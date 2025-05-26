<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class instansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('instansi')->insert([
            ['instansi_kode' => 'PT' , 'instansi_nama' => 'Pendidikan Tinggi'],
            ['instansi_kode' => 'IP' , 'instansi_nama' => 'Instansi Pemerintah'],
            ['instansi_kode' => 'PS' , 'instansi_nama' => 'Perusahaan Swasta'],
            ['instansi_kode' => 'BUMN' , 'instansi_nama' => 'BUMN'],
        ]);
    }
}
