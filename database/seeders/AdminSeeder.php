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
            'name' => 'Adam Admin',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
