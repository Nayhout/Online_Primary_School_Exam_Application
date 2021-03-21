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
                <br>
                <br>
                <div class="col-md-10 text-center" style="font-family: 'Khmer OS System';text-align: center">ព័ត៌មានអំពីមូលដ្ឋានសម្ភារៈរូបវ័ន្ត សម្រាប់ឆ្នាំសិក្សា២០១៩-២០២០</div>
            </div>
        </table>
        <div class="table-responsive table1" style="font-family: 'Khmer OS System'">
            <table class="mt-30 mb-20 table table-striped table-bordered ">
                <thead class="border">
                    <tr>
                        <th style="width: 40px">ល.រ</th>
                        <th>បរិយាយ</th>
                        <th>ចំនួន ( គិតជាចំនួនបន្ទប់ )</th>
                        <th>ផ្សេងៗ</th>

                    </tr>
                </thead>
                <tbody class="border">
                <tr>
                    <td style="text-align: center;font-weight: bold">{{$a++}}</td>
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
                <div style="margin-right: 60px;text-align: center;float: right">ធ្វើនៅ.........ថ្ងៃទី.............ខែ............ឆ្នាំ២០២០</div>
                <br>
                <div style="margin-right: 150px;float: right;font-family: 'Khmer Moul'">សាកលវិទ្យាធិការ</div>
            </div>
        </table>
    </div>
</body>
</html>