<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Liaison_student_groupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [1,2,3,4];
        $students = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $index = 1;
        for($j =0;$j<count($students);$j++){
            for($i =0;$i<random_int(1,2);$i++){
                DB::table('liaison_student_group')->insert([
                    'id'=> $groups[$index],
                    'studentId'=>$students[$j],
                ]);
                $index = ($index+1)%count($groups);
            }
        }

    }
}
