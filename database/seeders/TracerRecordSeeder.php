<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TracerRecordModel;
use Illuminate\Support\Facades\DB;
use App\Models\LulusanModel;
use Faker\Factory as Faker;

class TracerRecordSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $alumniList = DB::table('data_alumni')->pluck('id');
        $instansiTypes = DB::table('instansi')->pluck('id')->all();
        $scales = DB::table('skala')->pluck('id')->all();
        $categories = DB::table('category')->pluck('id')->all();
        $professions = DB::table('profesi')->pluck('id')->all();

        $data = [];

        foreach ($alumniList as $alumniId) {
            // Pastikan tanggal masuk kerja setelah lulus
            $firstJob = $faker->dateTimeBetween('-5 years', 'now');
            $currentStart = $faker->dateTimeBetween($firstJob, 'now');

            $data[] = [
                'alumni_id' => $alumniId,
                'first_job_date' => $firstJob->format('Y-m-d'),
                'current_instansi_start_date' => $currentStart->format('Y-m-d'),
                'instansi_type' => $faker->randomElement($instansiTypes),
                'instansi_name' => $faker->company,
                'instansi_scale' => $faker->randomElement($scales),
                'instansi_location' => $faker->city,
                'category_profession' => $faker->randomElement($categories),
                'profession_id' => $faker->randomElement($professions),
                'nama_atasan' => $faker->name,
                'jabatan' => $faker->jobTitle,
                'no_hp' => $faker->phoneNumber,
                'email' => $faker->companyEmail,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('tracer_record')->insert($data);
    }
}
