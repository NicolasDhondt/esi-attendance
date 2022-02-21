<?php

use App\Http\Controllers\AttendanceCtrl;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeanceCtrl;
use App\Http\Controllers\StudentCtrl;
use App\Http\Controllers\CourseCtrl;
use App\Http\Controllers\AddFilesCtrl;
use App\Http\Controllers\QrCodeCtrl;
use App\Http\Controllers\LoginCtrl;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});
Route::get('/students', [StudentCtrl::class, 'index'])->name("students");
Route::get('/seances/{teacher}', [SeanceCtrl::class, 'index'])->name('seances');
Route::get('/getCalendar/{teacher}', [SeanceCtrl::class, 'getAllSeancesForCalendar'])->name('getCalendar');
Route::get('/studentsByCourse/{courseId}', [StudentCtrl::class, 'getByCourse'])->name("studentsByCourse");
Route::get('/studentsBySeance/{id}/{courseId}/{teacherId}', [StudentCtrl::class, 'getStudentsBySeance'])->name("studentsBySeance");
Route::get('/courses', [CourseCtrl::class, 'getAllCourseStudent'])->name('courses');
Route::post('/deleteInCourse', [CourseCtrl::class, 'deleteStudentInACourse'])->name("deleteInCourse");
Route::post('/addInCourse', [CourseCtrl::class, 'addStudentInACourse'])->name("addInCourse");
Route::post('/students/add', [StudentCtrl::class, 'store'])->name('addStudent');
Route::post('/studentsByGroup', [StudentCtrl::class, 'getByGroup'])->name("studentsByGroup");
Route::get('/addFiles', [AddFilesCtrl::class, 'index'])->name('addFiles');
Route::post('/addICS', [AddFilesCtrl::class, 'addICS'])->name('addICS');
Route::post('/addCSV', [AddFilesCtrl::class, 'addCSV'])->name('addCSV');
Route::post('/updateAttendance', [AttendanceCtrl::class, 'updateAttendance'])->name('updateAttendance');
Route::post('/updateAllAttendance', [AttendanceCtrl::class, 'updateAll'])->name('updateAllAttendance');
Route::post('/qrcode', [QrCodeCtrl::class, 'getQrCodeBySeance'])->name('qrcode');
Route::get('/login/{seanceId}', [LoginCtrl::class, 'redirectToGoogle'])->name('urlLoginToGoogle');
Route::get('/connectionResponse', [LoginCtrl::class, 'handleGoogleCallback']);
Route::get('/toValidationPage', [QrCodeCtrl::class, 'returnViewValidation'])->name('viewValidation');

