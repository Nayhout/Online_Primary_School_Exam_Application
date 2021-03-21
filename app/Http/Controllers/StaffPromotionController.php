<?php

namespace App\Http\Controllers;

use App\ApiBaseMethod;
use App\SmAcademicYear;
use App\SmClass;
use App\SmClassSection;
use App\SmDesignation;
use App\SmExamType;
use App\SmGeneralSettings;
use App\SmHumanDepartment;
use App\SmSection;
use App\YearCheck;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffPromotionController extends Controller
{
    public function staffPromote(Request $request)
    {
        try {
            $designations = SmDesignation::where('department_id',$request->id)->get();
            $departments = SmHumanDepartment::where('department_id',$request->id)->get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['designations'] = $designations->toArray();
                $data['departments'] = $departments->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }

            $generalSetting = SmGeneralSettings::where('school_id', Auth::user()->school_id)->first();

            if ($generalSetting->promotionSetting == 0) {
                return view('backEnd.humanResource.staff_promote', compact('designations', 'departments'));
            } else {
                return view('backEnd.humanResource.staff_promote_custom', compact('designations', 'departments'));
            }

      } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentPromoteCustom(Request $request)
    {
        try {
                $designations = SmDesignation::where('department_id',$request->id)->get();
                $departments = SmHumanDepartment::where('department_id',$request->id)->get();
                if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['designations'] = $designations->toArray();
                $data['departments'] = $departments->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }

            $generalSetting = SmGeneralSettings::find(1);

            if ($generalSetting->promotionSetting == 0) {
                return view('backEnd.humanResource.staff_promote', compact('designations', 'departments'));
            } else {
                return view('backEnd.humanResource.staff_promote_custom', compact('designations', 'departments'));
            }

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

}
