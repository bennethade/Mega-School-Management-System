<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Subject extends Model
{
    use HasFactory;

    protected $table = "subjects";


    static public function getRecord()
    {
        $return = Subject::select('subjects.*', 'users.name as created_by_name')
                    ->join('users', 'users.id', 'subjects.created_by');


                    //SEARCH FEATURE STARTS
                    if(!empty(Request::get('name')))
                    {
                        $return = $return->where('subjects.name', 'like', '%' . Request::get('name') . '%');
                    }

                    if(!empty(Request::get('type')))
                    {
                        $return = $return->where('subjects.type', '=', Request::get('type'));
                    }

                    if(!empty(Request::get('date')))
                    {
                        $return = $return->whereDate('subjects.created_at', '=', Request::get('date'));
                    }
                    //SEARCH FEATURE ENDS


        $return = $return->where('subjects.is_delete', '=' ,0)
                    ->orderBy('subjects.id', 'asc')
                    ->paginate(20);

        return $return;
    }


    static public function getSingle($id)
    {
        return self::findOrFail($id);
    }


    
}
