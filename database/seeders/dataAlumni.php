<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class dataAlumni extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('data_alumni')->insert([
    [
        'programs_id'   => 2,
        'NIM'           => '2341760077',
        'nama'          => 'Fasya Dita',
        'tanggal_lulus' => '2024-07-15',
        'created_at'    => now(),
        'updated_at'    => now()
    ],
    [
        'programs_id'   => 1,
        'NIM'           => '2341760098',
        'nama'          => 'Bagus Wiratama',
        'tanggal_lulus' => '2024-09-15',
        'created_at'    => now(),
        'updated_at'    => now()
    ],
    [
        'programs_id'   => 3,
        'NIM'           => '2341289821',
        'nama'          => 'Nur Aisyah',
        'tanggal_lulus' => '2023-08-01',
        'created_at'    => now(),
        'updated_at'    => now()
    ],
    [
        'programs_id'   => 1,
        'NIM'           => '2341763245',
        'nama'          => 'Rizky Saputra',
        'tanggal_lulus' => '2022-06-25',
        'created_at'    => now(),
        'updated_at'    => now()
    ],
    [
        'programs_id'   => 2,
        'NIM'           => '2346784453',
        'nama'          => 'Dewi Maharani',
        'tanggal_lulus' => '2024-01-10',
        'created_at'    => now(),
        'updated_at'    => now()
    ],
]);

    }
}
