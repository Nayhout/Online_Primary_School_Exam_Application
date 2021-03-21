@extends('backEnd.master')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('public/backEnd/')}}/css/croppie.css">
@endsection
@section('mainContent')
@php
function showPicName($data){
$name = explode('/', $data);
return $name[3];
}
@endphp
<style type="text/css">
    .form-control:disabled{
        background-color: #FFFFFF;
    }
</style>
<input type="text" hidden id="urlStaff" value="{{ route('staffPicStore') }}">
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('lang.add_new_staff')</h1>
            <div class="bc-pages">
                <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                <a href="{{ url('staff-directory') }}">@lang('lang.human_resource')</a>
                <a href="#">@lang('lang.add_new_staff')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-8 col-md-6">
                <div class="main-title">
                    <h3 class="mb-30">@lang('lang.staff') @lang('lang.information') </h3>
                </div>
            </div>
            <div class="col-lg-4 text-md-right text-left col-md-6 mb-30-lg">
                <a href="{{route('staff_directory')}}" class="primary-btn small fix-gr-bg">
                    @lang('lang.all') @lang('lang.staff_list')
                </a>
            </div>
        </div>
        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'staffStore', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
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
              <div class="white-box">
                <div class="">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h4>@lang('lang.basic_info')</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-20">
                        <div class="col-lg-12">
                            <hr>
                        </div>
                    </div>

                    <input type="hidden" name="url" id="url" value="{{URL::to('/')}}"> 
                    <div class="row mb-30">
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <input class="primary-input form-control{{ $errors->has('staff_no') ? ' is-invalid' : '' }}" type="text"  name="staff_no" value="{{$max_staff_no != ''? $max_staff_no + 1 : 1}}" readonly>
                                <span class="focus-border"></span>
                                <label>@lang('lang.staff_no') <span>*</span> </label>
                                @if ($errors->has('staff_no'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('staff_no') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="input-effect">
                                <select class="niceSelect w-100 bb form-control{{ $errors->has('role_id') ? ' is-invalid' : '' }}" name="role_id" id="role_id">

                                    <option data-display="Role *" value="">@lang('lang.select')</option>
                                    @foreach($roles as $key=>$value)
                                    <option value="{{$value->id}}" {{ (old("role_id") ==  $value->id? "selected":"") }}>{{$value->name}}</option>
                                    @endforeach
                                </select>
                                <span class="focus-border"></span>
                                @if ($errors->has('role_id'))
                                <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ $errors->first('role_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="input-effect">
                                <select class="niceSelect w-100 bb form-control{{ $errors->has('department_id') ? ' is-invalid' : '' }}" name="department_id" id="department_id">
                                    <option data-display="Department *" value="">@lang('lang.select') </option>
                                    @foreach($departments as $key=>$value)
                                    <option value="{{$value->id}}" {{ old('department_id')==$value->id? 'selected': '' }}  >{{$value->name}}</option>
                                    @endforeach
                                </select>
                                <span class="focus-border"></span>
                                @if ($errors->has('department_id'))
                                <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ $errors->first('department_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <select class="niceSelect w-100 bb form-control{{ $errors->has('designation_id') ? ' is-invalid' : '' }}" name="designation_id" id="designation_id">
                                    <option data-display="Designations *" value="">@lang('lang.select') </option>
                                    @foreach($designations as $key=>$value)
                                    <option value="{{$value->id}}" {{ old('designation_id')==$value->id? 'selected': '' }} >{{$value->title}}</option>
                                    @endforeach
                                </select>
                                <span class="focus-border"></span>
                                @if ($errors->has('designation_id'))
                                <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ $errors->first('designation_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mb-30">
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <input class="primary-input form-control {{$errors->has('first_name') ? 'is-invalid' : ' '}}" type="text"  name="first_name" value="{{old('first_name')}}">
                                <span class="focus-border"></span>
                                <label>@lang('lang.first_name') <span>*</span> </label>
                                @if ($errors->has('first_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <input class="primary-input form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" type="text"  name="last_name" value="{{old('last_name')}}">
                                <span class="focus-border"></span>
                                <label>@lang('lang.last_name') <span>*</span> </label>
                                @if ($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <input class="primary-input form-control{{ $errors->has('fathers_name') ? ' is-invalid' : '' }}" type="text"  name="fathers_name" value="{{old('first_name')}}">
                                <span class="focus-border"></span>
                                <label>@lang('lang.father_name')</label>
                                @if ($errors->has('fathers_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('fathers_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <input class="primary-input form-control{{ $errors->has('mothers_name') ? ' is-invalid' : '' }}" type="text" name="mothers_name" value="{{old('mothers_name')}}">
                                <span class="focus-border"></span>
                                <label>@lang('lang.mother_name')</label>
                                @if ($errors->has('mothers_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('mothers_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row mb-30">
                       <div class="col-lg-3">
                        <div class="input-effect">
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
                                <div class="input-effect">
                                    <input class="primary-input date form-control{{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}" id="startDate" type="text"
                                     name="date_of_birth" value="{{ old('date_of_birth') }}" autocomplete="off">
                                    <span class="focus-border"></span>
                                    <label>@lang('lang.date_of_birth')</label>
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
                        <div class="no-gutters input-right-icon">
                            <div class="col">
                                <div class="input-effect">
                                    <input class="primary-input date form-control{{ $errors->has('date_of_joining') ? ' is-invalid' : '' }}" id="date_of_joining" type="text"
                                     name="date_of_joining" value="{{date('m/d/Y')}}">
                                    <span class="focus-border"></span>
                                    <label>@lang('lang.date_of_joining') <span>*</span> </label>
                                    @if ($errors->has('date_of_joining'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_of_joining') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto">
                                <button class="" type="button">
                                    <i class="ti-calendar" id="date_of_joining"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-20">
                 <div class="col-lg-3">
                    <div class="input-effect">
                        <input class="primary-input form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" type="text"  name="mobile" value="{{old('mobile')}}">
                        <span class="focus-border"></span>
                        <label>@lang('lang.mobile') <span>*</span> </label>
                        @if ($errors->has('mobile'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('mobile') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input-effect">
                        <select class="niceSelect w-100 bb form-control" name="marital_status">
                            <option data-display="@lang('lang.marital_status')" value="">@lang('lang.marital_status')</option>
                            
                            <option {{old('marital_status') == 'married'? 'selected': ''}} value="married">@lang('lang.married')</option>
                            <option {{old('marital_status') == 'unmarried'? 'selected': ''}} value="unmarried">@lang('lang.unmarried')</option>
                            
                        </select>
                        <span class="focus-border"></span>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input-effect">
                        <input class="primary-input form-control{{ $errors->has('emergency_mobile') ? ' is-invalid' : '' }}" type="text"  name="emergency_mobile" value="{{old('emergency_mobile')}}">
                        <span class="focus-border"></span>
                        <label>@lang('lang.emergency_mobile')</label>
                        @if ($errors->has('emergency_mobile'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('emergency_mobile') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                
                <div class="col-lg-3">
                    <div class="input-effect">
                        <input class="primary-input form-control{{ $errors->has('driving_license') ? ' is-invalid' : '' }}" type="text"  name="driving_license" value="{{old('driving_license')}}">
                        <span class="focus-border"></span>
                        <label>@lang('lang.driving_license') </label>
                        @if ($errors->has('driving_license'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('driving_license') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                

            </div>
            <div class="row mb-20">
                <div class="col-lg-3">
                    <div class="input-effect">
                        <input class="primary-input form-control{{ $errors->has('identity') ? ' is-invalid' : '' }}" type="text" name="identity" value="@if(isset($editData)){{$editData->identity}}@endif">
                        <span class="focus-border"></span>
                        <label>@lang('Passport / National ID#') <span>*</span></label>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="input-effect">
                        <input class="primary-input form-control{{ $errors->has('nssf') ? ' is-invalid' : '' }}" type="text" value="@if(isset($editData)){{$editData->nssf}}@endif">
                        <span class="focus-border"></span>
                        <label>@lang('NSSF#')</label>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="row no-gutters input-right-icon">
                        <div class="col">
                            <div class="input-effect">

                                <input class="primary-input form-control {{ $errors->has('staff_photo') ? ' is-invalid' : '' }}" type="text" id="placeholderStaffsName" 
                                placeholder="{{isset($editData->file) && $editData->file != '' ? showPicName($editData->file):'Staff Photo *'}}"
                                disabled> 
                                <span class="focus-border"></span>

                                @if ($errors->has('staff_photo'))
                                     <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('staff_photo') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="col-auto">
                            <button class="primary-btn-small-input" type="button">
                                <label class="primary-btn small fix-gr-bg" for="staff_photo">@lang('lang.browse')</label>
                                <input type="file" class="d-none" name="staff_photo" id="staff_photo">
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col-lg-6">
                    <div class="row no-gutters input-right-icon">
                        <div class="col">
                            <div class="input-effect">
                                <input class="primary-input" type="text" id="placeholderCurrentAddress" placeholder="{{isset($editData->current_address) && $editData->current_address != ""? showPicName($editData->current_address):'current_address'}}"
                                       readonly>
                                <span class="focus-border"></span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button class="primary-btn-small-input" type="button">
                                <label class="primary-btn small fix-gr-bg" for="current_address">@lang('lang.browse')</label>
                                <input type="file" class="d-none" name="current_address" id="current_address">
                            </button>
                        </div>
                    </div>


                </div>
                <div class="col-lg-6">
                    <div class="input-effect">
                        <textarea class="primary-input form-control {{ $errors->has('permanent_address') ? 'is-invalid' : ''}}" cols="0" rows="4"  name="permanent_address" id="permanent_address">{{ old('permanent_address') }}</textarea>
                        <label>@lang('lang.permanent_address') <span></span> </label>
                        <span class="focus-border textarea"></span>
                         @if ($errors->has('permanent_address'))
                         <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('permanent_address') }}</strong>
                        </span>
                        @endif 
                    </div>
                </div>
            </div>
            <div class="row md-20">
                <div class="col-lg-6">
                    <div class="input-effect">
                        <textarea class="primary-input form-control" cols="0" rows="4" name="qualification" id="qualification">{{ old('qualification') }}</textarea>
                        <label>@lang('lang.qualifications') </label>
                        <span class="focus-border textarea"></span>
                        @if ($errors->has('qualification'))
                        <span class="danger text-danger">
                            <strong>{{ $errors->first('qualification') }}</strong>
                        </span>
                        @endif 
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="input-effect">
                        <textarea class="primary-input form-control" cols="0" rows="4"  name="experience" id="experience" value="{{old('experience')}}"></textarea>
                        <label>@lang('lang.experience') </label>
                        <span class="focus-border textarea"></span>
                        @if ($errors->has('experience'))
                        <span class="danger text-danger">
                            <strong>{{ $errors->first('experience') }}</strong>
                        </span>
                        @endif 
                    </div>
                </div>
            </div>


            <div class="row mt-40">
                <div class="col-lg-12">
                    <div class="main-title">
                        <h4>@lang('lang.payroll_details')</h4>
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
                    <input class="primary-input form-control{{ $errors->has('epf_no') ? ' is-invalid' : '' }}" type="text"  name="epf_no" value="{{old('epf_no')}}">
                    <label>@lang('lang.epf_no')</label>
                    <span class="focus-border"></span>
                    @if ($errors->has('epf_no'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('epf_no') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="col-lg-3">
               <div class="input-effect">
                   <input class="primary-input form-control{{ $errors->has('basic_salary') ? ' is-invalid' : '' }}" type="number"  name="basic_salary" value="{{old('basic_salary')}}" autocomplete="off">
                   <label>@lang('lang.basic_salary') *</label>
                   <span class="focus-border"></span>
                   @if ($errors->has('basic_salary'))
                   <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('basic_salary') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="col-lg-3">
            <div class="input-effect">
                <select class="niceSelect w-100 bb form-control" name="contract_type">
                    <option data-display="@lang('lang.contract_type')" value=""> @lang('lang.contract_type')</option>
                    <option value="permanent">@lang('lang.permanent') </option>
                    <option value="contract"> @lang('lang.contract')</option>
                </select>
                <span class="focus-border"></span>

            </div>
        </div>

        <div class="col-lg-3">
           <div class="input-effect">
            <input class="primary-input form-control{{ $errors->has('location') ? ' is-invalid' : '' }}" type="text" value="{{ old('location') }}" name="location">
            <label>@lang('lang.location')</label>
            <span class="focus-border"></span>
            @if ($errors->has('location'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('location') }}</strong>
            </span>
            @endif
        </div>
    </div>
</div>
</div>

<div class="row mt-40">
    <div class="col-lg-12">
        <div class="main-title">
            <h4>@lang('lang.bank_info_details')</h4>
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
        <input class="primary-input form-control{{ $errors->has('bank_account_name') ? ' is-invalid' : '' }}" type="text"  name="bank_account_name" value="{{old('bank_account_name')}}">
        <label>@lang('lang.bank_account_name')</label>
        <span class="focus-border"></span>

    </div>
</div>

<div class="col-lg-3">
   <div class="input-effect">
    <input class="primary-input form-control{{ $errors->has('bank_account_no') ? ' is-invalid' : '' }}" type="text"  name="bank_account_no" value="{{old('bank_account_no')}}">
    <label>@lang('lang.account') @lang('lang.no')</label>
    <span class="focus-border"></span>

</div>
</div>

<div class="col-lg-3">
   <div class="input-effect">
    <input class="primary-input form-control{{ $errors->has('bank_name') ? ' is-invalid' : '' }}" type="text"  name="bank_name" value="{{old('bank_name')}}">
    <label>@lang('lang.bank_name')</label>
    <span class="focus-border"></span>

</div>
</div>

<div class="col-lg-3">
   <div class="input-effect">
    <input class="primary-input form-control{{ $errors->has('bank_brach') ? ' is-invalid' : '' }}" type="text"  name="bank_brach" value="{{old('bank_brach')}}">
    <label>@lang('lang.branch_name')</label>
    <span class="focus-border"></span>

</div>
</div>

</div>

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
    <div class="col-lg-6">
        <div class="input-effect">
             <input class="primary-input form-control{{ $errors->has('telegram_url') ? ' is-invalid' : '' }}" type="text" name="telegram_url" value={{old('telegram_url')}}>
             <label>@lang('Telegram url')</label>
             <span class="focus-border"></span>

        </div>
     </div>
    <div class="col-lg-6">
        <div class="input-effect">
            <input class="primary-input form-control{{ $errors->has('facebook_url') ? ' is-invalid' : '' }}" type="text" name="facebook_url" value={{old('facebook_url')}}>
            <label>@lang('lang.facebook_url')</label>
            <span class="focus-border"></span>

        </div>
</div>
</div>


 <div class="row mb-20">

<div class="col-lg-4">
   <div class="input-effect">
    <input class="primary-input form-control{{ $errors->has('twiteer_url') ? ' is-invalid' : '' }}" type="text"  name="twiteer_url" value="{{old('twiteer_url')}}">
    <label>@lang('lang.twitter_url')</label>
    <span class="focus-border"></span>

</div>
</div>

<div class="col-lg-4">
   <div class="input-effect">
    <input class="primary-input form-control{{ $errors->has('linkedin_url') ? ' is-invalid' : '' }}" type="text"  name="linkedin_url" value="{{old('linkedin_url')}}">
    <label>@lang('lang.linkedin_url')</label>
    <span class="focus-border"></span>

</div>
</div>

<div class="col-lg-4">
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
            <h4>@lang('lang.document_info')</h4>
        </div>
    </div>
</div>
<div class="row mb-30">
    <div class="col-lg-12">
        <hr>
    </div>
</div>

<div class="row mb-20">
   <div class="col-lg-4">
    <div class="row no-gutters input-right-icon">
        <div class="col">
            <div class="input-effect">
                <input class="primary-input" type="text" id="placeholderResume" placeholder="{{isset($editData->resume) && $editData->resume != ""? showPicName($editData->resume):'Resume'}}"
                readonly>
                <span class="focus-border"></span>
            </div>
        </div>
        <div class="col-auto">
            <button class="primary-btn-small-input" type="button">
                <label class="primary-btn small fix-gr-bg" for="resume">@lang('lang.browse')</label>
                <input type="file" class="d-none" name="resume" id="resume">
            </button>
        </div>
    </div>
</div>
<div class="col-lg-4">
    <div class="row no-gutters input-right-icon">
        <div class="col">
            <div class="input-effect">
                <input class="primary-input" type="text" id="placeholderJoiningLetter" placeholder="{{isset($editData->joining_letter) && $editData->joining_letter != ""? showPicName($editData->joining_letter):'Joining Letter'}}"
                readonly>
                <span class="focus-border"></span>
            </div>
        </div>
        <div class="col-auto">
            <button class="primary-btn-small-input" type="button">
                <label class="primary-btn small fix-gr-bg" for="joining_letter">@lang('lang.browse')</label>
                <input type="file" class="d-none" name="joining_letter" id="joining_letter">
            </button>
        </div>
    </div>
</div>
<div class="col-lg-4">
    <div class="row no-gutters input-right-icon">
        <div class="col">
            <div class="input-effect">
                <input class="primary-input" type="text" id="placeholderOthersDocument" placeholder="{{isset($editData->other_document) && $editData->other_document != ""? showPicName($editData->other_document):'Others Documents'}}"
                readonly>
                <span class="focus-border"></span>
            </div>
        </div>
        <div class="col-auto">
            <button class="primary-btn-small-input" type="button">
                <label class="primary-btn small fix-gr-bg" for="other_document">@lang('lang.browse')</label>
                <input type="file" class="d-none" name="other_document" id="other_document">
            </button>
        </div>
    </div>
</div>
</div>
<div class="row mt-40">
    <div class="col-lg-12 text-center">
        <button class="primary-btn fix-gr-bg">
            <span class="ti-check"></span>
            @lang('lang.save') @lang('lang.staff')

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
@endsection
@section('script')
<script src="{{asset('public/backEnd/')}}/js/croppie.js"></script>
<script src="{{asset('public/backEnd/')}}/js/editStaff.js"></script>
@endsection
