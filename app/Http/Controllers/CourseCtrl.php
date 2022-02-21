<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Pae;
use Illuminate\Http\Request;

class CourseCtrl extends Controller
{

    /**
     * Method returning the view course.
     */
    public function getAllCourseStudent()
    {
        $courses = Course::getAll();
        return view("/course", compact("courses"));
    }

    /**
     * Method deleting the student of a course.
     */
    public function deleteStudentInACourse()
    {
        $courseId = $_POST['courseId'];
        Pae::deleteStudentInCourse($_POST['studentId'], $courseId);
        return redirect('studentsByCourse/' . $courseId)->with('success', 'Student has been deleted');
    }

    /**
     * Method adding a student in a course.
     */
    public function addStudentInACourse()
    {
        $courseId = $_POST['courseId'];
        if (Student::find($_POST['studentId'])) {
            Pae::addStudentInCourse($_POST['studentId'], $courseId);
        }
        return redirect('studentsByCourse/' . $courseId)->with('success', 'Student has been added');
    }
}
