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
                <div style="text-align: center;font-family: 'Khmer Moul'"> ចំនួនគណៈគ្រប់គ្រង បុគ្គលិក សាស្រ្តាចា្យ ជាតិ និងអន្តរជាតិ តាមសញ្ញាបត្រ សម្រាប់ឆ្នាំសិក្សា២០១៩-២០២០</div>
                <div style="text-align: center;font-family: 'Khmer Moul'"> សាស្រ្តាចា្យជាតិបង្រៀនពេញម៉ោង</div>
            </div>
        </table>
        <div class="table-responsive table1" style="font-family: 'Khmer OS System'">
            <table class="mt-30 mb-20 table table-striped table-bordered ">
                <thead class="border">
                    <tr>
                        <th rowspan="2" style="width: 40px">ល.រ</th>
                        <th rowspan="2">បរិយាយ</th>
                        <th colspan="2">សរុប</th>
                        <th colspan="2">សបណ្ឌិត</th>
                        <th colspan="2">ស.បរិ.ជាន់ខ្ពស់</th>
                        <th colspan="2">ស.បរិញ្ញាបត្រ</th>
                        <th colspan="2">ស.ក្រោមបរិញ្ញាបត្រ</th>

                    </tr>

                    <tr>
                        <th style="width: 100px;">សរុប</th>
                        <th style="width: 100px;">ស្រី</th>
                        <th style="width: 100px;">សរុប</th>
                        <th style="width: 100px;">ស្រី</th>
                        <th style="width: 100px;">សរុប</th>
                        <th style="width: 100px;">ស្រី</th>
                        <th style="width: 100px;">សរុប</th>
                        <th style="width: 100px;">ស្រី</th>
                        <th style="width: 100px;">សរុប</th>
                        <th style="width: 100px;">ស្រី</th>

                    </tr>
                </thead>
                <tbody class="border">
                <tr>
                    <td style="text-align: center;font-weight: bold">{{$i++}}</td>
                    <td></td>
                    <td></td>
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
                @if($i < 4)
                    <?php  $k=4 - $i; ?>
                    @for($j=0;$j<$k;$j++)
                        <tr>
                            <td style="font-weight: bold;text-align: center">{{$i++}}</td>
                            <td></td>
                            <td></td>
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
                @endif
                <tr>
                    <td style="text-align: center"><b>សរុប</b></td>
                    <td></td>
                    <td></td>
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
                </tbody>
            </table>
            <br>
            <table>
                <div>
                    <div style="text-align: center;font-family: 'Khmer Moul'"> សាស្រ្តាចា្យជាតិបង្រៀនជារបបម៉ោងបន្ថែម</div>
                </div>
            </table>
            <table class="mt-30 mb-20 table table-striped table-bordered ">
                <thead class="border">
                <tr>
                    <th rowspan="2" style="width: 40px">ល.រ</th>
                    <th rowspan="2">បរិយាយ</th>
                    <th colspan="2">សរុប</th>
                    <th colspan="2">សបណ្ឌិត</th>
                    <th colspan="2">ស.បរិ.ជាន់ខ្ពស់</th>
                    <th colspan="2">ស.បរិញ្ញាបត្រ</th>
                    <th colspan="2">ស.ក្រោមបរិញ្ញាបត្រ</th>

                </tr>

                <tr>
                    <th style="width: 100px;">សរុប</th>
                    <th style="width: 100px;">ស្រី</th>
                    <th style="width: 100px;">សរុប</th>
                    <th style="width: 100px;">ស្រី</th>
                    <th style="width: 100px;">សរុប</th>
                    <th style="width: 100px;">ស្រី</th>
                    <th style="width: 100px;">សរុប</th>
                    <th style="width: 100px;">ស្រី</th>
                    <th style="width: 100px;">សរុប</th>
                    <th style="width: 100px;">ស្រី</th>

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
                    <td></td>
                    <td></td>

                </tr>
                @for($a=1;$a<=3;)
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
                            <td></td>
                            <td></td>
                        </tr>
                    @endfor
                <tr>
                    <td style="text-align: center"><b>សរុប</b></td>
                    <td></td>
                    <td></td>
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
                </tbody>
            </table>
            <br>
            <br>
            <br>
            <table>
                <div>
                    <div style="text-align: center;font-family: 'Khmer Moul'"> ចំនួនគណៈគ្រប់គ្រង/បុគ្គលិក  បង្រៀនជារបបម៉ោងបន្ថែម</div>
                </div>
            </table>
            <table class="mt-30 mb-20 table table-striped table-bordered ">
                <thead class="border">
                <tr>
                    <th rowspan="2" style="width: 40px">ល.រ</th>
                    <th rowspan="2">បរិយាយ</th>
                    <th colspan="2">សរុប</th>
                    <th colspan="2">សបណ្ឌិត</th>
                    <th colspan="2">ស.បរិ.ជាន់ខ្ពស់</th>
                    <th colspan="2">ស.បរិញ្ញាបត្រ</th>
                    <th colspan="2">ស.ក្រោមបរិញ្ញាបត្រ</th>

                </tr>

                <tr>
                    <th style="width: 100px;">សរុប</th>
                    <th style="width: 100px;">ស្រី</th>
                    <th style="width: 100px;">សរុប</th>
                    <th style="width: 100px;">ស្រី</th>
                    <th style="width: 100px;">សរុប</th>
                    <th style="width: 100px;">ស្រី</th>
                    <th style="width: 100px;">សរុប</th>
                    <th style="width: 100px;">ស្រី</th>
                    <th style="width: 100px;">សរុប</th>
                    <th style="width: 100px;">ស្រី</th>

                </tr>
                </thead>
                <tbody class="border">
                <tr>
                    <td style="text-align: center;font-weight: bold">{{$b++}}</td>
                    <td></td>
                    <td></td>
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
                @for($b=1;$b<=3;)
                    <tr>
                        <td style="font-weight: bold;text-align: center">{{$b++}}</td>
                        <td></td>
                        <td></td>
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
                    <td style="text-align: center"><b>សរុប</b></td>
                    <td></td>
                    <td></td>
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
                </tbody>
            </table>
            <br>
            <br>
            <table>
                <div>
                    <div style="text-align: center;font-family: 'Khmer Moul'"> ចំនួនគណៈគ្រប់គ្រង/បុគ្គលិក មិនបង្រៀន</div>
                </div>
            </table>
            <table class="mt-30 mb-20 table table-striped table-bordered ">
                <thead class="border">
                <tr>
                    <th rowspan="2" style="width: 40px">ល.រ</th>
                    <th rowspan="2">បរិយាយ</th>
                    <th colspan="2">សរុប</th>
                    <th colspan="2">សបណ្ឌិត</th>
                    <th colspan="2">ស.បរិ.ជាន់ខ្ពស់</th>
                    <th colspan="2">ស.បរិញ្ញាបត្រ</th>
                    <th colspan="2">ស.ក្រោមបរិញ្ញាបត្រ</th>

                </tr>

                <tr>
                    <th style="width: 100px;">សរុប</th>
                    <th style="width: 100px;">ស្រី</th>
                    <th style="width: 100px;">សរុប</th>
                    <th style="width: 100px;">ស្រី</th>
                    <th style="width: 100px;">សរុប</th>
                    <th style="width: 100px;">ស្រី</th>
                    <th style="width: 100px;">សរុប</th>
                    <th style="width: 100px;">ស្រី</th>
                    <th style="width: 100px;">សរុប</th>
                    <th style="width: 100px;">ស្រី</th>

                </tr>
                </thead>
                <tbody class="border">
                <tr>
                    <td style="text-align: center;font-weight: bold">{{$c++}}</td>
                    <td></td>
                    <td></td>
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
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
                <tr>
                    <td style="text-align: center"><b>សរុប</b></td>
                    <td></td>
                    <td></td>
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
                </tbody>
            </table>
        </div>
        <br>
        <table>
            <div style="font-family: 'Khmer OS System'">
                <div style="margin-right: 20px;text-align: center;float: left">សំគាល់ៈគណៈគ្រប់គ្រង/បុគ្គលិក បង្រៀនម៉ោងបន្ថែម និងបុគ្គលិកមិនបង្រៀន មិនអាចជាន់គ្នាបានទេ!</div>
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