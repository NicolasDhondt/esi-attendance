<?php

namespace App\Http\Controllers;
use App\Models\Attendance;
use App\Models\Student;
use Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use function Psy\debug;

class AttendanceCtrl extends Controller
{

    /**
     * Update the attendance of a student by creating one.
     * if the attendance already exist delete it.
     */
    public function updateAttendance(Request $request){
        $attendance = Attendance::getAttendance($request->studentId,$request->seanceId);
        if($attendance ){
            Attendance::deleteAttendance($attendance);
        }else if(!$attendance){
            Attendance::addAttendance($request->studentId,$request->seanceId);
        }
        return true;
    }

    /**
     * Create a attendance for all the student of a seance.
     */
    public function updateAll(Request $request){
        Log::info("dans update all");
        $students = Student::getBySeance($request->seanceId);
        $attendances = Attendance::getAllAttendance($request->seanceId);
        if(count($students) == count($attendances)){
            Attendance::removeAllAttendance($attendances);
        }else{
            Attendance::addAllAttendance($students,$request->seanceId);
        }
        return back();
    }
    public static function makeStudentAttended($idStudent, $idSeance){
        $attendance = Attendance::getAttendance($idStudent,$idSeance);
        if(!$attendance || $attendance->present = false){
            Attendance::addAttendance($idStudent,$idSeance);
        }
    }

}
