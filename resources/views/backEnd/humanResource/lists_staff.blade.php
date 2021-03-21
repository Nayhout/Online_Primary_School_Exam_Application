<!DOCTYPE html>
<html>
@php
    $i = 1;
    $a = 1;
    $b = 1;
    $c = 1;
@endphp
<style>
    @page { size: A4 }
    body{
        background: lightgray;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        /*border: 1px solid black;*/
    }
    .border th, .border td {
        border: 1px solid black;
        padding: 9px 1px;
    }
    #check-site{
        width: 1500px;
        margin-left: 200px;
        margin-top: 100px;
        background: white;
        padding: 100px 10px;
    }
    .centers{
        text-align: center;
        font-family: 'Khmer Moul';
        font-size: 20px
    }
    .left{
        font-family: 'Khmer Moul';
        font-size: 20px
    }

    @media print {
        @page  {
            size: A4 landscape;
        }
        #check-site{
            width: 1500px;
            margin-left: 10px;
            margin-top: 30px;
            background: white;
            padding: 10px 10px;
        }

    }
</style>
<body>
    <div id="check-site">
        <table>
            <div>
                <div class="centers">ព្រះរាជាណាចក្រកម្ពុជា</div>
                <div class="centers">ជាតិ សាសនា ព្រះមហាក្សត្រ</div>
                <div class="left">ក្រសួងអាណាព្យាបាល: ក្រសួងអប់រំយុវជន និងកីឡា</div>
                <div>ឈ្មោះគ្រឹះស្ថានសិក្សា: សាកលវិទ្យាល័យស្វាយរៀង</div>
                <br>
                <br>
                <div style="text-align: center;font-family: 'Khmer Moul'"> បញ្ជីរាយនាមគណៈគ្រប់គ្រង បុគ្គលិក សាស្រ្តាចា្យ ជាតិ និងអន្តរជាតិ តាមសញ្ញាបត្រ សម្រាប់ឆ្នាំសិក្សា២០១៩-២០២០</div>
            </div>
        </table>
        <div class="table-responsive table1" style="font-family: 'Khmer OS System'">
            <table class="mt-30 mb-20 table table-striped table-bordered ">
                <thead class="border">
                    <tr>
                        <th style="width: 40px">ល.រ</th>
                        <th>គោត្តនាម</th>
                        <th>នាម</th>
                        <th>ជាអក្សរឡាតាំង</th>
                        <th>ភេទ</th>
                        <th>ថ្ងៃ ខែ ឆ្នាំកំណើត</th>
                        <th>សញ្ញាបត្រចុងក្រោយ</th>
                        <th>ឯកទេស/ជំនាញ</th>
                        <th>ប្រទេស</th>
                        <th>ផ្សេងៗ</th>

                    </tr>

                    <tr>
                        <th></th>
                        <th colspan="9" style="width: 100px;text-align: left;font-family: 'Khmer Moul'">&nbsp;I- សាស្រ្តាចា្យជាតិ</th>
                    </tr>

                    <tr>
                        <th></th>
                        <th colspan="9" style="width: 100px;text-align: left;font-family: 'Khmer Moul'">&nbsp;&nbsp;&nbsp;1- សាស្រ្តាចា្យបង្រៀនពេញម៉ោង</th>
                    </tr>
                </thead>
                <tbody class="border">
                <tr>
                    <td style="text-align: center;font-weight: bold">{{$a++}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                @for($a=1;$a<=5;)
                    <tr>
                        <td style="font-weight: bold;text-align: center">{{$a++}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
                <tr>
                    <th></th>
                    <th colspan="9" style="text-align: left;font-family: 'Khmer Moul'"> &nbsp;&nbsp;&nbsp;2- សាស្រ្តាចា្យបង្រៀនជារបបម៉ោងបន្ថែម</th>
                </tr>
                @for($a=1;$a<=5;)
                    <tr>
                        <td style="font-weight: bold;text-align: center">{{$a++}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endfor
                <tr>
                    <th></th>
                    <th colspan="9" style="width: 100px;text-align: left;font-family: 'Khmer Moul'">&nbsp;II- សាស្រ្តាចា្យអន្តរជាតិ</th>
                </tr>

                <tr>
                    <th></th>
                    <th colspan="9" style="width: 100px;text-align: left;font-family: 'Khmer Moul'">&nbsp;&nbsp;&nbsp;1- សាស្រ្តាចា្យបង្រៀនពេញម៉ោង</th>
                </tr>
                @for($a=1;$a<=2;)
                    <tr>
                        <td style="font-weight: bold;text-align: center">{{$a++}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor

                <tr>
                    <th></th>
                    <th colspan="9" style="width: 100px;text-align: left;font-family: 'Khmer Moul'">&nbsp;&nbsp;&nbsp;2- សាស្រ្តាចា្យបង្រៀនជារបបម៉ោងបន្ថែម</th>
                </tr>
                @for($a=1;$a<=2;)
                    <tr>
                        <td style="font-weight: bold;text-align: center">{{$a++}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
                <tr>
                    <th></th>
                    <th colspan="9" style="width: 100px;text-align: left;font-family: 'Khmer Moul'">&nbsp;III- គណៈគ្រប់គ្រង/បុគ្គលិក ជាតិ</th>
                </tr>
                <tr>
                    <th></th>
                    <th colspan="9" style="width: 100px;text-align: left;font-family: 'Khmer Moul'">&nbsp;&nbsp;&nbsp;1- ចំនួនគណៈគ្រប់គ្រង/បុគ្គលិក  បង្រៀនជារបបម៉ោងបន្ថែម</th>
                </tr>
                <tr>
                    <th></th>
                    <th colspan="9" style="width: 100px;text-align: left;font-family: 'Khmer Moul'">&nbsp;&nbsp;&nbsp;1-1 ចំនួនគណៈគ្រប់គ្រង បង្រៀនជារបបម៉ោងបន្ថែម</th>
                </tr>
                @for($c=1;$c<=5;)
                    <tr>
                        <td style="font-weight: bold;text-align: center">{{$c++}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
                <tr>
                    <th></th>
                    <th colspan="9" style="width: 100px;text-align: left;font-family: 'Khmer Moul'">&nbsp;&nbsp;&nbsp; 1-2 ចំនួនបុគ្គលិក បង្រៀនជារបបម៉ោងបន្ថែម</th>
                </tr>
                @for($c=1;$c<=3;)
                    <tr>
                        <td style="font-weight: bold;text-align: center">{{$c++}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
                <tr>
                    <th></th>
                    <th colspan="9" style="width: 100px;text-align: left;font-family: 'Khmer Moul'">&nbsp;&nbsp;&nbsp;2- ចំនួនគណៈគ្រប់គ្រង/បុគ្គលិក មិនបង្រៀន </th>
                </tr>
                <tr>
                    <th></th>
                    <th colspan="9" style="width: 100px;text-align: left;font-family: 'Khmer Moul'">&nbsp;&nbsp;&nbsp;2-1 ចំនួនគណៈគ្រប់គ្រង មិនបង្រៀន </th>
                </tr>
                @for($c=1;$c<=2;)
                    <tr>
                        <td style="font-weight: bold;text-align: center">{{$c++}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
                <tr>
                    <th></th>
                    <th colspan="9" style="width: 100px;text-align: left;font-family: 'Khmer Moul'">&nbsp;&nbsp;&nbsp;2-2 ចំនួនបុគ្គលិក មិនបង្រៀន  </th>
                </tr>
                @for($c=1;$c<=5;)
                    <tr>
                        <td style="font-weight: bold;text-align: center">{{$c++}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
                <tr>
                    <th></th>
                    <th colspan="9" style="width: 100px;text-align: left;font-family: 'Khmer Moul'">&nbsp;IV- គណៈគ្រប់គ្រង/បុគ្គលិក អន្តរជាតិ </th>
                </tr>
                <tr>
                    <th></th>
                    <th colspan="9" style="width: 100px;text-align: left;font-family: 'Khmer Moul'">&nbsp;&nbsp;&nbsp;1- ចំនួនគណៈគ្រប់គ្រង/បុគ្គលិក  បង្រៀនជារបបម៉ោងបន្ថែម</th>
                </tr>
                @for($c=1;$c<=2;)
                    <tr>
                        <td style="font-weight: bold;text-align: center">{{$c++}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
                <tr>
                    <th></th>
                    <th colspan="9" style="width: 100px;text-align: left;font-family: 'Khmer Moul'">&nbsp;&nbsp;&nbsp; 2- ចំនួនគណៈគ្រប់គ្រង/បុគ្គលិក មិនបង្រៀន </th>
                </tr>
                @for($c=1;$c<=2;)
                    <tr>
                        <td style="font-weight: bold;text-align: center">{{$c++}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
        <br>
        <table>
            <div style="font-family: 'Khmer OS System'">
{{--                <div style="margin-right: 20px;text-align: center;float: left">សំគាល់ៈគណៈគ្រប់គ្រង/បុគ្គលិក បង្រៀនម៉ោងបន្ថែម និងបុគ្គលិកមិនបង្រៀន មិនអាចជាន់គ្នាបានទេ!</div>--}}
                <br><br>
                <br><br>
                <div style="margin-right: 20px;text-align: center;float: right">ធ្វើនៅ.........ថ្ងៃទី.............ខែ............ឆ្នាំ២០២០</div>
                <br>
                <div style="margin-right: 130px;float: right;font-family: 'Khmer Moul'">សាកលវិទ្យាធិការ</div>
            </div>
        </table>
    </div>
</body>
</html>