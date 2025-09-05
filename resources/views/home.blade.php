@extends('Dashboard.master')

@section('title')
    {{__('dashboard')}}
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#kt_quick_panel_toggle').click(function () {
                $('#notificationDropdown').toggleClass('show');
            });
        });
    </script>

@endsection


@section('content')
    <!--Begin::Row-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="card card-custom">
                <div class="card-body p-0">
                    <div class="row justify-content-center pt-8 px-8 pt-md-50 px-md-0">
                        <div class="col-md-9">
                            <div class="rounded-xl overflow-hidden w-300 max-h-md-450px mb-30">
                                @if(\Illuminate\Support\Facades\Auth::user()->level == 1)
                                    <img src="{{asset('admin/assets/media/bg/welcome.png')}}" class="w-100" alt="">
                                @elseif(\Illuminate\Support\Facades\Auth::user()->level == 2)
                                    <img src="{{asset('admin/assets/media/bg/welcome2.png')}}" class="w-100" alt="">
                                @elseif(\Illuminate\Support\Facades\Auth::user()->level == 3)
                                    <img src="{{asset('admin/assets/media/bg/welcome3.png')}}" class="w-100" alt="">

                                @endif
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
@endsection


