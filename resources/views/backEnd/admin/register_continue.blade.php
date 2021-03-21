<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        html, body {
            margin: 0;
            padding: 0;
        }
        .header {
            margin-top: 5rem;
            font-family: "Khmer Moul";
            font-size: 20px;
            line-height: 28px;
        }
        .sub-header{
            font-family: "Khmer Moul";
            font-size: 20px;
            font-weight: bold;
        }
        .content {
            padding: 5px 30px;
            margin-top: 3rem;
            font-family: "Khmer OS System";
            font-size: 16px;
        }
        .content p{
            font-family: "Khmer OS System";
            font-size: 10px;
        }
        .box{
            width: 100%;
            height: 300px;
            background: darkgrey;
            border: solid black 2px;
        }
        .text{
            margin-top: 30px;
        }
        .text h5{
            font-family: "Khmer Moul";
            font-size: 16px;
            font-weight: bold;
        }
        .text p{
            font-family: "Khmer OS System";
            font-size: 14px;
        }
        .content div {
            line-height: 40px;
        }
        @media print {
            .header {
                margin-top: 2px;
                font-family: "Khmer Moul";
                font-size: 20px;
                line-height: 28px;
            }
            .sub-header{
                font-family: "Khmer Moul";
                font-size: 20px;
                font-weight: bold;
            }
            .content {
                padding: 5px 2px;
                margin-top: 3rem;
                font-family: "Khmer OS System";
                font-size: 16px;
                font-weight: bold;
            }
            .content p{
                font-family: "Khmer OS";
                font-size: 12px;
            }
            .box{
                width: 100%;
                height: 360px;
                background: darkgrey;
                border: solid black 2px;
            }
            .text{
                margin-top: 30px;
            }
            .text h5{
                font-family: "Khmer Moul";
                font-size: 16px;
            }
            .text p{
                font-family: "Khmer OS System";
                font-size: 18px;
            }
            .content div {
                line-height: 45px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="child">
        <div class="header">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4"></div>
                <div class="col-md-4 text-center">ព្រះរាជាណាចក្រកម្ពុជា</div>
            </div>
            <div class="row">
                <div class="col-md-4 text-center">ក្រសួងអប់រំ យុវជន និងកីឡា</div>
                <div class="col-md-4"></div>
                <div class="col-md-4 text-center">ជាតិ សាសនា ព្រះមហាក្សត្រ</div>
            </div>
            <div class="row">
                <div class="col-md-4 text-center">សាកលវិទ្យាល័យស្វាយររៀង</div>
                <div class="col-md-4"></div>
                <div class="col-md-4"></div>
            </div>
        </div>
        <div class="sub-header">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 text-center">ពាក្យសុំបន្ដការសិក្សាឆ្នាំ____មុខជំនាញ___________</div>
                <div class="col-md-2"></div>
            </div>
            <p></p>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 text-center">នៅសាកលវិទ្យាល័យស្វាយររៀង</div>
                <div class="col-md-2"></div>
            </div>
        </div>
        <div class="content">
            <div class="row text-left">
                <div class="col-md-4">ខ្ងុំបាទ-នាងខ្ងុំឈ្មោះ Name in Khmer</div>
                <div class="col-md-3">អក្សរោឡាតាំង Name in Latin</div>
                <div class="col-md-2">ភេទ Gender</div>
                <div class="col-md-3">អត្តលេខនិស្សិត StudentID Nº</div>
            </div>
            <div class="row text-left">
                <div class="col-md-4">
                    <hr style="width: 100%">
                </div>
                <div class="col-md-3">
                    <hr style="width: 100%">
                </div>
                <div class="col-md-2">
                    <hr style="width: 100%">
                </div>
                <div class="col-md-3">
                    <hr style="width: 100%">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4"> សុំចុះឈ្មោះចូលរៀនបន្ដឆ្នាំទី Year</div>
                <div class="col-md-4"> មុខជំនាញ Major</div>
                <div class="col-md-4">  មហាវិទ្យាល័យ Faculty</div>
            </div>
            <div class="row">
                <div class="col-md-4"> <hr style="width: 100%"></div>
                <div class="col-md-4"><hr style="width: 100%"></div>
                <div class="col-md-4">  <hr style="width: 100%"></div>
            </div>
            <div class="row">
                <div class="col-md-6">បានព្យូរការសិក្សានៅឆមាសទី ឆ្នាំសិក្សា</div>
                <div class="col-md-6">មូលហេតុ</div>
            </div>
            <div class="row" style="line-height: 50px">
                <div class="col-md-6"><hr style="width: 100%"></div>
                <div class="col-md-6"><hr style="width: 100%"></div>
            </div>
            <p></p>
            <div class="div" style="border: solid 2px;padding: 2px 5px">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12"> អាស័យដ្ឋានបច្ចុប្បន្ន Current Address </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr style="width: 100%"></div>
                        </div>
                        <div class="row" STYLE="margin-top: -20px" ​​​>
                            <div class="col-md-2"><p>​<i>ផ្ទះលេខ-ផ្លូវលេខ</i></p></div>
                            <div class="col-md-2"><p><i>ភូមិ</i></p></div>
                            <div class="col-md-2"><p><i>ឃុំ សង្កាត់</i></p></div>
                            <div class="col-md-3"><p><i>ខណ្ឌ ក្រុង ស្រុក</i></p></div>
                            <div class="col-md-3"><p><i>រាជធានី ខេត្ត</i></p></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">អត្តសញ្ញាណប័ណ្ណ ID Nº</div>
                            <div class="col-md-3">លេខទូរស័ព្ទ Telephone</div>
                            <div class="col-md-4" style="font-size: 15px">គណនីហ្វេសប៊ុក Facebook Account Name</div>
                            <div class="col-md-2">អ៊ីមែល Email</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <hr style="width: 100%">
                            </div>  <div class="col-md-3">
                                <hr style="width: 100%">
                            </div>  <div class="col-md-4">
                                <hr style="width: 100%">
                            </div>  <div class="col-md-2">
                                <hr style="width: 100%">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"> មុខរបរសព្វថ្ងៃ Current Occupation</div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr style="width: 100%"></div>
                        </div>
                        <div class="row" STYLE="margin-top: -20px" ​​​>
                            <div class="col-md-4"><p><i>​មុខងារ</i></p></div>
                            <div class="col-md-3"><p><i>អង្គភាព</i></p></div>
                            <div class="col-md-5"><p><i>អង្គភាព</i></p></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">​ ព័ត័មានសម្រាប់ទាក់ទងក្នុងករណីបន្ទាន់កើតឡើង Emergency Contact Information</div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr style="width: 100%"></div>
                        </div>
                        <div class="row" STYLE="margin-top: -20px" ​​​>
                            <div class="col-md-4"><p><i>​ឈ្មោះ</i></p></div>
                            <div class="col-md-3"><p><i>មុខរបរ</i></p></div>
                            <div class="col-md-5"><p><i>លេខទូរស័ព្ទ</i></p></div>
                        </div>
                    </div>
                </div>
            </div>
            <p></p>
            <div class="row text-left">
                <div class="col-md-1"></div>
                <div class="col-md-10">សូមភ្ជាប់មកជាមូយនូវ Enclosure</div>
            </div>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-5">លិខិតស្នើសុំព្យូរការសិក្សាដែលបានទទូលការឯកភាព</div>
                <div class="col-md-5">ចុះថ្ងៃទី_______ខែ_______ឆ្នាំ________</div>
                <p></p>
            </div>
            <p></p>
            <p></p>
            <div>
                ខ្ងុំបាទ នាងខ្ងុំ សូមសន្យាថា នឹងគោរពតាមបទបញ្ជាផ្ទៃក្នុងនិងបទប្បញ្ញត្តិរបស់សកលវិទ្យាល័យអោយបានត្រឹមត្រូវ។ បើមានការប្រព្រឹត្តខុសដោយប្រការមួយណា ខ្ងុំបាទ នាងខ្ងុំ សូមទទួលខុសត្រូវចំពោះក្រុមប្រឹក្សាវិន័យរបស់គ្រឹះស្ថាន។
            </div>
            <p></p>
            <div class="row">
                <div class="col-md-6">
                    <div class="box">
                        <div class="text" style="text-align: center;">
                            <h5>សម្រាប់បុគ្គលិកស.ស.រ. For office use only</h5>
                            <p>ការពិនិត្យពាក្យសុំ_______________________________</p>
                            <p>________________________________</p>
                            <p>ស្វាយរៀង ថ្ងៃទី______ខែ______ឆ្នាំ២០_______</p>
                            <p>ហត្ថលេខា និង ឈ្មោះអ្នកទទួល</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    ធ្វើនៅ______ថ្ងៃទី_____ខែ_______ ឆ្នាំ ២០______
                    <br> <br> ហត្ថលេខា និង ឈ្មោះសមីខ្លួន
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>