<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Facebook\WebDriver\WebDriverBy;

use function PHPUnit\Framework\assertNotEquals;

class CourseTest extends DuskTestCase
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

    public function test_see_courses()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/courses')
                ->assertSee('N° cours');
        });
    }

    public function test_see_student_by_course()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/courses')
                ->assertSee('N° cours')
                ->click("@trCourse")
                ->assertSee('Etudiants du cours');
        });
    }
}
