<?php

namespace App\Http\Controllers;
use App\SmAcademicYear;
use App\SmBaseSetup;
use App\SmExam;
use App\SmClass;
use App\SmSection;
use App\SmStudent;
use App\SmStudentCategory;
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

class SmFoundationReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('PM');
    }
    public function studentScholarship(Request $request) {

//            try {
                $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
                $types = SmStudentCategory::where('school_id', Auth::user()->school_id)->get();
                $genders = SmBaseSetup::where('active_status', '=', '1')->where('base_group_id', '=', '1')->get();
                $faculties = DB::table('sm_faculty')->where('active_status','=', '1')->select('faculty_name')->get();
                $academic_years = SmAcademicYear::where('school_id', Auth::user()->school_id)->get();
                $generations = DB::table('sm_generation')->where('active_status', '=', "1")->select('generation_name')->get();
                $students = SmStudent::where('student_category_id','=',1)->where('school_id', Auth::user()->school_id)->get();
                if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                    $data = [];
                    $data['classes'] = $classes->toArray();
                    $data['types'] = $types->toArray();
                    $data['genders'] = $genders->toArray();
                    return ApiBaseMethod::sendResponse($data, null);
                }
                return view('backEnd.studentInformation.list_student_scholarship', compact('classes', 'types', 'genders', 'faculties', 'academic_years', 'generations','students'));
//            } catch (\Exception $e) {
//                Toastr::error('Operation Failed', 'Failed');
//                return redirect()->back();
//            }
        }
    public function studentScholarshipSearch(Request $request)
    {
//        dd($request->all());
        // if don't want to search in Report Student
//        $request->validate([
//            'class' => 'required'
//        ]);
        //   try {
        //// $students = SmStudent::query();

        // $students->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('active_status', 1);



        $class = $request->class;
        $student = $request->student;
        $section = $request->section;
        $type = $request->type;
        $gender = $request->gender;
        $faculty = $request->faculty;
        $academic_year = $request->academic_year;
        $generation = $request->generation;
        //if no class is selected


        /*
        if ($request->class != "") {
            $students->where('class_id', $request->class);
        }
        if ($request->student != ""){
            $students->where('student_id', $request->student);
        }
        //if no section is selected
        if ($request->section != "") {
            $students->where('section_id', $request->section);
        }
        //if no student is category selected
        if ($request->type != "") {
            $students->where('student_category_id', $request->type);
        }

        //if no gender is selected
        if ($request->gender != "") {
            $students->where('gender_id', $request->gender);
        }
        */

        $students = SmStudent::where('student_category_id','=',1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('active_status', 1)
            ->where(function ($query) use ($student) {
                if ($student != null) {
                    return  $query->where('id', $student);
                }

            })
            ->where(function ($query) use ($class) {
                if ($class != null) {
                    return $query->where('class_id', $class);
                }
            })
            ->where(function ($query) use ($section) {
                if ($section != null){
                    return $query->where('section_id', $section);
                }
            })
            ->where(function ($query) use ($type) {
                if ($type != null) {
                    $query->where('student_category_id', $type);
                }
            })
            ->where(function ($query) use ($gender) {
                if ($gender != null){
                    return $query->where('gender_id', $gender);
                }
            })
            ->where(function ($query) use ($academic_year) {
                if ($academic_year != null){
                    return $query->where('session_id', $academic_year);
                }
            })
//                ->leftjoin('sm_faculty', 'sm_students.faculty_id', '=', 'sm_faculty.id')
//                ->where(function ($query) use ($faculty) {
//                    if ($faculty != null){
//                        return $query->where('sm_faculty.id',$faculty);
//                    }
//                })
//                ->join('sm_generation', 'sm_students.generation_id', '=', 'sm_generation.id')
            ->get();


        // dd();


        //$students = $students->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
//            $students = SmStudent::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
        $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
        $types = SmStudentCategory::where('school_id', Auth::user()->school_id)->get();
        $genders = SmBaseSetup::where('active_status', '=', '1')->where('base_group_id', '=', '1')->get();
        $faculties = DB::table('sm_faculty')->where('active_status','=', '1')->select('name')->get();
        $academic_years = SmAcademicYear::where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
        $generations = DB::table('sm_generation')->where('active_status', '=', "1")->select('name')->get();


        $class_id = $request->class;
        $type_id = $request->type;
        $gender_id = $request->gender;
        $student_id = $request->student;

        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
            $data = [];
            $data['students'] = $students->toArray();
            $data['classes'] = $classes->toArray();
            $data['types'] = $types->toArray();
            $data['genders'] = $genders->toArray();
            $data['student_id'] = $student_id;
            $data['class_id'] = $class_id;
            $data['type_id'] = $type_id;
            $data['gender_id'] = $gender_id;
            return ApiBaseMethod::sendResponse($data, null);
        }
        $clas = SmClass::find($request->class);
        return view('backEnd.studentInformation.list_student_scholarship', compact('students', 'classes', 'types', 'genders', 'class_id', 'type_id', 'gender_id', 'clas','faculties','academic_years','generations','student_id'));
//        } catch (\Exception $e) {
//            Toastr::error('Operation Failed', 'Failed');
//            return redirect()->back();
//        }
    }
    public function studentPrivate(Request $request) {

        try {
            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $types = SmStudentCategory::where('school_id', Auth::user()->school_id)->get();
            $genders = SmBaseSetup::where('active_status', '=', '1')->where('base_group_id', '=', '1')->get();
            $faculties = DB::table('sm_faculty')->where('active_status','=', '1')->select('name')->get();
            $academic_years = SmAcademicYear::where('school_id', Auth::user()->school_id)->get();
            $generations = DB::table('sm_generation')->where('active_status', '=', "1")->select('name')->get();
            $students = SmStudent::where('student_category_id','<>',1)->where('school_id', Auth::user()->school_id)->get();
//            dd($students);
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['classes'] = $classes->toArray();
                $data['types'] = $types->toArray();
                $data['genders'] = $genders->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.studentInformation.list_student_private', compact('classes', 'types', 'genders', 'faculties', 'academic_years', 'generations','students'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function studentPrivateSearch(Request $request)
    {
//        dd($request->all());
        // if don't want to search in Report Student
//        $request->validate([
//            'class' => 'required'
//        ]);
        //   try {
        //// $students = SmStudent::query();

        // $students->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('active_status', 1);



        $class = $request->class;
        $student = $request->student;
        $section = $request->section;
        $type = $request->type;
        $gender = $request->gender;
        $faculty = $request->faculty;
        $academic_year = $request->academic_year;
        $generation = $request->generation;
        //if no class is selected


        /*
        if ($request->class != "") {
            $students->where('class_id', $request->class);
        }
        if ($request->student != ""){
            $students->where('student_id', $request->student);
        }
        //if no section is selected
        if ($request->section != "") {
            $students->where('section_id', $request->section);
        }
        //if no student is category selected
        if ($request->type != "") {
            $students->where('student_category_id', $request->type);
        }

        //if no gender is selected
        if ($request->gender != "") {
            $students->where('gender_id', $request->gender);
        }
        */

        $students = SmStudent::where('student_category_id','<>',1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('active_status', 1)
            ->where(function ($query) use ($student) {
                if ($student != null) {
                    return  $query->where('id', $student);
                }

            })
            ->where(function ($query) use ($class) {
                if ($class != null) {
                    return $query->where('class_id', $class);
                }
            })
            ->where(function ($query) use ($section) {
                if ($section != null){
                    return $query->where('section_id', $section);
                }
            })
            ->where(function ($query) use ($type) {
                if ($type != null) {
                    $query->where('student_category_id', $type);
                }
            })
            ->where(function ($query) use ($gender) {
                if ($gender != null){
                    return $query->where('gender_id', $gender);
                }
            })
            ->where(function ($query) use ($academic_year) {
                if ($academic_year != null){
                    return $query->where('session_id', $academic_year);
                }
            })
//                ->leftjoin('sm_faculty', 'sm_students.faculty_id', '=', 'sm_faculty.id')
//                ->where(function ($query) use ($faculty) {
//                    if ($faculty != null){
//                        return $query->where('sm_faculty.id',$faculty);
//                    }
//                })
//                ->join('sm_generation', 'sm_students.generation_id', '=', 'sm_generation.id')
            ->get();


        // dd();


        //$students = $students->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
//            $students = SmStudent::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
        $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
        $types = SmStudentCategory::where('school_id', Auth::user()->school_id)->get();
        $genders = SmBaseSetup::where('active_status', '=', '1')->where('base_group_id', '=', '1')->get();
        $faculties = DB::table('sm_faculty')->where('active_status','=', '1')->select('name')->get();
        $academic_years = SmAcademicYear::where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
        $generations = DB::table('sm_generation')->where('active_status', '=', "1")->select('name')->get();


        $class_id = $request->class;
        $type_id = $request->type;
        $gender_id = $request->gender;
        $student_id = $request->student;

        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
            $data = [];
            $data['students'] = $students->toArray();
            $data['classes'] = $classes->toArray();
            $data['types'] = $types->toArray();
            $data['genders'] = $genders->toArray();
            $data['student_id'] = $student_id;
            $data['class_id'] = $class_id;
            $data['type_id'] = $type_id;
            $data['gender_id'] = $gender_id;
            return ApiBaseMethod::sendResponse($data, null);
        }
        $clas = SmClass::find($request->class);
        return view('backEnd.studentInformation.list_student_private', compact('students', 'classes', 'types', 'genders', 'class_id', 'type_id', 'gender_id', 'clas','faculties','academic_years','generations','student_id'));
//        } catch (\Exception $e) {
//            Toastr::error('Operation Failed', 'Failed');
//            return redirect()->back();
//        }
    }
}
