<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CourseController;
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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [SMSController::class, 'index'])->name('/');
Route::get('/about', [SMSController::class, 'about'])->name('about'); // name for uses route in assets pages

Route::get('/course', [SMSController::class, 'course'])->name('course');
Route::get('/contact', [SMSController::class, 'contact'])->name('contact');
Route::get('/student-login', [SMSController::class, 'studentLogin'])->name('student-login');
Route::get('/student-register', [SMSController::class, 'studentRegister'])->name('student-register');
Route::get('/teacher-login', [TeacherController::class, 'teacherLogin'])->name('teacher-login');
Route::post('/teacher-login', [TeacherController::class, 'teacherLoginCheck'])->name('teacher-login');


Route::group(['middleware' => 'teacher'], function(){
    Route::get('/teacher-logout', [TeacherController::class, 'teacherLogout'])->name('teacher-logout');
    Route::get('/teacher-profile', [TeacherController::class, 'teacherProfile'])->name('teacher-profile');
    Route::get('/add-course', [CourseController::class, 'addCourse'])->name('add-course');
    Route::get('/manage-course', [CourseController::class, 'manageCourse'])->name('manage-course');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
//    Route::get('/dashboard', function () {
//        return view('dashboard');
//    })->name('dashboard');

    Route::get('/dashboard',[AdminController::class, 'index'])->name('dashboard');
    Route::get('/add-teacher',[TeacherController::class, 'index'])->name('add-teacher');
    Route::get('/manage-teacher',[TeacherController::class, 'manageTeacher'])->name('manage-teacher');
    Route::post('/new-teacher',[TeacherController::class, 'saveTeacher'])->name('new-teacher');
    Route::post('/teacher-delete',[TeacherController::class, 'deleteTeacher'])->name('teacher-delete');
    Route::get('/teacher-edit/{id}',[TeacherController::class, 'editTeacher'])->name('teacher-edit');
    Route::post('/update-teacher',[TeacherController::class, 'updateTeacher'])->name('update-teacher');
});
