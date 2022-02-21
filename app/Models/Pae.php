<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Seance;

class Pae extends Model
{
    use HasCompositePrimaryKey;
    protected $table = 'pae';
    protected $primaryKey = ['studentId', 'courseId'];
    public $incrementing = false;
    public $timestamps = false;

    use HasFactory;

    /**
     * Method deleting a student from a course.
     */
    public static function deleteStudentInCourse($studentId, $courseId)
    {
        Pae::where('studentId', $studentId)->where('courseId', $courseId)
            ->delete();
    }

    /**
     * Method adding a student on a course.
     */
    public static function addStudentInCourse($studentId, $courseId)
    {
        $pae = new Pae;
        $pae->studentId = $studentId;
        $pae->courseId = $courseId;
        $pae->save();
    }

    public static function addStudentToCourses($matricules,$groupes)
    {
        for ($i = 0; $i < sizeof($groupes); $i++) {
            $courses = Seance::getCoursesByGroup($groupes[$i]);
            foreach($courses as $course){
                $paeOccurence = Pae::where([
                    ['courseId', $course->courseId],
                    ['studentId', $matricules[$i]],
                ])->get()->first();
                if($paeOccurence==null){
                    $pae = new Pae;
                    $pae->courseId = $course->courseId;
                    $pae->studentId = $matricules[$i];
                    $pae->save();
                }
            }
        }
    }

    public function student(){
        return $this->hasMany(Student::class,'studentId');
    }
}
