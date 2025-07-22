<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'employee_code' => 'SBY00001',
            'email' => 'admin@sinergia.com',
            'password' => null,
            'role' => 'admin',
        ]);

        // Create Cleaning Staff Users
        User::create([
            'name' => 'Budi Santoso',
            'employee_code' => 'SBY09876',
            'email' => null,
            'password' => null,
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Sari Dewi',
            'employee_code' => 'SBY09877',
            'email' => null,
            'password' => null,
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Ahmad Rizki',
            'employee_code' => 'SBY09878',
            'email' => null,
            'password' => null,
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Indah Permata',
            'employee_code' => 'SBY09879',
            'email' => null,
            'password' => null,
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Joko Susilo',
            'employee_code' => 'SBY09880',
            'email' => null,
            'password' => null,
            'role' => 'user',
        ]);
    }
}
