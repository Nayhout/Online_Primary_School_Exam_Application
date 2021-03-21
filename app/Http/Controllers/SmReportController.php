<?php

namespace App\Http\Controllers;
use App\SmExam;
use App\SmClass;
use App\SmSection;
use App\SmStudent;
use App\SmSubject;
use App\SmTemporaryMeritlist;
use App\YearCheck;
use App\SmExamType;
use App\SmExamSetup;
use App\SmMarkStore;
use App\SmMarksGrade;
use App\ApiBaseMethod;
use App\SmResultStore;
use App\SmAssignSubject;
use Illuminate\Http\Request;
use App\SmClassOptionalSubject;
use App\SmOptionalSubjectAssign;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SmReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('PM');
    }

    public function tabulationSheetReport(Request $request)
    {
        try{
            $exam_types = SmExamType::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['exam_types'] = $exam_types->toArray();
                $data['classes'] = $classes->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.reports.tabulation_sheet_report', compact('exam_types', 'classes'));
        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back(); 
        }
    }

    public function tabulationSheetReportSearch(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'exam' => 'required',
            'class' => 'required',
            'section' => 'required'
        ]);

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try{
        $exam_term_id   = $request->exam;
        $class_id       = $request->class;
        $section_id     = $request->section;
        $student_id     = $request->student;

        $optional_subject_setup=SmClassOptionalSubject::where('class_id','=',$request->class)->first();
        // return $optional_subject_setup;
        if ($request->student == "") {
            $eligible_subjects       = SmAssignSubject::where('class_id', $class_id)->where('section_id', $section_id)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
            $eligible_students       = SmStudent::where('class_id', $class_id)->where('section_id', $section_id)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
            foreach ($eligible_students as $SingleStudent) {
                foreach ($eligible_subjects as $subject) {


                    $getMark            =  SmResultStore::where([
                        ['exam_type_id',   $exam_term_id],
                        ['class_id',       $class_id],
                        ['section_id',     $section_id],
                        ['student_id',     $SingleStudent->id],
                        ['subject_id',     $subject->subject_id]
                    ])->first();


                    if ($getMark == "") {
                        Toastr::error('Please register marks for all students.!', 'Failed');
                        return redirect()->back();
                        // return redirect()->back()->with('message-danger', 'Please register marks for all students.!');
                    }
                }
            }
        } else {

            $eligible_subjects       = SmAssignSubject::where('class_id', $class_id)->where('section_id', $section_id)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();

            foreach ($eligible_subjects as $subject) {


                $getMark            =  SmResultStore::where([
                    ['exam_type_id',   $exam_term_id],
                    ['class_id',       $class_id],
                    ['section_id',     $section_id],
                    ['student_id',     $request->student],
                    ['subject_id',     $subject->subject_id]
                ])->first();


                if ($getMark == "") {
                    Toastr::error('Please register marks for all students.!', 'Failed');
                    return redirect()->back();
                    // return redirect()->back()->with('message-danger', 'Please register marks for all students.!');
                }
            }
        }


        if ($request->student!='') {
            $marks      = SmMarkStore::where([
                ['exam_term_id', $request->exam],
                ['class_id', $request->class],
                ['section_id', $request->section],
                ['student_id', $request->student]
            ])->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
            $students   = SmStudent::where([
                ['class_id', $request->class],
                ['section_id', $request->section],
                ['id', $request->student]
            ])->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();

            $subjects       = SmAssignSubject::where([
                ['class_id', $request->class],
                ['section_id', $request->section]
            ])->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
            foreach ($subjects as $sub) {
                $subject_list_name[] = $sub->subject->subject_name;
            }
            $grade_chart = SmMarksGrade::select('grade_name', 'gpa', 'percent_from as start', 'percent_upto as end', 'description')->where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->get()->toArray();

            $single_student = SmStudent::find($request->student);
            $single_exam_term = SmExamType::find($request->exam);

            $tabulation_details['student_name'] = $single_student->full_name;
            $tabulation_details['student_roll'] = $single_student->roll_no;
            $tabulation_details['student_admission_no'] = $single_student->admission_no;
            $tabulation_details['student_class'] = $single_student->ClassName->class_name;
            $tabulation_details['student_section'] = $single_student->section->section_name;
            $tabulation_details['exam_term'] = $single_exam_term->title;
            $tabulation_details['subject_list'] = $subject_list_name;
            $tabulation_details['grade_chart'] = $grade_chart;
        } else {
            $marks = SmMarkStore::where([
                ['exam_term_id', $request->exam],
                ['class_id', $request->class],
                ['section_id', $request->section]
            ])->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
            $students       = SmStudent::where([
                ['class_id', $request->class],
                ['section_id', $request->section]
            ])->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
        }


        $exam_types     = SmExamType::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
        $classes        = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
        $single_class   = SmClass::find($request->class);
        $single_section   = SmSection::find($request->section);
        $subjects       = SmAssignSubject::where([
            ['class_id', $request->class],
            ['section_id', $request->section]
        ])->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();


        foreach ($subjects as $sub) {
            $subject_list_name[] = $sub->subject->subject_name;
        }
        $grade_chart = SmMarksGrade::select('grade_name', 'gpa', 'percent_from as start', 'percent_upto as end', 'description')->where('active_status', 1)->get()->toArray();

        $single_exam_term = SmExamType::find($request->exam);

        $tabulation_details['student_class'] = $single_class->class_name;
        $tabulation_details['student_section'] = $single_section->section_name;
        $tabulation_details['exam_term'] = $single_exam_term->title;
        $tabulation_details['subject_list'] = $subject_list_name;
        $tabulation_details['grade_chart'] = $grade_chart;

        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
            $data = [];
            $data['exam_types'] = $exam_types->toArray();
            $data['classes'] = $classes->toArray();
            $data['marks'] = $marks->toArray();
            $data['subjects'] = $subjects->toArray();
            $data['exam_term_id'] = $exam_term_id;
            $data['class_id'] = $class_id;
            $data['section_id'] = $section_id;
            $data['students'] = $students->toArray();
            return ApiBaseMethod::sendResponse($data, null);
        }
        $get_class = SmClass::where('active_status', 1)
            ->where('id', $request->class)
            ->first();
        $get_section = SmSection::where('active_status', 1)
            ->where('id', $request->section)
            ->first();
        $class_name = $get_class->class_name;
        $section_name = $get_section->section_name;
        return view('backEnd.reports.tabulation_sheet_report',compact('optional_subject_setup','exam_types', 'classes', 'marks', 'subjects', 'exam_term_id', 'class_id', 'section_id', 'class_name', 'section_name', 'students', 'student_id', 'tabulation_details')
        );
    }catch (\Exception $e) {
        Toastr::error('Operation Failed', 'Failed');
        return redirect()->back(); 
        }
    }

    //tabulationSheetReportPrint
    public function tabulationSheetReportPrint(Request $request)
    {
        try{
        $exam_term_id   = $request->exam_term_id;
        $class_id       = $request->class_id;
        $section_id     = $request->section_id;
        $student_id     = $request->student_id;

        $single_class   = SmClass::find($request->class_id);
        $single_section   = SmSection::find($request->section_id);
        $single_exam_term = SmExamType::find($request->exam_term_id);
        $subject_list_name = [];

        $subjects       = SmAssignSubject::where([
            ['class_id', $request->class_id],
            ['section_id', $request->section_id]
        ])->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
        $optional_subject_setup=SmClassOptionalSubject::where('class_id','=',$request->class_id)->first();

        if (!empty($request->student_id)) {


            $marks      = SmMarkStore::where([
                ['exam_term_id',    $request->exam_term_id],
                ['class_id',        $request->class_id],
                ['section_id',      $request->section_id],
                ['student_id',      $request->student_id]
            ])->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
            $students   = SmStudent::where([
                ['class_id',    $request->class_id],
                ['section_id',  $request->section_id],
                ['id',          $request->student_id]
            ])->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();


            foreach ($subjects as $sub) {
                $subject_list_name[] = $sub->subject->subject_name;
            }
            $grade_chart = SmMarksGrade::select('grade_name', 'gpa', 'percent_from as start', 'percent_upto as end', 'description')->where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->get()->toArray();

            $single_student = SmStudent::find($request->student_id);

            $single_exam_term = SmExamType::find($request->exam_term_id);

            $tabulation_details['student_name'] = $single_student->full_name;
            $tabulation_details['student_roll'] = $single_student->roll_no;
            $tabulation_details['student_admission_no'] = $single_student->admission_no;
            $tabulation_details['student_class'] = $single_student->ClassName->class_name;
            $tabulation_details['student_section'] = $single_student->section->section_name;
            $tabulation_details['exam_term'] = $single_exam_term->title;
            $tabulation_details['subject_list'] = $subject_list_name;
            $tabulation_details['grade_chart'] = $grade_chart;
        } else {
            $marks = SmMarkStore::where([
                ['exam_term_id', $request->exam_term_id],
                ['class_id', $request->class_id],
                ['section_id', $request->section_id]
            ])->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
            $students       = SmStudent::where([
                ['class_id', $request->class_id],
                ['section_id', $request->section_id]
            ])->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
        }


        $exam_types     = SmExamType::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
        $classes        = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();

        foreach ($subjects as $sub) {
            $subject_list_name[] = $sub->subject->subject_name;
        }
        $grade_chart = SmMarksGrade::select('grade_name', 'gpa', 'percent_from as start', 'percent_upto as end', 'description')->where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->get()->toArray();

        $tabulation_details['student_class'] = $single_class->class_name;
        $tabulation_details['student_section'] = $single_section->section_name;
        $tabulation_details['exam_term'] = $single_exam_term->title;
        $tabulation_details['subject_list'] = $subject_list_name;
        $tabulation_details['grade_chart'] = $grade_chart;


        $get_class = SmClass::where('active_status', 1)
            ->where('id', $request->class_id)
            ->first();
        $get_section = SmSection::where('active_status', 1)
            ->where('id', $request->section_id)
            ->first();
        $class_name = $get_class->class_name;
        $section_name = $get_section->section_name;
        
        $customPaper = array(0, 0, 700.00, 1500.80);

        // return view('backEnd.reports.tabulation_sheet_report_print',compact('optional_subject_setup','exam_types', 'classes', 'marks', 'subjects', 'exam_term_id', 'class_id', 'section_id', 'class_name', 'section_name', 'students', 'student_id', 'tabulation_details'));
       

        $pdf = PDF::loadView(
            'backEnd.reports.tabulation_sheet_report_print',
            [
                'exam_types'    => $exam_types,
                'classes'       => $classes,
                'marks'         => $marks,
                'class_id'      => $class_id,
                'section_id'    => $section_id,
                'exam_term_id'  => $exam_term_id,
                'subjects'      => $subjects,
                'class_name'    => $class_name,
                'section_name'  => $section_name,
                'students'      => $students,
                'student_id'    => $student_id,
                'tabulation_details' => $tabulation_details,
                'optional_subject_setup' => $optional_subject_setup,
            ]
        )->setPaper('A4', 'landscape');
        return $pdf->stream('tabulationSheetReportPrint.pdf');
        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back(); 
        }
    }


    public function progressCardReport(Request $request)
    {
        try{
        $exams = SmExam::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
        $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();

        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
            $data = [];
            $data['routes'] = $exams->toArray();
            $data['assign_vehicles'] = $classes->toArray();
            return ApiBaseMethod::sendResponse($data, null);
        }

        return view('backEnd.reports.progress_card_report', compact('exams', 'classes'));
        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back(); 
        }
    }


    //student progress report search by rashed
    public function progressCardReportSearch(Request $request)
    {

        //input validations, 3 input must be required
        $input = $request->all();
        $validator = Validator::make($input, [
            'class' => 'required',
            'section' => 'required',
            'student' => 'required'
        ]);

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try{
        $exams = SmExam::where('active_status', 1)->where('class_id', $request->class)->where('section_id', $request->section)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();

        $exam_types = SmExamType::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
        $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
        //$studentDetails = SmStudent::find($request->student);

        $studentDetails = SmStudent::where('sm_students.id', '=', $request->student)
            ->join('sm_academic_years', 'sm_academic_years.id', '=', 'sm_students.session_id')
            ->join('sm_classes', 'sm_classes.id', '=', 'sm_students.class_id')
            ->join('sm_sections', 'sm_sections.id', '=', 'sm_students.section_id')
            ->first();

            $optional_subject_setup=SmClassOptionalSubject::where('class_id','=',$request->class)->first(); 

            $student_optional_subject=SmOptionalSubjectAssign::where('student_id',$request->student)->where('session_id','=',$studentDetails->session_id)->first();
        // return $student_optional_subject;

        $exam_setup = SmExamSetup::where([['class_id', $request->class], ['section_id', $request->section]])->where('school_id',Auth::user()->school_id)->get();

        $class_id = $request->class;
        $section_id = $request->section;
        $student_id = $request->student;

        $subjects = SmAssignSubject::where([['class_id', $request->class], ['section_id', $request->section]])->where('school_id',Auth::user()->school_id)->get();
        $assinged_exam_types = [];
        foreach ($exams as $exam) {
            $assinged_exam_types[] = $exam->exam_type_id;
        }
        $assinged_exam_types = array_unique($assinged_exam_types);
        foreach ($assinged_exam_types as $assinged_exam_type) {
            foreach ($subjects as $subject) {
                $is_mark_available = SmResultStore::where([['class_id', $request->class], ['section_id', $request->section], ['student_id', $request->student], ['subject_id', $subject->subject_id], ['exam_type_id', $assinged_exam_type]])->first();
                // return $is_mark_available;
                if ($is_mark_available == "") {
                    Toastr::error('Ops! Your result is not found! Please check mark register.', 'Failed');
                    return redirect('progress-card-report');
                    // return redirect('progress-card-report')->with('message-danger', 'Ops! Your result is not found! Please check mark register.');
                }
            }
        }


        $is_result_available = SmResultStore::where([['class_id', $request->class], ['section_id', $request->section], ['student_id', $request->student]])->where('school_id',Auth::user()->school_id)->get();


        if ($is_result_available->count() > 0) {

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['exams'] = $exams->toArray();
                $data['classes'] = $classes->toArray();
                $data['studentDetails'] = $studentDetails;
                $data['is_result_available'] = $is_result_available;
                $data['subjects'] = $subjects->toArray();
                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;
                $data['student_id'] = $student_id;
                $data['exam_types'] = $exam_types;
                return ApiBaseMethod::sendResponse($data, null);
            }


            return view('backEnd.reports.progress_card_report', compact('exams','optional_subject_setup','student_optional_subject', 'classes', 'studentDetails', 'is_result_available', 'subjects', 'class_id', 'section_id', 'student_id', 'exam_types', 'assinged_exam_types'));
        } else {
            Toastr::error('Ops! Your result is not found! Please check mark register.', 'Failed');
            return redirect('progress-card-report');
            // return redirect('progress-card-report')->with('message-danger', 'Ops! Your result is not found! Please check mark register.');
        }

        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back(); 
        }
    }

    public function progressCardPrint(Request $request)
    {
       try{
        $exams = SmExam::where('active_status', 1)->where('class_id', $request->class_id)->where('section_id', $request->section_id)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
        $exam_types = SmExamType::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
        $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
        //$studentDetails = SmStudent::find($request->student);

        $student_detail = DB::table('sm_students')
            ->join('sm_sessions', 'sm_sessions.id', '=', 'sm_students.session_id')
            ->join('sm_classes', 'sm_classes.id', '=', 'sm_students.class_id')
            ->join('sm_sections', 'sm_sections.id', '=', 'sm_students.section_id')
            ->where('sm_students.id', '=', $request->student_id)
            ->first();
        //return $studentDetails;
        $exam_setup = SmExamSetup::where([['class_id', $request->class_id], ['section_id', $request->section_id]])->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
        $class_id = $request->class_id;
        $section_id = $request->section_id;
        $student_id = $request->student_id;
        $subjects = SmAssignSubject::where([['class_id', $request->class_id], ['section_id', $request->section_id]])->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
        $assinged_exam_types = [];
        foreach ($exams as $exam) {
            $assinged_exam_types[] = $exam->exam_type_id;
        }
        $assinged_exam_types = array_unique($assinged_exam_types);
        foreach ($assinged_exam_types as $assinged_exam_type) {
            foreach ($subjects as $subject) {
                $is_mark_available = SmResultStore::where([['class_id', $request->class_id], ['section_id', $request->section_id], ['student_id', $request->student_id], ['subject_id', $subject->subject_id], ['exam_type_id', $assinged_exam_type]])->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->first();

                if ($is_mark_available == "") {
                    Toastr::error('Ops! Your result is not found! Please check mark register.', 'Failed');
                    return redirect('progress-card-report');
                    // return redirect('progress-card-report')->with('message-danger', 'Ops! Your result is not found! Please check mark register.');
                }
            }
        }
        $is_result_available = SmResultStore::where([['class_id', $request->class_id], ['section_id', $request->section_id], ['student_id', $request->student_id]])->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
       
        $optional_subject_setup=SmClassOptionalSubject::where('class_id','=',$request->class_id)->first(); 

        $student_optional_subject=SmOptionalSubjectAssign::where('student_id',$request->student_id)->where('session_id','=',$student_detail->session_id)->first();
        //    return $student_optional_subject;
         return view('backEnd.reports.progress_card_report_print', compact('optional_subject_setup','student_optional_subject','exams', 'classes', 'student_detail', 'is_result_available', 'subjects', 'class_id', 'section_id', 'student_id', 'exam_types', 'assinged_exam_types'));
       
        $customPaper = array(0, 0, 700.00, 1500.80);

        $pdf = PDF::loadView(
            'backEnd.reports.progress_card_report_print',
            [
                'exams'    => $exams,
                'classes'       => $classes,
                'student_detail'         => $student_detail,
                'is_result_available'         => $is_result_available,
                'subjects'         => $subjects,
                'class_id'         => $class_id,
                'section_id'         => $section_id,
                'student_id'         => $student_id,
                'exam_types'         => $exam_types,
                'assinged_exam_types'         => $assinged_exam_types,
            ]
        )->setPaper($customPaper, 'landscape');
        // return $pdf->stream('progressCardReportPrint.pdf');

         // } else {
        //     return redirect('progress-card-report')->with('message-danger', 'Ops! Your result is not found! Please check mark register.');
        // }
        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back(); 
        }
    }

    public function StudentReExamReport(Request $request){
//        try{
            $exams = SmExamType::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['exams'] = $exams->toArray();
                $data['classes'] = $classes->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.reports.student_re_exam_report', compact('exams', 'classes'));
//        }catch (\Exception $e) {
//            Toastr::error('Operation Failed', 'Failed');
//            return redirect()->back();
//        }
    }
    public function StudentReExamReportSearch(Request $request)
    {
//        dd($request->all());
//        try{
            $iid = time();
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            if ($request->method() == 'POST') {
                //ur code here

                // $emptyResult = SmTemporaryMeritlist::truncate();
                $input = $request->all();
                $validator = Validator::make($input, [
                    'exam' => 'required',
                    'class' => 'required',
                    'section' => 'required'
                ]);

                if ($validator->fails()) {
                    if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                        return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
                    }
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }

                $InputClassId = $request->class;
                $InputExamId = $request->exam;
                $InputSectionId = $request->section;

                $class          = SmClass::find($InputClassId);
                $section        = SmSection::find($InputSectionId);
                $exam           = SmExamType::find($InputExamId);

                $optional_subject_setup=SmClassOptionalSubject::where('class_id','=',$request->class)->first();

                $is_data = DB::table('sm_mark_stores')->where([['class_id', $InputClassId], ['section_id', $InputSectionId], ['exam_term_id', $InputExamId]])->first();
                //    dd( $is_data);
                if (empty($is_data)) {
                    Toastr::error('Your result is not found!', 'Failed');
                    return redirect()->back();
                    // return redirect()->back()->with('message-danger', 'Your result is not found!');
                }

                $exams = SmExamType::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
                $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();



                $subjects = SmSubject::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
                $assign_subjects = SmAssignSubject::where('class_id', $class->id)->where('section_id', $section->id)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
                $class_name = $class->class_name;


                $exam_name = $exam->title;

                $eligible_subjects       = SmAssignSubject::where('class_id', $InputClassId)->where('section_id', $InputSectionId)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
                $eligible_students       = SmStudent::where('class_id', $InputClassId)->where('section_id', $InputSectionId)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
                $eligible_grades         = SmMarksGrade::where('active_status',1)->get();

                //all subject list in a specific class/section
                $subject_ids        = [];
                $subject_strings    = '';
                $grade_ids          = [];
                $grade_strings      = '';
                $subject_id_strings = '';
                $marks_string       = '';

                foreach ($eligible_students as $SingleStudent) {
//                    dd($SingleStudent);
                    if ($SingleStudent->id){
                        //dd('afae');
                        foreach ($eligible_subjects as $subject) {
                            $subject_ids[]      = $subject->subject_id;
                            $subject_strings    = (empty($subject_strings)) ? $subject->subject->subject_name : $subject_strings . ',' . $subject->subject->subject_name;
                            $subject_id_strings    = (empty($subject_id_strings)) ? $subject->subject_id : $subject_id_strings . ',' . $subject->subject_id;
                            $getMark            =  SmResultStore::where([
                                ['exam_type_id',   $InputExamId],
                                ['class_id',       $InputClassId],
                                ['section_id',     $InputSectionId],
                                ['student_id',     $SingleStudent->id],
                                ['subject_id',     $subject->subject_id]
                            ])->first();

//                        if ($getMark == "") {
//                            Toastr::error('Please register marks for all students.!', 'Failed');
//                            return redirect()->back();
//                            // return redirect()->back()->with('message-danger', 'Please register marks for all students.!');
//                        }

                            // if (empty($getMark->total_marks)) {
                            //     $FinalMarks = 0;
                            // } else {
                            //     $FinalMarks = $getMark->total_marks;
                            // }

                            if ($marks_string == "") {
                                if ($getMark->total_marks == 0) {
                                    $marks_string = '0';

                                } else {
                                    $marks_string = $getMark->total_marks;
                                }
                            }
                            else {
                                $marks_string = $marks_string . ',' . optional($getMark)->total_marks;
                            }

                            if ($grade_strings == "") {
                                if ($getMark->total_gpa_grade == '') {
                                    $grade_strings = '';

                                } else {
                                    $grade_strings = $getMark->total_gpa_grade;
                                }
                            } else {
                                $grade_strings = $grade_strings . ',' . optional($getMark)->total_gpa_grade;
                            }



                            // dd($marks_string,$getMark->total_marks);

                        }




                    //end subject list for specific section/class

                    $results                =  SmResultStore::where([
                        ['exam_type_id',   $InputExamId],
                        ['class_id',       $InputClassId],
                        ['section_id',     $InputSectionId],
                        ['student_id',     $SingleStudent->id]
                    ])->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
                    $is_absent                =  SmResultStore::where([
                        ['exam_type_id',   $InputExamId],
                        ['class_id',       $InputClassId],
                        ['section_id',     $InputSectionId],
                        ['is_absent',      1],
                        ['student_id',     $SingleStudent->id]
                    ])->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();

                    $total_gpa_point        =  SmResultStore::where([
                        ['exam_type_id',   $InputExamId],
                        ['class_id',       $InputClassId],
                        ['section_id',     $InputSectionId],
                        ['student_id',     $SingleStudent->id]
                    ])->sum('total_gpa_point');

                    $total_marks            =  SmResultStore::where([
                        ['exam_type_id',   $InputExamId],
                        ['class_id',       $InputClassId],
                        ['section_id',     $InputSectionId],
                        ['student_id',     $SingleStudent->id]
                    ])->sum('total_marks');




                    $dat= array();
                    $sum_of_mark = $total_marks;
                    $average_mark = floor($total_marks / $results->count()); //get average number
                    $is_absent = (count($is_absent) > 0) ? 1 : 0;         //get is absent ? 1=Absent, 0=Present
                    foreach ($results as $key => $gpa_result) {
                        $da = DB::table('sm_optional_subject_assigns')->where(['student_id'=>$gpa_result->student_id,'subject_id'=>$gpa_result->subject_id])->count();
                        if ($da < 1) {
                            $grade_gpa = DB::table('sm_marks_grades')->where('percent_from','<=',$gpa_result->total_marks)->where('percent_upto','>=',$gpa_result->total_marks)->first();
                            if ($grade_gpa->grade_name == 'F') {
                                array_push($dat,$grade_gpa->gpa);
                            }
                        }
                    }
                    //dd($results,$dat);
                    if ( !empty($dat)) {
                        $exart_gp_point = $dat['0'];
                    }else {
                        $total_GPA = ($total_gpa_point == 0) ? 0 : $total_gpa_point / $results->count();
                        $exart_gp_point = number_format($total_GPA, 2, '.', '');
                        //get gpa results
                    }
                    $full_name          =   $SingleStudent->full_name;                 //get name
                    $admission_no       =   $SingleStudent->admission_no;           //get admission no
                    $student_id       =   $SingleStudent->id;           //get admission no


                        SmTemporaryMeritlist::where([['admission_no', $admission_no], ['class_id', $InputClassId], ['section_id', $InputSectionId], ['exam_id', $InputExamId]])->delete();

                        $is_existing_data = SmTemporaryMeritlist::where([['admission_no', $admission_no], ['class_id', $InputClassId], ['section_id', $InputSectionId], ['exam_id', $InputExamId]])->first();

                    // return $is_existing_data;
                    if (empty($is_existing_data)) {
                        $insert_results                     = new SmTemporaryMeritlist();
                    } else {
                        $insert_results                     = SmTemporaryMeritlist::find($is_existing_data->id);
                    }
                    // $insert_results                     = new SmTemporaryMeritlist();
                    $insert_results->student_name       = $full_name;
                    $insert_results->admission_no       = $admission_no;
                    $insert_results->subjects_id_string    =implode(',',array_unique($subject_ids));
                    $insert_results->subjects_string    = $subject_strings;
                    $insert_results->grades_id_string   =implode(',',array_unique($grade_ids));
                    $insert_results->grades_string      = $grade_strings;
                    $insert_results->marks_string       = $marks_string;
                    $insert_results->total_marks        = $sum_of_mark;
                    $insert_results->average_mark       = $average_mark;
                    $insert_results->gpa_point          = $exart_gp_point;
                    $insert_results->iid          = $iid;
                    $insert_results->student_id          = $SingleStudent->id;

//                    dd($average_mark,$exart_gp_point);
                    $exart_gp_point = number_format($average_mark, 2, '.', '');

                    $markGrades = SmMarksGrade::where([['percent_from', '<=', $exart_gp_point], ['percent_upto', '>=', $exart_gp_point]])->where('school_id',Auth::user()->school_id)->first();

                   // dd($markGrades,$exart_gp_point);
//                        dd($is_absent);
//                    if ($is_absent == "") {
                        $insert_results->result             = $markGrades->grade_name;
//                    } else {
//                        $insert_results->result             = 'F';
//                    }
                    $insert_results->section_id         = $InputSectionId;
                    $insert_results->class_id           = $InputClassId;
                    $insert_results->exam_id            = $InputExamId;
                    $insert_results->created_at = YearCheck::getYear() . '-' . date('m-d h:i:s');
                    $insert_results->school_id = Auth::user()->school_id;
                    $insert_results->save();




                    $subject_strings = "";
                    $marks_string = "";
                    $total_marks = 0;
                    $average = 0;
                    $exart_gp_point = 0;
                    $admission_no = 0;
                    $full_name = "";
                    $grade_strings = "";

//                        dd($total_marks,$results->count(),$SingleStudent);

                    }
                } //end loop eligible_students

                // return implode(',',array_unique($subject_ids));

                $first_data = SmTemporaryMeritlist::where('iid', $iid)->first();

                $subjectlist = explode(',', $first_data->subjects_string);
//                $gradeslist = explode(',', $first_data->grades_string);
                $allresult_data = SmTemporaryMeritlist::where('iid', $iid)->orderBy('gpa_point', 'desc')->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
                // return  $allresult_data;
                $merit_serial = 1;
                foreach ($allresult_data as $row) {
                    $D = SmTemporaryMeritlist::where('iid', $iid)->where('id', $row->id)->first();
                    $D->merit_order = $merit_serial++;
                    $D->save();

                }
                $types = $request->types;
                if ($types == 'Pass') {
                    $allresult_data = SmTemporaryMeritlist::orderBy('merit_order', 'asc')
                        ->where('exam_id', '=', $InputExamId)->where('result', '<>', 'F')
                        ->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')
                        ->where('school_id', Auth::user()->school_id)
                        ->get();
                }
                elseif ($types == 'Failed'){
                    $allresult_data = SmTemporaryMeritlist::orderBy('merit_order', 'asc')
                        ->where('exam_id', '=', $InputExamId)->where('result', '=', 'F')
                        ->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')
                        ->where('school_id', Auth::user()->school_id)
                        ->get();
                }elseif ($types == 'Re-study'){
                    $allresult_data = SmTemporaryMeritlist::orderBy('merit_order', 'asc')
                        ->where('exam_id', '=', $InputExamId)->where('result', 'Like','%' .'F'.'%')
                        ->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')
                        ->where('school_id', Auth::user()->school_id)
                        ->get();
                }elseif ($types == 'Re-exam'){
                    $allresult_data = SmTemporaryMeritlist::orderBy('merit_order', 'asc')
                        ->where('exam_id', '=', $InputExamId)->where('grades_string', 'Like','%' .'F'.'%')
                        ->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')
                        ->where('school_id', Auth::user()->school_id)
                        ->get();
                }
                else{
                    $allresult_data = SmTemporaryMeritlist::orderBy('merit_order', 'asc')->where('exam_id','=',$InputExamId)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();

                }


                if (ApiBaseMethod::checkUrl($request->fullUrl())) {

                    $data = [];
                    $data['exams'] = $exams->toArray();
                    $data['classes'] = $classes->toArray();
                    $data['subjects'] = $subjects->toArray();
                    $data['class'] = $class;
                    $data['section'] = $section;
                    $data['exam'] = $exam;
                    $data['subjectlist'] = $subjectlist;
                    $data['gradeslist'] = $gradeslist;
                    $data['allresult_data'] = $allresult_data;
                    $data['class_name'] = $class_name;
                    $data['assign_subjects'] = $assign_subjects;
                    $data['exam_name'] = $exam_name;


                    return ApiBaseMethod::sendResponse($data, null);
                }

//                if ($optional_subject_setup=='') {
//                    return view('backEnd.reports.merit_list_report_normal', compact('iid', 'exams', 'classes', 'subjects', 'class', 'section', 'exam', 'subjectlist', 'allresult_data', 'class_name', 'assign_subjects', 'exam_name', 'InputClassId', 'InputExamId', 'InputSectionId','optional_subject_setup'));
//                } else {
                    return view('backEnd.reports.student_re_exam_report', compact('iid', 'exams', 'classes', 'subjects', 'class', 'section', 'exam', 'subjectlist', 'allresult_data', 'class_name', 'assign_subjects', 'exam_name', 'InputClassId', 'InputExamId', 'InputSectionId','optional_subject_setup'));

                }
//            }
//        }catch (\Exception $e) {
//            // dd($e);
//            Toastr::error('Operation Failed', 'Failed');
//            return redirect()->back();
//        }
    }
}
