<!DOCTYPE html>
<html lang="en">
<head>

    <title>Main Page</title>
    @include('Dashboard.css')
    @yield('css')
</head>
<body>
<div class="content pt-0 d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-3 py-lg-8" style="height:82px;" id="kt_subheader">
        <div class="d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->

            <div class="d-flex" style="margin-left:36px;">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h2 class="d-flex align-items-center text-dark font-weight-bold my-1 mr-3"><img
                            src="{{asset('admin/assets/media/logos/logoo.png')}}" class="max-h-70px" alt=""/>
                    </h2>
                </div>
                <!--end::Page Heading-->
            </div>

            <div class="d-flex" style="margin-left: 570px;">

                <a href="{{route('login')}}"
                   class="btn btn-primary btn-fixed-height font-weight-bold px-2 px-lg-5 mr-2">
               <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\legacy\metronic\theme\html\demo1\dist/../src/media/svg/icons\Navigation\Sign-in.svg-->
                   <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                   <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                      <rect x="0" y="0" width="24" height="24"/>
                       <rect fill="#000000" opacity="0.3"
                             transform="translate(9.000000, 12.000000) rotate(-270.000000) translate(-9.000000, -12.000000) "
                             x="8" y="6" width="2" height="12" rx="1"/>
                       <path
                           d="M20,7.00607258 C19.4477153,7.00607258 19,6.55855153 19,6.00650634 C19,5.45446114 19.4477153,5.00694009 20,5.00694009 L21,5.00694009 C23.209139,5.00694009 25,6.7970243 25,9.00520507 L25,15.001735 C25,17.2099158 23.209139,19 21,19 L9,19 C6.790861,19 5,17.2099158 5,15.001735 L5,8.99826498 C5,6.7900842 6.790861,5 9,5 L10.0000048,5 C10.5522896,5 11.0000048,5.44752105 11.0000048,5.99956624 C11.0000048,6.55161144 10.5522896,6.99913249 10.0000048,6.99913249 L9,6.99913249 C7.8954305,6.99913249 7,7.89417459 7,8.99826498 L7,15.001735 C7,16.1058254 7.8954305,17.0008675 9,17.0008675 L21,17.0008675 C22.1045695,17.0008675 23,16.1058254 23,15.001735 L23,9.00520507 C23,7.90111468 22.1045695,7.00607258 21,7.00607258 L20,7.00607258 Z"
                           fill="#000000" fill-rule="nonzero" opacity="0.3"
                           transform="translate(15.000000, 12.000000) rotate(-90.000000) translate(-15.000000, -12.000000) "/>
                       <path
                           d="M16.7928932,9.79289322 C17.1834175,9.40236893 17.8165825,9.40236893 18.2071068,9.79289322 C18.5976311,10.1834175 18.5976311,10.8165825 18.2071068,11.2071068 L15.2071068,14.2071068 C14.8165825,14.5976311 14.1834175,14.5976311 13.7928932,14.2071068 L10.7928932,11.2071068 C10.4023689,10.8165825 10.4023689,10.1834175 10.7928932,9.79289322 C11.1834175,9.40236893 11.8165825,9.40236893 12.2071068,9.79289322 L14.5,12.0857864 L16.7928932,9.79289322 Z"
                           fill="#fff" fill-rule="nonzero"
                           transform="translate(14.500000, 12.000000) rotate(-90.000000) translate(-14.500000, -12.000000) "/>
                   </g>
                  </svg>
               </span>
                    <span class="d-none d-md-inline">  Login</span>
                </a>

                <a href="{{route('trainees.create')}}"
                   class="btn btn-primary btn-fixed-height font-weight-bold px-2 px-lg-5 mr-2">
                  <span class="svg-icon svg-icon-primary svg-icon-2x">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                             height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                  <polygon points="0 0 24 0 24 24 0 24"/>
                                         <path
                                             d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                             fill="#fff" fill-rule="nonzero" opacity="0.3"/>
                                         <path
                                             d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                             fill="#000000" fill-rule="nonzero"/>
                            </g>
                        </svg>
                    </span>
                    <span class="d-none d-md-inline">Trainee Register</span>
                </a>
                <a href="{{route('advisors.create')}}"
                   class="btn btn-primary btn-fixed-height font-weight-bold px-2 px-lg-5 mr-2">
                    <span class="svg-icon svg-icon-primary svg-icon-2x">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                             height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                  <polygon points="0 0 24 0 24 24 0 24"/>
                                         <path
                                             d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                             fill="#fff" fill-rule="nonzero" opacity="0.3"/>
                                         <path
                                             d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                             fill="#000000" fill-rule="nonzero"/>
                            </g>
                        </svg>
                    </span>
                    <span class="d-none d-md-inline">Advisor Register</span>
                </a>
            </div>
        </div>
    </div>
    <!--end::Subheader-->
    <!--begin::Entry-->
    <!--begin::Hero-->
    <div class="d-flex flex-row-fluid bgi-size-cover bgi-position-center"
         style="background-image: url('{{asset('admin/assets/media/bg/bg-12.png')}}')">
        <div class="container">
            <!--begin::Topbar-->

            <!--end::Topbar-->
            <div class="d-flex align-items-stretch text-center flex-column py-40">
                <!--begin::Heading-->
                <!--end::Heading-->
                <!--begin::Form-->
                <!--end::Form-->
            </div>
        </div>
    </div>
    <!--end::Hero-->
    <!--begin::Section-->
    <div class="container py-8">
        <div class="row">
            <div class="col-lg-4">
                <!--begin::Callout-->
                <div class="card card-custom wave wave-animate-slow wave-primary mb-8 mb-lg-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center p-5">
                            <!--begin::Icon-->
                            <div class="mr-6">
												<span class="svg-icon svg-icon-primary svg-icon-4x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\legacy\metronic\theme\html\demo3\dist/../src/media/svg/icons\Communication\Group.svg--><svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"/>
        <path
            d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
            fill="#000000" fill-rule="nonzero" opacity="0.3"/>
        <path
            d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
            fill="#000000" fill-rule="nonzero"/>
    </g>
</svg><!--end::Svg Icon--></span>
                            </div>
                            <!--end::Icon-->
                            <!--begin::Content-->
                            <div class="d-flex flex-column">
                                <span class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">Advisors
                                    Number</span>
                                <div class="text-dark-90"> {{ $advisor_num }} </div>
                            </div>
                            <!--end::Content-->
                        </div>
                    </div>
                </div>
                <!--end::Callout-->
            </div>
            <div class="col-lg-4">
                <!--begin::Callout-->
                <div class="card card-custom wave wave-animate-slow wave-danger mb-8 mb-lg-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center p-5">
                            <!--begin::Icon-->
                            <div class="mr-6">

													<span class="svg-icon svg-icon-primary svg-icon-4x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\legacy\metronic\theme\html\demo3\dist/../src/media/svg/icons\Communication\Group.svg--><svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"/>
        <path
            d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
            fill="#000000" fill-rule="nonzero" opacity="0.3"/>
        <path
            d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
            fill="#000000" fill-rule="nonzero"/>
    </g>
</svg><!--end::Svg Icon--></span>
                            </div>
                            <!--end::Icon-->
                            <!--begin::Content-->
                            <div class="d-flex flex-column">
                                <span class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">Trainees
                                    Number</span>
                                <div class="text-dark-90"> {{ $trainee_num }} </div>
                            </div>
                            <!--end::Content-->
                        </div>
                    </div>
                </div>
                <!--end::Callout-->
            </div>
            <div class="col-lg-4">
                <!--begin::Callout-->
                <div class="card card-custom wave wave-animate-slow wave-success mb-8 mb-lg-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center p-5">
                            <!--begin::Icon-->
                            <div class="mr-6">
                                <span class="svg-icon svg-icon-secondary svg-icon-4x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\legacy\metronic\theme\html\demo3\dist/../src/media/svg/icons\Devices\Display1.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path
            d="M11,20 L11,17 C11,16.4477153 11.4477153,16 12,16 C12.5522847,16 13,16.4477153 13,17 L13,20 L15.5,20 C15.7761424,20 16,20.2238576 16,20.5 C16,20.7761424 15.7761424,21 15.5,21 L8.5,21 C8.22385763,21 8,20.7761424 8,20.5 C8,20.2238576 8.22385763,20 8.5,20 L11,20 Z"
            fill="#000000" opacity="0.3"/>
        <path
            d="M3,5 L21,5 C21.5522847,5 22,5.44771525 22,6 L22,16 C22,16.5522847 21.5522847,17 21,17 L3,17 C2.44771525,17 2,16.5522847 2,16 L2,6 C2,5.44771525 2.44771525,5 3,5 Z M4.5,8 C4.22385763,8 4,8.22385763 4,8.5 C4,8.77614237 4.22385763,9 4.5,9 L13.5,9 C13.7761424,9 14,8.77614237 14,8.5 C14,8.22385763 13.7761424,8 13.5,8 L4.5,8 Z M4.5,10 C4.22385763,10 4,10.2238576 4,10.5 C4,10.7761424 4.22385763,11 4.5,11 L7.5,11 C7.77614237,11 8,10.7761424 8,10.5 C8,10.2238576 7.77614237,10 7.5,10 L4.5,10 Z"
            fill="#000000"/>
    </g>
</svg><!--end::Svg Icon--></span>
                            </div>
                            <!--end::Icon-->
                            <!--begin::Content-->
                            <div class="d-flex flex-column">
                                <span href="#" class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">
                                    Programs Number</span>
                                <div class="text-dark-75">{{$program_num}}</div>
                            </div>
                            <!--end::Content-->
                        </div>
                    </div>
                </div>
                <!--end::Callout-->
            </div>
        </div>
    </div>
</div>
@include('Dashboard.js')
@yield('js')

</body>
<!--end::Body-->
</html>
