<?php

namespace App\Http\Controllers;
use App\SmAcademicYear;
use App\SmBaseSetup;
use App\SmBuilding;
use App\SmClass;
use App\SmClassSection;
use App\SmDegree;
use App\SmExamType;
use App\SmFaculty;
use App\SmMajor;
use App\SmSection;
use App\SmSemester;
use App\SmStudent;
use App\SmStudentCategory;
use App\SmWeekend;
use App\YearCheck;
use App\ApiBaseMethod;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DegreeStatisticController extends Controller
{
    public function __construct()
    {
        $this->middleware('PM');
    }

    public function index(Request $request)
    {
        return view('backEnd.admin.DegreeStatistics');
    }

    public function Degrees(Request $request){
//        try {
            $degrees = SmDegree::where('active_status', '=', 1)->get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse($degrees, null);
            }
//        } catch (\Exception $e) {
//            Toastr::error('Operation Failed', 'Failed');
//            return redirect()->back();
//        }
        return view('backEnd.academics.degree', compact('degrees'));
    }

    public function DegreesStore(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'degree_name' => "required|max:200|unique:sm_degrees,degree_name," . $request->id,
//            'year' => "required|max:200|unique:sm_degrees,year," . $request->id
        ]);

        $is_duplicate = SmDegree::where('degree_name', $request->degree_name)->where('id','!=', $request->id)->first();
        if ($is_duplicate) {
            if ($is_duplicate->active_status == null){
                $degree = new SmDegree();
                $degree->code = $request->code;
                $degree->degree_name = $request->degree_name;
                $degree->degree_name_kh = $request->degree_name_kh;
//                $degree->year = $request->year;
                $degree->description = $request->description;
                $degree->created_by = Auth::user()->id;
                $result = $degree->save();
                if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                    if ($result) {
                        return ApiBaseMethod::sendResponse(null, 'Degree has been created successfully');
                    } else {
                        return ApiBaseMethod::sendError('Something went wrong, please try again.');
                    }
                } else {
                    if ($result) {
                        Toastr::success('Operation successful', 'Success');
                        return redirect()->back();
                    }
                }
            }
        }

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $academic_year=SmAcademicYear::where('school_id',Auth::user()->school_id)->first();
        if ($academic_year==null) {
            Toastr::warning('Create academic year first', 'Warning');
            return redirect()->back();
        }

        try {
            $degree = new SmDegree();
            $degree->code = $request->code;
            $degree->degree_name = $request->degree_name;
            $degree->degree_name_kh = $request->degree_name_kh;
//            $degree->year = $request->year;
            $degree->description = $request->description;
            $degree->created_by = Auth::user()->id;
            $result = $degree->save();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'Degree has been created successfully');
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

    public function DegreesEdit(Request $request, $id)
    {

        try {
            $degree = SmDegree::find($id);
            $degrees = SmDegree::where('active_status', '=', 1)->orderBy('id', 'desc')->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['degree'] = $degree->toArray();
                $data['degrees'] = $degrees->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }

            return view('backEnd.academics.degree', compact('degree', 'degrees'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function DegreesUpdate(Request $request)
    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'degree_name' => "required|max:200|unique:sm_degrees,degree_name," . $request->id,
//            'year' => "required|max:200|unique:sm_degrees,year," . $request->id,
        ]);

        $is_duplicate = SmDegree::where('degree_name', $request->degree_name)->where('id','!=', $request->id)->first();
        if ($is_duplicate) {
            Toastr::error('Duplicate Degree name found!', 'Failed');
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
            $degree = SmDegree::find($request->id);
            $degree->code = $request->code;
            $degree->degree_name = $request->degree_name;
            $degree->degree_name_kh = $request->degree_name_kh;
//            $degree->year = $request->year;
            $degree->description = $request->description;
            $degree->created_by = null;
            $degree->updated_by = Auth::user()->id;
            $result = $degree->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'Degree has been updated successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            } else {
                if ($result) {
                    Toastr::success('Operation successful', 'Success');

                    return redirect('degree');
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
    public function DegreesDelete(Request $request, $id)
    {
//        try {
//            $tables = tableList::getTableList('faculty_id', $id);
        try {
//                if ($tables == null) {
            $delete_query = $degree = SmDegree::find($id);
            $delete_query -> active_status = '0';
            $delete_query->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($degree) {
                    return ApiBaseMethod::sendResponse(null, 'Degree has been deleted successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            } else {
                if ($delete_query) {
                    Toastr::success('Operation successful', 'Success');
                    return redirect('degree');
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
//
//                $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
//                Toastr::error($msg, 'Failed');
//                return redirect()->back();
//            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function StaticDegree(Request $request)
    {
        try {
            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $types = SmStudentCategory::where('school_id', Auth::user()->school_id)->get();
            $genders = SmBaseSetup::where('active_status', '=', '1')->where('base_group_id', '=', '1')->get();
            $faculties = DB::table('sm_faculty')->where('active_status', '=', '1')->select('id','faculty_name')->get();
            $academic_years = SmAcademicYear::where('school_id', Auth::user()->school_id)->get();
            $generations = DB::table('sm_generation')->where('active_status', '=', "1")->select('generation_name')->get();
            $students = SmStudent::where('school_id', Auth::user()->school_id)->get();
            $semesters = DB::table('sm_semester')->where('active_status',1)->select('id','semester_name')->get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['classes'] = $classes->toArray();
                $data['types'] = $types->toArray();
                $data['genders'] = $genders->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.reports.student_degree', compact('classes', 'types', 'genders', 'faculties', 'academic_years', 'generations', 'students','semesters'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function ajaxStudentMajor(Request $request)
    {


        $majorIds = SmMajor::where('faculty_id', $request->id)->get();
//        dd($majorIds);
//dd($majorIds);
//        $majors = [];
//        foreach ($majorIds as $majorId) {
//            $majors[] = SmMajor::find($majorId->faculty_id);
//        }

        return response()->json($majorIds);
    }
    public function ajaxSelectSemester(Request $request)
    {


        $semesterIds = SmSemester::where('academic_year_id', $request->id)->get();

//        $majors = [];
//        foreach ($majorIds as $majorId) {
//            $majors[] = SmMajor::find($majorId->faculty_id);
//        }

        return response()->json($semesterIds);
    }


 
}
