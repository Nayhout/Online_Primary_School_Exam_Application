<?php

namespace App\Http\Controllers;
use App\SmStudent;
use App\SmWeekend;
use App\YearCheck;
use App\ApiBaseMethod;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;

class TemporaryCertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware('PM');
    }

    public function index($id,$exam_date=null)
    {
        $students = SmStudent::find($id);

        return view('backEnd.admin.temporary_certificate', compact('students'));
    }


 
}
