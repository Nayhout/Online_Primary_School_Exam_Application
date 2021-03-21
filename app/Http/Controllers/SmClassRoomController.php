<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\SmAcademicYear;
use App\SmBaseSetup;
use App\SmBuilding;
use App\SmClass;
use App\SmGeneralSettings;
use App\SmParent;
use App\SmStudent;
use App\User;
use App\YearCheck;
use App\SmClassRoom;
use App\ApiBaseMethod;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SmClassRoomController extends Controller
{

    public function __construct()
    {
        $this->middleware('PM');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        try {
            $building = SmBuilding::where('active_status', 1)->get();
            $class_rooms = SmClassRoom::where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse($class_rooms, null);
            }
            return view('backEnd.academics.class_room', compact('class_rooms', 'building'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $input = $request->all();
        $validator = Validator::make($input, [
            'room_no' => 'required|max:100',
            'capacity' => 'required'
        ]);
        $is_duplicate = SmClassRoom::where('school_id', Auth::user()->school_id)->where('room_no', $request->room_no)->first();
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
            $class_room = new SmClassRoom();
            $class_room->room_no = $request->room_no;
            $class_room->capacity = $request->capacity;
            $class_room->school_id = Auth::user()->school_id;
            $class_room->building_id = $request->building_id;
            $result = $class_room->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'Class Room has been created successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            } else {
                if ($result) {
                    Toastr::success('Operation successful', 'Success');
                    return redirect()->back();
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

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {


        try {
            $building = SmBuilding::where('active_status', 1)->get();
            $class_room = SmClassRoom::find($id);
            $class_rooms = SmClassRoom::where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['class_room'] = $class_room->toArray();
                $data['class_rooms'] = $class_rooms->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }

            return view('backEnd.academics.class_room', compact('class_room', 'class_rooms', 'building'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        dd($request->all());
        $input = $request->all();
        $validator = Validator::make($input, [
            'room_no' => 'required',
            'capacity' => 'required'
        ]);
        $is_duplicate = SmClassRoom::where('school_id', Auth::user()->school_id)->where('id', '!=', $request->id)->where('room_no', $request->room_no)->first();
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

//        try {
        $class_room = SmClassRoom::find($request->id);
        $class_room->room_no = $request->room_no;
        $class_room->capacity = $request->capacity;
        $class_room->building_id = $request->building_id;
        $result = $class_room->save();

        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
            if ($result) {
                return ApiBaseMethod::sendResponse(null, 'Class Room has been updated successfully');
            } else {
                return ApiBaseMethod::sendError('Something went wrong, please try again.');
            }
        } else {
            if ($result) {
                Toastr::success('Operation successful', 'Success');
                return redirect('class-room');
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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        try {
            $id_key = 'room_id';
            $tables = \App\tableList::getTableList('room_id', $id);

            try {
                if ($tables == null) {
                    $delete_query = SmClassRoom::find($id);
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
            //dd($e->getMessage(), $e->errorInfo);
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function importRoom()
    {
        try {
//            $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $buildings = SmBuilding::where('active_status', '=', 1)->get();
            return view('backEnd.studentInformation.import_room', compact('buildings'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function downloadRoomFile()
    {
//         try {

        $roomsArray = ['room_no', 'capacity', 'building_code'];
        return Excel::create('rooms', function ($excel) use ($roomsArray) {
            $excel->sheet('room', function ($sheet) use ($roomsArray) {
                $sheet->fromArray($roomsArray);
            });
        })->download('xlsx');
//         } catch (\Exception $e) {
//             Toastr::error('Operation Failed', 'Failed');
//             return redirect()->back();
//         }
    }

    public function roomBulkStore(Request $request)
    {
//        $request->validate([
//            'room_no' => 'required',
//        ]);


        $file_type = strtolower($request->file->getClientOriginalExtension());
        if ($file_type <> 'csv' && $file_type <> 'xlsx' && $file_type <> 'xls') {
            Toastr::warning('The file must be a file of type: xlsx, csv or xls', 'Warning');
            return redirect()->back();
        } else {
            try {

                $path = $request->file('file')->getRealPath();
                $data = Excel::load($path, function ($reader) {
                })->get();

                /*   $usersUnique = $data->unique('admission_number');
                $usersDupes = $data->diff($usersUnique);
                dd(sizeof($usersDupes));
                if (sizeof($usersDupes) > sizeof($data)) {
                    return redirect()->back()->with("message-danger","Admission number required");
                 }
                if (sizeof($usersDupes) >= 1) {
                   return redirect()->back()->with("message-danger","Admission number should be unique");
                } */


//                $shcool_details = SmGeneralSettings::find(1);
//                $school_name = explode(' ', $shcool_details->school_name);
//                $short_form = '';
//                foreach ($school_name as $value) {
//                    $ch = str_split($value);
//                    $short_form = $short_form . '' . $ch[0];
//                }

                if (!empty($data)) {
                    DB::beginTransaction();
//                    dd($data);
                    foreach ($data as $key => $value) {
                        if ($value->filter()->isNotEmpty()) {
                            $chk = DB::table('sm_building')->where('code', $value->building_code)->count();
//                            dd($chk,$value->building_code);
                            if ($chk == 0) {
                                return redirect()->back()->with("message-danger", "Please create Building First. Code: {$value->building_code}");
                            }
//                            $roomsArray = ['building_code'];
                            $building = SmBuilding::where('code', $value->building_code)->first();
//                            dd($building,$value->building_code);
//                            if ($building == $roomsArray){
//                                return redirect()->back()->with("message-danger", "Please add Building First");
//                            }
//                            if($building == $value->building_code) {
//                                return redirect()->back()->with("message-danger", "Please Create Building First: {$value->building_code}" );
//                            }

                            try {
                                $class_rooms = new SmClassRoom();
                                $class_rooms->room_no = $value->room_no;
                                $class_rooms->capacity = $value->capacity;
                                $class_rooms->created_by = Auth::user()->id;
                                $class_rooms->building_id = optional($building)->id;

                                $class_rooms->save();
                                $class_rooms->toArray();
                            } catch (\Illuminate\Database\QueryException $e) {
                                return redirect()->back()->with("message-danger", "Capacity number should be unique");
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
                    return redirect('class-room');
                }
            } catch (\Exception $e) {

                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        }
    }
}