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
            'phone_number' => '081234567890',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create Cleaning Staff Users
        User::create([
            'name' => 'Budi Santoso',
            'employee_code' => 'SBY09876',
            'email' => null,
            'phone_number' => '08153209513',
            'password' => Hash::make('budi123'), // No password initially
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Sari Dewi',
            'employee_code' => 'SBY09877',
            'email' => null,
            'phone_number' => '083456789012',
            'password' => Hash::make('sari123'), // Has password
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Ahmad Rizki',
            'employee_code' => 'SBY09878',
            'email' => null,
            'phone_number' => '084567890123',
            'password' => null,
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Indah Permata',
            'employee_code' => 'SBY09879',
            'email' => null,
            'phone_number' => '085678901234',
            'password' => Hash::make('indah123'), // Has password
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Joko Susilo',
            'employee_code' => 'SBY09880',
            'email' => null,
            'phone_number' => null, // No phone number for testing error case
            'password' => null,
            'role' => 'user',
        ]);
    }
}
