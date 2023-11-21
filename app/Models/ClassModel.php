<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = "classes";


    static public function getSingle($id)
    {
        return self::findOrFail($id);
    }


    static public function getRecord()
    {
        $return = ClassModel::select('classes.*', 'users.name as created_by_name')
                    ->join('users', 'users.id', 'classes.created_by');


                    //SEARCH FEATURE STARTS
                    if(!empty(Request::get('name')))
                    {
                        $return = $return->where('classes.name', 'like', '%' . Request::get('name') . '%');
                    }

                    if(!empty(Request::get('date')))
                    {
                        $return = $return->whereDate('classes.created_at', '=', Request::get('date'));
                    }
                    //SEARCH FEATURE ENDS


        $return = $return->where('classes.is_delete', '=' ,0)
                    ->orderBy('classes.id', 'asc')
                    ->paginate(20);

        return $return;
    }



}
