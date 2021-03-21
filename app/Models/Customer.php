<?php

namespace App\Models;

use App\SmAcademicYear;
use App\SmClass;
use App\SmGeneralSettings;
use App\SmSection;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $connection = 'erp';
    protected $table = 'customers';

    public static function getCustomer($student){
        $cus = Customer::where('student_id',$student->id)->first();
        if($cus == null){
            $cus = new Customer();
        }

        $academic = SmAcademicYear::find($student->session_id);
        $class = SmClass::find($student->class_id);
        $section = SmSection::find($student->section_id);
        $cus->code = $student->roll_no;
        $cus->company_kh = '';
        $cus->company = '';
        $cus->name = $student->full_name;
        $cus->name_khmer = $student->bank_name;
        $cus->email = $student->email;
        $cus->phone = $student->mobile;
        $cus->address_1 = '';
        $cus->student_id = $student->id;
        $cus->class_id = $student->class_id;
        $cus->class_name = $class->class_name;
        $cus->section_id = $student->section_id;
        $cus->section_name = $section->section_name;
        $cus->academic_id = $academic->id;
        $cus->academic_title = $academic->title;
        $cus->ar_acc_id = 208;
        $cus->deposit_acc_id = 208;
        $cus->transport_acc_id = 208;
        $cus->sale_disc_acc_id = 285;
        $cus->currency_id = 1;
        $cus->branch_id = 1;
        if($cus->save()){
            $student->is_transfer = 1;
            $student->save();
        }

    }
    public static function getPromoteStudent($student){

        $cus = new Customer();

        $academic = SmAcademicYear::find($student->session_id);
        $class = SmClass::find($student->class_id);
        $section = SmSection::find($student->section_id);
        $cus->code = $student->roll_no;
        $cus->company_kh = '';
        $cus->company = '';
        $cus->name = $student->full_name;
        $cus->name_khmer = $student->bank_name;
        $cus->email = $student->email;
        $cus->phone = $student->mobile;
        $cus->address_1 = '';
        $cus->student_id = $student->id;
        $cus->class_id = $student->class_id;
        $cus->class_name = $class->class_name;
        $cus->section_id = $student->section_id;
        $cus->section_name = $section->section_name;
        $cus->academic_id = $academic->id;
        $cus->academic_title = $academic->title;
        $cus->ar_acc_id = 208;
        $cus->deposit_acc_id = 208;
        $cus->transport_acc_id = 208;
        $cus->sale_disc_acc_id = 285;
        $cus->currency_id = 1;
        $cus->branch_id = 1;
        if($cus->save()){
            $student->is_transfer = 1;
            $student->save();
        }

    }
    public static function deleteCustomer($student_id){
        Customer::where("student_id",$student_id)->delete();
    }
}
