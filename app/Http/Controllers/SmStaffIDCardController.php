<?php

namespace App\Http\Controllers;
use App\ApiBaseMethod;
use App\Http\Controllers\SmStaffIDController;
use App\SmDesignation;
use App\SmHumanDepartment;
use App\SmStaff;
use App\SmStaffIDCard;
use App\SmToDo;
use Auth;
use App\SmStaffID;
use App\YearCheck;
use Barryvdh\DomPDF\Facade as PDF;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SmStaffIDCardController extends Controller
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
    public function index()
    {
//        try {
            $staff_id_cards = SmStaffIDCard::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
//                $staff_id_cards = SmStaffIDCard::all();
//                dd($staff_id_cards);
            return view('backEnd.humanResource.staff_id_card', compact('staff_id_cards'));

//        } catch (\Exception $e) {
//            Toastr::error('Operation Failed', 'Failed');
//            return redirect()->back();
//        }
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


    public function show()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $request->validate([
//            'address' => '',
            'title' => 'required',
//            'designation' => 'required',
//            'logo' => '|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//            'signature' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $fileNameLogo = "";
            if ($request->file('logo') != "") {
                $file = $request->file('logo');
                $fileNameLogo = 'logo-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('public/uploads/studentIdCard/', $fileNameLogo);
                $fileNameLogo = 'public/uploads/studentIdCard/' . $fileNameLogo;
            }

            $fileNameSignature = "";
            if ($request->file('signature') != "") {
                $file = $request->file('signature');
                $fileNameSignature = 'signature-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('public/uploads/studentIdCard/', $fileNameSignature);
                $fileNameSignature = 'public/uploads/studentIdCard/' . $fileNameSignature;
            }

            $staff_id_card = new SmStaffIDCard();
            $staff_id_card->title = $request->title;
//            $staff_id_card->logo = $fileNameLogo;
            $staff_id_card->designation = $request->designation;
            $staff_id_card->department = $request->department;
            $staff_id_card->school_id = Auth::user()->school_id;

            if (isset($fileNameSignature)) {
                $staff_id_card->signature = $fileNameSignature;
            }

//            $staff_id_card->address = $request->address;
//            $staff_id_card->admission_no = $request->admission_no;
            $staff_id_card->staff_name = $request->staff_name;
//            $staff_id_card->class = $request->class;
            //$id_card->father_name = $request->father_name;
            //$id_card->mother_name = $request->mother_name;
            //$id_card->student_address = $request->student_address;
            // $id_card->phone = $request->mobile;
            // $id_card->dob = $request->dob;
            // $id_card->blood = $request->blood;


            $result = $staff_id_card->save();

            if ($result) {
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
                // return redirect()->back()->with('message-danger', 'Something went wrong, please try again');
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function edit($id)
    {

        try {
            $staff_id_cards = SmStaffIDCard::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
            $staff_id_card = SmStaffIDCard::find($id);
            return view('backEnd.humanResource.staff_id_card',compact('staff_id_cards', 'staff_id_card'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
//            'address' => '',
            'title' => 'required',
//            'designation' => 'required',


        ]);

        try {
            $fileNamelogo = "";
            if ($request->file('logo') != "") {
                $staff_id_card = SmStaffIDCard::find($request->id);
                if ($staff_id_card->logo != "") {
                    if (file_exists($staff_id_card->logo)) {
                        unlink($staff_id_card->logo);
                    }
                }

                $file = $request->file('logo');
                $fileNamelogo = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('public/uploads/studentIdCard/', $fileNamelogo);
//                $fileNamelogo = 'public/uploads/studentIdCard/' . $fileNamelogo;
            }

//            $fileNameSignature = "";
//            if ($request->file('signature') != "") {
//                $staff_id_card = SmStaffIDCard::find($request->id);
//                if ($staff_id_card->signature != "") {
//                    if (file_exists($staff_id_card->signature)) {
//                        unlink($staff_id_card->signature);
//                    }
//                }
//
//                $file = $request->file('signature');
//                $fileNameSignature = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
//                $file->move('public/uploads/studentIdCard/', $fileNameSignature);
//                $fileNameSignature = 'public/uploads/studentIdCard/' . $fileNameSignature;
//            }
            $staff_id_card = SmStaffIDCard::find($request->edit_id);

//            dd($request->all());
            if($staff_id_card != null){
                $staff_id_card->title = $request->title;
                $staff_id_card->designation = $request->designation;
                $staff_id_card->department = $request->department;
                $staff_id_card->staff_name = $request->staff_name;
                if ($fileNamelogo != "") {
                    $staff_id_card->logo = $fileNamelogo;
                }
            }

//            if ($fileNameSignature != "") {
//                $staff_id_card->signature = $fileNameSignature;
//            }
//            $staff_id_card->address = $request->address;
//            $staff_id_card->admission_no = $request->admission_no;


//            $staff_id_card->designation = $request->designation;

//            $staff_id_card->class = $request->class;
//            $staff_id_card->father_name = $request->father_name;
//            $staff_id_card->mother_name = $request->mother_name;
//            $id_card->student_address = $request->student_address;
//            $id_card->phone = $request->mobile;
//            $id_card->dob = $request->dob;
//            $id_card->blood = $request->blood;


            $result =$staff_id_card != null ? $staff_id_card->save() : null;
            if ($result) {
                Toastr::success('Operation successful', 'Success');
                return redirect('staff-id-card');
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {
            $staff_id_card = SmStaffIDCard::find($id);
            if ($staff_id_card->logo != "") {
                unlink($staff_id_card->logo);
            }

//            if ($staff_id_card->designation != "") {
//                unlink($staff_id_card->designation);
//            }

            $result = $staff_id_card->delete();
            if ($result) {
                Toastr::success('Operation successful', 'Success');
                return redirect('staff-id-card');
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function generateStaffIDCard(Request $request)
    {
        try {
            $staff_id_cards = SmStaffIDCard::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
//            $designations = SmDesignation::where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            $departments = SmHumanDepartment::where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
//            dd($departments);
            return view('backEnd.humanResource.generate_staff_id_card', compact('staff_id_cards','departments'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function generateStaffIdCardSearch(Request $request)
    {



  //  dd($request->department,$request->designation);

        $request->validate([
//            'staff_id_card' => 'required',
//            'designation' => 'required',
//            'department' => 'required',

        ]);

//       try {
           $card_id = $request->staff_id_card;


           //dd();

            $department_id = $request->department;
            $designation_id = $request->designation;

            $staffs = SmStaff::query();
            $staffs->where('active_status', 1);
            $staffs->where('department_id',$request->department);
            $staffs->where('designation_id',$request->designation);
            $staffs = $staffs->where('school_id', Auth::user()->school_id)->get();
            $staffs->where('gender_id',$request->gender);
//            dd($staffs);
            $departments = SmHumanDepartment::where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            $designations = SmDesignation::where('active_status', 1)->where('department_id',$request->department)->where('school_id', Auth::user()->school_id)->get();
//            dd($designations);
            $staff_id_cards = SmStaffIDCard::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
//            dd($staff_id_cards);
            return view('backEnd.humanResource.generate_staff_id_card', compact('staff_id_cards','staffs','departments','designations','designation_id','department_id','card_id'));
//        } catch (\Exception $e) {
//            Toastr::error('Operation Failed', 'Failed');
//            return redirect()->back();
//        }
    }

    public function ajaxStaffIdCardPrint()
    {

        try {
            $pdf = PDF::loadView('backEnd.humanResource.staff_id_card_print');
            return response()->$pdf->stream('certificate.pdf');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function generateStaffIDCardPrint($staff_id, $depart_id)
    {
        set_time_limit(2700);
        try {

            $staff_ids = explode('-', $staff_id);
            $staffs = [];
            foreach ($staff_ids as $staffId) {
                $staffs[] = SmStaff::find($staffId);
            }
            // return $students;
            $staff_id_card = SmStaffIDCard::find($depart_id);

            // return ['id_card' => $id_card, 'students' => $students];
            return view('backEnd.humanResource.staff_id_card_print2', ['id_card' => $staff_id_card, 'staffs' => $staffs]);

            $pdf = PDF::loadView('backEnd.humanResource.staff_id_card_print2', ['id_card' => $staff_id_card, 'staffs' => $staffs]);
            return $pdf->stream($staff_id_card->title . '.pdf');
        } catch (\Exception $e) {
            dd($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function ajaxStaffDesignation(Request $request)
    {

        $designation = SmDesignation::where('department_id',$request->id)->get();

////        dd($staffs);
////        $designations = SmDesignation::find('id',$staffs->designation_id);
//        $departments = SmHumanDepartment::find('id',$des->department_id);

        return response()->json($designation);
    }

    public function addNewTask(Request $request){

//        dd($request->all());
        try{

        $new_tasks = new SmToDo();
        $new_tasks->todo_title = $request->name;
        $new_tasks->date = date('Y-m-d', strtotime($request->date));
        $new_tasks->due_date = date('Y-m-d', strtotime($request->due_date));
        $new_tasks->complete_status = $request->complete_status;
//        if ( $request->complete_status == 'Not Started'){
//            $new_tasks->complete_status = $request->complete_status;
//        }
//        elseif( $request->complete_status == 'Pending'){
//            $new_tasks->complete_status = $request->complete_status;
//        }
//        elseif( $request->complete_status == 'Testing'){
//            $new_tasks->complete_status = $request->complete_status;
//        }
//        elseif( $request->complete_status == 'Await Feedback'){
//            $new_tasks->complete_status = $request->complete_status;
//        }
//        elseif( $request->complete_status == 'Completed'){
//            $new_tasks->complete_status = $request->complete_status;
//        }
        $new_tasks->assign_staff_id = $request->assign_staff_id;
        $new_tasks->description = $request->description;
        $result = $new_tasks->save();
        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
            if ($result) {
                return ApiBaseMethod::sendResponse(null, 'Task has been added successfully.');
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

        }catch (\Exception $e) {
            dd($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }

    }

    public function editToDo($id)
    {
        try {

            $editData = SmToDo::find($id);
            return view('backEnd.dashboard.editToDo', compact('editData', 'id'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function updateToDo(Request $request,$to_do_id)
    {
//        dd($request->all());

//        try {
//            $to_do_id = $request->to_do_id;
        $new_tasks = SmToDo::find($request->to_do_id);
        dd($new_tasks,$to_do_id);
        $new_tasks->todo_title = $request->name;
        $new_tasks->date = date('Y-m-d', strtotime($request->date));
        $new_tasks->due_date = date('Y-m-d', strtotime($request->due_date));
        $new_tasks->complete_status = $request->complete_status;
//        if ( $request->complete_status == 'Not Started'){
//            $new_tasks->complete_status = $request->complete_status;
//        }
//        elseif( $request->complete_status == 'Pending'){
//            $new_tasks->complete_status = $request->complete_status;
//        }
//        elseif( $request->complete_status == 'Testing'){
//            $new_tasks->complete_status = $request->complete_status;
//        }
//        elseif( $request->complete_status == 'Await Feedback'){
//            $new_tasks->complete_status = $request->complete_status;
//        }
//        elseif( $request->complete_status == 'Completed'){
//            $new_tasks->complete_status = $request->complete_status;
//        }
        $new_tasks->assign_staff_id = $request->assign_staff_id;
        $new_tasks->description = $request->description;
        $new_tasks->updated_by = Auth::user()->id;
        $results = $new_tasks->save();

            if ($results) {
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
                // return redirect()->back()->with('message-success', 'To Do Data updated successfully');
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
                // return redirect()->back()->with('message-danger', 'Something went wrong, please try again');
            }
//        } catch (\Exception $e) {
//            Toastr::error('Operation Failed', 'Failed');
//            return redirect()->back();
//        }
    }

}
