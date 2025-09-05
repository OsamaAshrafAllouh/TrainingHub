<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    @include('Dashboard.css')
    <title>Forget Password</title>
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
                <a href="#" class="login-logo text-center pt-lg-25 pb-10" style="margin-top: -160px;">
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
            <!--begin::Wrapper-->
            <div class="d-flex flex-row-fluid flex-center">
                <!--begin::Forgot-->
                <div class="login-form">
                    <!--begin::Form-->
                            <form class="form" id="kt_login_forgot_form"  method="POST" action="{{ route('password.email') }}">
                                @csrf

                        <!--begin::Title-->
                        <div class="pb-5 pb-lg-15">
                            <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Forgotten Password ?</h3>
                            <p class="text-muted font-weight-bold font-size-h4">Enter your email to reset your password</p>
                        </div>
                        <!--end::Title-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            @if (session('status'))
                                <div class="alert alert-success btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <input id="email" type="email" class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6 @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group d-flex flex-wrap">
                            <button type="submit" id="kt_login_forgot_form_submit_button" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">  {{ __('Send Password Reset Link') }}</button>
                            <a href="{{route('login')}}" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">Back</a>

                        </div>
                        <!--end::Form group-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Forgot-->
            </div>            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Login-->
</div>
<!--end::Main-->
@include('Dashboard.js')

<!--end::Page Scripts-->
</body>
<!--end::Body-->
</html>
