<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Seance;
use Facebook\WebDriver\WebDriverBy;

class AttendanceTest extends DuskTestCase
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
        $this->artisan('db:seed PaeSeeder');
    }
    /**
     * a test of the add a presence option.
     *
     * @return void
     */
    public function testTakeThePresence()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/students');
            $seanceUrl = Seance::seancesForCalendar(Seance::getAll())[0][4];
            $browser->visit($seanceUrl)
                ->check('@presentCheck');
            $browser->assertChecked('@presentCheck');
        });
    }
    /**
     * a test of the delete a presence option.
     *
     * @return void
     */
    public function testDeletePresence()
    {
        $this->browse(function (Browser $browser) {
            $seanceUrl = Seance::seancesForCalendar(Seance::getAll())[0][4];
            $browser->visit($seanceUrl)
                ->check('@presentCheck')
                ->assertChecked('@presentCheck')
                ->press('@presentCheck')
                ->assertNotChecked('@presentCheck');
        });
    }
    /**
     * a test of the delete a presence option.
     *
     * @return void
     */
    public function testQrCodeDisplay()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('studentsBySeance/3/2/1')
                ->press('@genererQrCodeButton')
                ->assertSee('@qrCodeImage');
        });
    }
    /**
     * A test of the select all button.
     */
    public function testSelectAll(){
        $this->browse(function(Browser $browser){
            $seanceUrl = Seance::seancesForCalendar(Seance::getAll())[0][4];
            $browser->visit($seanceUrl)
                ->click('@selectAll');

            $checkBox = $browser->driver->findElements(WebDriverBy::className('checkbox_max'));
            $allChecked = true;
            for ($i = 0; $i < count($checkBox) - 1 && $allChecked; $i++) {
                if($checkBox[$i]->getAttribute('checked')!=true){
                    $allChecked = false;
                }
            }
            $this->assertTrue($allChecked);
            $this->assertTrue(count($checkBox)>0);
        });
    }
}
