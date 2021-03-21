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
        font-size: 10px;
        font-family: 'Poppins', sans-serif;

    }

    .marklist th, .marklist td {
        border: 1px solid #ddd;
        text-align: center !important;
        font-family: 'Poppins', sans-serif;

    }

    .marklist th {
        text-transform: capitalize;
        text-align: center;
    }

    .marklist td {
        border: solid 1px;
        text-align: center;
    }

    .border1 {
        text-align: right;
        font-size: 20px;
        font-family: 'Khmer Moul';
        width: 90%;
    }

    .border2 {
        text-align: left;
        font-size: 20px;
        font-family: 'Khmer Moul';
        margin-left: 71px;
    }

    .border3 {
        text-align: center;
        font-family: 'Khmer Moul';
        font-weight: bold;
        font-size: 18px
    }


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
    $degree = \App\SmDegree::find($student->degree_id);
    $major = \App\SmMajor::find($student->major_id);
    $generation = \App\SmGeneration::find($student->generation_id);

    //dd($InputType);
    $re_exam = "ប្រឡងសង";
    if ($InputType != "Re-exam"){
   $re_exam = "រៀនសង";
    }
@endphp
<div class="container">
    <table>
        <div>
            <div class="border1">ព្រះរាជាណាចក្រកម្ពុជា</div>
            <td>
                <div class="border2" style="margin-top: -80px;">ក្រសួងអប់រំយុវជន និងកីឡា</div>
            </td>
            <div class="border1">ជាតិ សាសនា ព្រះមហាក្សត្រ</div>
            <div class="border2" style="margin-top: -40px;">សាកលវិទ្យាល័យស្វាយរៀង</div>
        </div>
    </table>
    <br>
    <br>
    <br>
    <table>
        <div class="border3">
            <div>បញ្ជីឈ្មោះនិស្សិត{{@$re_exam}} ឆមាសទី១ ឆ្នាំសិក្សា {{$generalSetting->session_year}}-{{$generalSetting->session_year+1}}</div>
            <div>ថ្នាក់{{@$degree->degree_name_kh}} {{@$generation->generation_name_kh}} ឆ្នាំទី១</div>
            <div>ជំនាញ {{@$major->major_name_kh}} សិក្សាពេល {{@$section->section_name}} {{@$class_name}}</div>

        </div>
    </table>
    <?php
    $p = \App\SmTemporaryMeritlist::where('result', 'F')
        ->first();
    $r = '';
    $subjectlists = explode(',', optional($p)->subjects_string);
    $F = 'រៀនសង';

    $gradelists = explode(',', optional($p)->grades_string);
    $arr_grade = [];
    //                $arr_grade_ = [];
    if ($gradelists != null) {
        foreach ($gradelists as $k => $v) {
            $arr_grade[$k] = $v;
//                        $arr_grade_[$k] = $v;
        }
    }


    ?>
    <h4 style=" text-align: center;  padding: 10px;"></h4>


    <table class="w-100 mt-30 mb-20 table marklist" style="width: 100%; border: solid 1px">
        <thead>
        <tr>
            <th style="border: solid 1px;font-family: 'Khmer OS Battambang'">@lang('ល.រ')</th>
            <th style="border: solid 1px;font-family: 'Khmer OS Battambang'">@lang('អត្តលេខ')</th>
            <th style="border: solid 1px;font-family: 'Khmer OS Battambang'">@lang('គោត្តនាម-នាម')</th>
            <th style="border: solid 1px;font-family: 'Khmer OS Battambang'">@lang('ភេទ')</th>
            <th style="border: solid 1px;font-family: 'Khmer OS Battambang'">@lang('ថ្ងៃខែឆ្នាំកំណើត')</th>
{{--            <th style="border: solid 1px">@lang('lang.student')</th>--}}
{{--            @foreach($subjectlists as $k=>$v)--}}
{{--                @php--}}
{{--                    $result_grade = isset($arr_grade[$k]) ? $arr_grade[$k] : null;--}}
{{--                @endphp--}}
{{--                @if($result_grade == "F")--}}
{{--                    <th style="border: solid 1px">{{$v}}</th>--}}
{{--                @endif--}}
{{--            @endforeach--}}
            @foreach($subjectlists as $subject)
                <th style="border: solid 1px;font-family: 'Khmer OS Battambang'">{{$subject}}</th>
                @endforeach

            <th style=" border: solid 1px;font-family: 'Khmer OS Battambang'">@lang('lang.total_mark')</th>
            <th style="border: solid 1px;font-family: 'Khmer OS Battambang'">@lang('lang.average')</th>


            @if ($optional_subject_setup!='')
                <th style="border: solid 1px;font-family: 'Khmer OS Battambang'">@lang('lang.gpa')
                    <hr>
                    <small>@lang('lang.without_additional')</small>

                </th>
                {{-- <th>@lang('lang.result')</th> --}}
{{--                <th style="border: solid 1px">@lang('lang.gpa')</th>--}}
                <th style="border: solid 1px;font-family: 'Khmer OS Battambang'">@lang('lang.result')</th>
            @else
{{--                <th style="border: solid 1px">@lang('lang.gpa')</th>--}}
                <th style="border: solid 1px;font-family: 'Khmer OS Battambang'">@lang('lang.result')</th>
            @endif
        </tr>
        </thead>

        <tbody>
        @php $i=1; $subject_mark = []; $total_student_mark = 0; $total_student_mark_optional = 0;

        @endphp

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
                <td id="no">{{$loop->iteration}}</td>
{{--                <td>{{$row->merit_order}}</td>--}}
                <td>{{$student_detail->roll_no}}</td>
                <td style="text-align:left !important;" nowrap>{{$row->student_name}}</td>
                @if($gender->base_setup_name == 'Male')
                    <td style="text-align:center !important;font-family: 'Khmer OS Battambang'" nowrap>{{$male}}</td>
                @else
                    <td style="text-align:center !important;;font-family: 'Khmer OS Battambang'" nowrap>{{$female}}</td>

                @endif
                <td style="text-align:center !important;font-family: 'Khmer OS Battambang'" nowrap>{{\Carbon\Carbon::parse($student_detail->date_of_birth)->format('d')}}-{{MonthKhmer(\Carbon\Carbon::parse($student_detail->date_of_birth)->format('m'))}}-{{\Carbon\Carbon::parse($student_detail->date_of_birth)->format('Y')}}</td>

                @php
                    $markslist = explode(',',$row->marks_string);
                   $get_subject_id = explode(',',$row->subjects_id_string);
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
                    @if($mark < 35)
                        <td style="background: #ff615d !important;border-color: #000000">
                            {{!empty($mark)?$mark:0}}

                            @if (App\SmOptionalSubjectAssign::is_optional_subject($row->student_id,$get_subject_id[$count]))
                                <hr>
                                @php
                                    $additioncheck[] = $mark;
                                @endphp
                                {{-- GPA Above {{ $optional_subject_setup->gpa_above }} --}}
                                <small>(@lang('lang.additional_subject'))</small>
                            @endif
                            @php
                                if(App\SmOptionalSubjectAssign::is_optional_subject($row->student_id,$get_subject_id[$count])){

                                    $special_mark[$row->student_id]=$mark;
                                }
                                $count++;

                            @endphp


                        </td>
                        @else
                            <td>
                                {{!empty($mark)?$mark:0}}

                                @if (App\SmOptionalSubjectAssign::is_optional_subject($row->student_id,$get_subject_id[$count]))
                                    <hr>
                                    @php
                                        $additioncheck[] = $mark;
                                    @endphp
                                    {{-- GPA Above {{ $optional_subject_setup->gpa_above }} --}}
                                    <small>(@lang('lang.additional_subject'))</small>
                                @endif
                                @php
                                    if(App\SmOptionalSubjectAssign::is_optional_subject($row->student_id,$get_subject_id[$count])){

                                        $special_mark[$row->student_id]=$mark;
                                    }
                                    $count++;

                                @endphp


                            </td>
                        @endif
                    @endforeach

                @endif


                <td>{{$total_student_mark}} </td>
                <td>{{!empty($row->average_mark)?$row->average_mark:0}} @php $total_student_mark=0; @endphp </td>


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
                @if ( $get_optional_subject=='')
                    <td>
                        {{$row->result}}

                    </td>
                @endif

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
    <table>
        <div>

            <div style="padding: 5px 10px;font-family: 'Khmer OS Battambang';font-size: 14px">បញ្ឈប់បញ្ជីត្រឹម {{@$totals}}
                នាក់; ស្រី {{@$total_female}}នាក់
            </div>
        </div>

    </table>
    <br>
    <br>
    <table>
        <div style="float: right;font-size: 15px">
            <div style="padding: 5px 10px;text-align: center;font-family: 'Khmer OS Battambang'">
                ថ្ងៃ..................ខែ.............ឆ្នាំជូត ទោស័ក ព.ស ២៥៦៤
            </div>
            <div style="padding: 5px 10px;text-align: center;font-family: 'Khmer OS Battambang'">
                ស្វាយរៀង,ថ្ងៃទី...........ខែ...........ឆ្នាំ២០២០
            </div>
            <div style="padding: 5px 10px;text-align:center;font-family: 'Khmer Moul'">សាកលវិទ្យាធិការ</div>
        </div>
    </table>
</body>
</html>
    
