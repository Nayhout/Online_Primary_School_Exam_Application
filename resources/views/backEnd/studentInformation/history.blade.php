<div id="DivIdToPrintPop">
<?php
    $student = \App\SmStudent::find($row->id);

?>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            /*border: 1px solid black;*/
        }

        .border th, .border td {
            border: 1px solid black;
            padding: 5px;
        }

        .right {
            text-align: right;
        }

        .font-size {
            font-size: 12px;
        }

        @media print {
            * {
                -webkit-print-color-adjust: exact !important; /* Chrome, Safari */
                color-adjust: exact !important;
            }
            @page  {
                size: A5 landscape;
            }

            body.modal-open {
                visibility: hidden;
                width: 100%;
            }

            body.modal-open .modal .modal-body {
                visibility: visible; /* make visible modal body and header */
                width: 100%;
            }

            table {
                width: 100%;
            }

            .font-size {
                font-size: 12px !important;
            }


            .border th, .border td {
                padding: 2px 2px 2px 2px;
            }
            .bottom {
                position: absolute;
                bottom: 5px;
                right: 0;
            }
        }
    </style>
    {{--    <style>--}}
    {{--        .bottom {--}}
    {{--            position: absolute;--}}
    {{--            bottom: 0;--}}
    {{--            right: 0;--}}
    {{--        }--}}
    {{--    </style>--}}
        <table style="text-align: center">
            <div style="font-family: 'Khmer Moul';text-align: right;margin-right: 145px">ព្រះរាជាណាចក្រកម្ពុជា</div>
            <div style="font-family: 'Khmer Moul';text-align: right;margin-right: 125px">ជាតិ &nbsp;សាសនា &nbsp; ព្រះមហាក្សត្រ</div>
        </table>
        <table style="text-align: center">
            <div style="text-align: left;font-family: 'Khmer Moul';font-size: 26px;font-weight: bold">ក្រសួងអប់រំ​យុវជន និងកីឡា</div>
        </table>
        <table style="text-align: center">
            <td style="font-family: 'Khmer OS Battambang';font-size: 26px;font-weight: bold"><u>ប្រវត្តិនិស្សិត</u></td>
        </table>
        <table style="margin-top: 5px">

            <tr>
                <td class="font-size">
                    <span style="font-size: 15px;font-weight: bold">អត្តលេខ: {{@$student->roll_no}}<br></span>
                    <span style="font-size: 15px;">គោត្តនាម និងនាម : {{@$student->bank_name}}<br></span>
                    <span style="font-size: 15px;">ឈ្មោះឡាតាំង: {{@$student->full_name}} <br></span>
                    <span style="font-size: 15px;">ថ្ងៃ ខែ ឆ្នាំកំណើត : {{@$student->date_of_birth}}<br></span>

                </td>
            </tr>
        </table>
        <br>

        {{--        <table class="bottom" style="text-align: center">--}}
        {{--            <tr>--}}
        {{--                <td style="width:150px;">--}}
        {{--                    <hr>--}}
        {{--                    <p style="font-size: 9px; font-weight: bold;text-align: center">Customer’s Signature & Name</p>--}}
        {{--                </td>--}}
        {{--                <td></td>--}}
        {{--                <td style="width:150px;">--}}
        {{--                    <hr>--}}
        {{--                    <p style="font-size: 9px; font-weight: bold;text-align: center">Seller’s Signature & Name</p>--}}
        {{--                </td>--}}
        {{--            </tr>--}}
        {{--        </table>--}}

        <table style="margin-top: 20px;font-family: 'Khmer OS Battambang';font-size: 11px ">
            <thead class="border">
            <tr style="background-color: #b3cce6">
                <th style="text-align: center;width:30px;">ID</th>
                <th style="text-align: center;">ឆ្នាំសិក្សា</th>
                <th style="text-align: center;width:80px;">បង្កាន់ដៃ</th>
                <th style="width:120px;text-align: center;">កាលបរិច្ឆេទ</th>
                <th style="text-align: center;width:100px;">កូដថ្នាក់</th>
                <th style="text-align: center;width:100px;">ឆ្នាំទី</th>
                <th style="text-align: center;width:100px;">ត្រូវបង់</th>
                <th style="text-align: center;width:100px;">បានបង់</th>
                <th style="text-align: center;width:100px;">នៅសល់</th>
                <th style="text-align: center;width:100px;">ផ្សេង</th>
                <th style="text-align: center;width:100px;">រៀនសង និងប្រឡងសង</th>
                <th style="text-align: center;width:100px;">ចំណាំ</th>
                <th style="text-align: center;width:100px;">Action</th>
                <th style="text-align: center;width:100px;">Edit Semester</th>
            </tr>
            </thead>

            <tbody class="border">

                <tr>
                    <td></td>
                    <td><b></b></td>
                    <td style="text-align: center"></td>
                    <td style="text-align: right"></td>
                    <td style="font-weight: bold;text-align: right"></td>
                    <td style="font-weight: bold;text-align: right"></td>
                    <td style="font-weight: bold;text-align: right"></td>
                    <td style="font-weight: bold;text-align: right"></td>
                    <td style="font-weight: bold;text-align: right"></td>
                    <td style="font-weight: bold;text-align: right"></td>
                    <td style="font-weight: bold;text-align: right"></td>
                    <td style="font-weight: bold;text-align: right"></td>
                    <td style="font-weight: bold;text-align: right"></td>
                    <td style="font-weight: bold;text-align: right"></td>
                </tr>
            </tbody>
        </table>
        <br>

        <br>
        <br>
        <br>
        <br>
        <br>

</div>
