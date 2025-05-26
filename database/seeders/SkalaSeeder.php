<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SkalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('skala')->insert([
            ['skala_kode' => 'S1' , 'skala_nama' => 'International'],
            ['skala_kode' => 'S2' , 'skala_nama' => 'National'],
            ['skala_kode' => 'S3' , 'skala_nama' => 'Wirausaha'],
        ]);
    }
}
