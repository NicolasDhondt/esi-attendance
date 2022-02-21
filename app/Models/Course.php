<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'course';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = true;

    use HasFactory;

    /**
     * Method returning all the courses.
     */
    public static function getAll()
    {
        $all = Course::all();
        return $all;
    }

    /**
     * Method returning a course title with its id.
     */
    public static function getCourseTitle($courseId)
    {
        $courseId = Course::where('id', $courseId)
            ->get('course.title')->first();
        return $courseId;
    }

    //Add a course to the database if it doesn't already exist.
    public static function addCourse($idList)
    {
        foreach ($idList as $title) {
            $titleExist = Course::where('title', $title)->get('course.title')->first();
            if ($titleExist === null) {
                $course = new Course();
                $course->title = $title;
                $course->save();
            }
        }
    }
}
