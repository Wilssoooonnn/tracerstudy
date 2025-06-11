<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ResponSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $stakeholders = DB::table('data_stakeholder')->pluck('id');
        $pertanyaans = DB::table('pertanyaan')->get();

        $data = [];

        foreach ($stakeholders as $stakeholderId) {
            foreach ($pertanyaans as $pertanyaan) {
                $responseText = $pertanyaan->question_type === 'scale'
                    ? (string) $faker->numberBetween(1, 5)
                    : $faker->sentence(rand(6, 12));

                $data[] = [
                    'pertanyaan_id' => $pertanyaan->id,
                    'stakeholder_id' => $stakeholderId,
                    'respon' => $responseText,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('respon')->insert($data);
    }
}
