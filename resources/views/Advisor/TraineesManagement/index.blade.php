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
                <h3 class="card-label">Trainee Data</h3>
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                   style="margin-top: 13px !important">
                <thead>
                <tr>

                    <th>#</th>
                    <th>Name</th>
                    <th>email</th>
                    <th>phone</th>
                    <th>education</th>
                    <th>gpa</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Program</th>
                    <th>Language</th>
                    <th>Actions</th>
                    <th>Documents</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($trainees as $trainee)
                    <tr data-entry-id="{{ $trainee->id }}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$trainee->first_name}} {{$trainee->last_name}}</td>
                        <td>{{$trainee->email}}</td>
                        <td>{{$trainee->phone}}</td>
                        <td>{{$trainee->education}}</td>
                        <td>{{$trainee->gpa}}</td>
                        <td>{{$trainee->address}}</td>
                        <td>{{$trainee->city}}</td>
                        <td>
                            @if (!empty($programName))
                                {{ $programName }}

                            @elseif ($trainee->programs->count() > 0)
                                @foreach ($trainee->programs as $program)
                                    <span class="badge badge-success">{{ $program->name }}</span>
                                @endforeach
                            @else
                                <span class="badge badge-danger">Not Accepted in any Program</span>
                            @endif
                        </td>
                        <td>{{$trainee->language}}</td>
                        <td>
                            <a href="{{ route('show_trainees_to_advisor', $trainee->id) }}"
                               class="btn btn-sm btn-clean btn-icon"
                               title="Show details">
                                <i class="la la-eye"></i>
                            </a>

                        </td>
                        <td>
                            @if($trainee->cv)
                                <a href="{{ $trainee->cv}}" class="btn btn-primary" target="_blank"
                                   rel="noopener noreferrer">Download CV</a>
                            @endif

                            @if($trainee->certification)
                                <a href="{{ $trainee->certification }}" class="btn btn-primary" target="_blank"
                                   rel="noopener noreferrer">Download Certification</a>
                            @endif

                            @if(count($trainee->otherFile ?? []) > 0)
                                @foreach($trainee->otherFile as $otherFileUrl)
                                    <a href="{{ $otherFileUrl }}" class="btn btn-primary" target="_blank"
                                       rel="noopener noreferrer">Related File</a>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/html.js')}}"></script>
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
