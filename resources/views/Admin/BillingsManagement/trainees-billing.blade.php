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
                <h3 class="card-label">Trainee Not Paid To paid Program</h3>
            </div>
        </div>

        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                   style="margin-top: 13px !important">

                <thead>
                <tr>

                    <th>#</th>
                    <th>Trainee Name</th>
                    <th>Program Name</th>
                    <th>Payment For Program</th>
                    <th>status</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($trainees as $trainee)
                    <tr data-entry-id="{{ $trainee->id }}">
                        <td>{{$loop->iteration}}</td>

                        <td>{{ $trainee->first_name . " " .$trainee->last_name}}</td>
                        <td>{{ $trainee->program_name }}</td>
                        <td>{{ $trainee->payment_status }}</td>
                        <td>
                            @if($trainee->send_email == 0)
                                <div class="col-3">
                                 <span class="switch switch-primary">
                                     <label>
                                         <input type="checkbox"
                                                {{ $trainee->payment_status == 'unpaid' ? '' : 'checked' }} name="select"
                                                data-id="{{ $trainee->id }}"
                                                data-program-id="{{ $trainee->program_id }}"
                                                onchange="updateStatus(this)">
                                         <span></span>
                                     </label>
                                 </span>
                                </div>
                            @else
                                Trainee is Pending in this course , Send Email Successfully
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        function updateStatus(checkbox) {
            let traineeId = checkbox.getAttribute('data-id');
            let programId = checkbox.getAttribute('data-program-id');
            let isChecked = checkbox.checked;

            console.log(traineeId);
            console.log(programId);

            axios.post('/trainee/update-status/' + traineeId, {program_id: programId})
                .then(function (response) {
                    const message = response.data.message;
                    // Display the toastr message only if it hasn't been displayed before
                    toastr.success(message);

                    console.log(response.data.success);

                    // Update the status column in the table if successful
                    let statusCell = checkbox.parentElement.parentElement.parentElement.lastElementChild;
                    statusCell.textContent = isChecked ? 'pending' : 'unpaid';
                })
                .catch(function (error) {
                    // Display error message or handle error as needed
                    console.log(error.response.data.error);
                });
        }

    </script>    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Toastr library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/html.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
@endsection
