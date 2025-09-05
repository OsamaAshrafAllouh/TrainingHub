<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    @include('Dashboard.css')
    <title>Login</title>

</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body"
      class="header-mobile-fixed subheader-enabled aside-enabled aside-fixed aside-secondary-enabled page-loading">
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-3 wizard d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Aside-->
        <div class="login-aside d-flex flex-column flex-row-auto">
            <!--begin::Aside Top-->
            <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
                <!--begin::Aside header-->
                <a href="{{url('/')}}" class="login-logo text-center pt-lg-25 pb-10" style="margin-top: -160px;">
                    <img src="{{asset('admin/assets/media/logos/logoo.png')}}" class="max-h-70px" alt=""/>
                </a>
                <!--end::Aside header-->
                <!--begin::Aside Title-->
                <h3 class="font-weight-bolder text-center font-size-h4 text-dark-50 line-height-xl">
                    A Platform That Provides All Training Services</h3>
                <!--end::Aside Title-->
            </div>
            <!--end::Aside Top-->
            <!--begin::Aside Bottom-->

            <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-x-center"
                 style="background-position-y: calc(100% + 0.5rem); background-image: url({{asset('admin/assets/media/svg/illustrations/login-visual-5.jpg')}})"></div>

            <!--end::Aside Bottom-->
        </div>
        <!--begin::Aside-->
        <!--begin::Content-->
        <div class="login-content flex-row-fluid d-flex flex-column p-10">
            <!--begin::Top-->

            <!--end::Top-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-row-fluid flex-center">
                <!--begin::Signin-->
                <div class="login-form">
                    <!--begin::Form-->
                    <form class="form fv-plugins-bootstrap fv-plugins-framework" id="kt_login_singin_form" method="POST"
                          action="{{ route('login') }}">
                        @csrf
                        <!--begin::Title-->
                        <div class="pb-5 pb-lg-15">
                            <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg" style="
    margin-top: -200px;
">Sign In</h3>
                            <div class="text-muted font-weight-bold font-size-h4">New Here?
                                <a href="{{route('trainees.create')}}" class="text-primary font-weight-bolder">Create
                                    Account</a>
                            </div>
                        </div>
                        <!--begin::Title-->
                        <div class="form-group fv-plugins-icon-container">
                            <label class="font-size-h6 font-weight-bolder text-dark">Your Email OR ID</label>
                            <input id="email" type="text"
                                   class="form-control font-size-h6 h-auto py-7 px-6 rounded-lg border-0 @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autofocus>
                            <div class="fv-plugins-message-container"></div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group fv-plugins-icon-container">
                            <div class="d-flex justify-content-between mt-n5">
                                <label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>
                                @if (Route::has('password.request'))
                                    <a class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5"
                                       href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif

                            </div>
                            <input id="password" type="password"
                                   class="form-control h-auto py-7 px-6 font-size-h6 rounded-lg border-0 @error('password') is-invalid @enderror"
                                   name="password" required
                                   autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror                                </div>
                        <!--end::Form group-->

                        <div class="pb-lg-0 pb-5">
                            <button type="submit" id="kt_login_singin_form_submit_button"
                                    class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">  {{ __('Login') }}</button>
                            <a type="button" href="{{route('google.login')}}"
                               class="btn btn-light-primary font-weight-bolder px-8 py-4 my-3 font-size-lg">
									<span class="svg-icon svg-icon-md">
										<!--begin::Svg Icon | path:assets/media/svg/social-icons/google.svg-->
										<svg xmlns="http://www.w3.org/2000/svg" width="23" height="20"
                                             viewBox="0 0 20 20" fill="none">
											<path
                                                d="M19.9895 10.1871C19.9895 9.36767 19.9214 8.76973 19.7742 8.14966H10.1992V11.848H15.8195C15.7062 12.7671 15.0943 14.1512 13.7346 15.0813L13.7155 15.2051L16.7429 17.4969L16.9527 17.5174C18.879 15.7789 19.9895 13.221 19.9895 10.1871Z"
                                                fill="#4285F4"/>
											<path
                                                d="M10.1993 19.9313C12.9527 19.9313 15.2643 19.0454 16.9527 17.5174L13.7346 15.0813C12.8734 15.6682 11.7176 16.0779 10.1993 16.0779C7.50243 16.0779 5.21352 14.3395 4.39759 11.9366L4.27799 11.9466L1.13003 14.3273L1.08887 14.4391C2.76588 17.6945 6.21061 19.9313 10.1993 19.9313Z"
                                                fill="#34A853"/>
											<path
                                                d="M4.39748 11.9366C4.18219 11.3166 4.05759 10.6521 4.05759 9.96565C4.05759 9.27909 4.18219 8.61473 4.38615 7.99466L4.38045 7.8626L1.19304 5.44366L1.08875 5.49214C0.397576 6.84305 0.000976562 8.36008 0.000976562 9.96565C0.000976562 11.5712 0.397576 13.0882 1.08875 14.4391L4.39748 11.9366Z"
                                                fill="#FBBC05"/>
											<path
                                                d="M10.1993 3.85336C12.1142 3.85336 13.406 4.66168 14.1425 5.33717L17.0207 2.59107C15.253 0.985496 12.9527 0 10.1993 0C6.2106 0 2.76588 2.23672 1.08887 5.49214L4.38626 7.99466C5.21352 5.59183 7.50242 3.85336 10.1993 3.85336Z"
                                                fill="#EB4335"/>
										</svg>
                                  </span>Sign in with Google

                            </a>


                            <a href="{{url('/')}}"
                               class="btn btn-icon btn-default btn-hover-primary ml-22 h-45px w-45px flex-shrink-0">
							<span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\legacy\metronic\theme\html\demo3\dist/../src/media/svg/icons\Home\Home.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z" fill="#000000"/>
    </g>
</svg><!--end::Svg Icon--></span>
                            </a>


                        </div>
                    </form>
                    <!--end::Form-->
                </div>

                <!--end::Signin-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
    </div>
</div>
<!--end::Main-->
@include('Dashboard.js')

<!--end::Page Scripts-->
</body>
<!--end::Body-->
</html>
