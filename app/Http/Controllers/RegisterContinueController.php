<?php

namespace App\Http\Controllers;
use App\SmAssignSubject;
use App\SmClass;
use App\SmClassOptionalSubject;
use App\SmDegree;
use App\SmExamType;
use App\SmFaculty;
use App\SmMajor;
use App\SmMarksGrade;
use App\SmResultStore;
use App\SmSection;
use App\SmSemester;
use App\SmStudent;
use App\SmSubject;
use App\SmTemporaryMeritlist;
use App\SmWeekend;
use App\YearCheck;
use App\ApiBaseMethod;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RegisterContinueController extends Controller
{
    public function __construct()
    {
        $this->middleware('PM');
    }
    public function index(){
        return view('backEnd.admin.register_continue');
    }
    public function storeRegister(Request $request)
    {
        $students = SmStudent::where('active_status', 1)
            ->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')
            ->where('school_id', Auth::user()->school_id)
            ->first();
//        dd($students);
        return view('backEnd.admin.register',compact('students'));
    }
    public function storeRegisterSearch($id)
    {
       $students = SmStudent::find($id);
//        dd($students);
        return view('backEnd.admin.register',compact('students'));
    }


    public function ReStudy(Request $id){
        $results = SmTemporaryMeritlist::where('created_at','LIKE','%'.YearCheck::getYear().'%')
            ->where('school_id',Auth::user()->school_id)
            ->where('result','F')
            ->get();

        $total_male = SmTemporaryMeritlist::join('sm_students','sm_students.id','sm_temporary_meritlists.student_id')
            ->where('sm_temporary_meritlists.created_at','LIKE','%'.YearCheck::getYear().'%')
            ->where('sm_temporary_meritlists.school_id',Auth::user()->school_id)
            ->where('sm_temporary_meritlists.result','F')
            ->where('sm_students.gender_id',1)
            ->count();

        $total_female = SmTemporaryMeritlist::join('sm_students','sm_students.id','sm_temporary_meritlists.student_id')
            ->where('sm_temporary_meritlists.created_at','LIKE','%'.YearCheck::getYear().'%')
            ->where('sm_temporary_meritlists.school_id',Auth::user()->school_id)
            ->where('sm_temporary_meritlists.result','F')
            ->where('sm_students.gender_id',2)
            ->count();

        $total_other = SmTemporaryMeritlist::join('sm_students','sm_students.id','sm_temporary_meritlists.student_id')
            ->where('sm_temporary_meritlists.created_at','LIKE','%'.YearCheck::getYear().'%')
            ->where('sm_temporary_meritlists.school_id',Auth::user()->school_id)
            ->where('sm_temporary_meritlists.result','F')
            ->where('sm_students.gender_id',3)
            ->count();

        $totals = $total_male + $total_female + $total_other;


        return view('backEnd.reports.re-study' , compact('results','total_other','total_female','total_male','totals'));
    }
    public function ReExam(Request $request){


        return view('backEnd.reports.re-exam');
    }
    public function AssociateStaticDegreeForeign(Request $request){


        return view('backEnd.admin.associate_degree_static_foreign');
    }
    public function StaticDegreeForeign(Request $request){


        return view('backEnd.admin.degree_static_foreign');
    }
    public function AssociateDisabilityDegree(){


        return view('backEnd.admin.associate_disability_degree');
    }
    public function DisabilityDegree(){


        return view('backEnd.admin.degree_disability_statistics');
    }
    public function MasterDegreeDisability(){

        return view('backEnd.admin.disability_master_degree');
    }
    public function DoctorDegreeDisability(){


        return view('backEnd.admin.disability_doctor_degree');
    }
    public function GraduateAssociate(){

        return view('backEnd.admin.graduated_associate_degree');
    }
    public function GraduateDegree(){

        return view('backEnd.admin.graduated_degree');
    }
    public function GraduateMasterAssociate(){

        return view('backEnd.admin.graduated_master_degree');
    }
    public function GraduateDoctorDegree(){


        return view('backEnd.admin.graduated_doctor_degree');

    }

     public function DropoutAssociateDegree(){


        return view('backEnd.admin.dropout_associate_degree');
    }
    public function DropoutDegree(){


        return view('backEnd.admin.dropout_degree');
    }
    public function DropoutMasterDegree(){


        return view('backEnd.admin.dropout_master_degree');
    }
     public function DropoutDoctorDegree(){


        return view('backEnd.admin.dropout_doctor_degree');
    }
    public function OverlapDegree(){


        return view('backEnd.admin.overlap_degree');
    }
    public function OverlapMasterDegree(){


        return view('backEnd.admin.overlap_master_degree');
    }
    public function OverlapAssociateDegree(){


        return view('backEnd.admin.overlap_associate_degree');
    }
    public function OverlapDoctorDegree(){


        return view('backEnd.admin.overlap_doctor_degree');
    }
    public function AssociateAgeDegree(){


        return view('backEnd.admin.associate_age_degree');
    }
    public function MasterAgeDegree(){


        return view('backEnd.admin.master_age_degree');
    }
    public function DoctorAgeDegree(){


        return view('backEnd.admin.doctor_age_degree');
    }
    public function AgeDegree(){


        return view('backEnd.admin.age_degree');
    }
    public function MasterDegree(){


        return view('backEnd.admin.master_degree');
    }

    public function DoctorDegree(){


        return view('backEnd.admin.doctor_statistic_degree');
    }
    public function CountStaff(){

        return view('backEnd.humanResource.count_staff');
    }
    public function ListStaff(){

        return view('backEnd.humanResource.lists_staff');
    }
    public function ListNameStaff(){

        return view('backEnd.humanResource.lists_name_staff');
    }
    public function TrainingPermitLaw(){

        return view('backEnd.humanResource.training_permit_law');
    }
    public function Cooperation(){

        return view('backEnd.humanResource.cooperation');
    }
    public function PhysicalMaterial(){

        return view('backEnd.humanResource.physical_material');
    }

    public function StudentExamType(Request $request){

        //        try{
        $exams = SmExamType::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
        $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
        $faculties = SmFaculty::where('active_status',1)->get();
        $majors = SmMajor::where('active_status',1)->get();
        $degrees = SmDegree::where('active_status',1)->get();
        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
            $data = [];
            $data['exams'] = $exams->toArray();
            $data['classes'] = $classes->toArray();
            $data['faculties'] = $faculties->toArray();
            $data['degrees'] = $degrees->toArray();
            $data['majors'] = $majors->toArray();
            return ApiBaseMethod::sendResponse($data, null);
        }
        return view('backEnd.reports.student_exam_type_report', compact('exams', 'classes','faculties','majors','degrees'));
//        }catch (\Exception $e) {
//            Toastr::error('Operation Failed', 'Failed');
//            return redirect()->back();
//        }
    }
    public function StudentExamTypeSearch(Request $request)
    {
//        dd($request->all());
//        try{
//        $faculties = SmFaculty::where('active_status',1)->get();
//        $majors = SmMajor::where('active_status',1)->get();
//        $degrees = SmDegree::where('active_status',1)->get();
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
//            $InputFacultyId = $request->faculty;
//            $InputMajorId = $request->majors;
//            $InputDegreeId = $request->degree;
            $InputClassId = $request->class;
            $InputExamId = $request->exam;
            $InputSectionId = $request->section;
            $InputType = $request->types;

            $class          = SmClass::find($InputClassId);
            $section        = SmSection::find($InputSectionId);
            $exam           = SmExamType::find($InputExamId);
//            $faculty        = SmFaculty::find($InputFacultyId);
//            $majors         = SmMajor::find($InputMajorId);
//            $degrees        = SmDegree::find($InputDegreeId);

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
                    $insert_results->type               = $InputType;
//                    $insert_results->faculty            = $InputFacultyId;
//                    $insert_results->major              = $InputMajorId;
//                    $insert_results->degree             = $InputDegreeId;
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
            if ($types == 'Re-study'){
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
                $data['faculties'] = $faculty;
                $data['majors'] = $majors;
                $data['degrees'] = $degrees;
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
            return view('backEnd.reports.student_exam_type_report', compact('iid', 'exams', 'classes', 'subjects', 'class', 'section', 'exam', 'subjectlist', 'allresult_data', 'class_name', 'assign_subjects', 'exam_name', 'InputClassId', 'InputExamId', 'InputSectionId','InputType','optional_subject_setup','faculties','InputMajorId','InputDegreeId','InputFacultyId'));

        }
//            }
//        }catch (\Exception $e) {
//            // dd($e);
//            Toastr::error('Operation Failed', 'Failed');
//            return redirect()->back();
//        }
    }
    public function StudentExamTypePrint($exam_id, $class_id, $section_id, $type)
    {
        set_time_limit(2700);
        try{
            // $iid = time();
            // DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // $emptyResult = SmTemporaryMeritlist::truncate();
//dd($type);
            $InputClassId = $class_id;
            $InputExamId = $exam_id;
            $InputSectionId = $section_id;
            $InputType = $type;

            $allresult_data = SmTemporaryMeritlist::orderBy('gpa_point', 'desc')->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();

            if ($InputType == 'Re-study'){
                $allresult_data = SmTemporaryMeritlist::orderBy('merit_order', 'asc')
                    ->where('exam_id', '=', $InputExamId)->where('result', 'Like','%' .'F'.'%')
                    ->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')
                    ->where('school_id', Auth::user()->school_id)
                    ->get();
            }elseif ($InputType == 'Re-exam'){
                $allresult_data = SmTemporaryMeritlist::orderBy('merit_order', 'asc')
                    ->where('exam_id', '=', $InputExamId)->where('grades_string', 'Like','%' .'F'.'%')
                    ->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')
                    ->where('school_id', Auth::user()->school_id)
                    ->get();
            }


            $class          = SmClass::find($InputClassId);
            $section        = SmSection::find($InputSectionId);
            $exam           = SmExamType::find($InputExamId);

            // $is_data = DB::table('sm_mark_stores')->where([['class_id', $InputClassId], ['section_id', $InputSectionId], ['exam_term_id', $InputExamId]])->first();

            $exams = SmExamType::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
            $subjects = SmSubject::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
            $assign_subjects = SmAssignSubject::where('class_id', $class->id)->where('section_id', $section->id)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
            $class_name = $class->class_name;
            $exam_name = $exam->title;

            // $eligible_subjects       = SmAssignSubject::where('class_id', $InputClassId)->where('section_id', $InputSectionId)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
            // $eligible_students       = SmStudent::where('class_id', $InputClassId)->where('section_id', $InputSectionId)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();


            // //all subject list in a specific class/section
            // $subject_ids        = [];
            // $subject_strings    = '';
            // $subject_id_strings = '';
            // $marks_string       = '';
            // foreach ($eligible_students as $SingleStudent) {
            //     foreach ($eligible_subjects as $subject) {
            //         $subject_ids[]      = $subject->subject_id;
            //         $subject_strings    = (empty($subject_strings)) ? $subject->subject->subject_name : $subject_strings . ',' . $subject->subject->subject_name;
            //         $subject_id_strings    = (empty($subject_id_strings)) ? $subject->subject_id : $subject_id_strings . ',' . $subject->subject_id;
            //         $getMark            =  SmResultStore::where([
            //             ['exam_type_id',   $InputExamId],
            //             ['class_id',       $InputClassId],
            //             ['section_id',     $InputSectionId],
            //             ['student_id',     $SingleStudent->id],
            //             ['subject_id',     $subject->subject_id]
            //         ])->first();


            //         if ($marks_string == "") {
            //             if ($getMark->total_marks == 0) {
            //                 $marks_string = '0';
            //             } else {
            //                 $marks_string = $getMark->total_marks;
            //             }
            //         } else {
            //             $marks_string = $marks_string . ',' . $getMark->total_marks;
            //         }
            //     }
            //     //end subject list for specific section/class

            //     $results                =  SmResultStore::where([
            //         ['exam_type_id',   $InputExamId],
            //         ['class_id',       $InputClassId],
            //         ['section_id',     $InputSectionId],
            //         ['student_id',     $SingleStudent->id]
            //     ])->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();


            //     $is_absent                =  SmResultStore::where([
            //         ['exam_type_id',   $InputExamId],
            //         ['class_id',       $InputClassId],
            //         ['section_id',     $InputSectionId],
            //         ['is_absent',      1],
            //         ['student_id',     $SingleStudent->id]
            //     ])->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
            //     $total_gpa_point        =  SmResultStore::where([
            //         ['exam_type_id',   $InputExamId],
            //         ['class_id',       $InputClassId],
            //         ['section_id',     $InputSectionId],
            //         ['student_id',     $SingleStudent->id]
            //     ])->sum('total_gpa_point');
            //     $total_marks            =  SmResultStore::where([
            //         ['exam_type_id',   $InputExamId],
            //         ['class_id',       $InputClassId],
            //         ['section_id',     $InputSectionId],
            //         ['student_id',     $SingleStudent->id]
            //     ])->sum('total_marks');


            //     $sum_of_mark = ($total_marks == 0) ? 0 : $total_marks;
            //     $average_mark = ($total_marks == 0) ? 0 : floor($total_marks / $results->count()); //get average number
            //     $is_absent = (count($is_absent) > 0) ? 1 : 0;         //get is absent ? 1=Absent, 0=Present
            //     $total_GPA = ($total_gpa_point == 0) ? 0 : $total_gpa_point / $results->count();
            //     $exart_gp_point = number_format($total_GPA, 2, '.', '');            //get gpa results
            //     $full_name          =   $SingleStudent->full_name;                 //get name
            //     $admission_no       =   $SingleStudent->admission_no;           //get admission no


            //     $insert_results                     = new SmTemporaryMeritlist();
            //     $insert_results->student_name       = $full_name;
            //     $insert_results->admission_no       = $admission_no;
            //     $insert_results->subjects_string    = $subject_strings;
            //     $insert_results->marks_string       = $marks_string;
            //     $insert_results->total_marks        = $sum_of_mark;
            //     $insert_results->average_mark       = $average_mark;
            //     $insert_results->gpa_point          = $exart_gp_point;
            //     $insert_results->subjects_id_string    =implode(',',array_unique($subject_ids));
            //     $insert_results->student_id          = $SingleStudent->id;
            //     $insert_results->iid          = $iid;
            //     $markGrades = SmMarksGrade::where([['from', '<=', $exart_gp_point], ['up', '>=', $exart_gp_point]])->first();

            //     if ($is_absent == "") {
            //         $insert_results->result             = $markGrades->grade_name;
            //     } else {
            //         $insert_results->result             = 'F';
            //     }

            //     $insert_results->section_id         = $InputSectionId;
            //     $insert_results->class_id           = $InputClassId;
            //     $insert_results->exam_id            = $InputExamId;
            //     $insert_results->save();

            //     $subject_strings = "";
            //     $marks_string = "";
            //     $total_marks = 0;
            //     $average = 0;
            //     $exart_gp_point = 0;
            //     $admission_no = 0;
            //     $full_name = "";
            // } //end loop eligible_students
            $optional_subject_setup=SmClassOptionalSubject::where('class_id','=',$class_id)->first();
            // $first_data = SmTemporaryMeritlist::find(1);
            //$subjectlist = explode(',', $first_data->subjects_string);
            // $allresult_data = SmTemporaryMeritlist::orderBy('gpa_point', 'desc')->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
            // $merit_serial = 1;
            // foreach ($allresult_data as $row) {
            //     $D = SmTemporaryMeritlist::find($row->id);
            //     $D->merit_order = $merit_serial++;
            //     $D->save();
            // }
            if ($InputType == 'Re-study'){
            $total_male = SmTemporaryMeritlist::join('sm_students','sm_students.id','sm_temporary_meritlists.student_id')
                ->where('sm_temporary_meritlists.created_at','LIKE','%'.YearCheck::getYear().'%')
                ->where('sm_temporary_meritlists.school_id',Auth::user()->school_id)
                ->where('sm_temporary_meritlists.result','F')
                ->where('sm_students.gender_id',1)
                ->count();

            $total_female = SmTemporaryMeritlist::join('sm_students','sm_students.id','sm_temporary_meritlists.student_id')
                ->where('sm_temporary_meritlists.created_at','LIKE','%'.YearCheck::getYear().'%')
                ->where('sm_temporary_meritlists.school_id',Auth::user()->school_id)
                ->where('sm_temporary_meritlists.result','F')
                ->where('sm_students.gender_id',2)
                ->count();

            $total_other = SmTemporaryMeritlist::join('sm_students','sm_students.id','sm_temporary_meritlists.student_id')
                ->where('sm_temporary_meritlists.created_at','LIKE','%'.YearCheck::getYear().'%')
                ->where('sm_temporary_meritlists.school_id',Auth::user()->school_id)
                ->where('sm_temporary_meritlists.result','F')
                ->where('sm_students.gender_id',3)
                ->count();
            }
            else{
                $total_male = SmTemporaryMeritlist::join('sm_students','sm_students.id','sm_temporary_meritlists.student_id')
                    ->where('sm_temporary_meritlists.created_at','LIKE','%'.YearCheck::getYear().'%')
                    ->where('sm_temporary_meritlists.school_id',Auth::user()->school_id)
                    ->where('sm_temporary_meritlists.grades_string','Like','%'.'F'.'%')
                    ->where('sm_students.gender_id',1)
                    ->count();

                $total_female = SmTemporaryMeritlist::join('sm_students','sm_students.id','sm_temporary_meritlists.student_id')
                    ->where('sm_temporary_meritlists.created_at','LIKE','%'.YearCheck::getYear().'%')
                    ->where('sm_temporary_meritlists.school_id',Auth::user()->school_id)
                    ->where('sm_temporary_meritlists.grades_string','Like','%'.'F'.'%')
                    ->where('sm_students.gender_id',2)
                    ->count();

                $total_other = SmTemporaryMeritlist::join('sm_students','sm_students.id','sm_temporary_meritlists.student_id')
                    ->where('sm_temporary_meritlists.created_at','LIKE','%'.YearCheck::getYear().'%')
                    ->where('sm_temporary_meritlists.school_id',Auth::user()->school_id)
                    ->where('sm_temporary_meritlists.grades_string','Like','%'.'F'.'%')
                    ->where('sm_students.gender_id',3)
                    ->count();
            }
            $totals = $total_male + $total_female + $total_other;

//            $semester = SmSemester::join('sm_students','sm_students')

            $allresult_dat = SmTemporaryMeritlist::orderBy('merit_order', 'asc')->where(['exam_id'=>$exam_id,'class_id'=>$class_id,'section_id'=>$section_id,'type'=>$type])->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->first();
//            $allresult_data = SmTemporaryMeritlist::orderBy('merit_order', 'asc')->where(['exam_id'=>$exam_id,'class_id'=>$class_id,'section_id'=>$section_id,'type'=>$type])->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
            // $allresult_data = SmTemporaryMeritlist::orderBy('merit_order', 'asc')->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
            $subjectlist = explode(',', $allresult_dat->subjects_string);

            return view('backEnd.reports.student_exam_type_print',compact('exams','classes','subjects','class','section','exam','subjectlist','allresult_data','class_name','assign_subjects','exam_name','optional_subject_setup','InputType','allresult_data','allresult_dat','total_other','total_female','total_male','totals'));


            $pdf = PDF::loadView(
                'backEnd.reports.merit_list_report_print',
                [
                    'exams' => $exams,
                    'classes' => $classes,
                    'subjects' => $subjects,
                    'class' => $class,
                    'section' => $section,
                    'exam' => $exam,
                    'subjectlist' => $subjectlist,
                    'allresult_data' => $allresult_data,
                    'class_name' => $class_name,
                    'assign_subjects' => $assign_subjects,
                    'exam_name' => $exam_name,
                    'optional_subject_setup' => $optional_subject_setup,

                ]
            )->setPaper('A4', 'landscape');

            return $pdf->stream('student_exam_type_report.pdf');
        }catch (\Exception $e) {
            dd($e);
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }

    }

}
