<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Request;

class Exam extends Model
{
    use HasFactory, SoftDeletes;



    static public function getSingle($id)
    {
        return self::findOrFail($id);
    }

    static public function getRecord()
    {
        $return = self::select('exams.*', 'users.name as created_by')
                ->join('users', 'users.id', '=', 'exams.created_by');

                if(!empty(Request::get('name')))
                {
                    $return = $return->where('exams.name', 'like', '%'.Request::get('name').'%');
                }

                if(!empty(Request::get('date')))
                {
                    $return = $return->whereDate('exams.created_at', '=', Request::get('date'));
                }
                
                $return = $return->orderBy('exams.id', 'desc')
                ->paginate(50);

        return $return;
    }


    static public function getExam()
    {
        $return = self::select('exams.*')
                ->join('users', 'users.id', '=', 'exams.created_by')                
                ->orderBy('exams.name', 'asc')
                ->get();

        return $return;
    }


}
