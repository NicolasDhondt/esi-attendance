<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use App\Models\Teacher;
use Tests\DuskTestCase;
use Facebook\WebDriver\WebDriverBy;

class SeanceTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed StudentSeeder');
        $this->artisan('db:seed GroupSeeder');
        $this->artisan('db:seed Liaison_student_groupSeeder');
        $this->artisan('db:seed TeacherSeeder');
        $this->artisan('db:seed CourseSeeder');
        $this->artisan('db:seed SeanceSeeder');
        $this->artisan('db:seed paeSeeder');
    }
    public function test_callendar_seances()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/seances/all')
                ->assertSee("L'ensemble des cours")
                ->assertSee('today')
                ->assertSee('month')
                ->assertSee('week')
                ->assertSee('day')
                ->assertSee('16 h');
        });
    }

    public function test_filters_seances()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/seances/all')
                ->assertSee("L'ensemble des cours")
                ->click("@selectTeacher")
                ->screenshot("eeee")
                ->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
            $browser->click("@selectTeacherButton")
                ->assertSee("Cours du professeur ");
        });
    }
    public function test_seances_teacher()
    {
        $this->browse(function (Browser $browser) {
            $teachers = Teacher::getAll();
            $teacherName = $teachers[0]->last_name;
            $browser->visit("/seances/$teacherName")
                ->assertSee("Cours du professeur $teacherName");
        });
    }
}
