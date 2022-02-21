<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SeanceCtrl extends Controller
{

    /**
     * Method getting all the seance for the calendar.
     */
    public function getAllSeancesForCalendar($teacher)
    {
        $teachers = Teacher::getAll();

        if ($teacher == "all") {
            $seances = Seance::getAll();
        } else {
            $seances = Seance::getAllSortedByTeacher($teacher);
        }
        $seances = Seance::seancesForCalendar($seances);
        $informations = array(
            'teachers' => $teachers,
            'seances' => $seances
        );
        return $informations;
    }

    /**
     * Method returning the view seances .
     */
    public function index($teacher)
    {
        return view("/seances", compact('teacher'));
    }

}
