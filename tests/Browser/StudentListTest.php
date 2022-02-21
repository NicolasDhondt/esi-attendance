<?php

namespace Tests\Browser;

use App\Models\Student;
use App\Models\Seance;
use App\Models\Liaison_student_group;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Facebook\WebDriver\WebDriverBy;
use phpDocumentor\Reflection\PseudoTypes\True_;

class StudentListTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->artisan('db:seed StudentSeeder');
        $this->artisan('db:seed GroupSeeder');
        $this->artisan('db:seed Liaison_student_groupSeeder');
        $this->artisan('db:seed TeacherSeeder');
        $this->artisan('db:seed CourseSeeder');
        $this->artisan('db:seed SeanceSeeder');
        $this->artisan('db:seed paeSeeder');
    }

    /**
     * A test of the list of student
     */
    public function testDisplayStudent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/students');
            $browser->screenshot('filename');
            $studentsMatricules = $browser->driver->findElements(WebDriverBy::className('studentMat'));
            $sorted = true;
            for ($i = 0; $i < count($studentsMatricules) - 1 && $sorted; $i++) {
                if ($studentsMatricules[$i + 1]->getAttribute("title") < $studentsMatricules[$i]->getAttribute("title")) {
                    $sorted = false;
                }
            }
            $this->assertTrue($sorted);
            $this->assertTrue(count($studentsMatricules) > 0);
        });
    }
    /**
     * A test of the list of student sorted by group
     */
    public function testDisplayStudentBySeance()
    {
        $this->browse(function (Browser $browser) {
            $seanceUrl = Seance::seancesForCalendar(Seance::getAll())[0][4];
            $browser->visit($seanceUrl);
            $studentsMatricules = $browser->driver->findElements(WebDriverBy::className('studentMat'));
            $sorted = true;
            for ($i = 0; $i < count($studentsMatricules) - 1 && $sorted; $i++) {
                if ($studentsMatricules[$i + 1]->getAttribute("title") < $studentsMatricules[$i]->getAttribute("title")) {
                    $sorted = false;
                }
            }
            $this->assertTrue($sorted);
        });
    }
    public function test_see_student_by_course()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/courses')
                ->assertSee('N° cours')
                ->click("@trCourse");
            $studentsMatricules = $browser->driver->findElements(WebDriverBy::className('studentMat'));
            $sorted = true;
            for ($i = 0; $i < count($studentsMatricules) - 1 && $sorted; $i++) {
                if ($studentsMatricules[$i + 1]->getAttribute("title") < $studentsMatricules[$i]->getAttribute("title")) {
                    $sorted = false;
                }
            }
            $this->assertTrue($sorted);
        });
    }

    public function test_delete_student()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/courses')
                ->assertSee('N° cours')
                ->click("@trCourse")
                ->assertSee('Etudiants du cours')
                ->screenshot("aa1");
            $studentsIds = $browser->driver->findElements(WebDriverBy::className('studentMat'));
            $browser->click("@deleteStudent-button")
                ;

            $browser->screenshot("aa5")->type('@inputRemoveStudent',  $studentsIds[0]->getAttribute('value'))
                ->screenshot("aa4")
                ->click("@delete-button")
                ->screenshot("aa3")
                ->assertSee('Etudiants du cours');
            $newStudentsIds = $browser->driver->findElements(WebDriverBy::className('studentMat'));
            $this->assertEquals(count($studentsIds) - 1, count($newStudentsIds));
        });
    }

    public function test_add_student()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/courses')
                ->assertSee('N° cours')
                ->click("@trCourse")
                ->assertSee('Etudiants du cours')
                ->screenshot("aa1");
            $studentsIds = $browser->driver->findElements(WebDriverBy::className('studentMat'));
            $browser->click("@deleteStudent-button");
            $studentId = $studentsIds[0]->getAttribute('value');
            $browser
                ->type('@inputRemoveStudent',  $studentId)
                ->click("@delete-button")
                ->screenshot("aa3")
                ->assertSee('Etudiants du cours');
            $studentsBeforeAdd = $browser->driver->findElements(WebDriverBy::className('studentMat'));
            $browser
                ->click("@addStudent-button")
                ->assertSee("Le matricule de l'étudiant")
                ->type('@inputAddStudent', $studentId)
                ->click("@add-button");

            $studentsAfterAdd = $browser->driver->findElements(WebDriverBy::className('studentMat'));

            $this->assertEquals(count($studentsBeforeAdd) + 1, count($studentsAfterAdd));
        });
    }
}
