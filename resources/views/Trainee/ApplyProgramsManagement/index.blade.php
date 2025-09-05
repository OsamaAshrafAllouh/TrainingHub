@extends('Dashboard.master')

@section('title')
    Join Program Request
@endsection

@section('js')
    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/html.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('.pay-now-btn').click(function() {
                var price = $(this).data('price');
                var programId = $(this).data('program-id');

                $('#price').val(price);
                $('#program_ids').val(programId);
                $('#course-price').text(price);
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#field_id').on('change', function () {
                var fieldId = $(this).val();

                // Clear the options in the "Available Program" select dropdown
                $('#program_id').html('<option value="">Select Option</option>');

                // Send an AJAX request to fetch the available programs based on the selected field
                $.ajax({
                    url: '/get-available-programs/' + fieldId,
                    type: 'GET',
                    success: function (response) {
                        console.log(response)
                        // Add the fetched programs to the "Available Program" select dropdown
                        response.forEach(function (program) {
                            $('#program_id').append('<option value="' + program.id + '">' + program.name + '</option>');
                        });
                    },
                    error: function (xhr, status, error) {
                        // Handle the error if necessary
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#program_id').change(function () {
                var programId = $(this).val();
                if (programId) {
                    $.ajax({
                        url: '/getAdvisor',
                        type: 'GET',
                        data: {program_id: programId},
                        success: function (response) {
                            $('#advisor_name').val(response);
                        },
                        error: function (xhr) {
                            // Handle error if any
                            console.log(xhr.responseText);
                        }
                    });
                } else {
                    $('#advisor_name').val('');
                }
            });
        });
    </script>

@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
				<span class="card-icon">
                    <i class="flaticon2-favourite text-primary"></i>
				</span>
                <h3 class="card-label">Join Program Request </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{route('trainees-programs.create')}}" class="btn btn-sm btn-light-primary er fs-6 px-8 py-4"
                   data-bs-toggle="modal"
                   data-bs-target="#kt_modal_new_target" data-toggle="modal"
                   data-target="#exampleModal">
                    <i class="la la-plus"></i> apply for training program
                </a>
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                   style="margin-top: 13px !important">
                <thead>
                <tr>

                    <th>#</th>
                    <th>Program</th>
                    <th>Advisor</th>
                    <th>Payment Status</th>
                    <th>status for Request</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($programs as $program)
                    <tr data-entry-id="{{ $program->id }}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$program->program_name}}</td>
                        <td>{{$program->advisor}}</td>
                        <td>
                            @if ($program->program_type == 'paid')
                                @if ($program->payment_status == 'paid')
                                    <span
                                        class="label font-weight-bold label-lg label-light-primary label-inline">Paid</span>
                                @else
                                    <span class="label font-weight-bold label-lg label-light-danger label-inline">Not Paid</span>
                                @endif
                            @else
                                <span
                                    class="label font-weight-bold label-lg label-light-info label-inline"> Free Course</span>

                            @endif
                        </td>
                        <td>
                            @if ($program->status == 'rejected')
                                <span
                                    class="label font-weight-bold label-lg label-light-danger label-inline">Reject</span>
                            @elseif ($program->status == 'pending')
                                <span
                                    class="label font-weight-bold label-lg label-light-warning label-inline">Pending</span>
                            @else
                                <span
                                    class="label font-weight-bold label-lg label-light-success label-inline">Accept</span>
                            @endif
                        </td>
                        <td>
                            @if ($program->program_type == 'paid')

                                @if ($paymentInformation && !$program->payment_status)
                                    <a class="btn btn-sm btn-light-primary er fs-6 px-8 py-4 pay-now-btn"
                                       data-bs-toggle="modal"
                                       data-bs-target="#kt_modal_new_target" data-toggle="modal"
                                       data-target="#exampleModal2"
                                       data-price="{{$program->price}}" data-program-id="{{$program->id}}">
                                        Pay Now
                                    </a>
                                @elseif(!$program->payment_status)
                                    <a class="btn btn-sm btn-light-primary er fs-6 px-8 py-4" data-bs-toggle="modal"
                                       data-bs-target="#kt_modal_new_target" data-toggle="modal"
                                       data-target="#exampleModal1">
                                        Add Payment Information
                                    </a>

                                @else
                                    -
                                @endif
                            @else
                                -
                            @endif
                        </td>
                    </tr>

                @endforeach

                </tbody>

            </table>
            <!--end: Datatable-->
        </div>
    </div>
    <form method="POST" action="{{ route("payment-information.pay") }}" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">Payment for program</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row pt-4">
                            <div class="col-lg-12">
                                <label>Card Number<span class="text-danger">*</span></label>
                                <input type="hidden">
                                <input type="text"
                                       class="form-control{{ $errors->has('card_num') ? 'is-invalid' : '' }}"
                                       name="card_number" id="" value="{{ old('card_number','') }}"
                                       placeholder="Enter Card Name" required/>
                                @if($errors->has('card_number'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('card_number') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row pt-4">

                            <div class="col-lg-12">
                                <label>Amount <small style="color: red;">Course fees <span id="course-price"></span></small> <span
                                        class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}"
                                       name="amount" id="" value="{{ old('amount','') }}"
                                       placeholder="amount" required/>
                                <input type="hidden" name="price" id="price" value="">
                                <input type="hidden" name="program_ids" id="program_ids" value="">

                            @if($errors->has('amount'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('amount') }}
                                    </div>
                                @endif
                            </div>


                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">
                                Close
                            </button>
                            <button class='btn btn-primary font-weight-bold' type='submit'>
                                <span class="indicator-label">pay</span>

                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form method="POST" action="{{ route("payment-information.store") }}" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">Payment Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row pt-4">
                            <div class="col-lg-12">
                                <label>Card Number<span class="text-danger">*</span></label>
                                <input type="hidden">
                                <input type="text"
                                       class="form-control{{ $errors->has('card_num') ? 'is-invalid' : '' }}"
                                       name="card_number" id="" value="{{ old('card_number','') }}"
                                       placeholder="Enter Card Name" required/>
                                @if($errors->has('card_number'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('card_number') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row pt-4">

                            <div class="col-lg-4">
                                <label>CVV<span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control {{ $errors->has('cvv') ? 'is-invalid' : '' }}"
                                       name="cvv" id="" value="{{ old('cvv','') }}"
                                       placeholder="CVV" required/>
                                <input type="hidden">

                                @if($errors->has('cvv'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('cvv') }}
                                    </div>
                                @endif
                            </div>


                            <div class="col-lg-4">
                                <label>Expiration Month<span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control {{ $errors->has('ex_month') ? 'is-invalid' : '' }}"
                                       name="ex_month" id="" value="{{ old('ex_month','') }}"
                                       placeholder="MM" required/>
                                <input type="hidden">

                                @if($errors->has('ex_month'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('ex_month') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                <label> Expiration Year<span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control {{ $errors->has('ex_year') ? 'is-invalid' : '' }}"
                                       name="ex_year" id="" value="{{ old('ex_year','') }}"
                                       placeholder="YYYY" required/>
                                <input type="hidden">

                                @if($errors->has('ex_year'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('ex_year') }}
                                    </div>
                                @endif
                            </div>


                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">
                                Close
                            </button>
                            <button class='btn btn-primary font-weight-bold' type='submit'>
                                <span class="indicator-label">save</span>

                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form method="POST" action="{{ route("trainees-programs.store") }}" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Apply to new Program</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row pt-4">

                            <div class="col-lg-12">
                                <label>Program Field<span class="text-danger">*</span></label>
                                <select required name="" id="field_id" class="form-control">
                                    <option value="">Select Option</option>
                                    @foreach($fields as $field)
                                        <option value="{{ $field->id }}">{{ $field->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="form-group row pt-4">
                            <div class="col-lg-12">
                                <label>Available Program<span class="text-danger">*</span></label>
                                <select required name="program_id" id="program_id" class="form-control">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row pt-4">
                            <div class="col-lg-12">
                                <label>Advisor of Program<span class="text-danger">*</span></label>
                                <input type="text" name="advisor_name" id="advisor_name" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close
                        </button>
                        <button type="submit" class="btn btn-primary font-weight-bold">
                            <span class="indicator-label">Add</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection


@section('js')


@endsection
