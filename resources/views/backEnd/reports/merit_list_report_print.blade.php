<!DOCTYPE html>
<html lang="en">
<head>
    <title>@lang('lang.merit_list') </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/vendors/css/print/bootstrap.min.css"/>
    <script type="text/javascript" src="{{asset('public/backEnd/')}}/vendors/js/print/jquery.min.js"></script>
    <script type="text/javascript" src="{{asset('public/backEnd/')}}/vendors/js/print/bootstrap.min.js"></script>
</head>
<style>
    body, table, th, td {
        font-family: 'Poppins', sans-serif;

    }

    @page { size: A4 }


    .border th, .border td {
        border: 1px solid black;
        padding: 9px 1px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        /*border: 1px solid black;*/
    }
    .border1{
        text-align: right;
        font-size: 20px;
        font-family: 'Khmer Moul';
        width: 90%;
    }
    .border2{
        text-align: left;
        font-size: 20px;
        font-family: 'Khmer Moul';
        margin-left: 71px;
    }
    .border3{
        text-align: center;
        font-family: 'Khmer Moul';
        font-weight: bold;
        font-size: 18px
    }
    .border4{
        text-align: left;
        font-size: 20px;
        font-family: 'Khmer Moul';
        margin-left: 71px;

    }
    .table1{
        padding: 60px;
    }

    /*.marklist th, .marklist td {*/
    /*    border: 1px solid #ddd;*/
    /*    text-align: center !important;*/
    /*    font-family: 'Poppins', sans-serif;*/

    /*}*/

    /*.marklist th {*/
    /*    text-transform: capitalize;*/
    /*    text-align: center;*/
    /*}*/

    /*.marklist td {*/
    /*    text-align: center;*/
    /*}*/


    .container {
        padding-bottom: 50px;
        background: white;
        font-family: 'Poppins', sans-serif;
    }

    h1, h2, h3, h4 {

        font-family: "Poppins", sans-serif;
        margin-bottom: 15px;
    }

    hr {
        margin: 0px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .mb-10 {
        margin-bottom: 10px;
    }
    @media print {
        .border1{
            text-align: right;
            font-size: 20px;
            font-family: 'Khmer Moul';
            width: 100%;
        }
        table td , th{
            padding: 10px 5px;
        }
        .border2{
            text-align: left;
            font-size: 20px;
            font-family: 'Khmer Moul';
            margin-left: 10px;
            width: 100%;

        }
        .border4{
            text-align: left;
            font-size: 20px;
            font-family: 'Khmer Moul';
            margin-left: 10px;
            width: 100%;
            height: 19px;

        }
        /*#rotate{*/
        /*    transform: rotate(90deg);*/
        /*}*/
        .table1{
            padding: 0px;
        }
        .print{
            display: none;
            margin: 0;
        }


        .footers {page-break-after: always;}

    }


</style>
<body>


@php
    $generalSetting= App\SmGeneralSettings::find(1); 
    if(!empty($generalSetting)){
        $school_name =$generalSetting->school_name;
        $site_title =$generalSetting->site_title;
        $school_code =$generalSetting->school_code;
        $address =$generalSetting->address;
        $phone =$generalSetting->phone; 
    }
    $student = \App\SmStudent::find($allresult_dat->student_id);
    $major = \App\SmMajor::find($student->major_id);
    $degree = \App\SmDegree::find($student->degree_id);
    $generation = \App\SmGeneration::find($student->generation_id);
@endphp
<div class="container">
    {{--        <table style="width:100%; border:0;"> --}}
    {{--                <tr >--}}
    {{--                    --}}
    {{--                    <th>--}}
    {{--                        <img class="logo-img" src="{{ url('/')}}/{{$generalSetting->logo }}" alt=""> --}}
    {{--                    </th>--}}
    {{--                    <th colspan="2"> --}}
    {{--                        <h3 class="text-white"> {{isset($school_name)?$school_name:'Infix School Management ERP'}} </h3> --}}
    {{--                        <p class="text-white mb-0" style="padding-right:10px !important;"> {{isset($address)?$address:'Infix School Address'}} </p>--}}
    {{--                    </th> --}}

    {{--                </tr>  --}}
    {{--                <tr>--}}
    {{--                    <td colspan="3"><hr></td>--}}
    {{--                </tr>--}}
    {{--                <tr>--}}
    {{--                    <td  style=" padding:10px; vertical-align:top;">--}}
    {{--                        --}}
    {{--                        <p class="mb-0" style="padding-right:10px !important; font-size:11px;"> @lang('lang.academic_year') : <span class="primary-color fw-500">{{$generalSetting->session_year}}</span> </p>--}}
    {{--                        <p class="mb-0" style="padding-right:10px !important; font-size:11px;"> @lang('lang.exam') : <span class="primary-color fw-500">{{$exam_name}}</span> </p>--}}
    {{--                        <p class="mb-0" style="padding-right:10px !important; font-size:11px;"> @lang('lang.class') : <span class="primary-color fw-500">{{$class_name}}</span> </p>--}}
    {{--                        <p class="mb-0" style="padding-right:10px !important; font-size:11px;"> @lang('lang.section') : <span class="primary-color fw-500">{{$section->section_name}}</span> </p>--}}
    {{--                    </td>--}}
    {{--                    <td  style="  padding:10px; vertical-align:top;"> --}}
    {{--                        <p style="font-weight: 700;">@lang('lang.subjects') @lang('lang.list')</p> --}}
    {{--                        <div class="row">--}}
    {{--                            <div class="col-md-12 w-100" style="columns: 2">--}}
    {{--                                @foreach($assign_subjects as $subject)--}}
    {{--                                <p class="mb-0" style="padding-right:10px !important; font-size:11px;"> <span class="primary-color fw-500">{{$subject->subject->subject_name}}</span> </p>--}}
    {{--                                @endforeach --}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </td>--}}
    {{--                    <td  style=" padding:10px; vertical-align:top;">--}}
    {{--                         @php $marks_grade=DB::table('sm_marks_grades')->where('created_at', 'LIKE', '%' . App\YearCheck::getYear() . '%')->get(); @endphp--}}
    {{--                                                    @if(@$marks_grade)--}}
    {{--                                                        <table class="table  table-bordered table-striped " id="grade_table">--}}
    {{--                                                            <thead>--}}
    {{--                                                                <tr>--}}
    {{--                                                                    <th>@lang('lang.staring')</th>--}}
    {{--                                                                    <th>@lang('lang.ending')</th>--}}
    {{--                                                                    <th>@lang('lang.gpa')</th>--}}
    {{--                                                                    <th>@lang('lang.grade')</th>--}}
    {{--                                                                    <th>@lang('lang.evalution')</th>--}}
    {{--                                                                </tr>--}}
    {{--                                                            </thead>--}}
    {{--                                                            <tbody>--}}
    {{--                                    --}}
    {{--                                                                @foreach($marks_grade as $grade_d)--}}
    {{--                                                                    <tr>--}}
    {{--                                                                        <td>{{$grade_d->percent_from}}</td>--}}
    {{--                                                                        <td>{{$grade_d->percent_upto}}</td>--}}
    {{--                                                                        <td>{{$grade_d->gpa}}</td>--}}
    {{--                                                                        <td>{{$grade_d->grade_name}}</td>--}}
    {{--                                                                        <td class="text-left">{{$grade_d->description}}</td>--}}
    {{--                                                                    </tr>--}}
    {{--                                                                @endforeach--}}
    {{--                                                            </tbody>--}}
    {{--                                                        </table>--}}
    {{--                                                    @endif --}}
    {{--                    </td>--}}
    {{--                </tr> --}}
    {{--        </table>--}}

    <table>
        <br>
        <br>
        <div>
            <div class="border1">ព្រះរាជាណាចក្រកម្ពុជា</div>
            <td>
                <div class="border2" style="margin-top: -57px;">ក្រសួងអប់រំយុវជន និងកីឡា</div>
            </td>
            <div class="border1">ជាតិ សាសនា ព្រះមហាក្សត្រ</div>
            <div class="border4" style="margin-top: -30px;">សាកលវិទ្យាល័យស្វាយរៀង</div>
        </div>
    </table>
    <br>
    <br>
    <br>
    <table>
        <div class="border3">
            <div>លទ្ធផលប្រឡង ឆមាសទី១ ឆ្នាំសិក្សា {{$generalSetting->session_year}}-{{$generalSetting->session_year+1}}</div>
            <div>ថ្នាក់{{@$degree->degree_name_kh}} {{@$generation->generation_name_kh}} ឆ្នាំទី៤</div>
            <div>ជំនាញ {{@$major->major_name_kh}} សិក្សាពេល {{@$section->section_name}} {{@$class_name}}</div>

        </div>
    </table>
    <h4 style=" text-align: center;  padding: 15px;"></h4>


    <table class="w-100 mt-30 mb-20 table table-bordered marklist" style="width: 100%">
        <thead>
        <tr>
            <th style="text-align: center;font-family: 'Khmer OS Battambang'">@lang('ល.រ')</th>
            <th style="text-align: center;font-family: 'Khmer OS Battambang'">@lang('អត្តលខ ')</th>
            <th style="text-align: center;font-family: 'Khmer OS Battambang'">@lang('គោត្តនាម-នាម')</th>
            <th style="text-align: center;font-family: 'Khmer OS Battambang'">@lang('ភេទ')</th>
            <th style="text-align: center;font-family: 'Khmer OS Battambang'">@lang('ថៃ្ងខែឆ្នាំកំណើត')</th>
            @foreach($subjectlist as $subject)
                <th id="rotate" width="20px">{{$subject}}</th>
            @endforeach

{{--            <th>@lang('lang.total_mark')</th>--}}
{{--            <th>@lang('lang.average')</th>--}}


{{--            @if ($optional_subject_setup!='')--}}
{{--                <th>@lang('lang.gpa')--}}
{{--                    <hr>--}}
{{--                    <small>@lang('lang.without_additional')</small>--}}

{{--                </th>--}}
{{--                --}}{{-- <th>@lang('lang.result')</th> --}}
{{--                <th>@lang('lang.gpa')</th>--}}
{{--                <th>@lang('lang.result')</th>--}}
{{--            @else--}}
{{--                <th>@lang('lang.gpa')</th>--}}
{{--                <th>@lang('lang.result')</th>--}}
{{--            @endif--}}
            <th style="text-align: center;font-family: 'Khmer OS Battambang'">@lang('ផ្សេងៗ')</th>
        </tr>
        </thead>

        <tbody>
        @php $i=1; $subject_mark = []; $total_student_mark = 0; $total_student_mark_optional = 0; @endphp

        @foreach($allresult_data as $row)

            @php




                $student_detail=App\SmStudent::where('id','=',$row->student_id)->first();
                $gender = \App\SmBaseSetup::find($student_detail->gender_id);
                        $optional_subject='';

                        $get_optional_subject=App\SmOptionalSubjectAssign::where('student_id','=',$student_detail->id)->where('session_id','=',$student_detail->session_id)->first();

                        if ($get_optional_subject!='') {
                                    $optional_subject=$get_optional_subject->subject_id;

                           }
                $male = 'ប្រុស';
                $female = 'ស្រី';
            @endphp
            <tr>
                <td style="text-align: center">{{@$loop->iteration}}</td>
                <td style="text-align: center">{{@$student_detail->roll_no}}</td>
                <td style="text-align:left !important;" nowrap>{{@$row->student_name}}</td>
                @if($gender->base_setup_name == 'Male')
                <td style="text-align: center;font-family: 'Khmer OS Battambang'">{{@$male}} </td>
                    @else
                    <td style="text-align: center;font-family: 'Khmer OS Battambang'"">{{@$female}} </td>
                @endif
                <td style="text-align: center;font-family: 'Khmer OS Battambang'">{{\Carbon\Carbon::parse($student_detail->date_of_birth)->format('d')}}-{{MonthKhmer(\Carbon\Carbon::parse($student_detail->date_of_birth)->format('m'))}}-{{\Carbon\Carbon::parse($student_detail->date_of_birth)->format('Y')}}</td>
                @php
                    $markslist = explode(',',@$row->marks_string);
                   $get_subject_id = explode(',',@$row->subjects_id_string);
                   $count=0;
                   $subject_mark=[];
                   $additioncheck=[];
                   // $special_mark=[];
                @endphp

                @if(!empty($markslist))
                    @foreach($markslist as $mark)
                        @php
                            $subject_mark[]= $mark;
                            $total_student_mark = $total_student_mark + $mark;
                        @endphp
                        <td id="rotates" style="text-align: center">  {{!empty($mark)?$mark:0}}

                            @if (App\SmOptionalSubjectAssign::is_optional_subject($row->student_id,$get_subject_id[$count]))
                                <hr>
                                @php
                                    $additioncheck[] = $mark;
                                @endphp
                                 GPA Above {{ $optional_subject_setup->gpa_above }}
                                <small>(@lang('lang.additional_subject'))</small>
                            @endif
                            @php
                                if(App\SmOptionalSubjectAssign::is_optional_subject($row->student_id,$get_subject_id[$count])){

                                    $special_mark[$row->student_id]=$mark;
                                }
                                $count++;

                            @endphp

                        </td>
                    @endforeach
                    <td></td>
                @endif

{{--                <td>{{$total_student_mark}} </td>--}}
{{--                <td>{{!empty($row->average_mark)?$row->average_mark:0}} @php $total_student_mark=0; @endphp </td>--}}


                {{-- END GPA with optional --}}
                <?php /*?>
                                                    <td>
                                                            <?php

                                                            if($row->result == 'F'){
                                                                echo '0.00';
                                                            }else{
                                                               $total_grade_point = 0;
                                                               $c = 0;
                                                                $number_of_subject = count($subject_mark);
                                                                foreach ($subject_mark as $mark) {
                                                                    if ($additioncheck['0'] != $mark) {
                                                                    $grade_gpa = DB::table('sm_marks_grades')->where('percent_from','<=',$mark)->where('percent_upto','>=',$mark)->first();
                                                                    $total_grade_point = $total_grade_point + $grade_gpa->gpa;
                                                                    $c++;
                                                                   }
                                                                }
                                                                if($total_grade_point==0){
                                                                    echo '0.00';
                                                                }else{
                                                                    if($number_of_subject  == 0){
                                                                        echo '0.00';
                                                                    }else{
                                                                        echo number_format((float)$total_grade_point/$c, 2, '.', '');
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <?php */?>
{{--                @if ( $get_optional_subject=='')--}}
{{--                    <td>--}}
{{--                        {{$row->result}}--}}

{{--                    </td>--}}
{{--                @endif--}}

                @if ($optional_subject_setup!='' )


                    @if ( $get_optional_subject!='')


                        @php

                            if(!empty($special_mark[$row->student_id])){
                                        $optional_subject_mark=$special_mark[$row->student_id];
                                    }else{
                                        $optional_subject_mark=0;
                                    }
                        @endphp


                        <td>

                            <?php
                            if ($row->result == 'F') {
                                echo '0.00';
                            } else {
                                $optional_grade_gpa = DB::table('sm_marks_grades')->where('percent_from', '<=', $optional_subject_mark)->where('percent_upto', '>=', $optional_subject_mark)->first();
                                $countable_optional_gpa = 0;
                                if ($optional_grade_gpa->gpa > $optional_subject_setup->gpa_above) {
                                    $countable_optional_gpa = $optional_grade_gpa->gpa - $optional_subject_setup->gpa_above;
                                } else {
                                    $countable_optional_gpa = 0;
                                }

                                // echo "op G".$countable_optional_gpa;
                                // dd($subject_mark);

                                $total_grade_point = 0;
                                $number_of_subject = count($subject_mark) - 1;
                                foreach ($subject_mark as $mark) {

                                    // echo $mark;
                                    $grade_gpa = DB::table('sm_marks_grades')->where('percent_from', '<=', $mark)->where('percent_upto', '>=', $mark)->first();
                                    $total_grade_point = $total_grade_point + $grade_gpa->gpa;
                                }
                                $gpa_with_optional = $total_grade_point - $optional_grade_gpa->gpa;
                                $gpa_with_optional = $gpa_with_optional + $countable_optional_gpa;

                                // echo "Optional GPA".$gpa_with_optional." -Total gpa:".$total_grade_point  ;
                                if ($gpa_with_optional == 0) {
                                    echo '0.00';
                                } else {
                                    if ($number_of_subject == 0) {
                                        echo '0.00';
                                    } else {
                                        $grade = number_format((float)$gpa_with_optional / $number_of_subject, 2, '.', '');
                                        if ($grade > 5) {
                                            echo "5.00";
                                            // echo $grade;
                                        } else {
                                            echo $grade;
                                        }
                                    }
                                }

                            }

                            ?>
                        </td>
                        <td>
                            @php
                                if($row->result == 'F'){
                                        echo 'F';
                                }else {
                                    $optional_grade_gpa = DB::table('sm_marks_grades')->where('from','<=',$grade)->where('up','>=',$grade)->first();
                                     echo @$optional_grade_gpa->grade_name;
                                }
                            @endphp

                        </td>
                    @else
                        <td>
                            <?php

                            if ($row->result == 'F') {
                                echo '0.00';
                            } else {
                                $total_grade_point = 0;
                                $number_of_subject = count($subject_mark);
                                foreach ($subject_mark as $mark) {
                                    $grade_gpa = DB::table('sm_marks_grades')->where('percent_from', '<=', $mark)->where('percent_upto', '>=', $mark)->first();
                                    $total_grade_point = $total_grade_point + $grade_gpa->gpa;
                                }
                                if ($total_grade_point == 0) {
                                    echo '0.00';
                                } else {
                                    if ($number_of_subject == 0) {
                                        echo '0.00';
                                    } else {
                                        echo number_format((float)$total_grade_point / $number_of_subject, 2, '.', '');
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            {{$row->result}}

                        </td>
                    @endif
                @endif
            </tr>


            {{-- START GPA with optional --}}


        @endforeach
        </tbody>
    </table>
{{--    <table style="width:100%">--}}
{{--        <tr>--}}
{{--            <td>--}}
{{--                <p style="padding-top:10px; text-align:right; float:right; border-top:1px solid #ddd; display:inline-block; margin-top:50px;">--}}
{{--                    ( @lang('lang.exam_controller') )</p>--}}
{{--            </td>--}}
{{--        </tr>--}}

{{--    </table>--}}

    <table>
        <div class="footers"></div>
        <div>

            <div style="padding: 5px 10px;font-family: 'Khmer OS Battambang';font-size: 14px">បញ្ឈប់បញ្ជីត្រឹម {{@$totals}}
                នាក់; ស្រី {{@$total_female}}នាក់
            </div>
        </div>

            <div style="float: right">
                <div style="padding: 5px 10px;text-align: center;font-family: 'Khmer OS Battambang'">
                    ថ្ងៃ...............ខែ.............ឆ្នាំជូត ទោស័ក ព.ស ២៥៦៤
                </div>
                <div style="padding: 5px 10px;text-align: center;font-family: 'Khmer OS Battambang'">
                    ស្វាយរៀង,ថ្ងៃទី.........ខែ........ឆ្នាំ២០២០
                </div>
                <div style="padding: 5px 10px;text-align:center;font-family: 'Khmer Moul';font-size: 20px">សាកលវិទ្យាធិការ</div>
            </div>


{{--        @php $marks_grade=DB::table('sm_marks_grades')->where('created_at', 'LIKE', '%' . App\YearCheck::getYear() . '%')->get(); @endphp--}}
{{--        @if(@$marks_grade)--}}
{{--            <table class="table  table-bordered table-striped " id="grade_table" style="width: 388px;">--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <th>@lang('lang.staring')</th>--}}
{{--                    <th>@lang('lang.ending')</th>--}}
{{--                    <th>@lang('lang.gpa')</th>--}}
{{--                    <th>@lang('lang.grade')</th>--}}
{{--                    <th>@lang('lang.evalution')</th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}

{{--                @foreach($marks_grade as $grade_d)--}}
{{--                    <tr>--}}
{{--                        <td>{{$grade_d->percent_from}}</td>--}}
{{--                        <td>{{$grade_d->percent_upto}}</td>--}}
{{--                        <td>{{$grade_d->gpa}}</td>--}}
{{--                        <td>{{$grade_d->grade_name}}</td>--}}
{{--                        <td class="text-left">{{$grade_d->description}}</td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        @endif--}}
    </table>
    <table class="w-100 mt-30 mb-20 table table-bordered marklist" style="width: 25%;">
        <div style="padding: 1px;">
                <tr>
                    <td colspan="6" style="text-align: center;padding: 1px;border: solid 1px;font-family: 'Lucida Calligraphy'">Remarks</td>
                </tr>
                <tr>
                    <td style="text-align: center;padding: 1px;border: solid 1px">Score</td>
                    <td colspan="2" style="text-align: center;padding: 1px;border: solid 1px">Grade</td>
                    <td style="text-align: center;padding: 1px;border: solid 1px">Score</td>
                    <td colspan="2" style="text-align: center;padding: 1px;border: solid 1px">Grade</td>
                </tr>
                <tr>
                    <td style="text-align: center;padding: 1px;border: solid 1px">95%-100%</td>
                    <td style="text-align: center;padding: 1px;border: solid 1px">A<sup>+</sup></td>
                    <td style="text-align: center;padding: 1px;border: solid 1px;font-family: 'Khmer OS Battambang'">ប្រសើរ</td>
                    <td style="text-align: center;padding: 1px;border: solid 1px">66%-74%</td>
                    <td style="text-align: center;padding: 1px;border: solid 1px">C<sup>+</sup></td>
                    <td style="text-align: center;padding: 1px;border: solid 1px;font-family: 'Khmer OS Battambang'">ល្អបង្គួរ</td>
                </tr>
                <tr>
                    <td style="text-align: center;padding: 1px;border: solid 1px">88%-94%</td>
                    <td style="text-align: center;padding: 1px;border: solid 1px">A</td>
                    <td style="text-align: center;padding: 1px;border: solid 1px;font-family: 'Khmer OS Battambang'">ល្អប្រសើរ</td>
                    <td style="text-align: center;padding: 1px;border: solid 1px">56%-65%</td>
                    <td style="text-align: center;padding: 1px;border: solid 1px">C</td>
                    <td style="text-align: center;padding: 1px;border: solid 1px;font-family: 'Khmer OS Battambang'">មធ្យម</td>
                </tr>
                <tr>
                    <td style="text-align: center;padding: 1px;border: solid 1px">80%-87%</td>
                    <td style="text-align: center;padding: 1px;border: solid 1px">B<sup>+</sup></td>
                    <td style="text-align: center;padding: 1px;border: solid 1px;font-family: 'Khmer OS Battambang'">ល្អណាស់</td>
                    <td style="text-align: center;padding: 1px;border: solid 1px">50%-55%</td>
                    <td style="text-align: center;padding: 1px;border: solid 1px">D</td>
                    <td style="text-align: center;padding: 1px;border: solid 1px;font-family: 'Khmer OS Battambang'">ខ្សោយ</td>
                </tr>
                <tr>
                    <td style="text-align: center;padding: 1px;border: solid 1px">75%-79%</td>
                    <td style="text-align: center;padding: 1px;border: solid 1px">B</td>
                    <td style="text-align: center;padding: 1px;border: solid 1px;font-family: 'Khmer OS Battambang'">ល្អ</td>
                    <td style="text-align: center;padding: 1px;border: solid 1px"><50%</td>
                    <td style="text-align: center;padding: 1px;border: solid 1px">F</td>
                    <td style="text-align: center;padding: 1px;border: solid 1px;font-family: 'Khmer OS Battambang'">ធ្លាក់</td>
                </tr>
        </div>
    </table>
    <table>

        <div style="border: solid 1px;width: 273px;font-family: 'Khmer OS System'">
            <div style="">
                <p style="margin: 10px 6px 10px">កំណត់សម្គាល់៖</p>
                <p style="margin: 10px 6px 10px"> Number A ត្រូវប្រឡងសងតាមការកំណត់។</p>
                <p style="margin: 10px 6px 10px"> សញ្ញានេះត្រូវនរៀនសងឡើងវិញ។</p>
            </div>
        </div>
    </table>



</body>
</html>
    
