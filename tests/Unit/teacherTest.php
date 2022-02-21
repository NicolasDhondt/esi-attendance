<?php

namespace Tests\Unit;

use App\Models\Teacher;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

class teacherTest extends TestCase
{

    use DatabaseMigrations;

    function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->artisan('db:seed TeacherSeeder');
    }
    /**
     * Test of the method getProfName with a correct id
     *
     * @return void
     */
    public function test_getTeacherName_correct()
    {
        $firstTeacher = Teacher::first();
        $firstTeacherName = $firstTeacher->last_name;
        $teacherName = Teacher::getTeacherName($firstTeacher->id)->first()->last_name;
        assertEquals($firstTeacherName, $teacherName);
    }
    /**
     * Test of the method getProfName with a incorrect id
     *
     * @return void
     */
    public function test_getTeacherName_incorrect()
    {
        $teacherName = Teacher::getTeacherName(99);
        assertTrue($teacherName->isEmpty());
    }

    /**
     * Test if getAll return teachers
     *
     * @return void
     */
    public function test_getAll()
    {
        $teachers = Teacher::getAll();
        $this->assertTrue($teachers[0] != NULL);
    }
}
