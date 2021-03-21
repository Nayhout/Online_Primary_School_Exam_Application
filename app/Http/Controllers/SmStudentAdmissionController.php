<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\SmDegree;
use App\SmEmergency;
use App\SmFaculty;
use App\SmGeneration;
use App\SmMajor;
use App\SmProvinces;
use App\SmSemester;
use App\SmStudentsFamily;
use App\SmStudentsPermanent;
use App\SmStudentYear;
use Mail;
use App\User;
use App\SmClass;
use App\SmRoute;
use App\SmStaff;
use App\SmParent;
use App\SmSection;
use App\SmStudent;
use App\SmVehicle;
use App\YearCheck;
use App\SmExamType;
use App\SmRoomList;
use App\SmBaseSetup;
use App\SmFeesAssign;
use App\SmMarksGrade;
use App\ApiBaseMethod;
use App\SmAcademicYear;
use App\SmClassSection;
use App\SmEmailSetting;
use App\SmExamSchedule;
use App\SmAssignVehicle;
use App\SmDormitoryList;
use App\SmGeneralSettings;
use App\SmStudentCategory;
use App\SmStudentDocument;
use App\SmStudentTimeline;
use App\SmStudentPromotion;
use App\SmStudentAttendance;
use Illuminate\Http\Request;
use App\SmFeesAssignDiscount;
use App\SmTemporaryMeritlist;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Table;
use PhpParser\Node\Stmt\DeclareDeclare;
use PHPUnit\Framework\SkippedTest;

class SmStudentAdmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('PM');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    }

    function admissionCheck($val)
    {
        $data = DB::table('sm_students')->where('admission_no', $val)->where('school_id', Auth::user()->school_id)->first();
        if (!is_null($data)) {
            $msg = 'found';
            $status = 200;
            return response()->json($msg, $status);
        } else {
            $msg = 'not_found';
            $status = 200;
            return response()->json($msg, $status);
        }
    }
    function admissionCheckUpdate($val, $id)
    {
        $data = DB::table('sm_students')->where('admission_no', $val)->where('school_id', Auth::user()->school_id)->first();

        $student = SmStudent::find($id);

        if (!is_null($data) && $student->admission_no != $data->admission_no) {
            $msg = 'found';
            $status = 200;
            return response()->json($msg, $status);
        } else {
            $msg = 'not_found';
            $status = 200;
            return response()->json($msg, $status);
        }
    }

    public function admission()
    {
//        try {
            $max_admission_id = SmStudent::where('school_id', Auth::user()->school_id)->max('admission_no');
            $max_roll_id = SmStudent::where('school_id', Auth::user()->school_id)->max('roll_no');
            $classes = SmClass::where('active_status', '=', '1')->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $religions = SmBaseSetup::where('active_status', '=', '1')->where('base_group_id', '=', '2')->get();
            $blood_groups = SmBaseSetup::where('active_status', '=', '1')->where('base_group_id', '=', '3')->get();
            $genders = SmBaseSetup::where('active_status', '=', '1')->where('base_group_id', '=', '1')->get();
            $route_lists = SmRoute::where('active_status', '=', '1')->where('school_id', Auth::user()->school_id)->get();
            $vehicles = SmVehicle::where('active_status', '=', '1')->where('school_id', Auth::user()->school_id)->get();
            $driver_lists = SmStaff::where([['active_status', '=', '1'], ['role_id', 9]])->where('school_id', Auth::user()->school_id)->get();
            $dormitory_lists = SmDormitoryList::where('active_status', '=', '1')->where('school_id', Auth::user()->school_id)->get();
            $categories = SmStudentCategory::where('school_id', Auth::user()->school_id)->get();
            $sessions = SmAcademicYear::where('active_status', '=', '1')->where('school_id', Auth::user()->school_id)->get();
            $semesters = SmSemester::where('active_status',1)->where('created_at','LIKE','%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $provinces = SmProvinces::all();
            $generations = SmGeneration::where('active_status',1)->get();
            $student_years = SmStudentYear::where('active_status',1)->get();
//            dd($student_years);
            return view('backEnd.studentInformation.student_admission', compact('classes', 'religions', 'blood_groups', 'genders', 'route_lists', 'vehicles', 'dormitory_lists', 'categories', 'sessions', 'max_admission_id', 'max_roll_id', 'driver_lists','provinces','generations','semesters','student_years'));
//        } catch (\Exception $e) {
//            Toastr::error('Operation Failed', 'Failed');
//            return redirect()->back();
//        }
    }



    public function ajaxSectionStudent(Request $request)
    {
        try {
            $sectionIds = SmClassSection::where('class_id', '=', $request->id)
                ->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')
                ->where('school_id', Auth::user()->school_id)->get();
            $sections = [];
            foreach ($sectionIds as $sectionId) {
                $sections[] = SmSection::find($sectionId->section_id);
            }
            return response()->json([$sections]);
        } catch (\Exception $e) {
            return response()->json("", 404);
        }
    }

    public function ajaxSectionSibling(Request $request)
    {
        try {
            $sectionIds = SmClassSection::where('class_id', '=', $request->id)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

            $sibling_sections = [];
            foreach ($sectionIds as $sectionId) {
                $sibling_sections[] = SmSection::find($sectionId->section_id);
            }
            return response()->json([$sibling_sections]);
        } catch (\Exception $e) {
            return response()->json("", 404);
        }
    }
    public function ajaxSiblingInfo(Request $request)
    {
        try {
            if ($request->id == "") {
                $siblings = SmStudent::where('class_id', '=', $request->class_id)->where('section_id', '=', $request->section_id)->where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            } else {
                $siblings = SmStudent::where('class_id', '=', $request->class_id)->where('section_id', '=', $request->section_id)->where('active_status', 1)->where('id', '!=', $request->id)->where('school_id', Auth::user()->school_id)->get();
            }
            return response()->json($siblings);
        } catch (\Exception $e) {
            return response()->json("", 404);
        }
    }

    public function ajaxSiblingInfoDetail(Request $request)
    {
        try {
            $sibling_detail = SmStudent::find($request->id);
            $parent_detail =  $sibling_detail->parents;
            return response()->json([$sibling_detail, $parent_detail]);
        } catch (\Exception $e) {
            return response()->json("", 404);
        }
    }

    public function ajaxGetVehicle(Request $request)
    {
        try {
            $vehicle_detail = SmAssignVehicle::where('route_id', $request->id)->first();
            $vehicles = explode(',', $vehicle_detail->vehicle_id);
            $vehicle_info = [];
            foreach ($vehicles as $vehicle) {
                $vehicle_info[] = SmVehicle::find($vehicle[0]);
            }
            return response()->json([$vehicle_info]);
        } catch (\Exception $e) {
            return response()->json("", 404);
        }
    }

    public function ajaxVehicleInfo(Request $request)
    {
        try {
            $vehivle_detail = SmVehicle::find($request->id);
            return response()->json([$vehivle_detail]);
        } catch (\Exception $e) {
            return response()->json("", 404);
        }
    }

    public function ajaxRoomDetails(Request $request)
    {
        try {
            $room_details = SmRoomList::where('dormitory_id', '=', $request->id)->where('school_id', Auth::user()->school_id)->get();
            $rest_rooms = [];
            foreach ($room_details as $room_detail) {
                $count_room = SmStudent::where('room_id', $room_detail->id)->count();
                if ($count_room < $room_detail->number_of_bed) {
                    $rest_rooms[] = $room_detail;
                }
            }
            return response()->json([$rest_rooms]);
        } catch (\Exception $e) {
            return response()->json("", 404);
        }
    }

    public function ajaxGetRollId(Request $request)
    {

        try {
            $max_roll = SmStudent::where('school_id', Auth::user()->school_id)
                ->max('roll_no');
//            $max_roll = SmStudent::where('class_id', $request->class)->where('section_id', $request->section)
//                ->where('school_id', Auth::user()->school_id)
//                ->max('roll_no');
            // return $max_roll;
            if ($max_roll == "") {
                $max_roll = 1;
            } else {
                $max_roll = $max_roll + 1;
            }
            return response()->json([$max_roll]);
        } catch (\Exception $e) {
            return response()->json("", 404);
        }
    }

    public function ajaxGetRollIdCheck(Request $request)
    {
        try {
            $roll_no = SmStudent::where('roll_no', $request->roll_no)->where('school_id', Auth::user()->school_id)->get();
//            $roll_no = SmStudent::where('class_id', $request->class)->where('section_id', $request->section)->where('roll_no', $request->roll_no)->where('school_id', Auth::user()->school_id)->get();

            // if($roll_no->count() == 0){
            //     $roll_no == 1;
            // }else{
            //     $roll_no == 0;
            // }

            return response()->json($roll_no);
        } catch (\Exception $e) {
            return response()->json("", 404);
        }
    }


    public function studentStore(Request $request)
    {
//        dd($request->all());
        if ($request->parent_id == "") {
            $request->validate([
                'admission_number' => 'required',
                'roll_number' => 'required:unique',
                'class' => 'required',
                'section' => 'required',
                'session' => 'required',
                'gender' => 'required',
                'first_name' => 'required|max:100',
                'date_of_birth' => 'required',
//                'guardians_email' => "required",
                'guardians_phone' => "required",

            ]);
        } else {
            $request->validate([
                'admission_number' => 'required',

                'roll_number' => 'required:unique',
                'class' => 'required',
                'section' => 'required',
                'gender' => 'required',
                'first_name' => 'required|max:100',
                'date_of_birth' => 'required',
                'session' => 'required',
            ]);
        }


        $is_duplicate = SmStudent::where('school_id', Auth::user()->school_id)->where('admission_no', $request->admission_number)->first();

        if ($is_duplicate) {
            Toastr::error('Duplicate admission number found!', 'Failed');
            return redirect()->back()->withInput();
        }

        if ($request->email_address != "") {
            $is_duplicate = SmStudent::where('school_id', Auth::user()->school_id)->where('email', $request->email_address)->first();

            if ($is_duplicate) {
                Toastr::error('Duplicate student email found!', 'Failed');
                return redirect()->back()->withInput();
            }
        }

//
//        $is_duplicate = SmParent::where('school_id', Auth::user()->school_id)->where('guardians_email', $request->guardians_email)->first();
//
//        if ($is_duplicate) {
//            Toastr::error('Duplicate guardian email found!', 'Failed');
//            return redirect()->back()->withInput();
//        }
//
//        $is_duplicate = SmParent::where('school_id', Auth::user()->school_id)->where('guardians_mobile', $request->guardians_mobile)->first();
//
//        if ($is_duplicate) {
//            Toastr::error('Duplicate guardian mobile number found!', 'Failed');
////            return redirect()->back()->withInput();
//        }


        $document_file_1 = "";
        if ($request->file('document_file_1') != "") {
            $file = $request->file('document_file_1');
            $document_file_1 = 'doc1-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move('public/uploads/student/document/', $document_file_1);
            $document_file_1 = 'public/uploads/student/document/' . $document_file_1;
        }

        $document_file_2 = "";
        if ($request->file('document_file_2') != "") {
            $file = $request->file('document_file_2');
            $document_file_2 = 'doc2-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move('public/uploads/student/document/', $document_file_2);
            $document_file_2 = 'public/uploads/student/document/' . $document_file_2;
        }

        $document_file_3 = "";
        if ($request->file('document_file_3') != "") {
            $file = $request->file('document_file_3');
            $document_file_3 = 'doc3-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move('public/uploads/student/document/', $document_file_3);
            $document_file_3 = 'public/uploads/student/document/' . $document_file_3;
        }

        $document_file_4 = "";
        if ($request->file('document_file_4') != "") {
            $file = $request->file('document_file_4');
            $document_file_4 = 'doc4-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move('public/uploads/student/document/', $document_file_4);
            $document_file_4 = 'public/uploads/student/document/' . $document_file_4;
        }

        $document_file_5 = "";
        if ($request->file('document_file_5') != "") {
            $file = $request->file('document_file_5');
            $document_file_5 = 'doc5-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move('public/uploads/student/document/', $document_file_5);
            $document_file_5 = 'public/uploads/student/document/' . $document_file_5;
        }


        // $get_admission_number = SmStudent::where('school_id',Auth::user()->school_id)->max('admission_no') + 1;

        $shcool_details = SmGeneralSettings::find(1);

        $school_name = explode(' ', $shcool_details->school_name);

        $short_form = '';

        foreach ($school_name as $value) {
            $ch = str_split($value);
            $short_form = $short_form . '' . $ch[0];
        }


        DB::beginTransaction();
//        try {

            $user_stu = new User();
            $user_stu->role_id = 2;
            $user_stu->full_name = $request->first_name . ' ' . $request->last_name;

            $user_stu->username = $request->admission_number;

            $user_stu->email = $request->email_address;


            $user_stu->password = Hash::make(123456);
            $user_stu->school_id = Auth::user()->school_id;
            $user_stu->save();
            $user_stu->toArray();

//            try {

                if ($request->parent_id == "") {
                    $user_parent = new User();
                    $user_parent->role_id = 3;
                    $user_parent->full_name = $request->fathers_name;


                    if (!empty($request->guardians_email)) {
                        $data_parent['email'] = $request->guardians_email;
                        $user_parent->username = $request->guardians_email;
                    }

                    $user_parent->email = $request->guardians_email;
                    $user_parent->password = Hash::make(123456);
                    $user_parent->school_id = Auth::user()->school_id;
                    $user_parent->save();
                    $user_parent->toArray();
                }

//                try {
                    if ($request->parent_id == "") {
                        $parent = new SmParent();
                        $parent->user_id = $user_parent->id;
                        $parent->fathers_name = $request->fathers_name;
                        $parent->fathers_mobile = $request->fathers_phone;
                        $parent->fathers_occupation = $request->fathers_occupation;
                        $parent->fathers_photo = Session::get('fathers_photo');
                        $parent->mothers_name = $request->mothers_name;
                        $parent->mothers_mobile = $request->mothers_phone;
                        $parent->mothers_occupation = $request->mothers_occupation;
                        $parent->mothers_photo = Session::get('mothers_photo');
                        $parent->guardians_name = $request->guardians_name;
                        $parent->guardians_mobile = $request->guardians_phone;
                        $parent->guardians_email = $request->guardians_email;
                        $parent->guardians_occupation = $request->guardians_occupation;
                        $parent->guardians_relation = $request->relation;
                        $parent->relation = $request->relationButton;
                        $parent->guardians_photo = Session::get('guardians_photo');
                        $parent->guardians_address = $request->guardians_address;
                        $parent->is_guardian = $request->is_guardian;
                        $parent->date_of_birth_father = date('Y-m-d', strtotime($request->date_of_birth_father));
                        $parent->date_of_birth_mother = date('Y-m-d', strtotime($request->date_of_birth_mother));
                        $parent->date_of_birth_guardian = date('Y-m-d', strtotime($request->date_of_birth_guardian));
                        $parent->location = $request->locations;
                        $parent->as_guardian = $request->as_guardian;
                        $parent->father_address = $request->father_address;
                        $parent->mother_address = $request->mother_address;
                        $parent->facebook_guardian = $request->facebook_guardian;
                        $parent->emergency_contact = $request->emergency_contact;
                        $parent->school_id = Auth::user()->school_id;
                        $parent->save();
                        $parent->toArray();
                    }
//                        try{
                        $family = new SmStudentsFamily();
                        $family->family_member = $request->family_member;
                        $family->family1 = $request->family1;
                        $family->family2 = $request->family2;
                        $family->family3 = $request->family3;
                        $family->major1 = $request->major1;
                        $family->major2 = $request->major2;
                        $family->major3 = $request->major3;
                        $family->academic1 = $request->academic1;
                        $family->academic2 = $request->academic2;
                        $family->academic3 = $request->academic3;
                        $family->as1 = $request->as1;
                        $family->as2 = $request->as2;
                        $family->as3 = $request->as3;
                        $family->save();
                        $family->toArray();
                //                            try{
                        $student_permanent = new SmStudentsPermanent();
                        $student_permanent->house_permanent = $request->house_permanent;
                        $student_permanent->street_permanent = $request->street_permanent;
                        $student_permanent->group_permanent = $request->group_permanent;
                        $student_permanent->village_permanent = $request->village_permanent;
                        $student_permanent->commune_permanent = $request->commune_permanent;
                        $student_permanent->district_permanent = $request->district_permanent;
                        $student_permanent->province_permanent = $request->province_permanent;
                        $student_permanent->save();
                        $student_permanent->toArray();
//                        try{
//        dd($request->mobile);
                            $emergency = new SmEmergency();
                            $emergency->emergency_name = $request->emergency_name;
                            $emergency->emergency_name_kh = $request->emergency_name_kh;
                            $emergency->emergency_occupation = $request->emergency_occupation;
                            $emergency->emergency_mobile = $request->emergency_mobile;
                            $emergency->save();
                            $emergency->toArray();
//                    try {

                    $classes = SmClass::find($request->class);

                        $student = new SmStudent();
                        $student->id = $request->id;
                        $student->class_id = $request->class;
                        $student->faculty_id = optional($classes)->faculty_id;
                        $student->degree_id = optional($classes)->degree_id;
                        $student->major_id = optional($classes)->majors_id;
                        $student->semester_id = $request->semester;
                        $student->student_year_id = $request->student_year;
                        $student->nationality = $request->nationality;
                        $student->section_id = $request->section;
                        $student->session_id = $request->session;
                        $student->generation_id = $request->generation_id;
                        $student->user_id = $user_stu->id;
                        $student->house_student = $request->house_student;
                        $student->street_student = $request->street_student;
                        $student->group_student = $request->group_student;
                        $student->village_student = $request->village_student;
                        $student->commune_student = $request->commune_student;
                        $student->district_student = $request->district_student;
                        $student->province_student = $request->province_student;
                        $student->village_school = $request->village_school;
                        $student->commune_school = $request->commune_school;
                        $student->district_school = $request->district_school;
                        $student->from_school = $request->from_school;
                        $student->province_school = $request->province_school;
                        $student->degree_year = $request->degree_year;
                        $student->degree_no = $request->degree_no;
                        $student->subject1 = $request->subject1;
                        $student->subject2 = $request->subject2;
                        $student->subject3 = $request->subject3;
                        $student->subject4 = $request->subject4;
                        $student->subject5 = $request->subject5;
                        $student->subject6 = $request->subject6;
                        $student->total_grade = $request->total_grade;
                        $student->total_score = $request->total_score;
                        $student->degree_level = $request->degree_level;
                        $student->grade1 = $request->grade1;
                        $student->grade2 = $request->grade2;
                        $student->grade3 = $request->grade3;
                        $student->grade4 = $request->grade4;
                        $student->grade5 = $request->grade5;
                        $student->grade6 = $request->grade6;
                        $student->house_birth = $request->house_birth;
                        $student->group_birth = $request->group_birth;
                        $student->village_birth = $request->village_birth;
                        $student->commune_birth = $request->commune_birth;
                        $student->district_birth = $request->district_birth;
                        $student->city = $request->city;
                        $student->external = $request->external;
                        $student->company = $request->company;



                        if ($request->parent_id == "") {
                            $student->parent_id = $parent->id;
                        } else {
                            $student->parent_id = $request->parent_id;
                        }

                        $student->role_id = 2;

                        $student->admission_no = $request->admission_number;

                        $student->roll_no = $request->roll_number;
                        $student->first_name = $request->first_name;
                        $student->last_name = $request->last_name;
                        $student->full_name = $request->first_name . ' ' . $request->last_name;
                        $student->gender_id = $request->gender;
                        $student->date_of_birth = date('Y-m-d', strtotime($request->date_of_birth));

                        if (@$request->category != "") {
                            $student->student_category_id = $request->category;
                        }

                        $student->caste = $request->caste;

                        $student->email = $request->email_address;


                        $student->mobile = $request->phone_number;
                        $student->admission_date = date('Y-m-d', strtotime($request->admission_date));
                        $student->student_photo = Session::get('student_photo');

                        if (@$request->blood_group != "") {
                            $student->bloodgroup_id = $request->blood_group;
                        }
                        if (@$request->religion != "") {
                            $student->religion_id = $request->religion;
                        }
                        $student->height = $request->height;
                        $student->weight = $request->weight;
                        $student->current_address = $request->current_address;
                        $student->permanent_address = $request->permanent_address;
                        if (@$request->route != "") {
                            $student->route_list_id = $request->route;
                        }
                        if (@$request->dormitory_name != "") {
                            $student->dormitory_id = $request->dormitory_name;
                        }
                        if (@$request->room_number != "") {
                            $student->room_id = $request->room_number;
                        }
                        //$driver_id=SmVehicle::where('id','=',$request->vehicle)->first();

                        if (!empty($request->vehicle)) {
                            $driver = SmVehicle::where('id', '=', $request->vehicle)
                                ->select('driver_id')
                                ->first();

                            if (!empty($driver)) {
                                $student->vechile_id = $request->vehicle;
                                $student->driver_id = $driver->driver_id;
                            }
                        }

                        // $student->driver_name = $request->driver_name;
                        // $student->driver_phone_no = $request->driver_phone;
                        $student->national_id_no = $request->national_id_number;
                        $student->local_id_no = $request->local_id_number;
                        $student->bank_account_no = $request->bank_account_number;
                        $student->bank_name = $request->bank_name;
                        $student->previous_school_details = $request->previous_school_details;
                        $student->aditional_notes = $request->additional_notes;
                        $student->document_title_1 = $request->document_title_1;
                        $student->document_file_1 = $document_file_1;
                        $student->document_title_2 = $request->document_title_2;
                        $student->document_file_2 = $document_file_2;
                        $student->document_title_3 = $request->document_title_3;
                        $student->document_file_3 = $document_file_3;
                        $student->document_title_4 = $request->document_title_4;
                        $student->document_file_4 = $document_file_4;
                        $student->document_title_5 = $request->document_title_5;
                        $student->document_file_5 = $document_file_5;
                        $student->current_occupation_student = $request->current_occupation_student;
                        $student->facebook_student = $request->facebook_student;
//                        $student->student_family_id = $request->student_family;
//                        $student->student_permanent_id = $request->student_permanent;

                        if ($request->student_family_id == "") {
                            $student->student_family_id = $family->id;
                        } else {
                            $student->student_family_id = $request->student_family_id;
                        }
                        if ($request->student_permanent_id == "") {
                            $student->student_permanent_id = $student_permanent->id;
                        } else {
                            $student->student_permanent_id = $request->student_permanent_id;
                        }
                        if ($request->emergency_contact_id == "") {
                            $student->emergency_contact_id = $emergency->id;
                        } else {
                            $student->emergency_contact_id = $request->emergency_contact_id;
                        }




                        $student->school_id = Auth::user()->school_id;

                        if ($student->save()) {
                            Customer::getCustomer($student);
                        }
                        $is_erp = isset($_REQUEST['is_erp']) ? $_REQUEST['is_erp'] : 0;

                        $student->toArray();

                        $user_info = [];

                        if ($request->email_address != "") {
                            $user_info[] = array('email' => $request->email_address, 'id' => $student->id, 'slug' => 'student');
                        }


                        if ($request->guardians_email != "") {
                            $user_info[] = array('email' => $request->guardians_email, 'id' => $parent->id, 'slug' => 'parent');
                        }


                        // if($request->email_address != ""){
                        //     $data['email'] = $data_student['email'];
                        //      Mail::send('backEnd.studentInformation.user_credential', compact('data'), function ($message) use ($request) {
                        //         $settings = SmEmailSetting::find(1);
                        //         $email = $settings->from_email;
                        //         $Schoolname = $settings->from_name;
                        //         $message->to($request->email_address, $Schoolname)->subject('Login Credentials');
                        //         $message->from($email, $Schoolname);
                        //     });
                        //  }

                        //  if($request->guardians_email != ""){
                        //     $data['email'] = $data_parent['email'];
                        //     Mail::send('backEnd.studentInformation.user_credential', compact('data'), function ($message) use ($request) {
                        //         $settings = SmEmailSetting::find(1);
                        //         $email = $settings->from_email;
                        //         $Schoolname = $settings->from_name;
                        //         $message->to($request->guardians_email, $Schoolname)->subject('Login Credentials');
                        //         $message->from($email, $Schoolname);
                        //     });
                        //  }


                        /* Mail::send('backEnd.studentInformation.user_credential', compact('data'), function ($message) use ($request) {
                            $settings = SmEmailSetting::find(1);
                            $email = $settings->from_email;
                            $Schoolname = $settings->from_name;
                            $message->to($request->email, $Schoolname)->subject('Login Credentials');
                            $message->from($email, $Schoolname);
                        });*/

                        DB::commit();


//                        try {


//                            if (count($user_info) != 0) {
//                                $systemSetting = SmGeneralSettings::select('school_name', 'email')->find(1);
//
//                                $systemEmail = SmEmailSetting::find(1);
//
//                                $system_email = $systemEmail->from_email;
//                                $school_name = $systemSetting->school_name;
//
//                                $sender['system_email'] = $system_email;
//                                $sender['school_name'] = $school_name;
//
//                                dispatch(new \App\Jobs\SendUserMailJob($user_info, $sender));
//                            }
//                        } catch (\Exception $e) {
//
//                            Toastr::success('Operation successful', 'Success');
//                            if($is_erp>0){
//                                return redirect('http://wisc-acc.icloud-erp.org/school/get-student');
//                            }else {
//                                return redirect('student-list');
//                            }
//                        }

                        if ($is_erp > 0) {
                            return redirect('http://wisc-acc.icloud-erp.org/school/get-student');
                        } else {
                            Toastr::success('Operation successful', 'Success');
                        }
                        return redirect('student-list');
    //                            } catch (\Exception $e) {
    //                                DB::rollback();
    //                                Toastr::error('Operation Failed', 'Failed');
    //                                return redirect()->back();
    //                            }
//                              } catch (\Exception $e) {
//                                DB::rollback();
//                                Toastr::error('Operation Failed', 'Failed');
//                                return redirect()->back();
//                            }
//                        } catch (\Exception $e) {
//                            DB::rollback();
//                            Toastr::error('Operation Failed', 'Failed');
//                            return redirect()->back();
//                        }
//                    } catch (\Exception $e) {
//                        DB::rollback();
//                        Toastr::error('Operation Failed', 'Failed');
//                        return redirect()->back();
//                    }
//                } catch (\Exception $e) {
//                    DB::rollback();
//                    Toastr::error('Operation Failed', 'Failed');
//                    return redirect()->back();
//                }
//            } catch (\Exception $e) {
//                DB::rollback();
//                Toastr::error('Operation Failed', 'Failed');
//                return redirect()->back();
//            }
    }


    function admissionPic(Request $r)
    {
        try {
            $validator = Validator::make($r->all(), [
                'logo_pic' => 'sometimes|required|mimes:jpg,png|max:40000',

            ]);
            if ($validator->fails()) {
                return response()->json(['error' => 'error'], 201);
            }
            $data = new SmStudent();
            $data_parent = new SmParent();
            if ($r->hasFile('logo_pic')) {
                $file = $r->file('logo_pic');
                $images = Image::make($file)->insert($file);
                $pathImage = 'public/uploads/student/';
                if (!file_exists($pathImage)) {
                    mkdir($pathImage, 0777, true);
                    $name = md5($file->getClientOriginalName() . time()) . "." . "png";
                    $images->save('public/uploads/student/' . $name);
                    $imageName = 'public/uploads/student/' . $name;
                    // $data->staff_photo =  $imageName;
                    Session::put('student_photo', $imageName);
                } else {
                    $name = md5($file->getClientOriginalName() . time()) . "." . "png";
                    if (file_exists(Session::get('student_photo'))) {
                        File::delete(Session::get('student_photo'));
                    }
                    $images->save('public/uploads/student/' . $name);
                    $imageName = 'public/uploads/student/' . $name;
                    // $data->student_photo =  $imageName;
                    Session::put('student_photo', $imageName);
                }
            }
            // parent
            if ($r->hasFile('fathers_photo')) {
                $file = $r->file('fathers_photo');
                $images = Image::make($file)->insert($file);
                $pathImage = 'public/uploads/student/';
                if (!file_exists($pathImage)) {
                    mkdir($pathImage, 0777, true);
                    $name = md5($file->getClientOriginalName() . time()) . "." . "png";
                    $images->save('public/uploads/student/' . $name);
                    $imageName = 'public/uploads/student/' . $name;
                    // $data->staff_photo =  $imageName;
                    Session::put('fathers_photo', $imageName);
                } else {
                    $name = md5($file->getClientOriginalName() . time()) . "." . "png";
                    if (file_exists(Session::get('fathers_photo'))) {
                        File::delete(Session::get('fathers_photo'));
                    }
                    $images->save('public/uploads/student/' . $name);
                    $imageName = 'public/uploads/student/' . $name;
                    // $data->fathers_photo =  $imageName;
                    Session::put('fathers_photo', $imageName);
                }
            }
            //mother
            if ($r->hasFile('mothers_photo')) {
                $file = $r->file('mothers_photo');
                $images = Image::make($file)->insert($file);
                $pathImage = 'public/uploads/student/';
                if (!file_exists($pathImage)) {
                    mkdir($pathImage, 0777, true);
                    $name = md5($file->getClientOriginalName() . time()) . "." . "png";
                    $images->save('public/uploads/student/' . $name);
                    $imageName = 'public/uploads/student/' . $name;
                    // $data->staff_photo =  $imageName;
                    Session::put('mothers_photo', $imageName);
                } else {
                    $name = md5($file->getClientOriginalName() . time()) . "." . "png";
                    if (file_exists(Session::get('mothers_photo'))) {
                        File::delete(Session::get('mothers_photo'));
                    }
                    $images->save('public/uploads/student/' . $name);
                    $imageName = 'public/uploads/student/' . $name;
                    // $data->mothers_photo =  $imageName;
                    Session::put('mothers_photo', $imageName);
                }
            }
            //guardians_photo
            if ($r->hasFile('guardians_photo')) {
                $file = $r->file('guardians_photo');
                $images = Image::make($file)->insert($file);
                $pathImage = 'public/uploads/student/';
                if (!file_exists($pathImage)) {
                    mkdir($pathImage, 0777, true);
                    $name = md5($file->getClientOriginalName() . time()) . "." . "png";
                    $images->save('public/uploads/student/' . $name);
                    $imageName = 'public/uploads/student/' . $name;
                    // $data->staff_photo =  $imageName;
                    Session::put('guardians_photo', $imageName);
                } else {
                    $name = md5($file->getClientOriginalName() . time()) . "." . "png";
                    if (file_exists(Session::get('guardians_photo'))) {
                        File::delete(Session::get('guardians_photo'));
                    }
                    $images->save('public/uploads/student/' . $name);
                    $imageName = 'public/uploads/student/' . $name;
                    // $data->guardians_photo =  $imageName;
                    Session::put('guardians_photo', $imageName);
                }
            }

            return response()->json('success', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'error'], 201);
        }
    }
    public function studentDetails(Request $request)
    {
        try {

           $staff =  DB::table('sm_staffs')->where('user_id',Auth::user()->id)->first();
//           $staff =  DB::table('infix_roles')->where('role_id',Auth::user()->role_id)->first();
//            if(Auth::user()->role_id ==1 ||Auth::user()->role_id == 11 ){
//                 $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
//            }else{
//                $classes =  DB::table('sm_classes')
//                    ->leftJoin('sm_assign_class_teachers','sm_assign_class_teachers.class_id','sm_classes.id')
//                    ->leftJoin('sm_class_teachers','sm_assign_class_teachers.id','sm_class_teachers.assign_class_teacher_id')
//                    ->where('sm_classes.active_status', 1)
//                    ->where('sm_classes.created_at', 'LIKE', '%' . YearCheck::getYear() . '%')
//                    ->where('sm_classes.school_id',Auth::user()->school_id)
//                    ->where('sm_class_teachers.teacher_id',optional($staff)->id)
//                    ->select('sm_classes.*','sm_class_teachers.teacher_id')
//                    ->get();
//            }
            if(Auth::user()->role_id == 4){
                $classes =  DB::table('sm_classes')
                    ->leftJoin('sm_assign_class_teachers','sm_assign_class_teachers.class_id','sm_classes.id')
                    ->leftJoin('sm_class_teachers','sm_assign_class_teachers.id','sm_class_teachers.assign_class_teacher_id')
                    ->where('sm_classes.active_status', 1)
                    ->where('sm_classes.created_at', 'LIKE', '%' . YearCheck::getYear() . '%')
                    ->where('sm_classes.school_id',Auth::user()->school_id)
                    ->where('sm_class_teachers.teacher_id',optional($staff)->id)
                    ->select('sm_classes.*','sm_class_teachers.teacher_id')
                    ->get();
            }else{
                $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

            }

            $student_list = DB::table('sm_students')
                ->join('sm_classes', 'sm_students.class_id', '=', 'sm_classes.id')
                ->join('sm_sections', 'sm_students.section_id', '=', 'sm_sections.id')
                ->where('sm_students.created_at', 'LIKE', '%' . YearCheck::getYear() . '%')
                ->where('sm_students.school_id', Auth::user()->school_id)->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['student_list'] = $student_list->toArray();
                // $data['classes'] = $classes->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            $academic_years = SmAcademicYear::latest()->where('school_id', Auth::user()->school_id)->get();
            return view('backEnd.studentInformation.student_details', compact('classes', 'academic_years'));
        } catch (\Exception $e) {

            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentDetailsSearch(Request $request)
    {
        if (Auth::user()->role_id == 4){
            $request->validate([
                'class' => 'required',
            ]);
        }

        try {
            $students = SmStudent::query();
            $students->where('active_status', 1);
            if ($request->class != "") {
                $students->where('class_id', $request->class);
            }
            if ($request->section != "") {
                $students->where('section_id', $request->section);
            }
            if ($request->name != "") {
                $students->where('full_name', 'like', '%' . $request->name . '%');
            }
            if ($request->roll_no != "") {
                $students->where('roll_no', 'like', '%' . $request->roll_no . '%');
            }


            $students = $students->where('created_at','LIKE','%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
//            dd($students);
//            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $staff =  DB::table('sm_staffs')->where('user_id',Auth::user()->id)->first();
            if(Auth::user()->role_id == 4){
                $classes =  DB::table('sm_classes')
                    ->leftJoin('sm_assign_class_teachers','sm_assign_class_teachers.class_id','sm_classes.id')
                    ->leftJoin('sm_class_teachers','sm_assign_class_teachers.id','sm_class_teachers.assign_class_teacher_id')
                    ->where('sm_classes.active_status', 1)
                    ->where('sm_classes.created_at', 'LIKE', '%' . YearCheck::getYear() . '%')
                    ->where('sm_classes.school_id',Auth::user()->school_id)
                    ->where('sm_class_teachers.teacher_id',optional($staff)->id)
                    ->select('sm_classes.*','sm_class_teachers.teacher_id')
                    ->get();
            }else{
                $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

            }
            $class_id = $request->class;
            $name = $request->name;
            $roll_no = $request->roll_no;

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['students'] = $students->toArray();
                $data['classes'] = $classes->toArray();
                $data['class_id'] = $class_id;
                $data['name'] = $name;
                $data['roll_no'] = $roll_no;
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.studentInformation.student_details', compact('students', 'classes', 'class_id', 'name', 'roll_no'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentView(Request $request, $id)
    {
        try {
            $student_detail = SmStudent::find($id);

            $siblings = SmStudent::where('parent_id', $student_detail->parent_id)
                ->where('active_status', 1)
                ->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')
                ->where('id', '!=', $student_detail->id)
                ->where('school_id', Auth::user()->school_id)->get();

            $vehicle = DB::table('sm_vehicles')->where('id', $student_detail->vehicle_id)->first();
            // return $vehicle;
            $fees_assigneds = SmFeesAssign::where('student_id', $id)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            //  return $fees_assigneds;
            $fees_discounts = SmFeesAssignDiscount::where('student_id', $id)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            // $documents = SmStudentDocument::where('student_staff_id', $id)->where('type', 'stu')->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
            $documents = SmStudentDocument::where('student_staff_id', $id)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

            $timelines = SmStudentTimeline::where('staff_student_id', $id)->where('type', 'stu')->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $exams = SmExamSchedule::where('class_id', $student_detail->class_id)->where('section_id', $student_detail->section_id)->where('school_id', Auth::user()->school_id)->get();
            $academic_year = SmAcademicYear::where('id', $student_detail->session_id)->first();
            $grades = SmMarksGrade::where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            if (!empty($student_detail->vechile_id)) {
                $driver_id = SmVehicle::where('id', '=', $student_detail->vechile_id)->first();
                $driver_info = SmStaff::where('id', '=', $driver_id->driver_id)->first();
            } else {
                $driver_id = '';
                $driver_info = '';
            }

            // return $academic_year;

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['student_detail'] = $student_detail->toArray();
                $data['fees_assigneds'] = $fees_assigneds->toArray();
                $data['fees_discounts'] = $fees_discounts->toArray();
                $data['exams'] = $exams->toArray();
                $data['documents'] = $documents->toArray();
                $data['timelines'] = $timelines->toArray();
                $data['siblings'] = $siblings->toArray();
                $data['grades'] = $grades->toArray();
                $data['driver_info'] = $driver_info->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }

            return view('backEnd.studentInformation.student_view', compact('student_detail', 'driver_info', 'fees_assigneds', 'fees_discounts', 'exams', 'documents', 'timelines', 'siblings', 'grades', 'academic_year'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function uploadDocument(Request $request)
    {
        try {
            if ($request->file('photo') != "" && $request->title != "") {
                $document_photo = "";
                if ($request->file('photo') != "") {
                    $file = $request->file('photo');
                    $document_photo = 'stu-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                    $file->move('public/uploads/student/document/', $document_photo);
                    $document_photo =  'public/uploads/student/document/' . $document_photo;
                }

                $document = new SmStudentDocument();
                $document->title = $request->title;
                $document->student_staff_id = $request->student_id;
                $document->type = 'stf';
                $document->file = $document_photo;
                $document->school_id = Auth::user()->school_id;
                $document->save();
            }
            Toastr::success('Document uploaded successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function deleteDocument($id)
    {
        try {
            $document = SmStudentDocument::find($id);
            if ($document->file != "") {
                unlink($document->file);
            }
            $result = SmStudentDocument::destroy($id);
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentUploadDocument(Request $request)
    {
        try {
            if ($request->file('photo') != "" && $request->title != "") {
                $document_photo = "";
                if ($request->file('photo') != "") {
                    $file = $request->file('photo');
                    $document_photo = 'stu-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                    $file->move('public/uploads/student/document/', $document_photo);
                    $document_photo =  'public/uploads/student/document/' . $document_photo;
                }

                $document = new SmStudentDocument();
                $document->title = $request->title;
                $document->student_staff_id = $request->student_id;
                $document->type = 'stu';
                $document->file = $document_photo;
                $document->school_id = Auth::user()->school_id;
                $document->save();
            }

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    // timeline 
    public function studentTimelineStore(Request $request)
    {
        try {
            if ($request->title != "") {

                $document_photo = "";
                if ($request->file('document_file_4') != "") {
                    $file = $request->file('document_file_4');
                    $document_photo = 'stu-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                    $file->move('public/uploads/student/timeline/', $document_photo);
                    $document_photo =  'public/uploads/student/timeline/' . $document_photo;
                }

                $timeline = new SmStudentTimeline();
                $timeline->staff_student_id = $request->student_id;
                $timeline->type = 'stu';
                $timeline->title = $request->title;
                $timeline->date = date('Y-m-d', strtotime($request->date));
                $timeline->description = $request->description;
                if (isset($request->visible_to_student)) {
                    $timeline->visible_to_student = $request->visible_to_student;
                }
                $timeline->file = $document_photo;
                $timeline->school_id = Auth::user()->school_id;
                $timeline->save();
            }
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function deleteTimeline($id)
    {
        try {
            $document = SmStudentTimeline::find($id);
            if ($document->file != "") {
                unlink($document->file);
            }
            $result = SmStudentTimeline::destroy($id);
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    // public function studentDestroy(Request $request)
    // {
    //     //dd($request->all());
    //     DB::beginTransaction();
    //     try {
    //         $student = SmStudent::find($request->id);
    //         $student->active_status = 0;
    //         $student->save();
    //         $student_user = User::find($student->user_id);
    //         $student_user->active_status = 0;
    //         $student_user->access_status = 0;
    //         $student_user->save();
    //         DB::commit();
    //         if (ApiBaseMethod::checkUrl($request->fullUrl())) {
    //             return ApiBaseMethod::sendResponse(null, 'Student has been deleted successfully');
    //         }
    //         Toastr::success('Operation successful', 'Success');
    //         return redirect()->back();
    //     } catch (\Exception $e) {
    //         if (ApiBaseMethod::checkUrl($request->fullUrl())) {
    //             return ApiBaseMethod::sendResponse(null, 'Operation Failed');
    //         }
    //         Toastr::error('Operation Failed', 'Failed');
    //         return redirect()->back();
    //     }
    // }

    public function studentDelete1(Request $request)
    {

        try {

            $student_detail = SmStudent::find($request->id);

            $siblings = SmStudent::where('parent_id', $student_detail->parent_id)->where('school_id', Auth::user()->school_id)->get();


            DB::beginTransaction();

            $student = SmStudent::find($request->id);
            $student->active_status = 0;
            $student->save();
            $student_user = User::find($student_detail->user_id);
            $student_user->active_status = 0;
            $student_user->save();


            if (count($siblings) == 1) {
                $parent = SmParent::find($student_detail->parent_id);
                $parent->active_status = 0;
                $parent->save();
            }


            $student_user = User::find($student_detail->user_id);
            $student_user->active_status = 0;
            $student_user->save();



            if (count($siblings) == 1) {

                $parent_user = User::find($student_detail->parents->user_id);
                $parent_user->active_status = 0;
                $parent_user->save();
            }

            DB::commit();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse(null, 'Student has been disabled successfully');
            }

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Something went wrong, please try again');
            }
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function studentDelete(Request $request)
    {
        // return $request;
        try {
            $tables = \App\tableList::getTableList('student_id', $request->id);

            try {

                $student_detail = SmStudent::find($request->id);
                $siblings = SmStudent::where('parent_id', $student_detail->parent_id)->where('school_id', Auth::user()->school_id)->get();

                DB::beginTransaction();
                $student = SmStudent::find($request->id);
                $student->active_status = 0;
                $student->save();
                $student_user = User::find($student_detail->user_id);
                $student_user->active_status = 0;
                $student_user->save();

                if (count($siblings) == 1) {
                    $parent = SmParent::find($student_detail->parent_id);
                    $parent->active_status = 0;
                    $parent->save();
                }

                $student_user = User::find($student_detail->user_id);
                $student_user->active_status = 0;
                $student_user->save();

                if (count($siblings) == 1) {

                    $parent_user = User::find($student_detail->parents->user_id);
                    $parent_user->active_status = 0;
                    $parent_user->save();
                }

                DB::commit();
                if ($student_detail) {
                    if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                        if ($student_detail) {
                            return ApiBaseMethod::sendResponse(null, 'Room type has been deleted successfully');
                        } else {
                            return ApiBaseMethod::sendError('Something went wrong, please try again');
                        }
                    } else {
                        if ($student_detail) {
                            Toastr::success('Operation successful', 'Success');
                            return redirect()->back();
                        } else {
                            Toastr::error('Operation Failed', 'Failed');
                            return redirect()->back();
                        }
                    }
                } else {
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
            } catch (\Illuminate\Database\QueryException $e) {

                $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
                Toastr::error($msg, 'Failed');
                return redirect()->back();
            } catch (\Exception $e) {
                DB::rollback();
                //dd($e, $e->errorInfo);
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }







    public function studentEdit(Request $request, $id)
    {
        try {
            $student = SmStudent::find($id);
            $classes = SmClass::where('active_status', '=', '1')->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $sections = SmSection::where('active_status', '=', '1')->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $religions = SmBaseSetup::where('active_status', '=', '1')->where('base_group_id', '=', '2')->get();
            $blood_groups = SmBaseSetup::where('active_status', '=', '1')->where('base_group_id', '=', '3')->get();
            $genders = SmBaseSetup::where('active_status', '=', '1')->where('base_group_id', '=', '1')->get();
            $route_lists = SmRoute::where('active_status', '=', '1')->where('school_id', Auth::user()->school_id)->get();
            $vehicles = SmVehicle::where('active_status', '=', '1')->where('school_id', Auth::user()->school_id)->get();
            $dormitory_lists = SmDormitoryList::where('active_status', '=', '1')->where('school_id', Auth::user()->school_id)->get();
            $driver_lists = SmStaff::where([['active_status', '=', '1'], ['role_id', 9]])->where('school_id', Auth::user()->school_id)->get();
            $categories = SmStudentCategory::where('school_id', Auth::user()->school_id)->get();
            $sessions = SmAcademicYear::where('active_status', '=', '1')->where('school_id', Auth::user()->school_id)->get();
            $siblings = SmStudent::where('parent_id', $student->parent_id)->where('school_id', Auth::user()->school_id)->get();
            $provinces = SmProvinces::all();
            $guardians = SmParent::all();
            $families = SmStudentsFamily::all();
            $generations = SmGeneration::where('active_status',1)->get();
            $academic_years = SmAcademicYear::where('active_status', '=', '1')->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $semesters = SmSemester::where('active_status', '=', '1')->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $student_years = SmStudentYear::where('active_status', '=', '1')->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->get();
//            $permanents = SmStudentsPermanent::find($student->student_permanent_id)->get();
//            dd($student_years);
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['student'] = $student;
                $data['classes'] = $classes->toArray();
                $data['religions'] = $religions->toArray();
                $data['blood_groups'] = $blood_groups->toArray();
                $data['genders'] = $genders->toArray();
                $data['route_lists'] = $route_lists->toArray();
                $data['vehicles'] = $vehicles->toArray();
                $data['dormitory_lists'] = $dormitory_lists->toArray();
                $data['categories'] = $categories->toArray();
                $data['sessions'] = $sessions->toArray();
                $data['siblings'] = $siblings->toArray();
                $data['driver_lists'] = $driver_lists->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.studentInformation.student_edit', compact('student', 'classes', 'sections', 'religions', 'blood_groups', 'genders', 'route_lists', 'vehicles', 'dormitory_lists', 'categories', 'sessions', 'siblings', 'driver_lists','provinces','guardians','families','generations','academic_years','semesters','student_years'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    function studentUpdatePic(Request $r, $id)
    {
        // try {
        $validator = Validator::make($r->all(), [
            'logo_pic' => 'sometimes|required|mimes:jpg,png|max:40000',
            'student_photo'=>'sometimes|required|mimes:jpg,png|max:40000',
            'fathers_photo' => 'sometimes|required|mimes:jpg,png|max:40000',
            'mothers_photo' => 'sometimes|required|mimes:jpg,png|max:40000',
            'guardians_photo' => 'sometimes|required|mimes:jpg,png|max:40000',

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'error'], 201);
        }
        try {
            $data = SmStudent::find($id);
            $data_parent = $data->parents;
            if ($r->hasFile('logo_pic')) {
                $file = $r->file('logo_pic');
                $images = Image::make($file)->insert($file);
                $pathImage = 'public/uploads/student/';
                if (!file_exists($pathImage)) {
                    mkdir($pathImage, 0777, true);
                    $name = md5($file->getClientOriginalName() . time()) . "." . "png";
                    $images->save('public/uploads/student/' . $name);
                    $imageName = 'public/uploads/student/' . $name;
                    // $data->staff_photo =  $imageName;
                    Session::put('student_photo', $imageName);
                } else {
                    $name = md5($file->getClientOriginalName() . time()) . "." . "png";
                    if (file_exists(Session::get('student_photo')) || file_exists($data->student_photo)) {
//                        File::delete($data->student_photo);
//                        File::delete(Session::get('student_photo'));
                    }
                    $images->save('public/uploads/student/' . $name);
                    $imageName = 'public/uploads/student/' . $name;
                    // $data->student_photo =  $imageName;
                    Session::put('student_photo', $imageName);
                }
            }
            // parent
            if ($r->hasFile('fathers_photo')) {
                $file = $r->file('fathers_photo');
                $images = Image::make($file)->insert($file);
                $pathImage = 'public/uploads/student/';
                if (!file_exists($pathImage)) {
                    mkdir($pathImage, 0777, true);
                    $name = md5($file->getClientOriginalName() . time()) . "." . "png";
                    $images->save('public/uploads/student/' . $name);
                    $imageName = 'public/uploads/student/' . $name;
                    // $data->staff_photo =  $imageName;
                    Session::put('fathers_photo', $imageName);
                } else {
                    $name = md5($file->getClientOriginalName() . time()) . "." . "png";
                    if (file_exists(Session::get('fathers_photo')) || file_exists($data_parent->fathers_photo)) {
//                        File::delete(Session::get('fathers_photo'));
//                        File::delete($data_parent->fathers_photo);
                    }
                    $images->save('public/uploads/student/' . $name);
                    $imageName = 'public/uploads/student/' . $name;
                    // $data->fathers_photo =  $imageName;
                    Session::put('fathers_photo', $imageName);
                }
            }
            //mother
            if ($r->hasFile('mothers_photo')) {
                $file = $r->file('mothers_photo');
                $images = Image::make($file)->insert($file);
                $pathImage = 'public/uploads/student/';
                if (!file_exists($pathImage)) {
                    mkdir($pathImage, 0777, true);
                    $name = md5($file->getClientOriginalName() . time()) . "." . "png";
                    $images->save('public/uploads/student/' . $name);
                    $imageName = 'public/uploads/student/' . $name;
                    // $data->staff_photo =  $imageName;
                    Session::put('mothers_photo', $imageName);
                } else {
                    $name = md5($file->getClientOriginalName() . time()) . "." . "png";
                    if (file_exists(Session::get('mothers_photo')) || file_exists($data_parent->mothers_photo)) {
//                        File::delete(Session::get('mothers_photo'));
//                        File::delete($data_parent->mothers_photo);
                    }
                    $images->save('public/uploads/student/' . $name);
                    $imageName = 'public/uploads/student/' . $name;
                    // $data->mothers_photo =  $imageName;
                    Session::put('mothers_photo', $imageName);
                }
            }
            //guardians_photo
            if ($r->hasFile('guardians_photo')) {
                $file = $r->file('guardians_photo');
                $images = Image::make($file)->insert($file);
                $pathImage = 'public/uploads/student/';
                if (!file_exists($pathImage)) {
                    mkdir($pathImage, 0777, true);
                    $name = md5($file->getClientOriginalName() . time()) . "." . "png";
                    $images->save('public/uploads/student/' . $name);
                    $imageName = 'public/uploads/student/' . $name;
                    // $data->staff_photo =  $imageName;
                    Session::put('guardians_photo', $imageName);
                } else {
                    $name = md5($file->getClientOriginalName() . time()) . "." . "png";
                    if (file_exists(Session::get('guardians_photo')) || file_exists($data_parent->guardians_photo)) {
//                        File::delete(Session::get('guardians_photo'));
//                        File::delete($data_parent->guardians_photo);
                    }
                    $images->save('public/uploads/student/' . $name);
                    $imageName = 'public/uploads/student/' . $name;
                    // $data->guardians_photo =  $imageName;
                    Session::put('guardians_photo', $imageName);
                }
            }

            return response()->json('success', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'error'], 201);
        }
    }

    public function studentUpdate(Request $request)
    {
//        dd($request->all());
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $student_detail = SmStudent::find($request->id);

        $is_duplicate = SmStudent::where('school_id', Auth::user()->school_id)->where('admission_no', $request->admission_number)->where('id', '!=', $request->id)->first();
        if ($is_duplicate) {
            Toastr::error('Duplicate admission number found!', 'Failed');
            return redirect()->back()->withInput();
        }
//        $is_duplicate = SmParent::where('school_id', Auth::user()->school_id)->where('guardians_email', $request->guardians_email)->where('id', '!=', $student_detail->parent_id)->first();
//        if ($is_duplicate) {
//            Toastr::error('Duplicate guardian email found!', 'Failed');
//            return redirect()->back()->withInput();
//        }

//        $is_duplicate = SmParent::where('school_id', Auth::user()->school_id)->where('guardians_mobile', $request->guardians_mobile)->where('id', '!=', $student_detail->parent_id)->first();
//        if ($is_duplicate) {
//            Toastr::error('Duplicate guardian mobile number found!', 'Failed');
//            return redirect()->back()->withInput();
//        }


        if (($request->sibling_id == 0 || $request->sibling_id == 1) && $request->parent_id == "") {

            $request->validate([
                'admission_number' => 'required',
                'roll_number' => 'required',
                'class' => 'required',
                'section' => 'required',
                'gender' => 'required',
                'first_name' => 'required|max:100',
                'date_of_birth' => 'required',
//                'guardians_email' => 'required',
                'guardians_phone' => 'required'
            ]);
        } elseif ($request->sibling_id == 0 && $request->parent_id != "") {
            $request->validate([
                'admission_number' => 'required',
                'roll_number' => 'required',
                'class' => 'required',
                'section' => 'required',
                'gender' => 'required',
                'first_name' => 'required|max:100',
                'date_of_birth' => 'required'
            ]);
        } elseif (($request->sibling_id == 2 || $request->sibling_id == 1) && $request->parent_id != "") {
            $request->validate([
                'admission_number' => 'required',
                'roll_number' => 'required',
                'class' => 'required',
                'section' => 'required',
                'gender' => 'required',
                'first_name' => 'required|max:100',
                'date_of_birth' => 'required'
            ]);
        } elseif ($request->sibling_id == 2 && $request->parent_id == "") {
            $request->validate([
                'admission_number' => 'required',
                'roll_number' => 'required',
                'class' => 'required',
                'section' => 'required',
                'gender' => 'required',
                'first_name' => 'required|max:100',
                'date_of_birth' => 'required',
//                'guardians_email' => 'required',
                'guardians_phone' => 'required'
            ]);
        }




        //always happen start
        // $student_photo = "";
        // if ($request->file('photo') != "") {
        //     if ($student_detail->student_photo != "") {
        //         if (file_exists($student_detail->student_photo)) {
        //             unlink($student_detail->student_photo);
        //         }
        //     }
        //     $file = $request->file('photo');
        //     $student_photo = 'stu-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
        //     $file->move('public/uploads/student/', $student_photo);
        //     $student_photo =  'public/uploads/student/' . $student_photo;
        // }



        // if (($request->sibling_id == 0 || $request->sibling_id == 1) && $request->parent_id == "") {

        //     //fathers photo
        //     $fathers_photo = "";
        //     if ($request->file('fathers_photo') != "") {
        //         if ($student_detail->parents->fathers_photo != "") {
        //             if (file_exists($student_detail->parents->fathers_photo)) {
        //                 unlink($student_detail->parents->fathers_photo);
        //             }
        //         }
        //         $file = $request->file('fathers_photo');
        //         $fathers_photo = 'fat-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
        //         $file->move('public/uploads/student/', $fathers_photo);
        //         $fathers_photo =  'public/uploads/student/' . $fathers_photo;
        //     }
        //     //Mothers photo
        //     $mothers_photo = "";
        //     if ($request->file('mothers_photo') != "") {
        //         if ($student_detail->parents->mothers_photo != "") {
        //             if (file_exists($student_detail->parents->mothers_photo)) {
        //                 unlink($student_detail->parents->mothers_photo);
        //             }
        //         }
        //         $file = $request->file('mothers_photo');
        //         $mothers_photo = 'mot-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
        //         $file->move('public/uploads/student/', $mothers_photo);
        //         $mothers_photo =  'public/uploads/student/' . $mothers_photo;
        //     }
        //     //always happen end


        //     $guardians_photo = "";
        //     if ($request->relationButton == "F") {
        //         if ($request->file('fathers_photo') == "") {
        //             if ($student_detail->parents->fathers_photo == "") {
        //                 $guardians_photo =  $fathers_photo;
        //             } else {
        //                 $guardians_photo =  $student_detail->parents->fathers_photo;
        //             }
        //         }
        //     } elseif ($request->relationButton == "M") {
        //         if ($request->file('mothers_photo') == "") {
        //             if ($student_detail->parents->mothers_photo == "") {
        //                 $guardians_photo =  $mothers_photo;
        //             } else {
        //                 $guardians_photo =   $student_detail->parents->mothers_photo;
        //             }
        //         }
        //     } else {
        //         if ($request->file('guardians_photo') != "") {
        //             if ($student_detail->parents->guardians_photo != "") {
        //                 if ($student_detail->parents->relation == "O") {
        //                     //unlink($sibling_detail->parents->guardians_photo);
        //                 }
        //             }
        //             $file = $request->file('guardians_photo');
        //             $guardians_photo = 'guar-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
        //             $file->move('public/uploads/student/', $guardians_photo);
        //             $guardians_photo =  'public/uploads/student/' . $guardians_photo;
        //         }
        //     }
        // } elseif ($request->sibling_id == 0 && $request->parent_id != "") {


        //     if ($student_detail->parents->fathers_photo != "") {
        //         if (file_exists($student_detail->parents->fathers_photo)) {
        //             unlink($student_detail->parents->fathers_photo);
        //         }
        //     }
        //     if ($student_detail->parents->mothers_photo != "") {
        //         if (file_exists($student_detail->parents->mothers_photo)) {
        //             unlink($student_detail->parents->mothers_photo);
        //         }
        //     }
        //     if ($student_detail->parents->relation != "") {
        //         if ($student_detail->parents->relation == "O") {
        //             //unlink($student_detail->parents->guardians_photo);
        //         }
        //     }
        // } elseif (($request->sibling_id == 2 || $request->sibling_id == 1) && $request->parent_id != "") {
        //     $fathers_photo = "";
        //     $mothers_photo = "";
        //     $guardians_photo = "";
        // } elseif ($request->sibling_id == 2 && $request->parent_id == "") {
        //     $student_photo = "";
        //     if ($request->file('photo') != "") {
        //         $file = $request->file('photo');
        //         $student_photo = 'stu-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
        //         $file->move('public/uploads/student/', $student_photo);
        //         $student_photo =  'public/uploads/student/' . $student_photo;
        //     }

        //     if ($request->parent_id == "") {

        //         $fathers_photo = "";
        //         if ($request->file('fathers_photo') != "") {
        //             $file = $request->file('fathers_photo');
        //             $fathers_photo = 'fat-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
        //             $file->move('public/uploads/student/', $fathers_photo);
        //             $fathers_photo =  'public/uploads/student/' . $fathers_photo;
        //         }

        //         $mothers_photo = "";
        //         if ($request->file('mothers_photo') != "") {
        //             $file = $request->file('mothers_photo');
        //             $mothers_photo = 'mot-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
        //             $file->move('public/uploads/student/', $mothers_photo);
        //             $mothers_photo =  'public/uploads/student/' . $mothers_photo;
        //         }
        //         $guardians_photo = "";
        //         if ($request->relationButton == "F") {
        //             $guardians_photo =  $fathers_photo;
        //         } elseif ($request->relationButton == "M") {
        //             $guardians_photo =  $mothers_photo;
        //         } else {
        //             if ($request->file('guardians_photo') != "") {
        //                 $file = $request->file('guardians_photo');
        //                 $guardians_photo = 'guar-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
        //                 $file->move('public/uploads/student/', $guardians_photo);
        //                 $guardians_photo =  'public/uploads/student/' . $guardians_photo;
        //             }
        //         }
        //     }
        // }



        // always happen start

        $document_file_1 = "";
        if ($request->file('document_file_1') != "") {
            if ($student_detail->document_file_1 != "") {
                if (file_exists($student_detail->document_file_1)) {
                    unlink($student_detail->document_file_1);
                }
            }
            $file = $request->file('document_file_1');
            $document_file_1 = 'doc1-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move('public/uploads/student/document/', $document_file_1);
            $document_file_1 =  'public/uploads/student/document/' . $document_file_1;
        }

        $document_file_2 = "";
        if ($request->file('document_file_2') != "") {
            if ($student_detail->document_file_2 != "") {
                if (file_exists($student_detail->document_file_2)) {
                    unlink($student_detail->document_file_2);
                }
            }
            $file = $request->file('document_file_2');
            $document_file_2 = 'doc2-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move('public/uploads/student/document/', $document_file_2);
            $document_file_2 =  'public/uploads/student/document/' . $document_file_2;
        }

        $document_file_3 = "";
        if ($request->file('document_file_3') != "") {
            if ($student_detail->document_file_3 != "") {
                if (file_exists($student_detail->document_file_3)) {
                    unlink($student_detail->document_file_3);
                }
            }
            $file = $request->file('document_file_3');
            $document_file_3 = 'doc3-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move('public/uploads/student/document/', $document_file_3);
            $document_file_3 =  'public/uploads/student/document/' . $document_file_3;
        }

        $document_file_4 = "";
        if ($request->file('document_file_4') != "") {
            if ($student_detail->document_file_4 != "") {
                if (file_exists($student_detail->document_file_4)) {
                    unlink($student_detail->document_file_4);
                }
            }
            $file = $request->file('document_file_4');
            $document_file_4 = 'doc4-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move('public/uploads/student/document/', $document_file_4);
            $document_file_4 =  'public/uploads/student/document/' . $document_file_4;
        }

        $document_file_5 = "";
        if ($request->file('document_file_5') != "") {
            if ($student_detail->document_file_5 != "") {
                if (file_exists($student_detail->document_file_5)) {
                    unlink($student_detail->document_file_5);
                }
            }
            $file = $request->file('document_file_5');
            $document_file_5 = 'doc1-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move('public/uploads/student/document/', $document_file_5);
            $document_file_5 =  'public/uploads/student/document/' . $document_file_5;
        }


        $shcool_details = SmGeneralSettings::find(1);
        $school_name = explode(' ', $shcool_details->school_name);
        $short_form = '';

        foreach ($school_name as $value) {
            $ch = str_split($value);
            $short_form = $short_form . '' . $ch[0];
        }



        DB::beginTransaction();

        try {
            $user_stu = User::find($student_detail->user_id);
            $user_stu->role_id = 2;


            $user_stu->username = $request->admission_number;


            $user_stu->email = $request->email_address;


            $user_stu->password = Hash::make(123456);
            $user_stu->save();
            $user_stu->toArray();



            try {
                if (($request->sibling_id == 0 || $request->sibling_id == 1) && $request->parent_id == "") {

                    $user_parent = User::find($student_detail->parents->user_id);
                    $user_parent->role_id = 3;
                    $user_parent->username = $request->guardians_email;
                    $user_parent->email = $request->guardians_email;
                    $user_parent->password = Hash::make(123456);
                    $user_parent->save();
                    $user_parent->toArray();
                } elseif ($request->sibling_id == 0 && $request->parent_id != "") {
                    User::destroy($student_detail->parents->user_id);
                } elseif (($request->sibling_id == 2 || $request->sibling_id == 1) && $request->parent_id != "") {
                } elseif ($request->sibling_id == 2 && $request->parent_id == "") {
                    $user_parent = new User();
                    $user_parent->role_id = 3;

                    $user_parent->username = $request->guardians_email;
                    $user_parent->email = $request->guardians_email;

                    $user_parent->password = Hash::make(123456);
                    $user_parent->save();
                    $user_parent->toArray();
                }
                try {

                    if (($request->sibling_id == 0 || $request->sibling_id == 1) && $request->parent_id == "") {

                        $parent = SmParent::find($student_detail->parent_id);
                        $parent->user_id = $user_parent->id;
                        $parent->fathers_name = $request->fathers_name;
                        $parent->fathers_mobile = $request->fathers_phone;
                        $parent->fathers_occupation = $request->fathers_occupation;
                        $parent->fathers_photo = Session::get('fathers_photo');
                        $parent->mothers_name = $request->mothers_name;
                        $parent->mothers_mobile = $request->mothers_phone;
                        $parent->mothers_occupation = $request->mothers_occupation;
                        $parent->mothers_photo = Session::get('mothers_photo');
                        $parent->guardians_name = $request->guardians_name;
                        $parent->guardians_mobile = $request->guardians_phone;
                        $parent->guardians_email = $request->guardians_email;
                        $parent->guardians_occupation = $request->guardians_occupation;
                        $parent->guardians_relation = $request->relation;
                        $parent->relation = $request->relationButton;
                        $parent->guardians_photo = Session::get('guardians_photo');
                        $parent->guardians_address = $request->guardians_address;
                        $parent->is_guardian = $request->is_guardian;
                        $parent->save();
                        $parent->toArray();
                    } elseif ($request->sibling_id == 0 && $request->parent_id != "") {
                        SmParent::destroy($student_detail->parent_id);
                    } elseif (($request->sibling_id == 2 || $request->sibling_id == 1) && $request->parent_id != "") {
                    } elseif ($request->sibling_id == 2 && $request->parent_id == "") {
                        $parent = new SmParent();
                        $parent->user_id = $user_parent->id;
                        $parent->fathers_name = $request->fathers_name;
                        $parent->fathers_mobile = $request->fathers_phone;
                        $parent->fathers_occupation = $request->fathers_occupation;
                        $parent->fathers_photo = Session::get('fathers_photo');
                        $parent->mothers_name = $request->mothers_name;
                        $parent->mothers_mobile = $request->mothers_phone;
                        $parent->mothers_occupation = $request->mothers_occupation;
                        $parent->mothers_photo = Session::get('mothers_photo');
                        $parent->guardians_name = $request->guardians_name;
                        $parent->guardians_mobile = $request->guardians_phone;
                        $parent->guardians_email = $request->guardians_email;
                        $parent->guardians_occupation = $request->guardians_occupation;
                        $parent->guardians_relation = $request->relation;
                        $parent->relation = $request->relationButton;
                        $parent->guardians_photo = Session::get('guardians_photo');
                        $parent->guardians_address = $request->guardians_address;
                        $parent->is_guardian = $request->is_guardian;
                        $parent->save();
                        $parent->toArray();
                    }

                    try {
                        $student = SmStudent::find($request->id);

                        if (($request->sibling_id == 0 || $request->sibling_id == 1) && $request->parent_id == "") {
                            $student->parent_id = $parent->id;
                        } elseif ($request->sibling_id == 0 && $request->parent_id != "") {
                            $student->parent_id = $request->parent_id;
                        } elseif (($request->sibling_id == 2 || $request->sibling_id == 1) && $request->parent_id != "") {
                            $student->parent_id = $request->parent_id;
                        } elseif ($request->sibling_id == 2 && $request->parent_id == "") {
                            $student->parent_id = $parent->id;
                        }
                        $student->class_id = $request->class;
                        $student->semester_id = $request->semester;
                        $student->student_year_id = $request->student_year;
                        $student->nationality = $request->nationality;
                        $student->section_id = $request->section;
                        $student->session_id = $request->session;
                        $student->user_id = $user_stu->id;
                        $student->house_student = $request->house_student;
                        $student->street_student = $request->street_student;
                        $student->group_student = $request->group_student;
                        $student->village_student = $request->village_student;
                        $student->commune_student = $request->commune_student;
                        $student->district_student = $request->district_student;
                        $student->province_student = $request->province_student;
                        $student->village_school = $request->village_school;
                        $student->commune_school = $request->commune_school;
                        $student->district_school = $request->district_school;
                        $student->from_school = $request->from_school;
                        $student->province_school = $request->province_school;
                        $student->degree_year = $request->degree_year;
                        $student->degree_no = $request->degree_no;
                        $student->subject1 = $request->subject1;
                        $student->subject2 = $request->subject2;
                        $student->subject3 = $request->subject3;
                        $student->subject4 = $request->subject4;
                        $student->subject5 = $request->subject5;
                        $student->subject6 = $request->subject6;
                        $student->total_grade = $request->total_grade;
                        $student->total_score = $request->total_score;
                        $student->degree_level = $request->degree_level;
                        $student->grade1 = $request->grade1;
                        $student->grade2 = $request->grade2;
                        $student->grade3 = $request->grade3;
                        $student->grade4 = $request->grade4;
                        $student->grade5 = $request->grade5;
                        $student->grade6 = $request->grade6;
                        $student->house_birth = $request->house_birth;
                        $student->group_birth = $request->group_birth;
                        $student->village_birth = $request->village_birth;
                        $student->commune_birth = $request->commune_birth;
                        $student->district_birth = $request->district_birth;
                        $student->city = $request->city;
                        $student->external = $request->external;

                        $student->admission_no = $request->admission_number;

                        $student->roll_no = $request->roll_number;
                        $student->first_name = $request->first_name;
                        $student->last_name = $request->last_name;
                        $student->full_name = $request->first_name . ' ' . $request->last_name;
                        $student->gender_id = $request->gender;
                        $student->date_of_birth = date('Y-m-d', strtotime($request->date_of_birth));
                        if (@$request->category != "") {
                            $student->student_category_id = $request->category;
                        }
                        $student->caste = $request->caste;
                        $student->email = $request->email_address;
                        $student->mobile = $request->phone_number;
                        $student->admission_date = date('Y-m-d', strtotime($request->admission_date));
                        $student->student_photo = Session::get('student_photo');
                        /* if ($student_photo != "") {
                        } */
                        if (@$request->blood_group != "") {
                            $student->bloodgroup_id = $request->blood_group;
                        }
                        if (@$request->religion != "") {
                            $student->religion_id = $request->religion;
                        }

                        $student->height = $request->height;
                        $student->weight = $request->weight;
                        $student->current_address = $request->current_address;
                        $student->permanent_address = $request->permanent_address;

                        if (@$request->route != "") {
                            $student->route_list_id = $request->route;
                        }
                        if (@$request->dormitory_name != "") {
                            $student->dormitory_id = $request->dormitory_name;
                        }
                        if (@$request->room_id != "") {
                            $student->room_id = $request->room_id;
                        }

                        if (!empty($request->vehicle)) {
                            $driver = SmVehicle::where('id', '=', $request->vehicle)
                                ->select('driver_id')
                                ->first();

                            $student->vechile_id = $request->vehicle;
                            $student->driver_id = $driver->driver_id;
                        }
                        //$student->driver_id = $request->driver_id;

                        // $student->driver_phone_no = $request->driver_phone;
                        $student->national_id_no = $request->national_id_number;
                        $student->local_id_no = $request->local_id_number;
                        $student->bank_account_no = $request->bank_account_number;
                        $student->bank_name = $request->bank_name;
                        $student->previous_school_details = $request->previous_school_details;
                        $student->aditional_notes = $request->additional_notes;
                        $student->document_title_1 = $request->document_title_1;
                        if ($document_file_1 != "") {
                            $student->document_file_1 =  $document_file_1;
                        }

                        $student->document_title_2 = $request->document_title_2;
                        if ($document_file_2 != "") {
                            $student->document_file_2 =  $document_file_2;
                        }

                        $student->document_title_3 = $request->document_title_3;
                        if ($document_file_3 != "") {
                            $student->document_file_3 = $document_file_3;
                        }

                        $student->document_title_4 = $request->document_title_4;

                        if ($document_file_4 != "") {
                            $student->document_file_4 = $document_file_4;
                        }

                        $student->document_title_5 = $request->document_title_5;

                        if ($document_file_5 != "") {
                            $student->document_file_5 = $document_file_5;
                        }

                        if($student->save()){
                            Customer::getCustomer($student);
                        }
                        DB::commit();
                        Toastr::success('Operation successful', 'Success');
                        return redirect('student-list');
                    } catch (\Exception $e) {
                        DB::rollback();
                        Toastr::error('Operation Failed', 'Failed');
                        return redirect()->back();
                    }
                } catch (\Exception $e) {
                    DB::rollback();
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
            } catch (\Exception $e) {
                // return $e;
                DB::rollback();
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function studentPromote(Request $request)
    {
    try {
        $sessions = SmAcademicYear::where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
        $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
            $data = [];
            $data['sessions'] = $sessions->toArray();
            $data['classes'] = $classes->toArray();
            return ApiBaseMethod::sendResponse($data, null);
        }
        $exams = SmExamType::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

        $generalSetting = SmGeneralSettings::where('school_id', Auth::user()->school_id)->first();

        if ($generalSetting->promotionSetting == 0) {
            return view('backEnd.studentInformation.student_promote', compact('sessions', 'classes', 'exams'));
        } else {
            return view('backEnd.studentInformation.student_promote_custom', compact('sessions', 'classes', 'exams'));
        }


        // return view('backEnd.studentInformation.student_promote', compact('sessions', 'classes', 'exams'));

    } catch (\Exception $e) {
        Toastr::error('Operation Failed', 'Failed');
        return redirect()->back();
    }
}
    public function studentPromoteCustom(Request $request)
    {
        try {
            $sessions = SmAcademicYear::where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['sessions'] = $sessions->toArray();
                $data['classes'] = $classes->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            $exams = SmExamType::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

            $generalSetting = SmGeneralSettings::find(1);

            if ($generalSetting->promotionSetting == 0) {
                return view('backEnd.studentInformation.student_promote', compact('sessions', 'classes', 'exams'));
            } else {
                return view('backEnd.studentInformation.student_promote_custom', compact('sessions', 'classes', 'exams'));
            }


            // return view('backEnd.studentInformation.student_promote', compact('sessions', 'classes', 'exams'));

        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }



    public function ajaxStudentPromoteSection(Request $request)
    {
        $sectionIds = SmClassSection::where('class_id', '=', $request->id)->get();

        $promote_sections = [];
        foreach ($sectionIds as $sectionId) {
            $promote_sections[] = SmSection::find($sectionId->section_id);
        }

        return response()->json([$promote_sections]);
    }

//    public function ajaxStudentMajor(Request $request)
//    {
//
//
//        $majors = SmMajor::where('faculty_id', '=', $request->id)->get();
//
//
//        return response()->json([$majors]);
//    }

    public function ajaxGetClass(Request $request)
    {
        $classes = SmClass::where('created_at', 'LIKE', $request->year . '%')->get();

        return response()->json([$classes]);
    }



    public function SearchMultipleSection(Request $request)
    {
        $sectionIds = SmClassSection::where('class_id', '=', $request->id)->where('school_id', Auth::user()->school_id)->get();
        return response()->json([$sectionIds]);
    }





    public function ajaxSelectStudent(Request $request)
    {
        $students = SmStudent::where('class_id', '=', $request->class)->where('section_id', $request->section)->where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

        return response()->json([$students]);
    }


    public function studentCurrentSearch(Request $request)
    {
//dd($request->all());
        $input = $request->all();
        $validator = Validator::make($input, [
            'current_session' => 'required',
            'current_class' => 'required',
            'section' => 'required',
            'result' => 'required',
            'exam' => 'required',
        ]);

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
//        try {
            if ($request->result == 'F') {
                $students = SmGeneralSettings::make_merit_list($request->current_class, $request->section, $request->exam);
                // return  $students;
                $fail_result=DB::table('sm_temporary_meritlists')
                ->where('class_id',$request->current_class)
                ->where('exam_id',$request->exam)
                ->where('result','F')
                ->get();
                if (empty($fail_result)) {
                    Toastr::error('Meritlist not generated', 'Failed');
                    return redirect()->back();
                } else

                    $students=array();
                    foreach ($fail_result as $key => $value) {

                    // $d = SmStudent::where('id', $value->student_id)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->first();
                    $d = SmStudent::join('sm_temporary_meritlists','sm_temporary_meritlists.student_id','=','sm_students.id')
                    ->join('sm_classes','sm_classes.id','=','sm_temporary_meritlists.class_id')
                        ->where('sm_students.id', $value->student_id)
                        ->where('sm_temporary_meritlists.exam_id', $request->exam)
                        ->first();
                        $students[]=$d->toArray();
                }
                if ($students==null) {
                    Toastr::error('Student not found', 'Failed');
                    return redirect()->back();
                }
            } else {
                $pass_result=DB::table('sm_temporary_meritlists')
                    ->where('class_id',$request->current_class)
                    ->where('exam_id',$request->exam)
                    ->where('result','<>','F')
                    ->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')
                    ->get();
//                dd($pass_result);
                if (empty($pass_result)) {
                    Toastr::error('Meritlist not generated', 'Failed');
                    return redirect()->back();
                } else

                    $students=array();
                foreach ($pass_result as $key => $value) {

//                     $d = SmStudent::where('id', $value->student_id)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->first();
                    $d = SmStudent::join('sm_temporary_meritlists','sm_temporary_meritlists.student_id','=','sm_students.id')
                        ->join('sm_classes','sm_classes.id','=','sm_temporary_meritlists.class_id')
                        ->where('sm_students.id', $value->student_id)
                        ->where('sm_temporary_meritlists.exam_id', $request->exam)
                        ->where('sm_students.created_at', 'LIKE', '%' . YearCheck::getYear() . '%')
                        ->first();
//                    dd($d);
                    $students[]=$d->toArray();
                }
//                $students = SmGeneralSettings::make_merit_list($request->current_class, $request->section, $request->exam);
//                if (@$students == 0) {
//                    Toastr::error('Meritlist not generated', 'Failed');
//                    return redirect()->back();
//                } else
//                    $students['students'] = [];
//                foreach ($students['allresult_data'] as $key => $value) {
//
//                     $d = SmStudent::where('id', $value->student_id)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->first();
////                    $d = SmStudent::join('sm_temporary_meritlists','sm_temporary_meritlists.student_id','=','sm_students.id')
////                        ->where('sm_students.id', $value->student_id)
////                        ->where('sm_temporary_meritlists.exam_id', $request->exam)
////                        ->where('sm_temporary_meritlists.result', '!=','F')
////                        ->first();
//                    if ($d) {
//                        array_push($students['students'], $d);
//                    }
//                }
//                if ($students['students']==null) {
//                    Toastr::error('Student not found', 'Failed');
//                    return redirect()->back();
//                }
           
            }
            $current_session = $request->current_session;
            $current_class = $request->current_class;
            $sessions = SmAcademicYear::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $UpYear = SmAcademicYear::find($current_session);


            $Upsessions = SmAcademicYear::where('active_status', 1)->whereYear('created_at', '>', date('Y', strtotime($UpYear->year)) . ' 00:00:00')->where('school_id', Auth::user()->school_id)->get();



            $Upcls = SmClass::find($current_class);
            $Upclasses = SmClass::where('active_status', 1)->whereYear('created_at', '>', date('Y', strtotime($UpYear->year)) . ' 00:00:00')->where('school_id', Auth::user()->school_id)->get();

            if (@$students['allresult_data'] ? $students['allresult_data']->isEmpty() : empty($students)) {
                Toastr::error('No result found', 'Failed');
                return redirect('student-promote');
            }

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['sessions'] = $sessions->toArray();
                $data['classes'] = $classes->toArray();
                $data['students'] = $students->toArray();
                $data['current_session'] = $current_session;
                $data['current_class'] = $current_class;
                return ApiBaseMethod::sendResponse($data, null);
            }
            $exams = SmExamType::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
           if ($request->result == 'F') {
                 return view('backEnd.studentInformation.student_promote_fail', compact('exams', 'Upsessions', 'sessions', 'classes', 'students', 'current_session', 'current_class', 'Upclasses', 'Upcls', 'UpYear'));
      
           } else {
                 return view('backEnd.studentInformation.student_promote', compact('exams', 'Upsessions', 'sessions', 'classes', 'students', 'current_session', 'current_class', 'Upclasses', 'Upcls', 'UpYear'));
      
           }
//       } catch (\Exception $e) {
////            dd($e);
//            Toastr::error('Operation Failed', 'Failed');
//            return redirect()->back();
//        }
    }
    public function studentCurrentSearchCustom(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'current_session' => 'required',
            'current_class' => 'required',
            'section' => 'required',
        ]);

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {

            $students = SmStudent::where('class_id', '=', $request->current_class)->where('session_id', '=', $request->current_session)->where('section_id', $request->section)->where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

            $current_session = $request->current_session;
            $current_class = $request->current_class;
            $sessions = SmAcademicYear::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $UpYear = SmAcademicYear::find($current_session);
            $Upsessions = SmAcademicYear::where('active_status', 1)->whereYear('created_at', '>', date('Y', strtotime($UpYear->year)) . ' 00:00:00')->where('school_id', Auth::user()->school_id)->get();
            $Upcls = SmClass::find($current_class);
            $Upclasses = SmClass::where('active_status', 1)->whereYear('created_at', '>', date('Y', strtotime($UpYear->year)) . ' 00:00:00')->where('school_id', Auth::user()->school_id)->get();
            if (@$students['allresult_data'] ? $students['allresult_data']->isEmpty() : empty($students)) {
                Toastr::error('No result found', 'Failed');
                return redirect('student-promote');
            }

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['sessions'] = $sessions->toArray();
                $data['classes'] = $classes->toArray();
                $data['students'] = $students->toArray();
                $data['current_session'] = $current_session;
                $data['current_class'] = $current_class;
                return ApiBaseMethod::sendResponse($data, null);
            }
            $exams = SmExamType::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            return view('backEnd.studentInformation.student_promote_custom', compact('exams', 'Upsessions', 'sessions', 'classes', 'students', 'current_session', 'current_class', 'Upclasses', 'Upcls', 'UpYear'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function ajaxPromoteYear(Request $request)
    {
        $year_name = SmAcademicYear::where('id', '=', $request->year)->select('year')->first();
        $classes = SmClass::where('created_at', 'LIKE', '%' . $year_name->year . '%')->where('school_id', Auth::user()->school_id)->get();

        return response()->json([$classes]);

        // return response()->json($year_name, 200);
        // return response()->json($request->year, 200);
    }
    public function studentPromoteStore(Request $request)
    {
//dd($request->all());
        $input = $request->all();
        $validator = Validator::make($input, [
            'promote_session' => 'required',
            'promote_class' => 'required',
            'promote_section' => 'required',
        ]);

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // dd($request->all());

        // return $request;

//        try {
            $current_session = $request->current_session;
            $current_class = $request->current_class;
            $UpYear = SmAcademicYear::find($current_session);
            $exams = SmExamType::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $Upsessions = SmAcademicYear::where('active_status', 1)->whereYear('created_at', '>', date('Y', strtotime($UpYear->year)) . ' 00:00:00')->where('school_id', Auth::user()->school_id)->get();
            $sessions = SmAcademicYear::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $promot_year = SmAcademicYear::find($request->promote_session);
            // return $request;
            if ($request->promote_class == "" || $request->promote_session == "") {
                $students = SmStudent::where('class_id', '=', $request->promote_class)->where('session_id', '=', $request->promote_session)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
                //dd($students);
                Session::flash('message-danger', 'Something went wrong, please try again');

                if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                    $data = [];
                    $data['sessions'] = $sessions->toArray();
                    $data['classes'] = $classes->toArray();
                    $data['students'] = $students->toArray();
                    $data['current_session'] = $current_session;
                    $data['current_class'] = $current_class;
                    return ApiBaseMethod::sendResponse($data, null);
                }
                return view('backEnd.studentInformation.student_promote', compact('exams', 'Upsessions', 'sessions', 'classes', 'students', 'current_session', 'current_class'));
            } else {

//                DB::beginTransaction();

//                try {
                    $std_info = [];

                   // dd($request->all(),$request->id);
                    foreach ($request->id as $student_id) {



                        $student_details = SmStudent::find($student_id);
//dd($student_id,$student_details);
                        $new_academic_year = SmAcademicYear::find($request->promote_session);

                        $old_section = SmSection::find(@$student_details->section_id);

                        $new_section = $request->promote_section;
                        // return $request->result[$student_id] ;
//                        dd('faoi');
                        if ($request->result[$student_id] == 'P') {
                            $merit_list = \App\SmTemporaryMeritlist::where(['student_id' => $student_id, 'class_id' => $request->current_class, 'section_id' => $student_details->section_id])->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->first();
                            $roll = @$merit_list->merit_order;
                        } else {
                            $roll = null;
                            $merit_list = null;
                        }

                        $student_promote = new SmStudentPromotion();
                        $student_promote->student_id = $student_id;
                        $student_promote->previous_class_id = $request->current_class;
                        $student_promote->current_class_id = $request->promote_class;
                        $student_promote->previous_session_id = $request->current_session;
                        $student_promote->current_session_id = $request->promote_session;

//                        $student_promote->new_academic_year = $new_academic_year;
                        $student_promote->previous_section_id = $student_details->section_id;
                        $student_promote->current_section_id = $new_section;

                        $student_promote->admission_number = $student_details->admission_no;
                        $student_promote->student_info = $student_details->toJson();
                        $student_promote->merit_student_info = ($merit_list != null ? $merit_list->toJson() : $student_details->toJson());

                        $student_promote->previous_roll_number = $student_details->roll_no;
                        $student_promote->current_roll_number = $roll;

                        $student_promote->result_status = $request->result[$student_id];
                        $student_promote->save();
//                        dd($student_promote);

                        $student = SmStudent::find($student_id);
                        $student->class_id = $request->promote_class;
                        $student->session_id = $request->promote_session;
                        $student->section_id = $new_section;
//                        $student->roll_no = $roll;
                        $student->created_at = $promot_year->starting_date . ' 12:00:00';
                        $student->save();
                    }


//                    DB::commit();

                    $students = SmStudent::where('class_id', '=', $request->promote_class)->where('session_id', '=', $request->promote_session)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

//                    if (ApiBaseMethod::checkUrl($request->fullUrl())) {
//                        return ApiBaseMethod::sendResponse(null, 'Student has been promoted successfully');
//                    }
                    Toastr::success('Operation successful', 'Success');



                return view('backEnd.studentInformation.student_promote', compact('exams', 'Upsessions', 'sessions', 'classes', 'students', 'current_session', 'current_class'));

              //  return redirect('student-promote');
//                } catch (\Exception $e) {
//                    DB::rollback();
//                    $students = SmStudent::where('class_id', '=', $request->current_class)->where('session_id', '=', $request->current_session)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
//
//                    Session::flash('message-danger-table', 'Something went wrong, please try again');
//
//                    if (ApiBaseMethod::checkUrl($request->fullUrl())) {
//                        $data = [];
//                        $data['sessions'] = $sessions->toArray();
//                        $data['classes'] = $classes->toArray();
//                        $data['students'] = $students->toArray();
//                        $data['current_session'] = $current_session;
//                        $data['current_class'] = $current_class;
//                        return ApiBaseMethod::sendResponse($data, 'Something went wrong, please try again');
////                    }
//                        Toastr::error('Operation Failed', 'Failed');
//                        return view('backEnd.studentInformation.student_promote', compact('exams', 'Upsessions', 'sessions', 'classes', 'students', 'current_session', 'current_class'));
//                    }
//                }
            }
//        } catch (\Exception $e) {
//            Toastr::error('Operation Failed', 'Failed');
//            return redirect()->back();
//        }
    }
    public function studentPromoteCustomStore(Request $request)
    {

        // return $request;
        $input = $request->all();
        $validator = Validator::make($input, [
            'promote_session' => 'required',
            'promote_class' => 'required',
            'promote_section' => 'required',
        ]);

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // dd($request->all());

        // return $request;

        try {
            $current_session = $request->current_session;
            $current_class = $request->current_class;
            $UpYear = SmAcademicYear::find($current_session);
            $exams = SmExamType::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $Upsessions = SmAcademicYear::where('active_status', 1)->whereYear('created_at', '>', date('Y', strtotime($UpYear->year)) . ' 00:00:00')->where('school_id', Auth::user()->school_id)->get();
            $sessions = SmAcademicYear::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $promot_year = SmAcademicYear::find($request->promote_session);
            // return $request;
            if ($request->promote_class == "" || $request->promote_session == "") {
                $students = SmStudent::where('class_id', '=', $request->promote_class)->where('session_id', '=', $request->promote_session)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
                //dd($students);            
                Session::flash('message-danger', 'Something went wrong, please try again');

                if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                    $data = [];
                    $data['sessions'] = $sessions->toArray();
                    $data['classes'] = $classes->toArray();
                    $data['students'] = $students->toArray();
                    $data['current_session'] = $current_session;
                    $data['current_class'] = $current_class;
                    return ApiBaseMethod::sendResponse($data, null);
                }
                return view('backEnd.studentInformation.student_promote_custom', compact('exams', 'Upsessions', 'sessions', 'classes', 'students', 'current_session', 'current_class'));
            } else {

                DB::beginTransaction();

//                try {
                    $std_info = [];
                    foreach ($request->id as $student_id) {
                        $student_details = SmStudent::findOrfail($student_id);

                        $new_academic_year = SmAcademicYear::findOrfail($request->promote_session);

                        $old_section = SmSection::findOrfail($student_details->section_id);

                        $new_section = $request->promote_section;


                        $roll = null;
                        $merit_list = null;

                        $student_promote = new SmStudentPromotion();
                        $student_promote->student_id = $student_id;
                        $student_promote->previous_class_id = $request->current_class;
                        $student_promote->current_class_id = $request->promote_class;
                        $student_promote->previous_session_id = $request->current_session;
                        $student_promote->current_session_id = $request->promote_session;

                        $student_promote->previous_section_id = $student_details->section_id;
                        $student_promote->current_section_id = $new_section;

                        $student_promote->admission_number = $student_details->admission_no;
                        $student_promote->student_info = $student_details->toJson();
                        $student_promote->merit_student_info = ($merit_list != null ? $merit_list->toJson() : $student_details->toJson());

                        $student_promote->previous_roll_number = $student_details->roll_no;
                        $student_promote->current_roll_number = $roll;

                        $student_promote->result_status = $request->result[$student_id];
                        $student_promote->save();

                        $student = SmStudent::find($student_id);
                        $student->class_id = $request->promote_class;
                        $student->session_id = $request->promote_session;
                        $student->section_id = $new_section;
//                        $student->roll_no = $roll;
                        $student->created_at = $promot_year->starting_date . ' 12:00:00';
                        if($student->save()){
                            Customer::getPromoteStudent($student);
                        }
                    }


                    DB::commit();

                    $students = SmStudent::where('class_id', '=', $request->promote_class)->where('session_id', '=', $request->promote_session)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

                    if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                        return ApiBaseMethod::sendResponse(null, 'Student has been promoted successfully');
                    }
                    Toastr::success('Operation successful', 'Success');
                    return redirect('student-promote');
//                } catch (\Exception $e) {
//                    dd($e);
                    DB::rollback();
                    $students = SmStudent::where('class_id', '=', $request->current_class)->where('session_id', '=', $request->current_session)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

                    Session::flash('message-danger-table', 'Something went wrong, please try again');

                    if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                        $data = [];
                        $data['sessions'] = $sessions->toArray();
                        $data['classes'] = $classes->toArray();
                        $data['students'] = $students->toArray();
                        $data['current_session'] = $current_session;
                        $data['current_class'] = $current_class;
                        return ApiBaseMethod::sendResponse($data, 'Something went wrong, please try again');
//                    }
                    Toastr::error('Operation Failed', 'Failed');
                    return view('backEnd.studentInformation.student_promote_custom', compact('exams', 'Upsessions', 'sessions', 'classes', 'students', 'current_session', 'current_class'));
                }
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    //studentReport modified by jmrashed
    public function studentReport(Request $request)
    {

//        try {
            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $types = SmStudentCategory::where('school_id', Auth::user()->school_id)->get();
            $genders = SmBaseSetup::where('active_status', '=', '1')->where('base_group_id', '=', '1')->get();
            $faculties = SmFaculty::where('active_status','=', '1')->selectRaw('id,faculty_name')->get();
            $academic_years = SmAcademicYear::where('school_id', Auth::user()->school_id)->get();
            $generations = DB::table('sm_generation')->where('active_status', '=', 1)->select('generation_name')->get();
            $students = SmStudent::orderBy('admission_no','asc')->where('school_id', Auth::user()->school_id)->get();
            $majors = DB::table('sm_majors')->where('active_status','=',1)->select('major_name')->get();
            $degrees = SmDegree::where('active_status',1)->get();
            $categories = SmStudentCategory::select('category_name')->get();
            $semesters = SmSemester::where('active_status',1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
//            dd($semesters);
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['classes'] = $classes->toArray();
                $data['types'] = $types->toArray();
                $data['genders'] = $genders->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.studentInformation.student_report', compact('classes', 'types', 'genders', 'faculties', 'academic_years', 'generations','students','majors','degrees','categories','semesters'));
//        } catch (\Exception $e) {
//            Toastr::error('Operation Failed', 'Failed');
//            return redirect()->back();
//        }
    }

    //student report search modified by jmrashed
    public function studentReportSearch(Request $request)
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
            $major = $request->major;
            $degree = $request->degree;
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

            $students = SmStudent::where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('active_status', 1)
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
                ->where(function ($query) use ($faculty) {
                    if ($faculty != null){
                        return $query->where('faculty_id', $faculty);
                    }
                })
                ->where(function ($query) use ($generation) {
                    if ($generation != null){
                        return $query->where('generation_id', $generation);
                    }
                })
                ->where(function ($query) use ($major) {
                    if ($major != null){
                        return $query->where('major_id', $major);
                    }
                })
                ->where(function ($query) use ($degree) {
                    if ($degree != null){
                        return $query->where('degree_id', $degree);
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
            $faculties = DB::table('sm_faculty')->where('active_status','=', '1')->select('id','faculty_name')->get();
            $academic_years = SmAcademicYear::where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            $generations = DB::table('sm_generation')->where('active_status', '=', "1")->select('generation_name')->get();
            $majors = DB::table('sm_majors')->where('active_status','=',1)->select('major_name')->get();
            $degrees = SmDegree::where('active_status',1)->get();
            $categories = SmStudentCategory::select('category_name')->get();
            $semesters = SmSemester::where('active_status',1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();


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
            return view('backEnd.studentInformation.student_report', compact('students', 'classes', 'types', 'genders', 'class_id', 'type_id', 'gender_id', 'clas','faculties','academic_years','generations','student_id','degrees','majors','categories','semesters'));
//        } catch (\Exception $e) {
//            Toastr::error('Operation Failed', 'Failed');
//            return redirect()->back();
//        }
    }

    public function studentAttendanceReport(Request $request)
    {
        try {
//            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $staff =  DB::table('sm_staffs')->where('user_id',Auth::user()->id)->first();
            if(Auth::user()->role_id == 4){
                $classes =  DB::table('sm_classes')
                    ->leftJoin('sm_assign_class_teachers','sm_assign_class_teachers.class_id','sm_classes.id')
                    ->leftJoin('sm_class_teachers','sm_assign_class_teachers.id','sm_class_teachers.assign_class_teacher_id')
                    ->where('sm_classes.active_status', 1)
                    ->where('sm_classes.created_at', 'LIKE', '%' . YearCheck::getYear() . '%')
                    ->where('sm_classes.school_id',Auth::user()->school_id)
                    ->where('sm_class_teachers.teacher_id',optional($staff)->id)
                    ->select('sm_classes.*','sm_class_teachers.teacher_id')
                    ->get();
            }else{
                $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

            }
            $types = SmStudentCategory::where('school_id', Auth::user()->school_id)->get();
            $genders = SmBaseSetup::where('active_status', '=', '1')->where('base_group_id', '=', '1')->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['classes'] = $classes->toArray();
                $data['types'] = $types->toArray();
                $data['genders'] = $genders->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.studentInformation.student_attendance_report', compact('classes', 'types', 'genders'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentAttendanceReportSearch(Request $request)
    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'class' => 'required',
            'section' => 'required',
            'month' => 'required',
            'year' => 'required'
        ]);

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $year = $request->year;
            $month = $request->month;
            $class_id = $request->class;
            $section_id = $request->section;
            $current_day = date('d');
            $clas = SmClass::findOrFail($request->class);
            $sec = SmSection::findOrFail($request->section);
            $days = cal_days_in_month(CAL_GREGORIAN, $request->month, $request->year);
//            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $staff =  DB::table('sm_staffs')->where('user_id',Auth::user()->id)->first();
            if(Auth::user()->role_id == 4){
                $classes =  DB::table('sm_classes')
                    ->leftJoin('sm_assign_class_teachers','sm_assign_class_teachers.class_id','sm_classes.id')
                    ->leftJoin('sm_class_teachers','sm_assign_class_teachers.id','sm_class_teachers.assign_class_teacher_id')
                    ->where('sm_classes.active_status', 1)
                    ->where('sm_classes.created_at', 'LIKE', '%' . YearCheck::getYear() . '%')
                    ->where('sm_classes.school_id',Auth::user()->school_id)
                    ->where('sm_class_teachers.teacher_id',optional($staff)->id)
                    ->select('sm_classes.*','sm_class_teachers.teacher_id')
                    ->get();
            }else{
                $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

            }
            $students = SmStudent::where('class_id', $request->class)->where('section_id', $request->section)->where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

            $attendances = [];
            foreach ($students as $student) {
                $attendance = SmStudentAttendance::where('student_id', $student->id)->where('attendance_date', 'like', $request->year . '-' . $request->month . '%')->where('school_id', Auth::user()->school_id)->get();
                if (count($attendance) != 0) {
                    $attendances[] = $attendance;
                }
            }

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['classes'] = $classes->toArray();
                $data['attendances'] = $attendances;
                $data['days'] = $days;
                $data['year'] = $year;
                $data['month'] = $month;
                $data['current_day'] = $current_day;
                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;
                return ApiBaseMethod::sendResponse($data, null);
            }

            return view('backEnd.studentInformation.student_attendance_report', compact('classes', 'attendances', 'days', 'year', 'month', 'current_day', 'class_id', 'section_id', 'clas', 'sec'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function studentAttendanceReportPrint($class_id, $section_id, $month, $year)
    {
        set_time_limit(2700);
        try {
            $current_day = date('d');

            $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $students = DB::table('sm_students')->where('class_id', $class_id)->where('section_id', $section_id)->where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            $attendances = [];
            foreach ($students as $student) {
                $attendance = SmStudentAttendance::where('student_id', $student->id)->where('attendance_date', 'like', $year . '-' . $month . '%')->where('school_id', Auth::user()->school_id)->get();
                if ($attendance) {
                    $attendances[] = $attendance;
                }
            }
            $pdf = PDF::loadView(
                'backEnd.studentInformation.student_attendance_print',
                [
                    'attendances' => $attendances,
                    'days' => $days,
                    'year' => $year,
                    'month' => $month,
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                ]
            )->setPaper('A4', 'landscape');
            return $pdf->stream('student_attendance.pdf');
            //return view('backEnd.studentInformation.student_attendance_print', compact('classes', 'attendances', 'days', 'year', 'month', 'current_day', 'class_id', 'section_id'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function importStudent()
    {
        try {
            $generations = SmGeneration::where('active_status', 1)->get();
            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $genders = SmBaseSetup::where('base_group_id', 1)->get();
            $blood_groups = SmBaseSetup::where('base_group_id', 3)->get();
            $religions = SmBaseSetup::where('base_group_id', 2)->get();
            $sessions = SmAcademicYear::where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $semesters = SmSemester::where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            return view('backEnd.studentInformation.import_student', compact('classes', 'genders', 'blood_groups', 'religions', 'sessions', 'provinces', 'generations','semesters'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function downloadStudentFile()
    {
        try {
            $studentsArray = ['session','semester', 'admission_number', 'roll_no', 'first_name', 'last_name', 'khmer_name', 'date_of_birth', 'religion', 'gender', 'caste', 'mobile', 'email', 'admission_date',
                'blood_group', 'height', 'weight', 'father_name', 'father_phone', 'father_occupation', 'mother_name', 'mother_phone', 'mother_occupation', 'guardian_name', 'guardian_relation',
                'guardian_email', 'guardian_phone', 'guardian_occupation', 'guardian_address', 'current_address', 'permanent_address', 'bank_account_no', 'national_identification_no', 'local_identification_no',
                'previous_school_details', 'note', 'house_student', 'street_student', 'group_student', 'village_student', 'commune_student', 'district_student', 'province_student', 'village_school', 'commune_school', 'district_school',
                'from_school', 'province_school', 'degree_year', 'degree_no', 'subject1', 'subject2', 'subject3', 'subject4', 'subject5', 'subject6',
                'grade1', 'grade2', 'grade3', 'grade4', 'grade5', 'grade6', 'total_grade', 'total_score', 'degree_level', 'house_birth', 'group_birth', 'village_birth', 'commune_birth', 'district_birth', 'city', 'external',
                'current_occupation_student', 'facebook_student', 'family_member', 'family1', 'major1', 'academic1', 'as1', 'family2', 'major2', 'academic2', 'as2',
                'family3', 'major3', 'academic3', 'as3', 'house_permanent', 'street_permanent', 'group_permanent', 'village_permanent', 'commune_permanent', 'district_permanent',
                'province_permanent', 'company', 'emergency_name', 'emergency_name_kh', 'emergency_occupation', 'emergency_mobile','description'];

            return Excel::create('students', function ($excel) use ($studentsArray) {
                $excel->sheet('students', function ($sheet) use ($studentsArray) {
                    $sheet->fromArray($studentsArray);
                });
            })->download('xlsx');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function studentBulkStore(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'class' => 'required',
            'section' => 'required',
            'file' => 'required'
        ]);


        $file_type = strtolower($request->file->getClientOriginalExtension());
        if ($file_type <> 'csv' && $file_type <> 'xlsx' && $file_type <> 'xls') {
            Toastr::warning('The file must be a file of type: xlsx, csv or xls', 'Warning');
            return redirect()->back();
        } else {
            try {

                $path = $request->file('file')->getRealPath();
                $data = Excel::load($path, function ($reader) {
                })->get();
                $usersUnique = $data->unique('admission_number');
                $usersDupes = $data->diff($usersUnique);
//                dd(sizeof($usersDupes));
                if (sizeof($usersDupes) > sizeof($data)) {
                    return redirect()->back()->with("message-danger", "Admission number required");
                }
                if (sizeof($usersDupes) >= 1) {
                    return redirect()->back()->with("message-danger", "Admission number should be unique");
                }


                $shcool_details = SmGeneralSettings::find(1);
                $school_name = explode(' ', $shcool_details->school_name);
                $short_form = '';
                foreach ($school_name as $value) {
                    $ch = str_split($value);
                    $short_form = $short_form . '' . $ch[0];
                }

                if (!empty($data)) {
                    DB::beginTransaction();
                    foreach ($data as $key => $value) {
                        if ($value->filter()->isNotEmpty()) {
                            $chk = DB::table('sm_students')->where('admission_no', $value->admission_number)->count();
                            if ($chk >= 1) {
                                return redirect()->back()->with("message-danger", "Admission number should be unique");
                            }
                            try {
                                $user_stu = new User();
                                $user_stu->role_id = 2;
                                $user_stu->full_name = $value->first_name . ' ' . $value->last_name;

                                $user_stu->username = $value->admission_number;

                                $user_stu->email = $value->email;
                                $user_stu->school_id = Auth::user()->school_id;

                                $user_stu->password = Hash::make(123456);
                                $user_stu->save();
                                $user_stu->toArray();

                                try {

                                    $user_parent = new User();
                                    $user_parent->role_id = 3;
                                    $user_parent->full_name = $value->father_name;

                                    if (empty($value->guardian_email)) {
                                        $data_parent['email'] = 'par_' . $value->admission_number;

                                        $user_parent->username = 'par_' . $value->admission_number;
                                    } else {

                                        $data_parent['email'] = $value->guardian_email;

                                        $user_parent->username = $value->guardian_email;
                                    }

                                    $user_parent->email = $value->guardian_email;

                                    $user_parent->password = Hash::make(123456);
                                    $user_parent->school_id = Auth::user()->school_id;
                                    $user_parent->save();
                                    $user_parent->toArray();

                                    try {

                                        $parent = new SmParent();
                                        $parent->user_id = $user_parent->id;
                                        $parent->fathers_name = $value->father_name;
                                        $parent->fathers_mobile = $value->father_phone;
                                        $parent->fathers_occupation = $value->fathe_occupation;
                                        $parent->mothers_name = $value->mother_name;
                                        $parent->mothers_mobile = $value->mother_phone;
                                        $parent->mothers_occupation = $value->mother_occupation;
                                        $parent->guardians_name = $value->guardian_name;
                                        $parent->guardians_mobile = $value->guardian_phone;
                                        $parent->guardians_occupation = $value->guardian_occupation;
                                        $parent->guardians_relation = $value->relation;
                                        $parent->relation = $value->relationButton;
                                        $parent->guardians_address = $value->guardian_address;
                                        $parent->school_id = Auth::user()->school_id;
                                        $parent->save();
                                        $parent->toArray();

                                        try {
                                            $emergency_contact = new SmEmergency();
                                            $emergency_contact->emergency_name = $value->emergency_name;
                                            $emergency_contact->emergency_name_kh = $value->emergency_name_kh;
                                            $emergency_contact->emergency_occupation = $value->emergency_occupation;
                                            $emergency_contact->emergency_mobile = $value->emergency_mobile;
                                            $emergency_contact->save();
                                            $emergency_contact->toArray();
                                        } catch (\Exception $e) {
                                            DB::rollback();
                                            Toastr::error('Operation Failed', 'Failed');
                                            return redirect()->back();
                                        }

                                        try {
                                            $student_family = new SmStudentsFamily();
                                            $student_family->family_member = $value->family_member;
                                            $student_family->family1 = $value->family1;
                                            $student_family->major1 = $value->major1;
                                            $student_family->academic1 = $value->academic1;
                                            $student_family->as1 = $value->as1;
                                            $student_family->family2 = $value->family2;
                                            $student_family->major2 = $value->major2;
                                            $student_family->academic2 = $value->academic2;
                                            $student_family->as2 = $value->as2;
                                            $student_family->family3 = $value->family3;
                                            $student_family->major3 = $value->major3;
                                            $student_family->academic3 = $value->academic3;
                                            $student_family->as3 = $value->as3;

                                            $student_family->save();
                                            $student_family->toArray();
                                        } catch (\Exception $e) {
                                            DB::rollback();
                                            Toastr::error('Operation Failed', 'Failed');
                                            return redirect()->back();
                                        }

                                        try{
                                            $student_permanent = new SmStudentsPermanent();
                                            $student_permanent->house_permanent = $value->house_permanent;
                                            $student_permanent->street_permanent = $value->street_permanent;
                                            $student_permanent->group_permanent = $value->group_permanent;
                                            $student_permanent->village_permanent = $value->village_permanent;
                                            $student_permanent->commune_permanent = $value->commune_permanent;
                                            $student_permanent->district_permanent = $value->district_permanent;
                                            $student_permanent->province_permanent = $value->province_permanent;

                                            $student_permanent->save();
                                            $student_permanent->toArray();

                                        } catch (\Exception $e) {
                                            DB::rollback();
                                            Toastr::error('Operation Failed', 'Failed');
                                            return redirect()->back();
                                        }

                                        try {
                                            $student = new SmStudent();

                                            // $student->siblings_id = $value->sibling_id;
                                            $student->class_id = $request->class;
                                            $student->degree_id = $request->class;
                                            $student->major_id = $request->class;
                                            $student->faculty_id = $request->class;
                                            $student->generation_id = $request->generation_id;
                                            $student->semester_id = $value->semester;

                                            $student->section_id = $request->section;
                                            $student->session_id = $value->session;
                                            $student->user_id = $user_stu->id;

                                            $student->parent_id = $parent->id;
                                            $student->role_id = 2;
                                            $student->current_occupation_student = $value->current_occupation_student;
                                            $student->facebook_student = $value->facebook_student;
                                            $student->roll_no = $value->roll_no;
                                            $student->admission_no = $value->admission_number;
                                            $student->first_name = $value->first_name;
                                            $student->last_name = $value->last_name;
                                            $student->full_name = $value->first_name . ' ' . $value->last_name;
                                            $student->bank_name = $value->khmer_name;
                                            $student->gender_id = $value->gender;
                                            $student->date_of_birth = date('Y-m-d', strtotime($value->date_of_birth));
                                            $student->caste = $value->caste;
                                            $student->email = $value->email;
                                            $student->mobile = $value->mobile;
                                            $student->admission_date = date('Y-m-d', strtotime($value->admission_date));
                                            $student->bloodgroup_id = $value->blood_group;
                                            $student->religion_id = $value->religion;
                                            $student->height = $value->height;
                                            $student->weight = $value->weight;
                                            $student->current_address = $value->current_address;
                                            $student->permanent_address = $value->permanent_address;
                                            $student->national_id_no = $value->national_identification_no;
                                            $student->local_id_no = $value->local_identification_no;
                                            $student->bank_account_no = $value->bank_account_no;
                                            $student->previous_school_details = $value->previous_school_details;
                                            $student->aditional_notes = $value->note;
                                            $student->house_student = $value->house_student;
                                            $student->street_student = $value->street_student;
                                            $student->group_student = $value->group_student;
                                            $student->village_student = $value->village_student;
                                            $student->commune_student = $value->commune_student;
                                            $student->district_student = $value->district_student;
                                            $student->province_student = $value->province_student;
                                            $student->village_school = $value->village_school;
                                            $student->commune_school = $value->commune_school;
                                            $student->district_school = $value->district_school;
                                            $student->from_school = $value->from_school;
                                            $student->province_school = $value->province_school;
                                            $student->degree_year = $value->degree_year;
                                            $student->degree_no = $value->degree_no;
                                            $student->subject1 = $value->subject1;
                                            $student->subject2 = $value->subject2;
                                            $student->subject3 = $value->subject3;
                                            $student->subject4 = $value->subject4;
                                            $student->subject5 = $value->subject5;
                                            $student->subject6 = $value->subject6;
                                            $student->total_grade = $value->total_grade;
                                            $student->total_score = $value->total_score;
                                            $student->degree_level = $value->degree_level;
                                            $student->grade1 = $value->grade1;
                                            $student->grade2 = $value->grade2;
                                            $student->grade3 = $value->grade3;
                                            $student->grade4 = $value->grade4;
                                            $student->grade5 = $value->grade5;
                                            $student->grade6 = $value->grade6;
                                            $student->house_birth = $value->house_birth;
                                            $student->group_birth = $value->group_birth;
                                            $student->village_birth = $value->village_birth;
                                            $student->commune_birth = $value->commune_birth;
                                            $student->district_birth = $value->district_birth;
                                            $student->city = $value->city;
                                            $student->company = $value->company;
                                            $student->description = $value->description;
                                            $student->external = $value->external;
                                            $student->emergency_contact_id = $emergency_contact->id;
                                            $student->student_family_id = $student_family->id;
                                            $student->student_permanent_id = $student_permanent->id;

                                            $student->school_id = Auth::user()->school_id;

                                            if ($student->save()) {
                                                Customer::getCustomer($student);
                                            }

                                            $user_info = [];

                                            if ($value->email != "") {
                                                $user_info[] = array('email' => $value->email, 'username' => $value->email);
                                            }


                                            if ($value->guardian_email != "") {
                                                $user_info[] = array('email' => $value->guardian_email, 'username' => $data_parent['email']);
                                            }

                                        } catch (\Illuminate\Database\QueryException $e) {
                                            return redirect()->back()->with("message-danger", "Admission number should be unique");
                                        } catch (\Exception $e) {

                                            DB::rollback();
                                            Toastr::error('Operation Failed', 'Failed');
                                            return redirect()->back();
                                        }
                                    } catch (\Exception $e) {

                                        DB::rollback();
                                        Toastr::error('Operation Failed', 'Failed');
                                        return redirect()->back();
                                    }
                                } catch (\Exception $e) {

                                    DB::rollback();
                                    Toastr::error('Operation Failed', 'Failed');
                                    return redirect()->back();
                                }
                            } catch (\Exception $e) {
                                DB::rollback();
                                Toastr::error('Operation Failed', 'Failed');
                                return redirect()->back();
                            }
                        }
                    }


                    // if(count($user_info) != 0){

                    //     $systemSetting = SmGeneralSettings::select('school_name', 'email')->find(1);


                    //     $systemEmail = SmEmailSetting::find(1);

                    //     $system_email = $systemEmail->from_email;
                    //     $school_name = $systemSetting->school_name;


                    //     $sender['system_email'] = $system_email;
                    //     $sender['school_name'] = $school_name;

                    //     dispatch(new \App\Jobs\SendUserMailJob($user_info, $sender));

                    // }


                    DB::commit();
                    Toastr::success('Operation successful', 'Success');
                    return redirect()->back();
                }
            } catch (\Exception $e) {

                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        }
    }



    public function guardianReport(Request $request)
    {
        try {
            $students = SmStudent::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['students'] = $students->toArray();
                $data['classes'] = $classes->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.studentInformation.guardian_report', compact('classes'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function guardianReportSearch(Request $request)
    {
//        $input = $request->all();
//        $validator = Validator::make($input, [
//            'class' => 'required'
//        ]);

//        if ($validator->fails()) {
//            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
//                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
//            }
//            return redirect()->back()
//                ->withErrors($validator)
//                ->withInput();
//        }
        try {
            $students = SmStudent::query();
            $students->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('active_status', 1);
            $students->where('class_id', $request->class);
            if ($request->section != "") {
                $students->where('section_id', $request->section);
            }
            $students = $students->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();


            $class_id = $request->class;

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['students'] = $students->toArray();
                $data['classes'] = $classes->toArray();
                $data['class_id'] = $class_id;
                return ApiBaseMethod::sendResponse($data, null);
            }
            $clas = SmClass::find($request->class);
            return view('backEnd.studentInformation.guardian_report', compact('students', 'classes', 'class_id', 'clas'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentLoginReport(Request $request)
    {
        try {
            $students = SmStudent::where('school_id', Auth::user()->school_id)->get();
            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['students'] = $students->toArray();
                $data['classes'] = $classes->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.studentInformation.login_info', compact('classes'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function studentLoginSearch(Request $request)
    {
//        $input = $request->all();
//        $validator = Validator::make($input, [
//            'class' => 'required'
//        ]);

//        if ($validator->fails()) {
//            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
//                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
//            }
//            return redirect()->back()
//                ->withErrors($validator)
//                ->withInput();
//        }
        try {
            $students = SmStudent::query();
            $students->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('active_status', 1);
            $students->where('class_id', $request->class);
            if ($request->section != "") {
                $students->where('section_id', $request->section);
            }
            $students = $students->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $class_id = $request->class;

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['students'] = $students->toArray();
                $data['classes'] = $classes->toArray();
                $data['class_id'] = $class_id;
                return ApiBaseMethod::sendResponse($data, null);
            }
            $clas = SmClass::find($request->class);
            return view('backEnd.studentInformation.login_info', compact('students', 'classes', 'class_id', 'clas'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function disabledStudent(Request $request)
    {
        try {
            $students = SmStudent::where('active_status', 0)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['students'] = $students->toArray();
                $data['classes'] = $classes->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.studentInformation.disabled_student', compact('students', 'classes'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function disabledStudentSearch(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'class' => 'required'
        ]);

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $students = SmStudent::query();
            $students->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('active_status', 0);
            if ($request->class != "") {
                $students->where('class_id', $request->class);
            }
            if ($request->section != "") {
                $students->where('section_id', $request->section);
            }
            if ($request->name != "") {
                $students->where('full_name', 'like', '%' . $request->name . '%');
            }
            if ($request->roll_no != "") {
                $students->where('roll_no', 'like', '%' . $request->roll_no . '%');
            }
            $students = $students->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

            $class_id = $request->class;
            $section_id = $request->section;
            $name = $request->name;
            $roll_no = $request->roll_no;


            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['students'] = $students->toArray();
                $data['classes'] = $classes->toArray();
                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;
                $data['name'] = $name;
                $data['roll_no'] = $roll_no;
                return ApiBaseMethod::sendResponse($data, null);
            }

            return view('backEnd.studentInformation.disabled_student', compact('students', 'classes', 'class_id', 'section_id', 'name', 'roll_no'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }



    public function disabledStudentDelete1(Request $request)
    {
        try {

            $student_detail = SmStudent::find($request->id);
            $parent_user = @$student_detail->parents->user_id;


            $siblings = SmStudent::where('parent_id', $student_detail->parent_id)->where('school_id', Auth::user()->school_id)->get();


            DB::beginTransaction();


            if ($student_detail->student_photo != "") {
                if (file_exists($student_detail->student_photo)) {
                    unlink($student_detail->student_photo);
                }
            }

            SmStudent::destroy($request->id);


            if (count($siblings) == 1) {
                $parent = SmParent::find($student_detail->parent_id);

                if ($parent->fathers_photo != "") {
                    if (file_exists($parent->fathers_photo)) {
                        unlink($parent->fathers_photo);
                    }
                }
                if ($parent->mothers_photo != "") {
                    if (file_exists($parent->mothers_photo)) {
                        unlink($parent->mothers_photo);
                    }
                }
                if ($parent->guardians_photo != "") {
                    if (file_exists($parent->guardians_photo)) {
                        unlink($parent->guardians_photo);
                    }
                }

                $parent->delete();
            }



            $student_user = User::find($student_detail->user_id);
            $student_user->delete();

            if (count($siblings) == 1) {

                $parent_user = User::find($parent_user);
                $parent_user->delete();
            }

            DB::commit();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse(null, 'Student has been disabled successfully');
            }

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Something went wrong, please try again');
            }
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function disabledStudentDelete(Request $request)
    {
        // return $request;
        try {
            $tables = \App\tableList::getTableList('student_id', $request->id);
            try {
                $student_detail = SmStudent::find($request->id);
                $parent_user = @$student_detail->parents->user_id;
                $siblings = SmStudent::where('parent_id', $student_detail->parent_id)->where('school_id', Auth::user()->school_id)->get();
                DB::beginTransaction();
                if ($student_detail->student_photo != "") {
                    if (file_exists($student_detail->student_photo)) {
                        unlink($student_detail->student_photo);
                    }
                }

                SmStudent::destroy($request->id);
                Customer::deleteCustomer($request->id);

                if (count($siblings) == 1) {
                    $parent = SmParent::find($student_detail->parent_id);

                    if ($parent->fathers_photo != "") {
                        if (file_exists($parent->fathers_photo)) {
                            unlink($parent->fathers_photo);
                        }
                    }
                    if ($parent->mothers_photo != "") {
                        if (file_exists($parent->mothers_photo)) {
                            unlink($parent->mothers_photo);
                        }
                    }
                    if ($parent->guardians_photo != "") {
                        if (file_exists($parent->guardians_photo)) {
                            unlink($parent->guardians_photo);
                        }
                    }

                    $parent->delete();
                }
                $student_user = User::find($student_detail->user_id);
                $student_user->delete();

                if (count($siblings) == 1) {

                    $parent_user = User::find($parent_user);
                    $parent_user->delete();
                }

                DB::commit();

                if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                    return ApiBaseMethod::sendResponse(null, 'Student has been disabled successfully');
                }

                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } catch (\Illuminate\Database\QueryException $e) {
                DB::rollback();
                $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
                Toastr::error($msg, 'Failed');
                return redirect()->back();
            } catch (\Exception $e) {
                DB::rollback();
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function enableStudent(Request $request)
    {
        try {



            DB::beginTransaction();



            $student_detail = SmStudent::find($request->id);

            $student_detail->active_status = 1;
            // $student_detail->save();


            $parent = SmParent::find($student_detail->parent_id);
            $parent->active_status = 1;
            $parent->save();

            $student_user = User::find($student_detail->user_id);
            $student_user->active_status = 1;
            $student_user->save();


            $parent_user = User::find(@$student_detail->parents->user_id);
            $parent_user->active_status = 1;
            $parent_user->save();

            $student_detail->save();

            DB::commit();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse(null, 'Student has been enabled successfully');
            }

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Something went wrong, please try again');
            }
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function studentHistory(Request $request)
    {
        try {
            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $students = SmStudent::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $admission_years = SmStudent::groupBy('admission_date')->select('admission_date')->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();

            $years = SmStudent::select('admission_date')->where('active_status', 1)
                ->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->get()
                ->groupBy(function ($val) {
                    return Carbon::parse($val->admission_date)->format('Y');
                });

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['classes'] = $classes->toArray();
                $data['students'] = $students->toArray();
                $data['years'] = $years->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }

            return view('backEnd.studentInformation.student_history', compact('classes', 'years'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentHistorySearch(Request $request)
    {
//        $input = $request->all();
////        dd($input);
//        $validator = Validator::make($input, [
////            'class' => 'required'
//        ]);
//
//        if ($validator->fails()) {
//            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
//                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
//            }
//            return redirect()->back()
//                ->withErrors($validator)
//                ->withInput();
//        }
        try {
            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $students = SmStudent::query();
            $students->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('active_status', 1);
            if ( $request->class != null){
                $students->where('class_id', $request->class);
            }
            $students->where('active_status', 1);
            if ($request->admission_year != "") {
                $students->where('admission_date', 'like',  $request->admission_year . '%');
            }

            $students = $students->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();


            $years = SmStudent::select('admission_date')->where('active_status', 1)
                ->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->get()
                ->groupBy(function ($val) {
                    return Carbon::parse($val->admission_date)->format('Y');
                });


            $class_id = $request->class;
            $year = $request->admission_year;

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['students'] = $students->toArray();
                $data['classes'] = $classes->toArray();
                $data['years'] = $years->toArray();
                $data['class_id'] = $class_id;
                $data['year'] = $year;
                return ApiBaseMethod::sendResponse($data, null);
            }
            $clas = SmClass::find($request->class);
            return view('backEnd.studentInformation.student_history', compact('students', 'classes', 'years', 'class_id', 'year', 'clas'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }



    public function view_academic_performance(Request $request, $id)
    {

        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
            return ApiBaseMethod::sendResponse($id, null);
        }
        return $id;
    }

    function previousRecord()
    {
        try {
            $academic_years = SmAcademicYear::where('school_id', Auth::user()->school_id)->get();
            $exam_types = SmExamType::where('school_id', Auth::user()->school_id)->get();

            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            return view('backEnd.examination.previous_record', compact('classes', 'exam_types', 'academic_years'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    function previousRecordSearch(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'promote_session' => 'required',
            'promote_class' => 'required',
            'promote_section' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $yearCh = SmAcademicYear::find($request->promote_session);
            $students = SmStudentPromotion::where('created_at', 'LIKE', '%' . $yearCh->year . '%');
            if ($request->promote_class != "") {
                $students->where('previous_class_id', $request->promote_class);
            }
            if ($request->promote_section != "") {
                $students->where('previous_section_id', $request->promote_section);
            }
            $year = $request->promote_session;
            $students = $students->where('school_id', Auth::user()->school_id)->get();

            $academic_years = SmAcademicYear::where('school_id', Auth::user()->school_id)->get();
            $exam_types = SmExamType::where('school_id', Auth::user()->school_id)->get();
            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $clas = SmClass::find($request->promote_class);
            $sec = SmSection::find($request->promote_section);
            return view('backEnd.examination.previous_record', compact('classes', 'exam_types', 'academic_years', 'students', 'year', 'clas', 'sec'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function History($id){
//            $students = SmStudent::select('id','full_name')->where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();

        $row =   $students = SmStudent::find($id);
//        dd($students);
        return view('backEnd.studentInformation.history',compact('row'));
    }
}