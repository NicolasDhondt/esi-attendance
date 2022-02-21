<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $acronym = ['TNI', 'PHA', 'JLC', 'EGR', 'DHA'];
        $index = 1;
        $faker = Faker\Factory::create();
        for($index; $index <= 5; $index++){
            DB::table('teacher')->insert([
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'acronym' => $acronym[$index-1],
            ]);
        }
    }
}
