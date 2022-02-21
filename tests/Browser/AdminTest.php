<?php

namespace Tests\Browser;

use App\Models\Group;
use App\Models\Liaison_student_group;
use App\Models\Student;
use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Facebook\WebDriver\WebDriverBy;
use LiaisonStudentGroup;

class AdminTest extends DuskTestCase
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
        $this->artisan('admin:install');
    }

    /**
     * a test of the admin home page
     *
     * @return void
     */
    public function testAdminHome()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin');
            try{
                $browser->assertDontSee("Login");
            }catch(Exception $e){
                $browser->type('username','admin')
                    ->type('password','admin');
                $browser->press('Login');
            }
            $browser->assertSee('ESI-Attendance - Admin');
        });
    }

    /**
     * A test of the page of the Students list.
     *
     * @return void
     */
    public function testStudents()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin');
            try{
                $browser->assertDontSee("Login");
            }catch(Exception $e){
                $browser->type('username','admin')
                    ->type('password','admin');
                $browser->press('Login');
            }
            $browser->visit('/admin/students');

            $browser->assertSee('Students');
            $studentsMatricules = $browser->driver->findElements(WebDriverBy::className('column-studentId'));
            $this->assertTrue(count($studentsMatricules)>0);
        });
    }
    /**
     * A test of the show option.
     *
     * @return void
     */
    public function testShowStudent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin');
            try{
                $browser->assertDontSee("Login");
            }catch(Exception $e){
                $browser->type('username','admin')
                    ->type('password','admin');
                $browser->press('Login');
            }
            $browser->visit('/admin/students')
                    ->assertSee('Students')
                    ->assertSee('Matricule')
                    ->assertSee('Prénom')
                    ->assertSee('Nom de famille');
            $link = "/admin/students/".Student::all()->first()->studentId;
            $browser->visit($link)
                    ->screenshot('tetetet')
                    ->assertSee('Matricule')
                    ->assertSee("Groups")
                    ->assertSee("Acronym");
        });
    }
    /**
     * A test of the edit option.
     * add a group
     *
     * @return void
     */
    public function testEditStudentGroup()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin');
            try{
                $browser->assertDontSee("Login");
            }catch(Exception $e){
                $browser->type('username','admin')
                    ->type('password','admin');
                $browser->press('Login');
            }
            $browser->visit('/admin/students')
                    ->assertSee('Students')
                    ->assertSee('Matricule')
                    ->assertSee('Prénom')
                    ->assertSee('Nom de famille');
            $id = Student::all()->first()->studentId;
            Liaison_student_group::where('studentId',$id)->delete();
            $link = "/admin/students/".$id."/edit";
            $browser->visit($link)
                    ->screenshot('tetetet')
                    ->assertSee('Edit')
                    ->assertSee("Group")
                    ->assertSee("Submit");

            $browser->select('Groups[]',"1");
            $browser->press('Submit');
            $browser->screenshot("rererer");
            $group = Group::find(1)->first();
            $browser->assertSee($group->acronym);
        });
    }
}
