<style>
    @page { size: A4 }
        .p{
            margin-top: 30px;
        }
        .p1{
            margin-top: 60px;
        }
        #pho_pos{
            border: solid black 1px;
            height: 200px;
            width: 150px;
            text-align: center;
            margin-bottom: 20px;
            margin-left: 700px;


        }
        #body{
            width:1000px;
            margin:0 auto;
            background:#fff !important;
        }
        .display{
            width: 85%;
            margin: auto;
            padding-top: 60px;
        }
        .A4 {
            background: white;
            width: 315mm;
            height: 450mm;
            display: block;
            margin: 0 auto;
            padding: 50px 200px;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
        }
        .border1{
            text-align: center;
            font-size: 35px;
            margin-right: 1000px;
            font-family: 'Khmer Moul';
            width: 60%;
        }
        .font1{
            font-size: 22px;
            margin-left: -120px;
            font-family: "Khmer OS Battambang";
        }

    @media print {
        input{
            border: hidden;
        }
        .A4 {
            background: white;
            width: 250mm;
            height: 296mm;
            margin: 0 auto;
            padding: 10px 100px;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0cm rgba(0,0,0,0);

        }
        #pho_pos {
            border: solid black 1px;
            height: 160px;
            width: 120px;
            text-align: center;
            margin-bottom: 20px;
            margin-left: 900px;
            /*background: blue;*/
        }
        #content_print{
            /*background-color: red !important;*/
            margin-left:-100px!important;
        }
        .border1{
            text-align: center;
            font-size: 35px;
            margin-right: 1000px;
            font-family: 'Khmer Moul';
            width: 80%;
        }
        .font1{
            font-size: 22px;
            margin-left: 10px;
            font-family: "Khmer OS Battambang";
        }
        .p{
            margin-top: 10px;
        }


    }

</style>
<?php
    $gender = \App\SmBaseSetup::find($students->gender_id);
    $places = \App\SmProvinces::find($students->city);
    $province = \App\SmProvinces::find($students->province_student);
    $faculty = \App\SmFaculty::find($students->faculty_id);
    $major = \App\SmMajor::find($students->major_id);
//    dd($major);
    $session = \App\SmAcademicYear::find($students->session_id);
    $string = str_replace('មហាវិទ្យាល័យ','',$faculty->name_kh);
    $generation = \App\SmGeneration::find($students->generation_id);
    $degree = \App\SmDegree::find($students->degree_id);
    $student_year = \App\SmStudentYear::find($students->student_year_id);
?>


<table style="border: 1px">
    <td>

    </td>
    <table class="A4" id="content_print">
    <td >
        <div id="pho_pos">៤x៦</div>
        <br>
                <div class="border1" >លិខិតបញ្ជាក់ការសិក្សា</div>
                <div class="border1">សកលវិទ្យាធិការ នៃសកលវិទ្យាល័យស្វាយរៀង</div>
                <div class="p border1">បញ្ជាក់ថា</div>
        <br><br>
                <div class="p font1" >និស្សិតឈ្មោះ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input style="font-family: 'Khmer Moul';font-size: 30px;width: 220px" value="{{@$students->bank_name}}"> </input>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ជាអក្សរឡាតាំង&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                            type="text" value="{{@$students->full_name}}" style=" font-size: 25px;width: 300px;font-family: 'Khmer Moul'"></div>
                <div class="p font1" >ភេទ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{@$gender->base_setup_name}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;សញ្ជាតិ
                    <input type="text" style="width: 50px;font-family: 'Khmer OS Battambang' ; font-size: 25px " value="{{@$students->nationality}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; អត្តលេខ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{@$students->roll_no}}</div>
                <div class="p font1">ថ្ងៃខែឆ្នាំកំណើត&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{@$students->date_of_birth}}</div>
                <div class="p font1" >ទីកន្លែងកំណើត&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ស្រុក/ក្រុង&nbsp;&nbsp;&nbsp;<input
                            type="text" value="{{@$students->district_birth}}" style="font-family: 'Khmer OS Battambang' ; font-size: 25px;width: 220px">&nbsp;&nbsp;&nbsp;ខេត្ត/រាជធានី&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                            type="text" value="{{@$places->name_kh}}" style="font-family: 'Khmer OS Battambang' ; font-size: 25px ; width: 200px"></div>
                <div class="p font1" >អាសយដ្ឋានបច្ចុប្បន្ន&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ស្រុក/ក្រុង&nbsp;&nbsp;&nbsp;<input
                            type="text" value="{{@$students->district_student}}" style="font-family: 'Khmer OS Battambang' ; font-size: 25px;width: 220px">&nbsp;&nbsp;&nbsp;ខេត្ត/រាជធានី&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                            type="text" value="{{@$province->name_kh}}" style="font-family: 'Khmer OS Battambang' ; font-size: 25px ; width: 200px"></div>
                <div class="p font1" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ជានិសិ្សតកំពុងសិក្សានៅមហាវិទ្យាល័យ <space style="font-family: 'Khmer Moul';font-size: 23px">{{@$faculty->faculty_name_kh}}</space> ជំនាញ <space style="font-family: 'Khmer Moul';font-size: 23px">{{@$major->major_name_kh}}</space> </div>
                <div class="p font1"> {{@$generation->generation_name_kh}} {{@$student_year->student_year_kh}} ថ្នាក់ <space style="font-family: 'Khmer Moul';font-size: 25px">{{@$degree->degree_name_kh}}</space> ក្នុងឆ្នាំសិក្សា {{@$session->title}} នៃសាកលវិទ្យាល័យស្វាយរៀងពិតប្រាកដមែន ។</div>
                <div class="p font1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;លិខិតបញ្ជាក់នេះចេញជូនសាមុីខ្លួនដើម្បីប្រើប្រាស់តាមមុខការដែលអាចប្រើបាន។</div>
                <div class="col-lg-6 p font1" style="text-align: center">ថ្ងៃ............................ខែ......................ឆ្នាំជូត ទោស័ក ព.ស ២៥៦៤</div>
                <div class="col-lg-6 p font1" style="text-align: center">ស្វាយរៀង, ថ្ងៃទី.............ខែ.................ឆ្នាំ ២០២០</div>
                <div class="col-lg-6 p font1" style="text-align: center"><h2 style="font-family: 'Khmer Moul'">សាកលវិទ្យាធិការ</h2></div>
        
    </td>
    </table>
</table>