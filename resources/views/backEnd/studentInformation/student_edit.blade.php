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

@php
    function showPicNameDoc($data){
        $name = explode('/', $data);
        return $name[4];
    }
@endphp

<section class="sms-breadcrumb up_breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('lang.student_edit')</h1>
            <div class="bc-pages">
                <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                <a href="{{route('student_list')}}">@lang('lang.student_list')</a>
                <a href="#">@lang('lang.student_edit')</a>
            </div>
        </div>
    </div>
</section>

<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row mb-30">
            <div class="col-lg-6">
                <div class="main-title">
                    <h3>@lang('lang.student_edit')</h3>
                </div>
            </div>
        </div>
        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'student_update',
                        'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'student_form']) }}
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
                        <div class="row mb-4">
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
                        <input type="hidden" name="id" id="id" value="{{$student->id}}"> 

                        <!-- <input type="hidden" name="parent_id" id="parent_id" value="{{$student->parent_id}}">  -->



                        <div class="row mb-20">
                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input class="primary-input form-control{{ $errors->has('admission_number') ? ' is-invalid' : '' }}" type="text" name="admission_number" value="{{$student->admission_no}}" onkeyup="GetAdminUpdate(this.value,{{$student->id}})">
                                    <label>@lang('lang.admission') @lang('lang.number') <span>*</span></label>
                                    <span class="focus-border"></span>
                                    <span class="invalid-feedback" id="Admission_Number" role="alert"></span>
                                    @if ($errors->has('admission_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('admission_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('class') ? ' is-invalid' : '' }}" name="class" id="classSelectStudent">
                                        <option data-display="@lang('lang.class') *" value="">@lang('lang.class') *</option>
                                        @foreach($classes as $class)
                                        <option value="{{$class->id}}" {{$student->class_id == $class->id? 'selected':''}}>{{$class->class_name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('class'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('class') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="col-lg-3">
                                <div class="input-effect" id="sectionStudentDiv">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('section') ? ' is-invalid' : '' }}" name="section" id="sectionSelectStudent">
                                       <option data-display="@lang('lang.section') *" value="">@lang('lang.section') *</option>
                                       @if(isset($student->section_id))
                                       @foreach($sections as $section)
                                        <option value="{{$section->id}}" {{$student->section_id == $section->id? 'selected': ''}}>{{$section->section_name}}</option>
                                        @endforeach
                                       @endif
                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('section'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('section') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input class="primary-input" type="text" placeholder="Roll Number" name="roll_number" value="{{$student->roll_no}}" readonly id="roll_number">
                                    <span class="focus-border"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-20">
                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input class="primary-input form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" type="text" name="first_name" value="{{$student->first_name}}">
                                    <label>@lang('lang.first') @lang('lang.name') <span>*</span></label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('first_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input class="primary-input form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" type="text" name="last_name" value="{{$student->last_name}}">
                                    <label>@lang('lang.last') @lang('lang.name')</label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('last_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input class="primary-input form-control" type="text" name="bank_name" value="{{$student->bank_name}}">
                                    <label>@lang('khmer name') <span></span> </label>
                                    <span class="focus-border"></span>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender">
                                        <option data-display="@lang('lang.gender') *" value="">@lang('lang.gender') *</option>
                                        @foreach($genders as $gender)
                                            @if(isset($student->gender_id))
                                                <option value="{{$gender->id}}" {{$student->gender_id == $gender->id? 'selected': ''}}>{{$gender->base_setup_name}}</option>
                                            @else
                                                <option value="{{$gender->id}}">{{$gender->base_setup_name}}</option>
                                            @endif
                                        @endforeach

                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('gender'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="row mb-20">
                            <div class="col-lg-3">
                                <div class="no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect">
                                            <input class="primary-input date form-control{{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}" id="startDate" type="text" name="date_of_birth" value="{{date('m/d/Y', strtotime($student->date_of_birth))}}" autocomplete="off">
                                            <span class="focus-border"></span>
                                            <label>@lang('lang.date_of_birth') <span>*</span></label>
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
                            <div class="col-lg-2">
                                <div class="input-effect">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('blood_group') ? ' is-invalid' : '' }}" name="blood_group">
                                        <option data-display="@lang('lang.blood_group')" value="">@lang('lang.blood_group')</option>
                                        @foreach($blood_groups as $blood_group)
                                        @if(isset($student->bloodgroup_id))
                                            <option value="{{$blood_group->id}}" {{$blood_group->id == $student->bloodgroup_id? 'selected': ''}}>{{$blood_group->base_setup_name}}</option>
                                        @else
                                            <option value="{{$blood_group->id}}">{{$blood_group->base_setup_name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('blood_group'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('blood_group') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="input-effect">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('religion') ? ' is-invalid' : '' }}" name="religion">
                                        <option data-display="@lang('lang.religion')" value="">@lang('lang.religion')</option>
                                        @foreach($religions as $religion)
                                            <option value="{{$religion->id}}" {{$student->religion_id != ""? ($student->religion_id == $religion->id? 'selected':''):''}}>{{$religion->base_setup_name}}</option>
                                        }
                                        @endforeach

                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('religion'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('religion') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
{{--                            <div class="col-lg-2">--}}
{{--                                <div class="input-effect">--}}
{{--                                    <input class="primary-input" type="text" name="caste" value="{{$student->caste}}">--}}
{{--                                    <label>@lang('lang.caste')</label>--}}
{{--                                    <span class="focus-border"></span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-lg-2">
                                <div class="input-effect">
                                    <input class="primary-input" type="text" name="nationality" value="{{$student->nationality}}">
                                    <label>@lang('lang.nationality')</label>
                                    <span class="focus-border"></span>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input class="primary-input form-control{{ $errors->has('email_address') ? ' is-invalid' : '' }}" type="text" name="email_address" value="{{$student->email}}">
                                    <label>@lang('lang.email') @lang('lang.address') <span></span></label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('email_address'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email_address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="row mb-20">
                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input class="primary-input form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" type="text" name="phone_number" value="{{$student->mobile}}">
                                    <label>@lang('lang.phone') @lang('lang.number')</label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('phone_number'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect">
                                            <input class="primary-input date" id="endDate" type="text" name="admission_date" value="{{$student->admission_date != ""? date('m/d/Y', strtotime($student->admission_date)): date('m/d/Y')}}" autocomplete="off">
                                                <label>@lang('lang.admission') @lang('lang.date')</label>
                                            <span class="focus-border"></span>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="" type="button">
                                            <i class="ti-calendar" id="end-date-icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                           
{{--                            <div class="col-lg-3">--}}
{{--                                <div class="input-effect">--}}
{{--                                    <div class="input-effect">--}}
{{--                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('category') ? ' is-invalid' : '' }}" name="category">--}}
{{--                                        <option data-display="@lang('lang.category')" value="">@lang('lang.category')</option>--}}
{{--                                        @foreach($categories as $category)--}}
{{--                                        @if(isset($student->student_category_id))--}}
{{--                                        <option value="{{$category->id}}" {{$student->student_category_id == $category->id? 'selected': ''}}>{{$category->category_name}}</option>--}}
{{--                                        @else--}}
{{--                                        <option value="{{$category->id}}">{{$category->category_name}}</option>--}}
{{--                                        @endif--}}
{{--                                        @endforeach--}}

{{--                                    </select>--}}
{{--                                    <span class="focus-border"></span>--}}
{{--                                    @if ($errors->has('category'))--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $errors->first('category') }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input class="primary-input" type="text" name="height" value="{{$student->height}}">
                                    <label>@lang('lang.height') (@lang('lang.in')) <span></span> </label>
                                    <span class="focus-border"></span>
                                </div>
                            </div>
                            <div class="col-lg-2">

                                <select class="primary-input niceSelect w-100 bb form-control{{ $errors->has('generation_id') ? ' is-invalid' : '' }}" name="generation_id">
                                    <label>@lang('Generation')</label>
                                    <option data-display="@lang('generation name')" value="">@lang('generation name')</option>
                                    @foreach($generations as $generation)
                                        <option value="{{$generation->id}}" {{$student->generation_id == $generation->id? 'selected': ''}}>{{$generation->generation_name}}</option>
                                    @endforeach

                                </select>
                                @if ($errors->has('generation_id'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('generation_id') }}</strong>
                                    </span>
                                @endif
                            </div>


                            <div class="col-lg-1">
                                <div class="input-effect sm2_mb_20 md_mb_20">

                                    <label style="margin-top: 15px;">@lang('External')&nbsp;&nbsp;&nbsp;<span></span> </label>
                                    <span class="focus-border"></span>
                                    <input type="checkbox" id="checkExternal" class="common-all_check btn btn-sm fix-gr-bg" name="checkAll" value="" {{$student->external==1?'checked':''}}>
                                    <input type="hidden" id="external" class="primary-input" name="external" value="{{$student->external??0}}">
                                </div>
                                <div type="checkbox"></div>
                            </div>
                        </div>

                        <div class="row mb-20">
{{--                            <div class="col-lg-3">--}}
{{--                                <div class="input-effect">--}}
{{--                                    <input class="primary-input" type="text" name="weight" value="{{$student->weight}}">--}}
{{--                                    <label>@lang('lang.Weight') (@lang('lang.kg')) <span></span> </label>--}}
{{--                                    <span class="focus-border"></span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-lg-2">
                                <div class="input-effect">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('session') ? ' is-invalid' : '' }}" name="session" id="select_academic">
                                        <option data-display="@lang('lang.academic_year')" value="">@lang('lang.academic_year')</option>
                                        @foreach($sessions as $session)
                                        @if(isset($student->session_id))
                                        <option value="{{$session->id}}" {{$student->session_id == $session->id? 'selected':''}}>{{$session->year}}-{{$session->year+1}}</option>
                                        @else
                                        <option value="{{$session->id}}">{{$session->year}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('session'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('session') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <?php
//                                $semester = \App\SmSemester::find($student->semester_id);
                            ?>
                            <div class="col-lg-2">
                                <div class="input-effect sm2_mb_20 md_mb_20" id="select_semester_div">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('semester') ? ' is-invalid' : '' }}" name="semester" id="select_semester">
                                        <option data-display="@lang('lang.semester') *" value="">@lang('lang.semester') *</option>
                                        @if(isset($student->semester_id))
                                            @foreach($semesters as $semester)
                                                <option value="{{$semester->id}}" {{$student->semester_id == $semester->id? 'selected': ''}}>{{$semester->semester_name_kh}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('semester'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('semester') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('student_year') ? ' is-invalid' : '' }}" name="student_year">
                                        <option data-display="@lang('lang.Student year') *" value="">@lang('lang.Student year') *</option>
                                        @if(isset($student->student_year_id))
                                        @foreach($student_years as $student_year)
                                            <option value="{{$student_year->id}}" {{$student->student_year_id == $student_year->id? 'selected': ''}}>{{$student_year->student_year_kh}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('semester'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('semester') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="row no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect">
                                            <input class="primary-input" type="text" id="placeholderPhoto" placeholder="{{$student->student_photo != ""? showPicName($student->student_photo):'Student Photo'}}"
                                                disabled>
                                            <span class="focus-border"></span>
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
                            <div class="row">
                                <div class="col-lg-3 text-left" id="parent_info">
                                    <input type="hidden" name="parent_id" value="">

                                </div>
                                <div class="col-lg-offset-3 text-right">
                                    <button class="primary-btn-small-input primary-btn small fix-gr-bg" type="button" data-toggle="modal" data-target="#editStudent">
                                        <span class="ti-plus pr-2"></span>
                                        @lang('add parents')
                                    </button>
                                </div>
                            </div>

                           <div class="col-lg-6 text-right">


                            </div>
                        </div>
                        <div class="row mb-40">
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input" type="text" name="current_occupation_student" value="{{@$student->current_occupation_student}}">
                                    <label>@lang('current occupation') <span></span> </label>
                                    <span class="focus-border"></span>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input" type="text" name="company" value="{{@$student->company}}">
                                    <label>@lang('company') <span></span> </label>
                                    <span class="focus-border"></span>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input" type="text" name="locations" value="{{@$student->parents->location}}">
                                    <label>@lang('locations') <span></span> </label>
                                    <span class="focus-border"></span>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input" type="text" name="facebook_student" value="{{@$student->facebook_student}}">
                                    <label>@lang('student facebook') <span></span> </label>
                                    <span class="focus-border"></span>
                                </div>
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
                                                                    @foreach($classes as $class)
                                                                    <option value="{{$class->id}}">{{$class->class_name}}</option>
                                                                    @endforeach
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
                                                            <button class="primary-btn fix-gr-bg" id="save_button_parent" data-dismiss="modal" type="button">@lang('update_information')</button>
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

                        <input type="hidden" name="sibling_id" value="{{count($siblings) > 1? 1: 0}}" id="sibling_id">
                        @if(count($siblings) > 1)
                         <div class="row mt-40 mb-4" id="siblingTitle">
                            <div class="col-lg-11 col-md-10">
                                <div class="main-title">
                                    <h4 class="stu-sub-head">@lang('lang.siblings')</h4>
                                </div>
                            </div>
                            <div class="col-lg-1 text-right col-md-2">
                                <button type="button" class="primary-btn small fix-gr-bg icon-only ml-10"  data-toggle="modal" data-target="#removeSiblingModal">
                                    <span class="pr ti-close"></span>
                                </button>
                            </div>
                        </div>
                        
                        <div class="row mb-20 student-details" id="siblingInfo">
                            @foreach($siblings as $sibling)
                            @if($sibling->id != $student->id)
                            <div class="col-sm-12 col-md-6 col-lg-3 mb-30">
                                <div class="student-meta-box">
                                    <div class="student-meta-top siblings-meta-top"></div>
                                    <img class="student-meta-img img-100" src="{{asset($student->student_photo)}}" alt="">
                                    <div class="white-box radius-t-y-0">
                                        <div class="single-meta mt-10">
                                            <div class="d-flex justify-content-between">
                                                <div class="name">
                                                    @lang('lang.full_name')
                                                </div>
                                                <div class="value">
                                                    {{$sibling->full_name}}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-meta">
                                            <div class="d-flex justify-content-between">
                                                <div class="name">
                                                    @lang('lang.admission') @lang('lang.number')
                                                </div>
                                                <div class="value">
                                                    {{$sibling->admission_no}}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-meta">
                                            <div class="d-flex justify-content-between">
                                                <div class="name">
                                                    @lang('lang.class')
                                                </div>
                                                <div class="value">
                                                    {{$sibling->className!=""?$sibling->className->class_name:""}}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-meta">
                                            <div class="d-flex justify-content-between">
                                                <div class="name">
                                                    @lang('lang.section')
                                                </div>
                                                <div class="value">
                                                    {{$sibling->section !=""?$sibling->section->section_name:""}}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            @endif
                            @endforeach
                        </div>
                        @endif

                        <div class="parent_details" id="parent_details">
                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <div class="main-title">
                                        <h4 class="stu-sub-head">@lang('lang.parents_and_guardian_info')</h4>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-20">
                                <div class="col-lg-3">
                                    <div class="input-effect">
                                        <input class="primary-input form-control{{ $errors->has('fathers_name') ? ' is-invalid' : '' }}" type="text" name="fathers_name" id="fathers_name" value="{{$student->parents->fathers_name}}">
                                        <label>@lang('lang.father_name') <span></span></label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('fathers_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fathers_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input-effect">
                                        <input class="primary-input form-control" type="text" placeholder="" name="fathers_occupation" id="fathers_occupation" value="{{$student->parents->date_of_birth_father}}">
                                        <label>@lang('date of birth father')</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>
                                 <div class="col-lg-3">
                                    <div class="input-effect">
                                        <input class="primary-input form-control{{ $errors->has('fathers_phone') ? ' is-invalid' : '' }}" type="text" name="fathers_phone" id="fathers_phone"  value="{{$student->parents->fathers_mobile}}">
                                        <label>@lang('lang.father_phone') <span>*</span></label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('fathers_phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fathers_phone') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="row no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="input-effect">
                                                <input class="primary-input" type="text" id="placeholderFathersName" placeholder="{{isset($student->parents->fathers_photo) && $student->parents->fathers_photo != ""? showPicName($student->parents->fathers_photo):'Photo'}}"
                                                    disabled>
                                                <span class="focus-border"></span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="primary-btn small fix-gr-bg" for="fathers_photo">@lang('lang.browse')</label>
                                                <input type="file" class="d-none" name="fathers_photo" id="fathers_photo">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-40 mt-30">
                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input class="primary-input" type="text" name="fathers_occupation" id="fathers_occupation" value="{{$student->parents->fathers_occupation}}">
                                        <label>@lang('father occupation')</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input class="primary-input form-control" cols="0" rows="3" name="father_address" id="father_address" value="{{$student->parents->father_address}}">{{old('father_address')}}</input>
                                        <label>@lang('father address') <span></span> </label>
                                        <span class="focus-border textarea"></span>
                                        @if ($errors->has('father_address'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('father_address') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <div class="row mb-20">
                                <div class="col-lg-3">
                                    <div class="input-effect">
                                        <input class="primary-input form-control{{ $errors->has('mothers_name') ? ' is-invalid' : '' }}" type="text" name="mothers_name" id="mothers_name"   value="{{$student->parents->mothers_name}}">
                                        <label>@lang('lang.mother_name') <span></span></label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('mothers_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mothers_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input-effect">
                                        <input class="primary-input" type="text" name="mothers_occupation" id="mothers_occupation" value="{{$student->parents->date_of_birth_mother}}">
                                        <label>@lang('Date of Birth Mother')</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>
                                 <div class="col-lg-3">
                                    <div class="input-effect">
                                        <input class="primary-input form-control{{ $errors->has('mothers_phone') ? ' is-invalid' : '' }}" type="text" name="mothers_phone" id="mothers_phone" value="{{$student->parents->mothers_mobile}}">
                                        <label>@lang('lang.mother_phone') <span></span></label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('mothers_phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mothers_phone') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="row no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="input-effect">
                                                <input class="primary-input" type="text" id="placeholderMothersName" placeholder="{{isset($student->parents->mothers_photo) && $student->parents->mothers_photo != ""? showPicName($student->parents->mothers_photo):'Photo'}}"
                                                    disabled>
                                                <span class="focus-border"></span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="primary-btn small fix-gr-bg" for="mothers_photo">@lang('lang.browse')</label>
                                                <input type="file" class="d-none" name="mothers_photo" id="mothers_photo">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-40 mt-30">
                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input class="primary-input" type="text" name="mothers_occupation" id="mothers_occupation" value="{{$student->parents->mothers_occupation}}">
                                        <label>@lang('lang.occupation')</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input class="primary-input form-control" cols="0" rows="3" name="mother_address" id="mother_address" value="{{$student->parents->mother_address}}">{{old('mother_address')}}</input>
                                        <label>@lang('mother address') <span></span> </label>
                                        <span class="focus-border textarea"></span>
                                        @if ($errors->has('mother_address'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('mother_address') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                            </div>

                             <div class="row mb-40">
                                <div class="col-lg-12 d-flex">
                                    <p class="text-uppercase fw-500 mb-10">@lang('lang.relation_with_guardian') *</p>
                                    <div class="d-flex radio-btn-flex ml-40">
                                        <div class="mr-30">
                                            <input type="radio" name="relationButton" id="relationFather" value="F" class="common-radio relationButton" {{$student->parents->relation == "F"? 'checked':''}}>
                                            <label for="relationFather">@lang('lang.father')</label>
                                        </div>
                                        <div class="mr-30">
                                            <input type="radio" name="relationButton" id="relationMother" value="M" class="common-radio relationButton" {{$student->parents->relation == "M"? 'checked':''}}>
                                            <label for="relationMother">@lang('lang.mother')</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="relationButton" id="relationOther" value="O" class="common-radio relationButton" {{$student->parents->relation == "O"? 'checked':''}}>
                                            <label for="relationOther">@lang('lang.Other')</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        
                            <div class="row mb-20">
                                <div class="col-lg-3">
                                    <div class="input-effect">
                                        <input class="primary-input form-control{{ $errors->has('guardians_name') ? ' is-invalid' : '' }}" type="text" name="guardians_name" id="guardians_name" value="{{$student->parents->guardians_name}}">
                                        <label>@lang('lang.guardian_name')  <span></span> </label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('guardians_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('guardians_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input-effect">
                                        <input class="primary-input read-only-input" type="text" placeholder="Relation" name="relation" id="relation" value="{{$student->parents->guardians_relation}}" readonly>
                                        <label>@lang('lang.relation_with_guardian') </label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input-effect">
                                        <input class="primary-input form-control{{ $errors->has('guardians_email') ? ' is-invalid' : '' }}" type="text" name="guardians_email" id="guardians_email" value="{{$student->parents->guardians_email}}">
                                        <label>@lang('lang.guardian_email') <span>*</span></label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('guardians_email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('guardians_email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="row no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="input-effect">
                                                <input class="primary-input" type="text" id="placeholderGuardiansName" placeholder="{{isset($student->parents->guardians_photo) && $student->parents->guardians_photo != ""? showPicName($student->parents->guardians_photo):'Photo'}}"
                                                    disabled>
                                                <span class="focus-border"></span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="primary-btn small fix-gr-bg" for="guardians_photo">@lang('lang.browse')</label>
                                                <input type="file" class="d-none" name="guardians_photo" id="guardians_photo">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-20">
                                <div class="col-lg-3">
                                    <div class="input-effect">
                                        <input class="primary-input form-control{{ $errors->has('guardians_phone') ? ' is-invalid' : '' }}" type="text" name="guardians_phone" id="guardians_phone" value="{{$student->parents->guardians_mobile}}">
                                        <label>@lang('lang.guardian_phone') <span>*</span></label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('guardians_phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('guardians_phone') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input-effect">
                                        <input class="primary-input" type="text" name="guardians_occupation" id="guardians_occupation" value="{{$student->parents->guardians_occupation}}">
                                        <label>@lang('lang.guardian_occupation')</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-effect">
                                        <input class="primary-input form-control" cols="0" rows="4" name="guardians_address" id="guardians_address" value="{{$student->parents->guardian_address}}">{{$student->parents->guardians_address}}</input>
                                        <label>@lang('lang.guardian_address') <span></span> </label>
                                        <span class="focus-border textarea"></span>
                                        @if ($errors->has('guardians_address'))
                                            <span class="danger text-danger">
                                            <strong>{{ $errors->first('guardians_address') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row mb-30">

                            <div class="col-lg-3">

                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input form-control{{ $errors->has('facebook_guardian') ? ' is-invalid' : '' }}" type="text" name="facebook_guardian" id="facebook_guardian" value="{{$student->parents->facebook_guardian}}">
                                    <label>@lang('facebook guardian')</label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('facebook_guardian'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('facebook_guardian') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect sm2_mb_20 md_mb_20">
                                            <input class="primary-input date form-control{{ $errors->has('date_of_birth_guardian') ? ' is-invalid' : '' }}" id="startDate" type="text"
                                                   name="date_of_birth_guardian" value="{{$student->parents->date_of_birth_guardian}}" autocomplete="off">
                                            <label>@lang('date of birth guardian')</label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('date_of_birth_guardian'))
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('date_of_birth_guardian') }}</strong>
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
                                    <input class="primary-input form-control{{ $errors->has('as_guardian') ? ' is-invalid' : '' }}" type="text" name="as_guardian" id="as_guardian" value="{{$student->parents->as_guardian}}">
                                    <label>@lang('as')</label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('as_guardian'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('as_guardian') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mt-40">
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h4 class="stu-sub-head">@lang('emergency contact')</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-4">
                                <?php
                                    $emergency = \App\SmEmergency::find($student->emergency_contact_id);
                                ?>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <label>@lang('Name')<span></span> </label>
                                    <input class=" form-control" cols="0" rows="3" name="names" id="names" value="{{@$emergency->name}}">{{old('names')}}</input>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('names'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('names') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4">

                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <label>@lang('Occupation') <span></span> </label>
                                    <input class=" form-control" cols="0" rows="3" name="occupation" id="occupation" value="{{@$emergency->occupation}}">{{old('occupation')}}</input>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('occupation'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('occupation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <label>@lang('Mobile') <span></span> </label>
                                    <input class=" form-control" cols="0" rows="3" name="mobiles" id="mobiles" value="{{@$emergency->mobile}}">{{old('Mobile')}}</input>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('Mobile'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('Mobile') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mt-40">
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h4 class="stu-sub-head">@lang('high school info')</h4>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-30 mt-30">
                            <div class="col-lg-4">

                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input form-control" cols="0" rows="3" name="village_school" id="village_school" value="{{$student->village_school}}">{{old('village_school')}} </input>
                                    <label>@lang('village')<span></span> </label>
                                   <span class="focus-border textarea"> </span>
                                    @if ($errors->has('village_school'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('village_school') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4">

                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input form-control" cols="0" rows="3" name="commune_school" id="commune_school" value="{{$student->commune_school}}">{{old('commune_school')}}</input>
                                    <label>@lang('commune') <span></span> </label>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('commune_school'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('commune_school') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input form-control" cols="0" rows="3" name="district_school" id="district_school" value="{{$student->district_school}}">{{old('district_school')}}</input>
                                    <label>@lang('district') <span></span> </label>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('district_school'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('district_school') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mb-30 mt-30">
                            <div class="col-lg-6">

                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input form-control" cols="0" rows="3" name="from_school" id="from_school" value="{{$student->from_school}}">{{old('from_school')}}</input>
                                    <label>@lang('from high school') <span></span> </label>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('from_school'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('from_school') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">

                                <select class="niceSelect w-100 bb form-control{{ $errors->has('province_school') ? ' is-invalid' : '' }}" name="province_school" value="{{$student->province_school}}">
                                    <option data-display="@lang('province')" value="">@lang('province')</option>
                                    @foreach($provinces as $province)
                                        <option value="{{$province->id}}" {{ $student->province_school== $province->id? 'selected': ''}}>{{$province->name}}</option>
                                    @endforeach

                                </select>
                                @if ($errors->has('province_school'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('province_school') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-40">
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h4 class="stu-sub-head">@lang('degree info')</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-6">
                                <label>@lang('Degree Year') <span>*</span> </label>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class=" form-control" cols="0" rows="3" type="number" name="degree_year" id="degree_year" value="{{$student->degree_year}}">{{old('degree_year')}}</input>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('degree_year'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('degree_year') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>@lang('Degree No') <span>*</span> </label>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class=" form-control" cols="0" rows="3" name="degree_no" id="degree_no" value="{{$student->degree_no}}">{{old('degree_no')}}</input>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('degree_no'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('degree_no') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-6">
                                <label>@lang('Subject 1') <span></span> </label>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class=" form-control" cols="0" rows="3" name="subject1" id="subject1" value="{{$student->subject1}}">{{old('subject1')}}</input>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('subject1'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('subject1') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>@lang('Grade') <span></span> </label>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class=" form-control" cols="0" rows="3" name="grade1" id="grade1" value="{{$student->grade1}}">{{old('grade1')}}</input>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('grade1'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('grade1') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-6">
                                <label>@lang('Subject 2') <span></span> </label>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class=" form-control" cols="0" rows="3" name="subject2" id="subject2" value="{{$student->subject2}}">{{old('subject2')}}</input>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('subject2'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('subject2') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>@lang('Grade') <span></span> </label>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class=" form-control" cols="0" rows="3" name="grade2" id="grade2" value="{{$student->grade2}}">{{old('grade2')}}</input>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('grade2'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('grade2') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-6">
                                <label>@lang('Subject 3') <span></span> </label>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class=" form-control" cols="0" rows="3" name="subject3" id="subject3" value="{{$student->subject3}}">{{old('subject3')}}</input>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('subject3'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('subject3') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>@lang('Grade') <span></span> </label>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class=" form-control" cols="0" rows="3" name="grade3" id="grade3" value="{{$student->grade3}}">{{old('grade3')}}</input>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('grade3'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('grade3') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-6">
                                <label>@lang('Subject 4') <span></span> </label>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class=" form-control" cols="0" rows="3" name="subject4" id="subject4" value="{{$student->subject4}}">{{old('subject4')}}</input>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('subject4'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('subject4') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>@lang('Grade') <span></span> </label>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class=" form-control" cols="0" rows="3" name="grade4" id="grade4" value="{{$student->grade4}}">{{old('grade4')}}</input>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('grade4'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('grade4') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-6">
                                <label>@lang('Subject 5') <span></span> </label>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class=" form-control" cols="0" rows="3" name="subject5" id="subject5" value="{{$student->subject5}}">{{old('subject5')}}</input>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('subject5'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('subject5') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>@lang('Grade') <span></span> </label>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class=" form-control" cols="0" rows="3" name="grade5" id="grade5" value="{{$student->grade5}}">{{old('grade5')}}</input>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('grade5'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('grade5') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-6">
                                <label>@lang('Subject 6') <span></span> </label>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class=" form-control" cols="0" rows="3" name="subject6" id="subject6" value="{{$student->subject6}}">{{old('subject6')}}</input>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('subject6'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('subject6') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>@lang('Grade') <span></span> </label>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class=" form-control" cols="0" rows="3" name="grade6" id="grade6"value="{{$student->grade6}}">{{old('grade6')}}</input>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('grade6'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('grade6') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-6">
                                <label>@lang('Total Grade') <span></span> </label>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <select class="w-100 niceSelect bb form-control{{ $errors->has('total_grade') ? ' is-invalid' : '' }}" name="total_grade" value="{{$student->total_grade}}>
                                        <option data-display="Select grade *" value="">@lang('lang.select_grade') *</option>
                                        <option {{$student->total_grade == 'A' ? 'selected':''}} value="A"> A</option>
                                        <option {{$student->total_grade == 'B' ? 'selected':''}} value="B"> B</option>
                                        <option {{$student->total_grade == 'C' ? 'selected':''}} value="C"> C</option>
                                        <option {{$student->total_grade == 'D' ? 'selected':''}} value="D"> D</option>
                                        <option {{$student->total_grade == 'E' ? 'selected':''}} value="E"> E</option>
                                        <option {{$student->total_grade == 'F' ? 'selected':''}} value="F"> F</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>@lang('Total Score') <span></span> </label>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class=" form-control" cols="0" rows="3" type="number" name="total_score" id="total_score" value="{{$student->total_score}}">{{old('total_score')}}</input>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('total_score'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('total_score') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-6">
                                <label>@lang('Degree Level') <span></span> </label>
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    @php

                                    @endphp
                                    <select class="w-100 niceSelect bb form-control{{ $errors->has('degree_level') ? ' is-invalid' : '' }}" name="degree_level" value="{{$student->degree_level}}">{{old('degree_level')}}
                                        <option data-display="Select Level *" value="" >@lang('lang.select_level') *</option>

                                        <option value="" >Select Level *</option>
                                        <option {{$student->degree_level == 'បាក់ឌុប' ? 'selected':''}} value="បាក់ឌុប" > បាក់ឌុប</option>
                                        <option {{$student->degree_level == 'សមមូល' ? 'selected':''}}  value="សមមូល"  > សមមូល</option>
                                        <option {{$student->degree_level == 'បរិញ្ញាបត្ររង' ? 'selected':''}}  value="បរិញ្ញាបត្ររង" > បរិញ្ញាបត្ររង</option>
                                        <option {{$student->degree_level == 'ផ្សេងៗ' ? 'selected':''}}  value="ផ្សេងៗ" > ផ្សេងៗ</option>

                                    </select>
                                    <span class="focus-border textarea"></span>
                                    @if ($errors->has('degree_level'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('degree_level') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-effect">
                                    <div class="input-effect">
                                        <option data-display="@lang('lang.category')" value="">@lang('lang.category')</option>
                                        <select class="niceSelect w-100 bb form-control{{ $errors->has('category') ? ' is-invalid' : '' }}" name="category">
                                            @foreach($categories as $category)
                                                @if(isset($student->student_category_id))
                                                    <option value="{{$category->id}}" {{$student->student_category_id == $category->id? 'selected': ''}}>{{$category->category_name}}</option>
                                                @else
                                                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                                                @endif
                                            @endforeach

                                        </select>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('category'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-40">
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h4 class="stu-sub-head">@lang('lang.student') @lang('lang.address') @lang('lang.info')</h4>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-30 mt-30">
                            <div class="col-lg-4">
                                <label>@lang('House No') <span></span> </label>
                                <input   class="form-control{{ $errors->has('house_student') ? ' is-invalid' : '' }}" cols="0" rows="3" name="house_student" id="house_student" value="{{$student->house_student}}">{{old('house_student')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('house_student'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('house_student') }}</strong>
                                    </span>
                                @endif

                            </div>
                            <div class="col-lg-4">


                                <label>@lang('Street')  <span></span> </label>
                                <input class="form-control{{ $errors->has('street_student') ? ' is-invalid' : '' }}" cols="0" rows="3" name="street_student" id="street_student" value="{{$student->street_student}}">{{old('street_student')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('street_student'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('street_student') }}</strong>
                                    </span>
                                @endif

                            </div>
                            <div class="col-lg-4">


                                <label>@lang('Group')  <span></span> </label>
                                <input class="form-control{{ $errors->has('group_student') ? ' is-invalid' : '' }}" cols="0" rows="3" name="group_student" id="group_student" value="{{$student->group_student}}">{{old('group_student')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('group_student'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('group_student') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-4">

                                <label>@lang('Village') <span></span> </label>
                                <input   class="form-control{{ $errors->has('village_student') ? ' is-invalid' : '' }}" cols="0" rows="3" name="village_student" id="village_student" value="{{$student->village_student}}">{{old('village_student')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('village_student'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('village_student') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-4">

                                <label>@lang('Commune')  <span></span> </label>
                                <input class="form-control{{ $errors->has('commune_student') ? ' is-invalid' : '' }}" cols="0" rows="3" name="commune_student" id="commune_student" value="{{$student->commune_student}}">{{old('commune_student')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('commune_student'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('commune_student') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-4">

                                <label>@lang('District')  <span></span> </label>
                                <input class="form-control{{ $errors->has('district_student') ? ' is-invalid' : '' }}" cols="0" rows="3" name="district_student" id="district_student" value="{{$student->district_student}}">{{old('district_student')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('district_student'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('district_student') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-6">

                                <label>@lang('Province')  <span></span> </label>
                                <select class="niceSelect w-100 bb form-control{{ $errors->has('province_student') ? ' is-invalid' : '' }}" name="province_student" value="{{$student->province_student}}">
                                    <option data-display="@lang('province')" value="">@lang('province')</option>
                                    @foreach($provinces as $province)
                                        <option value="{{$province->id}}" {{$student->province_student == $province->id? 'selected': ''}}>{{$province->name}}</option>
                                    @endforeach

                                </select>
                                @if ($errors->has('province_student'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('province_student') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-40">
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h4 class="stu-sub-head">@lang('Student Address Permanent')</h4>
                                </div>
                            </div>
                        </div>

                            <?php
                                $permanents = \App\SmStudentsPermanent::find($student->student_permanent_id)->first();
//                                dd($permanent);
                            ?>
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-4">
                                <label>@lang('House No') <span></span> </label>
                                <input   class="form-control{{ $errors->has('house_permanent') ? ' is-invalid' : '' }}" cols="0" rows="3" name="house_permanent" id="house_permanent" value="{{@$permanents->house_permanent}}">{{old('house_permanent')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('house_permanent'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('house_permanent') }}</strong>
                                    </span>
                                @endif

                            </div>
                            <div class="col-lg-4">


                                <label>@lang('Street')  <span></span> </label>
                                <input class="form-control{{ $errors->has('street_permanent') ? ' is-invalid' : '' }}" cols="0" rows="3" name="street_permanent" id="street_permanent" value="{{@$permanents->street_permanent}}">{{old('street_permanent')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('street_permanent'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('street_permanent') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="col-lg-4">


                                <label>@lang('Group')  <span></span> </label>
                                <input class="form-control{{ $errors->has('group_permanent') ? ' is-invalid' : '' }}" cols="0" rows="3" name="group_permanent" id="group_permanent" value="{{@$permanents->group_permanent}}">{{old('group_permanent')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('group_permanent'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('group_permanent') }}</strong>
                                    </span>
                                @endif

                            </div>

                        </div>
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-4">

                                <label>@lang('Village') <span></span> </label>
                                <input   class="form-control{{ $errors->has('village_permanent') ? ' is-invalid' : '' }}" cols="0" rows="3" name="village_permanent" id="village_permanent" value="{{@$permanents->village_permanent}}">{{old('village_permanent')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('village_permanent'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('village_permanent') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-lg-4">

                                <label>@lang('Commune')  <span></span> </label>
                                <input class="form-control{{ $errors->has('commune_permanent') ? ' is-invalid' : '' }}" cols="0" rows="3" name="commune_permanent" id="commune_permanent" value="{{@$permanents->commune_permanent}}">{{old('commune_permanent')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('commune_permanent'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('commune_permanent') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-4">

                                <label>@lang('District')  <span></span> </label>
                                <input class="form-control{{ $errors->has('district_permanent') ? ' is-invalid' : '' }}" cols="0" rows="3" name="district_permanent" id="district_permanent"value="{{@$permanents->district_permanent}}">{{old('district_permanent')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('district_permanent'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('district_permanent') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-4">

                                <label>@lang('Province')</label>
                                <select class="niceSelect w-100 bb form-control{{ $errors->has('province_permanent') ? ' is-invalid' : '' }}" name="province_permanent" value="{{$student->province_permanent}}">
                                    <option data-display="@lang('province')" value="">@lang('province')</option>
                                    @foreach($provinces as $province)
                                        <?php
                                            $p = \App\SmStudentsPermanent::find($student->student_permanent_id);
                                        ?>
                                        <option value="{{$province->id}}" {{ $p->province_permanent == $province->id? 'selected': ''}}>{{$province->name}}</option>
                                    @endforeach

                                </select>
                                @if ($errors->has('province_permanent'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('province_permanent') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-40">
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h4 class="stu-sub-head">@lang('Place of Birth')</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-4">
                                <label>@lang('House No') <span></span> </label>
                                <input   class="form-control{{ $errors->has('house_birth') ? ' is-invalid' : '' }}" cols="0" rows="3" name="house_birth" id="house_birth" value="{{$student->house_birth}}">{{old('house_birth')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('house_birth'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('house_birth') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="col-lg-4">


                                <label>@lang('Group')  <span></span> </label>
                                <input class="form-control{{ $errors->has('group_birth') ? ' is-invalid' : '' }}" cols="0" rows="3" name="group_birth" id="group_birth" value="{{$student->group_birth}}">{{old('group_birth')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('group_birth'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('group_birth') }}</strong>
                                    </span>
                                @endif

                            </div>
                            <div class="col-lg-4">

                                <label>@lang('Village') <span></span> </label>
                                <input   class="form-control{{ $errors->has('village_birth') ? ' is-invalid' : '' }}" cols="0" rows="3" name="village_birth" id="village_birth" value="{{$student->village_birth}}">{{old('village_birth')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('village_birth'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('village_birth') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-30 mt-30">

                            <div class="col-lg-4">

                                <label>@lang('Commune')  <span></span> </label>
                                <input class="form-control{{ $errors->has('commune_birth') ? ' is-invalid' : '' }}" cols="0" rows="3" name="commune_birth" id="commune_birth" value="{{$student->commune_birth}}">{{old('commune_birth')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('commune_birth'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('commune_birth') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-4">

                                <label>@lang('District')  <span></span> </label>
                                <input class="form-control{{ $errors->has('district_birth') ? ' is-invalid' : '' }}" cols="0" rows="3" name="district_birth" id="district_birth" value="{{$student->district_birth}}">{{old('district_birth')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('district_birth'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('district_birth') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-4">

                                <label>@lang('City')</label>
                                <select class="niceSelect w-100 bb form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" value="{{$student->city}}">
                                    <option data-display="@lang('province')" value="">@lang('province')</option>
                                    @foreach($provinces as $province)
                                        <option value="{{$province->id}}" {{ $student->city == $province->id? 'selected': ''}}>{{$province->name}}</option>
                                    @endforeach

                                </select>
                                @if ($errors->has('city'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-40">
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h4 class="stu-sub-head">@lang('Family')</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-3">
                                <label>@lang('Name') <span></span> </label>
                                <?php
                                    $families = \App\SmStudentsFamily::find($student->student_family_id);
                                ?>
                                <input   class="form-control{{ $errors->has('family1') ? ' is-invalid' : '' }}" cols="0" rows="3" name="family1" id="family1" value="{{$families->family1}}">{{old('family1')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('family1'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('family1') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="col-lg-3">


                                <label>@lang('Major')  <span></span> </label>
                                <input class="form-control{{ $errors->has('major1') ? ' is-invalid' : '' }}" cols="0" rows="3" name="major1" id="major1" value="{{$families->major1}}">{{old('major1')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('major1'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('major1') }}</strong>
                                    </span>
                                @endif

                            </div>
                            <div class="col-lg-3">

                                <label>@lang('Academic') <span></span> </label>
                                <input   class="form-control{{ $errors->has('academic1') ? ' is-invalid' : '' }}" cols="0" rows="3" name="academic1" id="academic1" value="{{$families->academic1}}">{{old('academic1')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('academic1'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('academic1') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-3">

                                <label>@lang('As') <span></span> </label>
                                <input   class="form-control{{ $errors->has('as1') ? ' is-invalid' : '' }}" cols="0" rows="3" name="as1" id="as1" value="{{$families->as1}}">{{old('as1')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('as1'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('as1') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-3">
                                <label>@lang('Name') <span></span> </label>
                                <input   class="form-control{{ $errors->has('family2') ? ' is-invalid' : '' }}" cols="0" rows="3" name="family2" id="family2" value="{{$families->family2}}">{{old('family2')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('family2'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('family2') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="col-lg-3">


                                <label>@lang('Major')  <span></span> </label>
                                <input class="form-control{{ $errors->has('major2') ? ' is-invalid' : '' }}" cols="0" rows="3" name="major2" id="major2" value="{{$families->major2}}">{{old('major2')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('major2'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('major2') }}</strong>
                                    </span>
                                @endif

                            </div>
                            <div class="col-lg-3">

                                <label>@lang('Academic') <span></span> </label>
                                <input   class="form-control{{ $errors->has('academic2') ? ' is-invalid' : '' }}" cols="0" rows="3" name="academic2" id="academic2"value="{{$families->academic2}}">{{old('academic2')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('academic2'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('academic2') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-3">

                                <label>@lang('As') <span></span> </label>
                                <input   class="form-control{{ $errors->has('as2') ? ' is-invalid' : '' }}" cols="0" rows="3" name="as2" id="as2" value="{{$families->as2}}">{{old('as2')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('as2'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('as2') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-30 mt-30">
                            <div class="col-lg-3">
                                <label>@lang('Name') <span></span> </label>
                                <input   class="form-control{{ $errors->has('family3') ? ' is-invalid' : '' }}" cols="0" rows="3" name="family3" id="family3" value="{{$families->family3}}">{{old('family3')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('family3'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('family3') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="col-lg-3">


                                <label>@lang('Major')  <span></span> </label>
                                <input class="form-control{{ $errors->has('major3') ? ' is-invalid' : '' }}" cols="0" rows="3" name="major3" id="major3" value="{{$families->major3}}">{{old('major3')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('major3'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('major3') }}</strong>
                                    </span>
                                @endif

                            </div>
                            <div class="col-lg-3">

                                <label>@lang('Academic') <span></span> </label>
                                <input   class="form-control{{ $errors->has('academic3') ? ' is-invalid' : '' }}" cols="0" rows="3" name="academic3" id="academic3" value="{{$families->academic3}}">{{old('academic3')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('academic3'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('academic3') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-3">

                                <label>@lang('As') <span></span> </label>
                                <input   class="form-control{{ $errors->has('as3') ? ' is-invalid' : '' }}" cols="0" rows="3" name="as3" id="as3" value="{{$families->as3}}">{{old('as3')}}</input>
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('as3'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('as3') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
{{--                       <div class="row mt-40">--}}
{{--                            <div class="col-lg-12">--}}
{{--                                <div class="main-title">--}}
{{--                                    <h4 class="stu-sub-head">@lang('lang.student_address_info')</h4>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}


{{--                        <div class="row mb-30 mt-30">--}}
{{--                            <div class="col-lg-6">--}}

{{--                                <div class="input-effect mt-20">--}}
{{--                                    <textarea class="primary-input form-control{{ $errors->has('current_address') ? ' is-invalid' : '' }}" cols="0" rows="3" name="current_address" id="current_address">{{$student->current_address}}</textarea>--}}
{{--                                    <label>@lang('lang.current_address') <span></span> </label>--}}
{{--                                    <span class="focus-border textarea"></span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-lg-6">--}}

{{--                                <div class="input-effect mt-20">--}}
{{--                                    <textarea class="primary-input form-control{{ $errors->has('current_address') ? ' is-invalid' : '' }}" cols="0" rows="3" name="permanent_address" id="permanent_address">{{$student->permanent_address}}</textarea>--}}
{{--                                    <label>@lang('lang.permanent_address') <span></span> </label>--}}
{{--                                    <span class="focus-border textarea"></span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="row mt-40 mb-4">
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h4 class="stu-sub-head">@lang('lang.transport')</h4>
                                </div>
                            </div>
                        </div>

                         <div class="row mb-20">
                            <div class="col-lg-6">
                                <div class="input-effect">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('route') ? ' is-invalid' : '' }}" name="route" id="route">
                                        <option data-display="@lang('lang.route_list')" value="">@lang('lang.route_list')</option>
                                        @foreach($route_lists as $route_list)
                                        @if(isset($student->route_list_id))
                                        <option value="{{$route_list->id}}" {{$student->route_list_id == $route_list->id? 'selected':''}}>{{$route_list->title}}</option>
                                        @else
                                        <option value="{{$route_list->id}}">{{$route_list->title}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('route'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('route') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-effect" id="select_vehicle_div">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('vehicle') ? ' is-invalid' : '' }}" name="vehicle" id="selectVehicle">
                                        <option data-display="@lang('lang.vehicle_number')" value="">@lang('lang.vehicle_number')</option>
                                        @foreach($vehicles as $vehicle)
                                        @if(isset($student->vechile_id) && $vehicle->id == $student->vechile_id)
                                        <option value="{{$vehicle->id}}" {{$student->vechile_id == $vehicle->id? 'selected':''}}>{{$vehicle->vehicle_no}}</option>
                                        @endif
                                        @endforeach

                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('vehicle'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('vehicle') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{-- <div class="col-lg-3">
                                <div class="input-effect">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('driver') ? ' is-invalid' : '' }}" name="driver_id" id="">
                                        <option data-display="@lang('lang.driver') @lang('lang.name')" value="">@lang('lang.driver') @lang('lang.name')</option>
                                        @foreach($driver_lists as $driver)
                                        <option value="{{$driver->id}}" {{old('driver') == $driver->id? 'selected': ''}}>{{$driver->full_name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('class'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('class') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div> --}}
                        </div>
                        <div class="row mt-40">
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h4 class="stu-sub-head">@lang('lang.Other') @lang('lang.info')</h4>
                                </div>
                            </div>
                        </div>
                         <div class="row mb-20">
                            <div class="col-lg-6">
                                <div class="input-effect">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('dormitory_name') ? ' is-invalid' : '' }}" name="dormitory_name" id="SelectDormitory">
                                        <option data-display="@lang('lang.dormitory') @lang('lang.name')" value="">@lang('lang.dormitory') @lang('lang.name')</option >
                                        @foreach($dormitory_lists as $dormitory_list)
                                        @if($student->dormitory_id)
                                        <option value="{{$dormitory_list->id}}" {{$student->dormitory_id == $dormitory_list->id? 'selected':''}}>{{$dormitory_list->dormitory_name}}</option>
                                        @else
                                        <option value="{{$dormitory_list->id}}">{{$dormitory_list->dormitory_name}}</option>
                                        @endif
                                        @endforeach                                    
                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('dormitory_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('dormitory_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-effect" id="roomNumberDiv">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('room_number') ? ' is-invalid' : '' }}" name="room_id" id="selectRoomNumber">
                                        <option data-display="@lang('lang.room') @lang('lang.name')" value="">@lang('lang.room') @lang('lang.name')</option>
                                        @if($student->room_id != "")
                                            <option value="{{$student->room_id}}" selected="true"}}>{{$student->room !=""?$student->room->name:""}}</option>
                                        @endif
                                        
                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('room_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('room_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mt-40 mb-4">
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h4 class="stu-sub-head">@lang('lang.document_info')</h4>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-20">
                            <div class="col-lg-4">
                                <div class="input-effect">
                                    <input class="primary-input form-control{{ $errors->has('national_id_number') ? ' is-invalid' : '' }}" type="text" name="national_id_number" value="{{$student->national_id_no}}">
                                    <label>@lang('lang.national_iD_number') <span></span></label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('national_id_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('national_id_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-effect">
                                    <input class="primary-input form-control" type="text" name="local_id_number" value="{{$student->local_id_no}}">
                                    <label>@lang('lang.local_Id_Number') <span></span> </label>
                                    <span class="focus-border"></span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-effect">
                                    <input class="primary-input form-control" type="text" name="bank_account_number" value="{{$student->bank_account_no}}">
                                    <label>@lang('lang.bank_account') @lang('lang.number') <span></span> </label>
                                    <span class="focus-border"></span>
                                </div>
                            </div>

                        </div>
                        <div class="row mb-20 mt-40">
                            <div class="col-lg-6">
                                <div class="input-effect">
                                    <textarea class="primary-input form-control" cols="0" rows="4" name="previous_school_details">{{$student->previous_school_details}}</textarea>
                                    <label>@lang('lang.previous_school_details')</label>
                                    <span class="focus-border textarea"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-effect">
                                    <textarea class="primary-input form-control" cols="0" rows="4" name="additional_notes">{{$student->aditional_notes}}</textarea>
                                     <label>@lang('lang.additional_notes')</label>
                                    <span class="focus-border textarea"></span>
                                </div>
                            </div>
                        </div>

                        
                         <div class="row mb-20">
                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input class="primary-input" type="text" name="document_title_1" value="{{$student->document_title_1}}">
                                    <label>@lang('lang.document_01_title')</label>
                                    <span class="focus-border"></span>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="input-effect">
                                    <input class="primary-input" type="text" name="document_title_2" value="{{$student->document_title_2}}">
                                    <label>@lang('lang.document_02_title')</label>
                                    <span class="focus-border"></span>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="input-effect">
                                    <input class="primary-input" type="text" name="document_title_3" value="{{$student->document_title_3}}">
                                    <label>@lang('lang.document_03_title')</label>
                                    <span class="focus-border"></span>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="input-effect">
                                    <input class="primary-input" type="text" name="document_title_4" value="{{$student->document_title_4}}">
                                    <label>@lang('lang.document_04_title')</label>
                                    <span class="focus-border"></span>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input class="primary-input" type="text" name="document_title_5" value="{{$student->document_title_5}}">
                                    <label>@lang('document_05_title')</label>
                                    <span class="focus-border"></span>
                                </div>
                            </div>
                        </div>
                         <div class="row mb-20">
                             <div class="col-lg-3">
                                <div class="row no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect">
                                            <input class="primary-input" type="text" id="placeholderFileOneName" placeholder="{{$student->document_file_1 != ""? showPicNameDoc($student->document_file_1):'01'}}"
                                                disabled>
                                            <span class="focus-border"></span>
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
                             <div class="col-lg-2">
                                <div class="row no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect">
                                            <input class="primary-input" type="text" id="placeholderFileTwoName" placeholder="{{isset($student->document_file_2) && $student->document_file_2 != ""? showPicNameDoc($student->document_file_2):'02'}}"
                                                disabled>
                                            <span class="focus-border"></span>
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
                             <div class="col-lg-2">
                                <div class="row no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect">
                                            <input class="primary-input" type="text" id="placeholderFileThreeName" placeholder="{{isset($student->document_file_3) && $student->document_file_3 != ""? showPicNameDoc($student->document_file_3):'03'}}"
                                                disabled>
                                            <span class="focus-border"></span>
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
                             <div class="col-lg-2">
                                <div class="row no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect">
                                            <input class="primary-input" type="text" id="placeholderFileFourName" placeholder="{{isset($student->document_file_4) && $student->document_file_4 != ""? showPicNameDoc($student->document_file_4):'04'}}"
                                                disabled>
                                            <span class="focus-border"></span>
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
                             <div class="col-lg-3">
                                 <div class="row no-gutters input-right-icon">
                                     <div class="col">
                                         <div class="input-effect">
                                             <input class="primary-input" type="text" id="placeholderFileFiveName" placeholder="{{isset($student->document_file_5) && $student->document_file_5 != ""? showPicNameDoc($student->document_file_5):'05'}}"
                                                    disabled>
                                             <span class="focus-border"></span>
                                         </div>
                                     </div>
                                     <div class="col-auto">
                                         <button class="primary-btn-small-input" type="button">
                                             <label class="primary-btn small fix-gr-bg" for="document_file_5">@lang('lang.browse')</label>
                                             <input type="file" class="d-none" name="document_file_5" id="document_file_5">
                                         </button>
                                     </div>
                                 </div>
                             </div>
                        </div>
                        

                        <div class="row mt-5">
                            <div class="col-lg-12 text-center">
                                <button class="primary-btn fix-gr-bg">
                                    <span class="ti-check"></span>
                                    @lang('lang.update_student')
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


<div class="modal fade admin-query" id="removeSiblingModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('lang.remove')</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="text-center">
                        <h4>@lang('lang.are_you')</h4>
                    </div>

                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('lang.cancel')</button>
                        <button type="button" class="primary-btn fix-gr-bg" data-dismiss="modal" id="yesRemoveSibling">@lang('lang.delete')</button>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>


 {{-- student photo --}}
 <input type="text" id="STurl" value="{{ route('student_update_pic',$student->id)}}" hidden>
 <div class="modal" id="LogoPic">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Crop Image And Upload</h4>
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
                <a href="javascript:;" class="primary-btn fix-gr-bg pull-right" id="upload_logo">Crop</a>
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
                <h4 class="modal-title">Crop Image And Upload</h4>
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
                <a href="javascript:;" class="primary-btn fix-gr-bg pull-right" id="FatherPic_logo">Crop</a>
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
<script>
    $(document).ready(function() {


        $('#checkExternal').on("click", function () {
            $('#external').val(0);
            if($(this).is(":checked")) {
                $('#external').val(1);
                //  $(this).attr("checked");
            }

        })
    });
</script>
@endsection