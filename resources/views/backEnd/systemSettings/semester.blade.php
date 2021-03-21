@extends('backEnd.master')
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('Semester')</h1>
                <div class="bc-pages">
                    <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                    <a href="#">@lang('lang.system_settings')</a>
                    <a href="{{url('semester')}}">@lang('Semester')</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            @if(isset($semester))
                @if(in_array(266, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                            <a href="{{url('semester')}}" class="primary-btn small fix-gr-bg">
                                <span class="ti-plus pr-2"></span>
                                @lang('lang.add')
                            </a>
                        </div>
                    </div>
                @endif
            @endif
            <div class="row">
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h3 class="mb-30">@if(isset($semester))
                                        @lang('lang.edit')
                                    @else
                                        @lang('lang.add')
                                    @endif
                                    @lang('Semester')
                                </h3>
                            </div>
                            @if(isset($semester))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'semester_update', 'method' => 'POST']) }}
                            @else
                                @if(in_array(266, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )

                                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'semester_store', 'method' => 'POST']) }}
                                @endif
                            @endif
                            <div class="white-box">
                                <div class="add-visitor">
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
                                            <?php

                                            ?>
                                                <div class="row mt-40">
                                                    <div class="col-lg-12">
                                                        <div class="input-effect">
                                                            <select class="niceSelect w-100 bb form-control{{ $errors->has('academic_year') ? ' is-invalid' : '' }}" name="academic_year_id" id="academic_year_id">
                                                                <option data-display="@lang('lang.select') @lang('lang.academic') *" value="">@lang('lang.select') @lang('lang.academic')</option>
                                                                @foreach($academic_years as $row)
                                                                    <option value="{{@$row->id}}"
                                                                            @if (@$row->id == @$semester->academic_year_id)
                                                                            selected="selected"
                                                                            @endif
                                                                    >{{@$row->title}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="row mt-40">
                                                    <div class="col-lg-12">
                                                        <div class="input-effect">
                                                            <input class="primary-input form-control{{ @$errors->has('semester_code') ? ' is-invalid' : '' }}" type="text" name="semester_code" autocomplete="off" value="{{isset($semester)? $semester->semester_code: old('semester_code')}}">
                                                            <input type="hidden" name="id" value="{{isset($semester)? $semester->id: ''}}">
                                                            <label>@lang('Code')</label>
                                                            <span class="focus-border"></span>
                                                            @if ($errors->has('semester_code'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ @$errors->first('semester_code') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="row mt-40">
                                                <div class="col-lg-12">
                                                    <div class="input-effect">
                                                        <input class="primary-input form-control{{ @$errors->has('semester_name') ? ' is-invalid' : '' }}" type="text" name="semester_name" autocomplete="off" value="{{isset($semester)? $semester->semester_name: old('semester_name')}}">
                                                        <input type="hidden" name="id" value="{{isset($semester)? $semester->id: ''}}">
                                                        <label>@lang('lang.name') <span>*</span></label>
                                                        <span class="focus-border"></span>
                                                        @if ($errors->has('semester_name'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ @$errors->first('semester_name') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-40">
                                                <div class="col-lg-12">

                                                    <div class="input-effect">
                                                        <input class="primary-input form-control{{ $errors->has('semester_name_kh') ? ' is-invalid' : '' }}" type="text" name="semester_name_kh" autocomplete="off" value="{{isset($semester)? $semester->semester_name_kh: old('semester_name_kh')}}">
                                                        <label>@lang('Khmer Name') <span>*</span></label>
                                                        <span class="focus-border"></span>
                                                        @if ($errors->has('semester_name_kh'))
                                                            <span class="invalid-feedback" role="alert">
                                                             <strong>{{ $errors->first('semester_name_kh') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                                <div class="row no-gutters input-right-icon mt-25">
                                                    <div class="col">
                                                        <div class="input-effect">
                                                            <input class="primary-input date form-control{{ @$errors->has('start_date') ? ' is-invalid' : '' }}" type="text" name="start_date" value="{{isset($semester)? $semester->start_date: old('start_date')}}">
                                                            <label>@lang('Start Date') *</label>
                                                            <span class="focus-border"></span>
                                                            @if ($errors->has('start_time'))
                                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ @$errors->first('start_time') }}</strong>
                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <button class="" type="button">
                                                            <i class="ti-calendar"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="row no-gutters input-right-icon mt-25">
                                                    <div class="col">
                                                        <div class="input-effect">
                                                            <input class="primary-input date form-control{{ @$errors->has('end_date') ? ' is-invalid' : '' }}" type="text" name="end_date" value="{{isset($semester)? $semester->end_date: old('end_date')}}">
                                                            <label>@lang('End Date') <span>*</span></label>
                                                            <span class="focus-border"></span>
                                                            @if ($errors->has('end_date'))
                                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ @$errors->first('end_date') }}</strong>
                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <button class="" type="button">
                                                            <i class="ti-calendar"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    @php
                                        $tooltip = "";
                                        if(in_array(266, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 ){
                                              $tooltip = "";
                                          }else{
                                              $tooltip = "You have no permission to add";
                                          }
                                    @endphp
                                    <div class="row mt-40">
                                        <div class="col-lg-12 text-center">
                                            <button class="primary-btn fix-gr-bg" data-toggle="tooltip" title="{{@$tooltip}}">
                                                <span class="ti-check"></span>
                                                @if(isset($semester))
                                                    @lang('lang.update')
                                                @else
                                                    @lang('lang.save')
                                                @endif
                                                @lang('Semester')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">@lang('Semester') @lang('lang.list')</h3>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">

                            <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                                <thead>
                                @if(session()->has('message-success-delete') != "" ||
                                 session()->get('message-danger-delete') != "")
                                    <tr>
                                        <td colspan="3">
                                            @if(session()->has('message-success-delete'))
                                                <div class="alert alert-success">
                                                    {{ session()->get('message-success-delete') }}
                                                </div>
                                            @elseif(session()->has('message-danger-delete'))
                                                <div class="alert alert-danger">
                                                    {{ session()->get('message-danger-delete') }}
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>@lang('Code')</th>
                                    <th>@lang('lang.name')</th>
                                    <th>@lang('Khmer Name')</th>
                                    <th>@lang('Start Date')</th>
                                    <th>@lang('End Date')</th>
                                    <th>@lang('lang.note')</th>
                                    <th>@lang('lang.action')</th>
                                </tr>
                                </thead>

                                <tbody>

                                @foreach($semesters as $row)
                                    <?php
                                        $academic = \App\SmAcademicYear::find($row->academic_year_id);
                                    ?>
                                    <tr>
                                        <td>{{$row->semester_code}}</td>
                                        <td>{{$row->semester_name}}</td>
                                        <td>{{$row->semester_name_kh}}</td>
                                        <td>{{$row->start_date}}</td>
                                        <td>{{$row->end_date}}</td>
                                        <td>{{$academic->title}}</td>

                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                    @lang('lang.select')
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if(in_array(267, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )
                                                        <a class="dropdown-item" href="{{route('semester_edit', [$row->id])}}">@lang('lang.edit')</a>
                                                    @endif
                                                    @if(in_array(268, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )
                                                        <a class="dropdown-item" data-toggle="modal" data-target="#deleteSemesterModal{{$row->id}}"  href="#">@lang('lang.delete')</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade admin-query" id="deleteSemesterModal{{$row->id}}" >
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">@lang('lang.delete') @lang('Semester')</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        <h4>@lang('lang.are_you_sure_to_delete')</h4>
                                                    </div>

                                                    <div class="mt-40 d-flex justify-content-between">
                                                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('lang.cancel')</button>
                                                        <a href="{{route('semester_delete', [$row->id])}}" class="text-light">
                                                            <button class="primary-btn fix-gr-bg" type="submit">@lang('lang.delete')</button>
                                                        </a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
{{--                                    </div>--}}
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection