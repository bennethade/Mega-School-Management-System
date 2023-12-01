<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssignClassTeacherController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ClassSubjectController;
use App\Http\Controllers\ClassTimetableController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

    

    //TEACHER ROUTES
    Route::get('admin/teacher/list', [TeacherController::class,'list'])->name('teacher.list');
    Route::get('admin/teacher/add', [TeacherController::class,'add'])->name('teacher.add');
    Route::post('admin/teacher/add', [TeacherController::class,'insert'])->name('teacher.insert');
    Route::get('admin/teacher/edit{id}', [TeacherController::class,'edit'])->name('teacher.edit');
    Route::post('admin/teacher/edit{id}', [TeacherController::class,'update'])->name('teacher.update');
    Route::get('admin/teacher/delete/{id}', [TeacherController::class,'delete'])->name('teacher.delete');




    
    //STUDENT ROUTES
    Route::get('admin/student/list', [StudentController::class,'list'])->name('student.list');
    Route::get('admin/student/add', [StudentController::class,'add'])->name('student.add');
    Route::post('admin/student/add', [StudentController::class,'insert'])->name('student.insert');
    Route::get('admin/student/edit{id}', [StudentController::class,'edit'])->name('student.edit');
    Route::post('admin/student/edit{id}', [StudentController::class,'update'])->name('student.update');
    Route::get('admin/student/delete/{id}', [StudentController::class,'delete'])->name('student.delete');




    //PARENT ROUTES
    Route::get('admin/parent/list', [ParentController::class,'list'])->name('parent.list');
    Route::get('admin/parent/add', [ParentController::class,'add'])->name('parent.add');
    Route::post('admin/parent/add', [ParentController::class,'insert'])->name('parent.insert');
    Route::get('admin/parent/edit{id}', [ParentController::class,'edit'])->name('parent.edit');
    Route::post('admin/parent/edit{id}', [ParentController::class,'update'])->name('parent.update');
    Route::get('admin/parent/delete/{id}', [ParentController::class,'delete'])->name('parent.delete');
    Route::get('admin/parent/delete/{id}', [ParentController::class,'delete'])->name('parent.delete');
    Route::get('admin/parent/my-student{id}', [ParentController::class,'myStudent'])->name('parent.my.student');
    Route::get('admin/parent/assign_student_to_parent/{student_id}/{parent_id}', [ParentController::class,'assignStudentToParent'])->name('parent.my.student');
    Route::get('admin/parent/delete_assign_student_to_parent/{student_id}', [ParentController::class,'deleteAssignStudentToParent'])->name('delete.parent.my.student');


    




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




    //ASSIGN SUBJECT ROUTES
    Route::get('admin/assign_subject/list', [ClassSubjectController::class,'list'])->name('assign_subject.list');
    Route::get('admin/assign_subject/add', [ClassSubjectController::class,'add'])->name('assign_subject.add');
    Route::post('admin/assign_subject/add', [ClassSubjectController::class,'insert'])->name('assign_subject.insert');

    Route::get('admin/assign_subject/edit_single{id}', [ClassSubjectController::class,'editSingle'])->name('assign_subject.edit_single');
    Route::post('admin/assign_subject/edit_single{id}', [ClassSubjectController::class,'updateSingle'])->name('assign_subject.update_single');

    Route::get('admin/assign_subject/mass_edit{id}', [ClassSubjectController::class,'massEdit'])->name('assign_subject.mass_edit');
    Route::post('admin/assign_subject/mass_edit{id}', [ClassSubjectController::class,'massUpdate'])->name('assign_subject.mass_update');

    Route::get('admin/assign_subject/delete/{id}', [ClassSubjectController::class,'delete'])->name('assign_subject.delete');





    //CLASS TIMETABLE ROUTES
    Route::get('admin/class_timetable/list', [ClassTimetableController::class,'list'])->name('class_timetable.list');
    Route::post('admin/class_timetable/get_subject', [ClassTimetableController::class,'getSubject'])->name('get_subject');


    


    //MY ACCOUNT
    Route::get('/admin/account', [UserController::class,'myAccount'])->name('admin.account');
    Route::post('/admin/account', [UserController::class,'updateMyAdminAccount'])->name('update.admin.account');



    //CHANGE PASSWORD
    Route::get('admin/change_password', [UserController::class,'changePassword'])->name('change_password');
    Route::post('admin/change_password', [UserController::class,'updatePassword'])->name('update_password');
    



    //ASSIGN CLASS TEACHER ROUTES
    Route::get('admin/assign_class_teacher/list', [AssignClassTeacherController::class,'list'])->name('assign_class_teacher.list');
    Route::get('admin/assign_class_teacher/add', [AssignClassTeacherController::class,'add'])->name('assign_class_teacher.add');
    Route::post('admin/assign_class_teacher/add', [AssignClassTeacherController::class,'insert'])->name('assign_class_teacher.insert');
    Route::get('admin/assign_class_teacher/mass_edit{id}', [AssignClassTeacherController::class,'massEdit'])->name('assign_class_teacher.mass_edit');
    Route::post('admin/assign_class_teacher/mass_edit{id}', [AssignClassTeacherController::class,'massUpdate'])->name('assign_class_teacher.mass_update');
    Route::get('admin/assign_class_teacher/edit_single{id}', [AssignClassTeacherController::class,'editSingle'])->name('assign_class_teacher.edit_single');
    Route::post('admin/assign_class_teacher/edit_single{id}', [AssignClassTeacherController::class,'updateSingle'])->name('assign_class_teacher.update_single');
    Route::get('admin/assign_class_teacher/delete{id}', [AssignClassTeacherController::class,'delete'])->name('assign_class_teacher.delete');



    

    

});
//===ADMIN ROUTE GROUP END===///








//===TEACHER ROUTE GROUP===///
Route::group(['middleware' => 'teacher'], function(){

    Route::get('/teacher/dashboard', [DashboardController::class,'dashboard'])->name('admin.dashboard');
    
    Route::get('teacher/change_password', [UserController::class,'changePassword'])->name('change_password');
    Route::post('teacher/change_password', [UserController::class,'updatePassword'])->name('update_password');


    Route::get('/teacher/account', [UserController::class,'myAccount'])->name('teacher.account');
    Route::post('/teacher/account', [UserController::class,'updateMyAccount'])->name('update.teacher.account');


    Route::get('/teacher/my_class_subject', [AssignClassTeacherController::class,'myClassSubject'])->name('teacher.my_class_subject');


    Route::get('/teacher/my_student', [StudentController::class,'myStudent'])->name('teacher.my_student');


    
});
//===TEACHER ROUTE GROUP END===///








//===STUDENT ROUTE GROUP===///
Route::group(['middleware' => 'student'], function(){

    Route::get('/student/dashboard', [DashboardController::class,'dashboard'])->name('admin.dashboard');

    Route::get('/student/account', [UserController::class,'myAccount'])->name('student.account');
    Route::post('/student/account', [UserController::class,'updateMyStudentAccount'])->name('update.student.account');

    Route::get('student/change_password', [UserController::class,'changePassword'])->name('change_password');
    Route::post('student/change_password', [UserController::class,'updatePassword'])->name('update_password');


    Route::get('/student/my_subject', [SubjectController::class,'mySubject'])->name('student.my_subject');


});
//===STUDENT ROUTE GROUP END===///






//===PARENT ROUTE GROUP===///
Route::group(['middleware' => 'parent'], function(){
    
    Route::get('/parent/dashboard', [DashboardController::class,'dashboard'])->name('admin.dashboard');

    Route::get('/parent/account', [UserController::class,'myAccount'])->name('parent.account');
    Route::post('/parent/account', [UserController::class,'updateMyParentAccount'])->name('update.parent.account');
    


    Route::get('parent/change_password', [UserController::class,'changePassword'])->name('change_password');
    Route::post('parent/change_password', [UserController::class,'updatePassword'])->name('update_password');


    Route::get('parent/my_student/subject{student_id}', [SubjectController::class,'parentStudentSubject'])->name('parent.student.subject');


    Route::get('parent/my_student', [ParentController::class,'myStudentParentSide'])->name('parent.my_student');

});



