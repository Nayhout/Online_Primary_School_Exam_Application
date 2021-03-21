<?php
    $degree = \App\SmDegree::find($students->degree_id);
    $gender = \App\SmBaseSetup::find($students->gender_id);
    $city = \App\SmProvinces::find($students->city);
    $parent = \App\SmParent::find($students->parent_id);
    $major = \App\SmMajor::find($students->major_id);
//    dd($city);

//    dd($gender);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        h5{
            font-size: 20px;
            font-family: 'khmer Moul';
        }
        h6{
            font-size: 20px;
            font-family: 'khmer Moul';
        }
        .footers{
            font-family: 'Khmer Moul';
            margin-left: 500px
        }
        header{
            margin-top: 5rem;
            color: black;
            font-family: 'khmer Moul';
        }
        .date{
            margin-left: 580px
        }
        .nation{
            font-size: 17px;margin-top: -20px;width: 100px
        }
        .sub-header{
            margin-top: 1rem;
            color: black;
            font-family: 'khmer Moul';
        }
        .content{
            margin-top: 2rem;
            color: black;
            font-family: 'Khmer OS System';
            position: relative;
        }
        /*.content p{*/
        /*    font-family: 'khmer Moul';*/
        /*    font-size: 18px;*/
        /*}*/
        .content #pho_pos{
            border: solid black 1px;
            height: 160px;
            width: 115px;
            text-align: center;
            margin-left: 300px;
            position: absolute;
        }
        .content .cap{
            text-align: center;
            margin-left: 300px;
            margin-top: 10%;

            position: absolute;
        }
        .date-kh{
          margin-left: 40%;
        }
        .khmer_name{
            font-family: 'Khmer Moul';
            font-size: 25px;
            margin-top: -10px
        }
        .degree{
            font-family: 'Khmer Moul';
            font-size: 20px
        }

        @media print {
            header{
                margin-top: 20rem;
                color: black;
                font-family: "Khmer OS Moul Light";
            }
            input{
                border: hidden;
            }
            h3{
                font-size: 36px;
            }
            h2{
                font-family: 'khmer Moul';
            }
            h5{
                font-size: 30px;
                font-family: 'khmer Moul';
            }
            h6{
                font-size: 28px;
                font-family: 'khmer Moul';
            }
            .degree{
                font-family: 'Khmer Moul';
                font-size: 30px
            }
            #dates{
                font-size: 25px;
                margin-bottom: 10px;
            }
            #nation{
                font-size: 25px;margin-top: -20px;width: 100px;margin-left: 30px;
            }
            #date{
                margin-left: 420px
            }
            #footers{
                 font-family: 'Khmer Moul';
                 margin-left: 410px
             }
            .sub-header{
                margin-top: 1rem;
                color: black;
                font-family: "Khmer OS Moul Light";
            }
            .content{
                margin-top: 2rem;
                color: black;
                font-family: "Kh Battambang";
                position: relative;
            }
            .content p{
                font-family: "Kh Battambang";
                font-size: 26px;
            }
            .content #pho_pos{
                border: solid black 1px;
                height: 160px;
                width: 115px;
                text-align: center;
                margin-left: 150px;
                position: absolute;
                font-family: "Kh Battambang";
                font-size: 16px;
            }
            .content .cap{
                text-align: center;
                margin-left: 130px;
                margin-top: 14%;

                font-family: "Kh Battambang";
                font-size: 16px;
                position: absolute;
            }
            .date-kh p{
                margin-left: -120px;
            }
            .khmer_name{
                font-family: 'Khmer Moul';
                font-size: 35px;
                margin-top: -10px
            }
            #id{
                font-size: 25px;
                margin-top: 3px
            }
        }
    </style>
</head>
<body style="margin-left: -70px">
       <header>
           <div class="row text-left">
               <div class="col-md-3"></div>
               <div class="col-md-9"><h2><u>វិញ្ញាបនបត្របណ្ដោះអាសន្នថ្នាក់{{@$degree->degree_name_kh}}</u></h2></div>
           </div>
       </header>
        <div class="sub-header">
            <div class="row text-left">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <h5>សាកលវិទ្យាធិការ នៃសាកលវិទ្យាល័យ​ស្វាយរៀង <other style="font-family: 'Khmer OS System'">បញ្ជាក់ថា</other> </h5>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <div class="row text-left">
                        <div class="col-md-3"><p>ឈ្មោះនិស្សិត</p></div>
                        <div class="col-md-1"><p>:</p></div>
                        <input class="col-md-4 khmer_name" value="{{@$students->bank_name}}" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <div class="row text-left">
                        <div class="col-md-3"><p>ជាអក្សរឡាតាំង</p></div>
                        <div class="col-md-1"><p>:</p></div>
                        <div class="col-md-4" style="font-size: 25px;">{{@$students->full_name}}</div>
                    </div>
                </div>
            </div>
            <?php
                $male = 'ប្រុស';
                $female = 'ស្រី';
            ?>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <div class="row text-left">
                        <div class="col-md-3"><p>ភេទ</p></div>
                        <div class="col-md-1"><p>:</p></div>
                        @if($gender->base_setup_name == 'Male')
                        <div class="col-md-2"><p>{{@$male}}</p></div>
                            @elseif($gender->base_setup_name == 'Female')
                         <div class="col-md-2"><p>{{@$female}}</p></div>
                        @endif
                        <div class="col-md-1"><p>សញ្ជាតិ</p></div>
                        <input class="nation" id="nation" value="{{$students->nationality}}">
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <div class="row text-left">
                        <div class="col-md-3"><p>ថ្ងៃខែឆ្នាំកំណើត</p></div>
                        <div class="col-md-1"><p>:</p></div>
                        <div class="col-md-4"><p>{{\Carbon\Carbon::parse(@$students->date_of_birth)->format('d')}}-{{MonthKhmer(\Carbon\Carbon::parse(@$students->date_of_birth)->format('m'))}}-{{\Carbon\Carbon::parse(@$students->date_of_birth)->format('Y')}}</p></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <div class="row text-left">
                        <div class="col-md-3"><p>ទីកន្លែងកំណើត</p></div>
                        <div class="col-md-1"><p>:</p></div>
                        <div class="col-md-4"><p>ខេត្ត {{@$city->name_kh}}</p></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <div class="row text-left">
                        <div class="col-md-3"><p>ឪពុកឈ្មោះ</p></div>
                        <div class="col-md-1"><p>:</p></div>
                        <div class="col-md-2"><p id="father">{{@$parent->fathers_name}}</p></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <div class="row text-left">
                        <div class="col-md-3"><p>ម្ដាយឈ្មោះ</p></div>
                        <div class="col-md-1"><p>:</p></div>
                        <div class="col-md-2"><p>{{@$parent->mothers_name}}</p></div>
                    </div>
                </div>
            </div>
            <div id="pho_pos">
                <p>រូបថត</p>
                <p>4x6</p>
            </div>
            <div class="cap">
                <p style="font-family: 'Khmer Moul';"><u>កំណត់សំគាល់</u></p>
            </div>
            <div class="row">
                <div class="col-md-3">
                </div>
                <div class="col-md-9">
                    <p>បានបំពេញគ្រប់លក្ខខណ្ឌដោយជោគជ័យ ក្នុងការប្រឡងបញ្ចប់ការសិក្សាថ្នាក់ <b class="degree">{{@$degree->degree_name_kh}}</b></p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <div class="row text-left">
                        <div class="col-md-3"><p>ឯកទេស</p></div>
                        <div class="col-md-1"><p>:</p></div>
                        <div class="col-md-5"><h5><b>{{@$major->major_name_kh}}</b></h5></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <div class="row text-left">
                        <div class="col-md-3"><p>សម័យប្រលង</p></div>
                        <div class="col-md-1"><p>:</p></div>
                        <input class="col-md-7 " id="dates" style=" margin-bottom: 10px;" value="{{@$exam_dates->name}}"><p></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <p><b><h6>វិញ្ញាបនបត្រនេះចេញអោយសាមីជន យកទៅប្រើប្រាស់តាមការដែលអាចប្រើបាន។</h6></b></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <p>វិញ្ញាបនបត្រនេះមិនចេញជូនជាលើកទីពីរទេ​​។</p>
                </div>
            </div>
            <div class="row​​" style="margin-left: 400px">
                <div class="col-md-3"></div>
                <div class="col-md-9 date-kh">
                    <p>ថ្ងៃ................. ខែ................ ឆ្នាំជូត ទោស័ក ព.ស ២៥៦៤ </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <p class="date" id="date">ស្វាយរៀង,ថ្ងៃទី...... ខែ...... ឆ្នាំ២០២១</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-6">
                    <p class="footers" id="footers"><b>សាកលវិទ្យាធិការ</b></p>
                </div>
            </div>
        </div>
</body>
</html>