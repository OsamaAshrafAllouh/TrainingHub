@extends('Dashboard.master')

@section('title')
    Solve Task
@endsection

@section('css')

@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
				<span class="card-icon">
                    <i class="flaticon2-favourite text-primary"></i>
				</span>
                <h3 class="card-label">Meetings</h3>
            </div>
            <div class="card-toolbar">
                <a href="{{route('meetings.create')}}"
                   class="btn btn-sm btn-light-primary er fs-6 px-8 py-4" data-bs-toggle="modal"
                   data-bs-target="#kt_modal_new_target" data-toggle="modal"
                   data-target="#exampleModal">
                    <i class="la la-plus"></i> Create new Meeting Request
                </a>

                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                   style="margin-top: 13px !important">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Advisor</th>
                    <th>Program</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($meetings as $meeting)
                    <tr data-entry-id="{{ $meeting->id }}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$meeting->advisor->first_name ." " .$meeting->advisor->last_name}}</td>
                        <td>{{$meeting->program->name}}</td>
                        <td>{{$meeting->date}}</td>
                        <td>{{$meeting->time}}</td>
                        <td>
                            <span style="width: 108px;">
                                @if ($meeting->status === 'accepted')
                                    <span class="label font-weight-bold label-lg label-light-primary label-inline">
                                        Accepted
                                    </span>
                                @elseif ($meeting->status === 'rejected')
                                    <span class="label font-weight-bold label-lg label-light-danger label-inline">
                                        Rejected
                                    </span>
                                @else
                                    <span class="label font-weight-bold label-lg label-light-warning label-inline">
                                        Pending
                                    </span>
                                @endif
                            </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>

    <form method="POST" action="{{ route('meetings.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Meeting Request</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row pt-4">
                            <div class="col-lg-12">
                                <label for="advisor_id">Advisor<span class="text-danger">*</span></label>
                                <select class="form-control {{ $errors->has('advisor_id') ? 'is-invalid' : '' }}"
                                        name="advisor_id" id="advisor_id" required>
                                    <option value="">Select Advisor</option>
                                    @foreach ($distinctAdvisors as $program)
                                        <option
                                            value="{{ $program->program->advisor_id }}">{{ $program->program->advisor->first_name . ' ' . $program->program->advisor->last_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('advisor_id'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('advisor_id') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row pt-4">
                            <div class="col-lg-12">
                                <label for="program_id">Program<span class="text-danger">*</span></label>
                                <select class="form-control {{ $errors->has('program_id') ? 'is-invalid' : '' }}"
                                        name="program_id" id="program_id" required>
                                    <option value="">Select Program</option>

                                </select>
                                @if ($errors->has('program_id'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('program_id') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row pt-4">
                            <div class="col-lg-12">
                                <label for="name">Date<span class="text-danger">*</span></label>
                                <input type="date"
                                       class="form-control {{ $errors->has('date') ? 'is-invalid' : '' }}" name="date"
                                       id="date" value="{{ old('date') }}" placeholder="Enter Date" required/>
                                @if($errors->has('date'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('date') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row pt-4">

                            <div class="col-lg-12">
                                <label for="name">Time<span class="text-danger">*</span></label>
                                <input type="time"
                                       class="form-control {{ $errors->has('time') ? 'is-invalid' : '' }}" name="time"
                                       id="time" value="{{ old('time') }}" placeholder="Enter Time" required/>
                                @if($errors->has('time'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('time') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Include a hidden input field for the task ID -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">
                            Close
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
    <script>
        $(document).ready(function () {
            // Handler for advisor selection change event
            $('#advisor_id').on('change', function () {
                var advisorId = $(this).val();
                var programOptions = $('#program_id');
                programOptions.empty(); // Clear existing options

                if (advisorId) {
                    // Send an AJAX request to fetch the programs for the selected advisor
                    $.ajax({
                        url: '/get-programs-by-advisor/' + advisorId,
                        type: 'GET',
                        success: function (response) {
                            // Add the fetched programs as options without clearing existing options
                            response.forEach(function (program) {
                                programOptions.append('<option value="' + program.id + '">' + program.name + '</option>');
                            });
                        },
                        error: function (xhr, status, error) {
                            // Handle the error if necessary
                        }
                    });
                }
            });
        });
    </script>
    <form method="POST" action="{{ route('meetings.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Meeting Request</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row pt-4">
                            <div class="col-lg-12">
                                <label for="advisor_id">Advisor<span class="text-danger">*</span></label>
                                <select class="form-control {{ $errors->has('advisor_id') ? 'is-invalid' : '' }}"
                                        name="advisor_id" id="advisor_id" required>
                                    <option value="">Select Advisor</option>
                                    @foreach ($distinctAdvisors as $program)
                                        <option
                                            value="{{ $program->program->advisor_id }}">{{ $program->program->advisor->first_name . ' ' . $program->program->advisor->last_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('advisor_id'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('advisor_id') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row pt-4">
                            <div class="col-lg-12">
                                <label for="program_id">Program<span class="text-danger">*</span></label>
                                <select class="form-control {{ $errors->has('program_id') ? 'is-invalid' : '' }}"
                                        name="program_id" id="program_id" required>
                                    <option value="">Select Program</option>

                                </select>
                                @if ($errors->has('program_id'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('program_id') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row pt-4">
                            <div class="col-lg-12">
                                <label for="name">Date<span class="text-danger">*</span></label>
                                <input type="date"
                                       class="form-control {{ $errors->has('date') ? 'is-invalid' : '' }}" name="date"
                                       id="date" value="{{ old('date') }}" placeholder="Enter Date" required/>
                                @if($errors->has('date'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('date') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row pt-4">

                            <div class="col-lg-12">
                                <label for="name">Time<span class="text-danger">*</span></label>
                                <input type="time"
                                       class="form-control {{ $errors->has('time') ? 'is-invalid' : '' }}" name="time"
                                       id="time" value="{{ old('time') }}" placeholder="Enter Time" required/>
                                @if($errors->has('time'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('time') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Include a hidden input field for the task ID -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary font-weight-bold">
                            <span class="indicator-label">Add</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
    </script>

    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/html.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script>
        function deleteRows(id, reference) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1BC5BD',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/programs/' + id,
                        method: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function (response) {
                            reference.closest('tr').remove();
                            // Show the success message
                            Swal.fire(
                                'Deleted!',
                                'Course has been deleted.',
                                'success'
                            ).then(() => {
                                // Reload the page
                                location.reload();
                            });
                        },
                        error: function (xhr, status, error) {
                            console(error);
                            // Show the error message
                            Swal.fire(
                                'Error!',
                                'There was an error deleting Course.',
                                'error'
                            );
                        }
                    });
                }
            });

        }
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

@endsection
