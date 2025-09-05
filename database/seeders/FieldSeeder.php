<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $fields = [
            'Software Development',
            'Web Development',
            'Mobile App Development',
            'Database Administration',
            'Network Administration',
            'Information Security',
            'System Administration',
            'IT Project Management',
            'Data Analysis',
            'Cloud Computing',
            'Artificial Intelligence',
            'Machine Learning',
            'DevOps',
            'IT Consulting',
            'IT Support'
        ];

        foreach ($fields as $field) {
            Field::create(['name' => $field]);
        }
    }
}
