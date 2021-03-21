<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Card</title>
    <style>
        .cards{
            font-family: 'Kh Muol';
            margin-left: 160px;
            font-size: 14px;
            color: blue;
        }
        #cd{
            width: 402px;
            height: 450px;
            background: darkgrey;
            margin: 0 auto;
            border: solid 1px;

        }
        .cards1{
            font-family: 'Times New Roman';
            margin-left: 160px;
            font-size: 14px;

        }
        .form{
            border: 1px solid;
            width: 400px;
            height: 26%;
            background: mediumpurple;

        }
        .letter-head{
            font-family: 'Kh Muol';
            font-size: 16px;
        }
        .letter-head2{
            font-family:'Times New Roman';
            font-size: 15px
        }
        .st{
            width: 100%;
            background: yellowgreen;
        }
        .lg{
            width: 20%;
            float: left;
        }
        .name{
            width:69%;
            float: right;

        }
        .image{
            width: 100px;
            height: 100px;
        }
        .box{
            border:1px solid black;
            width: 15mm;
            height: 20mm;
            text-align: center;
            margin-top: 10px;
            margin-left: 180px;
        }
        .names{
            font-family: 'kh Muol';
            margin-left: 177px;
            font-size: 14px;
            color: blue
        }
        img{
            float: left;
            width: 40px;
            height: 40px;
            /*border-radius: 23px;*/
            margin: 4px;
        }
        .dd{
            font-size: 10px;
            margin-top: 50px;

        }
        .footers{
            font-family: 'khmer Muol';
            margin-left: 250px;
            font-size: 10px;
            color: black
        }
        .images{
            margin-left: 160px;width: 100px;height: 100px;
        }
        a:hover{
            color: white;
        }

        @media print{
            .letter-head2{
                font-family:'Times New Roman';
                font-size: 10px
            }
            .names{
                font-family: 'kh Muol';
                margin-left: 75px;
                font-size: 8px;
                color: blue
            }
            .letter-head{
                font-family: 'Kh Muol';
                font-size: 10px;
            }
            .cards{
                font-family: 'Kh Muol';
                margin-left: 78px;
                font-size: 8px;
                /*color: blue;*/
            }
            .cards1{
                font-family: 'Times New Roman';
                margin-left: 78px;
                font-size: 8px;

            }
            .footers{
                font-family: 'khmer Muol';
                margin-left: 109px;
                font-size: 8px;
                color: black
            }
            .form{

                width: 207px;
                height: 15%;
                color: whitesmoke;
                border-top: hidden;
                border-left: hidden;
                border-right: hidden;
                background: rebeccapurple;

            }
            #image{
                width: 40px;
                height: 40px;
            }
            #cd{
                width: 55mm;
                height: 85mm;
                /*background: deepskyblue !important;*/
                display: hidden;
                border: solid 2px;

            }
            #print1{
                display: none;
            }
            .name{
                width:76%;
                float: right;

            }
            .box{
                border:1px solid black;
                width: 15mm;
                height: 20mm;
                text-align: center;
                margin-top: 10px;
                margin-left: 76px;
            }
            #images{
                width: 70px;
                height: 70px;
                margin-left: 70px;
                margin-top: -10px;
            }
        }


    </style>
</head>
<body>

<button onclick="window.print()" id="print1">Print this page</button>


<div id="cd" >

    <div class="form" >
        <div class="lg">
                <img src="{{asset('public/upload/logoschool.jpg')}}" alt="" class="image" id="image" style="border-radius: 50%">
        </div>
        <div class="name ">
            <h2 class="letter-head">សាកលវិទ្យាល័យស្វាយរៀង</h2>
            <h2 class="letter-head2">SVAY RIENG UNIVERSITY</h2>

        </div>

    </div>
    <div class="st"></div>

    <div>
        <span class="cards">បណ្ណសម្គាល់ខ្លួន</span><br>
        <span class="cards1">IDENTITY CARD</span>
        <div >
            <p><img class="images" id="images" src="{{ @$student->student_photo != "" ? asset(@$student->student_photo) : asset('public/backEnd/img/student/id-card-img.jpg') }}" alt=""></p>
    </div>
        @foreach($staffs as $staff)
            <?php
                $designation = \App\SmDesignation::find($staff->designation_id);
                $department = \App\SmHumanDepartment::find($staff->department_id);

            ?>
            <span class="names">{{@$staff->full_name}}</span><br>
        @endforeach
            <span class="names">{{(@$designation->title)}}</span><br>

            <span class="names">{{(@$department->name)}}</span><br>

            <span class="footers">សាកលវិទ្យាល័យធិការ</span><br>

    </div>


    <div class="dd">
        <div><a href="www.sru.edu.kh" style="float: left;margin-left: 15px">www.sru.edu.kh</a></div>
        <div><a href="E-email:infor@sru.edu.kh" style="float: right;margin-right: 15px">E-email:infor@sru.edu.kh</a></div>
    </div>

</div>

</body>
</html>