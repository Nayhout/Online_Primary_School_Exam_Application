<style>
    .upper_text{
        text-transform: uppercase;
    }
    @media only screen and (max-width: 991px){
        #sidebar.active {
            margin-left: 0px;
            z-index: 999;
            background: orange;
            box-shadow: 4px 0px 8px rgba(221, 221, 221, 0.4);
        }
    }

</style>
@php
    use App\SmGeneralSettings;
    $school_settings= SmGeneralSettings::where('school_id',Auth::user()->school_id)->first();
    if (Auth::user() == "") { header('location:' . url('/login')); exit(); }
    Session::put('permission', App\GlobalVariable::GlobarModuleLinks());
@endphp
@if(SmGeneralSettings::isModule('Saas')== TRUE && Auth::user()->is_administrator=="yes" && Session::get('isSchoolAdmin')==FALSE )
    @include('backEnd/partials/saas_menu')
    {{--  @elseif(Session::get('isSchoolAdmin')==TRUE && SmGeneralSettings::isModule('Saas')== TRUE && Auth::user()->is_administrator=="yes")  --}}


@else




    <input type="hidden" name="url" id="url" value="{{url('/')}}">
    <nav id="sidebar">
        <div class="sidebar-header update_sidebar">
            <a href="{{url('/')}}">
                <img  src="{{ file_exists(@$school_settings->logo) ? asset($school_settings->logo) : asset('public/uploads/settings/logo.png') }}" alt="logo" style="border-radius: 50%">
            </a>
            <a id="close_sidebar" class="d-lg-none">
                <i class="ti-close"></i>
            </a>
        </div>
        {{-- {{ Auth::user()->role_id }} --}}
        <ul class="list-unstyled components">
            @if(Auth::user()->role_id != 2 && Auth::user()->role_id != 3 )

                @if(@in_array(1, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                    <li>
                        <a href="{{url('/admin-dashboard')}}" id="admin-dashboard" style="color: white;font-size: 15px">
                            <span class="flaticon-speedometer"></span>
                            <b class="upper_text">  @lang('lang.dashboard') </b>
                        </a>
                        <div style=" height: 1px;background-color: grey !important;"></div>
                    </li>

                @endif

                @if(@in_array(11, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenuAdmin" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="color: white;font-size: 15px">
                            <span class="flaticon-analytics"></span>
                            <b class="upper_text">@lang('lang.admin_section')</b>
                        </a>
                        <div style=" height: 1px;background-color: grey !important;"></div>
                        <ul class="collapse list-unstyled" id="subMenuAdmin">
                            @if(@in_array(12, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('admission_query')}}" style="font-size: 15px">@lang('lang.admission_query')</a>
                                </li>
                            @endif
                            @if(@in_array(16, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('visitor')}}" style="font-size: 15px">@lang('lang.visitor_book') </a>
                                </li>
                            @endif
                            @if(@in_array(21, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('complaint')}}" style="font-size: 15px">@lang('lang.complaint')</a>
                                </li>
                            @endif
                            @if(@in_array(27, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('postal-receive')}}" style="font-size: 15px">@lang('lang.postal_receive')</a>
                                </li>
                            @endif
                            @if(@in_array(32, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('postal-dispatch')}}" style="font-size: 15px">@lang('lang.postal_dispatch')</a>
                                </li>
                            @endif
                            @if(@in_array(36, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('phone-call')}}" style="font-size: 15px">@lang('lang.phone_call_log')</a>
                                </li>
                            @endif
                            @if(@in_array(41, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('setup-admin')}}" style="font-size: 15px">@lang('lang.admin_setup')</a>
                                </li>
                            @endif
                            @if(@in_array(49, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('student-certificate')}}" style="font-size: 15px">@lang('lang.student_certificate')</a>
                                </li>
                            @endif
                            @if(@in_array(53, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('generate_certificate')}}" style="font-size: 15px">@lang('lang.generate_certificate')</a>
                                </li>
                            @endif
                            @if(@in_array(45, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('student-id-card')}}" style="font-size: 15px">@lang('lang.student_id_card')</a>
                                </li>
                            @endif
                            @if(@in_array(57, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('generate_id_card')}}" style="font-size: 15px">@lang('lang.generate_id_card')</a>
                                </li>
                            @endif
                            <li>
                                <a href="{{route('pick_up')}}" style="font-size: 15px"> @lang('lang.pickup_student')</a>
                            </li>

                            {{--                            <li>--}}
                            {{--                                <a href="{{route('generate_pick_up')}}"> @lang('Generate Pick Up')</a>--}}
                            {{--                            </li>--}}
                        </ul>
                    </li>

                @endif

                @if(SmGeneralSettings::isModule('ParentRegistration')== TRUE )
                    @if(@in_array(542, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                        <li>
                            <a href="#subMenuStudentRegistration" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="color: white;font-size: 15px">
                                <span class="flaticon-reading"></span>
                                <b class="upper_text"> @lang('lang.registration') </b>
                            </a>
                            <div style=" height: 1px;background-color: grey !important;"></div>
                            <ul class="collapse list-unstyled" id="subMenuStudentRegistration">
                                @if(@in_array(543, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{url('parentregistration/student-list')}}" style="font-size: 15px"> @lang('lang.student_list')</a>
                                    </li>
                                @endif
                                @if(SmGeneralSettings::isModule('Saas') != TRUE)
                                    @if(@in_array(547, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                        <li>
                                            <a href="{{url('parentregistration/settings')}}" style="font-size: 15px"> @lang('lang.settings')</a>
                                        </li>
                                    @endif
                                @endif
                            </ul>
                        </li>

                    @endif
                @endif




                @if(@in_array(61, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenuStudent" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="color: white;font-size: 15px">
                            <span class="flaticon-reading"></span>
                            <b class="upper_text">@lang('lang.student_information')</b>
                        </a>
                        <div style=" height: 1px;background-color: grey !important;"></div>
                        <ul class="collapse list-unstyled" id="subMenuStudent">

                            {{--                        @if(@in_array(800 , App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                            {{--                            <li>--}}
                            {{--                                <a href="{{route('register-student')}}"> @lang('Print Register Student')</a>--}}
                            {{--                            </li>--}}
                            {{--                        @endif--}}
                            @if(@in_array(71, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_category')}}" style="font-size: 15px"> @lang('lang.student_category')</a>
                                </li>
                            @endif
                            @if(@in_array(565, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                <li>
                                    <a href="{{url('generate-student')}}" style="font-size: 15px">@lang('Generation Student')</a>
                                </li>
                            @endif
                            @if(@in_array(64, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_list')}}" style="font-size: 15px"> @lang('lang.student_list')</a>
                                </li>
                            @endif


                            @if(@in_array(68, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_attendance')}}" style="font-size: 15px"> @lang('lang.student_attendance')</a>
                                </li>
                            @endif

                            @if(@in_array(70, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_attendance_report')}}" style="font-size: 15px"> @lang('lang.student_attendance_report')</a>
                                </li>
                            @endif

                            <li>
                                <a href="{{route('student_attendance_detail')}}" style="font-size: 15px"> @lang('Daily Attendance')</a>
                            </li>

                            @if(@in_array(533, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                <li>
                                    <a href="{{route('subject-wise-attendance')}}" style="font-size: 15px"> @lang('lang.subject') @lang('lang.wise') @lang('lang.attendance') </a>
                                </li>
                            @endif

                            @if(@in_array(535, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                <li>
                                    <a href="{{url('subject-attendance-report')}}" style="font-size: 15px"> @lang('lang.subject_attendance_report') </a>
                                </li>
                            @endif

                            @if(@in_array(62, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_admission')}}" style="font-size: 15px">@lang('lang.student_admission')</a>
                                </li>
                            @endif
                            @if(@in_array(76, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_group')}}" style="font-size: 15px">@lang('lang.student_group')</a>
                                </li>
                            @endif

                            @if(@in_array(81, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_promote')}}" style="font-size: 15px">@lang('lang.student_promote')</a>
                                </li>
                            @endif

                            @if(@in_array(83, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('disabled_student')}}" style="font-size: 15px">@lang('lang.disabled_student')</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif


                @if(@in_array(245, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenuAcademic" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="color: white;font-size: 15px">
                            <span class="flaticon-graduated-student"></span>
                            <b class="upper_text">@lang('lang.academics')</b>
                        </a>
                        <div style=" height: 1px;background-color: grey !important;"></div>
                        <ul class="collapse list-unstyled" id="subMenuAcademic">


                            {{--                        @if(@in_array(537, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}

                            {{--                            <li>--}}
                            {{--                                <a href="{{route('optional-subject')}}"> @lang('lang.optional') @lang('lang.subject') </a>--}}
                            {{--                            </li>--}}
                            {{--                        @endif--}}

                            @if(@in_array(257, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('subject')}}" style="font-size: 15px"> @lang('lang.subjects')</a>
                                </li>
                            @endif
                            @if(@in_array(273, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('class-time')}}" style="font-size: 15px"> @lang('lang.cl_ex_time_setup')</a>
                                </li>
                            @endif
                            @if(@in_array(253, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('assign-class-teacher')}}" style="font-size: 15px"> @lang('lang.assign_class_teacher')</a>
                                </li>
                            @endif
                            @if(@in_array(250, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('assign_subject')}}" style="font-size: 15px"> @lang('lang.assign_subject')</a>
                                </li>
                            @endif
                            @if(@in_array(246, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('class_routine_new')}}" style="font-size: 15px"> @lang('lang.class_routine')</a>

                                </li>
                            @endif

                        <!-- only for teacher -->
                            @if(Auth::user()->role_id == 4)
                                <li>
                                    <a href="{{url('view-teacher-routine')}}" style="font-size: 15px">@lang('lang.view') @lang('lang.class_routine')</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif



                @if(@in_array(87, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenuTeacher" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="color: white;font-size: 15px">
                            <span class="flaticon-professor"></span>
                            <b class="upper_text">@lang('lang.study_material')</b>
                        </a>
                        <div style=" height: 1px;background-color: grey !important;"></div>
                        <ul class="collapse list-unstyled" id="subMenuTeacher">
                            @if(@in_array(88, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('upload-content')}}" style="font-size: 15px"> @lang('lang.upload_content')</a>
                                </li>
                            @endif

                            @if(@in_array(92, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('assignment-list')}}" style="font-size: 15px">@lang('lang.assignment')</a>
                                </li>
                            @endif

                            {{-- @if(@in_array(96, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('study-metarial-list')}}">@lang('lang.study_material')</a>
                                </li>
                            @endif --}}

                            @if(@in_array(100, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('syllabus-list')}}" style="font-size: 15px">@lang('lang.syllabus')</a>
                                </li>
                            @endif

                            @if(@in_array(105, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('other-download-list')}}" style="font-size: 15px">@lang('lang.other_download')</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(@in_array(108, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                    @if(SmGeneralSettings::isModule('FeesCollection')== TRUE)
                                        <li>
                                            <a href="#subMenuFeesCollection" data-toggle="collapse" aria-expanded="false"
                                            class="dropdown-toggle" style="font-size: 15px;color: whitesmoke">
                                                <span class="flaticon-wallet"></span>
                                                <b>@lang('lang.fees_collection')</b>
                                            </a>
                                            <div style=" height: 1px;background-color: grey !important;"></div>
                                            <ul class="collapse list-unstyled" id="subMenuFeesCollection" style="font-size: 15px;">
                                                <li>
                                                    <a href="{{url('feescollection/fees-term')}}"> @lang('lang.fees') @lang('lang.term')</a>
                                                </li>
                                                <li>
                                                    <a href="{{url('feescollection/fees-type')}}">  @lang('lang.fees_type')</a>
                                                </li>
                                                <li>
                                                    <a href="{{url('feescollection/fees-type-assign')}}">  @lang('lang.fees_type') @lang('lang.assign')</a>
                                                </li>
                                                <li>
                                                    <a href="{{url('feescollection/fine-setup')}}"> @lang('lang.fees')  @lang('lang.fine') @lang('lang.setup')</a>
                                                </li>
                                                <li>
                                                    <a href="{{url('feescollection/fees-discount')}}"> @lang('lang.fees_discount')</a>
                                                </li>

                                                <li>
                                                    <a href="{{url('feescollection/assign-discount')}}">  @lang('lang.assign') @lang('lang.discount')</a>
                                                </li>

                                                <li>
                                                    <a href="{{url('feescollection/fees-master')}}"> @lang('lang.fees_master')</a>
                                                </li>

                                                <li>
                                                    <a href="{{route('collect_fees_final')}}">@lang('lang.collect_fees')</a>
                                                </li>
                                                <li>
                                                    <a href="{{url('feescollection/term-wise-report')}}"> @lang('lang.term_wise_report')</a>
                                                </li>
                                                <li>
                                                    <a href="{{url('feescollection/term-wise-students-report')}}"> @lang('lang.term_wise_report') @lang('lang.student') </a>
                                                </li>
                                                <li>
                                                    <a href="{{url('feescollection/type-wise-report')}}"> @lang('lang.type_wise_report')</a>
                                                </li>
                                                <li>
                                                    <a href="{{url('feescollection/fees-due-report')}}">  @lang('lang.due_wise_report')</a>
                                                </li>


                                            </ul>
                                        </li>
                                    @else
                                        <li>
                                            <a href="#subMenuFeesCollection" data-toggle="collapse" aria-expanded="false"
                                            class="dropdown-toggle" style="font-size: 15px;color: whitesmoke">
                                                <span class="flaticon-wallet"></span>
                                                <b class="upper_text">@lang('lang.fees_collection')</b>
                                            </a>
                                            <div style=" height: 1px;background-color: grey !important;"></div>
                                            <ul class="collapse list-unstyled" id="subMenuFeesCollection" >
                                                @if(@in_array(123, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                                    <li>
                                                        <a href="{{route('fees_group')}}" style="font-size: 15px"> @lang('lang.fees_group')</a>
                                                    </li>
                                                @endif
                                                @if(@in_array(127, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                                    <li>
                                                        <a href="{{route('fees_type')}}" style="font-size: 15px"> @lang('lang.fees_type')</a>
                                                    </li>
                                                @endif
                                                @if(@in_array(151, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                                    <li>
                                                        <a href="{{route('fees_discount')}}" style="font-size: 15px"> @lang('lang.fees_discount')</a>
                                                    </li>
                                                @endif
                                                @if(@in_array(118, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                                    <li>
                                                        <a href="{{url('fees-master')}}" style="font-size: 15px"> @lang('lang.fees_master')</a>
                                                    </li>
                                                @endif
                                                @if(@in_array(109, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                                    <li>
                                                        <a href="{{route('collect_fees')}}" style="font-size: 15px"> @lang('lang.collect_fees')</a>
                                                    </li>
                                                @endif
                                                @if(@in_array(115, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                                    <li>
                                                        <a href="{{route('search_fees_payment')}}" style="font-size: 15px"> @lang('lang.search_fees_payment')</a>
                                                    </li>
                                                @endif
                                                @if(@in_array(116, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                                    <li>
                                                        <a href="{{route('search_fees_due')}}" style="font-size: 15px"> @lang('lang.search_fees_due')</a>
                                                    </li>
                                                @endif


                                                 @if(@in_array(156, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                                    <li>
                                                        <a href="{{route('fees_forward')}}" style="font-size: 15px">@lang('lang.fees_forward')</a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </li>
                                    @endif
                    {{--                --}}{{-- check module enble or not --}}

                @endif
                {{--            --}}{{-- check module link permission --}}

                            @if(@in_array(157, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="#subMenuAccount" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="font-size: 15px;color: whitesmoke">
                                        <span class="flaticon-accounting"></span>
                                        <b class="upper_text">@lang('lang.accounts')</b>
                                    </a>
                                    <div style=" height: 1px;background-color: grey !important;"></div>
                                    <ul class="collapse list-unstyled" id="subMenuAccount">
                                        @if(@in_array(148, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                            <li>
                                                <a href="{{url('chart-of-account')}}" style="font-size: 15px"> @lang('lang.chart_of_account')</a>
                                            </li>
                                        @endif

                                        @if(@in_array(156, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                            <li>
                                                <a href="{{url('bank-account')}}" style="font-size: 15px"> @lang('lang.bank_account')</a>
                                            </li>
                                        @endif
                                        @if(@in_array(159, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                            <li>
                                                <a href="{{route('add_income')}}" style="font-size: 15px"> @lang('lang.income')</a>
                                            </li>
                                        @endif
                                        @if(@in_array(158, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                            <li>
                                                <a href="{{route('profit')}}" style="font-size: 15px"> @lang('lang.profit')</a>
                                            </li>
                                        @endif

                                        @if(@in_array(143, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                            <li>
                                                <a href="{{url('add-expense')}}" style="font-size: 15px"> @lang('lang.expense')</a>
                                            </li>
                                        @endif
                                        @if(@in_array(147, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                            <li>
                                                <a href="{{route('search_account')}}" style="font-size: 15px"> @lang('lang.search')</a>
                                            </li>
                                        @endif

                                    </ul>
                                </li>
                            @endif

                @if(@in_array(160, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenuHumanResource" data-toggle="collapse" aria-expanded="false" style="color: white;font-size: 15px"
                           class="dropdown-toggle">
                            <span class="flaticon-consultation"></span>
                            <b class="upper_text">@lang('lang.human_resource')</b>
                        </a>
                        <div style=" height: 1px;background-color: grey !important;"></div>
                        <ul class="collapse list-unstyled" id="subMenuHumanResource">
                            @if(@in_array(180, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('designation')}}" style="font-size: 15px"> @lang('lang.designation')</a>
                                </li>
                            @endif
                            @if(@in_array(184, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('department')}}" style="font-size: 15px"> @lang('lang.department')</a>
                                </li>
                            @endif
                            @if(@in_array(161, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('staff_directory')}}" style="font-size: 15px"> @lang('lang.staff_directory')</a>
                                </li>
                            @endif

                            @if(Auth::user()->role_id == 1)
                                 <li>
                                     <a href="{{route('staff_promote')}}" style="font-size: 15px"> Staff Promotion</a>
                                 </li>
                            @endif
                            @if(Auth::user()->role_id == 1)
                                 <li>
                                     <a href="#" style="font-size: 15px"> Staff Promotion Record</a>
                                 </li>
                            @endif
                            @if(@in_array(165, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('staff_attendance')}}" style="font-size: 15px"> @lang('lang.staff_attendance')</a>
                                </li>
                            @endif
                            @if(@in_array(169, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('staff_attendance_report')}}" style="font-size: 15px"> @lang('lang.staff_attendance_report')</a>
                                </li>
                            @endif


                            @if(@in_array(170, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('payroll')}}" style="font-size: 15px"> @lang('lang.payroll')</a>
                                </li>
                            @endif
                            @if(@in_array(178, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('payroll-report')}}" style="font-size: 15px"> @lang('lang.payroll_report')</a>
                                </li>
                            @endif
                            @if(Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('staff-id-card')}}" style="font-size: 15px">Staff ID Card</a>
                                </li>
                            @endif
                            @if(Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('generate_staff_id_card')}}" style="font-size: 15px">Generate Card</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif

                @if(@in_array(188, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenuLeaveManagement" data-toggle="collapse" aria-expanded="false" style="color: white;font-size: 15px"
                           class="dropdown-toggle">
                            <span class="flaticon-slumber"></span>
                            <b class="upper_text">@lang('lang.leave')</b>
                        </a>
                        <div style=" height: 1px;background-color: grey !important;"></div>
                        <ul class="collapse list-unstyled" id="subMenuLeaveManagement">
                            @if(@in_array(203, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('leave-type')}}" style="font-size: 15px"> @lang('lang.leave_type')</a>
                                </li>
                            @endif
                            @if(@in_array(199, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('leave-define')}}" style="font-size: 15px"> @lang('lang.leave_define')</a>
                                </li>
                            @endif
                            @if(@in_array(189, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('approve-leave')}}" style="font-size: 15px">@lang('lang.approve_leave_request')</a>
                                </li>
                            @endif
                            {{--                        @if(@in_array(196, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                            {{--                            <li>--}}
                            {{--                                <a href="{{url('pending-leave')}}">@lang('lang.pending_leave_request')</a>--}}
                            {{--                            </li>--}}
                            {{--                        @endif--}}
                            @if(@in_array(193, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('apply-leave')}}" style="font-size: 15px">@lang('lang.apply_leave')</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif

                @if(@in_array(207, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenuExam" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="color: white;font-size: 15px">
                            <span class="flaticon-test"></span>
                            <b class="upper_text">@lang('lang.examination')</b>
                        </a>
                        <div style=" height: 1px;background-color: grey !important;"></div>
                        <ul class="collapse list-unstyled" id="subMenuExam">
                            @if(@in_array(225, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('marks-grade')}}" style="font-size: 15px"> @lang('lang.marks_grade')</a>
                                </li>
                            @endif
                            @if(@in_array(208, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('exam-type')}}" style="font-size: 15px"> @lang('lang.add_exam_type')</a>
                                </li>
                            @endif
                            @if(@in_array(214, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('exam')}}" style="font-size: 15px"> @lang('lang.exam_setup')</a>
                                </li>
                            @endif

                            @if(@in_array(217, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('exam_schedule')}}" style="font-size: 15px"> @lang('lang.exam_schedule')</a>
                                </li>
                            @endif


                            @if(@in_array(554, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('exam_attendance')}}" style="font-size: 15px"> @lang('lang.exam_attendance')</a>
                                </li>
                            @endif

                            @if(@in_array(558, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('marks_register')}}" style="font-size: 15px"> @lang('lang.marks_register')</a>
                                </li>
                            @endif


                            @if(@in_array(229, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('send_marks_by_sms')}}" style="font-size: 15px"> @lang('lang.send_marks_by_sms')</a>
                                </li>
                            @endif
                            @if(@in_array(230, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('question-group')}}" style="font-size: 15px">@lang('lang.question_group')</a>
                                </li>
                            @endif
                            @if(@in_array(234, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('question-bank')}}" style="font-size: 15px">@lang('lang.question_bank')</a>
                                </li>
                            @endif
                            @if(@in_array(238, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('online-exam')}}" style="font-size: 15px">@lang('lang.online_exam')</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif



                @if(@in_array(277, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                    <li>
                        <a href="#subMenuHomework" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="color: white;font-size: 15px">
                            <span class="flaticon-book"></span>
                            <b class="upper_text">@lang('lang.home_work')</b>
                        </a>
                        <div style=" height: 1px;background-color: grey !important;"></div>
                        <ul class="collapse list-unstyled" id="subMenuHomework">
                            @if(@in_array(278, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('add-homeworks')}}" style="font-size: 15px"> @lang('lang.add_homework')</a>
                                </li>
                            @endif
                            @if(@in_array(280, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('homework-list')}}" style="font-size: 15px"> @lang('lang.homework_list')</a>
                                </li>
                            @endif
                            @if(@in_array(284, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('evaluation-report')}}" style="font-size: 15px"> @lang('lang.evaluation_report')</a>
                                </li>
                            @endif
                        </ul>
                    </li>

                @endif

                @if(@in_array(286, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenuCommunicate" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="color: white;font-size: 15px">
                            <span class="flaticon-email"></span>
                            <b class="upper_text">@lang('lang.communicate')</b>
                        </a>
                        <div style=" height: 1px;background-color: grey !important;"></div>
                        <ul class="collapse list-unstyled" id="subMenuCommunicate">
                            @if(@in_array(287, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('notice-list')}}" style="font-size: 15px">@lang('lang.notice_board')</a>
                                </li>
                            @endif
                            @if (@$config->Saas == 1 && Auth::user()->is_administrator != "yes" )

                                <li>
                                    <a href="{{url('administrator-notice')}}" style="font-size: 15px">@lang('lang.administrator') @lang('lang.notice')</a>
                                </li>

                            @endif
                            {{--
                            @if(@in_array(73, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                            <li>
                                 <a href="{{url('send-message')}}">@lang('lang.send_message')</a>
                            </li>
                            @endif
                            --}}
                            @if(@in_array(291, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('send-email-sms-view')}}" style="font-size: 15px">@lang('lang.send_email')</a>
                                </li>
                            @endif
                            @if(@in_array(293, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('email-sms-log')}}" style="font-size: 15px">@lang('lang.email_sms_log')</a>
                                </li>
                            @endif
                            @if(@in_array(294, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('event')}}" style="font-size: 15px">@lang('lang.event')</a>
                                </li>
                            @endif
                            @if(@in_array(294, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('to-do-list')}}" style="font-size: 15px">@lang('lang.to_do_list')</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(@in_array(298, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenulibrary" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="color: white;font-size: 15px">
                            <span class="flaticon-book-1"></span>
                            <b class="upper_text">@lang('lang.library')</b>
                        </a>
                        <div style=" height: 1px;background-color: grey !important;"></div>
                        <ul class="collapse list-unstyled" id="subMenulibrary">
                            @if(@in_array(304, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('book-category-list')}}" style="font-size: 15px"> @lang('lang.book_category')</a>
                                </li>
                            @endif
                            @if(@in_array(299, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('add-book')}}" style="font-size: 15px"> @lang('lang.add_book')</a>
                                </li>
                            @endif
                            @if(@in_array(301, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('book-list')}}" style="font-size: 15px"> @lang('lang.book_list')</a>
                                </li>
                            @endif

                            @if(@in_array(308, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('library-member')}}" style="font-size: 15px"> @lang('lang.library_member')</a>
                                </li>
                            @endif
                            @if(@in_array(311, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('member-list')}}" style="font-size: 15px"> @lang('lang.member_list')</a>
                                </li>
                            @endif
                            @if(@in_array(314, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('all-issed-book')}}" style="font-size: 15px"> @lang('lang.all_issued_book')</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                {{--            @if(@in_array(315, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                {{--                <li>--}}
                {{--                    <a href="#subMenuInventory" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="font-size: 15px;color: whitesmoke">--}}
                {{--                        <span class="flaticon-inventory"></span>--}}
                {{--                        @lang('lang.inventory')--}}
                {{--                    </a>--}}
                {{--                    <div style=" height: 1px;background-color: grey !important;"></div>--}}
                {{--                    <ul class="collapse list-unstyled" id="subMenuInventory">--}}
                {{--                        @if(@in_array(316, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                {{--                            <li>--}}
                {{--                                <a href="{{url('item-category')}}" style="font-size: 15px"> @lang('lang.item_category')</a>--}}
                {{--                            </li>--}}
                {{--                        @endif--}}
                {{--                        @if(@in_array(320, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                {{--                            <li>--}}
                {{--                                <a href="{{url('item-list')}}" style="font-size: 15px"> @lang('lang.item_list')</a>--}}
                {{--                            </li>--}}
                {{--                        @endif--}}
                {{--                        @if(@in_array(324, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                {{--                            <li>--}}
                {{--                                <a href="{{url('item-store')}}" style="font-size: 15px"> @lang('lang.item_store')</a>--}}
                {{--                            </li>--}}
                {{--                        @endif--}}
                {{--                        @if(@in_array(328, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                {{--                            <li>--}}
                {{--                                <a href="{{url('suppliers')}}" style="font-size: 15px"> @lang('lang.supplier')</a>--}}
                {{--                            </li>--}}
                {{--                        @endif--}}
                {{--                        @if(@in_array(332, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                {{--                            <li>--}}
                {{--                                <a href="{{url('item-receive')}}" style="font-size: 15px"> @lang('lang.item_receive')</a>--}}
                {{--                            </li>--}}
                {{--                        @endif--}}
                {{--                        @if(@in_array(334, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                {{--                            <li>--}}
                {{--                                <a href="{{url('item-receive-list')}}" style="font-size: 15px"> @lang('lang.item_receive_list')</a>--}}
                {{--                            </li>--}}
                {{--                        @endif--}}
                {{--                        @if(@in_array(339, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                {{--                            <li>--}}
                {{--                                <a href="{{url('item-sell-list')}}" style="font-size: 15px"> @lang('lang.item_sell')</a>--}}
                {{--                            </li>--}}
                {{--                        @endif--}}
                {{--                        @if(@in_array(345, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                {{--                            <li>--}}
                {{--                                <a href="{{url('item-issue')}}" style="font-size: 15px"> @lang('lang.item_issue')</a>--}}
                {{--                            </li>--}}
                {{--                        @endif--}}
                {{--                    </ul>--}}
                {{--                </li>--}}
                {{--            @endif--}}

                {{--@if(@in_array(348, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                {{--<li>--}}
                {{--<a href="#subMenuTransport" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="color: black">--}}
                {{--<span class="flaticon-bus"></span>--}}
                {{--<b>@lang('lang.transport')</b>--}}
                {{--</a>--}}
                {{--<ul class="collapse list-unstyled" id="subMenuTransport">--}}
                {{--@if(@in_array(349, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                {{--<li>--}}
                {{--<a href="{{url('transport-route')}}"> @lang('lang.routes')</a>--}}
                {{--</li>--}}
                {{--@endif--}}
                {{--@if(@in_array(353, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                {{--<li>--}}
                {{--<a href="{{url('vehicle')}}"> @lang('lang.vehicle')</a>--}}
                {{--</li>--}}
                {{--@endif--}}
                {{--@if(@in_array(357, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                {{--<li>--}}
                {{--<a href="{{url('assign-vehicle')}}"> @lang('lang.assign_vehicle')</a>--}}
                {{--</li>--}}
                {{--@endif--}}
                {{--@if(@in_array(361, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                {{--<li>--}}
                {{--<a href="{{route('student_transport_report')}}"> @lang('lang.student_transport_report')</a>--}}
                {{--</li>--}}
                {{--@endif--}}
                {{--</ul>--}}
                {{--</li>--}}
                {{--@endif--}}

                @if(@in_array(362, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenuDormitory" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="color: white;font-size: 15px">
                            <span class="flaticon-hotel"></span>
                            <b class="upper_text">@lang('lang.dormitory')</b>
                        </a>
                        <div style=" height: 1px;background-color: grey !important;"></div>
                        <ul class="collapse list-unstyled" id="subMenuDormitory">
                            @if(@in_array(371, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('room-type')}}" style="font-size: 15px"> @lang('lang.room_type')</a>
                                </li>
                            @endif
                            @if(@in_array(367, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('dormitory-list')}}" style="font-size: 15px"> @lang('lang.dormitory')</a>
                                </li>
                            @endif
                            @if(@in_array(363, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('room-list')}}" style="font-size: 15px"> @lang('lang.dormitory_rooms')</a>
                                </li>
                            @endif


                            @if(@in_array(375, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_dormitory_report')}}" style="font-size: 15px"> @lang('lang.student_dormitory_report')</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                {{-- @if(App\SmGeneralSettings::isModule('Saas')== TRUE)
                @else
                @endif --}}
                @if(App\SmGeneralSettings::isModule('Saas')== FALSE)
                    @if(@in_array(530, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                        <li>
                            <a href="#certificate_foundation" data-toggle="collapse" aria-expanded="false" style="color: white;font-size: 15px"
                               class="dropdown-toggle">
                                <span class="flaticon-software"></span>
                                <b class="upper_text">@lang('Student Certificate')</b>
                            </a>
                            <div style=" height: 1px;background-color: grey !important;"></div>
                            <ul class="collapse list-unstyled" id="certificate_foundation">
                                @if(@in_array(431, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{url('foundation')}}" style="font-size: 15px"> @lang('Foundation Certificate') </a>
                                    </li>
                                @endif
                                {{--                                @if(@in_array(532, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                                {{--                                    <li>--}}
                                {{--                                        <a href="{{url('#')}}" style="font-size: 15px"> @lang('Academic Certificate') </a>--}}
                                {{--                                    </li>--}}
                                {{--                                @endif--}}
                                {{--                                @if(@in_array(532, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                                {{--                                    <li>--}}
                                {{--                                        <a href="{{url('#')}}" style="font-size: 15px"> @lang('Master Certificate') </a>--}}
                                {{--                                    </li>--}}
                                {{--                                @endif--}}
                            </ul>
                        </li>
                    @endif
                @endif
                @if(App\SmGeneralSettings::isModule('Saas')== FALSE)
                    @if(@in_array(530, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                        <li>
                            <a href="#Student_report" data-toggle="collapse" aria-expanded="false" style="color: white;font-size: 15px"
                               class="dropdown-toggle">
                                <span class="flaticon-software"></span>
                                <b class="upper_text">@lang('Student Report')</b>
                            </a>
                            <div style=" height: 1px;background-color: grey !important;"></div>
                            <ul class="collapse list-unstyled" id="Student_report">

                                <a href="#foundation_report" data-toggle="collapse" aria-expanded="false" style="color: #000000;font-size: 15px"
                                   class="dropdown-toggle">
                                    <span class="flaticon-software"></span>
                                    <b>@lang('Student Foundation')</b>
                                </a>
                                <ul class="collapse list-unstyled" id="foundation_report">
                                    @if(@in_array(431, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                        <li>
                                            <a href="{{url('#')}}" style="font-size: 15px"> @lang('Student Foundation') </a>
                                        </li>
                                    @endif
                                    @if(@in_array(601, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                        <li>
                                            <a href="{{url('re-study')}}" style="font-size: 15px"> @lang('Student Re-Study') </a>
                                        </li>
                                    @endif
                                </ul>

{{--                                <a href="#academic_report" data-toggle="collapse" aria-expanded="false" style="color: #000000;font-size: 15px"--}}
{{--                                   class="dropdown-toggle">--}}
{{--                                    <span class="flaticon-software"></span>--}}
{{--                                    <b class="upper_text">@lang('Student Academic')</b>--}}
{{--                                </a>--}}
{{--                                <div style=" height: 1px;background-color: grey !important;"></div>--}}
{{--                                <ul class="collapse list-unstyled" id="academic_report">--}}
{{--                                    @if(@in_array(431, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
{{--                                        <li>--}}
{{--                                            <a href="{{url('#')}}" style="font-size: 15px"> @lang('Student Academic') </a>--}}
{{--                                        </li>--}}
{{--                                    @endif--}}
{{--                                </ul>--}}

{{--                                <a href="#master_report" data-toggle="collapse" aria-expanded="false" style="color: #000000;font-size: 15px"--}}
{{--                                   class="dropdown-toggle">--}}
{{--                                    <span class="flaticon-software"></span>--}}
{{--                                    <b>@lang('Student Master')</b>--}}
{{--                                </a>--}}
{{--                                <div style=" height: 1px;background-color: grey !important;"></div>--}}
{{--                                <ul class="collapse list-unstyled" id="master_report">--}}
{{--                                    @if(@in_array(431, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
{{--                                        <li>--}}
{{--                                            <a href="{{url('#')}}" style="font-size: 15px"> @lang('Student Master') </a>--}}
{{--                                        </li>--}}
{{--                                    @endif--}}
{{--                                </ul>--}}

                            </ul>
                        </li>
                    @endif
                @endif
                @if(@in_array(376, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenusystemReports" data-toggle="collapse" aria-expanded="false" style="color: white;font-size: 15px"
                           class="dropdown-toggle">
                            <span class="flaticon-analysis"></span>
                            <b class="upper_text">@lang('lang.reports')</b>
                        </a>
                        <div style=" height: 1px;background-color: grey !important;"></div>
                        <ul class="collapse list-unstyled" id="subMenusystemReports">
                            @if(@in_array(538, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                <li>
                                    <a href="{{route('student_report')}}" style="font-size: 15px">@lang('lang.student_report')</a>
                                </li>
                            @endif
                            @if(@in_array(1010, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                <li>
                                    <a href="{{route('student_degree_report')}}" style="font-size: 15px">@lang('Student Degree Report')</a>
                                </li>
                            @endif
                            @if(@in_array(1005, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                <li>
                                    <a href="{{route('student_scholarship')}}" style="font-size: 15px">@lang('List Student Scholarship')</a>
                                </li>
                            @endif
                            @if(@in_array(1008, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                <li>
                                    <a href="{{route('student_private')}}" style="font-size: 15px">@lang('List Student Private')</a>
                                </li>
                            @endif
                            @if(@in_array(377, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('guardian_report')}}" style="font-size: 15px">@lang('lang.guardian_report')</a>
                                </li>
                            @endif
                            @if(@in_array(378, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_history')}}" style="font-size: 15px">@lang('lang.student_history')</a>
                                </li>
                            @endif
                            @if(@in_array(379, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_login_report')}}" style="font-size: 15px">@lang('lang.student_login_report')</a>
                                </li>
                            @endif
                            {{--                        @if(@in_array(381, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                            {{--                            <li>--}}
                            {{--                                <a href="{{route('fees_statement')}}">@lang('lang.fees_statement')</a>--}}
                            {{--                            </li>--}}
                            {{--                        @endif--}}
                            {{--                        @if(@in_array(382, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                            {{--                            <li>--}}
                            {{--                                <a href="{{route('balance_fees_report')}}">@lang('lang.balance_fees_report')</a>--}}
                            {{--                            </li>--}}
                            {{--                        @endif--}}
                            {{--                        @if(@in_array(383, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                            {{--                            <li>--}}
                            {{--                                <a href="{{route('transaction_report')}}">@lang('lang.transaction_report')</a>--}}
                            {{--                            </li>--}}
                            {{--                        @endif--}}
                            {{--                        @if(@in_array(384, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                            {{--                            <li>--}}
                            {{--                                <a href="{{route('class_report')}}">@lang('lang.class_report')</a>--}}
                            {{--                            </li>--}}
                            {{--                        @endif--}}
                            @if(@in_array(385, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('class_routine_report')}}" style="font-size: 15px">@lang('lang.class_routine')</a>
                                </li>
                            @endif
                            @if(@in_array(386, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('exam_routine_report')}}" style="font-size: 15px">@lang('lang.exam_routine')</a>
                                </li>
                            @endif
                            @if(@in_array(387, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('teacher_class_routine_report')}}" style="font-size: 15px">@lang('lang.teacher') @lang('lang.class_routine')</a>
                                </li>
                            @endif
                            @if(@in_array(388, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('merit_list_report')}}" style="font-size: 15px">@lang('lang.merit_list_report')</a>
                                </li>
                            @endif
                            @if(@in_array(388, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_exam_report')}}" style="font-size: 15px">@lang('student exam report')</a>
                                </li>
                            @endif
                            @if(@in_array(432, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('student_exam_type_report')}}" style="font-size: 15px">@lang('Student Exam Type Report')</a>
                                </li>
                            @endif
                            {{--                        @if(@in_array(388, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                            {{--                            <li>--}}
                            {{--                                <a href="{{url('custom-merit-list')}}">@lang('custom') @lang('lang.merit_list_report')</a>--}}
                            {{--                            </li>--}}
                            {{--                        @endif--}}
                            @if(@in_array(389, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('online_exam_report')}}" style="font-size: 15px">@lang('lang.online_exam_report')</a>
                                </li>
                            @endif
                            {{--                                                    @if(@in_array(390, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                            {{--                                                        <li>--}}
                            {{--                                                            <a href="{{route('mark_sheet_report_student')}}">@lang('lang.mark_sheet_report')</a>--}}
                            {{--                                                        </li>--}}
                            {{--                                                    @endif--}}
                            @if(@in_array(391, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('tabulation_sheet_report')}}" style="font-size: 15px">@lang('lang.tabulation_sheet_report')</a>
                                </li>
                            @endif
                            @if(@in_array(392, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('progress_card_report')}}" style="font-size: 15px">@lang('lang.progress_card_report')</a>
                                </li>
                            @endif
                            {{--                        @if(@in_array(392, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                            {{--                            <li>--}}
                            {{--                                <a href="{{url('custom-progress-card')}}"> @lang('lang.custom') @lang('lang.progress_card_report')</a>--}}
                            {{--                            </li>--}}
                            {{--                        @endif--}}
                            {{--                        @if(@in_array(393, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                            {{--                            <li>--}}
                            {{--                                <a href="{{route('student_fine_report')}}">@lang('lang.student_fine_report')</a>--}}
                            {{--                            </li>--}}
                            {{--                        @endif--}}
                            @if(@in_array(394, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('user_log')}}" style="font-size: 15px">@lang('lang.user_log')</a>
                                </li>
                            @endif
                            @if(@in_array(539, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('previous-class-results')}}" style="font-size: 15px">@lang('lang.previous') @lang('lang.result') </a>
                                </li>
                            @endif
                            @if(@in_array(540, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('previous-record')}}" style="font-size: 15px">@lang('lang.previous') @lang('lang.record') </a>
                                </li>
                            @endif
                            {{-- New Client report start --}}



                            @if(SmGeneralSettings::isModule('ResultReports') == TRUE)
                                {{-- ResultReports --}}
                                <li>
                                    <a href="{{url('resultreports/cumulative-sheet-report')}}">@lang('lang.cumulative') @lang('lang.sheet') @lang('lang.report')</a>
                                </li>

                                <li>
                                    <a href="{{url('resultreports/continuous-assessment-report')}}">@lang('lang.contonuous') @lang('lang.assessment') @lang('lang.report')</a>
                                </li>
                                <li>

                                    <a href="{{url('resultreports/termly-academic-report')}}">@lang('lang.termly') @lang('lang.academic') @lang('lang.report')</a>
                                </li>
                                <li>

                                    <a href="{{url('resultreports/academic-performance-report')}}">@lang('lang.academic') @lang('lang.performance') @lang('lang.report')</a>
                                </li>
                                <li>

                                    <a href="{{url('resultreports/terminal-report-sheet')}}">@lang('lang.terminal') @lang('lang.report') @lang('lang.sheet')</a>
                                </li>
                                <li>

                                    <a href="{{url('resultreports/continuous-assessment-sheet')}}">@lang('lang.continuous') @lang('lang.assessment') @lang('lang.sheet')</a>
                                </li>
                                <li>

                                    <a href="{{url('resultreports/result-version-two')}}">@lang('lang.result') @lang('lang.version') V2</a>
                                </li>
                                <li>

                                    <a href="{{url('resultreports/result-version-three')}}">@lang('lang.result') @lang('lang.version') V3</a>
                                </li>
                                {{--End New result result report --}}
                            @endif


                        </ul>
                    </li>
                @endif

                @if(App\SmGeneralSettings::isModule('Saas')== FALSE)
                    @if(@in_array(530, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                        <li>
                            <a href="#Settings" data-toggle="collapse" aria-expanded="false" style="color: white;font-size: 15px"
                               class="dropdown-toggle">
                                <span class="flaticon-software"></span>
                                <b class="upper_text">@lang('Students setting')</b>
                            </a>
                            <div style=" height: 1px;background-color: grey !important;"></div>
                            <ul class="collapse list-unstyled" id="Settings">
                                @if(@in_array(431, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{url('faculty')}}" style="font-size: 15px"> @lang('Faculty') </a>
                                    </li>
                                @endif
                                @if(@in_array(855, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{url('majors')}}" style="font-size: 15px"> @lang('Major') </a>
                                    </li>
                                @endif
                                @if(@in_array(532, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{url('#')}}" style="font-size: 15px"> @lang('Subject') </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                @if(@in_array(398, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenusystemSettings" data-toggle="collapse" aria-expanded="false" style="color: white;font-size: 15px"
                           class="dropdown-toggle">
                            <span class="flaticon-settings"></span>
                            <b class="upper_text">@lang('lang.system_settings')</b>
                        </a>
                        <div style=" height: 1px;background-color: grey !important;"></div>
                        <ul class="collapse list-unstyled" id="subMenusystemSettings">

                            @if(App\SmGeneralSettings::isModule('RazorPay')== TRUE && Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('razorpay/about')}}" style="font-size: 15px">Razorpay</a>
                                </li>
                            @endif




                            {{-- @endif --}}
                            @if(App\SmGeneralSettings::isModule('Saas')== TRUE)
                                <li>
                                    <a href="{{url('school-general-settings')}}" style="font-size: 15px"> @lang('lang.general_settings')</a>
                                </li>
                            @else
                                @if(@in_array(405, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                    <li>
                                        <a href="{{url('general-settings')}}" style="font-size: 15px"> @lang('lang.general_settings')</a>
                                    </li>
                                @endif
                            @endif




                            @if(@in_array(417, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                <li>
                                    <a href="{{url('rolepermission/role')}}" style="font-size: 15px">@lang('lang.role')</a>
                                </li>
                            @endif


                            @if(@in_array(421, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                <li>
                                    <a href="{{url('login-access-control')}}" style="font-size: 15px">@lang('lang.login_permission')</a>
                                </li>
                            @endif
                            {{--                        @if(@in_array(424, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)--}}
                            {{--                            <li>--}}
                            {{--                                <a href="{{url('optional-subject-setup')}}">@lang('lang.optional') @lang('lang.subject')</a>--}}
                            {{--                            </li>--}}
                            {{--                        @endif--}}


                            @if(@in_array(121, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                {{--    <li> <a href="{{route('base_group')}}">@lang('lang.base_group')</a> </li>--}}
                            @endif
                            @php
                                $config = App\SmGeneralSettings::find(1);
                            @endphp

                            <a href="#building_and_room" data-toggle="collapse" aria-expanded="false" style="color: #000000;font-size: 15px"
                               class="dropdown-toggle">
                                <span class="flaticon-software"></span>
                                <b class="upper_text">@lang('Building and Room')</b>
                            </a>
                            <div style=" height: 1px;background-color: grey !important;"></div>
                            <ul class="collapse list-unstyled" id="building_and_room">
                                @if(@in_array(573, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                    <li>
                                        <a href="{{url('building')}}" style="font-size: 15px">@lang('Building')</a>
                                    </li>
                                @endif
                                @if(@in_array(265, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{route('section')}}" style="font-size: 15px"> @lang('lang.section')</a>
                                    </li>
                                @endif
                                @if(@in_array(269, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{url('class-room')}}" style="font-size: 15px"> @lang('lang.room')</a>
                                    </li>
                                @endif
                                @if(@in_array(261, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{route('class')}}" style="font-size: 15px"> @lang('lang.class')</a>
                                    </li>
                                @endif
                            </ul>

                            @if(@in_array(432, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('academic-year')}}" style="font-size: 15px">@lang('lang.academic_year')</a>
                                </li>
                            @endif
                            @if(@in_array(432, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('semester')}}" style="font-size: 15px">@lang('Semester')</a>
                                </li>
                            @endif
                            @if(@in_array(124, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('session')}}" style="font-size: 15px">@lang('session')</a>
                                </li>
                            @endif

                            @if(@in_array(436, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('custom-result-setting')}}" style="font-size: 15px">@lang('lang.custom_result_setting')</a>
                                </li>
                            @endif

                            @if(@in_array(440, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                <li>
                                    <a href="{{url('holiday')}}" style="font-size: 15px">@lang('lang.holiday')</a>
                                </li>
                            @endif

                            @if(@in_array(562, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                <li>
                                    <a href="{{url('examination-date')}}" style="font-size: 15px">@lang('Examination Date')</a>
                                </li>
                            @endif



                            @if(@in_array(448, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                <li>
                                    <a href="{{url('weekend')}}" style="font-size: 15px">@lang('lang.weekend')</a>
                                </li>
                            @endif


                            @if(@in_array(569, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                <li>
                                    <a href="{{url('degree')}}" style="font-size: 15px">@lang('Degree')</a>
                                </li>
                            @endif







                            {{-- SAAS DISABLE --}}

                            @php
                                $config = App\SmGeneralSettings::find(1);
                            @endphp
                            @if(SmGeneralSettings::isModule('Saas')== FALSE   )

                                @include('backEnd/partials/without_saas_school_admin_menu')

                            @endif



                        </ul>
                    </li>
                @endif

                @if(SmGeneralSettings::isModule('InfixBiometrics')== TRUE )
                    <li>
                        <a href="#BioSettings" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="color: white;font-size: 15px">
                            <span class="flaticon-hotel"></span>
                            <b class="upper_text"> @lang('lang.biometrics') </b>
                        </a>
                        <div style=" height: 1px;background-color: grey !important;"></div>
                        <ul class="collapse list-unstyled" id="BioSettings">

                            <li>
                                <a href="{{url('infixbiometrics/bio-settings')}}" style="font-size: 15px">@lang('lang.biometrics') @lang('lang.settings')</a>
                            </li>

                            <li>
                                <a href="{{url('infixbiometrics/bio-attendance')}}" style="font-size: 15px">@lang('lang.attendance')</a>
                            </li>
                            <li>
                                <a href="{{url('infixbiometrics/bio-attendance-reports')}}" style="font-size: 15px">@lang('lang.staff') @lang('lang.attendance') @lang('lang.reports')</a>
                            </li>
                            <li>
                                <a href="{{url('infixbiometrics/student-bio-attendance-reports')}}" style="font-size: 15px">@lang('lang.student') @lang('lang.attendance') @lang('lang.reports')</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if(App\SmGeneralSettings::isModule('Saas')== FALSE)
                    @if(@in_array(485, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                        <li>
                            <a href="#subMenusystemStyle" data-toggle="collapse" aria-expanded="false" style="color: white;font-size: 15px"
                               class="dropdown-toggle">
                                <span class="flaticon-settings"></span>
                                <b class="upper_text">@lang('lang.style')</b>
                            </a>
                            <div style=" height: 1px;background-color: grey !important;"></div>
                            <ul class="collapse list-unstyled" id="subMenusystemStyle">

                                @if(in_array(486, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                    <li>
                                        <a href="{{url('background-setting')}}" style="font-size: 15px">@lang('lang.background_settings')</a>
                                    </li>
                                @endif
                                @if(in_array(490, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{url('color-style')}}" style="font-size: 15px">@lang('lang.color') @lang('lang.theme')</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif


                {{-- <!-- @if(in_array(20, $main_modules))

                 @if(in_array(18, $modules) || Auth::user()->role_id == 1)
                     <li>
                         <a href="#subMenuApi" data-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle">
                             <span class="flaticon-settings"></span>
                             @lang('lang.api')
                             @lang('lang.permission')
                         </a>
                         <ul class="collapse list-unstyled" id="subMenuApi">
                             @if(in_array(117, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                 <li>
                                     <a href="{{url('api/permission')}}">@lang('lang.api') @lang('lang.permission') </a>
                                 </li>
                             @endif
                         </ul>
                     </li>
                 @endif

                 @endif --> --}}
                @if(App\SmGeneralSettings::isModule('Saas')== FALSE)
                    @if(@in_array(492, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                        <li>
                            <a href="#subMenufrontEndSettings" data-toggle="collapse" aria-expanded="false" style="color: white;font-size: 15px"
                               class="dropdown-toggle">
                                <span class="flaticon-software"></span>
                                <b class="upper_text">@lang('lang.front_settings')</b>
                            </a>
                            <div style=" height: 1px;background-color: grey !important;"></div>
                            <ul class="collapse list-unstyled" id="subMenufrontEndSettings">
                                @if(@in_array(493, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{url('admin-home-page')}}" style="font-size: 15px"> @lang('lang.home_page') </a>
                                    </li>
                                @endif
                                @if(@in_array(495, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{url('news')}}" style="font-size: 15px">@lang('lang.news_list')</a>
                                    </li>
                                @endif

                                @if(@in_array(500, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{url('news-category')}}" style="font-size: 15px">@lang('lang.news') @lang('lang.category')</a>
                                    </li>
                                @endif

                                @if(@in_array(504, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{url('testimonial')}}" style="font-size: 15px">@lang('lang.testimonial')</a>
                                    </li>
                                @endif

                                @if(@in_array(509, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{url('course-list')}}" style="font-size: 15px">@lang('lang.course_list')</a>
                                    </li>
                                @endif

                                @if(@in_array(514, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{url('contact-page')}}" style="font-size: 15px">@lang('lang.contact') @lang('lang.page') </a>
                                    </li>
                                @endif

                                @if(@in_array(517, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{url('contact-message')}}" style="font-size: 15px">@lang('lang.contact') @lang('lang.message')</a>
                                    </li>
                                @endif

                                @if(@in_array(520, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{url('about-page')}}" style="font-size: 15px"> @lang('lang.about_us') </a>
                                    </li>
                                @endif

                                @if(@in_array(523, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{url('news-heading-update')}}" style="font-size: 15px">@lang('lang.news_heading')</a>
                                    </li>
                                @endif

                                @if(@in_array(525, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{url('course-heading-update')}}" style="font-size: 15px">@lang('lang.course_heading')</a>
                                    </li>
                                @endif

                                @if(@in_array(527, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{url('custom-links')}}" style="font-size: 15px"> @lang('lang.custom_links') </a>
                                    </li>
                                @endif

                                @if(@in_array(529, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{url('social-media')}}" style="font-size: 15px"> @lang('lang.social_media') </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif

                @if(SmGeneralSettings::isModule('Saas')== TRUE  && Auth::user()->is_administrator != "yes" )

                    <li>
                        <a href="#Ticket" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="color: white;font-size: 15px">
                            <span class="flaticon-settings"></span>
                            <b class="upper_text"> @lang('lang.ticket_system')</b>
                        </a>
                        <div style=" height: 1px;background-color: grey !important;"></div>
                        <ul class="collapse list-unstyled" id="Ticket">
                            <li><a href="{{ url('school/ticket-view') }}" style="font-size: 15px">@lang('lang.ticket_list')</a>
                            </li>
                        </ul>
                    </li>

            @endif
        @endif

        <!-- Student Panel -->
        @if(Auth::user()->role_id == 2)
            @include('backEnd/partials/student_sidebar')
        @endif
        <!-- End student panel -->

            <!-- Parents Panel Menu -->
        @if(Auth::user()->role_id == 3)
            @include('backEnd/partials/parents_sidebar')
        @endif
        <!-- End Parents Panel Menu -->


        </ul>
    </nav>
@endif
