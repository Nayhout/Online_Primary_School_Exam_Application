@extends('backEnd.master')
@section('mainContent')

    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            <section class="sms-breadcrumb mb-40 up_breadcrumb white-box">
                <div class="container-fluid">
                    <div class="row justify-content-between">
                        <h1>@lang('Daily Attendance')</h1>
                        <div class="bc-pages">
                            <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                            <a href="#">@lang('lang.student_information')</a>
                            <a href="#">@lang('Daily Attendance')</a>
                        </div>
                    </div>
                </div>
            </section>
            <input type="text" hidden value="{{ @$clas->class_name }}" id="cls">
            <input type="text" hidden value="{{ @$sec->section_name }}" id="sec">
            <div class="row">
                <div class="col-lg-8 col-md-6">
                    <div class="main-title">
                        <h3 class="mb-30">@lang('lang.select_criteria')</h3>
                    </div>
                </div>

            </div>
            <div class="white-box">
                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'student-attendance-detail', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'search_student']) }}
                <div class="row">
                    <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                    <div class="col-lg-3 mt-30-md">
                        <select class="w-100 niceSelect bb form-control {{ $errors->has('class') ? ' is-invalid' : '' }}"
                                id="select_class" name="class">
                            <option data-display="@lang('lang.select_class')"
                                    value="">@lang('lang.select_class')
                            </option>
                            @foreach($classes as $class)
                                <option value="{{$class->id}}" {{ isset($class_id)? ($class_id == $class->id? 'selected':''): (old("class") == $class->id ? "selected":"")}}>{{$class->class_name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('class'))
                            <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ $errors->first('class') }}</strong>
                                </span>
                        @endif
                    </div>
                    <div class="col-lg-3 mt-30-md" id="select_section_div">
                        <select class="w-100 niceSelect bb form-control{{ $errors->has('section') ? ' is-invalid' : '' }}"
                                id="select_section" name="section">
                            <option data-display="@lang('lang.select_section') "
                                    value="">@lang('lang.select_section') *
                            </option>
                        </select>
                        @if ($errors->has('section'))
                            <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ $errors->first('section') }}</strong>
                                </span>
                        @endif
                    </div>
                    <div class="col-lg-3 mt-30-md">

                        <select class="w-100 niceSelect bb form-control {{ $errors->has('type') ? ' is-invalid' : '' }}"
                                name="att_type" id="attendance">
                            <option data-display="@lang('lang.select_type') "
                                    value="">
                            </option>
                            <option value="P">Present</option>
                            <option value="L">Late</option>
                            <option value="H">Half Day</option>
                            <option value="A">Absent</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 mt-30-md">
                        <div class="row no-gutters input-right-icon">
                            <div class="col">
                                <div class="input-effect">
                                    <input class="primary-input date form-control{{ $errors->has('attendance_date') ? ' is-invalid' : '' }} {{isset($date)? 'read-only-input': ''}}"
                                           id="startDate" type="text"
                                           name="attendance_date" autocomplete="off"
                                           value="{{isset($date)? $date: date('m/d/Y')}}">
                                    <label for="startDate">@lang('lang.attendance') @lang('lang.date')*</label>
                                    <span class="focus-border"></span>

                                    @if ($errors->has('attendance_date'))
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('attendance_date') }}</strong>
                                                </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto">
                                <button class="" type="button">
                                    <i class="ti-calendar" id="start-date-icon"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-12 mt-20 text-right">
                        <button type="submit" class="primary-btn small fix-gr-bg">
                            <span class="ti-search pr-2"></span>
                            @lang('lang.search')
                        </button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>

            <div class="row mt-40">


                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">Daily Attendance Report</h3>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                <div class="col-lg-12">
                    <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Khmer Name</th>
                            <th>Class</th>
{{--                            <th>Section</th>--}}
                            <th>Type</th>
                            <th>Parent</th>
                            <th>Number Phone</th>


                        </tr>
                        </thead>

                        <tbody>
                       {{--  @php
                             $total_late = 0;
                        @endphp
                         @foreach($attendances as $values)
                             @endforeach
                         <td>
                             @php $l = 0; @endphp
                             @foreach($values as $value)
                                 @if($value->attendance_type == 'L')
                                     @php $l++; $total_attendance++; $total_late++; @endphp
                                 @endif
                             @endforeach
                             {{$l}}
                         </td>--}}

<!--                       --><?php
//
//                       $attendance_l = \App\SmStudentAttendance::where('attendance_date', 'like', '%'.$date.'%')
//                       ->where('attendance_type','L')
//                       ->select('id')
//                       ->count();
//
//                       ?>








                        @if(isset($rows))
                            @foreach($rows as $row)
                                <?php
//                                    dd($row);
                                        $student = \App\SmStudent::find($row->student_id);
                                        $class = \App\SmClass::find(optional($student)->class_id);
                                        $parent = \App\SmParent::find(optional($student)->parent_id);

                                ?>
                                <tr>
                                    <td style="color: #ff8b23;font-size: 16px">{{$loop->iteration}}</td>
                                    <td>{{optional($student)->full_name}}</td>
                                    <td>{{optional($student)->bank_name}}</td>
                                    <td>{{optional($class)->class_name}}</td>
{{--                                    <td>{{$row->school_id}}</td>--}}
                                    <td>{{$row->attendance_type}}</td>
                                    <td>{{optional($parent)->fathers_name}}</td>
                                    <td>{{optional($parent)->fathers_mobile}}</td>

                                </tr>

                            @endforeach
                        @endif
                            <?php
//                            dd($rows);
                            ?>
                        </tbody>
                        <tr>
                            <th colspan="3"></th>
                            <th style="color: orange;font-size: 25px">Total</th>
                            <th style="color: orange;font-size: 25px">{{count($rows)}}</th>
                        </tr>

                    </table>
                </div>
{{--                        <input type="hidden" id="total-attendance" value="{{$total_late}}">--}}
                    </div>
                </div>
            </div>
                </div>
            </div>
        </div>
    </section>
@endsection
