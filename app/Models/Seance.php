<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Seance extends Model
{
    use HasCompositePrimaryKey;
    protected $table = 'seance';
    protected $primaryKey = 'id';
    protected $fillable = ['date', 'local'];
    public $incrementing = true;
    public $timestamps = false;
    use HasFactory;

    /**
     * Get all the seances in the table Seance.
     */
    public static function getAll()
    {
        $seances = Seance::join('teacher', 'teacher.id', '=', 'seance.teacherId')
            ->join('course', 'course.id', '=', 'seance.courseId')
            ->join('group', 'group.id', '=', 'seance.groupId')
            ->orderBy('dateTime', 'asc')
            ->get(['group.acronym as groupId', 'teacher.last_name', 'course.title as acronym', 'seance.dateTime', 'seance.courseId', 'seance.teacherId', 'seance.id']);
        return $seances;
    }

    /**
     * Method getting all the seances
     */
    public static function seancesForCalendar($seances)
    {
        $arraySeancesEvent = array();
        for ($i = 0; $i < count($seances); $i++) {
            $date = $seances[$i]->dateTime;
            $carbonDate = new Carbon($date);

            $start = $carbonDate->format("Y-m-d");
            $startTime = $carbonDate->timezone("Europe/Brussels")->format("H:i:s");
            $endTime = $carbonDate->timezone("Europe/Brussels")->addHours(2)->format("H:i:s");
            $title = $seances[$i]->acronym . " - " . $seances[$i]->groupId . " - " . $seances[$i]->last_name;
            $seanceId = $seances[$i]->id;
            $courseId = $seances[$i]->courseId;
            $teacherId = $seances[$i]->teacherId;
            $url = "/studentsBySeance/$seanceId/$courseId/$teacherId";
            $current_seance = [$title, $start, $startTime, $endTime, $url];
            $arraySeancesEvent[$i] = $current_seance;
        }
        return $arraySeancesEvent;
    }

    // Get all the seances that happens today
    public static function getAllToday()
    {
        $seances = Seance::join('teacher', 'teacher.id', '=', 'seance.teacherId')
            ->join('course', 'course.id', '=', 'seance.courseId')
            ->join('group', 'group.id', '=', 'seance.groupId')
            ->whereDate("dateTime", "=", date("Y-m-d"))
            ->get(['group.acronym as groupId', 'teacher.last_name', 'course.title as acronym', 'seance.dateTime', 'seance.courseId', 'seance.teacherId', 'seance.id']);
        return $seances;
    }

    // Get all seances from a specify teacher
    public static function getAllSortedByTeacher($teacher)
    {
        $seances = Seance::join('teacher', 'teacher.id', '=', 'seance.teacherId')
            ->join('course', 'course.id', '=', 'seance.courseId')
            ->join('group', 'group.id', '=', 'seance.groupId')
            ->where("teacher.last_name", "=", $teacher)
            ->get(['group.acronym as groupId', 'teacher.last_name', 'course.title as acronym', 'seance.dateTime', 'seance.courseId', 'seance.teacherId', 'seance.id']);
        return $seances;
    }

    //Get all seances of a specific teacher today
    public static function getAllTodaySortedByTeacher($teacher)
    {
        $seances = Seance::join('teacher', 'teacher.id', '=', 'seance.teacherId')
            ->join('course', 'course.id', '=', 'seance.courseId')
            ->join('group', 'group.id', '=', 'seance.groupId')
            ->where("teacher.last_name", "=", $teacher)
            ->whereDate("dateTime", "=", date("Y-m-d"))
            ->get(['group.acronym as groupId', 'teacher.last_name', 'course.title as acronym', 'seance.dateTime', 'seance.courseId', 'seance.teacherId', 'seance.id']);
        return $seances;
    }

    //Add a seance to the database if it doesn't already exist.
    public static function addSeance($courseId, $teacherId, $groupId, $date, $local)
    {
        for ($i = 0; $i < sizeof($courseId); $i++) {
            $teacher = Teacher::where('acronym', $teacherId[$i])->get()->first();
            $group = Group::where('acronym', $groupId[$i])->get()->first();
            $course = Course::where('title', $courseId[$i])->get()->first();
            $seanceOccurence = Seance::where([
                ['courseId', $course->id],
                ['teacherId', $teacher->id],
                ['local', $local[$i]],
                ['groupId', $group->id],
                ['dateTime', $date[$i]],
            ])->get()->first();

            if ($seanceOccurence === null) {
                $seance = new Seance();
                $seance->courseId = $course->id;
                $seance->teacherId = $teacher->id;
                $seance->groupId = $group->id;
                $seance->dateTime = $date[$i];
                $seance->local = $local[$i];
                $seance->save();
            }
        }
    }

    public static function getCoursesByGroup($groupe)
    {
        $group = Group::where('acronym', $groupe)->get()->first();
        $courses = Seance::where('groupId', $group->id)->distinct('seance.courseId')->get('seance.courseId');
        return $courses;
    }
}
