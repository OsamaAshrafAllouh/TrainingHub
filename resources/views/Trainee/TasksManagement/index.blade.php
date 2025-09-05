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
                <h3 class="card-label">Solve Task</h3>
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
                    <th>Task Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Mark</th>
                    <th>Files</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($tasks as $task)
                    <tr data-entry-id="{{ $task->id }}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$task->program->name}}</td>
                        <td>{{$task->description}}</td>
                        <td>{{$task->start_date}}</td>
                        <td>{{$task->end_date}}</td>
                        <td>{{$task->mark}}</td>
                        <td>
                            @if(count($task->related_file ?? []) > 0)
                                @foreach($task->related_file as $otherFileUrl)
                                    <a href="{{ $otherFileUrl }}" class="btn btn-primary" target="_blank"
                                       rel="noopener noreferrer">Task File</a>
                                @endforeach
                            @else
                                <span
                                    class="label font-weight-bold label-lg  label-light-danger label-inline">
                                    No Task File</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('task', $task->id) }}" class="btn btn-sm btn-clean btn-icon"
                               title="Solve Task">
                                <i class="la la-send"> </i>Submit
                            </a>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>

    @if(!$tasks->isEmpty())
    <form method="POST" action="{{ route('Training-tasks.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="exampleModalLabel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Solve {{ $task->program->name}} Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row pt-4">
                            <div class="col-lg-12">
                                <label for="name">Submit Solution<span class="text-danger">*</span></label>
                                <input type="file"
                                       class="form-control {{ $errors->has('solution') ? 'is-invalid' : '' }}"
                                       name="solution" id="solution" value="{{ old('solution') }}"
                                       placeholder="Enter Field Name" required/>
                                @if($errors->has('solution'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('solution') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Include a hidden input field for the task ID -->
                        <input type="hidden" name="task_id" value="{{ $task->id }}">
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
    @endif

@endsection


@section('js')

    <script>

        function showTaskSolvedNotification() {
            toastr.error('You have already solved this task. You can edit the solution before the end date.');
        }
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
