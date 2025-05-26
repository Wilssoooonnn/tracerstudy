<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class programsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('programs')->insert([
            ['program_studi' => 'D4 - Teknik Informatika' , 'Jurusan' => 'Teknologi Informasi'],
            ['program_studi' => 'D4 - Sistem Informasi Bisnis' , 'Jurusan' => 'Teknologi Informasi'],
            ['program_studi' => 'D2 - Pengembangan Piranti Lunak Situs' , 'Jurusan' => 'Teknologi Informasi'],
            ['program_studi' => 'S2 - Magister Rekayasa Teknologi Informasi' , 'Jurusan' => 'Teknologi Informasi'],
        ]);
    }
}
