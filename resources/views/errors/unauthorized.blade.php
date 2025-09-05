<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->
<head>
    <base href="">
    <meta charset="utf-8"/>
    <title>
      Unauthorized
    </title>
    <meta name="description"
          content="Metronic admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets."/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    @include('Dashboard.css')

</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Error-->
    <div class="d-flex flex-row-fluid flex-column bgi-size-cover bgi-position-center bgi-no-repeat p-10 p-sm-30" style="background-image: url({{asset('admin/assets/media/error/bg1.jpg')}}">
        <!--begin::Content-->
        <h1 class="font-weight-boldest text-dark-75 mt-15" style="font-size: 10rem">403</h1>
        <p class="font-size-h3 text-muted font-weight-normal">OOPS! Not Authorized Action</p>
        <!--end::Content-->
    </div>
    <!--end::Error-->
</div>
@include('Dashboard.js')

</body>
<!--end::Body-->
</html>
