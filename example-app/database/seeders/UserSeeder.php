<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Membuat data dummy untuk User
        $users = [
            [
                'name' => 'Admin User',
                'username' => 'adminuser',
                'email' => 'admin@example.com',
                'phone' => '081234567890',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'John Doe',
                'username' => 'johndoe',
                'email' => 'john.doe@example.com',
                'phone' => '081234567891',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Jane Smith',
                'username' => 'janesmith',
                'email' => 'jane.smith@example.com',
                'phone' => '081234567892',
                'password' => Hash::make('password123'),
            ]
        ];

        foreach ($users as $user) {
            User::create([
                'id' => Str::uuid(),  // Menambahkan UUID
                'name' => $user['name'],
                'username' => $user['username'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'password' => $user['password'],
            ]);
        }
    }
}
