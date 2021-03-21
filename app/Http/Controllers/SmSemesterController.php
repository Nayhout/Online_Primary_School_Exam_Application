<?php

namespace App\Http\Controllers;

use App\ApiBaseMethod;
use App\SmAcademicYear;
use App\SmFaculty;
use App\SmSemester;
use App\YearCheck;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SmSemesterController extends Controller
{
    //
    public function index(Request $request){
        try {
            $semesters = SmSemester::where('active_status', '=', 1)->get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse($semesters, null);
            }
//            $academic_years = SmAcademicYear::where('active_status',1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
           $academic_years = SmAcademicYear::all();
//            dd($academic_years);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
        return view('backEnd.systemSettings.semester',compact('semesters','academic_years'));
    }
    public function store(Request $request) {
//        dd($request->all());
        $input = $request->all();
//        $validator = Validator::make($input, [
//            'semester_name' => "required|max:200|unique:sm_semester,semester_name," . $request->id,
//            'semester_name_kh' => "required|max:200|unique:sm_semester,semester_name_kh," . $request->id
//        ]);
        $request->validate([
            'semester_name' => 'required',
            'semester_name_kh' => 'required',
        ]);

//        $is_duplicate = SmSemester::where('semester_name', $request->semester_name)->where('semester_name_kh', $request->semester_name_kh)->where('id','!=', $request->id)->first();
//        if ($is_duplicate) {
//            Toastr::error('Duplicate faculty name found!', 'Failed');
//            return redirect()->back()->withErrors($validator)->withInput();
//        }
//
//        if ($validator->fails()) {
//            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
//                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
//            }
//            return redirect()->back()
//                ->withErrors($validator)
//                ->withInput();
//        }

        $academic_year=SmAcademicYear::where('school_id',Auth::user()->school_id)->first();
        if ($academic_year==null) {
            Toastr::warning('Create academic year first', 'Warning');
            return redirect()->back();
        }

//        try {
            $semester = new SmSemester();
            $semester->semester_code = $request->semester_code;
            $semester->semester_name = $request->semester_name;
            $semester->semester_name_kh = $request->semester_name_kh;
            $semester->academic_year_id = $request->academic_year_id;
            $semester->start_date = date('Y-m-d', strtotime($request->start_date));
            $semester->end_date = date('Y-m-d', strtotime($request->end_date));
            $semester->created_by = Auth::user()->id;
            $result = $semester->save();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'Semester has been created successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            } else {
                if ($result) {
                    Toastr::success('Operation successful', 'Success');
                    return redirect()->back();
                }
            }
//        } catch (\Exception $e) {
//            //dd($e->getMessage());
//            Toastr::error('Operation Failed', 'Failed');
//            return redirect()->back();
//        }
    }
    public function edit(Request $request, $id){
        try {
            $semester = SmSemester::find($id);
            $semesters = SmSemester::where('active_status', '=', 1)->orderBy('id', 'desc')->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->get();
//            $academic_years = SmAcademicYear::where('active_status',1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id',Auth::user()->school_id)->get();
            $academic_years =SmAcademicYear::all();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['semester'] = $semester->toArray();
                $data['semesters'] = $semesters->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }

            return view('backEnd.systemSettings.semester', compact('semester', 'semesters','academic_years'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function update(Request $request){
        $input = $request->all();
        $validator = Validator::make($input, [
//            'semester_name' => "required|max:200|unique:sm_semester,semester_name," . $request->id,
//            'semester_name_kh' => "required|max:200|unique:sm_semester,semester_name_kh," . $request->id
        ]);

        $request->validate([
            'semester_name' => 'required',
            'semester_name_kh' => 'required',
        ]);

//        $is_duplicate = SmSemester::where('semester_name', $request->semester_name)->where('semester_name_kh', $request->semester_name_kh)->where('id','!=', $request->id)->first();
//        if ($is_duplicate) {
//            Toastr::error('Duplicate semester name found!', 'Failed');
//            return redirect()->back()->withErrors($validator)->withInput();
//        }

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

//        try {
            $semester = SmSemester::find($request->id);
            $semester->semester_code = $request->semester_code;
            $semester->semester_name = $request->semester_name;
            $semester->semester_name_kh = $request->semester_name_kh;
            $semester->academic_year_id = $request->academic_year_id;
            $semester->start_date = date('Y-m-d', strtotime($request->start_date));
            $semester->end_date = date('Y-m-d', strtotime($request->end_date));
            $semester->updated_by = Auth::user()->id;
            $result = $semester->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'Semester has been updated successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            } else {
                if ($result) {
                    Toastr::success('Operation successful', 'Success');

                    return redirect('semester');
                } else {
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
            }
//        } catch (\Exception $e) {
//            Toastr::error('Operation Failed', 'Failed');
//            return redirect()->back();
//        }
    }
    public function delete(Request $request, $id) {
        try {
            $tables = \App\tableList::getTableList('semester_id', $id);
            try {
                if ($tables == null) {
                    $delete_query = $semester = SmSemester::find($id);
//                    $delete_query -> active_status = '0';
                    $delete_query->delete();

                    if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                        if ($semester) {
                            return ApiBaseMethod::sendResponse(null, 'Semester has been deleted successfully');
                        } else {
                            return ApiBaseMethod::sendError('Something went wrong, please try again.');
                        }
                    } else {
                        if ($delete_query) {
                            Toastr::success('Operation successful', 'Success');
                            return redirect('semester');
                        } else {
                            Toastr::error('Operation Failed', 'Failed');
                            return redirect()->back();
                        }
                    }
                } else {
                    $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
                    Toastr::error($msg, 'Failed');
                    return redirect()->back();
                }
            } catch (\Illuminate\Database\QueryException $e) {

                $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
                Toastr::error($msg, 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}
