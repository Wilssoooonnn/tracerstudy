<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class profesiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $data = [
            // category_id = 1
            ['category_id' => 1, 'profesi' => 'Developer/Programmer/Software Engineer', 'created_at' => NOW()],
            ['category_id' => 1, 'profesi' => 'IT Support/IT Administrator', 'created_at' => NOW()],
            ['category_id' => 1, 'profesi' => 'Infrastructure Engineer', 'created_at' => NOW()],
            ['category_id' => 1, 'profesi' => 'Digital Marketing Specialist', 'created_at' => NOW()],
            ['category_id' => 1, 'profesi' => 'Graphic Designer/Multimedia Designer', 'created_at' => NOW()],
            ['category_id' => 1, 'profesi' => 'Business Analyst', 'created_at' => NOW()],
            ['category_id' => 1, 'profesi' => 'QA Engineer/Tester', 'created_at' => NOW()],
            ['category_id' => 1, 'profesi' => 'IT Enterpreneur', 'created_at' => NOW()],
            ['category_id' => 1, 'profesi' => 'Trainer/Guru/Dosen (IT)', 'created_at' => NOW()],
            ['category_id' => 1, 'profesi' => 'Mahasiswa', 'created_at' => NOW()],

            // Supplier 2
            ['category_id' => 2, 'profesi' => 'Wirausahawan (Non IT)', 'created_at' => NOW()],
            ['category_id' => 2, 'profesi' => 'Trainer/Guru/Dosen (Non IT)', 'created_at' => NOW()],
            ['category_id' => 2, 'profesi' => 'Mahasiswa (Non IT)', 'created_at' => NOW()],
        ];

        DB::table('profesi')->insert($data);
    }
}
