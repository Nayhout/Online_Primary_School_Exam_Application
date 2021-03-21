<!DOCTYPE html>
<html>
<head>
    <title>@lang('lang.student_id_card')</title>
    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/vendors/css/bootstrap.css" />
    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/css/style.css" />
    <style media="print">
        body{
            background: #fff;
        }
        input#button {
            margin: 20px 0;
            display: none;
        }
        #box-pic-bars{
            width: 50px;
            height: 50px;
            background: transparent;
            border: solid 1px black;
        }
        #cars{
            height: 55mm;
            width: 85mm;
            float: left;

        }
        #box-pics{
            margin-left: -65px;
            width: 80px;
            height: 80px;
            background: transparent;
            border: solid 1px black;
        }
        #name{
            font-size: 10px;
            margin-right: 70px;
        }
        #names{
            font-size: 8px;
            margin-right: 70px;
        }
        #cards{
            font-family: 'Khmer Moul';
            font-size: 10px;
            margin-right: 70px;
        }
        #photos{
            width: 60px;
            height: 60px;
            margin-right: 65px;
        }
        #pics{
            position: absolute;
            margin-left: 4%;
        }
        .infor{
            position: absolute;
            margin-left: 42%;
        }
        td{
            border-right: 1px solid #ddd;
            border-left: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            padding-top: 1px; padding-bottom: 3px;
        }
        table tr td{
            border: 0 !important;
        }

    </style>
    <style>
        /*.id_card {*/
        /*    display: grid !important;grid-template-columns: repeat(1,1fr) !important;grid-gap: 10px;justify-content: center;background: white !important;*/
        /*}*/
        input#button {
            margin: 20px 0;
        }
        .box-pic-bar{
            width: 50px;
            height: 50px;
            background: transparent;
            border: solid 1px black;
        }
        td {
            font-size: 11px;
            padding: 0 12px;
            font-family: "Khmer OS System";
            /*line-height: 18px;*/
        }
        body#abc {
            max-width: 900px;
            margin: auto;
            /*background: #808080;*/

        }
        html,body{
            font-family: "Khmer OS System", sans-serif;
            background: lightgrey;
        }
        .card{
            background: white;
            text-align: center;
            position: relative;
            margin: 0 auto;
            display: flex;
            box-sizing: border-box;
            border-radius: 12px;
        }
        .pic{
            position: absolute;
            margin-left: 10%;
        }
        .infor{
            background: white;
            /*position: absolute;*/
            margin-left: 42%;
            margin-bottom: 15%;
        }
        .infor_detail{
            /*margin-left: 1rem;*/
        }
        .box-pic{
            margin-left: -6px;
            width: 160px;
            height: 160px;
            background: transparent;
            border: solid 1px black;
        }
        .box-pic-bar{
            width: 200px;
            height: 200px;
            background: transparent;
            border: solid 1px black;
        }

        table {
            width: 180%;
            height: 100%;
            background: white;
        }
    </style>
</head>
<body id="abc">
<input type="button" onclick="printDiv('abc')" id="button" class="primary-btn small fix-gr-bg" value="print" />

{{-- <table style="height: 800px">
        <tr>  --}}
<div class="card" id="cars">
    @foreach($pickups as $pickup)
        <div class="sub-card">
            <div class="pic" id="pics">
                <p>
                    <img src="{{asset('public/backEnd/img/svrpic.jpg')}}" alt="" width="160px" height="160px" id="photos" style="border-radius: 50%">
                </p>
                <h2 style="font-family:'Khmer Moul' " id="cards">សាកលវិទ្យាល័យស្វាយរៀង</h2>
                <h2 id="names">SVAY RIENG UNIVERSITY</h2>
                <p><img src="{{ @$pickup->student_photo != "" ? asset(@$pickup->student_photo) : asset('public/backEnd/img/student/id-card-img.jpg') }}" alt="" class="box-pic" id="box-pics"></p>
            </div>
            <div class="infor" width="95%" >
                <h1 style="font-family: 'Khmer Moul'" id="cards">បណ័្ណសម្គាល់ខ្លួននិស្សិត</h1>
                <div class="infor_detail" style="text-align: left">
                    @if(@$id_card->student_name == 1)
                        <h2 id="name">ឈ្មោះ : {{@$pickup->bank_name}}</h2>
                    @endif
                    <h2 id="name">Name: {{@$pickup->first_name}}&nbsp;{{@$pickup->last_name}}</h2>
                    <h2 id="name">ជំនាញ</h2>
                    <h2 id="name">កម្រិត</h2>
                    <h2 id="name">អត្តលេខ:</h2>
                </div>
                <div id="box-pic-bars" class="box-pic-bar">

                </div>
            </div>
        </div>
    @endforeach
</div>
{{-- </tr>
</table> --}}

<script src="{{asset('public/backEnd/')}}/vendors/js/jquery-3.2.1.min.js"></script>
<script>



    function printDiv(divName) {

        // document.getElementById("button").remove();

        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
</body>
</html>

