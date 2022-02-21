<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = ['Projet', 'Systeme', 'Organisation des entreprises'];
        foreach($courses as $course){
            DB::table('course')->insert([
                'title' => $course,
            ]);
        }
    }
}
