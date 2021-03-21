<?php

namespace App\Http\Controllers;

use App\SmAcademicYear;
use App\SmBuilding;
use App\SmClass;
use App\SmClassRoom;
use App\SmExam;
use App\SmExamDate;
use App\SmFaculty;
use App\SmMajor;
use App\SmStaff;
use App\SmSection;
use App\SmStudent;
use App\SmSubject;
use App\YearCheck;
use App\SmFeesAssign;
use App\SmFeesMaster;
use App\ApiBaseMethod;
use App\SmFeesPayment;
use App\SmClassRoutine;
use App\SmAssignSubject;
use Illuminate\Http\Request;
use App\SmAssignClassTeacher;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Modules\RolePermission\Entities\InfixRole;

class FoundationController extends Controller
{
    public function Foundation(Request $request)
    {

//        try{
            $majors = DB::table('sm_majors')->where('active_status','=',1)->select('major_name')->get();
            $exam_dates = SmExamDate::where('active_status',1)->get();
            $students = SmStudent::where('active_status', 1)
            ->where('school_id',Auth::user()->school_id)
            ->get();
            $staffs = SmStaff::where('school_id',Auth::user()->school_id)->get();
            $faculties = SmFaculty::where('active_status','=',1)->get();
            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $academic_years = SmAcademicYear::where('active_status','=',1)
                ->where('school_id',Auth::user()->school_id)
                ->get();
            $staffs_api = DB::table('sm_staffs')

                ->where('sm_staffs.active_status', 1)
                ->join('roles', 'sm_staffs.role_id', '=', 'roles.id')
                ->join('sm_human_departments', 'sm_staffs.department_id', '=', 'sm_human_departments.id')
                ->join('sm_designations', 'sm_staffs.designation_id', '=', 'sm_designations.id')
                ->join('sm_base_setups', 'sm_staffs.gender_id', '=', 'sm_base_setups.id')
                ->where('sm_staffs.school_id',Auth::user()->school_id)
                ->get();


            if (ApiBaseMethod::checkUrl($request->fullUrl())) {

                return ApiBaseMethod::sendResponse($staffs_api, null);
            }
            return view('backEnd.studentInformation.student_foundation', compact('staffs', 'classes','majors','academic_years','faculties','students','exam_dates'));
//        }catch (\Exception $e) {
//            Toastr::error('Operation Failed', 'Failed');
//            return redirect()->back();
//        }
    }
    public function searchFoundation(Request $request)
    {
//dd($request->all());
//        try{
//            session(['exam_date'=>'1']);
            $majors = DB::table('sm_majors')->where('active_status','=',1)->select('major_name')->get();
            $exam_dates = SmExamDate::where('active_status',1)->where('created_at','Like','%'.YearCheck::getYear().'%')->get();
            $faculties = SmFaculty::where('active_status','=',1)->get();
            $students = SmStudent::where('active_status', 1)
            ->where('school_id',Auth::user()->school_id)
            ->get();
            $academic_years = SmAcademicYear::where('active_status','=',1)
                ->where('school_id',Auth::user()->school_id)
                ->get();
            $staff = SmStaff::query();
            $staff->where('active_status', 1);
            if ($request->role_id != "") {
                $staff->where('role_id', $request->role_id);
            }
            if ($request->staff_no != "") {
                $staff->where('staff_no', $request->staff_no);
            }

            if ($request->staff_name != "") {
                $staff->where('full_name', 'like', '%' . $request->staff_name . '%');
            }
            $staffs = $staff->where('school_id',Auth::user()->school_id)->get();
            $roles = InfixRole::where('active_status', '=', '1')->where('id', '!=', 2)->where('id', '!=', 3)->where(function ($q) {
                $q->where('school_id', Auth::user()->school_id)->orWhere('type', 'System');
            })->get();
            $classes = SmClass::where('active_status','=',1)
                ->where('created_at','Like','%'.YearCheck::getYear().'%')
                ->where('school_id',Auth::user()->school_id)
                ->get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['staffs'] = $staffs->toArray();
                $data['roles'] = $roles->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.studentInformation.student_foundation', compact('staffs', 'roles','students','majors','classes','academic_years','faculties','exam_dates'));
//        }catch (\Exception $e) {
//            Toastr::error('Operation Failed', 'Failed');
//            return redirect()->back();
//        }
    }
    public function ViewFoundation($id){

        $students = SmStudent::find($id);
//       $classes = SmClass::find($id);

        $faculties = SmFaculty::all();
//dd($classes);
        return view('backEnd.admin.certificate_student',compact('students','faculties','classes'));
    }
    public function Major(Request $request) {
//            dd($request->all());

            try {
                $majors = SmMajor::where('active_status', '=', 1)->where('school_id', Auth::user()->school_id)->get();
                $faculties = SmFaculty::where('active_status','=',1)->get();
                if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                    return ApiBaseMethod::sendResponse($majors, null);
                }
                return view('backEnd.studentInformation.major', compact('majors','faculties'));
            } catch (\Exception $e) {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }


    }
    public function MajorStore(Request $request){
        $academic_year=SmAcademicYear::where('school_id',Auth::user()->school_id)->first();
        if ($academic_year==null) {
            Toastr::warning('Create academic year first', 'Warning');
            return redirect()->back();
        }

        $input = $request->all();
        $validator = Validator::make($input, [
            'major_name' => "required|max:200"
        ]);
        if ($validator == null){
            Toastr::error('Operation Failed!','Failed');
        }
        $is_duplicate = SmMajor::where('school_id', Auth::user()->school_id)->where('major_name', $request->major_name)->first();
        if ($is_duplicate) {
            Toastr::error('Duplicate major name found!', 'Failed');
            return redirect()->back()->withErrors($validator)->withInput();
        }



        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $major = new SmMajor();
            $major->major_name = $request->major_name;
            $major->major_code = $request->major_code;
            $major->major_name_kh = $request->major_name_kh;
            $major->faculty_id = $request->faculty_id;
//            $major->created_at = YearCheck::getYear() . '-' . date('m-d h:i:s');
            $major->description = $request->description;
            $major->created_by = Auth::user()->id;
            $major->school_id = Auth::user()->school_id;
            $result = $major->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'Major has been created successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            } else {
                if ($result) {
                    Toastr::success('Operation successful', 'Success');
                    return redirect()->back();
                }
            }
        } catch (\Exception $e) {
            //dd($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function edit(Request $request, $id)
    {


        try {
            $majors = SmMajor::where('active_status', '=', 1)->where('school_id', Auth::user()->school_id)->get();
            $major = SmMajor::find($id);
            $faculties = SmFaculty::where('active_status','=',1)->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['class_room'] = $major->toArray();
                $data['class_rooms'] = $majors->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }

            return view('backEnd.studentInformation.major', compact('major', 'majors','faculties'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function update(Request $request, $id = null)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'faculty_id' => 'required',
            'major_name' => 'required'
        ]);
        $is_duplicate = SmMajor::where('school_id', Auth::user()->school_id)->where('id','!=', $request->id)->where('major_name', $request->major_name)->first();
        if ($is_duplicate) {
            Toastr::error('Duplicate name found!', 'Failed');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $major = SmMajor::find($request->id);
            $major->major_name = $request->major_name;
            $major->major_code = $request->major_code;
            $major->major_name_kh = $request->major_name_kh;
            $major->faculty_id = $request->faculty_id;
//            $major->created_at = YearCheck::getYear() . '-' . date('m-d h:i:s');
            $major->description = $request->description;
            $major->updated_by = Auth::user()->id;
            $major->school_id = Auth::user()->school_id;
            $result = $major->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'Major Room has been updated successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            } else {
                if ($result) {
                    Toastr::success('Operation successful', 'Success');
                    return redirect('majors');
                } else {
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function delete(Request $request, $id)
    {

//        try {
//            $id_key = 'faculty_id';
//            $tables = \App\tableList::getTableList('faculty_id', $id);
////            dd($tables);

            try {
//                if ($tables==null) {
                    $delete_query = SmMajor::find($id);
                    $delete_query->active_status = '0';
                    $delete_query->save();
                    if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                        if ($delete_query) {
                            return ApiBaseMethod::sendResponse(null, 'Class Room has been deleted successfully');
                        } else {
                            return ApiBaseMethod::sendError('Something went wrong, please try again.');
                        }
                    } else {
                        if ($delete_query) {
                            Toastr::success('Operation successful', 'Success');
                            return redirect()->back();
                        } else {
                            Toastr::error('Operation Failed', 'Failed');
                            return redirect()->back();
                        }
                    }
//                } else {
//                    $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
//                    Toastr::error($msg, 'Failed');
//                    return redirect()->back();
//                }


//            } catch (\Illuminate\Database\QueryException $e) {
//                $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
//                Toastr::error($msg, 'Failed');
//                return redirect()->back();
//            }
        } catch (\Exception $e) {
            //dd($e->getMessage(), $e->errorInfo);
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}