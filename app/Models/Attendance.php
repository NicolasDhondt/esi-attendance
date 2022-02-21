<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = true;
    protected $guarded = array('*');
    use HasFactory;

    /**
     * 1dd student attendance for a specific seance.
     */
    public static function addAttendance($studentId,$seanceId)
    {
        try{
            $attendance = Attendance::getAttendance($studentId,$seanceId);
            if($attendance == null){
                $attendance = new Attendance;
                $attendance->seanceId = $seanceId;
                $attendance->studentId = $studentId;
                $attendance->present = '1';
                $attendance->save();
                return true;
            }
        }catch(Exception $e){
            return false;
        }

    }

    /**
     * Delete the attendance.
    */
    public static function deleteAttendance($attendance){
        $attendance->delete();
    }

    /**
     * Get the attendance of a student in a specific seance.
     */
    public static function getAttendance($studentId,$seanceId)
    {
        $attendance = Attendance::where('studentId',$studentId)
        ->where('seanceId',$seanceId)->first();
        return $attendance;
    }

    /**
     * Get all the attendance of a specific seance.
     */
    public static function getAllAttendance($seanceId)
    {
        $attendances = Attendance::where('seanceId',$seanceId)->get();
        return $attendances;
    }

    /**
     * Add all the attendance of a seance.
     */
    public static function addAllAttendance($students,$seanceId){
        foreach($students as $student){
            Attendance::addAttendance($student->studentId,$seanceId);
        }
    }

    /**
     * Remove all the attendance of a seance.
     */
    public static function removeAllAttendance($attendances){
        foreach($attendances as $attendance){
            Attendance::deleteAttendance($attendance);
        }
    }



}
