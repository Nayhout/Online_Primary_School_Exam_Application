<!DOCTYPE html>
<html>
<head>
    <title>Form Register</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        @media print {
            @page {
                size: A4;
                margin: 0;
            }
            #check-side{
                /*border: red solid 2px;*/
                margin-left: -10px!important;
                margin-top: 70px!important;
            }
            .t-title-print{
                border: white solid 0.1px!important;
                margin-top: 22cm!important;
            }
            .b-print{
                font-size: 19px;
            }
            .b-print-1{
                font-size: 18px;
            }
            .b-print-t{
                font-size: 20px;
            }
            .sub-des{
                /*border: solid 1px red;*/
                font-family: 'Kh Baphnom Small Style';
                font-size: 18px!important;
                margin-right: 100px!important;
                font-style: italic !important;
            }
            .font-kmoul{
                font-size: 16px!important;
            }
            .sub-print{
                /*border: solid 1px red;*/
                font-size: 18px!important;
            }
            .ti-en{
                /*border: solid 1px red;*/
                font-size: 18px!important;
            }
            .ti-en-s{
                margin-left: 10px!important;
                font-size: 18px!important;
            }
            .ti-en-s-1{
                margin-left: 5px!important;
                font-size: 16px!important;
            }
            .info-print{
                font-size: 20px;
            }
            .t-line{
                height: 20px !important;
                border: solid black 1px;
                border-top: none;
            }
            .m-print{
                margin-top: 5px!important;
            }
            .set-top-print{
                margin-top: 100px!important;
            }
        }

        body{
            background: lightgray;
        }
        #check-side{
            /*border: solid 1px red;*/
            width: 1200px;
            margin-left: 400px;
            margin-top: 100px;
            margin-bottom: 100px;
            background: white;
        }
        .t-top-l{
            width: 600px;
            height: 60px;
            font-family: "Khmer OS Moul";
        }
        .t-top-r{
            width: 600px;
            text-align: center;
            font-family: "Khmer OS Moul";
        }
        #t-title{
            width: 1060px;
            margin-top: 30px;
        }

        .t-info{
            width: 310px;
            /*border: solid red 1px;*/
        }
        .t-mini{
            width: 120px;
            /*border: solid red 1px;*/
        }
        .t-left{
            margin-left: 50px;
        }
        #title{
            text-align: center;
            font-family: "Khmer OS Moul";
        }
        #photo{
            height: 130px;
            width: 100px;
            border: gray solid 1px;
            float: right;
            margin-right: 50px;
            margin-top: -46px;
            text-align: center;
        }
        #sty-l{
            text-align: center;
        }
        .line{
            /*border: 1px solid grey;*/
            width: 300px;
            height: 30px;
            border: solid grey 2px;
            border-top: none;
        }
        .t-line{
            height: 25px;
            border: solid black 1px;
            border-top: none;
        }
        #t-titles{
            width: 1200px;
        }
        .s-w{
            width: 235px;
        }
        .w-s{
            width: 300px;
        }
        .t-booder{
            margin-top: 30px;
            border: solid black 2px;
        }
        .test{
            margin-top: 15px;
            border: solid red 2px;
        }
        .box-left{
            margin-left: 12px;
        }
        .box-right{
            text-align: right;
            margin-right: 12px;
        }
        .p-top{
            border: black solid 1px;
            margin: -5px!important;
        }
        .un-title{
            border: black solid 1px;
            width: 1100px;
            margin-left: -4px;
        }
        .font-kmoul{
            font-family: "Khmer OS Moul";
            font-size: 13px;
        }
        .b-info{
            margin-right: 140px;
        }
        .bs-info{
            margin-right: 295px!important;
        }
        .font-style{
            font-family: 'Khmer OS System';
        }
        .sub-des{
            font-family: 'Khmer OS System';
            font-style: italic;
            font-size: 12px;
        }
        .b-info-s{
            margin-right: 160px;
        }
        .b-info-b{
            margin-right: 215px;
        }
    </style>
</head>
<body style="font-family: 'Khmer OS System'">
    <div id="check-side">
        <table class="t-left">
            <tr>
                <td class="t-top-l">
                    <div>ក្រសូងអប់រំ យុវជន និងកីឡា</div>
                    <div>សាកលវិទ្យាល័យស្វាយរៀង</div>
                </td>
                <td class="t-top-r">
                    <div>ព្រះរាជាណាចក្រកម្ពុជា</div>
                    <div>ជាតិ សាសនា ព្រះមហាក្សត្រ</div>
                    <div id="sty-l">---###---</div>
                </td>
            </tr>
        </table>
        <div id="title">
            <label >ពាក្យសុំចូលរៀនថ្នាក់ឆ្នាំទី១ នៅសាកលវិទ្យាល័យស្វាយរៀង</label>
        </div>
        <div id="sty-l">---###---</div>
        <div id="photo">Photo</div>
        <div id="t-title">
            <table class="t-left">
                <tr>
                    <th class="t-info font-style b-print">ខ្ញុំបាទ-នាងខ្ញុំឈ្មោះ Name in Khmer</th>
                    <th class="t-info font-style b-print">អក្សរឡាតាំង Name in Latin</th>
                    <th class="t-mini font-style b-print">ភេទ Gender</th>
                    <th class="t-info font-style b-print">ថ្ងៃ ខែ ឆ្នាំកំណើត Date of Birth</td>
                </tr>
                <tr>
                    <?php
                        $gender = \App\SmBaseSetup::find($students->gender_id);
                    ?>
                    <td class="t-line"><name style="margin-left: 100px;">{{@$students->bank_name}}</name></td>
                    <td class="t-line"><name style="margin-left: 100px;">{{@$students->first_name}} &nbsp;&nbsp; {{@$students->last_name}}</name></td>
                        <td class="t-line"><name style="margin-left: 50px;">{{@$gender->base_setup_name}}</name></td>
                    <td class="t-line"><name style="margin-left: 100px;">{{@$students->date_of_birth}}</name></td>

                </tr>
            </table>
        </div>
        <div id="t-titles">
            <table class="t-left" width="92%">
                <tr>
                    <th class="t-infos font-style  b-print">លេខអត្តសញ្ញាណប័ណ្ណ ID Nº</th>
                    <th class="t-infos font-style  b-print">ជាអតីតសិស្សនៅ Name of high school</th>
                    <th class="t-infos font-style  b-print">ឆ្នាំបញ្ចប់ Year of completion</th>
                    <th class="t-infos font-style  b-print-1">លេខវិញ្ញាបនបត្រមធ្យម.ទុត.Certifi.Nº</th>
                </tr>
                <tr>
                    <td class="t-line s-w"><name style="margin-left: 60px;">{{@$students->national_id_no}}</name></td>
                    <td class="t-line w-s"><name style="margin-left: 100px;">{{@$students->from_school}}</name></td>
                    <td class="t-line s-w"><name style="margin-left: 100px;">{{@$students->degree_year}}</name></td>
                    <td class="t-line w-s" ><name style="margin-left: 100px;">{{@$students->degree_no}}</name></td>
                </tr>
            </table>
        </div>
        <div id="t-titles">
            <table class="t-left t-booder m-print" width="92%">
                <tr>
                    <td colspan="5" class="b-print-t">
                        <span class="box-left font-style">ជ្រើសរើសការសិក្សា</span> <span>Interested in studying</span> <span>ថ្នាក់បរិញ្ញបត្រ(Bachelor Degree)</span><span><input type="checkbox"></span><span>ថ្នាក់បរិញ្ញបត្ររង(Associate degree)</span><span><input type="checkbox"></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <hr class="un-title">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span class="box-left font-kmoul">មហាវិទ្យាល័យកសិកម្ម</span><span class="ti-en"> Faculty of Agriculture </span><span class="ti-en-s" style="margin-left: 90px;">មុខជំនាញ</span>
                    </td>
                    <td></td>
                    <td colspan="2">
                        <span class="box-left font-kmoul">មហាវិទ្យាល័យសង្គមសាស្រ្ត</span><span class="ti-en"> Faculty of Social Sciences </span><span class="ti-en-s-1" style="margin-left: 30px;">មុខជំនាញ</span>
                    </td>
                </tr>
                <tr>
                    <td width="20%">
                        <div class="box-left sub-print font-style" >- ក្សេត្រសាស្រ្ត</div>
                        <div class="box-left sub-print font-style" >- អភិវឌ្ឍន៍ជនបទ</div>
                        <div class="box-left sub-print font-style">- វិទ្យាសាស្រ្ដ នឹងវេជ្ជសាស្រ្ដសត្វ</div>
                    </td>
                    <td width="20%">
                        <div class="box-right sub-print">
                            <span>Agronomy</span> <span><input type="checkbox"></span>
                        </div>
                        <div class="box-right sub-print">
                            <span>Rural Development</span> <span><input type="checkbox"></span>
                        </div>
                        <div class="box-right sub-print>
                            <span>Animal Science and Veterinary</span> <span><input type="checkbox"></span>
                        </div>
                    </td>
                    <td width="5%"></td>
                    <td width="20%">
                        <div class="box-left sub-print">
                            <span>- រដ្ឋបាលសាធារណៈ</span>
                        </div>
                        <div class="box-left"></div>
                        <div class="box-left"></div>
                    </td>
                    <td width="20%">
                        <div class="box-right sub-print">
                            <span>Public Administrator</span><span>&nbsp;<input type="checkbox"></span>
                        </div>
                        <div class="box-right"></div>
                        <div class="box-right"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span class="box-left font-kmoul">មហាវិទ្យាល័យគ្រប់គ្រងពាណិជ្ជកម្ម</span><span class="ti-en"> Faculty of Business</span><br><span style="margin-left: 12px;" class="ti-en">Administration មុខជំនាញ</span>
                    </td>
                    <td></td>
                    <td colspan="2">
                        <span class="box-left font-kmoul">មហាវិទ្យាល័យសិល្បៈ មនុស្សសាស្រ្ត និងភាសាបរទេស</span><span class="ti-en"> Faculty of Arts,</span><span class="ti-en" style="margin-left: 12px;">Humanities and Foreign Language មុខជំនាញ</span>
                    </td>
                </tr>
                <tr>
                    <td width="20%">
                        <div class="box-left sub-print">- គ្រប់គ្រង​(បរិ./បរិ.រង)</div>
                        <div class="box-left sub-print" >- គណនេយ្យ(បរិ./បរិ.រង)</div>
                        <div class="box-left sub-print" >- ទីផ្សារ</div>
                        <div class="box-left sub-print" >- ហិរញ្ញវត្ឋុ និងធនាគារ</div>
                    </td>
                    <td width="20%">
                        <div class="box-right sub-print">
                            <span>Management</span> <span><input type="checkbox"></span>
                        </div>
                        <div class="box-right sub-print">
                            <span>Accounting </span> <span><input type="checkbox"></span>
                        </div>
                        <div class="box-right sub-print">
                            <span>Marketing</span> <span><input type="checkbox"></span>
                        </div>
                        <div class="box-right sub-print">
                            <span>Finance and Banking</span> <span><input type="checkbox"></span>
                        </div>
                    </td>
                    <td width="5%"></td>
                    <td width="20%">
                        <div class="box-left sub-print">
                            <span>- ភាសាអង់គ្លេស​ (បរិ./បរិ.រង)</span>
                        </div>
                        <div class="box-left sub-print">​
                            <span>- បកប្រែភាសាអង់គ្លេស</span>
                        </div>
                        <div class="box-left sub-print"></div>
                    </td>
                    <td width="20%">
                        <div class="box-right sub-print">
                            <span>English Literature </span><span><input type="checkbox"></span>
                        </div>
                        <div class="box-right sub-print">
                            <span>Translation and Interpretation </span><span><input type="checkbox"></span>
                        </div>
                        <div class="box-right sub-print">

                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span class="box-left font-kmoul">មហាវិទ្យាល័យវិទ្យាសាស្រ្ត និងបច្ចេកវិទ្យា</span><span class="ti-en"> Faculty of Science</span><br><span class="ti-en" style="margin-left: 12px;">and Technology មុខជំនាញ</span>
                    </td>
                    <td></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td width="20%">
                        <div class="box-left sub-print">- គណិតវិទ្យា</div>
                        <div class="box-left sub-print">- វិទ្យាសាស្រ្តកុំព្យូទ័រ</div>
                    </td>
                    <td width="20%">
                        <div class="box-right sub-print">
                            <span>Mathematics</span> <span><input type="checkbox"></span>
                        </div>
                        <div class="box-right sub-print">
                            <span>Computer Science </span> <span><input type="checkbox"></span>
                        </div>
                    </td>
                    <td width="5%"></td>
                    <td width="20%">
                        <div class="box-left"></div>
                        <div class="box-left">​</div>
                        <div class="box-left"></div>
                    </td>
                    <td width="20%">
                        <div class="box-right"></div>
                        <div class="box-right"></div>
                        <div class="box-right">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <hr class="un-title">
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="b-print-t">
                        <span class="box-left">ម៉ោងសិក្សា</span>
                        <span>Study Session</span>
                        <span>ព្រឹក(7:00-11:30)</span>
                        <span><input type="checkbox"></span>
                        <span>រសៀល(13:00-17:30)</span>
                        <span><input type="checkbox"></span>
                        <span>យប់(17:00-21:30)</span>
                        <span><input type="checkbox"></span>
                        <span>សៅរិ៍-អាទិត្យ(Sat&Sun)</span>
                        <span><input type="checkbox"></span>
                    </td>
                </tr>
            </table>
        </div>
        <div id="t-titles">
            <table class="t-left t-booder m-print" width="92%">
                <tr>
                    <td width="12px;"></td>
                    <td class="info-print">ទីកន្លែងកណើត Date of birth </td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <?php
                        $province = \App\SmProvinces::find($students->city);
                    ?>
                    <td class="t-line" colspan="3"><name style="margin-left: 50px;">ផ្ទះលេខ : {{@$students->house_birth}} &nbsp;&nbsp; ផ្លូវលេខ : {{$students->group_birth}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ភូមិ : {{@$students->village_birth}}  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ឃុំ-សង្កាត់ : {{@$students->commune_birth?@$students->district_birth:''}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;រាជធានី-ខេត្ត : {{@$province->name_kh}}</name></td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td colspan="3">
                       <span class="b-info-s sub-des">ផ្ទះលេខ ផ្លូវលេខ</span>
                        <span class="b-info-s sub-des">ភូមិ</span>
                        <span class="b-info-s sub-des">ឃុំ-សង្កាត់</span>
                        <span class="b-info-s sub-des">ខណ្អ-ក្រុង-ស្រុក</span>
                        <span class="sub-des">រាជធានី-ខេត្ត</span>
                    </td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td class="info-print">អាសយដ្ឋានអចិន្រ្តៃយ៍ Permanent Home Address</td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <?php
                    $permanents = \App\SmStudentsPermanent::find($students->student_permanent_id);
                    $province = \App\SmProvinces::find($students->province_permanent);
                    ?>
                    <td width="12px;"></td>
                    <td class="t-line" colspan="3"><name style="margin-left: 50px;">ផ្ទះលេខ : {{@$students->house_permanent}} &nbsp;&nbsp; ផ្លូវលេខ : {{$students->street_permanent}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ភូមិ : {{@$students->village_permanent}}  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ឃុំ-សង្កាត់ : {{@$students->commune_permanent?@$students->district_permanent:''}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;រាជធានី-ខេត្ត : {{@$province->name_kh}}</name></td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td colspan="3">
                        <span class="b-info-s sub-des">ផ្ទះលេខ ផ្លូវលេខ</span>
                        <span class="b-info-s sub-des">ភូមិ</span>
                        <span class="b-info-s sub-des">ឃុំ-សង្កាត់</span>
                        <span class="b-info-s sub-des">ខណ្អ-ក្រុង-ស្រុក</span>
                        <span class=" sub-des">រាជធានី-ខេត្ត</span>
                    </td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td class="info-print">អាសយដ្ឋានបច្ចុប្បន្ន Current Address </td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <?php
                    $province = \App\SmProvinces::find($students->province_student);
                    ?>
                    <td width="12px;"></td>
                    <td class="t-line" colspan="3"><name style="margin-left: 50px;">ផ្ទះលេខ : {{@$students->house_student}} &nbsp;&nbsp; ផ្លូវលេខ : {{$students->group_student}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ភូមិ : {{@$students->village_student}}  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ឃុំ-សង្កាត់ : {{@$students->commune_student?@$students->district_student:''}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;រាជធានី-ខេត្ត : {{@$province->name_kh}}</name></td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td colspan="3">
                        <span class="b-info-s sub-des" >ផ្ទះលេខ ផ្លូវលេខ</span>
                        <span class="b-info-s sub-des">ភូមិ</span>
                        <span class="b-info-s sub-des">ឃុំ-សង្កាត់</span>
                        <span class="b-info-s sub-des">ខណ្អ-ក្រុង-ស្រុក</span>
                        <span class="sub-des">រាជធានី-ខេត្ត</span>
                    </td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td style="width: 30%!important;">លេខទូរស័ព្ទ Telephone Number</td>
                    <td style="width: 30%!important;">ឈ្មោះគណនីហ្វេសប៊ុក Facebook account name</td>
                    <td style="width: 30%!important;">អ៊ីម៉េល Email</td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td class="t-line " style="width: 50px!important;text-align: center"> {{@$students->mobile}}</td>
                    <td class="t-line " style="width: 165px!important;text-align: center">{{@$students->facebook_student}}</td>
                    <td class="t-line " style="width: 165px!important;"><name style="margin-left: 50px;">{{@$students->email}}</name></td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td class="info-print">មុខរបរសព្វថ្ងៃ Current Occupation </td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <?php
                    $parent = \App\SmParent::find($students->parent_id);
                    ?>
                    <td width="12px;"></td>
                    <td class="t-line" colspan="3">មុខងារ : {{@$students->current_occupation_student}} &nbsp;&nbsp;&nbsp;អង្គភាព : {{@$students->company}} &nbsp;&nbsp;&nbsp;&nbsp;ទីតាំង : {{@$parent->location}}</td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td colspan="3">
                        <span class="bs-info sub-des">មុខងារ</span>
                        <span class="bs-info sub-des">អង្គភាព</span>
                        <span class="sub-des">ទីតាំង</span>
                    </td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td >អំពីឪពុក Father </td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td class="t-line" colspan="3">ឈ្មោះ : {{@$parent->fathers_name}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ឆ្នាំកំណើត : {{@$parent->date_of_birth_father}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; មុខរបរ : {{@$parent->fathers_occupation}}</td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td colspan="3">
                        <span class="bs-info sub-des">ឈ្មោះ</span>
                        <span class="bs-info sub-des">ឆ្នាំកំណើត</span>
                        <span class="sub-des">មុខរបរ</span>
                    </td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td class="info-print">អំពីម្ដាយ Mother </td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td class="t-line" colspan="3">ឈ្មោះ : {{@$parent->mothers_name}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ឆ្នាំកំណើត : {{@$parent->date_of_birth_mother}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  មុខរបរ : {{@$parent->mothers_occupation}}</td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td colspan="3">
                        <span class="bs-info sub-des">ឈ្មោះ</span>
                        <span class="bs-info sub-des">ឆ្នាំកំណើត</span>
                        <span class="sub-des">មុខរបរ</span>
                    </td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td width="330px;" colspan="5" class="info-print">អាណាព្យាបាល(ប្រសិនបើមិនមែនជាឪពុកម្ដាយ) Guardian (If different from parent)</td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td class="t-line" colspan="3">ឈ្មោះ : {{@$parent->guardians_name}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ឆ្នាំកំណើត : {{@$parent->date_of_birth_guardian}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  មុខរបរ : {{@$parent->guardians_occupation}}</td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td colspan="3">
                        <span class="bs-info sub-des">ឈ្មោះ</span>
                        <span class="bs-info sub-des">ឆ្នាំកំណើត</span>
                        <span class="sub-des">ត្រូវជា</span>
                    </td>
                    <td width="12px;"></td>
                </tr>
            </table>
        </div>

        <div id="t-titles" class="t-title-print">
            <table class="t-left t-booder m-print set-top-print" width="92%">
                <tr>
                    <td width="12px;"></td>
                    <td width="330px;" colspan="5" class="info-print">អាសយដ្ឋាន Address</td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td class="t-line" colspan="3">{{@$parent->guardians_address}}</td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td colspan="3">
                        <span class="b-info-s sub-des" >ផ្ទះលេខ ផ្លូវលេខ</span>
                        <span class="b-info-s sub-des ">ភូមិ</span>
                        <span class="b-info-s sub-des">ឃុំ-សង្កាត់</span>
                        <span class="b-info-s sub-des">ខណ្អ-ក្រុង-ស្រុក</span>
                        <span class=" sub-des">រាជធានី-ខេត្ត</span>
                    </td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td style="width: 50px!important;">លេខទូរស័ព្ទ Telephone Number</td>
                    <td style="width: 160px!important;">ឈ្មោះគណនីហ្វេសប៊ុក Facebook account number</td>
                    <td style="width: 165px!important;">អ៊ីម៉េល Email</td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td class="t-line " style="width: 50px!important;text-align: center">{{@$parent->guardians_mobile}}</td>
                    <td class="t-line " style="width: 165px!important;text-align: center">{{@$parent->facebook_guardian}}</td>
                    <td class="t-line " style="width: 165px!important;text-align: center">{{@$parent->guardians_email}}</td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td width="330px;" colspan="5" class="info-print">ព័ត៍មានសម្រាប់ទំនាក់ទំនងក្នុងករណីបន្ទាន់កើតឡើង Emergency Contact Information</td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <?php
                        $emergency = \App\SmEmergency::find($students->emergency_contact_id);
                    ?>
                    <td width="12px;"></td>
                    <td class="t-line" colspan="3">&nbsp;&nbsp;&nbsp;&nbsp; ឈ្មោះ : {{@$emergency->name}}  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;មុខរបរ : {{@$emergency->occupation}}  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;លេខទូរស័ព្ទ : {{@$emergency->mobile}}</td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td colspan="3">
                        <span class="bs-info sub-des">ឈ្មោះ</span>
                        <span class="bs-info sub-des">មុខរបរ</span>
                        <span class="sub-des">លេខទូរស័ព្ទ</span>
                    </td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td colspan="5" class="info-print"><span>សមាជិកគ្រូសារដែលបាន ឬកំពុងសិក្សានៅស.ស.រ. &nbsp;&nbsp;Family member graduated or studying at SRU មាន <input type="checkbox"> គ្មាន<input type="checkbox"></span></td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <?php
                    $family = \App\SmStudentsFamily::find($students->student_family_id);
                    ?>
                    <td width="12px;"></td>
                    <td class="t-line" colspan="3">ឈ្មោះ : {{@$family->family1}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ជំនាញ : {{@$family->major1}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ឆ្នាំសិក្សា : {{@$family->academic1}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ត្រូវជា : {{@$family->as1}}</td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td colspan="3">
                        <span class="b-info-b sub-des">ឈ្មោះ</span>
                        <span class="b-info-b sub-des">ជំនាញ</span>
                        <span class="b-info-b sub-des">ឆ្នាំសិក្សា</span>
                        <span class=" sub-des">ត្រូវជា</span>
                    </td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                        <td class="t-line" colspan="3">ឈ្មោះ : {{@$family->family2}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ជំនាញ : {{@$family->major2}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ឆ្នាំសិក្សា : {{@$family->academic2}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ត្រូវជា : {{@$family->as2}}</td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td colspan="3">
                        <span class="b-info-b sub-des">ឈ្មោះ</span>
                        <span class="b-info-b sub-des">ជំនាញ</span>
                        <span class="b-info-b sub-des">ឆ្នាំសិក្សា</span>
                        <span class="b-info-b sub-des">ត្រូវជា</span>
                    </td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td class="t-line" colspan="3">ឈ្មោះ : {{@$family->family3}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ជំនាញ : {{@$family->major3}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ឆ្នាំសិក្សា : {{@$family->academic3}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ត្រូវជា : {{@$family->as3}}</td>
                    <td width="12px;"></td>
                </tr>
                <tr>
                    <td width="12px;"></td>
                    <td colspan="3">
                        <span class="b-info-b sub-des">ឈ្មោះ</span>
                        <span class="b-info-b sub-des">ជំនាញ</span>
                        <span class="b-info-b sub-des">ឆ្នាំសិក្សា</span>
                        <span class="b-info-b sub-des">ត្រូវជា</span>
                    </td>
                    <td width="12px;"></td>
                </tr>
            </table>
        </div>

        <div id="t-titles">
            <table class="t-left " width="92%">
                <tr>
                    <td width="12px;"></td>
                    <td >
                        <div><b>សូមភ្ជាប់មកជាមួយនូវ Enclosure</b></div>
                        <div style="margin-left: 20px; margin-top: 10px;" class="font-style">១.សញ្ញាបត្រមធ្យមសិក្សាទុតិយភូមិ ឬសញ្ញាបត្រមានតម្លៃស្មើរ Certificate of Upper Secondary School or equivalent</div>
                        <div style="margin-left: 20px; margin-top: 10px;" class="font-style">២.រូបថតទើបថតក្នុងអំឡុង១ឆ្នាំកន្លងទៅ ៤ x ៦ Recent photograph 4X6 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 02 សន្លឹក</div>
                        <div style="margin-left: 20px; margin-top: 10px;" class="font-style">ខ្ញុំបាទ-នាងខ្ញុំ សូមសន្សាថា នឹងគោរពតាមបទបញ្ជាផ្ទៃក្នុងនិងបទបញ្ញត្តិរបស់សាកលវិទ្យាល័យអោយបានត្រឹមត្រូវ។ បើមានការប្រព្រឹត្តខុស</div>
                        <div class="font-style" style="margin-top: 10px;">ប្រការណាមួយ ខ្ញុំបាទ-នាងខ្ញុំ សូមទទូលខុសត្រូវចំពោះក្រុមប្រឹក្សាវិន័យរបស់គ្រឹះស្ថាន។</div>
                    </td>
                    <td width="12px;"></td>
                </tr>
            </table>
        </div>
        <div id="t-titles">
            <table class="t-left" width="92%">
                <tr>
                    <td style="height: 300px; width: 40%; background: lightgray;" class="t-booder">
                        <div style="font-family: 'Khmer OS Moul'; font-size: 14px; text-align: center; margin-top: -130px;">សម្រាប់បុគ្គលិកស.ស.រ. For office use only</div>
                        <div style=" text-align: center; margin-top: 10px;">ការពិនិត្យពាក្យសុំ_________________________ Free F S P</div>
                        <div style=" text-align: center;margin-top: 10px;">លេខរៀង_____________________ID:__________________ </div>
                        <div style=" text-align: center;margin-top: 10px;">ស្វាយរៀង ថ្ងៃទី_________ខែ___________ឆ្នាំ២០_____</div>
                        <div style=" text-align: center;margin-top: 10px;">ហត្ថលេខា និង ឈ្មោះអ្នកទទូល</div>

                    </td>
                    <td width="10%"></td>
                    <td style="height: 300px; width: 40%;">
                        <div style=" text-align: center; margin-top: -130px; font-family: 'Kh Baphnom Small Style'; font-weight: bold;">ធ្វើនៅ______________,ថ្ងៃទី_________ខែ__________ឆ្នាំ២០________</div>
                        <div style=" text-align: center; margin-top: 10px; font-family: 'Kh Baphnom Small Style'; font-weight: bold;">ហត្ថលេខា និង ឈ្នោះសាម៉ីខ្លូន</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>