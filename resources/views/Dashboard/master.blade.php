<!DOCTYPE html>
<html lang="en">
<head>

    <title>@yield('title')</title>
    @include('Dashboard.css')
    @yield('css')
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body"
      class="header-mobile-fixed subheader-enabled aside-enabled aside-fixed aside-secondary-enabled page-loading">
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">
        <!--begin::Aside-->
        @include('Dashboard.sidebar')

        <!--end::Aside-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

            <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
                <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                    <!--begin::Info-->
                    <div class="d-flex align-items-center mr-1">
                        <!--begin::Page Heading-->
                        <div class="d-flex align-items-baseline flex-wrap mr-5">
                            <!--begin::Page Title-->
                            <h2 class="d-flex align-items-center text-dark font-weight-bold my-1 mr-3">
                                Dashboard</h2>
                            <!--end::Page Title-->
                        </div>
                        <!--end::Page Heading-->
                    </div>

                    @if(Auth()->user()->level == 1)
                    <div class="dropdown">
                        <!--begin::Toggle-->
                        <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" aria-expanded="false">
                            <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 pulse pulse-primary">
											<span class="svg-icon svg-icon-xl svg-icon-primary">
												<!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
												<i class="flaticon-bell text-success icon-lg"></i>
                                            </span>
                                @if(isset($count) && $count > 0)
                                    <span
                                        class="label label-sm label-light-danger label-rounded font-weight-bolder position-absolute top-0 right-0 mt-1 mr-1">{{ $count }}</span>
                                @endif
                                <span class="pulse-ring"></span>
                            </div>
                        </div>
                        <!--end::Toggle-->
                        <!--begin::Dropdown-->
                        <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg"
                             style="">
                            <div class="tab-content">
                                <!--begin::Tabpane-->
                                <div class="tab-pane active show p-8" id="topbar_notifications_notifications"
                                     role="tabpanel">
                                    <!--begin::Scroll-->
                                    <div class="scroll pr-7 mr-n7 ps ps--active-y" data-scroll="true" data-height="300"
                                         data-mobile-height="200" style="height: 300px; overflow: hidden;">
                                        <!--begin::Item-->
                                        <div class=" align-items-center ">
                                            <!--begin::Symbol-->
                                            @if(isset($notifications))
                                                @foreach($notifications as $notification)
                                                    <li>
                                                        <a href="{{ $notification->link }}" class="navi-item">
                                                            <div class="navi-link">
                                                                <div class="navi-text">
                                                                    <div
                                                                        class="font-weight-bold">{{ $notification->message }}</div>
                                                                    <div
                                                                        class="text-muted">{{ $notification->created_at->diffForHumans() }}</div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <hr>
                                                @endforeach
                                            @endif
                                            <!--end::Text-->
                                        </div>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Tabpane-->
                                    <!--begin::Tabpane-->
                                    <!--end::Content-->

                                </div>
                                <!--end::Dropdown-->
                            </div>

                        </div>
                        <!-- Notification dropdown -->
                    </div>
                    @endif<!--end::Toolbar-->
                </div>
            </div>

            <div class="d-flex flex-column-fluid" id="kt_content">
                <div class="container">
                    @yield('content')
                </div>
            </div>

            @include('Dashboard.footer')

        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::Main-->
@include('Dashboard.js')
@yield('js')

<!--end::Page Scripts-->
</body>
<!--end::Body-->
</html>
