<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker;

class SeanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = ['C112', 'E11', 'E12', 'C121'];
        $faker = Faker\Factory::create();
        $index = 0;
        $teacher=0;
        $id=1;
        for($courseId=1;$courseId<4;$courseId++){
            for($teacherId=1;$teacherId<=random_int(1,2);$teacherId++){
                DB::table('seance')->insert([
                    'courseId' => $courseId,
                    'teacherId' => ++$teacher,
                    'local' => $teacherId,
                    'groupId' => $index+1,
                    'dateTime' => $faker->dateTimeBetween('+0 days', '+2 years'),
                ]);
                $index=($index+1)%count($groups);
                $teacher = ($teacher+1)%4;
            }
        }

    }
}
