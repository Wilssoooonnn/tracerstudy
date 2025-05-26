<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\category;

class categorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       category::insert([
    [
        'id' => '1',
        'category' => 'Bidang Infokom',
        'name' => 'Bidang Informasi dan Komunikasi'
    ],
    [
        'id' => '2',
        'category' => 'Bidang Non Infokom',
        'name' => 'Bidang Non Informasi dan Komunikasi'
    ],
    [
        'id' => '3',
        'category' => 'Belum Bekerja',
        'name' => 'Belum Bekerja'
    ]
]);

    }
}
