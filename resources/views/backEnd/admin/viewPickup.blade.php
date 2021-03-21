@extends('backEnd.master')
@section('mainContent')

@php
function showPicName($data){
$name = explode('/', $data);
return $name[4];
}
function showJoiningLetter($data){
$name = explode('/', $data);
return $name[3];
}
function showResume($data){
$name = explode('/', $data);
return $name[3];
}
function showOtherDocument($data){
$name = explode('/', $data);
return $name[3];
}

@endphp
@php  $setting = App\SmGeneralSettings::find(1); if(!empty($setting->currency_symbol)){ $currency = $setting->currency_symbol; }else{ $currency = '$'; } @endphp
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('lang.admin')</h1>
            <div class="bc-pages">
                <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                <a href="{{route('pickup_directory')}}">@lang('Pickup List')</a>
            </div>
        </div>
    </div>
</section>
<section class="mb-40 student-details">
    @if(session()->has('message-success'))
    <div class="alert alert-success">
        {{ session()->get('message-success') }}
    </div>
    @elseif(session()->has('message-danger'))
    <div class="alert alert-danger">
        {{ session()->get('message-danger') }}
    </div>
    @endif

    <div class="container-fluid p-0">
        <div class="row">
         <div class="col-lg-3">
            <!-- Start Student Meta Information -->
            <div class="main-title">
                <h3 class="mb-20">@lang('Pickup') @lang('lang.details')</h3>
            </div>
            <div class="student-meta-box">
                <div class="student-meta-top"></div>

                {{-- @if(!empty($staffDetails->staff_photo))
                    <img class="student-meta-img img-100" src="{{asset($staffDetails->staff_photo)}}"  alt="">
                @else
                    <img class="student-meta-img img-100" src="{{ file_exists(@$staffDetails->staff_photo) ? asset($staffDetails->staff_photo) : asset('public/uploads/staff/demo/staff.jpg') }}"  alt="">
                @endif --}}
                <img class="student-meta-img img-100" src="{{ file_exists(@$pickupDetails->pickup_photo) ? asset($pickupDetails->pickup_photo) : asset('public/uploads/staff/demo/staff.jpg') }}"  alt="">
                <div class="white-box">
                    <div class="single-meta mt-10">
                        <div class="d-flex justify-content-between">
                            <div class="name">
                                @lang('Pick up Name')
                            </div>
                            <div class="value">

                                @if(isset($pickupDetails)){{$pickupDetails->full_name}}@endif
<?php

                                    ?>
                            </div>
                        </div>
                    </div>
                    <div class="single-meta">
                        <div class="d-flex justify-content-between">
                            <div class="name">
                                @lang('Khmer Name')
                            </div>
                            <div class="value">
                               @if(isset($pickupDetails)){{$pickupDetails->khmer_name}}@endif
                           </div>
                       </div>
                   </div>


                   <div class="single-meta">
                    <div class="d-flex justify-content-between">
                        <div class="name">
                            @lang('Pick up Student Name')
                        </div>
                        <div class="value">
                            <?php
                               $studend_id =isset($pickupDetails)? $pickupDetails->student_id:0;
//                               $student = \App\SmStudent::find($studend_id);
                               ?>
{{--                                {{optional($student)->full_name}}--}}
                                {{$pickupDetails->student->full_name}}
                       </div>
                   </div>
               </div>



</div>
</div>
<!-- End Student Meta Information -->

</div>

<!-- Start Student Details -->
<div class="col-lg-9 staff-details">
    
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" href="#studentProfile" role="tab" data-toggle="tab">@lang('lang.profile')</a>
        </li>

{{--        <li class="nav-item edit-button">--}}
{{--            <a href="{{url('edit-staff/'.$pickupDetails->id)}}" class="primary-btn small fix-gr-bg">@lang('lang.edit')--}}
{{--            </a>--}}
{{--        </li>--}}
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Start Profile Tab -->
        <div role="tabpanel" class="tab-pane fade show active" id="studentProfile">
            <div class="white-box">
                <h4 class="stu-sub-head">@lang('lang.personal') @lang('lang.info')</h4>
                <div class="single-info">
                    <div class="row">
                        <div class="col-lg-5 col-md-5">
                            <div class="">
                                @lang('lang.mobile') @lang('lang.no')
                            </div>
                        </div>

                        <div class="col-lg-7 col-md-6">
                            <div class="">
                                @if(isset($pickupDetails)){{$pickupDetails->mobile}}@endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="single-info">
                    <div class="row">
                        <div class="col-lg-5 col-md-6">
                            <div class="">
                               @lang('lang.emergency_mobile')
                           </div>
                       </div>

                       <div class="col-lg-7 col-md-7">
                        <div class="">
                         @if(isset($pickupDetails)){{$pickupDetails->emergency_mobile}}@endif
                     </div>
                 </div>
             </div>
         </div>

         <div class="single-info">
            <div class="row">
                <div class="col-lg-5 col-md-6">
                    <div class="">
                        @lang('lang.email')
                    </div>
                </div>

                <div class="col-lg-7 col-md-7">
                    <div class="">
                        @if(isset($pickupDetails)){{$pickupDetails->email}}@endif
                    </div>
                </div>
            </div>
        </div>

        <div class="single-info">
            <div class="row">
                <div class="col-lg-5 col-md-6">
                    <div class="">
                        @lang('lang.gender')
                    </div>
                </div>

                <div class="col-lg-7 col-md-7">
                    <div class="">

{{--                        @if(isset($pickupDetails)) {{$pickupDetails->genders->base_setup_name}} @endif--}}
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="single-info">
            <div class="row">
                <div class="col-lg-5 col-md-6">
                    <div class="">
                        @lang('lang.date_of_birth')
                    </div>
                </div>

                <div class="col-lg-7 col-md-7">
                    <div class="">
                        @if(isset($pickupDetails))
                       
{{$pickupDetails->date_of_birth != ""? App\SmGeneralSettings::DateConvater($pickupDetails->date_of_birth):''}}


                        @endif
                    </div>
                </div>
            </div>
        </div>




<!-- Start Parent Part -->
<h4 class="stu-sub-head mt-40">@lang('lang.address')</h4>
<div class="single-info">
    <div class="row">
        <div class="col-lg-5 col-md-5">
            <div class="">
                @lang('lang.current_address')
            </div>
        </div>

        <div class="col-lg-7 col-md-6">
            <div class="">
                @if(isset($pickupDetails)){{$pickupDetails->current_address}}@endif
            </div>
        </div>
    </div>
</div>

<div class="single-info">
    <div class="row">
        <div class="col-lg-5 col-md-5">
            <div class="">
             @lang('lang.permanent_address')
         </div>
     </div>

     <div class="col-lg-7 col-md-6">
        <div class="">
            @if(isset($pickupDetails)){{$pickupDetails->permanent_address}}@endif
        </div>
    </div>
</div>
</div>
<!-- End Parent Part -->

<!-- Start Other Information Part -->
<h4 class="stu-sub-head mt-40">@lang('lang.social_links_details')</h4>
<div class="single-info">
    <div class="row">
        <div class="col-lg-5 col-md-5">
            <div class="">
                @lang('lang.facebook_url')
            </div>
        </div>

        <div class="col-lg-7 col-md-6">
            <div class="">
                @if(isset($pickupDetails)){{$pickupDetails->facebook_url}}@endif
            </div>
        </div>
    </div>
</div>

<div class="single-info">
    <div class="row">
        <div class="col-lg-5 col-md-5">
            <div class="">
                @lang('lang.twitter_url')
            </div>
        </div>

        <div class="col-lg-7 col-md-6">
            <div class="">
                @if(isset($pickupDetails)){{$pickupDetails->twiteer_url}}@endif
            </div>
        </div>
    </div>
</div>

<div class="single-info">
    <div class="row">
        <div class="col-lg-5 col-md-5">
            <div class="">
                @lang('lang.linkedin_url')
            </div>
        </div>

        <div class="col-lg-7 col-md-6">
            <div class="">
                @if(isset($pickupDetails)){{$pickupDetails->linkedin_url}}@endif
            </div>
        </div>
    </div>
</div>

<div class="single-info">
    <div class="row">
        <div class="col-lg-5 col-md-5">
            <div class="">
                @lang('lang.instragram_url')
            </div>
        </div>

        <div class="col-lg-7 col-md-6">
            <div class="">
                @if(isset($pickupDetails)){{$pickupDetails->instragram_url}}@endif
            </div>
        </div>
    </div>
</div><!-- End Profile Tab -->
</section>
@endsection
