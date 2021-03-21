
@extends('backEnd.master')
@section('mainContent')

    @php
        function showPicName($data){
        $name = explode('/', $data);
        return $name[3];
        }
    @endphp
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('lang.to_do_list')</h1>
                <div class="bc-pages">
                    <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                    <a href="#">@lang('lang.communicate')</a>
                    <a href="#">@lang('lang.to_do_list')</a>
                </div>
            </div>
        </div>
    </section>
    <div class="row" style="margin-left: 1455px;">

        <button  data-toggle="modal" class="primary-btn small fix-gr-bg" data-target="#buttonModal" title="Add" data-modal-size="modal-md">
            <span class="ti-plus pr-2"></span>
            @lang('lang.add')
        </button>

        <!-- Modal -->
        <div class="modal fade" id="buttonModal" tabindex="-1" role="dialog" aria-labelledby="ModalNewTask"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'addNewTask', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}

                <div class="modal-content" style="height: 725px;width: 700px;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalNewTask">Add New Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;close</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-12">
                                <label>@lang('Name') <span>*</span> </label>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class=" form-control date" cols="0" rows="3" name="name"
                                           id="grade1">{{old('name')}}</input>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-6">
                                <label>@lang('Start Date') <span></span> </label>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <div class="input-effect">
                                        <input class="primary-input date form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" id="date" type="text"
                                               placeholder=" @lang('lang.starting_date') *" name="date" value="{{isset($academic_year)? date('m/d/Y',strtotime($academic_year->starting_date)): date('m/d/Y')}}">
                                        <span class="focus-border"></span>
                                        @if ($errors->has('date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>@lang('Due Date') <span></span> </label>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input date form-control" cols="0" rows="3" name="due_date"
                                           id="grade1">{{old('due_date')}}</input>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('due_date'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('due_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-12">
                                <label>@lang('Priority') <span></span> </label>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <select class="niceSelect w-100 bb form-control " cols="0" rows="3" name="complete_status"
                                           id="grade1">
                                        <option data-display="Select priority *" value="">@lang('Select priority') *</option>
                                        <option value="Not Started">Not Started</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Testing">Testing</option>
                                        <option value="Await Feedback">Await Feedback</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('complete_status'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('complete_status') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mt-30">
                            <div class="col-lg-12">
                                <div class="input-effect">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('assign') ? ' is-invalid' : '' }}" name="assign_staff_id" id="assign">
                                        <option data-display="@lang('lang.assign') @lang('to') *" value="">@lang('lang.assign') @lang('to')</option>
                                        @foreach($assigns_to as $rows)
                                            <option value="{{@$rows->id}}"
                                            >{{@$rows->full_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-12">
                                <label>@lang('Description') <span></span> </label>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class=" form-control date" cols="0" rows="3" name="description"
                                           id="grade1">{{old('description')}}</input>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" style="background: darkorange">Submit
                        </button>
                    </div>
                </div>

                {{ Form::close() }}
            </div>
        </div>
        </div>
    <div class="row">
        @if(in_array(2, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

            <div class="col-lg-2 col-md-6 col-sm-6">
                <a href="#" class="d-block">
                    <div class="white-box single-summery">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3>@lang('Not Started')</h3>
                                <p class="mb-0">@lang('lang.total') @lang('lang.assign')</p>
                            </div>
                            <h1 class="gradient-color2">
                                @if(isset($totalNotStarts))
                                    {{count($totalNotStarts)}}
                                @endif
                            </h1>
                        </div>
                    </div>
                </a>
            </div>
        @endif
        @if(in_array(3, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

            <div class="col-lg-2 col-md-6 col-sm-6">
                <a href="#" class="d-block">
                    <div class="white-box single-summery">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3>@lang('In Progress')</h3>
                                <p class="mb-0">@lang('lang.total') @lang('lang.pending')</p>
                            </div>
                            <h1 class="gradient-color2">
                                @if(isset($totalPending))
                                    {{count($totalPending)}}
                                @endif</h1>
                        </div>
                    </div>
                </a>
            </div>
        @endif
        @if(in_array(4, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
            {{-- mt-30-md --}}
            <div class="col-lg-2 col-md-6 col-sm-6">
                <a href="#" class="d-block">
                    <div class="white-box single-summery">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3>@lang('Testing')</h3>
                                <p class="mb-0">@lang('lang.total') @lang('Testing')</p>
                            </div>
                            <h1 class="gradient-color2">
                                @if(isset($totalTests))
                                    {{count($totalTests)}}
                                @endif</h1>
                        </div>
                    </div>
                </a>
            </div>
        @endif
        @if(in_array(5, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="#" class="d-block">
                    <div class="white-box single-summery">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3>@lang(' Awaiting Feedback')</h3>
                                <p class="mb-0">@lang('lang.total') @lang('Feedback')</p>
                            </div>
                            <h1 class="gradient-color2">
                                @if(isset($totalAwaits))
                                    {{count($totalAwaits)}}
                                @endif
                            </h1>
                        </div>
                    </div>
                </a>
            </div>
        @endif
        @if(in_array(6, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="#" class="d-block">
                    <div class="white-box single-summery">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3>@lang('lang.complete')</h3>
                                <p class="mb-0">@lang('lang.total') @lang('lang.complete')</p>
                            </div>
                            <h1 class="gradient-color2">
                                @if(isset($totalCompletes))
                                    {{count($totalCompletes)}}
                                @endif
                            </h1>
                        </div>
                    </div>
                </a>
            </div>
        @endif

    </div>

    <br>
    <br>

    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            @if(isset($editData))
                @if(in_array(295, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )

                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                            <a href="{{url('event')}}" class="primary-btn small fix-gr-bg">
                                <span class="ti-plus pr-2"></span>
                                @lang('lang.add')
                            </a>
                        </div>
                    </div>
                @endif
            @endif
            <div class="row">
                {{--                <div class="col-lg-3">--}}
                {{--                    <div class="row">--}}
                {{--                        <div class="col-lg-12">--}}
                {{--                            <div class="main-title">--}}
                {{--                                <h3 class="mb-30">@if(isset($editData))--}}
                {{--                                        @lang('lang.edit')--}}
                {{--                                    @else--}}
                {{--                                        @lang('lang.add')--}}
                {{--                                    @endif--}}
                {{--                                    @lang('lang.event')--}}
                {{--                                </h3>--}}
                {{--                            </div>--}}
                {{--                            @if(isset($editData))--}}
                {{--                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'event/'.$editData->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}--}}
                {{--                            @else--}}
                {{--                                @if(in_array(295, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )--}}

                {{--                                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'event',--}}
                {{--                                    'method' => 'POST', 'enctype' => 'multipart/form-data']) }}--}}
                {{--                                @endif--}}
                {{--                            @endif--}}
                {{--                            <div class="white-box">--}}
                {{--                                <div class="add-visitor">--}}
                {{--                                    <div class="row">--}}
                {{--                                        @if(session()->has('message-success'))--}}
                {{--                                            <div class="alert alert-success">--}}
                {{--                                                {{ session()->get('message-success') }}--}}
                {{--                                            </div>--}}
                {{--                                        @elseif(session()->has('message-danger'))--}}
                {{--                                            <div class="alert alert-danger">--}}
                {{--                                                {{ session()->get('message-danger') }}--}}
                {{--                                            </div>--}}
                {{--                                        @endif--}}

                {{--                                        <div class="col-lg-12 mb-20">--}}
                {{--                                            <div class="input-effect">--}}
                {{--                                                <input class="primary-input form-control{{ $errors->has('event_title') ? ' is-invalid' : '' }}"--}}
                {{--                                                       type="text" name="event_title" autocomplete="off" value="{{isset($editData)? $editData->event_title : '' }}">--}}
                {{--                                                <label>@lang('lang.event') @lang('lang.title') <span>*</span> </label>--}}
                {{--                                                <span class="focus-border"></span>--}}
                {{--                                                @if ($errors->has('event_title'))--}}
                {{--                                                    <span class="invalid-feedback" role="alert">--}}
                {{--                                                <strong>{{ $errors->first('event_title') }}</strong>--}}
                {{--                                            </span>--}}
                {{--                                                @endif--}}
                {{--                                            </div>--}}
                {{--                                        </div>--}}

                {{--                                        <div class="col-lg-12 mb-20">--}}

                {{--                                            <select class="w-100 bb niceSelect form-control {{ $errors->has('for_whom') ? ' is-invalid' : '' }}" id="for_whom" name="for_whom">--}}
                {{--                                                <option data-display="@lang('lang.for_whom') *" value="">@lang('lang.for_whom') *</option>--}}

                {{--                                                <option value="All" {{isset($editData)? ($editData->for_whom == 'All'? 'selected' : ''):"" }}>@lang('lang.all')</option>--}}
                {{--                                                <option value="Teacher" {{isset($editData)? ($editData->for_whom == 'Teacher'? 'selected' : ''):"" }}>@lang('lang.teacher')</option>--}}
                {{--                                                <option value="Student" {{isset($editData)? ($editData->for_whom == 'Student'? 'selected' : ''):"" }}>@lang('lang.student')</option>--}}
                {{--                                                <option value="Parents" {{isset($editData)? ($editData->for_whom == 'Parents'? 'selected' : ''):"" }}>@lang('lang.parents')</option>--}}


                {{--                                            </select>--}}
                {{--                                            @if ($errors->has('for_whom'))--}}
                {{--                                                <span class="invalid-feedback invalid-select" role="alert">--}}
                {{--                                            <strong>{{ $errors->first('for_whom') }}</strong>--}}
                {{--                                        </span>--}}
                {{--                                            @endif--}}

                {{--                                        </div>--}}
                {{--                                        <div class="col-lg-12 mb-20">--}}
                {{--                                            <div class="input-effect">--}}
                {{--                                                <input class="primary-input form-control{{ $errors->has('event_location') ? ' is-invalid' : '' }}"--}}
                {{--                                                       type="text" name="event_location" autocomplete="off" value="{{isset($editData)? $editData->event_location : '' }}">--}}
                {{--                                                <label>@lang('lang.event') @lang('lang.location') <span>*</span> </label>--}}
                {{--                                                <span class="focus-border"></span>--}}
                {{--                                                @if ($errors->has('event_location'))--}}
                {{--                                                    <span class="invalid-feedback" role="alert">--}}
                {{--                                                <strong>{{ $errors->first('event_location') }}</strong>--}}
                {{--                                            </span>--}}
                {{--                                                @endif--}}
                {{--                                            </div>--}}

                {{--                                        </div>--}}

                {{--                                        <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">--}}

                {{--                                    </div>--}}
                {{--                                    <div class="row no-gutters input-right-icon mb-30">--}}
                {{--                                        <div class="col">--}}
                {{--                                            <div class="input-effect">--}}
                {{--                                                <input class="primary-input date form-control{{ $errors->has('from_date') ? ' is-invalid' : '' }}" id="event_from_date" type="text"--}}
                {{--                                                       name="from_date" value="{{isset($editData)? date('m/d/Y', strtotime($editData->from_date)): ''}}" autocomplete="off">--}}
                {{--                                                <label>@lang('lang.start_date')<span>*</span> </label>--}}
                {{--                                                <span class="focus-border"></span>--}}
                {{--                                                @if ($errors->has('from_date'))--}}
                {{--                                                    <span class="invalid-feedback" role="alert">--}}
                {{--                                                <strong>{{ $errors->first('from_date') }}</strong>--}}
                {{--                                            </span>--}}
                {{--                                                @endif--}}
                {{--                                            </div>--}}

                {{--                                        </div>--}}
                {{--                                        <div class="col-auto">--}}
                {{--                                            <button class="" type="button">--}}
                {{--                                                <i class="ti-calendar" id="event_start_date"></i>--}}
                {{--                                            </button>--}}
                {{--                                        </div>--}}
                {{--                                    </div>--}}

                {{--                                    <div class="row no-gutters input-right-icon mb-30">--}}
                {{--                                        <div class="col">--}}
                {{--                                            <div class="input-effect">--}}
                {{--                                                <input class="primary-input date form-control{{ $errors->has('to_date') ? ' is-invalid' : '' }}" id="event_to_date" type="text"--}}
                {{--                                                       name="to_date" value="{{isset($editData)? date('m/d/Y', strtotime($editData->to_date)): '' }}" autocomplete="off">--}}
                {{--                                                <label>@lang('lang.to_date')<span>*</span> </label>--}}
                {{--                                                <span class="focus-border"></span>--}}
                {{--                                                @if ($errors->has('to_date'))--}}
                {{--                                                    <span class="invalid-feedback" role="alert">--}}
                {{--                                                <strong>{{ $errors->first('to_date') }}</strong>--}}
                {{--                                            </span>--}}
                {{--                                                @endif--}}
                {{--                                            </div>--}}

                {{--                                        </div>--}}
                {{--                                        <div class="col-auto">--}}
                {{--                                            <button class="" type="button">--}}
                {{--                                                <i class="ti-calendar" id="event_end_date"></i>--}}
                {{--                                            </button>--}}
                {{--                                        </div>--}}
                {{--                                    </div>--}}

                {{--                                    <div class="row mb-20">--}}
                {{--                                        <div class="col-lg-12">--}}
                {{--                                            <div class="input-effect">--}}
                {{--                                                <textarea class="primary-input form-control {{ $errors->has('event_des') ? ' is-invalid' : '' }}" cols="0" rows="4" name="event_des">{{isset($editData)? $editData->event_des: ''}}</textarea>--}}
                {{--                                                <label>@lang('lang.description') <span>*</span> </label>--}}
                {{--                                                <span class="focus-border textarea"></span>--}}
                {{--                                                @if ($errors->has('event_des'))--}}
                {{--                                                    <span class="invalid-feedback" role="alert">--}}
                {{--                                                <strong>{{ $errors->first('event_des') }}</strong>--}}
                {{--                                            </span>--}}
                {{--                                                @endif--}}
                {{--                                            </div>--}}
                {{--                                        </div>--}}
                {{--                                    </div>--}}
                {{--                                    <div class="row no-gutters input-right-icon mb-20">--}}
                {{--                                        <div class="col">--}}
                {{--                                            <div class="input-effect">--}}
                {{--                                                <input class="primary-input form-control {{ $errors->has('content_file') ? ' is-invalid' : '' }}" name="upload_file_name" type="text"--}}
                {{--                                                       placeholder="{{isset($editData->uplad_image_file) && $editData->uplad_image_file != ""? showPicName($editData->uplad_image_file):'Attach File'}}"--}}
                {{--                                                       id="placeholderEventFile" readonly>--}}
                {{--                                                <span class="focus-border"></span>--}}
                {{--                                                @if ($errors->has('upload_file_name'))--}}
                {{--                                                    <span class="invalid-feedback d-block" role="alert">--}}
                {{--                                                <strong>{{ $errors->first('upload_file_name') }}</strong>--}}
                {{--                                            </span>--}}
                {{--                                                @endif--}}
                {{--                                            </div>--}}
                {{--                                        </div>--}}
                {{--                                        <div class="col-auto">--}}
                {{--                                            <button class="primary-btn-small-input" type="button">--}}
                {{--                                                <label class="primary-btn small fix-gr-bg" for="upload_event_image">@lang('lang.browse')</label>--}}
                {{--                                                <input type="file" class="d-none form-control" name="upload_file_name" id="upload_event_image" readonly="">--}}
                {{--                                            </button>--}}

                {{--                                        </div>--}}
                {{--                                    </div>--}}
                {{--                                    @php--}}
                {{--                                        $tooltip = "";--}}
                {{--                                        if(in_array(295, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 ){--}}
                {{--                                              $tooltip = "";--}}
                {{--                                          }else{--}}
                {{--                                              $tooltip = "You have no permission to add";--}}
                {{--                                          }--}}
                {{--                                    @endphp--}}
                {{--                                    <div class="row mt-40">--}}
                {{--                                        <div class="col-lg-12 text-center">--}}
                {{--                                            <button class="primary-btn fix-gr-bg" data-toggle="tooltip" title="{{ @$tooltip}}">--}}
                {{--                                                <span class="ti-check"></span>--}}
                {{--                                                @if(isset($editData))--}}
                {{--                                                    @lang('lang.update')--}}
                {{--                                                @else--}}
                {{--                                                    @lang('lang.save')--}}
                {{--                                                @endif--}}
                {{--                                            </button>--}}
                {{--                                        </div>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                            {{ Form::close() }}--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                <div class="col-lg-12">
                    @if(session()->has('message-success-delete'))
                        <div class="alert alert-success">
                            {{ session()->get('message-success-delete') }}
                        </div>
                    @elseif(session()->has('message-danger-delete'))
                        <div class="alert alert-danger">
                            {{ session()->get('message-danger-delete') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">@lang('lang.event') @lang('lang.list')</h3>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-lg-12">
                            <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                                <thead>
                                <tr>
                                    <th>@lang('lang.name')</th>
                                    <th>@lang('lang.status')</th>
                                    <th>@lang('lang.start_date')</th>
                                    <th>@lang('lang.due_date')</th>
                                    <th>@lang('lang.assign') @lang('lang.to')</th>
                                    <th>@lang('lang.description')</th>
                                    <th>@lang('lang.action')</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if(isset($assigns))
                                    @foreach($assigns as $value)
                                        <?php
                                        $assign_to = \App\SmStaff::find($value->assign_staff_id);
                                        ?>
                                        <tr>

                                            <input type="hidden" value="{{@$value->id}}">
                                            <td>{{ @$value->todo_title}}</td>
                                            @if($value->complete_status == 'Not Started')
                                                <td> <select class="btn btn-sm" id="select_task" name="complete_status" style="background-color: #7f8ea1;color: whitesmoke;border-radius: 20px">{{ @$value->complete_status}}
                                                        <option value="{{@$value->id}},Not Started" >Not Started</option>
                                                        <option value="{{@$value->id}},Pending">Pending</option>
                                                        <option value="{{@$value->id}},Testing">Testing</option>
                                                        <option value="{{@$value->id}},Await Feedback">Await Feedback</option>
                                                        <option value="{{@$value->id}},Completed">Completed</option>
                                                    </select>
                                                </td>
                                                @elseif($value->complete_status == 'Completed')
                                                <td> <select  class="btn btn-sm btn-success" style="color: whitesmoke;border-radius: 20px">{{ @$value->complete_status}}
                                                        <option value="{{@$value->id}},Completed">Completed</option>
                                                        <option value="{{@$value->id}},Not Started" >Not Started</option>
                                                        <option value="{{@$value->id}},Pending">Pending</option>
                                                        <option value="{{@$value->id}},Testing">Testing</option>
                                                        <option value="{{@$value->id}},Await Feedback">Await Feedback</option>
                                                    </select></td>
                                                @elseif($value->complete_status == 'Pending')
                                                <td> <select class="btn btn-sm btn-warning" style="color: whitesmoke;border-radius: 20px">{{ @$value->complete_status}}
                                                        <option value="{{@$value->id}},Pending" style="padding: 10px">Pending</option>
                                                        <option value="{{@$value->id}},Not Started" >Not Started</option>
                                                        <option value="{{@$value->id}},Testing">Testing</option>
                                                        <option value="{{@$value->id}},Await Feedback">Await Feedback</option>
                                                        <option value="{{@$value->id}},Completed">Completed</option>
                                                    </select></td>
                                                @elseif($value->complete_status == 'Await Feedback')
                                                <td> <select class="btn btn-sm btn-info" style="color: whitesmoke;border-radius: 20px">{{ @$value->complete_status}}
                                                        <option value="{{@$value->id}},Await Feedback">Await Feedback</option>
                                                        <option value="{{@$value->id}},Not Started" >Not Started</option>
                                                        <option value="{{@$value->id}},Pending">Pending</option>
                                                        <option value="{{@$value->id}},Testing">Testing</option>
                                                        <option value="{{@$value->id}},Completed">Completed</option>
                                                    </select></td>
                                            @elseif($value->complete_status == 'Testing')
                                                <td> <select class="btn btn-sm btn-primary" style="color: whitesmoke;border-radius: 20px">{{ @$value->complete_status}}
                                                        <option value="{{@$value->id}},Testing">Testing</option>
                                                        <option value="{{@$value->id}},Not Started" >Not Started</option>
                                                        <option value="{{@$value->id}},Pending">Pending</option>
                                                        <option value="{{@$value->id}},Await Feedback">Await Feedback</option>
                                                        <option value="{{@$value->id}},Completed">Completed</option>
                                                    </select></td>
                                            @endif
                                            <td>{{ @$value->date != ""? App\SmGeneralSettings::DateConvater(@$value->date):''}}</td>


                                            <td data-sort="{{strtotime(@$value->due_date)}}">{{$value->due_date != ""? App\SmGeneralSettings::DateConvater(@$value->due_date):''}}</td>

                                            <td>{{ @$assign_to->full_name}}</td>
                                            <td>{{ @$value->description}}</td>

                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn dropdown-toggle"
                                                            data-toggle="dropdown">
                                                        @lang('lang.select')
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if(in_array(296, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1  )

{{--                                                            <a class="dropdown-item"--}}
{{--                                                               href="{{url('event/'.$value->id.'/edit')}}">@lang('lang.edit')</a>--}}

                                                            <a class="dropdown-item" data-toggle="modal" data-target="#editModal-{{$value->id}}" href="{{url('edit-toDo/'.$value->id)}}">@lang('lang.edit')</a>


                                                        @endif

                                                        @if(in_array(297, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1  )
                                                            <a class="deleteUrl dropdown-item"
                                                               data-modal-size="modal-md" title="Delete Task"
                                                               href="{{url('delete-todo-list/'.$value->id)}}">@lang('lang.delete')</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="editModal-{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="ModalNewTask"
                                             aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'updateToDo', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}

                                                <div class="modal-content" style="height: 725px;width: 700px;">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="ModalNewTask">Edit Task</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;close</span>
                                                        </button>
                                                    </div>
                                                    <input type="hidden" name="to_do_id" value="{{$value->id}}" />
                                                    <div class="modal-body">
                                                        <div class="row mb-30 mt-30">
                                                            <div class="col-lg-12">
                                                                <label>@lang('Name') <span>*</span> </label>
                                                                <div class="input-effect sm2_mb_20 md_mb_20">
                                                                    <input class=" form-control date" cols="0" rows="3" name="name"
                                                                           id="grade1" autocomplete="off" value="{{isset($value)? $value->todo_title: old('todo_title')}}">
                                                                    </input>
                                                                    <span class="focus-border textarea"></span>
                                                                    @if ($errors->has('name'))
                                                                        <span class="invalid-feedback">
                                                                            <strong>{{ $errors->first('name') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-30 mt-30">
                                                            <div class="col-lg-6">
                                                                <label>@lang('Start Date') <span></span> </label>
                                                                <div class="input-effect sm2_mb_20 md_mb_20">
                                                                    <div class="input-effect">
                                                                        <input class="primary-input date form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" id="date" type="text"
                                                                               placeholder=" @lang('lang.starting_date') *" name="date" value="{{isset($academic_year)? date('m/d/Y',strtotime($academic_year->starting_date)): date('m/d/Y')}}">
                                                                        <span class="focus-border"></span>
                                                                        @if ($errors->has('date'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('date') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label>@lang('Due Date') <span></span> </label>
                                                                <div class="input-effect sm2_mb_20 md_mb_20">
                                                                    <input class="primary-input date form-control" cols="0" rows="3" name="due_date"
                                                                           id="grade1" autocomplete="off" value="{{isset($value)? $value->due_date: old('due_date')}}"></input>
                                                                    <span class="focus-border textarea"></span>
                                                                    @if ($errors->has('due_date'))
                                                                        <span class="invalid-feedback">
                                                                            <strong>{{ $errors->first('due_date') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-30 mt-30">
                                                            <div class="col-lg-12">
                                                                <label>@lang('Priority') <span></span> </label>
                                                                <div class="input-effect sm2_mb_20 md_mb_20">
                                                                    <select class="niceSelect w-100 bb form-control " cols="0" rows="3" name="complete_status"
                                                                            id="grade1">
                                                                        <option data-display="{{isset($value)? $value->complete_status: old('complete_status')}}" value="{{isset($value)? $value->complete_status: old('complete_status')}}"></option>
                                                                        <option value="Not Started">Not Started</option>
                                                                        <option value="Pending">Pending</option>
                                                                        <option value="Testing">Testing</option>
                                                                        <option value="Await">Await Feedback</option>
                                                                        <option value="Completed">Completed</option>
                                                                    </select>
                                                                    <span class="focus-border textarea"></span>
                                                                    @if ($errors->has('complete_status'))
                                                                        <span class="invalid-feedback">
                                                                            <strong>{{ $errors->first('complete_status') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        //                        dd($assigns);
                                                        ?>
                                                        <div class="row mt-30">
                                                            <div class="col-lg-12">
                                                                <div class="input-effect">
                                                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('assign') ? ' is-invalid' : '' }}" name="assign_staff_id" id="assign">
                                                                        <option data-display="{{isset($assign_to)? $assign_to->full_name: old('full_name')}}" value="">@lang('lang.assign') @lang('to')</option>
                                                                        @foreach($assigns_to as $rows)
                                                                            <option value="{{@$rows->id}}"
                                                                            >{{@$rows->full_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-30 mt-30">
                                                            <div class="col-lg-12">
                                                                <label>@lang('Description') <span></span> </label>
                                                                <div class="input-effect sm2_mb_20 md_mb_20">
                                                                    <input class=" form-control date" cols="0" rows="3" name="description"
                                                                           id="grade1" autocomplete="off" value="{{isset($value)? $value->description: old('description')}}"></input>
                                                                    <span class="focus-border textarea"></span>
                                                                    @if ($errors->has('description'))
                                                                        <span class="invalid-feedback">
                                                                            <strong>{{ $errors->first('description') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary" style="background: darkorange">Update
                                                        </button>
                                                    </div>
                                                </div>

                                                {{ Form::close() }}
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<script>
    $(document).ready(function () {
        $('#table_id').on( 'change', 'tr', function () {
            // source codex
            alert('hi');
        });
    });


</script>
