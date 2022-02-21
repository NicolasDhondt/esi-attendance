<?php

namespace Tests\Unit;

use App\Models\Pae;
use App\Models\Student;
use App\Models\Course;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabaseState;

class PaeTest extends TestCase
{
    use DatabaseMigrations;

    function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    public function test_deleteStudentAtCourse()
    {
        $student = new Student;
        $student->studentId = 12345;
        $student->firstName = 'TestFN';
        $student->lastName = 'TestLN';
        $student->save();

        $course = new Course;
        $course->id = 1;
        $course->title = 'TestCourse';
        $course->save();

        $pae = new Pae;
        $pae->studentId = 12345;
        $pae->courseId = 1;
        $pae->save();

        $paes = Pae::all();
        foreach ($paes as $pae) {
            Pae::deleteStudentInCourse($pae->studentId, $pae->courseId);
        }
        $this::assertTrue(Pae::all()->count() == 0);
    }

    public function test_addStudentAtCourse()
    {
        $student = new Student;
        $student->studentId = 12345;
        $student->firstName = 'TestFN';
        $student->lastName = 'TestLN';
        $student->save();

        $course = new Course;
        $course->id = 1;
        $course->title = 'TestCourse';
        $course->save();

        Pae::addStudentInCourse($student->studentId, $course->id);
        $this::assertNotNull(
            Pae::where('studentId', $student->studentId)
                ->where('courseId', $course->id)
                ->first()
        );
    }
}
