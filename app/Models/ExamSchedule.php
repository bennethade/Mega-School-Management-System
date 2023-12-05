<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class ExamSchedule extends Model
{
    // use HasFactory, SoftDeletes;

    static public function getRecordSingle($exam_id, $class_id, $subject_id)
    {
        return self::where('exam_id', '=', $exam_id)->where('class_id', '=', $class_id)->where('subject_id', '=', $subject_id)->first();
    }


    static public function deleteRecord($exam_id, $class_id)
    {
        ExamSchedule::where('exam_id', '=', $exam_id)->where('class_id', '=', $class_id)->delete();
    }




    static public function getExam($class_id)
    {
        return ExamSchedule::select('exam_schedules.*', 'exams.name as exam_name')
                ->join('exams', 'exams.id', '=', 'exam_schedules.exam_id')
                ->where('exam_schedules.class_id', '=', $class_id)
                ->groupBy('exam_schedules.exam_id')
                ->orderBy('exam_schedules.id', 'desc')
                ->get();
    }




    
    static public function getExamTimetable($exam_id, $class_id)
    {
        return ExamSchedule::select('exam_schedules.*', 'subjects.name as subject_name', 'subjects.type as subject_type')
                ->join('subjects', 'subjects.id', '=', 'exam_schedules.subject_id')
                ->where('exam_schedules.exam_id', '=', $exam_id)
                ->where('exam_schedules.class_id', '=', $class_id)
                ->get();
    
    }







}
