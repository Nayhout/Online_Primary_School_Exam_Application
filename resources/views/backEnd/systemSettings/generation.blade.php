@extends('backEnd.master')
@section('mainContent')
    <section class="sms-breadcrumb mb-40 up_breadcrumb white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('Generation Student')</h1>
                <div class="bc-pages">
                    <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                    <a href="#">@lang('lang.system_settings')</a>
                    <a href="#">@lang('Generation Student')</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_admin_visitor full_wide_table">
        <div class="container-fluid p-0">
            <div class="row">
                @if(in_array(65, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )
                    <div class="col-lg-12 text-md-right text-left col-md-6 mb-30-lg col-sm-6 text_sm_right">
                        <a href="{{route('add-generate-student')}}" class="primary-btn small fix-gr-bg">
                            <span class="ti-plus pr-2"></span>
                            @lang('lang.add')
                        </a>
                    </div>
                @endif
            </div>

            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4 no-gutters">
                        <div class="main-title">
                            <h3 class="mb-0">Generation Student</h3>
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
                                <th>Academic</th>
                                <th>Note</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($generation as $row)
                                <?php
                                $active_status = 1;
                                ?>
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{optional($row)->generation_name}}</td>
                                    <td>{{optional($row)->generation_name_kh}}</td>
                                    <td>{{optional($row)->academic}}</td>
                                    <td>{{optional($row)->note}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                @lang('lang.select')
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="{{route('generate_edit', $row->id)}}">@lang('lang.edit')</a>
                                                {{--                                            @if(in_array(164, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )--}}

                                                {{--                                            @if(in_array(48, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                                                <a  class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteStaffModal{{$row->id}}" data-id="{{$row->id}}"  >@lang('lang.delete')</a>{{--                                            @endif--}}
                                                {{--                                            @endif--}}

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade admin-query" id="deleteStaffModal{{$row->id}}" >
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
                                                    <h4 class="text-danger">You are going to remove {{@$row->name}}. Removed data CANNOT be restored! Are you ABSOLUTELY Sure!</h4>
                                                    {{-- <div class="alert alert-warning">@lang('lang.student_delete_note')</div> --}}
                                                </div>

                                                <div class="mt-40 d-flex justify-content-between">
                                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('lang.cancel')</button>
                                                    <a href="{{url('generate-delete/'.$row->id)}}" class="text-light">
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
