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
                'programs_id' => 1,
                'NIM' => '2341760000',
                'nama' => 'Fasya',
                'tanggal_lulus' => '2024-07-15',
                'email' => 'fasyadita1@gmail.com',
                'token' => null,  // Set to null (not 'null')
                'token_expires_at' => null,  // Set to null (not 'null')
                'nohp' => null,  // Set to null (not 'null')
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

    }
}
