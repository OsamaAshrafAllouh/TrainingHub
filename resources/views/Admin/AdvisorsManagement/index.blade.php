@extends('Dashboard.master')

@section('title')
    Advisors
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
                <h3 class="card-label">Advisor Data</h3>
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
                    <th>Address</th>
                    <th>City</th>
                    <th>Status</th>
                    <th>Language</th>
                    <th>Actions</th>
                    <th>Documents</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($advisors as $advisor)
                    <tr data-entry-id="{{ $advisor->id }}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$advisor->first_name}} {{$advisor->last_name}}</td>
                        <td>{{$advisor->email}}</td>
                        <td>{{$advisor->phone}}</td>
                        <td>{{$advisor->education}}</td>
                        <td>{{$advisor->address}}</td>
                        <td>{{$advisor->city}}</td>
                        <td data-entry-id="{{ $advisor->id }}" class="datatable-cell status-cell">
    <span style="width: 108px;">
        <span class="label font-weight-bold label-lg label-light-{{ $advisor->is_approved ? 'primary' : 'danger' }} label-inline">
            {{ $advisor->is_approved ? 'Approved' : 'Not Approved' }}
        </span>
    </span>
                        </td>
                        <td>{{$advisor->language}}</td>
                        <td>
                            <a href="{{ route('advisors.show', $advisor->id) }}"
                               class="btn btn-sm btn-clean btn-icon"
                               title="Show details">
                                <i class="la la-eye"></i>
                            </a>
                            <a onclick="deleteRows('{{$advisor->id}}', this)"
                               class="btn btn-sm btn-clean btn-icon btn-delete" title="Delete">
                                <i class="nav-icon la la-trash"></i>
                            </a>
                            <a class="btn btn-sm btn-clean btn-icon" title="Approve" onclick="sendEmail({{ $advisor->id }})">
                                <i class="la la-check-circle"></i>
                            </a>
                        </td>
                        <td>
                            @if($advisor->cv)
                                <a href="{{ $advisor->cv}}" class="btn btn-primary" target="_blank"
                                   rel="noopener noreferrer">Download CV</a>
                            @endif

                            @if($advisor->certification)
                                <a href="{{ $advisor->certification }}" class="btn btn-primary" target="_blank"
                                   rel="noopener noreferrer">Download Certification</a>
                            @endif

                            @if(count($advisor->otherFile ?? []) > 0)
                                @foreach($advisor->otherFile as $otherFileUrl)
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
    <!-- Modal -->
    <div class="modal fade" id="advisorModal" tabindex="-1" role="dialog" aria-labelledby="advisorModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="advisorModalLabel">Advisor Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Advisor fields and checkbox here -->
                    <div class="form-group">
                        <label for="acceptCheckbox">Accept Program</label>
                        <input type="checkbox" id="acceptCheckbox" name="acceptCheckbox">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveAdvisorBtn">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>
        $(document).ready(function () {
            $('.edit-btn').click(function () {
                var advisorId = $(this).data('advisor-id');
                $('#advisorModal').modal('show');

                // Perform additional logic if needed based on the advisor ID
                // and populate the modal fields accordingly
            });

            // Handle the save button click event
            $('#saveAdvisorBtn').click(function () {
                var acceptCheckbox = $('#acceptCheckbox').prop('checked');

                // Perform further processing based on the checkbox value (accept/reject program)
                // You can make an AJAX request here to update the advisor's program status accordingly

                // Close the modal
                $('#advisorModal').modal('hide');
            });
        });
    </script>
    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/html.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script>
        function sendEmail(advisorId) {
            // AJAX call to send email
            $.ajax({
                url: '/sendmail/' + advisorId,
                type: 'GET',
                success: function (response) {
                    var message = response.message;

                    if (message === 'Advisor Not Active Now') {
                        toastr.error(message); // Display error message
                        updateStatus(advisorId, 'Not Approved'); // Update status display
                    } else {
                        toastr.success(message); // Display success message
                        updateStatus(advisorId, 'Approved'); // Update status display
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    toastr.error('Error occurred. Please try again.');
                }
            });
        }

        function updateStatus(advisorId, status) {
            // Update the status cell in the table
            var statusCell = $('.status-cell[data-entry-id="' + advisorId + '"]');
            var labelClass = (status === 'Approved') ? 'label-light-primary' : 'label-light-danger';
            var labelContent = (status === 'Approved') ? 'Approved' : 'Not Approved';

            statusCell.html('<span style="width: 108px;"><span class="label font-weight-bold label-lg ' + labelClass + ' label-inline">' + labelContent + '</span></span>');
        }
    </script>

    <script>
        function deleteRows(id, reference) {
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
                        url: '/advisors/' + id,
                        method: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function (response) {
                            reference.closest('tr').remove();
                            // Show the success message
                            Swal.fire(
                                'Deleted!',
                                'Advisor has been deleted.',
                                'success'
                            )
                        },
                        error: function (xhr, status, error) {
                            console(error);
                            // Show the error message
                            Swal.fire(
                                'Error!',
                                'There was an error deleting role.',
                                'error'
                            );
                        }
                    });
                }
            });

        }
    </script>

@endsection
