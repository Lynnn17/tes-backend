<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DivisionController extends Controller
{
    /**
     * Get all divisions with optional name filter.
     */
    public function index(Request $request): JsonResponse
    {
        // Ambil parameter 'name' dari query string
        $name = $request->input('name');

        // Query untuk mengambil data divisi, dengan filter berdasarkan nama jika ada
        $divisions = Division::when($name, function ($query, $name) {
            return $query->where('name', 'like', "%{$name}%");
        })
        ->paginate(10); // Gunakan pagination untuk hasil yang lebih besar

        // Kembalikan response dalam format JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Data divisi berhasil diambil',
            'data' => [
                'divisions' => $divisions->items(),
            ],
            'pagination' => [
                'current_page' => $divisions->currentPage(),
                'per_page' => $divisions->perPage(),
                'total' => $divisions->total(),
                'last_page' => $divisions->lastPage(),
            ],
        ]);
    }
}
