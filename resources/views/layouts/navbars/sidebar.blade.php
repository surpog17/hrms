<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">{{ __('IE') }}</a>
            <a href="#" class="simple-text logo-normal">{{ __('Attendance Payroll') }}</a>
        </div>
        @employ
        @hr
        <ul class="nav">
            <li @if ($pageSlug=='dashboard' ) class="active " @endif>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li>
                <a data-toggle="collapse" href="#employees" aria-expanded="true">
                    <i class="tim-icons icon-image-02"></i>
                    <span class="nav-link-text">{{ __('Employees') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse hide" id="employees">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='profile' ) class="active " @endif>
                            <a href="{{ route('profile.edit')  }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('User Profile') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='users' ) class="active " @endif>
                            <a href="{{ route('employee.index')  }}">
                                <i class="tim-icons icon-notes"></i>
                                <p>{{ __('Employee Management') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='users' ) class="active " @endif>
                            <a href="{{ route('user.index')  }}">
                                <i class="tim-icons icon-notes"></i>
                                <p>{{ __('User Management') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='shift' ) class="active " @endif>
                            <a href="{{route('employee')}}">
                                <i class="tim-icons icon-badge"></i>
                                <p>{{ __('Shift Management') }}</p>
                            </a>
                        </li>
                         <li @if ($pageSlug=='users' ) class="active " @endif>
                            <a href="{{ route('employeexport')  }}">
                               <i class="tim-icons icon-notes"></i>
                                <p>{{ __('Export User data') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#attendance" aria-expanded="true">
                    <i class="tim-icons icon-single-copy-04"></i>
                    <span class="nav-link-text">{{ __('Attendance') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse hide" id="attendance">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='raw' ) class="active " @endif>
                            <a href="{{route('raw.view')}}">
                               <i class="tim-icons icon-notes"></i>
                                <p>{{ __('Raw Data') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='webhr' ) class="active " @endif>
                            <a href="{{route('webhr.index')}}">
                               <i class="tim-icons icon-notes"></i>
                                <p>{{ __('Webhr Data') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='webhr_export' ) class="active " @endif>
                            <a href="{{route('webhr.show')}}">
                                <i class="tim-icons icon-notes"></i>
                                <p>{{ __('Export') }}</p>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#warning" aria-expanded="true">
                    <i class="tim-icons icon-single-copy-04"></i>
                    <span class="nav-link-text">{{ __('Warning') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse hide" id="warning">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='warning' ) class="active " @endif>
                            <a href="{{route('warning.index')}}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Warning Record') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='warning-type' ) class="active " @endif>
                            <a href="{{route('type.index')}}">
                                <i class="tim-icons icon-notes"></i>
                                <p>{{ __('Warning Type') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#deduction" aria-expanded="true">
                    <i class="tim-icons icon-single-copy-04"></i>
                    <span class="nav-link-text">{{ __('Deduction') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse hide" id="deduction">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='deduction-record' ) class="active " @endif>
                            <a href="{{route('loan.index')}}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Deduction Record') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='deduction-type' ) class="active " @endif>
                            <a href="{{route('category.index')}}">
                               <i class="tim-icons icon-notes"></i>
                                <p>{{ __('Deduction Type') }}</p>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#merit" aria-expanded="true">
                    <i class="tim-icons icon-single-copy-04"></i>
                    <span class="nav-link-text">{{ __('Merit') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse hide" id="merit">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='merit-record' ) class="active " @endif>
                            <a href="{{route('merit.index')}}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Merit Record') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='merit-type' ) class="active " @endif>
                            <a href="{{route('merit.type')}}">
                               <i class="tim-icons icon-notes"></i>
                                <p>{{ __('Merit Type') }}</p>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

        </ul>
        @endhr
        @fin
        <ul class="nav">
            <li>
                <a data-toggle="collapse" href="#payroll" aria-expanded="true">
                    <i class="tim-icons icon-single-copy-04"></i>
                    <span class="nav-link-text">{{ __('Payroll') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse hide" id="payroll">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='award' ) class="active " @endif>
                            <a href="{{route('award')}}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Award') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='deduct' ) class="active " @endif>
                            <a href="{{route('deduction')}}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Deduct') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='bank' ) class="active " @endif>
                            <a href="{{route('bank')}}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Bank') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='payroll' ) class="active " @endif>
                            <a href="{{route('payroll')}}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Payroll') }}</p>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

        </ul>
        @endfin
        @else
        <ul class="nav">
            <li @if ($pageSlug=='dashboard' ) class="active " @endif>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li>
                <a data-toggle="collapse" href="#employees" aria-expanded="true">
                    <i class="tim-icons icon-image-02"></i>
                    <span class="nav-link-text">{{ __('Employees') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse hide" id="employees">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='profile' ) class="active " @endif>
                            <a href="{{ route('profile.edit')  }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('User Profile') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='users' ) class="active " @endif>
                            <a href="{{ route('employee.index')  }}">
                                <i class="tim-icons icon-notes"></i>
                                <p>{{ __('Employee Management') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='users' ) class="active " @endif>
                            <a href="{{ route('user.index')  }}">
                                <i class="tim-icons icon-notes"></i>
                                <p>{{ __('User Management') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='shift' ) class="active " @endif>
                            <a href="{{route('employee')}}">
                                <i class="tim-icons icon-badge"></i>
                                <p>{{ __('Shift Management') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#attendance" aria-expanded="true">
                    <i class="fa fa-calculator"></i>
                    <span class="nav-link-text">{{ __('Attendance') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse hide" id="attendance">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='raw' ) class="active " @endif>
                            <a href="{{route('raw.view')}}">
                                <i class="fa fa-database"></i>
                                <p>{{ __('Raw Data') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='webhr' ) class="active " @endif>
                            <a href="{{route('webhr.index')}}">
                                <i class="fa fa-database"></i>
                                <p>{{ __('Webhr Data') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='webhr_export' ) class="active " @endif>
                            <a href="{{route('webhr.show')}}">
                                <i class="fa fa-calculator"></i>
                                <p>{{ __('Export') }}</p>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#warning" aria-expanded="true">
                    <i class="tim-icons icon-single-copy-04"></i>
                    <span class="nav-link-text">{{ __('Warning') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse hide" id="warning">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='warning' ) class="active " @endif>
                            <a href="{{route('warning.index')}}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Warning Record') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='warning-type' ) class="active " @endif>
                            <a href="{{route('type.index')}}">
                                <i class="fa fa-tag"></i>
                                <p>{{ __('Warning Type') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#deduction" aria-expanded="true">
                    <i class="tim-icons icon-single-copy-04"></i>
                    <span class="nav-link-text">{{ __('Deduction') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse hide" id="deduction">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='deduction-record' ) class="active " @endif>
                            <a href="{{route('loan.index')}}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Deduction Record') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='deduction-type' ) class="active " @endif>
                            <a href="{{route('category.index')}}">
                                <i class="fa fa-tag"></i>
                                <p>{{ __('Deduction Type') }}</p>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#merit" aria-expanded="true">
                    <i class="tim-icons icon-single-copy-04"></i>
                    <span class="nav-link-text">{{ __('Merit') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse hide" id="merit">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='merit-record' ) class="active " @endif>
                            <a href="{{route('merit.index')}}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Merit Record') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='merit-type' ) class="active " @endif>
                            <a href="{{route('merit.type')}}">
                                <i class="fa fa-tag"></i>
                                <p>{{ __('Merit Type') }}</p>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#payroll" aria-expanded="true">
                    <i class="tim-icons icon-single-copy-04"></i>
                    <span class="nav-link-text">{{ __('Payroll') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse hide" id="payroll">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='award' ) class="active " @endif>
                            <a href="{{route('award')}}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Award') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='deduct' ) class="active " @endif>
                            <a href="{{route('deduction')}}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Deduct') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='bank' ) class="active " @endif>
                            <a href="{{route('bank')}}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Bank') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='payroll' ) class="active " @endif>
                            <a href="{{route('payroll')}}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Payroll') }}</p>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
        </ul>
        @endemploy
    </div>
</div>
