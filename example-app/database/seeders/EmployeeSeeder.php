<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Division;
use Illuminate\Support\Str;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil divisi yang sudah ada
        $divisions = Division::all();


        // Data dummy karyawan
        $employees = [
            ['name' => 'John Doe',  'phone' => '1234567890', 'position' => 'manager'],
            ['name' => 'Jane Doe', 'phone' => '0987654321', 'position' => 'staff'],
            ['name' => 'Michael Johnson', 'phone' => '1122334455', 'position' => 'staff'],

        ];

        foreach ($employees as $employee) {
            Employee::create([
                'id' => Str::uuid(),
                'name' => $employee['name'],
                'phone' => $employee['phone'],
                'position' => $employee['position'],
                'division_id' => $divisions->random()->id, // Assign divisi secara acak
            ]);
        }
    }
}
