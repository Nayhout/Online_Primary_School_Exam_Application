@extends('backEnd.master')
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('Major') </h1>
                <div class="bc-pages">
                    <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                    <a href="#">@lang('Student Setting')</a>
                    <a href="majors">@lang('Major')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            @if(isset($major))
                @if(in_array(266, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                            <a href="{{url('majors')}}" class="primary-btn small fix-gr-bg">
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
                                <h3 class="mb-30">@if(isset($major))
                                        @lang('lang.edit')
                                    @else
                                        @lang('lang.add')
                                    @endif
                                    @lang('Major')
                                </h3>
                            </div>
                            @if(isset($major))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'majors_update', 'method' => 'POST']) }}
                            @else
                                @if(in_array(266, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )

                                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'majors_store', 'method' => 'POST']) }}
                                @endif
                            @endif
                            <div class="white-box">
                                <div class="add-visitor">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="input-effect">
                                                <select class="niceSelect w-100 bb form-control{{ $errors->has('faculty') ? ' is-invalid' : '' }}" name="faculty_id" id="faculty_id">
                                                    <option data-display="@lang('lang.select') @lang('faculty') *" value="">@lang('lang.select') @lang('faculty')</option>
                                                    @foreach($faculties as $row)
                                                        <option value="{{@$row->id}}"
                                                                @if ($row->id == @$major->faculty_id)
                                                                selected="selected"
                                                                @endif
                                                        >{{@$row->faculty_name_kh}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="input-effect">
                                                <input class="primary-input form-control{{ @$errors->has('major_code') ? ' is-invalid' : '' }}" type="text" name="major_code" autocomplete="off" value="{{isset($major)? $major->major_code: old('major_code')}}">
                                                <input type="hidden" name="id" value="{{isset($major)? $major->id: ''}}">
                                                <label>@lang('lang.code')</label>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('major_code'))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ @$errors->first('major_code') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="input-effect">
                                                <input class="primary-input form-control{{ @$errors->has('major_name') ? ' is-invalid' : '' }}" type="text" name="major_name" autocomplete="off" value="{{isset($major)? $major->major_name: old('major_name')}}">
                                                <input type="hidden" name="id" value="{{isset($major)? $major->id: ''}}">
                                                <label>@lang('lang.name') <span>*</span></label>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('major_name'))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ @$errors->first('major_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="input-effect">
                                                <input class="primary-input form-control{{ @$errors->has('major_name_kh') ? ' is-invalid' : '' }}" type="text" name="major_name_kh" autocomplete="off" value="{{isset($major)? $major->major_name_kh: old('major_name_kh')}}">
                                                <input type="hidden" name="id" value="{{isset($major)? $major->id: ''}}">
                                                <label>@lang('Khmer Name')</label>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('major_name_kh'))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ @$errors->first('major_name_kh') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="input-effect">
                                                <input class="primary-input form-control{{ @$errors->has('description') ? ' is-invalid' : '' }}" type="text" name="description" autocomplete="off" value="{{isset($major)? $major->description: old('description')}}">
                                                <input type="hidden" name="id" value="{{isset($major)? $major->id: ''}}">
                                                <label>@lang('lang.note')</label>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('description'))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ @$errors->first('description') }}</strong>
                                                </span>
                                                @endif
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
                                                @if(isset($major))
                                                    @lang('lang.update')
                                                @else
                                                    @lang('lang.save')
                                                @endif
                                                @lang('Major')
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
                                <h3 class="mb-0">@lang('Major') @lang('lang.list')</h3>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">

                            <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                                <thead>
                                    <tr>
                                        <th>@lang('Code')</th>
                                        <th>@lang('Major English')</th>
                                        <th>@lang('Major Khmer')</th>
                                        <th>@lang('Faculty English')</th>
                                        <th>@lang('Faculty Khmer')</th>
                                        <th>@lang('note')</th>
                                        <th>@lang('lang.action')</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach($majors as $major)
                                    <?php
                                        $faculty = \App\SmFaculty::find($major->faculty_id);
//                                        dd($faculty);
                                    ?>
                                    <tr>
                                        <td>{{@$major->major_code}}</td>
                                        <td>{{@$major->major_name}}</td>
                                        <td>{{@$major->major_name_kh}}</td>
                                        <td>{{@$faculty->faculty_name}}</td>
                                        <td>{{@$faculty->faculty_name_kh}}</td>
                                        <td>{{@$major->description}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                    @lang('lang.select')
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if(in_array(267, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )
                                                        <a class="dropdown-item" href="{{route('majors_edit', [@$major->id])}}">@lang('lang.edit')</a>
                                                    @endif
                                                    @if(in_array(268, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )
                                                        <a class="dropdown-item" data-toggle="modal" data-target="#deleteMajorModal{{@$major->id}}"  href="#">@lang('lang.delete')</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade admin-query" id="deleteMajorModal{{@$major->id}}" >
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">@lang('lang.delete') @lang('lang.major')</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        <h4>@lang('lang.are_you_sure_to_delete')</h4>
                                                    </div>

                                                    <div class="mt-40 d-flex justify-content-between">
                                                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('lang.cancel')</button>
                                                        <a href="{{route('majors_delete', [@$major->id])}}" class="text-light">
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
