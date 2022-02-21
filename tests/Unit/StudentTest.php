<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Models\Seance;
use Tests\TestCase;
use App\Models\Student;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StudentTest extends TestCase
{
    use DatabaseMigrations;

    function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->artisan('db:seed StudentSeeder');
        $this->artisan('db:seed GroupSeeder');
        $this->artisan('db:seed Liaison_student_groupSeeder');
        $this->artisan('db:seed teacherSeeder');
        $this->artisan('db:seed CourseSeeder');
        $this->artisan('db:seed PaeSeeder');
        $this->artisan('db:seed SeanceSeeder');
    }

    public function test_equals_when_true()
    {
        $studentOne = Student::factory()->make();
        $studentTwo = $studentOne;
        $this::assertTrue(Student::equals($studentOne, $studentTwo));
    }

    public function test_equals_when_false()
    {
        $studentOne = Student::factory()->make();
        $studentTwo = Student::factory()->make();
        $this::assertFalse(Student::equals($studentOne, $studentTwo));
    }

    public function test_equalsListOfStudents_when_true()
    {
        $studentsOne = Student::factory()->count(5)->make();
        $studentsTwo = $studentsOne;
        $this::assertTrue(Student::equalsListOfStudents($studentsOne, $studentsTwo));
    }

    public function test_equalsListOfStudents_when_bigger_list_false()
    {
        $studentsOne = Student::factory()->count(5)->make();
        $studentsTwo = Student::factory()->count(3)->make();
        $this::assertFalse(Student::equalsListOfStudents($studentsOne, $studentsTwo));
    }

    public function test_equalsListOfStudents_when_smaller_list_false()
    {
        $studentsOne = Student::factory()->count(3)->make();
        $studentsTwo = Student::factory()->count(6)->make();
        $this::assertFalse(Student::equalsListOfStudents($studentsOne, $studentsTwo));
    }

    public function test_when_getAll_true()
    {
        $students = Student::getAll();
        $this->assertTrue($students->count()>0);
    }

    public function test_when_getAll_severalStudents_false()
    {
        $students = Student::factory()->count(5)->create();
        $students = $students->sortBy('matricule')->values();
        $students = Student::factory()->count(5)->make();
        $fromDb = Student::getAll();
        $this::assertFalse(Student::equalsListOfStudents($students, $fromDb));
    }

    /**
     * test of the method getByGroup with a correct group name
     */
    public function test_getByGroup_exist(){
        $students = Student::getByGroup("E11");
        $sorted=true;
        for($i=0;$i<$students->count()-1 && $sorted;$i++){
            if((int)$students[$i+1]->studentId<(int)$students[$i]->studentId){
                $sorted = false;
            }
        }
        $this->assertTrue($students->count()>0);
        $this->assertTrue($sorted);
    }
    /**
     * test of the method getByGroup with a incorrect group name
     */
    public function test_getByGroup_exist_not(){
        $students = Student::getByGroup("dddsd");
        $this->assertTrue($students->isEmpty());
    }

    /**
     * test of the method getByGroup with a correct course ids
     */
    public function test_getByCourse_exist(){
        $students = Student::getByCourse(1);
        $this->assertTrue($students->count()>0);
    }
    /**
     * test of the method getByGroup with a incorrect course ids
     */
    public function test_getByCourse_exist_not(){
        $students = Student::getByGroup(999);
        $this->assertTrue($students->isEmpty());
    }

    /**
     * test of the method getBySeance with correct seance id
     */
    public function test_getBySeance_exist(){
        $students = Student::getBySeance(1);
        $this->assertTrue($students->count()>0);
    }
    /**
     * test of the method getBySeance with incorrect seance id
     */
    public function test_getBySeance_exist_not(){
        $students = Student::getBySeance(999);
        $this->assertTrue($students->isEmpty());
    }
}

