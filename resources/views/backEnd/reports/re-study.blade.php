@php
    $i = 1;
    $j = 2;
@endphp
<style>
    @page {
        size: A4
    }


    .border th, .border td {
        border: 1px solid black;
        padding: 9px 1px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        /*border: 1px solid black;*/
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

    .table1 {
        padding: 60px;
    }

    @media print {
        #birth {
            padding: 60px
        }

        .border1 {
            text-align: right;
            font-size: 20px;
            font-family: 'Khmer Moul';
            width: 100%;
        }

        table td, th {
            padding: 10px 5px;
        }

        .border2 {
            text-align: left;
            font-size: 20px;
            font-family: 'Khmer Moul';
            margin-left: 10px;
            width: 100%;

        }

        .rotate {
            transform: rotate(90deg);
        }

        .table1 {
            padding: 0px;
        }

    }
</style>
<table>
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
    <table>
        <div class="border3">
            <div>បញ្ជីឈ្មោះនិស្សិតរៀនសង ឆមាសទី១ ឆ្នាំសិក្សា២០១៩-២០២០</div>
            <div>ថ្នាក់បរិញ្ញាបត្រ ជំនាន់ទី១២ ឆ្នាំទី៤</div>
            <div>ជំនាញ គណនេយ្យ សិក្សាពេល សៅរ៍ អាទិត្យ ក្រុម១ ( 12ACT41Sb1 )</div>

        </div>
    </table>
    <div class="table-responsive table1">
        <table class="mt-30 mb-20 table table-striped table-bordered ">
            <thead class="border">
            <tr>
                <?php
                $p = \App\SmTemporaryMeritlist::where('result', 'F')
                    ->first();
                $subjectlists = explode(',', $p->subjects_string);
                $F = 'រៀនសង';
                $gradelists = explode(',', $p->grades_string);
                $arr_grade = [];
//                $arr_grade_ = [];
                if ($gradelists != null) {
                    foreach ($gradelists as $k => $v) {
                        $arr_grade[$k] = $v;
//                        $arr_grade_[$k] = $v;
                    }
                }

                ?>
                <th>ល.រ</th>
                <th>អត្តលេខ</th>
                <th>គោត្តនាម-នាម</th>
                <th>ភេទ</th>
                <th id="birth">ថ្ងៃខែឆ្នាំកំណើត</th>
                @foreach($subjectlists as $k=>$v)
                    @php
                        $result_grade = isset($arr_grade[$k]) ? $arr_grade[$k] : null;
                    @endphp
                    @if($result_grade == "F")
                        <th>{{$v}}</th>
                    @endif
                @endforeach
                <th>ផ្សេងៗ</th>

            </tr>

            </thead>
            <tbody class="border">
            <?php
            //dd($subjectlists);
            ?>
            @foreach($results as $result)
                <?php
                //                 dd($result);

                $stu = \App\SmStudent::find(@$result->student_id);

                $gender = \App\SmBaseSetup::where('id', @$stu->gender_id)->first();
                //                dd($gender);
                ?>
                <tr style="text-align: center">
                    <td style="text-align: center;font-weight: bold">{{$loop->iteration}}</td>
                    <td>{{@$stu->roll_no}}</td>
                    <td>{{@$stu->full_name}}</td>
                    <td>{{@$gender->base_setup_name}}</td>
                    <td>{{@$stu->date_of_birth}}</td>
                    @foreach($gradelists as $grade)

                        @if($grade == 'F')
                            <td style="color: red !important;">{{$F}}</td>
                            {{--                @else--}}
                            {{--                    <th>{{$grade}}</th>--}}
                        @endif
                    @endforeach
                    <td></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <table>
            <div>

                <div style="padding: 5px 10px">បញ្ឈប់បញ្ជីត្រឹម {{@$totals}} នាក់; ស្រី {{@$total_female}}នាក់</div>
            </div>

        </table>
        <br>
        <br>
        <table>
            <div style="float: right">
                <div style="padding: 5px 10px;text-align: center">
                    ថ្ងៃ.............................ខែ.......................ឆ្នាំជូត ទោស័ក ព.ស ២៥៦៤
                </div>
                <div style="padding: 5px 10px;text-align: center">
                    ស្វាយរៀង,ថ្ងៃទី......................ខែ.....................ឆ្នាំ២០២០
                </div>
                <div style="padding: 5px 10px;text-align:center;font-family: 'Khmer Moul'">សាកលវិទ្យាធិការ</div>
            </div>
        </table>

    </div>
</table>
