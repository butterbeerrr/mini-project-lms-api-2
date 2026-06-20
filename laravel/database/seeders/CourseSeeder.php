<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\User;
use App\Models\CourseCategory;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $instructorId = User::where('role', 'instructor')->first()->id;
        $categoryId = CourseCategory::first()->id;

        $courses = [
            [
                'instructor_id' => $instructorId,
                'category_id' => $categoryId,
                'title' => 'Kuasai Laravel 10 dalam 30 Hari',
                'description' => 'Belajar backend development menggunakan framework Laravel dari dasar sampai mahir.',
                'rating' => 9.2,
                'thumbnail' => 'laravel-basic.jpg',
                'level' => 'beginner',
                'duration' => 600,
                'status' => 'published',
                'enrolled_count' => 120
            ],
            [
                'instructor_id' => $instructorId,
                'category_id' => $categoryId,
                'title' => 'Membangun REST API dengan React dan Laravel',
                'description' => 'Kelas lanjutan pembuatan fullstack aplikasi menggunakan API.',
                'rating' => 8.7,
                'thumbnail' => 'laravel-react.jpg',
                'level' => 'intermediate',
                'duration' => 1200,
                'status' => 'published',
                'enrolled_count' => 85
            ]
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
