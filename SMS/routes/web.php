<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
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
Route::get('/contact', [SMSController::class, 'contact'])->name('contact');

Route::get('/course', [SMSController::class, 'course'])->name('course');
Route::get('/course-details/{slug}', [SMSController::class, 'courseDetails'])->name('course-details');



// frontend student routes
Route::get('/student-login', [StudentController::class, 'studentLogin'])->name('student-login');
Route::get('/student-profile/{stuId}', [StudentController::class, 'studentProfile'])->name('student-profile');
Route::get('/student-register', [StudentController::class, 'studentRegister'])->name('student-register');
Route::post('/save-student', [StudentController::class, 'saveStudent'])->name('save-student');
Route::post('/student-login-check', [StudentController::class, 'studentLoginCheck'])->name('student-login-check');
Route::get('/student-logout', [StudentController::class, 'studentLogout'])->name('student-logout');
Route::post('/admission', [StudentController::class, 'admission'])->name('admission');

//admin teacher routes
//first route get for open login form, second route post, for login check where send data from form
Route::get('/teacher-login', [TeacherController::class, 'teacherLogin'])->name('teacher-login');
Route::post('/teacher-login', [TeacherController::class, 'teacherLoginCheck'])->name('teacher-login');


Route::group(['middleware' => 'teacher'], function(){
    // this for where written form action post
    Route::post('/teacher-logout', [TeacherController::class, 'teacherLogout'])->name('teacher-logout');
    // this for where written route in anchor tag
    Route::get('/teacher-logout', [TeacherController::class, 'teacherLogout'])->name('teacher-logout');
    Route::get('/teacher-profile', [TeacherController::class, 'teacherProfile'])->name('teacher-profile');
    Route::get('/add-course', [CourseController::class, 'addCourse'])->name('add-course');
    Route::get('/manage-course/{teacherID}', [CourseController::class, 'manageCourse'])->name('manage-course');
    Route::post('/new-course', [CourseController::class, 'saveCourse'])->name('new-course');
    Route::post('/delete-course', [CourseController::class, 'deleteCourse'])->name('delete-course');
    Route::get('/edit-course/{id}', [CourseController::class, 'editCourse'])->name('edit-course');
    Route::post('/update-course', [CourseController::class, 'updateCourse'])->name('update-course');
    Route::get('/manage-applicant', [CourseController::class, 'manageApplicant'])->name('manage-applicant');
    Route::get('/applicant-overview', [CourseController::class, 'applicantOverview'])->name('applicant-overview');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
//    Route::get('/dashboard', function () {
//        return view('dashboard');
//    })->name('dashboard');

    Route::get('/dashboard',[AdminController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
    Route::get('/admin',[AdminController::class, 'index'])->name('dashboard');
    Route::get('/add-teacher',[TeacherController::class, 'index'])->name('add-teacher');
    Route::get('/manage-teacher',[TeacherController::class, 'manageTeacher'])->name('manage-teacher');
    Route::post('/new-teacher',[TeacherController::class, 'saveTeacher'])->name('new-teacher');
    Route::post('/teacher-delete',[TeacherController::class, 'deleteTeacher'])->name('teacher-delete');
    Route::get('/teacher-edit/{id}',[TeacherController::class, 'editTeacher'])->name('teacher-edit');
    Route::post('/update-teacher',[TeacherController::class, 'updateTeacher'])->name('update-teacher');
});
