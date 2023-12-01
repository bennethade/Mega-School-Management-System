<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class TeacherController extends Controller
{
    public function list()
    {
        $data['header_title'] = "Teacher List";

        $data['getRecord'] = User::getTeacher();
        return view('admin.teacher.list', $data);
    }


    public function add()
    {
        $data['header_title'] = "Add New Teacher";

        return view('admin.teacher.add', $data);
    }


    public function insert(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'email' => 'required|email|unique:users',
            'mobile_number' => 'max:15|min:8',
            'marital_status' => 'max:50',
        ]); 

        $teacher = new User();

        $teacher->user_type = 2;
        $teacher->keep_track = $request->password;
        
        $teacher->name = $request->name;
        $teacher->last_name = $request->last_name;
        $teacher->other_name = $request->other_name;
        $teacher->gender = $request->gender;

        if(!empty($request->date_of_birth))
        {
            $teacher->date_of_birth = $request->date_of_birth;
        }

        if(!empty($request->admission_date))
        {
            $teacher->admission_date = $request->admission_date;
        }

        if(!empty($request->file('profile_picture')))
        {
            $ext = $request->file('profile_picture')->getClientOriginalExtension();
            $file = $request->file('profile_picture');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename); 

            $teacher->profile_picture = $filename;
        }


        // if ($request->file('profile_picture')) {
        //     $file = $request->file('profile_picture');
        //     $filename = date('YmdHi').$file->getClientOriginalName();
        //     $file->move(public_path('upload/profile'),$filename);
        //     $teacher['profile_picture'] = $filename;
        // }

        
        $teacher->marital_status = $request->marital_status;
        $teacher->mobile_number = $request->mobile_number;
        $teacher->address = $request->address;
        $teacher->mobile_number = $request->mobile_number;
        $teacher->permanent_address = $request->permanent_address;
        $teacher->qualification = $request->qualification;
        $teacher->work_experience = $request->work_experience;
        $teacher->note = $request->note;
        $teacher->status = $request->status;
        
        $teacher->email = $request->email;
        $teacher->password = Hash::make($request->password);
        $teacher->save();

        return redirect()->route('teacher.list')->with('success', 'Teacher Created Successfully!');

    }


    public function edit($id)
    {
        $data['header_title'] = "Edit Teacher";

        $data['getRecord'] = User::getSingle($id);
        return view('admin.teacher.edit', $data);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,'.$id,
            'mobile_number' => 'max:15|min:8',
            'marital_status' => 'max:50',
        ]); 

        $teacher = User::getSingle($id);
        
        $teacher->name = $request->name;
        $teacher->last_name = $request->last_name;
        $teacher->other_name = $request->other_name;
        $teacher->gender = $request->gender;

        if(!empty($request->date_of_birth))
        {
            $teacher->date_of_birth = $request->date_of_birth;
        }

        if(!empty($request->admission_date))
        {
            $teacher->admission_date = $request->admission_date;
        }

        if(!empty($request->file('profile_picture')))
        {
            if(!empty($teacher->getProfile()))
            {
                unlink('upload/profile/'.$teacher->profile_picture);
            }

            $ext = $request->file('profile_picture')->getClientOriginalExtension();
            $file = $request->file('profile_picture');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename); 

            $teacher->profile_picture = $filename;
        }
        
        $teacher->marital_status = $request->marital_status;
        $teacher->mobile_number = $request->mobile_number;
        $teacher->address = $request->address;
        $teacher->mobile_number = $request->mobile_number;
        $teacher->permanent_address = $request->permanent_address;
        $teacher->qualification = $request->qualification;
        $teacher->work_experience = $request->work_experience;
        $teacher->note = $request->note;
        $teacher->status = $request->status;
        
        $teacher->email = $request->email;

        if(!empty($request->password))
        {
            $teacher->keep_track = $request->password;
            
            $teacher->password = Hash::make($request->password);
        }
        
        $teacher->save();

        return redirect()->route('teacher.list')->with('success', 'Teacher Updated Successfully!');

    }


    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('teacher.list')->with('warning', 'Teacher Deleted Successfully!');
    }




}
