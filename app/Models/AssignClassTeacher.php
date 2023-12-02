<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class AssignClassTeacher extends Model
{
    use HasFactory;


    static public function getSingle($id)
    {
        return self::findOrFail($id);
    }


    static public function getRecord()
    {
        $return = self::select('assign_class_teachers.*', 'classes.name as class_name', 'teacher.name as teacher_name', 'users.name as created_by_name')
                    ->join('users as teacher', 'teacher.id', '=', 'assign_class_teachers.teacher_id')
                    ->join('classes', 'classes.id', '=', 'assign_class_teachers.class_id')
                    ->join('users', 'users.id', '=', 'assign_class_teachers.created_by')
                    ->where('assign_class_teachers.is_delete', '=' ,0);

                    if(!empty(Request::get('class_name')))
                    {
                        $return = $return->where('classes.name', 'like', '%' . Request::get('class_name') . '%');
                    }

                    if(!empty(Request::get('teacher_name')))
                    {
                        $return = $return->where('teacher.name', 'like', '%' . Request::get('teacher_name') . '%');
                    }

                    if(!empty(Request::get('status')))
                    {
                        $status = (Request::get('status') == 100) ? 0 :1;
                        $return = $return->where('assign_class_teachers.status', '=', $status);
                    }

                    if(!empty(Request::get('date')))
                    {
                        $return = $return->whereDate('assign_class_teachers.created_at', '=', Request::get('date'));
                    }

        $return = $return->orderBy('assign_class_teachers.class_id', 'asc')
                    ->paginate(100);

        return $return;
    }



    static public function getMyClassSubject($teacher_id)
    {
        return self::select('assign_class_teachers.*', 'classes.name as class_name', 'subjects.name as subject_name', 'subjects.type as subject_type', 'classes.id as class_id', 'subjects.id as subject_id')
                    ->join('classes', 'classes.id', '=', 'assign_class_teachers.class_id')
                    ->join('class_subjects', 'class_subjects.class_id', '=', 'classes.id')
                    ->join('subjects', 'subjects.id', '=', 'class_subjects.subject_id')
                    ->where('assign_class_teachers.is_delete', '=' ,0)
                    ->where('assign_class_teachers.status', '=' ,0)
                    ->where('subjects.status', '=' ,0)
                    ->where('class_subjects.status', '=' ,0)
                    ->where('assign_class_teachers.teacher_id', '=', $teacher_id)
                    ->get();

    }


    static public function getAlreadyFirst($class_id, $teacher_id)
    {
        return self::where('class_id', $class_id)->where('teacher_id', $teacher_id)->first();
    }


    static public function getAssignTeacherId($class_id)
    {
        return self::where('class_id', $class_id)->where('is_delete',0)->get();
    }


    static public function deleteTeacher($teacher_id)
    {
        return self::where('teacher_id', $teacher_id)->delete();
    }



    static public function getMyTimetable($class_id, $subject_id)
    {
        $getWeek = Week::getWeekUsingName(date('l'));

        return ClassSubjectTimetable::getRecordClassSubject($class_id, $subject_id, $getWeek->id);
    }





}
