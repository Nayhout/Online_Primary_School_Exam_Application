@extends('backEnd.master')
@section('mainContent')
    <style type="text/css">
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background: linear-gradient(90deg, #7c32ff 0%, #c738d8 51%, #7c32ff 100%);
        }

        input:focus + .slider {
            box-shadow: 0 0 1px linear-gradient(90deg, #7c32ff 0%, #c738d8 51%, #7c32ff 100%);
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
        /* th,td{
            font-size: 9px !important;
            padding: 5px !important

        } */
    </style>
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('Pickup List')</h1>
                <div class="bc-pages">
                    <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                    <a href="#">@lang('lang.admin_section')</a>
                    <a href="#">@lang('Pickup List')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-8 col-md-6 col-6">
                    <div class="main-title xs_mt_0 mt_0_sm">
                        <h3 class="mb-30">@lang('lang.select_criteria') </h3>
                    </div>
                </div>

                @if(in_array(162, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )

                    <div class="col-lg-4 text-md-right text-left col-md-6 mb-30-lg col-6 text_sm_right">
                        <a href="{{route('add_pickup')}}" class="primary-btn small fix-gr-bg">
                            <span class="ti-plus pr-2"></span>
                            @lang('Add Pick Up')
                        </a>
                    </div>
                @endif
            </div>
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
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'search_pickup', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        <div class="row">
                            <div class="col-lg-4">
                                <select class="niceSelect w-100 bb form-control" name="full_name" id="full_name">
                                    <option data-display="Select Name" value=""> @lang('lang.select') </option>
                                    @foreach($pickup_data as $key=>$pick)
                                        <option value="{{$pick->id}}">{{$pick->full_name}}</option>
                                    @endforeach
                                    <?php
//                                    dd($pickup_data);
                                    ?>
                                </select>
                            </div>

                            <div class="col-lg-4 mt-30-md">
                                <div class="col-lg-12">
                                    <div class="input-effect">
                                        <input class="primary-input" type="text" placeholder=" @lang('search by id')" name="pickup_no">
                                        <span class="focus-border"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 mt-30-md">
                                <div class="col-lg-12">
                                    <div class="input-effect">
                                        <input class="primary-input" type="text" placeholder="@lang('lang.search_by_name')" name="staff_name">
                                        <span class="focus-border"></span>
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
                </div>
            </div>

            <div class="row mt-40 full_wide_table">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-2 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">@lang('Pick Up') @lang('lang.list')</h3>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <a href="javascript:;" id="genearte-pickup-print-button" class="primary-btn small fix-gr-bg" >
                                @lang('Print Pick Up')
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                                <thead>
                                <th width="10%">
                                    <input type="checkbox" id="checkAll" class="common-checkbox generate-pickup-print-all" name="checkAll" value="">
                                    <label for="checkAll">@lang('lang.all')</label>
                                </th>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Khmer Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Link</th>
                                    <th>Student Name</th>
                                    <th>Student Khmer Name</th>
                                    <th>Action</th>
                                </thead>

                                <tbody>
                                @foreach($pickup as $p)
                                    <?php
//                                      dd(isset($arr_student));
                                    $student = isset($arr_student[$p->student_id]) ? $arr_student[$p->student_id] : null;

                                    ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" id="pickup.{{@$p->id}}" class="common-checkbox generate-pickup-print" name="student_checked[]" value="{{$p->id}}">
                                            <label for="student.{{@$p->id}}"></label>
                                        </td>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$p->full_name}}</td>
                                        <td>{{$p->khmer_name}}</td>
                                        <td>{{$p->email}}</td>
                                        <td>{{$p->mobile}}</td>
                                        <td>{{$p->facebook_url}}</td>
                                        <td>{{$student != null ? $student->full_name:''}}</td>
                                        <td>{{$student != null ? $student->bank_name:''}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                    @lang('lang.select')
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{route('viewPickup', $p->id)}}">@lang('lang.view')</a>
                                                    @if(in_array(164, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )

                                                        @if ($p->role_id != Auth::user()->role_id )

                                                            {{-- <a class="dropdown-item modalLink" title="Delete Staff" data-modal-size="modal-md" href="{{route('deleteStaffView', $value->id)}}">@lang('lang.delete')</a> --}}
                                                            <a  class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteStaffModal{{$p->id}}" data-id="{{$p->id}}"  >@lang('lang.delete')</a>

                                                        @endif
                                                    @endif

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade admin-query" id="deleteStaffModal{{$p->id}}" >
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Confirmation Required</h4>
                                                    {{-- <h4 class="modal-title">@lang('lang.delete') @lang('lang.value')</h4> --}}
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        {{-- <h4>@lang('lang.are_you_sure_to_delete')</h4> --}}
                                                        <h4 class="text-danger">You are going to remove {{@$p->first_name.' '.@$p->last_name}}. Removed data CANNOT be restored! Are you ABSOLUTELY Sure!</h4>
                                                        {{-- <div class="alert alert-warning">@lang('lang.student_delete_note')</div> --}}
                                                    </div>

                                                    <div class="mt-40 d-flex justify-content-between">
                                                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('lang.cancel')</button>
                                                        <a href="{{url('deletePickup/'.$p->id)}}" class="text-light">
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


