@php
    $i = 1;
    $j = 2;
@endphp
<style>
    @page { size: A4 }


    .border th, .border td {
        border: 1px solid black;
        padding: 9px 1px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        /*border: 1px solid black;*/
    }
    .border1{
        text-align: right;
        font-size: 20px;
        font-family: 'Khmer Moul';
        width: 90%;
    }
    .border2{
        text-align: left;
        font-size: 20px;
        font-family: 'Khmer Moul';
        margin-left: 71px;
    }
    .border3{
        text-align: center;
        font-family: 'Khmer Moul';
        font-weight: bold;
        font-size: 18px
    }
    .table1{
        padding: 60px;
    }

    @media print {
        .border1{
            text-align: right;
            font-size: 20px;
            font-family: 'Khmer Moul';
            width: 100%;
        }
        table td , th{
            padding: 10px 5px;
        }
        .border2{
            text-align: left;
            font-size: 20px;
            font-family: 'Khmer Moul';
            margin-left: 10px;
            width: 100%;

        }
        .rotate{
            transform: rotate(90deg);
        }
        .table1{
            padding: 0px;
        }
        .print{
            display: none;
        }

    }
</style>
<div>
    <button onclick="window.print()" class="primary-btn fix-gr-bg print">Print</button>
</div>
<table>
    <table>
        <div>
            <div class="border1">ព្រះរាជាណាចក្រកម្ពុជា</div>
            <td><div class="border2" style="margin-top: -80px;">ក្រសួងអប់រំយុវជន និងកីឡា</div></td>
            <div class="border1">ជាតិ សាសនា ព្រះមហាក្សត្រ</div>
            <div class="border2" style="margin-top: -40px;">សាកលវិទ្យាល័យស្វាយរៀង</div>
        </div>
    </table>
    <table>
        <div class="border3">
            <div >បញ្ជីឈ្មោះនិស្សិតប្រឡងសង ឆមាសទី១ ឆ្នាំសិក្សា២០១៩-២០២០</div>
            <div>ថ្នាក់បរិញ្ញាបត្រ ជំនាន់ទី១២ ឆ្នាំទី៤</div>
            <div>ជំនាញ គណនេយ្យ សិក្សាពេល សៅរ៍ អាទិត្យ ក្រុម១ ( 12ACT41Sb1 )</div>

        </div>
    </table>
    <div class="table-responsive table1">
        <table class="mt-30 mb-20 table table-striped table-bordered ">
            <thead class="border">
            <tr>
                <th>ល.រ</th>
                <th>អត្តលេខ</th>
                <th>គោត្តនាម-នាម</th>
                <th>ភេទ</th>
                <th>ថ្ងៃខែឆ្នាំកំណើត</th>
                <th class="rotate" style="padding: 6px 1px">Investment Management</th>
                <th class="rotate">Inventory and Operation Management</th>
                <th class="rotate">Advance Accounting1</th>
                <th class="rotate">International Accounting</th>
                <th class="rotate">Computer For Accounting</th>
                <th class="rotate">Research Methodology</th>
                <th>ផ្សេងៗ</th>

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
            @if($i < 15)
                <?php  $k=15 - $i; ?>
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
            </tbody>
        </table>
        <table>
            <div>
                <div style="padding: 5px 10px">បញ្ឈប់បញ្ជីត្រឹម 2 នាក់; ស្រី 2នាក់</div>
            </div>

        </table>
        <br>
        <br>
        <table>
            <div style="float: right">
                <div style="padding: 5px 10px;text-align: center">ថ្ងៃ.............................ខែ.......................ឆ្នាំជូត ទោស័ក ព.ស ២៥៦៤</div>
                <div style="padding: 5px 10px;text-align: center">ស្វាយរៀង,ថ្ងៃទី......................ខែ.....................ឆ្នាំ២០២០</div>
                <div style="padding: 5px 10px;text-align:center;font-family: 'Khmer Moul'">សាកលវិទ្យាធិការ</div>
            </div>
        </table>

    </div>
</table>
