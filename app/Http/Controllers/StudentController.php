<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class StudentController extends Controller
{
    public function list()
    {
        $data['header_title'] = "Student List";

        $data['getRecord'] = User::getStudent();
        return view('admin.student.list', $data);
    }


    public function add()
    {
        $data['header_title'] = "Add New Student";

        $data['getClass'] = ClassModel::getClass();
        return view('admin.student.add', $data);
    }


    public function insert(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'email' => 'required|email|unique:users',
            // 'blooad_group' => 'max:10',
            // 'admission_number' => 'max:50',
            // 'roll_number' => 'max:50',
            // 'mobile_number' => 'max:15|min:8',
            // 'caste' => 'max:50',
            // 'religion' => 'max:50',
            // 'height' => 'max:10',
            // 'weight' => 'max:10'
        ]); 

        $student = new User();

        $student->user_type = 3;
        $student->keep_track = $request->password;
        
        $student->name = $request->name;
        $student->last_name = $request->last_name;
        $student->other_name = $request->other_name;
        $student->admission_number = $request->admission_number;
        $student->roll_number = $request->roll_number;
        $student->class_id = $request->class_id;
        $student->gender = $request->gender;

        if(!empty($request->date_of_birth))
        {
            $student->date_of_birth = $request->date_of_birth;
        }

        if(!empty($request->file('profile_picture')))
        {
            $ext = $request->file('profile_picture')->getClientOriginalExtension();
            $file = $request->file('profile_picture');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename); 

            $student->profile_picture = $filename;
        }


        // if ($request->file('profile_picture')) {
        //     $file = $request->file('profile_picture');
        //     $filename = date('YmdHi').$file->getClientOriginalName();
        //     $file->move(public_path('upload/profile'),$filename);
        //     $student['profile_picture'] = $filename;
        // }


        if(!empty($request->admission_date))
        {
            $student->admission_date = $request->admission_date;
        }
        
        $student->caste = $request->caste;
        $student->religion = $request->religion;
        $student->mobile_number = $request->mobile_number;
        $student->blood_group = $request->blood_group;
        $student->height = $request->height;
        $student->weight = $request->weight;
        $student->status = $request->status;
        $student->email = $request->email;
        $student->password = Hash::make($request->password);
        $student->save();

        return redirect()->route('student.list')->with('success', 'Student Created Successfully!');

    }



    public function edit($id)
    {
        $data['header_title'] = "Edit Student";

        $data['getRecord'] = User::getSingle($id);
        $data['getClass'] = ClassModel::getClass();
        return view('admin.student.edit', $data);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,'.$id,
            // 'blooad_group' => 'max:10',
            // 'admission_number' => 'max:50',
            // 'roll_number' => 'max:50',
            // 'mobile_number' => 'max:15|min:8',
            // 'caste' => 'max:50',
            // 'religion' => 'max:50',
            // 'height' => 'max:10',
            // 'weight' => 'max:10'
        ]); 

        $student = User::getSingle($id);
        
        $student->name = $request->name;
        $student->last_name = $request->last_name;
        $student->other_name = $request->other_name;
        $student->admission_number = $request->admission_number;
        $student->roll_number = $request->roll_number;
        $student->class_id = $request->class_id;
        $student->gender = $request->gender;

        if(!empty($request->date_of_birth))
        {
            $student->date_of_birth = $request->date_of_birth;
        }

        if(!empty($request->file('profile_picture')))
        {
            if(!empty($student->getProfile()))
            {
                unlink('upload/profile/'.$student->profile_picture);
            }

            $ext = $request->file('profile_picture')->getClientOriginalExtension();
            $file = $request->file('profile_picture');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename); 

            $student->profile_picture = $filename;
        }

        if(!empty($request->admission_date))
        {
            $student->admission_date = $request->admission_date;
        }
        
        $student->caste = $request->caste;
        $student->religion = $request->religion;
        $student->mobile_number = $request->mobile_number;
        $student->blood_group = $request->blood_group;
        $student->height = $request->height;
        $student->weight = $request->weight;
        $student->status = $request->status;
        $student->email = $request->email;

        if(!empty($request->password))
        {
            $student->keep_track = $request->password;
            
            $student->password = Hash::make($request->password);
        }
        
        $student->save();

        return redirect()->route('student.list')->with('success', 'Student Updated Successfully!');

    }


    public function delete($id)
    {
        $user = User::findorFail($id);
        $user->delete();

        return redirect()->route('student.list')->with('warning', 'Student Deleted Successfully!');
    }


    public function myStudent()
    {

        $data['getRecord'] = User::getTeacherStudent(Auth::user()->id);

        $data['header_title'] = "My Students";
        return view('teacher.my_student', $data);
    }





}
