<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker;

class PaeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $courses = [1, 2, 3];
        $faker = Faker\Factory::create();
        foreach($students as $studentId){
            foreach($courses as $course){
                DB::table('pae')->insert([
                    'studentId' => $studentId,
                    'courseId' => $course,
                ]);
            }
        }
    }
}
