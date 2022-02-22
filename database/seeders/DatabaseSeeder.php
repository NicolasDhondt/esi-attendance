<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            StudentSeeder::class, GroupSeeder::class, Liaison_student_groupSeeder::class, TeacherSeeder::class,
            CourseSeeder::class, PaeSeeder::class, SeanceSeeder::class
        ]);
    }
}
