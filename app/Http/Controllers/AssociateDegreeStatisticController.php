<?php

namespace App\Http\Controllers;
use App\SmClass;
use App\SmStudent;
use App\SmTemporaryMeritlist;
use App\SmWeekend;
use App\YearCheck;
use App\ApiBaseMethod;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;

class AssociateDegreeStatisticController extends Controller
{
    public function __construct()
    {
        $this->middleware('PM');
    }

    public function index(Request $request)
    {
        $student_associates = SmStudent::where('active_status','=',1)
            ->where('class_id','=',2)
            ->get();

//        dd($student_associates);
        return view('backEnd.admin.AssociateDegreeStatistics',compact('student_associates'));
    }


 
}
