<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Division;
use App\Http\Requests\StoreEmployee;
use App\Http\Requests\UpdateEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class EmployeeController extends Controller
{
    /**
     * Get all employees with optional filters for name and division.
     */
    public function index(Request $request): JsonResponse
    {
        $name = $request->input('name');
        $division = $request->input('division');

        $employees = Employee::with('division')
            ->when($name, function ($query, $name) {
                return $query->where('name', 'like', "%{$name}%");
            })
            ->when($division, function ($query, $division) {
                return $query->whereHas('division', function ($query) use ($division) {
                    return $query->where('name', 'like', "%{$division}%");
                });
            })
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'Data karyawan berhasil diambil',
            'data' => [
                'employees' => $employees->items(),
            ],
            'pagination' => [
                'current_page' => $employees->currentPage(),
                'per_page' => $employees->perPage(),
                'total' => $employees->total(),
                'last_page' => $employees->lastPage(),
            ],
        ]);
    }

    public function store(StoreEmployee $request)
    {
        $validatedData = $request->validated();
        $imagePath = null;


        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('employees');

        }

        $division = Division::findOrFail($request->division);

        $employee = Employee::create([
            'id' => Str::uuid(),
            'name' => $request->name,
            'phone' => $request->phone,
            'division_id' => $division->id,
            'position' => $request->position,
            'image' => $imagePath,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data karyawan berhasil dibuat',
            'data' => $employee,
        ], 201);
    }

    public function update(UpdateEmployee $request, $uuid)
        {

            $validatedData = $request->validated();

            $employee = Employee::where('id', $uuid)->first();

            if (!$employee) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Karyawan tidak ditemukan',
                ], 404);
            }

            $imagePath = $employee->image;
            if ($request->hasFile('image')) {
                if ($employee->image && file_exists(storage_path('app/public/' . $employee->image))) {
                    unlink(storage_path('app/public/' . $employee->image));
                }
                $imagePath = $request->file('image')->store('employees');
            }

            $division = Division::find($request->division);

            if (!$division) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Divisi tidak ditemukan',
                ], 404);
            }

            $employee->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'division_id' => $division->id,
                'position' => $request->position,
                'image' => $imagePath,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data karyawan berhasil diperbarui',
            ], 200);
        }


        public function destroy($uuid)
    {
        $employee = Employee::where('id', $uuid)->first();

        if (!$employee) {
            return response()->json([
                'status' => 'error',
                'message' => 'Karyawan tidak ditemukan',
            ], 404);
        }




        if ($employee->image && file_exists(storage_path('app/public/' . $employee->image))) {
            unlink(storage_path('app/public/' . $employee->image));
        }

        $employee->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data karyawan berhasil dihapus',
        ], 200);
    }
}
