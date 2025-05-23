<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin; // Use the Admin model

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a default admin user
        Admin::create([
            'username' => 'admin',  // Set a default username
            'password' => Hash::make('password123'),  // Ensure password is hashed
            'role' => 'admin',  // Role of the user (admin)
            'first_name' => 'Admin',  // First name of the admin
            'last_name' => 'User',  // Last name of the admin
            'email' => 'admin@example.com',  // Email of the admin
            'phone_number' => '1234567890',  // Phone number of the admin
        ]);
    }
}
