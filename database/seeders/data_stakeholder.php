<?php

namespace Database\Seeders;

use App\Models\LulusanModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class data_stakeholder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $alumniList = LulusanModel::all();

        $data = [];

        foreach ($alumniList as $alumni) {
            $data[] = [
                'nama' => $faker->name,
                'instansi' => $faker->company,
                'jabatan' => $faker->jobTitle,
                'email' => $faker->companyEmail,
                'alumni_id' => $alumni->id,
                'token' => Str::uuid(),
                'is_used' => false,
                'token_expires_at' => $faker->optional()->dateTimeBetween('now', '+6 months'),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('data_stakeholder')->insert($data);
    }
}
