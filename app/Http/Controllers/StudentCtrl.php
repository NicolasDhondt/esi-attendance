<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Http\Request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Models\Pae;
use Illuminate\Support\Facades\Log;

class StudentCtrl extends Controller
{

    /**
     * Method return the view students .
     */
    public function index()
    {
        $students = Student::getAll();
        return view("/students", compact("students"));
    }
    /**
     * Method returning the view students of a course.
     */
    public function getByCourse($courseId)
    {
        $students = Student::getByCourse($courseId);
        $courseTitle = Course::getCourseTitle($courseId);
        return view("/students", compact("students", "courseTitle", "courseId"));
    }

    /**
     * Method returning the view students of a group.
     */
    public function getByGroup(Request $request)
    {
        $students = Student::getByGroup($request->group);
        return view("students", compact("students"));
    }


    /**
     * Method returning the view students of a seance.
     */
    public function getStudentsBySeance($id, $courseId, $teacherId)
    {
        $students = Student::getBySeance($id);
        $teacherName = Teacher::getTeacherName($teacherId);
        $courseTitle = Course::getCourseTitle($courseId);
        $seanceId = $id;
        return view("/students", compact("students", "courseTitle", "teacherName", "seanceId"));
    }
    /**
     * Method returning true if a student is sign in a given seance.
     */
    public static function isStudentInSeance($matricule, $idSeance){
        $students = Student::getBySeance($idSeance);
        foreach($students as $student){
            if($student->studentId==$matricule){
                return true;
            }
        }
            return false;

        }

}
