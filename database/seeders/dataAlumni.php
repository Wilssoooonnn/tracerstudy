<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DataAlumni extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $data = [];

        for ($i = 0; $i < 20; $i++) {
            $data[] = [
                'programs_id' => 1, // pastikan program dengan ID 1 ada
                'NIM' => '234176' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'nama' => $faker->name,
                'nohp' => $faker->optional()->phoneNumber,
                'email' => $faker->optional()->safeEmail,
                'tanggal_lulus' => $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
                'token' => $faker->optional()->sha256,
                'token_expires_at' => $faker->optional()->dateTimeBetween('now', '+1 year'),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('data_alumni')->insert($data);
    }
}
