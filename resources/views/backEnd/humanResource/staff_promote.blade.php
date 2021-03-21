@extends('backEnd.master')
@section('mainContent')
    <section class="sms-breadcrumb mb-40 up_breadcrumb white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('lang.student_promote')</h1>
                <div class="bc-pages">
                    <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                    <a href="#">@lang('lang.student_information')</a>
                    <a href="{{url('staff-promote')}}">@lang('lang.student_promote')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    @if(session()->has('message-success'))
                        <div class="alert alert-success">
                            {{ session()->get('message-success') }}
                        </div>
                    @elseif(session()->has('message-danger'))
                        <div class="alert alert-danger">
                            {{ session()->get('message-danger') }}
                        </div>
                    @endif
                        <section class="admin-visitor-area up_admin_visitor">
                            <div class="container-fluid p-0">
                                <div class="row">
                                    <div class="col-lg-8 col-md-6">
                                        <div class="main-title">
                                            <h3 class="mb-30">@lang('lang.select_criteria') </h3>
                                        </div>
                                    </div>
                                </div>
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'staff_current_search', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
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
                                                <div class="col-lg-6">
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
                                                <div class="col-lg-6" id="select_designation_div">
                                                    <select class="niceSelect w-100 bb form-control {{ @$errors->has('designation') ? ' is-invalid' : '' }}" id="select_designation" name="designation">
                                                        <option data-display="@lang('lang.select') @lang('Designation*')" value="">@lang('lang.select') @lang('designation') *</option>
                                                    </select>
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
                </div>
            </div>
        </div>
    </section>
    <style>
        .all_check {
            background: linear-gradient(90deg, #7c32ff 0%, #c738d8 51%, #7c32ff 100%);
            color: #ffffff;
            background-size: 200% auto;
        }
    </style>

    @if(isset($staffs))
        <section class="admin-visitor-area">
            <div class="container-fluid p-0">
                <div class="row mt-40">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-4 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-30">@lang('lang.promote_student_in_next_session')</h3>
                                </div>
                            </div>
                        </div>
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'staff-promote-store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'student_promote_submit']) }}
                        <input type="hidden" name="current_session" value="{{$current_department}}">
                        <input type="hidden" name="current_class" value="{{$current_designation}}">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="display school-table school-table-style" cellspacing="0" width="100%">
                                    <thead>
                                    @if(session()->has('message-danger-table') != "" || session()->has('message-success') != "")
                                        <tr>
                                            <td colspan="5">
                                                @if(session()->has('message-danger-table'))
                                                    <div class="alert alert-danger">
                                                        {{ session()->get('message-danger-table') }}
                                                    </div>
                                                @else
                                                    <div class="alert alert-success">
                                                        {{ session()->get('message-success') }}
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th width="10%">
                                            <span class="all_check btn btn-sm fix-gr-bg"
                                                  id="all_check"> Select All </span>
                                        </th>
                                        <th>@lang('lang.admission') @lang('lang.no')</th>
                                        <th>@lang('lang.class')/@lang('lang.section')</th>
                                        <th>@lang('lang.name')</th>
                                        <th>@lang('lang.current') @lang('lang.result')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach( @$staffs['staffs'] ? @$staffs['staffs']: $staffs  as $staff)
                                        @php
                                        //    $department = \App\SmStaff::find($staff['department_id']);
                                        @endphp
                                        <tr>
                                            <td>
                                                <input type="checkbox" id="student.{{@$staff['id']}}"
                                                       class="{{--common-checkbox--}} generate-id-card-print" name="id[]"
                                                       value="{{@$staff['id']}}">
                                                <label for="student.{{@$staff['id']}}"></label>
                                            </td>
                                            <td>{{@$staff['admission_no']}}</td>
                                            @if (@$class->class_name)
                                                <td>{{@$class->class_name !=""?@$class->class_name:""}}</td>
                                            @else
                                                <td>{{@$class->className !=""?@$class->className->class_name:""}}</td>
                                            @endif
                                            <td>{{@$staff['full_name']}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="5">
                                            <div class="row mt-30">
                                                <div class="col-lg-3">
                                                    <select class="niceSelect w-100 bb promote_session form-control{{ $errors->has('promote_session') ? ' is-invalid' : '' }}"
                                                            name="promote_session" id="promote_session">
                                                        <option data-display="@lang('lang.select') @lang('lang.academic_year') *"
                                                                value="">@lang('lang.select') @lang('lang.academic_year')
                                                            *
                                                        </option>
                                                        @foreach($Upsessions as $session)
                                                            @if (@$current_session != $session->id)
                                                                <option value="{{$session->id}}" {{( old("promote_session") == $session->id ? "selected":"")}}>{{$session->year}}
                                                                    -{{$session->year+1}}</option> //add more year
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger d-none" role="alert"
                                                          id="promote_session_error">
                                                        <strong>@lang('lang.the_session_is_required')</strong>
                                                    </span>
                                                </div>
                                                <div class="col-lg-3 " id="select_class_div">
                                                    <select class="niceSelect w-100 bb" name="promote_class"
                                                            id="select_class">
                                                        <option data-display="@lang('lang.select_class')"
                                                                value="">@lang('lang.select_class')</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3 " id="select_section_div">
                                                    <select class="niceSelect w-100 bb" id="select_section"
                                                            name="promote_section">
                                                        <option data-display="@lang('lang.select_section')"
                                                                value="">@lang('lang.select_section')</option>
                                                    </select>
                                                </div>
                                                @if(in_array(82, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )
                                                    <div class="col-lg-3 text-center">
                                                        <button type="submit" class="primary-btn fix-gr-bg"
                                                                id="student_promote_submit">
                                                            <span class="ti-check"></span>
                                                            @lang('lang.promote')
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </section>
    @endif

    <script>


    </script>

@endsection
