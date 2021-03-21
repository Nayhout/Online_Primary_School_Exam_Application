@extends('backEnd.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('public/backEnd/')}}/css/croppie.css"
          xmlns="http://www.w3.org/1999/html">
@endsection
@section('mainContent')
    <style type="text/css">
        .form-control:disabled {
            background-color: #FFFFFF;
        }
    </style>
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('Add Generation Student')</h1>
                <div class="bc-pages">
                    <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                    <a href="{{ url('generate-edit') }}">@lang('Generation Student')</a>
                    <a href="#">@lang('Add Generation Student')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-8 col-md-6">
                    <div class="main-title">
                        <h3 class="mb-30">@lang('Add Generation Student') </h3>
                    </div>
                </div>
            </div>
            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'generate_store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
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

                            <div class="row mb-20">
                                <div class="col-lg-12">
                                    <hr>
                                </div>
                            </div>

                            <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                            <div class="row mb-30">

                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input class="primary-input form-control{{ $errors->has('generation_name') ? ' is-invalid' : '' }}"
                                               type="text" name="generation_name" value="{{old('generation_name')}}">
                                        <label>@lang('lang.name') *</label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('generation_name'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('generation_name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input class="primary-input form-control{{ $errors->has('generation_name_kh') ? ' is-invalid' : '' }}"
                                               type="text" name="generation_name_kh" value="{{old('generation_name_kh')}}">
                                        <label>@lang('Khmer Name') *</label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('generation_name_kh'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('generation_name_kh') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <select class="niceSelect w-100 bb form-control{{ $errors->has('academic_year') ? ' is-invalid' : '' }}"
                                                name="academic">
                                            <option data-display="@lang('lang.academic_year') *"
                                                    value="">@lang('lang.academic_year') *
                                            </option>
                                            @foreach($academic_year as $academic)
                                                <option value="{{$academic->title}}" {{old('academic_year') == $academic->title? 'selected': ''}}>{{$academic->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input class="primary-input form-control{{ $errors->has('note') ? ' is-invalid' : '' }}"
                                               type="text" name="note" value="{{old('note')}}">
                                        <label>@lang('note') *</label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('note'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('note') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row mt-40">
                            <div class="col-lg-12 text-center">
                                <button class="primary-btn fix-gr-bg">
                                    <span class="ti-check"></span>
                                    @lang('lang.save')

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

@endsection
@section('script')
    <script src="{{asset('public/backEnd/')}}/js/croppie.js"></script>
    <script src="{{asset('public/backEnd/')}}/js/editStaff.js"></script>
@endsection
