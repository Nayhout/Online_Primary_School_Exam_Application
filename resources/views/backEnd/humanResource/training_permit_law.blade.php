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
                <div class="left">ក្រសួងអាណាព្យាបាល: ...............................</div>
                <div style="height: 30px;">ឈ្មោះគ្រឹះស្ថានសិក្សាៈ(ជាភាសាខ្មែរ និងជាអក្សរកាត់)..................</div>
                <div>ឈ្មោះគ្រឹះស្ថានសិក្សាៈ(ជាភាសាអង់គ្លេស និងជាអក្សរកាត់)...............</div>
                <div style="text-align: center;font-family: 'Khmer Moul'"> ច្បាប់អនុញ្ញាតឲ្យបណ្តុះបណ្តាល</div>
            </div>
        </table>
        <div class="table-responsive table1" style="font-family: 'Khmer OS System'">
            <table class="mt-30 mb-20 table table-striped table-bordered ">
                <thead class="border">
                    <tr>
                        <th rowspan="2" style="width: 40px">ល.រ</th>
                        <th colspan="2">មហាវិទ្យាល័យ</th>
                        <th colspan="2">ដេប៉ាតឺម៉ង់</th>
                        <th colspan="2">ឯកទេស / ជំនាញ</th>
                        <th colspan="4">ច្បាប់អនុញ្ញាត</th>
                        <th colspan="4">កម្រិតបណ្តុះបណ្តាល</th>
                        <th rowspan="2">ភ្ជាប់ឯកសារយោង</th>

                    </tr>
                    <tr>
                        <th>ភាសាខ្មែរ</th>
                        <th>ភាសាអង់គ្លេស</th>
                        <th>ភាសាខ្មែរ</th>
                        <th>ភាសាអង់គ្លេស</th>
                        <th>ភាសាខ្មែរ</th>
                        <th>ភាសាអង់គ្លេស</th>
                        <th>ប្រកាសលេខ</th>
                        <th>ថ្ងៃ   ខែ   ឆ្នាំ</th>
                        <th>កំពុងប‌²</th>
                        <th>មិនបានប‌²</th>
                        <th>បរិ.រង</th>
                        <th>បរិ.</th>
                        <th>ជាន់ខ្ពស់</th>
                        <th>បណ្ឌិត</th>

                    </tr>
                </thead>
                <tbody class="border">
                <tr>
                    <td rowspan="2" style="text-align: center;font-weight: bold"></td>
                    <td rowspan="2" style="padding: 20px"></td>
                    <td rowspan="2" style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>

                </tr>
                <tr>
                    <td style="text-align: center;font-weight: bold"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>

                </tr>
                <tr>
                    <td rowspan="4" style="text-align: center;font-weight: bold"></td>
                    <td rowspan="4"></td>
                    <td rowspan="4"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>

                </tr>
                <tr>
                    <td style="text-align: center;font-weight: bold"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>

                </tr>
                <tr>
                    <td style="text-align: center;font-weight: bold"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>

                </tr>
                <tr>
                    <td style="text-align: center;font-weight: bold"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>

                </tr>
                <tr>
                    <td rowspan="2" style="text-align: center;font-weight: bold"></td>
                    <td rowspan="2"></td>
                    <td rowspan="2"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>

                </tr>
                <tr>
                    <td style="text-align: center;font-weight: bold"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>

                </tr>
                <tr>
                    <td rowspan="3" style="text-align: center;font-weight: bold"></td>
                    <td rowspan="3"></td>
                    <td rowspan="3"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                </tr>
                <tr>
                    <td style="text-align: center;font-weight: bold"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>

                </tr>
                <tr>
                    <td style="text-align: center;font-weight: bold"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>

                </tr>
                <tr>
                    <td style="text-align: center;font-weight: bold"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>
                    <td style="padding: 20px"></td>

                </tr>


                </tbody>
            </table>
        </div>
        <br>
        <table>
            <div style="font-family: 'Khmer OS System'">
                <div style="margin-right: 20px;text-align: center;float: left">សំគាល់ ៖   - ប២  = បណ្តុះបណ្តាល</div>
                <br><br>
                <div style="margin-right: 20px;text-align: center;float: left">- សូមគូស √ ក្នុងគូឡោន បើបានបណ្តុះបណ្តាល </div>
                <div style="margin-right: 60px;text-align: center;float: right">អ្នកសម្រង់ស្ថិតិ</div>

                <br>
                <div style="margin-right: 20px;text-align: center">ធ្វើនៅ.........ថ្ងៃទី.............ខែ............ឆ្នាំ២០១៩</div>
                <br>
                <div style="margin-right: 50px;text-align: center;font-family: 'Khmer Moul'">បានឃើញ និងឯកភាព</div>
                <div style="margin-right: 50px;text-align: center">សាកលវិទ្យាធិការ</div>
            </div>
        </table>
    </div>
</body>
</html>