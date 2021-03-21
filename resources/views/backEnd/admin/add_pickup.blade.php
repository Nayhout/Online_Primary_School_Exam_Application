@extends('backEnd.master')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('public/backEnd/')}}/css/croppie.css">
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 up_breadcrumb white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('Pick Up Student')</h1>
            <div class="bc-pages">
                <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                <a href="#">@lang('lang.admin_section')</a>
                <a href="#">@lang('Pick Up Student')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-6 col-sm-6">
                <div class="main-title xs_mt_0 mt_0_sm">
                    <h3 class="mb-0">@lang('lang.add') @lang('Pick Up')</h3>
                </div>
            </div>
              @if(in_array(63, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )
               <div class="offset-lg-3 col-lg-3 text-right mb-20 col-sm-6">
                <a href="{{route('pick_up')}}" class="primary-btn small fix-gr-bg">
                    <span class="ti-arrow-circle-left pr-2"></span>
                    @lang('back')
                </a>
            </div>
            @endif
        </div>
        @if(in_array(65, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )
            {{ Form::open(['class' => 'form-horizontal studentadmission', 'files' => true, 'route' => 'pickup_store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'student_form']) }}
        @endif
        <div class="row">
            <div class="col-lg-12">
                <?php
                $is_erp = isset($_REQUEST['is_erp'])?$_REQUEST['is_erp']:0;
                ?>
                <input type="hidden" value="{{$is_erp}}" name="is_erp">
                @if(session()->has('message-success'))
                  <div class="alert alert-success">
                      {{ session()->get('message-success') }}
                  </div>
                @elseif(session()->has('message-danger'))
                  <div class="alert alert-danger">
                      {{ session()->get('message-danger') }}
                  </div>
                @endif
                <div class="white-box">
                    <div class="">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                @if($errors->any())
                                    @foreach ($errors->all() as $error)
                                    @if($error == "The email address has already been taken.")
                                        <div class="error text-danger ">{{ 'The email address has already been taken, You can find out in student list or disabled student list' }}</div>
                                    @endif
                                    @endforeach
                                @endif
                                @if ($errors->any())
                                     <div class="error text-danger ">{{ 'Something went wrong, please try again' }}</div>
                                @endif
                            </div>
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h4 class="stu-sub-head">@lang('lang.personal') @lang('lang.info')</h4>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                        <div class="row mb-40 mt-30">

                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('student') ? ' is-invalid' : '' }}" name="student">
                                        <option data-display="Student ID *" value="">@lang('lang.student') *</option>
                                        @foreach($students as $student)
                                            <option value="{{$student->id}}" {{old('student') == $student->id? 'selected': ''}}>{{$student->full_name}}({{$student->roll_no}})</option>
                                        @endforeach
                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('student'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('student') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" type="text" name="first_name" value="{{old('first_name')}}">
                                    <label>@lang('lang.first') @lang('lang.name') <span>*</span> </label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('first_name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" type="text" name="last_name" value="{{old('last_name')}}">
                                    <label>@lang('lang.last') @lang('lang.name') <span>*</span></label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('last_name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input" type="text" name="bank_name" value="{{old('bank_name')}}">
                                    <label>@lang('Khmer') @lang('name') </label>
                                    <span class="focus-border"></span>
                                </div>
                            </div>

                        </div>
                        <div class="row mb-40">



                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('gender_id') ? ' is-invalid' : '' }}" name="gender_id">
                                        <option data-display="Gender *" value="">@lang('lang.gender') *</option>
                                        @foreach($genders as $gender)
                                            <option value="{{$gender->id}}" {{old('gender_id') == $gender->id? 'selected': ''}}>{{$gender->base_setup_name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('gender_id'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                <strong>{{ $errors->first('gender_id') }}</strong>
                            </span>
                                    @endif
                                </div>
                            </div>


                            <div class="col-lg-3">
                                <div class="no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect sm2_mb_20 md_mb_20">
                                            <input class="primary-input date form-control{{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}" id="startDate" type="text"
                                                   name="date_of_birth" value="{{old('date_of_birth')}}" autocomplete="off">
                                            <label>@lang('lang.date_of_birth') *</label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('date_of_birth'))
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('date_of_birth') }}</strong>
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


                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email"  name="email" value="{{old('email')}}">
                                    <span class="focus-border"></span>
                                    <label>@lang('lang.email') <span>*</span> </label>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" type="text"  name="mobile" value="{{old('mobile')}}">
                                    <span class="focus-border"></span>
                                    <label>@lang('lang.mobile') <span>*</span> </label>
                                    @if ($errors->has('mobile'))
                                        <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('mobile') }}</strong>\
                                      </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="row mb-40">


                            <div class="col-lg-3">
                                <div class="row no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect sm2_mb_20 md_mb_20">
                                            <input class="primary-input form-control {{ $errors->has('pickup_photo') ? ' is-invalid' : '' }}" type="text" id="placeholderStaffsName"
                                                   placeholder="{{isset($editData->file) && $editData->file != '' ? showPicName($editData->file):'PickUp Photo *'}}"
                                                   disabled>
                                            <span class="focus-border"></span>

                                            @if ($errors->has('pickup_photo'))
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('pickup_photo') }}</strong>
                                    </span>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="primary-btn small fix-gr-bg" for="photo">@lang('lang.browse')</label>
                                            <input type="file" class="d-none" name="photo" id="photo">
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-effect" style="display: none">
                                    <input class="primary-input form-control{{ $errors->has('pick_no') ? ' is-invalid' : '' }}" type="text"  name="pickup_no" value="{{$max_pickup_no != ''? $max_pickup_no + 1 : 1}}" readonly>
                                    <span class="focus-border"></span>
                                    <label>@lang('Pickup No') <span>*</span> </label>
                                    @if ($errors->has('pickup_no'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('pickup_no') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 text-left" id="parent_info">
                                    <input type="hidden" name="parent_id" value="">

                                </div>
{{--                                <div class="col-lg-offset-3 text-right">--}}
{{--                                    <button class="primary-btn-small-input primary-btn small fix-gr-bg" type="button" data-toggle="modal" data-target="#editStudent">--}}
{{--                                        <span class="ti-plus pr-2"></span>--}}
{{--                                        @lang('lang.add') @lang('lang.parents')--}}
{{--                                    </button>--}}
{{--                                </div>--}}
                            </div>


                        </div>


                        <!-- Start Sibling Add Modal -->
                        <div class="modal fade admin-query" id="editStudent">
                            <div class="modal-dialog small-modal modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">@lang('lang.select') @lang('lang.sibling')</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            <form action="">
                                                <div class="row">
                                                    <div class="col-lg-12">

                                                        <div class="row">
                                                            <div class="col-lg-12" id="sibling_required_error">

                                                            </div>
                                                        </div>
                                                        <div class="row mt-25">
                                                            <div class="col-lg-12" id="sibling_class_div">
                                                                <select class="niceSelect w-100 bb" name="sibling_class" id="select_sibling_class">
                                                                    <option data-display="@lang('lang.class') *" value="">@lang('lang.class') *</option>
{{--                                                                    @foreach($classes as $class)--}}
{{--                                                                    <option value="{{$class->id}}" {{old('sibling_class') == $class->id? 'selected': '' }} >{{$class->class_name}}</option>--}}
{{--                                                                    @endforeach--}}
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row mt-25">
                                                            <div class="col-lg-12" id="sibling_section_div">
                                                                <select class="niceSelect w-100 bb" name="sibling_section" id="select_sibling_section">
                                                                    <option data-display="@lang('lang.section') *" value="">@lang('lang.section') *</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-25">
                                                            <div class="col-lg-12" id="sibling_name_div">
                                                                <select class="niceSelect w-100 bb" name="select_sibling_name" id="select_sibling_name">
                                                                    <option data-display="@lang('lang.sibling') *" value="">@lang('lang.sibling') *</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <!-- <div class="col-lg-12 text-center mt-40">
                                                        <button class="primary-btn fix-gr-bg" id="save_button_sibling" type="button">
                                                            <span class="ti-check"></span>
                                                            save information
                                                        </button>
                                                    </div> -->
                                                    <div class="col-lg-12 text-center mt-40">
                                                        <div class="mt-40 d-flex justify-content-between">
                                                            <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('lang.cancel')</button>

                                                            <button class="primary-btn fix-gr-bg" id="save_button_parent" data-dismiss="modal" type="button">@lang('lang.save') @lang('lang.information')</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- End Sibling Add Modal -->


                        <div class="row mt-40">
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h4>@lang('lang.social_links_details')</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-30">
                            <div class="col-lg-12">
                                <hr>
                            </div>
                        </div>
                        <div class="row mb-20">
                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input class="primary-input form-control{{ $errors->has('facebook_url') ? ' is-invalid' : '' }}" type="text" name="facebook_url" value={{old('facebook_url')}}>
                                    <label>@lang('lang.facebook_url')</label>
                                    <span class="focus-border"></span>

                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input class="primary-input form-control{{ $errors->has('twiteer_url') ? ' is-invalid' : '' }}" type="text"  name="twiteer_url" value="{{old('twiteer_url')}}">
                                    <label>@lang('lang.twitter_url')</label>
                                    <span class="focus-border"></span>

                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input class="primary-input form-control{{ $errors->has('linkedin_url') ? ' is-invalid' : '' }}" type="text"  name="linkedin_url" value="{{old('linkedin_url')}}">
                                    <label>@lang('lang.linkedin_url')</label>
                                    <span class="focus-border"></span>

                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input class="primary-input form-control{{ $errors->has('instragram_url') ? ' is-invalid' : '' }}" type="text"  name="instragram_url" value="{{old('instragram_url')}}">
                                    <label>@lang('lang.instragram_url')</label>
                                    <span class="focus-border"></span>

                                </div>
                            </div>

                        </div>



                        <div class="row mt-40">
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h4 class="stu-sub-head">@lang('lang.address') @lang('lang.info')</h4>
                                </div>
                            </div>
                        </div>


                        <div class="row mb-30 mt-30">
                            <div class="col-lg-6">

                                <div class="input-effect sm2_mb_20 md_mb_20 mt-20">
                                    <textarea class="primary-input form-control{{ $errors->has('current_address') ? ' is-invalid' : '' }}" cols="0" rows="3" name="current_address" id="current_address">{{old('current_address')}}</textarea>
                                    <label>@lang('lang.current') @lang('lang.address') <span></span> </label>
                                    <span class="focus-border textarea"></span>
                                   @if ($errors->has('current_address'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('current_address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">

                                <div class="input-effect sm2_mb_20 md_mb_20 mt-20">
                                    <textarea class="primary-input form-control{{ $errors->has('current_address') ? ' is-invalid' : '' }}" cols="0" rows="3" name="permanent_address" id="permanent_address">{{old('permanent_address')}}</textarea>
                                    <label>@lang('lang.permanent') @lang('lang.address')  <span></span> </label>
                                    <span class="focus-border textarea"></span>
                                   @if ($errors->has('permanent_address'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('permanent_address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="row mt-40">
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h4 class="stu-sub-head">@lang('lang.Other') @lang('lang.info')</h4>
                                </div>
                            </div>
                        </div>





                         <div class="row mb-40 mt-30">
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input form-control" type="text" name="document_title_1" value="{{old('document_title_1')}}">
                                    <label>@lang('lang.document_01_title')</label>
                                    <span class="focus-border"></span>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input" type="text" name="document_title_2" value="{{old('document_title_2')}}">
                                    <label>@lang('lang.document_02_title')</label>
                                    <span class="focus-border"></span>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input" type="text" name="document_title_3" value="{{old('document_title_3')}}">
                                    <label>@lang('lang.document_03_title')</label>
                                    <span class="focus-border"></span>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input" type="text" name="document_title_4" value="{{old('document_title_4')}}">
                                    <label>@lang('lang.document_04_title')</label>
                                    <span class="focus-border"></span>
                                </div>
                            </div>
                        </div>
                         <div class="row mb-30">
                             <div class="col-lg-3">
                                <div class="row no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect sm2_mb_20 md_mb_20">
                                            <input class="primary-input" type="text" id="placeholderFileOneName" placeholder="01"
                                                readonly="">
                                            <span class="focus-border"></span>
                                            @if ($errors->has('file'))
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ @$errors->first('file') }}</strong>
                                                        </span>
                                                @endif

                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="primary-btn small fix-gr-bg" for="document_file_1">@lang('lang.browse')</label>
                                            <input type="file" class="d-none" name="document_file_1" id="document_file_1">
                                        </button>
                                    </div>
                                </div>
                            </div>
                             <div class="col-lg-3">
                                <div class="row no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect sm2_mb_20 md_mb_20">
                                            <input class="primary-input" type="text" id="placeholderFileTwoName" placeholder="02"
                                                readonly="">
                                            <span class="focus-border"></span>
                                            @if ($errors->has('file'))
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ @$errors->first('file') }}</strong>
                                                        </span>
                                                @endif
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="primary-btn small fix-gr-bg" for="document_file_2">@lang('lang.browse')</label>
                                            <input type="file" class="d-none" name="document_file_2" id="document_file_2">
                                        </button>
                                    </div>
                                </div>
                            </div>
                             <div class="col-lg-3">
                                <div class="row no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect sm2_mb_20 md_mb_20">
                                            <input class="primary-input" type="text" id="placeholderFileThreeName" placeholder="03"
                                                readonly="">
                                            <span class="focus-border"></span>
                                            @if ($errors->has('file'))
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ @$errors->first('file') }}</strong>
                                                        </span>
                                                @endif
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="primary-btn small fix-gr-bg" for="document_file_3">@lang('lang.browse')</label>
                                            <input type="file" class="d-none" name="document_file_3" id="document_file_3">
                                        </button>
                                    </div>
                                </div>
                            </div>
                             <div class="col-lg-3">
                                <div class="row no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect sm2_mb_20 md_mb_20">
                                            <input class="primary-input" type="text" id="placeholderFileFourName" placeholder="04"
                                                readonly="">
                                            <span class="focus-border"></span>
                                            @if ($errors->has('file'))
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ @$errors->first('file') }}</strong>
                                                        </span>
                                                @endif
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="primary-btn small fix-gr-bg" for="document_file_4">@lang('lang.browse')</label>
                                            <input type="file" class="d-none" name="document_file_4" id="document_file_4">
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
	                        @php
                                  $tooltip = "";
                                  if(in_array(65, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 ){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp


                        <div class="row mt-40">
                            <div class="col-lg-12 text-center">
                               <button class="primary-btn fix-gr-bg" id="_submit_btn_admission" data-toggle="tooltip" title="{{$tooltip}}">
                                    <span class="ti-check"></span>
                                    @lang('lang.save') @lang('lang.student')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</section>
 {{-- student photo --}}
<input type="text" id="STurl" value="{{ route('student_admission_pic')}}" hidden>
 <div class="modal" id="LogoPic">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">@lang('lang.crop_image_and_upload')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="resize"></div>
                <button class="btn rotate float-lef" data-deg="90" >
                <i class="ti-back-right"></i></button>
                <button class="btn rotate float-right" data-deg="-90" >
                <i class="ti-back-left"></i></button>
                <hr>

                <a href="javascript:;" class="primary-btn fix-gr-bg pull-right" id="upload_logo">@lang('lang.crop')</a>
            </div>
        </div>
    </div>
</div>
{{-- end student photo --}}

 {{-- father photo --}}

 <div class="modal" id="FatherPic">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">@lang('lang.crop_image_and_upload')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="fa_resize"></div>
                <button class="btn rotate float-lef" data-deg="90" >
                <i class="ti-back-right"></i></button>
                <button class="btn rotate float-right" data-deg="-90" >
                <i class="ti-back-left"></i></button>
                <hr>

                <a href="javascript:;" class="primary-btn fix-gr-bg pull-right" id="FatherPic_logo">@lang('lang.crop')</a>
            </div>
        </div>
    </div>
</div>
{{-- end father photo --}}
 {{-- mother photo --}}

 <div class="modal" id="MotherPic">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Crop Image And Upload</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="ma_resize"></div>
                <button class="btn rotate float-lef" data-deg="90" >
                <i class="ti-back-right"></i></button>
                <button class="btn rotate float-right" data-deg="-90" >
                <i class="ti-back-left"></i></button>
                <hr>

                <a href="javascript:;" class="primary-btn fix-gr-bg pull-right" id="Mother_logo">Crop</a>
            </div>
        </div>
    </div>
</div>
{{-- end mother photo --}}
 {{-- mother photo --}}

 <div class="modal" id="GurdianPic">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Crop Image And Upload</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="Gu_resize"></div>
                <button class="btn rotate float-lef" data-deg="90" >
                <i class="ti-back-right"></i></button>
                <button class="btn rotate float-right" data-deg="-90" >
                <i class="ti-back-left"></i></button>
                <hr>
                <a href="javascript:;" class="primary-btn fix-gr-bg pull-right" id="Gurdian_logo">Crop</a>
            </div>
        </div>
    </div>
</div>
{{-- end mother photo --}}

@endsection
@section('script')
<script src="{{asset('public/backEnd/')}}/js/croppie.js"></script>
<script src="{{asset('public/backEnd/')}}/js/st_addmision.js"></script>
@endsection
