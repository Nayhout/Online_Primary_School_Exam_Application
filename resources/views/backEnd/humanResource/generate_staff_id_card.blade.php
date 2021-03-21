@extends('backEnd.master')
@section('mainContent')

    <section class="sms-breadcrumb mb-40 white-box up_breadcrumb">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1> @lang('lang.generate') @lang('lang.id_card')</h1>
                <div class="bc-pages">
                    <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                    <a href="#">@lang('lang.admin_section')</a>
                    <a href="#">@lang('lang.generate') @lang('lang.id_card')</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-8 col-md-6">
                    <div class="main-title">
                        <h3 class="mb-30">@lang('lang.select_criteria') </h3>
                    </div>
                </div>
            </div>
            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'generate_staff_id_card_search', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
            <div class="row">
                <div class="col-lg-12">
                    @if(session()->has('message-success') != "")
                        @if(session()->has('message-success'))
                            <div class="alert alert-success">
                                {{ session()->get('message-success') }}
                            </div>
                        @endif
                    @endif
                    @if(session()->has('message-danger') != "")
                        @if(session()->has('message-danger'))
                            <div class="alert alert-danger">
                                {{ session()->get('message-danger') }}
                            </div>
                        @endif
                    @endif
                    <div class="white-box">
                        <div class="row">
                            <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                            <div class="col-lg-4">
                                <select class="niceSelect w-100 bb form-control {{ @$errors->has('department') ? ' is-invalid' : '' }}" id="select_department" name="department">
                                    <option data-display="@lang('lang.select') Departments*" value="">@lang('lang.select') @lang('lang.class') *</option>
                                    @foreach($departments as $department)
                                        <option value="{{@$department->id}}" {{isset($department_id)? ($department_id == $department->id? 'selected':''):''}}>{{@$department->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('department'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ @$errors->first('department') }}</strong>
                                </span>
                                @endif
                            </div>

{{--                            <div class="col-lg-4 mt-30-md">--}}
{{--                                <select class="niceSelect w-100 bb form-control {{ @$errors->has('designation') ? ' is-invalid' : '' }}" id="select_designation" name="designation">--}}
{{--                                    <option data-display="@lang('lang.select') Designation *" value="">@lang('lang.select') @lang('lang.class') *</option>--}}
{{--                                    @foreach($designations as $designation)--}}
{{--                                        <option value="{{@$designation->id}}" {{isset($designation_id)? ($designation_id == $designation->id? 'selected':''):''}}>{{@$designation->title}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                                @if ($errors->has('designation'))--}}
{{--                                    <span class="invalid-feedback invalid-select" role="alert">--}}
{{--                                    <strong>{{ @$errors->first('designation') }}</strong>--}}
{{--                                </span>--}}
{{--                                @endif--}}
{{--                            </div>--}}

                            <div class="col-lg-4" id="select_designation_div">
                                <select class="niceSelect w-100 bb form-control {{ @$errors->has('designation') ? ' is-invalid' : '' }}" id="select_designation" name="designation">
                                    <option data-display="@lang('lang.select') @lang('Designation*')" value="">@lang('lang.select') @lang('designation') *</option>

                                </select>

                            </div>



{{--                            <div class="col-lg-4 mt-30-md" id="select_section_div">--}}
{{--                                <select class="niceSelect w-100 bb" id="select_section" name="section">--}}
{{--                                    <option data-display="@lang('lang.select_section')" value=""> @lang('lang.select_section')</option>--}}

{{--                                </select>--}}
{{--                            </div>--}}


                            <div class="col-lg-4">
                                <select class="niceSelect w-100 bb form-control{{ $errors->has('staff_id_card') ? ' is-invalid' : '' }}" id="staff_id_card" name="staff_id_card">
                                    <option data-display=" @lang('lang.select') @lang('lang.id_card') " value=""> @lang('lang.select') @lang('lang.id_card') </option>
                                    @foreach($staff_id_cards as $staff_id_card)
                                        <option value="{{@$staff_id_card->id}}" {{isset($card_id)? ($card_id == $staff_id_card->id? 'selected':''):''}}>{{@$staff_id_card->title}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('staff_id_card'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ @$errors->first('staff_id_card') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="col-lg-12 mt-20 text-right">
                                <button type="submit" class="primary-btn small fix-gr-bg">
                                    <span class="ti-search pr-2"></span>
                                    @lang('lang.search')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </section>


    @if(isset($staffs))
        <section class="admin-visitor-area">
            <div class="container-fluid p-0">

                <div class="row mt-40">


                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-2 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-0">@lang('lang.staff') @lang('lang.list')</h3>
                                </div>
                            </div>

                            <div class="col-lg-1">
                                <a href="javascript:;" id="generate-staff-id-card-print-button" class="primary-btn small fix-gr-bg" >
                                    @lang('lang.generate')
                                </a>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-12">
                                <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                                    <thead>
                                    @if(session()->has('message-success') != "" ||
                                    session()->get('message-danger') != "")
                                        <tr>
                                            <td colspan="10">
                                                @if(session()->has('message-success'))
                                                    <div class="alert alert-success">
                                                        {{ session()->get('message-success') }}
                                                    </div>
                                                @elseif(session()->has('message-danger'))
                                                    <div class="alert alert-danger">
                                                        {{ session()->get('message-danger') }}
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th width="10%">
                                            <input type="checkbox" id="checkAll" class="common-checkbox generate-staff-id-card-print-all" name="checkAll" value="">
                                            <label for="checkAll">@lang('lang.all')</label>
                                        </th>
                                        <th>@lang('lang.department')</th>
                                        <th>@lang('lang.name')</th>
                                        <th>@lang('lang.designation')</th>

                                        <th>@lang('lang.father') @lang('lang.name')</th>
                                        <th>@lang('lang.date_of_birth')</th>
                                        <th>@lang('lang.gender')</th>
                                        <th>@lang('lang.phone')</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
//                                        $design = \App\SmDesignation::where();
                                    ?>
                                    @foreach($staffs as $staff)
                                        <tr>
                                            <td>
                                                <input type="checkbox" id="staff.{{@$staff->id}}" class="common-checkbox generate-staff-id-card-print" name="staff_checked[]" value="{{@$staff->id}}">
                                                <label for="staff.{{@$staff->id}}"></label>
                                            </td>
                                            <td>{{isset($department_id)? ($department_id == $department->id? 'selected':''):''}}{{@$department->name}}</td>
                                            <td>{{@$staff->full_name}}</td>
                                     <?php
                                            $design = \App\SmDesignation::find($staff->designation_id);
                                            $gender = \App\SmBaseSetup::find($staff->gender_id);
//                                            dd($design);
                                            ?>
{{--                                            @foreach( $designations as $designation)--}}
                                            <td>{{@$design->title}}</td>
{{--                                            <td>{{isset($designation_id)? ($designation_id == $designations->id? 'selected':''):''}}{{@$designations->title}}</td>--}}
{{--                                            @endforeach--}}
                                            <td>{{@$staff->fathers_name}}</td>
                                            <td>
                                                {{@$staff->date_of_birth}}
                                            </td>
                                            <td>{{@$gender->base_setup_name}}</td>
{{--                                            <td>{{@$staff->gender!=""?@$staff->gender->base_setup_name:""}}</td>--}}
                                            <td>{{@$staff->mobile}}</td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tr>
                                        <th colspan="3"></th>
                                        <th style="color: orange;font-size: 25px">Total</th>
                                        <th style="color: orange;font-size: 25px">{{count($staffs)}}</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif



@endsection
