<?php

namespace App\Models;

use App\Models\Prof;
use App\Models\Seance;
use App\Models\Course;
use App\Models\Group;

use ICal\ICal;

class Ics
{
    // Open the ics file and parse the data into multiple arrays to be able to call methods to fill the database.
    public static function addInfo($array)
    {
        $course = array();
        $group = array();
        $profLastname = array();
        $profFirstname = array();
        $profAcr = array();
        $local = array();
        $date = array();
        foreach ($array->events() as $event) {
            $val = explode("\n", $event->description);
            // Ajouter dans une variable tout les cours
            $mat = substr($val[0], 10);
            $mat = htmlspecialchars_decode($mat);
            array_push($course, $mat);
            // Ajouter dans une variable tout les groupes
            $grp = substr($val[2], 5);
            
            $tokgrp = strtok($grp,", ");
            while($tokgrp != false){
                if($tokgrp === 's' || $tokgrp === ':'){
                    array_push($group, "/");
                } else {
                    array_push($group, $tokgrp);
                }
                $tokgrp = strtok(", ");
            }
            
            // Ajouter dans une variable tout les profs
            $totaliteprof = substr($val[1], 12);
            $tokens = $totaliteprof;
            $i = 0;
            $nomProf = "";
            $prenomProf = "";
            $acrProf = "";
            $tok = strtok($tokens, " -");
            while ($tok != false) {
                if ($i == 0) {
                    $acrProf = $tok;
                } else {
                    if (ctype_upper($tok)) {
                        if ($nomProf == '') {
                            $nomProf = $tok;
                        } else {
                            $nomProf = $nomProf . " " . $tok;
                        }
                    } else {
                        if ($prenomProf == '') {
                            $prenomProf = $tok;
                        } else {
                            $prenomProf = $prenomProf . " " . $tok;
                        }
                    }
                }
                $tok = strtok(" -");
                $i++;
            }

            array_push($profAcr, $acrProf);
            array_push($profLastname, $nomProf);
            array_push($profFirstname, $prenomProf);

            if(sizeof($val) < 4){
                $salle = "undetermined";
            } else{
                $salle = substr($val[3], 8);
            }
            array_push($local, $salle);
            $cal = new ICal();
            $time = $cal->iCalDateToDateTime($event->dtstart_array[3])->format('Y-m-d H:i:s');
            array_push($date, $time);
        }
        Course::addCourse($course);
        Group::addGroup($group);
        Teacher::addTeacher($profLastname, $profFirstname, $profAcr);
        Seance::addSeance($course, $profAcr, $group, $date, $local);
    }
}
