<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseCategory;

class CourseCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Web Development', 'description' => 'Belajar coding website modern', 'icon' => 'laptop-code'],
            ['name' => 'Graphic Design', 'description' => 'Belajar UI/UX dan desain grafis', 'icon' => 'palette'],
            ['name' => 'Digital Marketing', 'description' => 'Belajar seo dan iklan digital', 'icon' => 'advertisement'],
            ['name' => 'Data Science', 'description' => 'Belajar analisis data dan AI', 'icon' => 'brain'],
        ];

        foreach ($categories as $category) {
            CourseCategory::create($category);
        }
    }
}
