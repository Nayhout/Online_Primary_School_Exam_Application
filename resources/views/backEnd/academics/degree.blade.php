@extends('backEnd.master')
@section('mainContent')

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('Degree')</h1>
                <div class="bc-pages">
                    <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                    <a href="#">@lang('lang.system_settings')</a>
                    <a href="{{url('degree')}}">@lang('Degree')</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            @if(isset($degree))
                @if(in_array(266, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                            <a href="{{url('degree')}}" class="primary-btn small fix-gr-bg">
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
                                <h3 class="mb-30">@if(isset($degree))
                                        @lang('lang.edit')
                                    @else
                                        @lang('lang.add')
                                    @endif
                                    @lang('Degree')
                                </h3>
                            </div>
                            @if(isset($degree))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'degree_update', 'method' => 'POST']) }}
                            @else
                                @if(in_array(266, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )

                                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'degree_store', 'method' => 'POST']) }}
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
                                                            <input class="primary-input form-control{{ @$errors->has('code') ? ' is-invalid' : '' }}" type="text" name="code" autocomplete="off" value="{{isset($degree)? $degree->code: old('code')}}">
                                                            <input type="hidden" name="id" value="{{isset($degree)? $degree->id: ''}}">
                                                            <label>@lang('lang.code')</label>
                                                            <span class="focus-border"></span>
                                                            @if ($errors->has('code'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ @$errors->first('code') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="row mt-40">
                                                <div class="col-lg-12">
                                                    <div class="input-effect">
                                                        <input class="primary-input form-control{{ @$errors->has('degree_name') ? ' is-invalid' : '' }}" type="text" name="degree_name" autocomplete="off" value="{{isset($degree)? $degree->degree_name: old('degree_name')}}">
                                                        <input type="hidden" name="id" value="{{isset($degree)? $degree->id: ''}}">
                                                        <label>@lang('lang.name') <span>*</span></label>
                                                        <span class="focus-border"></span>
                                                        @if ($errors->has('degree_name'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ @$errors->first('degree_name') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="row mt-40">
                                                    <div class="col-lg-12">
                                                        <div class="input-effect">
                                                            <input class="primary-input form-control{{ @$errors->has('degree_name_kh') ? ' is-invalid' : '' }}" type="text" name="degree_name_kh" autocomplete="off" value="{{isset($degree)? $degree->degree_name_kh: old('degree_name_kh')}}">
                                                            <input type="hidden" name="id" value="{{isset($degree)? $degree->id: ''}}">
                                                            <label>@lang('Khmer Name') <span>*</span></label>
                                                            <span class="focus-border"></span>
                                                            @if ($errors->has('degree_name_kh'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ @$errors->first('degree_name_kh') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

{{--                                            <div class="row mt-40">--}}
{{--                                                <div class="col-lg-12">--}}

{{--                                                    <div class="input-effect">--}}
{{--                                                        <input class="primary-input form-control{{ $errors->has('note') ? ' is-invalid' : '' }}" type="text" name="year" autocomplete="off" value="{{isset($degree)? $degree->year: old('year')}}">--}}
{{--                                                        <label>@lang('Year') <span>*</span></label>--}}
{{--                                                        <span class="focus-border"></span>--}}
{{--                                                        @if ($errors->has('year'))--}}
{{--                                                            <span class="invalid-feedback" role="alert">--}}
{{--                                                             <strong>{{ $errors->first('year') }}</strong>--}}
{{--                                                            </span>--}}
{{--                                                        @endif--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

                                            <div class="row mt-40">
                                                <div class="col-lg-12">

                                                    <div class="input-effect">
                                                        <input class="primary-input form-control{{ $errors->has('note') ? ' is-invalid' : '' }}" type="text" name="description" autocomplete="off" value="{{isset($degree)? $degree->description: old('description')}}">
                                                        <label>@lang('Description')</label>
                                                        <span class="focus-border"></span>
                                                        @if ($errors->has('description'))
                                                            <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $errors->first('description') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
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
                                                @if(isset($degree))
                                                    @lang('lang.update')
                                                @else
                                                    @lang('lang.save')
                                                @endif
                                                @lang('Degree')
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
                                <h3 class="mb-0">@lang('Degree') @lang('lang.list')</h3>
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
                                    <th>@lang('lang.code')</th>
                                    <th>@lang('lang.name')</th>
                                    <th>@lang('Khmer Name')</th>
                                    <th>@lang('lang.description')</th>
                                    <th>@lang('lang.action')</th>
                                </tr>
                                </thead>

                                <tbody>

                                @foreach($degrees as $row)
                                    <tr>
                                        <td>{{$row->code}}</td>
                                        <td>{{$row->degree_name}}</td>
                                        <td>{{$row->degree_name_kh}}</td>
                                        <td>{{$row->description}}</td>

                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                    @lang('lang.select')
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if(in_array(267, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )
                                                        <a class="dropdown-item" href="{{route('degree_edit', [$row->id])}}">@lang('lang.edit')</a>
                                                    @endif
                                                    @if(in_array(268, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )
                                                        <a class="dropdown-item" data-toggle="modal" data-target="#deleteDegreeModal{{$row->id}}"  href="#">@lang('lang.delete')</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade admin-query" id="deleteDegreeModal{{$row->id}}" >
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">@lang('lang.delete') @lang('Degree')</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        <h4>@lang('lang.are_you_sure_to_delete')</h4>
                                                    </div>

                                                    <div class="mt-40 d-flex justify-content-between">
                                                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('lang.cancel')</button>
                                                        <a href="{{route('degree_delete', [$row->id])}}" class="text-light">
                                                            <button class="primary-btn fix-gr-bg" type="submit">@lang('lang.delete')</button>
                                                        </a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
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
