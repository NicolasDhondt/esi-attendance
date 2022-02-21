<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $faker = Faker\Factory::create();
        foreach($students as $studentId){
            DB::table('student')->insert([
                'studentId' => $studentId,
                'firstName' => $faker->firstName(),
                'lastName' => $faker->lastName(),
            ]);
        }
    }
}
