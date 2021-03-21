<?php

namespace App\Http\Controllers;

use App\SmClass;
use App\SmPickUp;
use App\SmStudent;
use App\SmStudentCategory;
use App\SmStudentIdCard;
use App\YearCheck;
use Barryvdh\DomPDF\Facade as PDF;
use Modules\RolePermission\Entities\InfixRole;
use App\Role;
use App\User;
use App\SmStaff;
use App\tableList;
use App\SmBaseSetup;

use App\SmGeneralSettings;
use App\SmEmailSetting;

use App\ApiBaseMethod;
use App\SmDesignation;
use App\SmLeaveRequest;
use App\SmHumanDepartment;
use App\SmStudentDocument;
use App\SmStudentTimeline;
use App\SmHrPayrollGenerate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Promise\all;

class PickUpStudentController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('PM');
//    }

    public function pickupList(Request $request)
    {

//dd("Asfsd");
        $pickup = SmPickUp::all();
        $pickup_data = SmStudent::all();
        $students= SmStudent::where('school_id', Auth::user()->school_id)
            ->whereIn('section_id',array(1,36))
            ->get();

        $arr_student = [];
        if($students != null){
            foreach ($students as $row){
                $arr_student[$row->id]=$row;
            }
        }



        if (ApiBaseMethod::checkUrl($request->fullUrl())) {

//            return ApiBaseMethod::sendResponse($staffs_api, null);
        }
//        return view('backEnd.admin.pickup_student', compact('pickup','students','arr_student'));
        return view('backEnd.admin.pickup_student', [
            'arr_student' => $arr_student,
            'pickup'=>$pickup,
            'pickup_data'=>$pickup_data,

        ]);
    }
    public function pickupAdd(){
        try{
            $max_pickup_no = SmPickUp::where('school_id',Auth::user()->school_id)
                ->max('pickup_no');
            $students= SmStudent::where('school_id', Auth::user()->school_id)
                ->whereIn('section_id',array(1,36))
                ->get();

//            dd($students);

            $pickup = SmPickUp::all();
            $genders = SmBaseSetup::where('active_status', '=', '1')
                ->where('base_group_id', '=', '1')
                ->get();


            return view('backEnd.admin.add_pickup', compact('max_pickup_no','pickup','genders','students'));
        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function pickupStore(Request $request)
    {

        $request->validate([
            'student' => 'required',
            'first_name' => "required|max:200",
            'last_name' => "required|max:200",
            'photo' => 'required|image|mimes:jpeg,png,jpg',
            'email' => 'required',
            'mobile' => "required|max:30",
            'date_of_birth' => 'required',
            'gender_id' => 'required',

            ]);

        // for upload pickup photo
         $pickup_photo = "";
         if ($request->file('photo') != "") {
             $file = $request->file('photo');
             $pickup_photo = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
             $file->move('public/uploads/pickups_photos/', $pickup_photo);
             $pickup_photo = 'public/uploads/pickups_photos/' . $pickup_photo;
         }
        $user = new SmPickUp();
        $user->pickup_no = $request->pickup_no;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->full_name = $request->first_name . ' ' . $request->last_name;
        $user->khmer_name = $request->bank_name;
        $user->date_of_birth = date('Y-m-d', strtotime($request->date_of_birth));
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->emergency_mobile = $request->emergency_mobile;
        $user->current_address = $request->current_address;
        $user->permanent_address  = $request->permanent_address;
        $user->location  = $request->location;
        $user->facebook_url  = $request->facebook_url;
        $user->twiteer_url  = $request->twiteer_url;
        $user->linkedin_url  = $request->linkedin_url;
        $user->instragram_url  = $request->instragram_url;
        $user->other_document  = $request->other_document;
        $user->notes  = $request->notes;
        $user->pickup_photo =$pickup_photo;
        $user->student_id = $request->student;
        $user->school_id = Auth::user()->school_id;
        $user->save();
        $user->toArray();


        Toastr::success('Operation successful', 'Success');
        return redirect('pick-up');
        DB::rollback();
        Toastr::error('Operation Failed', 'Failed');
        return redirect()->back();

        if ($results) {
            Toastr::success('Operation successful', 'Success');
            return redirect('pick-up');
        } else {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function searchPickup(Request $request)
    {

        try{

            $pickup = SmPickUp::query();
            $pickup_data = SmStudent::all();
            $pickup->where('active_status', 1);
            if ($request->full_name != "") {
                $pickup->where('student_id', $request->full_name);
            }
//            dd($request->full_name);
            $pickup = $pickup->where('school_id',Auth::user()->school_id)->get();
            $students= SmStudent::where('school_id', Auth::user()->school_id)
                ->whereIn('section_id',array(1,36))
                ->get();

            $arr_student = [];
            if($students != null){
                foreach ($students as $row){
                    $arr_student[$row->id]=$row;
                }
            }

            return view('backEnd.admin.pickup_student', compact('pickup','pickup_data','arr_student'));
        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function pickupView($id)
    {

        try{
            $pickupDetails = SmPickUp::find($id);
            $students= SmStudent::where('school_id', Auth::user()->school_id)->get();
            $arr_student = [];
            if($students != null){
                foreach ($students as $row){
                    $arr_student[$row->id]=$row;
                }
            }



            if (!empty($pickupDetails)) {
                return view('backEnd.admin.viewPickup', compact('pickupDetails','arr_student'));
            } else {
                Toastr::error('Something went wrong, please try again', 'Failed');
                return redirect()->back();
            }
        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function deletePickupView($id)
    {

        try{
            return view('backEnd.admin.deletePickupView', compact('id'));
        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function deletePickup($id)
    {
//        $pickups = SmPickUp::find($id);
//        if ($pickups!=null){
//            $pickups->delete();
//           // Toastr::success('Operation successful', 'Success');
//            return redirect()->back()->with('message','Delete Successfully!');
//        }


        try {
            $pickups = SmPickUp::find($id);
            $pickups->delete();

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Illuminate\Database\QueryException $e) {

            $msg = 'This data already used, Please remove those data first';
            Toastr::error($msg, 'Failed');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }


    }


    public function generatePickupCard(){

            try {
                $pickup_data = SmStudent::where('school_id', Auth::user()->school_id)
                    ->whereIn('section_id',array(1,36))
                    ->get();



                $id_cards = SmStudentIdCard::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
                $classes = SmClass::where('active_status', 1)->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('school_id', Auth::user()->school_id)->get();
                return view('backEnd.admin.generate_pickup_card', compact('pickup_data','id_cards', 'classes'));
            } catch (\Exception $e) {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }


    }



    public function printPickUp()
    {
       dd('hello');

        return view('backEnd.admin.generate_pickup_card');
    }
    public function generatePickupCardPrint($s_id)
    {
        set_time_limit(2700);
        try {

            $s_ids = explode('-', $s_id);
            $pickups = [];
            foreach ($s_ids as $sId) {
                $pickups[] = SmPickUp::select('pickup_photo')->where('id',$sId)->first();
            }
            // return $students;


            // return ['id_card' => $id_card, 'students' => $students];
            return view('backEnd.admin.generate_pickup_card', [ 'pickups' => $pickups]);

            $pdf = PDF::loadView('backEnd.admin.generate_pickup_card', [ 'pickups' => $pickups]);
            return $pdf->stream($id_card->title . '.pdf');
        } catch (\Exception $e) {
            dd($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

}