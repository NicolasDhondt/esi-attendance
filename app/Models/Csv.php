<?php

namespace App\Models;

use App\Models\Student;
use App\Models\Group;
use App\Models\Liaison_student_group;
use App\Models\Pae;

class Csv
{
    // Open the csv file and parse the data into 2 arrays to be able to call methods to fill the database.
    public static function addInfo($file)
    {
        $matricules = array();
        $groupes =  array();
        $i = 0;
        if(($handle = fopen($file, 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if($i!=0){
                    array_push($matricules, $data[0]);
                    array_push($groupes, $data[1]);
                }
                $i++;
            }
            fclose($handle);
        }
        
        Student::addStudent($matricules);
        Group::addGroup($groupes);
        Pae::addStudentToCourses($matricules,$groupes);
        Liaison_student_group::addLiaison($matricules, $groupes);
    }
}