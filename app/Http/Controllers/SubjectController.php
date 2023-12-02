<?php

namespace App\Http\Controllers;

use App\Models\ClassSubject;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function list()
    {
        $data['header_title'] = "Subject List";

        $data['getRecord'] = Subject::getRecord();
        return view('admin.subject.list', $data);
    }


    public function add()
    {
        $data['header_title'] = "Add Subject";
        return view('admin.subject.add', $data);
    }


    public function insert(Request $request)
    {
        $subject = new Subject;
        $subject->name = $request->name;
        $subject->type = $request->type;
        $subject->status = $request->status;
        $subject->created_by = Auth::user()->id;
        $subject->save();

        return redirect()->route('subject.list')->with('success','Subject Created Successfull');

        // dd($request->all());
    }


    public function edit($id)
    {
        $data['header_title'] = "Edit Subject";


        // $data['getRecord'] = ClassModel::findOrFail($id);
        $data['getRecord'] = Subject::getSingle($id);
        
        return view('admin.subject.edit', $data);
    }


    public function update(Request $request, $id)
    {
        $subject = Subject::getSingle($id);

        $subject->name = $request->name;
        $subject->type = $request->type;
        $subject->status = $request->status;
        $subject->save();

        return redirect()->route('subject.list')->with('success','Subject Updated Successfull');
    }


    public function delete($id)
    {
        $subject = Subject::getSingle($id);
        $subject->delete();
        // $subject->is_delete = 1;
        // $subject->save();

        return redirect()->route('subject.list')->with('success','Subject Deleted Successfull');
    }





    //STUDENT SIDE
    public function mySubject()
    {
        // dd(auth::user()->class_id);

        $data['getRecord'] = ClassSubject::mySubject(Auth::user()->class_id);
        
        $data['header_title'] = "My Subject";

        return view('student.my_subject', $data);
    }



    //PARENT SIDE
    public function parentStudentSubject($student_id)
    {
        $user = User::getSingle($student_id);
        $data['getUser'] = $user;

        $data['getRecord'] = ClassSubject::mySubject($user->class_id);

        $data['header_title'] = "Student Subject";
        return view('parent.my_student_subject', $data);
    }



}


