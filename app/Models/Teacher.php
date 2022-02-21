<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Facades\DB;

class Teacher extends Model
{
    protected $table = 'teacher';
    protected $primaryKey = 'id';
    public $timestamps = false;
    use HasFactory;

    /**
     * Method getting teacher name from id.
     */
    public static function getTeacherName($teacherId)
    {
        $teacherName = Teacher::where('id', $teacherId)
            ->get('teacher.last_name');
        return $teacherName;
    }
    //Add a teacher to the database if it doesn't already exist.
    public static function addTeacher($nomList, $prénomList, $idList)
    {
        for ($i = 0; $i < sizeof($nomList); $i++) {
            $teacherExist = Teacher::where('acronym', $idList[$i])->get('teacher.acronym')->first();
            if ($teacherExist === null) {
                $teacher = new Teacher();
                $teacher->acronym = $idList[$i];
                $teacher->last_name = $nomList[$i];
                $teacher->first_name = $prénomList[$i];
                $teacher->save();
            }
        }
    }

    /**
     * Method getting all the teachers.
     */
    public static function getAll(){
        $teachers = DB::select("SELECT * FROM teacher");
        return $teachers;
    }
}
