<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacher;
use App\Models\ClassModel;
use App\Models\ClassSubject;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExaminationsController extends Controller
{
    public function examList()
    {
        $data['getRecord'] = Exam::getRecord();

        $data['header_title'] = "Exam List";
        return view('admin.examinations.exam.list', $data);
    }



    public function examAdd()
    {
        $data['header_title'] = "Add New Exam";
        return view('admin.examinations.exam.add', $data);
    }


    public function examInsert(Request $request)
    {
        // dd($request->all());

        $exam = new Exam();
        $exam->name = trim($request->name);
        $exam->note = trim($request->note);
        $exam->created_by = Auth::user()->id;
        $exam->save();

        return redirect()->route('examinations.list')->with('success', 'Exam Successfully Created!');
    }


    public function examEdit($id)
    {
        $data['getRecord'] = Exam::getSingle($id);

        $data['header_title'] = "Edit Exam";
        return view('admin.examinations.exam.edit', $data);
    }



    public function examUpdate(Request $request, $id)
    {
        $exam = Exam::getSingle($id);
        $exam->name = trim($request->name);
        $exam->note = trim($request->note);
        $exam->save();

        return redirect()->route('examinations.list')->with('success', 'Exam Successfully Updated!');
    }





    public function examDelete($id)
    {
        $exam = Exam::getSingle($id);
        $exam->delete();

        return redirect()->back()->with('success', 'Exam Successfully Deleted!');
    }



    public function examSchedule(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getExam'] = Exam::getExam();

        $result = array();

        if(!empty($request->get('exam_id')) && !empty($request->get('class_id')))
        {
            $getSubject = ClassSubject::mySubject($request->get('class_id'));
            foreach($getSubject as $value)
            {
                $dataS = array();
                $dataS['subject_id'] = $value->subject_id;
                $dataS['class_id'] = $value->class_id;
                $dataS['subject_name'] = $value->subject_name;
                $dataS['subject_type'] = $value->subject_type;

                $examSchedule = ExamSchedule::getRecordSingle($request->get('exam_id'), $request->get('class_id'), $value->subject_id);
                if(!empty($examSchedule))
                {
                    $dataS['exam_date'] = $examSchedule->exam_date;
                    $dataS['start_time'] = $examSchedule->start_time;
                    $dataS['end_time'] = $examSchedule->end_time;
                    $dataS['room_number'] = $examSchedule->room_number;
                    $dataS['full_mark'] = $examSchedule->full_mark;
                    $dataS['pass_mark'] = $examSchedule->pass_mark;
                }
                else
                {
                    $dataS['exam_date'] = '';
                    $dataS['start_time'] = '';
                    $dataS['end_time'] = '';
                    $dataS['room_number'] = '';
                    $dataS['full_mark'] = '';
                    $dataS['pass_mark'] = '';
                }

                $result[] = $dataS;
            }
        }

        // dd($result); 
        $data['getRecord'] = $result;



        $data['header_title'] = "Exam Schedule";
        return view('admin.examinations.exam_schedule', $data);
    }


    public function examScheduleInsert(Request $request)
    {
        // dd($request->all());

        ExamSchedule::deleteRecord($request->exam_id, $request->class_id); 

        if(!empty($request->schedule))
        {
            foreach($request->schedule as $schedule)
            {
                // dd($schedule['subject_id']);

                if(!empty($schedule['subject_id']) && !empty($schedule['exam_date']) && !empty($schedule['start_time']) && !empty($schedule['end_time']) && !empty($schedule['room_number']) && !empty($schedule['full_mark']) && !empty($schedule['pass_mark']))
                {
                    $exam = new ExamSchedule;
                    $exam->exam_id = $request->exam_id;
                    $exam->class_id = $request->class_id;
                    $exam->subject_id = $schedule['subject_id'];
                    $exam->exam_date = $schedule['exam_date'];
                    $exam->start_time = $schedule['start_time'];
                    $exam->end_time = $schedule['end_time'];
                    $exam->room_number = $schedule['room_number'];
                    $exam->full_mark = $schedule['full_mark'];
                    $exam->pass_mark = $schedule['pass_mark'];
                    $exam->created_by = Auth::user()->id;
                    $exam->save();
                }
 
            }
        }

        return redirect()->back()->with('success', 'Exam Schedule Successfully Saved!');

    }





    // STUDENT SIDE
    public function myExamTimetable(Request $request)
    {
        $class_id = Auth::user()->class_id;
        $getExam = ExamSchedule::getExam($class_id);
        $result = array();
        foreach($getExam as $value)
        {
            $dataE = array();
            $dataE['name'] = $value->exam_name;
            $getExamTimetable = ExamSchedule::getExamTimetable($value->exam_id, $class_id);
            // dd($getExamTimetable);
            $resultS = array();
            foreach($getExamTimetable as $valueS)
            {
                $dataS = array();
                $dataS['subject_name'] = $valueS->subject_name;
                $dataS['exam_date'] = $valueS->exam_date;
                $dataS['start_time'] = $valueS->start_time;
                $dataS['end_time'] = $valueS->end_time;
                $dataS['room_number'] = $valueS->room_number;
                $dataS['full_mark'] = $valueS->full_mark;
                $dataS['pass_mark'] = $valueS->pass_mark;
                $resultS[] = $dataS;
            }

            $dataE['exam'] = $resultS;
            $result[] = $dataE;
        }

        // dd($result);

        $data['getRecord'] = $result;

        $data['header_title'] = "My Exam Timetable";
        return view('student.my_exam_timetable', $data);
    }




    //TEACHER SIDE
    public function myExamTimetableTeacher()
    {
        $result = array();
        $getClass = AssignClassTeacher::getMyClassSubjectGroup(Auth::user()->id);
        // dd($getClass);
        foreach($getClass as $class)
        {
            $dataC = array();
            $dataC['class_name'] = $class->class_name;

            $getExam = ExamSchedule::getExam($class->class_id);
            $examArray = array();
            foreach($getExam as $exam)
            {
                $dataE = array();
                $dataE['exam_name'] = $exam->exam_name;

                $getExamTimetable = ExamSchedule::getExamTimetable($exam->exam_id, $class->class_id);
                $subjectArray = array();
                foreach($getExamTimetable as $valueS)
                {
                    $dataS = array();
                    $dataS['subject_name'] = $valueS->subject_name;
                    $dataS['exam_date'] = $valueS->exam_date;
                    $dataS['start_time'] = $valueS->start_time;
                    $dataS['end_time'] = $valueS->end_time;
                    $dataS['room_number'] = $valueS->room_number;
                    $dataS['full_mark'] = $valueS->full_mark;
                    $dataS['pass_mark'] = $valueS->pass_mark;
                    $subjectArray[] = $dataS;
                }
                
                $dataE['subject'] = $subjectArray;
                $examArray[] = $dataE;
            }
            $dataC['exam'] = $examArray; 

            $result[] = $dataC;
        }

        // dd($result);
        $data['getRecord'] = $result;

        $data['header_title'] = "My Exam Timetable";
        return view('teacher.my_exam_timetable', $data);
    }



    //PARENT SIDE
    public function parentMyExamTimetable($student_id)
    {
        $getStudent = User::getSingle($student_id);
        $class_id = $getStudent->class_id;
        $getExam = ExamSchedule::getExam($class_id);
        $result = array();
        foreach($getExam as $value)
        {
            $dataE = array();
            $dataE['name'] = $value->exam_name;
            $getExamTimetable = ExamSchedule::getExamTimetable($value->exam_id, $class_id);
            // dd($getExamTimetable);
            $resultS = array();
            foreach($getExamTimetable as $valueS)
            {
                $dataS = array();
                $dataS['subject_name'] = $valueS->subject_name;
                $dataS['exam_date'] = $valueS->exam_date;
                $dataS['start_time'] = $valueS->start_time;
                $dataS['end_time'] = $valueS->end_time;
                $dataS['room_number'] = $valueS->room_number;
                $dataS['full_mark'] = $valueS->full_mark;
                $dataS['pass_mark'] = $valueS->pass_mark;
                $resultS[] = $dataS;
            }

            $dataE['exam'] = $resultS;
            $result[] = $dataE;
        }

        // dd($result);

        $data['getRecord'] = $result;
        $data['getStudent'] = $getStudent;
        $data['header_title'] = "Exam Timetable";
        return view('parent.my_exam_timetable', $data);
    }




}
