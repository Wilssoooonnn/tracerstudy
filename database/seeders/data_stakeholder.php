<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class data_stakeholder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('data_stakeholder')->insert([
            'nama'      => 'Sinta Kamelia',
            'instansi'  => 'PT. Otsuka',
            'jabatan'   => 'CEO',
            'email'     => 'sintakamelia@otsuka.com',
            'alumni_id' => 1, // pastikan ID 1 ada di tabel data_alumni
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
