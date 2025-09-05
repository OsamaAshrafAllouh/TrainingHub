@extends('Dashboard.master')

@section('title')
    Advisors  Fields
@endsection

@section('css')

@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
				<span class="card-icon">
                    <i class="flaticon2-favourite text-primary"></i>
				</span>
                <h3 class="card-label">Fields</h3>
            </div>
        </div>

        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                   style="margin-top: 13px !important">

                <thead>
                <tr>

                    <th>#</th>
                    <th>Advisor Name</th>
                    <th>Field Name</th>
                    <th>status</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($advisor_fields as $advisor_field)
                    <tr data-entry-id="{{ $advisor_field->id }}">
                        <td>{{$loop->iteration}}</td>

                        <td>{{ $advisor_field->advisor->first_name . " " .$advisor_field->advisor->last_name}}</td>
                        <td>{{ $advisor_field->field->name }}</td>
                        <td>
                            <div class="col-3">
                               <span class="switch switch-primary">
                                   <label>
                                       <input type="checkbox" {{ $advisor_field->status == 'accept' ? 'checked' : '' }} name="select" data-id="{{ $advisor_field->id }}">
                                       <span></span>
                                   </label>
                               </span>
                            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        // Get all checkboxes with the name "select"
        const checkboxes = document.getElementsByName('select');

        // Attach a change event listener to each checkbox
        // Create an object to store the displayed toastr messages
        const displayedMessages = {};

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const advisorFieldId = this.dataset.id;
                const status = this.checked ? 'accept' : 'not-accept'; // Determine the new status

                // Send an AJAX request to update the advisor field status
                axios.put(`/update-status/${advisorFieldId}`, { status })
                    .then(response => {
                        if (status === 'accept') {
                            if (response.data.isAccepted) {
                                const message = response.data.message;
                                // Display the toastr message only if it hasn't been displayed before
                                if (!displayedMessages[message]) {
                                    toastr.success(message);
                                    displayedMessages[message] = true;
                                }
                            } else {
                                toastr.error("The advisor is not accepted yet !");
                            }
                        } else if (status === 'not-accept') {
                            if (response.data.isAccepted) {
                                const message = response.data.message;
                                // Display the toastr message only if it hasn't been displayed before
                                if (!displayedMessages[message]) {
                                    toastr.warning(message);
                                    displayedMessages[message] = true;
                                }
                            } else {
                                toastr.error("The advisor is not accepted yet ! ");
                            }
                        } else {
                            toastr.error(response.data.message);
                        }
                    })
                    .catch(error => {
                        toastr.error('Error updating status: ' + error);
                    });
            });
        });



    </script>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Toastr library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/html.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
@endsection
