@extends('Dashboard.master')

@section('title')
    Trainees
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
                <h3 class="card-label">Trainee Requests</h3>
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Program</th>
                    <th>Advisor</th>
                    <th>Trainee</th>
                    <th>Status of Request</th>
                    <th>Course Type</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($programs as $program)
                    <tr data-entry-id="{{ $program->id }}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$program->program_name}}</td>
                        <td>{{$program->advisor}}</td>
                        <td>{{$program->trainee_name }}</td>
                        <td>
                            @if ($program->status == 'rejected')
                                <span class="label font-weight-bold label-lg label-light-danger label-inline">Reject</span>
                            @elseif ($program->status == 'pending')
                                <span class="label font-weight-bold label-lg label-light-warning label-inline">Pending</span>
                            @else
                                <span class="label font-weight-bold label-lg label-light-success label-inline">Accept</span>
                            @endif
                        </td>
                        <td>
                            @if ($program->program_type == 'paid')
                                @if ($program->payment_status == 'paid')
                                    <span class="label font-weight-bold label-lg label-light-primary label-inline">Paid</span>
                                @else
                                    <span class="label font-weight-bold label-lg label-light-danger label-inline">Not Paid</span>
                                @endif
                            @else
                                <span class="label font-weight-bold label-lg label-light-info label-inline"> Free Course</span>
                            @endif
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-clean btn-icon edit-button" data-toggle="modal"
                               data-target="#editModal" data-program-id="{{ $program->id }}" title="Edit details">
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

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Change Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="editForm" method="POST" action="{{ route("trainees-programs.update", ":programId") }}" enctype="multipart/form-data">
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
    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/html.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('.edit-button').click(function() {
                var programId = $(this).data('program-id');
                var formAction = "{{ route('trainees-programs.update', ':programId') }}";
                formAction = formAction.replace(':programId', programId);
                $('#editForm').attr('action', formAction);
            });
        });
    </script>
    <script src="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script>
        function sendEmail(traineeId) {
            // AJAX call to send email
            $.ajax({
                url: '/sendemail/' + traineeId,
                type: 'GET',
                success: function (response) {
                    var message = response.message;

                    if (message === 'Trainee Not Active Now') {
                        toastr.error(message); // Display success message
                        updateStatus('Not Approved'); // Update status display
                    } else {
                        toastr.success(message); // Display error message
                        updateStatus('Approved'); // Update status display

                    }
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    toastr.error('Error occurred. Please try again.');
                }
            });
        }

        function updateStatus(status) {
            var statusCell = $('.datatable-cell[data-field="Status"]');
            var labelClass = (status === 'Approved') ? 'label-light-primary' : 'label-light-danger';
            var labelContent = (status === 'Approved') ? 'Approved' : 'Not Approved';

            statusCell.html('<span style="width: 108px;"><span class="label font-weight-bold label-lg ' + labelClass + ' label-inline">' + labelContent + '</span></span>');
        }
    </script>
    <script>
        function sweetees(id, reference) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/trainees/' + id,
                        method: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function (response) {
                            reference.closest('tr').remove();
                            // Show the success message
                            Swal.fire(
                                'Deleted!',
                                'Trainee has been deleted.',
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
                                'There was an error deleting Training.',
                                'error'
                            );
                        }
                    });
                }
            });

        }


    </script>

@endsection
