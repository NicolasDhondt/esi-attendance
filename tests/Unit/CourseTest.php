<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Course;
use Illuminate\Foundation\Testing\DatabaseMigrations;
class CourseTest extends TestCase
{

    use DatabaseMigrations;

    function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->artisan('db:seed StudentSeeder');
        $this->artisan('db:seed GroupSeeder');
        $this->artisan('db:seed Liaison_student_groupSeeder');
        $this->artisan('db:seed TeacherSeeder');
        $this->artisan('db:seed CourseSeeder');
        $this->artisan('db:seed SeanceSeeder');
    }
    /**
     * a test of the function getCourseTitle with a correct id
     *
     * @return void
     */
    public function test_getCourseTitle_equals()
    {
        $firstCourse = Course::first();
        $firstCourseTitle = $firstCourse->get('title')->first()->title;
        $firstCourseId = $firstCourse->get('id')->first()->id;
        $courseTitle = Course::getCourseTitle($firstCourseId)->title;
        $this->assertEquals($firstCourseTitle,$courseTitle);

    }
    /**
     * a test of the function getCourseTitle with a incorrect id
     *
     * @return void
     */
    public function test_getCourseTitle_equals_not()
    {
        $courseTitle = Course::getCourseTitle(999);
        $this->assertNull($courseTitle);

    }

    /**
     * a test of the function getAll
     *
     * @return void
     */
    public function test_getAll()
    {
        $courses = Course::getAll();
        $this->assertTrue($courses->count()>0);
    }
}
