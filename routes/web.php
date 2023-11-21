<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Subject;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'login'])->name('login');

Route::post('/login', [AuthController::class, 'authLogin'])->name('authLogin');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
Route::post('forgot-password', [AuthController::class, 'postForgotPassword'])->name('post.forgot-password');
Route::get('reset/{token}', [AuthController::class, 'reset'])->name('reset');
Route::post('reset/{token}', [AuthController::class, 'postReset'])->name('postReset');




//===ADMIN ROUTE GROUP===///
Route::group(['middleware' => 'admin'], function(){

    Route::get('admin/dashboard', [DashboardController::class,'dashboard'])->name('admin.dashboard');
    Route::get('admin/admin/list', [AdminController::class,'list'])->name('admin.list');
    Route::get('admin/admin/add', [AdminController::class,'add'])->name('admin.add');
    Route::post('admin/admin/add', [AdminController::class,'insert'])->name('admin.insert');
    Route::get('admin/admin/edit{id}', [AdminController::class,'edit'])->name('admin.edit');
    Route::post('admin/admin/edit{id}', [AdminController::class,'update'])->name('admin.update');
    Route::get('admin/admin/delete/{id}', [AdminController::class,'delete'])->name('admin.delete');

    

    // ClASS ROUTES
    Route::get('admin/class/list', [ClassController::class,'list'])->name('class.list');
    Route::get('admin/class/add', [ClassController::class,'add'])->name('class.add');
    Route::post('admin/class/add', [ClassController::class,'insert'])->name('class.insert');
    Route::get('admin/class/edit{id}', [ClassController::class,'edit'])->name('class.edit');
    Route::post('admin/class/edit{id}', [ClassController::class,'update'])->name('class.update');
    Route::get('admin/class/delete/{id}', [ClassController::class,'delete'])->name('class.delete');



    //SUBJECT ROUTES
    Route::get('admin/subject/list', [SubjectController::class,'list'])->name('subject.list');
    Route::get('admin/subject/add', [SubjectController::class,'add'])->name('subject.add');
    Route::post('admin/subject/add', [SubjectController::class,'insert'])->name('subject.insert');
    Route::get('admin/subject/edit{id}', [SubjectController::class,'edit'])->name('subject.edit');
    Route::post('admin/subject/edit{id}', [SubjectController::class,'update'])->name('subject.update');
    Route::get('admin/subject/delete/{id}', [SubjectController::class,'delete'])->name('subject.delete');


    


    

});








//===TEACHER ROUTE GROUP===///
Route::group(['middleware' => 'teacher'], function(){

    Route::get('/teacher/dashboard', [DashboardController::class,'dashboard'])->name('admin.dashboard');
    
});








//===STUDENT ROUTE GROUP===///
Route::group(['middleware' => 'student'], function(){

    Route::get('/student/dashboard', [DashboardController::class,'dashboard'])->name('admin.dashboard');

});






//===PARENT ROUTE GROUP===///
Route::group(['middleware' => 'parent'], function(){
    
    Route::get('/parent/dashboard', [DashboardController::class,'dashboard'])->name('admin.dashboard');

});


