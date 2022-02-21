<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Csv;
use App\Models\Ics;
use ICal\ICal;

class AddFilesCtrl extends Controller
{

    public function index()
    {
        return view("addFiles");
    }

    public function addCSV()
    {
        $array = array();
        for ($i = 0; $i < count($_FILES['csv']['tmp_name']); $i++) {
            array_push($array,  $_FILES['csv']['tmp_name'][$i]);
        }
        foreach ($array as $group) {
            Csv::addInfo($group);
        }
        return view("home");
    }

    function addICS()
    {
        $array = array();
        for ($i = 0; $i < count($_FILES['ics']['tmp_name']); $i++) {
            array_push($array, new ICal($_FILES['ics']['tmp_name'][$i]));
        }
        foreach ($array as $group) {
            Ics::addInfo($group);
        }
        return view("home");
    }
}
