<?php
// database/seeders/PertanyaanSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PertanyaanModel;

class PertanyaanSeeder extends Seeder
{
    public function run()
    {
        // Add questions here
        PertanyaanModel::create([
            'pertanyaan' => 'How satisfied are you with the quality of education provided by our institution?',
            'question_type' => 'scale',
        ]);

        PertanyaanModel::create([
            'pertanyaan' => 'How would you rate the teamwork skills of our alumni?',
            'question_type' => 'scale',
        ]);

        PertanyaanModel::create([
            'pertanyaan' => 'What are the key areas that alumni could improve upon?',
            'question_type' => 'text',
        ]);

        PertanyaanModel::create([
            'pertanyaan' => 'How do you assess the communication skills of our alumni in the workplace?',
            'question_type' => 'scale',
        ]);

        PertanyaanModel::create([
            'pertanyaan' => 'Please provide any suggestions for improving the curriculum of the program.',
            'question_type' => 'text',
        ]);
    }
}
