<?php

namespace Database\Seeders;

use App\Models\GradeLevel;
use Illuminate\Database\Seeder;

class GradeLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = [
            ['grade' => 'A', 'min_days' => 26, 'max_days' => 31],
            ['grade' => 'B', 'min_days' => 20, 'max_days' => 25],
            ['grade' => 'C', 'min_days' => 15, 'max_days' => 19],
            ['grade' => 'D', 'min_days' => 10, 'max_days' => 14],
            ['grade' => 'F', 'min_days' => 0, 'max_days' => 9],
        ];

        foreach ($grades as $grade) {
            GradeLevel::create($grade);
        }
    }
}