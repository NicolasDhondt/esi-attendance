<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use LiaisonStudentGroup;
use Illuminate\Support\Facades\Log;
use Faker;

class Student extends Model
{
    protected $table = 'student';
    protected $primaryKey = 'studentId';
    public $incrementing = false;
    public $timestamps = false;
    use HasFactory;

    /**
     * Get all the students in the table Students.
     */

    public static function getAll()
    {
        $all = Student::join('liaison_student_group', 'liaison_student_group.studentId', '=', 'student.studentId')
            ->join('group', 'group.id', '=', 'liaison_student_group.id')
            ->orderBy('student.studentId', 'asc')
            ->get(['student.studentId', 'student.firstName', 'student.lastName', 'group.acronym']);
        return $all;
    }

    /**
     * Method getting the course by its id.
     */
    public static function getByCourse($courseId)
    {
        $studentsAtCourse = Student::join('pae', 'pae.studentId', '=', 'student.studentId')
            ->join('course', 'course.id', '=', 'pae.courseId')
            ->join('liaison_student_group', 'liaison_student_group.studentId', '=', 'student.studentId')
            ->join('group', 'liaison_student_group.id', '=', 'group.id')
            ->where('course.id', '=', $courseId)
            ->orderBy('student.studentId', 'asc')
            ->get(['student.studentId', 'student.firstName', 'student.lastName', 'group.acronym']);
        return $studentsAtCourse->unique();
    }

    /**
     * Method getting students by group.
     */
    public static function getByGroup($group)
    {
        $all = Student::join('liaison_student_group', 'liaison_student_group.studentId', 'student.studentId')
            ->join('group', 'group.id', '=', 'liaison_student_group.id')
            ->where('group.acronym', $group)
            ->orderBy('student.studentId', 'asc')
            ->get();
        return $all->unique();
    }


    /**
     * Method getting students by seance.
     */
    public static function getBySeance($id)
    {
        $studentsAtSceance = Student::join('pae', 'pae.studentId', '=', 'student.studentId')
            ->join('seance', 'seance.courseId', '=', 'pae.courseId')
            ->join('group', 'group.id', '=', 'seance.groupId')
            ->leftjoin('attendance', function ($join) use ($id) {
                $join->on('attendance.studentId', '=', 'student.studentId')
                    ->where('attendance.seanceId', $id);
            })
            ->where('seance.id', '=', $id)
            ->orderBy('student.studentId', 'asc')
            ->get(['seance.id as seanceId', 'student.studentId', 'student.firstName', 'student.lastName', 'group.acronym', 'attendance.present']);
        return $studentsAtSceance->unique();
    }

    /**
     * Equal of the list of students.
     */
    public static function equalsListOfStudents($createdStudents, $fromDbStudents)
    {
        if (count($createdStudents) == count($fromDbStudents)) {
            for ($i = 0; $i < count($createdStudents); $i++) {
                if (!Student::equals($createdStudents[$i], $fromDbStudents[$i])) {
                    return false;
                }
            }
        } else {
            return false;
        }
        return true;
    }

    public static function equals($studentOne, $studentTwo)
    {
        return $studentOne->matricule == $studentTwo->matricule
            && $studentOne->firstName == $studentTwo->firstName
            && $studentOne->lastName == $studentTwo->lastName;
    }

    /**
     * Method getting the student pae.
     */
    public static function getStudentPae($studentId)
    {
        $student = Student::join('pae', 'student.studentId', '=', 'pae.studentId')
            ->join('course', 'pae.courseId', '=', 'course.id')
            ->where('student.studentId', $studentId)->get();
        return $student;
    }
    // Add a student to the database with a real matricule if it doesn't already exist, the other values are generated.
    public static function addStudent($matricules)
    {
        $faker = Faker\Factory::create();
        foreach ($matricules as $elem) {
            $studentExist = Student::where('studentId', $elem)->get('student.studentId')->first();
            if ($studentExist === null) {
                $student = new Student();
                $student->studentId = $elem;
                $student->firstName = $faker->firstName();
                $student->lastName = $faker->lastName();
                $student->save();
            }
        }
    }

    /**
     * Many to many link to pae.
     */
    public function pae()
    {
        return $this->belongsTo(Pae::class, 'studentId');
    }

    /**
     * Many to many link to groups.
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'liaison_student_group', 'studentId', 'id');
    }
}
