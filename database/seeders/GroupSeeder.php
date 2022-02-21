<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = ['C112', 'E11', 'E12', 'C121'];
            for($i =1;$i<=count($groups);$i++){
                DB::table('group')->insert([
                    'acronym'=>$groups[$i-1]
                ]);
            }
    }
}
