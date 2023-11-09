<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;

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




//===ADMIN ROUTE GROUP===///
Route::group(['middleware' => 'admin'], function(){

    Route::get('/admin/dashboard', [DashboardController::class,'dashboard'])->name('admin.dashboard');
    
    
    Route::get('admin/admin/list', function (){
        return view('admin.admin.list');
    });
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


