<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class pertanyaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    DB::table('pertanyaan')->insert([
        ['pertanyaan' => 'Kerjasama Tim'],
        ['pertanyaan' => 'Keahlian di Bidang TI'],
        ['pertanyaan' => 'Kemampuan Berbahasa Asing'],
        ['pertanyaan' => 'Kemampuan Berkomunikasi'],
        ['pertanyaan' => 'Pengembangan Diri'],
        ['pertanyaan' => 'Kepemimpinan'],
        ['pertanyaan' => 'Etos Kerja'],
    ]);

    }
}
