<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Seance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QrCodeCtrl extends Controller
{

    /**
     * Method returning the view qrCode of a seance.
     */
    public function getQrCodeBySeance(Request $request)
    {
        $urlLogin = "http://lit-atoll-02597.herokuapp.com/login/". $request->seanceId;
        return view("/qrcode", compact("urlLogin"));
    }

    /**
     * Method returning the view validation.
     */
    public function returnViewValidation(Request $request)
    {
        $isAuthenticated = $request->isAuthenticated;
        return view("/isAttended",compact('isAuthenticated'));
    }
}
