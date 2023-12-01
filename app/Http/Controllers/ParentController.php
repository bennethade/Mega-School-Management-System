<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class ParentController extends Controller
{
    public function list()
    {
        $data['header_title'] = "Parent List";

        $data['getRecord'] = User::getParent();
        return view('admin.parent.list', $data);
    }


    public function add()
    {
        $data['header_title'] = "Add New Parent";

        return view('admin.parent.add', $data);
    }



    public function insert(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'email' => 'required|email|unique:users',
            'mobile_number' => 'max:15|min:8',
            'address' => 'max:255',
            'occupation' => 'max:255',
        ]); 

        $parent = new User();

        $parent->user_type = 4;
        $parent->keep_track = $request->password;
        
        $parent->name = $request->name;
        $parent->last_name = $request->last_name;
        $parent->other_name = $request->other_name;
        $parent->gender = $request->gender;
        $parent->occupation = $request->occupation;
        $parent->address = $request->address;


        if(!empty($request->file('profile_picture')))
        {
            $ext = $request->file('profile_picture')->getClientOriginalExtension();
            $file = $request->file('profile_picture');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename); 

            $parent->profile_picture = $filename;
        }


        // if ($request->file('profile_picture')) {
        //     $file = $request->file('profile_picture');
        //     $filename = date('YmdHi').$file->getClientOriginalName();
        //     $file->move(public_path('upload/profile'),$filename);
        //     $parent['profile_picture'] = $filename;
        // }


        
        $parent->mobile_number = $request->mobile_number;
        $parent->status = $request->status;
        $parent->email = $request->email;
        $parent->password = Hash::make($request->password);
        $parent->save();

        return redirect()->route('parent.list')->with('success', 'Parent Created Successfully!');

    }


    public function edit($id)
    {
        $data['header_title'] = "Edit Parent";

        $data['getRecord'] = User::getSingle($id);
        return view('admin.parent.edit', $data);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,'.$id,
            'occupation' => 'max:255',
            'mobile_number' => 'max:15|min:8',
            'address' => 'max:255',
            
        ]); 

        $parent = User::getSingle($id);
        
        $parent->name = $request->name;
        $parent->last_name = $request->last_name;
        $parent->other_name = $request->other_name;
        $parent->occupation = $request->occupation;
        $parent->address = $request->address;
        $parent->gender = $request->gender;


        if(!empty($request->file('profile_picture')))
        {
            if(!empty($parent->getProfile()))
            {
                unlink('upload/profile/'.$parent->profile_picture);
            }

            $ext = $request->file('profile_picture')->getClientOriginalExtension();
            $file = $request->file('profile_picture');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename); 

            $parent->profile_picture = $filename;
        }

        
        $parent->mobile_number = $request->mobile_number;
        $parent->status = $request->status;
        $parent->email = $request->email;

        if(!empty($request->password))
        {
            $parent->keep_track = $request->password;
            
            $parent->password = Hash::make($request->password);
        }
        
        $parent->save();

        return redirect()->route('parent.list')->with('success', 'Parent Updated Successfully!');

    }



    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('parent.list')->with('warning', 'Parent Deleted Successfully!');
    }


    public function myStudent($id)
    {
        $data['header_title'] = "Parent Student List";

        $data['getParent'] = User::getSingle($id);
        $data['parent_id'] = $id;
        $data['getSearchStudent'] = User::getSearchStudent();
        $data['getRecord'] = User::getMyStudent($id);
        return view('admin.parent.my_student', $data);
    }


    public function assignStudentToParent($student_id, $parent_id)
    {
        $student = User::getSingle($student_id);
        $student->parent_id = $parent_id;
        $student->save();

        return redirect()->back()->with('success', 'Student Assigned Successfully!');
    }


    public function deleteAssignStudentToParent($student_id)
    {
        $student = User::getSingle($student_id);
        $student->parent_id = null;
        $student->save();

        return redirect()->back()->with('success', 'Deleted Assigned Student!');
    }


    //PARENT DASHBOARD FUNCTIONS
    public function myStudentParentSide()
    {
        $id = Auth::user()->id;

        $data['getRecord'] = User::getMyStudent($id);

        $data['header_title'] = "My Student";
        return view('parent.my_student', $data); 
    }




}
