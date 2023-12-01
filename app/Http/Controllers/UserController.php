<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserController extends Controller
{
    public function myAccount()
    {
        // $data['getRecord'] = User::findOrFail(Auth::user()->id);
        $data['getRecord'] = User::getSingle(Auth::user()->id);
        $data['header_title'] = "My Account";

        if(Auth::user()->user_type == 1)
        {
            return view('admin.my_account', $data);
        }

        elseif(Auth::user()->user_type == 2)
        {
            return view('teacher.my_account', $data);
        }
        elseif(Auth::user()->user_type == 3)
        {
            return view('student.my_account', $data);
        }
        elseif(Auth::user()->user_type == 4)
        {
            return view('parent.my_account', $data);
        }

        
    }


    public function updateMyAdminAccount(Request $request)
    {
        $id = Auth::user()->id;

        $request->validate([
            'email' => 'required|email|unique:users,email,'.$id,
        ]);
        
        $admin = User::getSingle($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->save();

        return redirect()->back()->with('success', 'Account Updated Successfully!');

    } 



    public function updateMyAccount(Request $request)
    {   
        $id = Auth::user()->id;

        $request->validate([
            'email' => 'required|email|unique:users,email,'.$id,
            'mobile_number' => 'max:15|min:8',
            'marital_status' => 'max:50'
        ]); 

        $user = User::getSingle($id);
        
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->other_name = $request->other_name;
        $user->gender = $request->gender;

        if(!empty($request->date_of_birth))
        {
            $user->date_of_birth = $request->date_of_birth;
        }

        if(!empty($request->file('profile_picture')))
        {
            if(!empty($user->getProfile()))
            {
                unlink('upload/profile/'.$user->profile_picture);
            }

            $ext = $request->file('profile_picture')->getClientOriginalExtension();
            $file = $request->file('profile_picture');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename); 

            $user->profile_picture = $filename;
        }
        
        $user->marital_status = $request->marital_status;
        $user->mobile_number = $request->mobile_number;
        $user->address = $request->address;
        $user->permanent_address = $request->permanent_address;
        $user->qualification = $request->qualification;
        $user->work_experience = $request->work_experience;
                
        $user->save();

        return redirect()->back()->with('success', 'Account Updated Successfully!');

    }



    public function updateMyStudentAccount(Request $request)
    {
        $id = Auth::user()->id;

        $request->validate([
            'mobile_number' => 'max:15|min:8',            
            'blooad_group' => 'max:10',
            'caste' => 'max:50',
            'religion' => 'max:50',
            'height' => 'max:10',
            'weight' => 'max:10'
        ]); 

        $user = User::getSingle($id);
        
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->other_name = $request->other_name;
        $user->gender = $request->gender;

        if(!empty($request->date_of_birth))
        {
            $user->date_of_birth = $request->date_of_birth;
        }

        if(!empty($request->file('profile_picture')))
        {
            if(!empty($user->getProfile()))
            {
                unlink('upload/profile/'.$user->profile_picture);
            }

            $ext = $request->file('profile_picture')->getClientOriginalExtension();
            $file = $request->file('profile_picture');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename); 

            $user->profile_picture = $filename;
        }
        
        $user->address = $request->address;
        $user->mobile_number = $request->mobile_number;        
        $user->caste = $request->caste;
        $user->religion = $request->religion;
        $user->blood_group = $request->blood_group;
        $user->height = $request->height;
        $user->weight = $request->weight;
                
        $user->save();

        return redirect()->back()->with('success', 'Account Updated Successfully!');

    }


    public function updateMyParentAccount(Request $request)
    {
        $id = Auth::user()->id;

        $request->validate([
            // 'email' => 'required|email|unique:users,email,'.$id,
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
        $parent->email = $request->email;
        
        $parent->save();

        return redirect()->back()->with('success', 'Account Updated Successfully!');


    }




    public function changePassword()
    {
        $data['header_title'] = "Change Password";
        return view('profile.change_password', $data);
    }


    public function updatePassword(Request $request)
    {
        // dd($request->all());

        $user = User::getSingle(Auth::user()->id);

       $new_password = $request->new_password;
       $confirm_password = $request->confirm_password;


        if(Hash::check($request->old_password, $user->password))
        {
            if($new_password == $confirm_password)
            {
                $user->password = Hash::make($request->new_password);
                $user->save();
                return redirect()->back()->with('success', "Password Changed Successfully!");
            }
            else{
                return redirect()->back()->with('error', "Passwords do not match");
            }

        }
        else
        {
            return redirect()->back()->with('error', "Old password is not correct");
        }

    }






}
