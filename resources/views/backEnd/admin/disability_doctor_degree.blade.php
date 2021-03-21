<!DOCTYPE html>
<html>
@php
    $i = 1;
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
                <div style="text-align: center">ស្ថិតិនិស្សិត <space style="font-family: 'Khmer Moul'">ពិការ</space> កំពុងសិក្សា <space style="font-family: 'Khmer Moul'"> ថ្នាក់បណ្ឌិត</space>  សម្រាប់ឆ្នាំសិក្សា២០១៩-២០២០</div>
            </div>
        </table>
        <div class="table-responsive table1">
            <table class="mt-30 mb-20 table table-striped table-bordered ">
                <thead class="border">
                    <tr>
                        <th rowspan="3">ល.រ</th>
                        <th rowspan="3">មហាវិទ្យាល័យ</th>
                        <th rowspan="3" width="10%">ដេប៉ាតឺម៉ង់</th>
                        <th rowspan="3" width="10%">ឯកទេស/ជំនាញ</th>
                        <th rowspan="3">រយៈពេល ប.ប</th>
                        <th colspan="6">ឆ្នាំទី១</th>
                        <th colspan="6">ឆ្នាំទី២</th>
                        <th colspan="6">ឆ្នាំទី៣</th>
                        <th colspan="6">សរុប</th>

                    </tr>
                    <tr>

                        <th colspan="2">អាហា.រដ្ឋ</th>
                        <th colspan="2">អាហា.ផ្សេងៗ</th>
                        <th colspan="2">បង់ថ្លៃ</th>
                        <th colspan="2">អាហា.រដ្ឋ</th>
                        <th colspan="2">អាហា.ផ្សេងៗ</th>
                        <th colspan="2">បង់ថ្លៃ</th>
                        <th colspan="2">អាហា.រដ្ឋ</th>
                        <th colspan="2">អាហា.ផ្សេងៗ</th>
                        <th colspan="2">បង់ថ្លៃ</th>
                        <th colspan="2">អាហា.រដ្ឋ</th>
                        <th colspan="2">អាហា.ផ្សេងៗ</th>
                        <th colspan="2">បង់ថ្លៃ</th>
                    </tr>
                    <tr>
                        <th>សរុប</th>
                        <th width="3%">ស្រី</th>
                        <th>សរុប</th>
                        <th width="3%">ស្រី</th>
                        <th>សរុប</th>
                        <th width="3%">ស្រី</th>
                        <th>សរុប</th>
                        <th width="3%">ស្រី</th>
                        <th>សរុប</th>
                        <th width="3%">ស្រី</th>
                        <th>សរុប</th>
                        <th width="3%">ស្រី</th>
                        <th>សរុប</th>
                        <th width="3%">ស្រី</th>
                        <th>សរុប</th>
                        <th width="3%">ស្រី</th>
                        <th>សរុប</th>
                        <th width="3%">ស្រី</th>
                        <th>សរុប</th>
                        <th width="3%">ស្រី</th>
                        <th>សរុប</th>
                        <th width="3%">ស្រី</th>
                        <th>សរុប</th>
                        <th width="3%">ស្រី</th>

                    </tr>
                </thead>
                <tbody class="border">
                <tr>
                    <td style="text-align: center;font-weight: bold">{{$i++}}</td>
                    <td></td>
                    <td width="3%"></td>
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
                    <td width="3%"></td>
                    <td></td>
                    <td width="3%"></td>
                    <td></td>
                    <td width="3%"></td>
                    <td></td>
                    <td width="3%"></td>
                    <td></td>
                    <td width="3%"></td>
                    <td></td>
                    <td width="3%"></td>
                    <td></td>
                    <td width="3%"></td>
                    <td></td>
                    <td width="3%"></td>
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
                    <td colspan="4" style="text-align: center"><b>សរុប</b></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
        <br>
        <table>
            <div>
                <div style="margin-right: 20px;text-align: center;float: right">ធ្វើនៅ.........ថ្ងៃទី.............ខែ............ឆ្នាំ២០២០</div>
                <br>
                <div style="margin-right: -205px;float: right;font-family: 'Khmer Moul'">សាកលវិទ្យាធិការ</div>
            </div>
        </table>
    </div>
</body>
</html>