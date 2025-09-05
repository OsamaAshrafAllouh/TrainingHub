@extends('Dashboard.master')

@section('title')
    Advisors
@endsection

@section('css')

@endsection

@section('content')
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="card card-custom">
                <div class="card-body p-0">
                    <!--begin::Invoice-->
                    <div class="row justify-content-center pt-8 px-8 pt-md-27 px-md-0">
                        <div class="col-md-9">
                            <div class="rounded-xl overflow-hidden w-100 max-h-md-250px mb-30">
                                <img src="{{asset('admin/assets/media/bg/pg-invoices-6.png')}}" class="w-100" alt="">
                            </div>
                            <!--end: Invoice header-->
                            <!--begin: Invoice body-->
                            <div class="row border-bottom pb-10">
                                <div class="col-md-7 py-md-10 pr-md-20">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th class="pt-1 pb-9 pl-0 font-weight-bolder text-muted font-size-lg text-uppercase">
                                                    Personal Information
                                                </th>
                                                <th class="pt-1 pb-9 text-left font-weight-bolder text-muted font-size-lg text-uppercase">
                                                    #
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="font-weight-bolder font-size-lg">
                                                <td class="border-top-0 pl-0 pt-7 d-flex align-items-center">
                                            <span class="navi-icon mr-2">
                                                <i class="fa fa-genderless text-danger font-size-h2"></i>
                                            </span>Name
                                                </td>
                                                <td class="text-left pt-7">{{$trainee->first_name}} {{$trainee->last_name}}</td>
                                            </tr>
                                            <tr class="font-weight-bolder border-bottom-0 font-size-lg">
                                                <td class="border-top-0 pl-0 py-4 d-flex align-items-center">
                                            <span class="navi-icon mr-2">
                                                <i class="fa fa-genderless text-success font-size-h2"></i>
                                            </span>Education
                                                </td>
                                                <td class="border-top-0 text-left py-4">{{$trainee->education}}</td>
                                            </tr>
                                            <tr class="font-weight-bolder border-bottom-0 font-size-lg">
                                                <td class="border-top-0 pl-0 py-4 d-flex align-items-center">
                                            <span class="navi-icon mr-2">
                                                <i class="fa fa-genderless text-primary font-size-h2"></i>
                                            </span>Address
                                                </td>
                                                <td class="border-top-0 text-left py-4">{{$trainee->address}}</td>
                                            </tr>
                                            <tr class="font-weight-bolder border-bottom-0 font-size-lg">
                                                <td class="border-top-0 pl-0 py-4 d-flex align-items-center">
                                            <span class="navi-icon mr-2">
                                                <i class="fa fa-genderless text-secondary font-size-h2"></i>
                                            </span>City
                                                </td>
                                                <td class="border-top-0 text-left py-4">{{$trainee->city}}</td>
                                            </tr>
                                            <tr class="font-weight-bolder border-bottom-0 font-size-lg">
                                                <td class="border-top-0 pl-0 py-4 d-flex align-items-center">
                                            <span class="navi-icon mr-2">
                                                <i class="fa fa-genderless text-danger font-size-h2"></i>
                                            </span>language
                                                </td>
                                                <td class="border-top-0 text-left py-4">{{$trainee->language}}</td>
                                            </tr>
                                            <tr class="font-weight-bolder border-bottom-0 font-size-lg">
                                                <td class="border-top-0 pl-0 py-4 d-flex align-items-center">
                                            <span class="navi-icon mr-2">
                                                <i class="fa fa-genderless text-success font-size-h2"></i>
                                            </span>Program
                                                </td>
                                                <td class="border-top-0 text-left py-4">{{$trainee->education}}</td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-5 border-left-md pl-md-10 py-md-10 text-left">
                                    <!--begin::Total Amount-->
                                    <div
                                        class="pt-1 pb-9 pl-0 font-weight-bolder text-muted font-size-lg text-uppercase">
                                        Contact Information
                                    </div>
                                    <div class="font-size-h6 font-weight-bold"><i class="fa fa-phone-alt"></i>
                                        : {{$trainee->phone}}</div>
                                    <div class="font-size-h6 font-weight-bold mb-16"><i class="fa fa-mail-bulk"></i> :
                                        <a href="mailto:{{$trainee->email}}">{{$trainee->email}}</a>
                                    </div>
                                    <!--end::Total Amount-->
                                    <div class="border-bottom w-100 mb-16"></div>
                                    <!--begin::Invoice To-->
                                    <div
                                        class="pt-1 pb-9 pl-0 font-weight-bolder text-muted font-size-lg text-uppercase">
                                        Documents & Files
                                    </div>
                                    <!--begin::Invoice No-->


                                    <div class="text-dark-50 font-size-lg font-weight-bold mb-3"> @if($trainee->cv)
                                            <a href="{{ $trainee->cv}}" class="btn btn-primary" target="_blank"
                                               rel="noopener noreferrer">Download CV</a>
                                        @endif</div>
                                    <!--end::Invoice No-->
                                    <!--begin::Invoice Date-->
                                    <div class="text-dark-50 font-size-lg font-weight-bold mb-3">
                                        @if($trainee->certification)
                                            <a href="{{ $trainee->certification }}" class="btn btn-primary"
                                               target="_blank"
                                               rel="noopener noreferrer">Download Certification</a>
                                        @endif
                                    </div>

                                    <div class="text-dark-50 font-size-lg font-weight-bold mb-3">
                                        @if(count($trainee->otherFile ?? []) > 0)
                                            @foreach($trainee->otherFile as $otherFileUrl)
                                                <a href="{{ $otherFileUrl }}" class="btn btn-primary" target="_blank"
                                                   rel="noopener noreferrer">Related File</a>
                                            @endforeach
                                        @endif
                                    </div>
                                    <!--end::Invoice Date-->
                                </div>
                            </div>
                            <!--end: Invoice body-->
                        </div>
                    </div>
                    <!-- begin: Invoice action-->
                    <div class="row justify-content-center py-8 px-8 py-md-28 px-md-0">
                        <div class="col-md-9">
                            <div class="d-flex font-size-sm flex-wrap">
                                <button type="button" class="btn btn-primary font-weight-bolder py-4 mr-3 mr-sm-14 my-1"
                                        onclick="window.print();">Print Adviser Information
                                </button>
                                <a class="btn btn-dark font-weight-bolder ml-sm-auto my-1"
                                   href="{{ route('trainees_to_advisor') }}">Back</a>

                            </div>
                        </div>
                    </div>
                    <!-- end: Invoice action-->
                    <!--end::Invoice-->
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
@endsection


@section('js')
    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/html.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script>
        // Event listener for checkbox change
        $(document).on('change', 'input[name="select"]', function () {
            var advisorId = $(this).data('id');
            var isChecked = $(this).prop('checked');

            // AJAX call to update advisor approval status
            $.ajax({
                url: '/sendmail/' + advisorId,
                type: 'GET',
                success: function (response) {
                    // Handle success response
                    if (isChecked) {
                        toastr.success('Advisor is now approved.');
                    } else {
                        toastr.warning('Advisor is now not approved.');
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    toastr.error('Error occurred. Please try again.');
                }
            });
        });
    </script>

@endsection
