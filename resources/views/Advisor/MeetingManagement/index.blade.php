@extends('Dashboard.master')

@section('title')
    Meeting Request
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
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                   style="margin-top: 13px !important">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Trainee</th>
                    <th>Program</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>change Status</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($meetings as $meeting)
                    <tr data-entry-id="{{ $meeting->id }}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$meeting->trainee->first_name ." " .$meeting->trainee->last_name}}</td>
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
                        <td>
                            <a href="#" class="btn btn-sm btn-clean btn-icon edit-button" data-toggle="modal"
                               data-target="#editModal" data-meeting-id="{{ $meeting->id }}" title="Edit Meeting status">
                                <i class="la la-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Change Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="editForm" method="POST" action="{{ route("meetings.update", ":meetingId") }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row pt-4">
                            <label for="status" class="col-lg-4 col-form-label text-lg-right">Status</label>
                            <div class="col-lg-8">
                                <select class="form-control" name="status" id="status" required>
                                    <option value="accepted">Accepted</option>
                                    <option value="rejected">Rejected</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary font-weight-bold">
                            <span class="indicator-label">Edit</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('js')
    <script>
        $(document).ready(function() {
            $('.edit-button').click(function() {
                var meetingId = $(this).data('meeting-id');
                var formAction = "{{ route('meetings.update', ':meetingId') }}";
                formAction = formAction.replace(':meetingId', meetingId);
                $('#editForm').attr('action', formAction);
            });
        });
    </script>

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
