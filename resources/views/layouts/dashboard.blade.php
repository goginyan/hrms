@php($settings = \App\Models\Setting::find(1))
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $settings->language) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{$settings->company_logo}}" type="image/x-icon">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--    Bootstrap4 and FontAwesome --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    {{--    BS4, popper, jQuery--}}
    <script src="{{mix('js/app.js')}}"></script>
    @auth
        <script>
            window.Laravel.userId = "{{Auth::id()}}"
        </script>
    @endauth
    @stack('style')
</head>
<body id="page-top">
<!-- Page Wrapper -->
<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
            <div class="sidebar-brand-icon">
                <img class="m-0" src="{{$settings->company_logo}}" alt="Logo">
            </div>
            <div class="sidebar-brand-text mx-3">{{$settings->company_name}}</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ (Request::is('dashboard') ? 'active' : '') }}">
            <a class="nav-link" href="{{route('dashboard')}}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>{{__('Dashboard')}}</span>
            </a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
        @can('view departments')
            <li class="nav-item {{ Request::is('departments/*')||Request::is('departments') ? 'active' : '' }}">
                <a class="nav-link " href="{{route('departments.index')}}">
                    <i class="fa fa-building"></i>
                    <span>{{__('Departments')}}</span>
                </a>
            </li>
        @endcan
        @can('view roles')
            <li class="nav-item {{ Request::is('roles/*')||Request::is('roles') ? 'active' : '' }}">
                <a class="nav-link " href="{{route('roles.index')}}">
                    <i class="fas fa-user-lock"></i>
                    <span>Roles</span>
                </a>
            </li>
        @endcan
        @can('view employees')
            <li class="nav-item {{ Request::is('employees*') ? 'active' : '' }}">
                <a class="nav-link {{ Request::is('employees*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse"
                   data-target="#collapseEmployees"
                   aria-expanded="true" aria-controls="collapseEmployees">
                    <i class="fas fa-user-tie"></i>
                    <span>{{__('Employees')}}</span>
                </a>
                <div id="collapseEmployees" class="collapse {{ Request::is('employees*') ? 'show' : '' }}"
                     aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item {{ Request::is('employees*') && !Request::is('employees/details') ? 'active' : '' }}"
                           href="{{route('employees.index')}}">{{__('List')}}</a>
                        <a class="collapse-item {{ Request::is('employees/details') ? 'active' : '' }}"
                           href="{{route('employees.details')}}">{{__('Details')}}</a>
                    </div>
                </div>
            </li>
        @endcan
        @can('view reports')
            <li class="nav-item {{ Request::is('reports/*')||Request::is('reports') ? 'active' : '' }}">
                <a class="nav-link " href="{{route('reports.index')}}">
                    <i class="fas fa-clipboard-check"></i>
                    <span>{{__('Reports')}}</span>
                </a>
            </li>
        @endcan
        @can('manage settings')
            <li class="nav-item {{ Request::is('settings/*')||Request::is('settings') ? 'active' : '' }}">
                <a class="nav-link " href="{{route('settings.edit')}}">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
        @endcan
        @if(Auth::user()->isAdmin())
            <li class="nav-item {{ Request::is('taxes*') ? 'active' : '' }}">
                <a class="nav-link " href="{{route('taxes.index')}}">
                    <i class="fas fa-percent"></i>
                    <span>Taxes</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('bonuses*') ? 'active' : '' }}">
                <a class="nav-link " href="{{route('bonuses.index')}}">
                    <i class="fa fa-gift"></i>
                    <span>Bonuses</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('non_taxable_income*') ? 'active' : '' }}">
                <a class="nav-link " href="{{route('non_taxable_income.index')}}">
                    <i class="fas fa-dollar-sign"></i>
                    <span>Non Taxable Incomes</span>
                </a>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item {{ Request::is('payroll*') ? 'active' : '' }}">
                <a class="nav-link {{ Request::is('payroll*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse"
                   data-target="#collapsePayroll"
                   aria-expanded="true" aria-controls="collapsePayroll">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>Payroll</span>
                </a>
                <div id="collapsePayroll" class="collapse {{ Request::is('payroll*') ? 'show' : '' }}"
                     aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item {{ Request::is('payroll') ? 'active' : '' }}"
                           href="{{route('payroll.index')}}">{{__('History')}}</a>
                        <a class="collapse-item {{ Request::is('payroll/generate') ? 'active' : '' }}"
                           href="{{route('payroll.generate')}}">{{__('Generate Payroll')}}</a>
                    </div>
                </div>
            </li>
        @else
            <li class="nav-item {{ Request::is('calendar*') ? 'active' : '' }}">
                <a class="nav-link " href="{{route('calendar.index')}}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{__('Calendar')}}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('time-trackers*') ? 'active' : '' }}">
                <a class="nav-link " href="{{route('time-trackers.index')}}">
                    <i class="fas fa-hourglass-half"></i>
                    <span>{{__('Time Trackers')}}</span>
                </a>
            </li>
        @endif
        @can('view doc-types')
            <li class="nav-item {{ Request::is('doc-types/*')||Request::is('doc-types') ? 'active' : '' }}">
                <a class="nav-link " href="{{route('doc-types.index')}}">
                    <i class="fas fa-file-invoice"></i>
                    <span>{{__('Doc.Types')}}</span>
                </a>
            </li>
        @endcan
        @can('manage profile-form')
            <li class="nav-item {{ Request::is('profile-form/*')||Request::is('profile-form') ? 'active' : '' }}">
                <a class="nav-link " href="{{route('profile.form.index')}}">
                    <i class="fas fa-address-card"></i>
                    <span>{{__('Profile Form')}}</span>
                </a>
            </li>
        @endcan
        @can('viewAny','App\Models\Document')
            <li class="nav-item {{ Request::is('documents/*')||Request::is('documents') ? 'active' : '' }}">
                <a class="nav-link " href="{{route('documents.index')}}">
                    <i class="fas fa-file-alt"></i>
                    <span class="d-inline-flex align-items-center">
                        {{__('Documents')}}
                    </span>
                </a>
            </li>
        @endcan
        <li class="nav-item {{ Request::is('tasks/*')||Request::is('tasks') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('tasks/*')||Request::is('tasks') ? '' : 'collapsed' }}" href="#"
               data-toggle="collapse"
               data-target="#collapseTasks"
               aria-expanded="true" aria-controls="collapseTasks">
                <i class="fas fa-tasks"></i>
                <span>{{__('Tasks')}}</span>
            </a>
            <div id="collapseTasks" class="collapse {{ Request::is('tasks/*')||Request::is('tasks') ? 'show' : '' }}"
                 aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @can('viewAny', 'App\Models\Task')
                        <a class="collapse-item {{ Request::is('tasks') ? 'active' : '' }}"
                           href="{{route('tasks.index')}}">{{__('My Tasks')}}
                        </a>
                    @endcan
                    @can('indexAll', 'App\Models\Task')
                        <a class="collapse-item {{ Request::is('tasks/all') ? 'active' : '' }}"
                           href="{{route('tasks.all')}}">{{__('All Tasks')}}
                        </a>
                    @endcan
                </div>
            </div>
        </li>
        <li class="nav-item {{ Request::is(['rewards*','redeemables*','manage-rewards*','redeem']) ? 'active' : '' }}">
            <a class="nav-link {{ Request::is(['rewards*','redeemables*','manage-rewards*','redeem']) ? '' : 'collapsed' }}"
               href="#"
               data-toggle="collapse"
               data-target="#collapseRewards"
               aria-expanded="true" aria-controls="collapseRewards">
                <i class="fas fa-medal"></i>
                <span>{{__('Rewards')}}</span>
            </a>
            <div id="collapseRewards"
                 class="collapse {{ Request::is(['rewards*','redeemables*','redeemed','redeem']) ? 'show' : '' }}"
                 aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ Request::is('rewards*') ? 'active' : '' }}"
                       href="{{route('rewards.index')}}">{{__('Feed')}}
                    </a>
                    <a class="collapse-item {{ Request::is('redeem') ? 'active' : '' }}"
                       href="{{route('redeemables.index.user')}}">{{__('Redeem')}}
                    </a>
                    @can('manage rewards')
                        <hr class="m-0 mx-3">
                        <a class="collapse-item {{ Request::is('redeemables*') ? 'active' : '' }}"
                           href="{{route('redeemables.index')}}">{{__('Redeemables')}}
                        </a>
                        <a class="collapse-item {{ Request::is('redeemed') ? 'active' : '' }}"
                           href="{{route('redeemables.manage')}}">{{__('Manage')}}
                        </a>
                    @endcan
                </div>
            </div>
        </li>
        <li class="nav-item {{ Request::is(['quizzes*','quiz-questions*','user-quizzes*']) ? 'active' : '' }}">
            <a class="nav-link {{ Request::is(['quizzes*','quiz-questions*','user-quizzes*']) ? '' : 'collapsed' }}"
               href="#"
               data-toggle="collapse"
               data-target="#collapseQuizzes"
               aria-expanded="true" aria-controls="collapseQuizzes">
                <i class="fas fa-cube"></i>
                <span>{{__('Quizzes')}}</span>
            </a>
            <div id="collapseQuizzes"
                 class="collapse {{ Request::is(['quizzes*','user-quizzes*','quiz-questions*','quiz-reports*']) ? 'show' : '' }}"
                 aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ Request::is('user-quizzes*') && !Request::hasAny(['active','passed']) ? 'active' : '' }}"
                       href="{{route('quizzes.index.user')}}">{{__('All')}}
                    </a>
                    <a class="collapse-item {{ Request::is('user-quizzes') && Request::has('active') ? 'active' : '' }}"
                       href="{{route('quizzes.index.user',['active'=>true])}}">{{__('Active')}}
                    </a>
                    <a class="collapse-item {{ Request::is('user-quizzes') && Request::has('passed') ? 'active' : '' }}"
                       href="{{route('quizzes.index.user',['passed'=>true])}}">{{__('Passed')}}
                    </a>
                    @can('manage quizzes')
                        <hr class="m-0 mx-3">
                        <a class="collapse-item {{ Request::is('quizzes*') ? 'active' : '' }}"
                           href="{{route('quizzes.index')}}">{{__('Quizzes')}}
                        </a>
                        <a class="collapse-item {{ Request::is('quiz-questions*') ? 'active' : '' }}"
                           href="{{route('quiz.questions.index')}}">{{__('Questions')}}
                        </a>
                        <a class="collapse-item {{ Request::is('quiz-reports*') ? 'active' : '' }}"
                           href="{{route('quizzes.reports.index')}}">{{__('Reports')}}
                        </a>
                    @endcan
                </div>
            </div>
        </li>
        <li class="nav-item {{ Request::is(['surveys*','user-surveys*']) ? 'active' : '' }}">
            <a class="nav-link {{ Request::is(['surveys*','user-surveys*']) ? '' : 'collapsed' }}" href="#"
               data-toggle="collapse"
               data-target="#collapseSurveys"
               aria-expanded="true" aria-controls="collapseSurveys">
                <i class="fas fa-question"></i>
                <span>{{__('Surveys')}}</span>
            </a>
            <div id="collapseSurveys"
                 class="collapse {{ Request::is('surveys*')||Request::is('user-surveys*') ? 'show' : '' }}"
                 aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ Request::is('user-surveys*') && !Request::hasAny(['active','passed']) ? 'active' : '' }}"
                       href="{{route('surveys.index.user')}}">{{__('All')}}
                    </a>
                    <a class="collapse-item {{ Request::is('user-surveys') && Request::has('active') ? 'active' : '' }}"
                       href="{{route('surveys.index.user',['active'=>true])}}">{{__('Active')}}
                    </a>
                    <a class="collapse-item {{ Request::is('user-surveys') && Request::has('passed') ? 'active' : '' }}"
                       href="{{route('surveys.index.user',['passed'=>true])}}">{{__('Passed')}}
                    </a>
                    @can('create surveys')
                        <hr class="m-0 mx-3">
                        <a class="collapse-item {{ Request::is('surveys*') ? 'active' : '' }}"
                           href="{{route('surveys.index')}}">{{__('Manage')}}
                        </a>
                    @endcan
                </div>
            </div>
        </li>
        @can('viewAny','App\Models\Team')
            <li class="nav-item {{ Request::is('teams/*')||Request::is('teams') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('teams.index')}}">
                    <i class="fas fa-users"></i>
                    <span>{{__('Teams')}}</span>
                </a>
            </li>
        @endcan
        @can('viewAny','App\Models\TimeOff')
            <li class="nav-item {{ Request::is('time-offs*') ? 'active' : '' }}">
                <a class="nav-link {{ Request::is('time-offs*') ? '' : 'collapsed' }}"
                   href="#" data-toggle="collapse" data-target="#collapseTimeOffs"
                   aria-expanded="true" aria-controls="collapseTimeOffs">
                    <i class="fas fa-clock"></i>
                    <span>{{__('Time Offs')}}</span>
                </a>
                <div id="collapseTimeOffs" class="collapse {{ Request::is('time-offs*') ? 'show' : '' }}"
                     aria-labelledby="headingTwo"
                     data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item {{ Request::is('time-offs*') && !Request::is('time-offs/manage') ? 'active' : '' }}"
                           href="{{route('time-offs.index')}}">{{__('Time Offs')}}</a>
                        @can('approve time-offs')
                            <hr class="m-0 mx-3">
                            <a class="collapse-item {{ Request::is('time-offs/manage') ? 'active' : '' }}"
                               href="{{route('time-offs.manage')}}">{{__('Manage')}}</a>
                        @endcan
                    </div>
                </div>
            </li>
        @endcan
        @can('viewAny','App\Models\Event')
            <li class="nav-item {{ Request::is('events*') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('events.index')}}">
                    <i class="fas fa-calendar-plus"></i>
                    <span>{{__('Events')}}</span>
                </a>
            </li>
        @endcan
        @can('manage blog')
            <li class="nav-item {{ Request::is('blog-posts/*')||Request::is('blog-posts') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('blog-posts.index')}}">
                    <i class="fas fa-blog"></i>
                    <span>{{__('Blog Posts')}}</span>
                </a>
            </li>
        @endcan
        @can('view vacancies')
            <li class="nav-item {{ Request::is(['vacancies*','interviews*','applicants*']) ? 'active' : '' }}">
                <a class="nav-link {{ Request::is(['vacancies*','interviews*','applicants*']) ? '' : 'collapsed' }}"
                   href="#" data-toggle="collapse" data-target="#collapseCareers"
                   aria-expanded="true" aria-controls="collapseCareers">
                    <i class="fas fa-briefcase"></i>
                    <span>{{__('Careers')}}</span>
                </a>
                <div id="collapseCareers"
                     class="collapse {{ Request::is(['vacancies*','interviews*','applicants*']) ? 'show' : '' }}"
                     aria-labelledby="headingTwo"
                     data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item {{ Request::is('vacancies*') ? 'active' : '' }}"
                           href="{{route('vacancies.index')}}">{{__('Vacancies')}}</a>
                        @can('manage interviews')
                            <hr class="m-0 mx-3">
                            <a class="collapse-item {{ Request::is('applicants*') ? 'active' : '' }}"
                               href="{{route('applicants.index')}}">{{__('Applicants')}}</a>
                            <a class="collapse-item {{ Request::is('interviews*') ? 'active' : '' }}"
                               href="{{route('interviews.index')}}">{{__('Interviews')}}</a>
                        @endcan
                    </div>
                </div>
            </li>
        @endcan
        <li class="nav-item {{ Request::is('structure') ? 'active' : '' }}">
            <a class="nav-link " href="{{route('structure')}}">
                <i class="fas fa-sitemap"></i>
                <span>{{__('Organization')}}</span>
            </a>
        </li>
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-3 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-primary btn-circle d-md-none mr-3">
                    <i class="fa fa-bars"></i>
                </button>
                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="btn btn-primary btn-circle" id="sidebarToggle"><i class="fa fa-bars"></i></button>
                </div>
                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">
                    @unlessrole('root')
                    <!-- Nav Item - Alerts -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0);" id="alertsDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw"></i>
                            <!-- Counter - Alerts -->
                            <span style="display: none;" class="badge badge-danger badge-counter">
                                {{Auth::user()->unreadNotifications()->where('data->type','!=','message')->count()}}
                            </span>
                        </a>
                        <!-- Dropdown - Alerts -->
                        <div id="notificationsBlock"
                             class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header d-flex justify-content-between align-items-center">
                                {{__('Notifications Center')}}
                                <small><a href="{{route('notifications.readAll')}}" class="btn-link text-light"
                                          id="markAllAsRead">{{__('Mark all as read')}}</a></small>
                            </h6>
                            @forelse(Auth::user()->notifications()->where('data->type','!=','message')->limit(5)->get() as $notification)
                                <div class="dropdown-item d-flex align-items-center notification"
                                     data-id="{{$notification->id}}">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-{{$notification->data['color']}}">
                                            <i class="{{$notification->data['icon']}} text-white"></i>
                                        </div>
                                    </div>
                                    <a href="{{$notification->data['url']}}">
                                        <div class="small text-gray-500">
                                            {{$notification->data['title']}}
                                            · {{$notification->created_at->diffForHumans()}}
                                        </div>
                                        <span class="{{$notification->read_at?:"font-weight-bold"}}">
                                            {{$notification->data['text']}}
                                        </span>
                                    </a>
                                    <span
                                        class="ml-3 badge mark-as-read badge-{{$notification->read_at ? "light" : "primary"}}"></span>
                                </div>
                            @empty
                                <a id="noNotifications"
                                   class="dropdown-item d-flex align-items-center justify-content-center" href="#">
                                    <span class="font-weight-bold">{{__('You have no new notifications')}}!</span>
                                </a>
                            @endforelse
                            <a id="allNotificationsLink" class="dropdown-item text-center small text-gray-500"
                               href="{{route('notifications.index')}}">{{__('Show All Notifications')}}</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link" href="javascript:void(0);" id="messagesDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-envelope fa-fw"></i>
                            <!-- Counter - Messages -->
                            <span style="display: none;" class="badge badge-danger badge-counter">
                                {{Auth::user()->unreadNotifications()->where('data->type','message')->count()}}
                            </span>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div id="messagesBlock"
                             class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="messagesDropdown">
                            <h6 class="dropdown-header">
                                {{__('Messages Center')}}
                            </h6>
                            @php($threads = [])
                            @forelse(Auth::user()->notifications()->where('data->type','message')->get() as $notification)
                                @continue(in_array($notification->data['thread_id'], $threads))
                                @php($threads[]=$notification->data['thread_id'])
                                <div class="dropdown-item d-flex align-items-center notification"
                                     data-thread="{{$notification->data['thread_id']}}"
                                     data-id="{{$notification->id}}">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle"
                                             src="{{\App\Models\Employee::find($notification->data['sender']['id'])->avatar ?? asset('images/no_avatar.jpg')}}"
                                             alt="">
                                    </div>
                                    <a href="{{$notification->data['url']}}"
                                       class="{{$notification->read_at?:"font-weight-bold"}}">
                                        <div class="text-truncate">
                                            {{$notification->data['text']}}
                                        </div>
                                        <div
                                            class="small text-gray-500">{{$notification->data['sender']['name']}}
                                            · {{$notification->created_at->diffForHumans()}}</div>
                                    </a>
                                    <span
                                        class="ml-3 badge mark-as-read badge-{{$notification->read_at ? "light" : "primary"}}"></span>
                                </div>
                            @empty
                                <a id="noMessages"
                                   class="dropdown-item d-flex justify-content-center align-items-center" href="#">
                                    <span class="font-weight-bold">{{__('You have no new messages')}}!</span>
                                </a>
                            @endforelse
                            <a class="dropdown-item text-center small text-gray-500" id="allMessagesLink"
                               href="{{route('threads.index')}}">{{__('Show All Threads')}}</a>
                        </div>
                    </li>
                    @endunlessrole
                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span
                                class="flex-column justify-content-center align-items-end mr-2 d-none d-lg-inline-flex text-gray-600 small">
                                <span>{{Auth::user()->employee->fullName}}</span>
                                <span>({{Auth::user()->email}})</span>
                            </span>
                            <img class="img-profile rounded-circle" alt="avatar"
                                 src="{{Auth::user()->employee->avatar??asset('images/no_avatar.jpg')}}">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown" id="userDropdown">
                            @unlessrole('root')
                            <a class="dropdown-item" href="{{route('profile.show')}}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{__('Profile')}}
                            </a>
                            <a class="dropdown-item" href="{{route('blog.index')}}">
                                <i class="fas fa-blog fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{__('Blog')}}
                            </a>
                            <a class="dropdown-item" href="{{route('time-sheet')}}">
                                <i class="fas fa-clipboard-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{__('Timesheet')}}
                            </a>
                            <div class="dropdown-divider"></div>
                            @endunlessrole
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <h4 class="mb-3">@yield('title')</h4>
                @yield('content')
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
        <div class="notifications-area d-none flex-column justify-content-end align-content-end"></div>
        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; HRMS 2019</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- ./wrapper -->
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
{{--Application script--}}
<script src="{{asset('js/script.js')}}"></script>
{{-- Dashboard js--}}
<script src="{{ asset('js/dashboard.js') }}"></script>
{{--Notifications js--}}
<script src="{{ asset('js/notifications.js') }}"></script>
@stack('script')
</body>
</html>
