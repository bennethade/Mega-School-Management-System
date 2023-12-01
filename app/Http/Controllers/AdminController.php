<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    
    public function list()
    {
        $data['header_title'] = "Admin List";

        // $data['getRecord'] = User::where('user_type', 1)->Where('is_delete', 0)->orderBy('id','desc')->paginate(4);
        $data['getRecord'] = User::getAdmin();
        
        return view('admin.admin.list', $data);
    }


    public function add()
    {
        $data['header_title'] = "Add New Admin";

        return view('admin.admin.add', $data);
    }


    public function insert(Request $request)
    {
        // dd($request->all());

        request()->validate([
            'email' => 'required|email|unique:users'
        ]);

        $user = new User();
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->user_type = 1;
        $user->keep_track = $request->password;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('admin.list')->with('success', 'Admin Successfully Created!');
    }


    public function edit($id)
    {
        $data['header_title'] = "Edit Admin";

        $user = User::findOrFail($id);

        ///TUTOR'S METHOD FOR FETCHING AND PASSING THE DETAILS TO THE EDIT VIEW FILE
        // $data['getRecord'] = User::getSingle($id);
        // if(!empty($data['getRecord']))
        // {
            
        //     return view('admin.admin.edit', $data,  );
        // }else{
        //     abort(404);
        // }


        return view('admin.admin.edit', $data, ['user' => $user]);
    }



    public function update(Request $request, $id)
    {
        request()->validate([
            'email' => 'required|email|unique:users,email,'.$id
        ]);


        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if(!empty($request->password))
        {
            $user->keep_track = $request->password;
            $user->password = Hash::make($request->password);
        }
        $user->save();
        

        return redirect()->route('admin.list')->with('success', 'Admin Details Successfully Updated!');
    }


    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        // $user->is_delete = 1;
        // $user->save();
        return redirect()->route('admin.list')->with('warning', 'Admin Deleted Successfully!');
    }



}
