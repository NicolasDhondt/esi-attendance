<?php

namespace Tests\Unit;

use App\Models\Seance;
use App\Models\Teacher;
use Carbon\Carbon;
use DateTime;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SeanceTest extends TestCase
{
    use DatabaseMigrations;

    function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed StudentSeeder');
        $this->artisan('db:seed GroupSeeder');
        $this->artisan('db:seed Liaison_student_groupSeeder');
        $this->artisan('db:seed teacherSeeder');
        $this->artisan('db:seed CourseSeeder');
        $this->artisan('db:seed SeanceSeeder');
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_getAll()
    {
        $seances = Seance::getAll();
        $sorted = true;
        for ($i = 0; $i < $seances->count() - 1 && $sorted; $i++) {
            if ($seances[$i + 1]->dateTime < $seances[$i]->dateTime) {
                $sorted = false;
            }
        }
        $this->assertTrue($sorted);
    }

    public function test_getAllToday()
    {
        $datetime = new DateTime();
        $datetime->format('Y-m-d H:i:s');
        $datetime->setTime(23, 59, 59, 0); //To have a correct date

        $seance = new Seance();
        $seance->courseId = 1;
        $seance->teacherId = 1;
        $seance->groupId = 1;
        $seance->dateTime = $datetime;
        $seance->local = "004";
        $seance->save();
        $seances = Seance::getAllToday();
        $this->assertTrue(count($seances) > 0);
    }

    public function test_getAllSortedByTeacher()
    {
        $firstTeacher = Teacher::first();
        $seances = Seance::getAllSortedByTeacher($firstTeacher->last_name);
        $this->assertTrue(count($seances) > 0);
    }

    public function test_getAllTodaySortedByTeacher()
    {
        $datetime = new DateTime();
        $datetime->format('Y-m-d H:i:s');
        $datetime->setTime(23, 59, 59, 0);
        $seance = new Seance();
        $seance->courseId = 1;
        $seance->teacherId = 1;
        $seance->groupId = 1;
        $seance->dateTime = $datetime;
        $seance->local = "004";
        $seance->save();

        $firstTeacher = Teacher::where('id', '=', 1)->get()->first();

        $seances = Seance::getAllTodaySortedByTeacher($firstTeacher->last_name);
        $this->assertTrue(count($seances) > 0);
    }

    public function test_addSeance()
    {
        $datetime = new DateTime();
        $datetime->format('Y-m-d H:i:s');
        $carbonDate = new Carbon($datetime);
        $date = $carbonDate->timezone("Europe/Brussels")->addHours(2)->format('Y-m-d H:i:s');

        $seancesBeforeAdd = Seance::getAll();

        $firstTeacher = Teacher::where('id', '=', 1)->get()->first();
        Seance::addSeance(["Projet"], ["$firstTeacher->acronym"], ["E11"], [$date], ["989"]);

        $seancesAfterAdd = Seance::getAll();

        $this->assertTrue(count($seancesBeforeAdd) < count($seancesAfterAdd));
    }

    // -------- Tests for ICalendar --------

    public function test_seancesForCalendar()
    {
        $datetime = new DateTime();
        $datetime->format('Y-m-d H:i:s');
        $datetime->setTime(23, 59, 59, 0);

        $seance = new Seance();
        $seance->courseId = 1;
        $seance->teacherId = 1;
        $seance->groupId = 1;
        $seance->dateTime = $datetime;
        $seance->local = "004";
        $seance->save();

        $seances = Seance::getAll();
        $arraySeancesEvent = Seance::seancesForCalendar($seances);

        $rigthSeanceForCalendar = false;
        foreach ($arraySeancesEvent as $seanceEventsInfos) {
            if (!$rigthSeanceForCalendar && $seanceEventsInfos[4] == "/studentsBySeance/1/1/1") {
                $rigthSeanceForCalendar = true;
            }
        }
        $this->assertTrue($rigthSeanceForCalendar);
    }
}
