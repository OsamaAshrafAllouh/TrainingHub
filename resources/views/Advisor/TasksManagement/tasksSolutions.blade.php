@extends('Dashboard.master')

@section('title')
    Task
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
                <h3 class="card-label">Tasks Evaluation</h3>
            </div>
        </div>

        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Program</th>
                    <th>Task Description</th>
                    <th>Trainee name</th>
                    <th>Solution</th>
                    <th>Mark</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($tasks as $task)
                    @foreach ($task->trainingTasks as $trainingTask)
                        <tr data-entry-id="{{ $task->id }}">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$task->program->name}}</td>
                            <td>{{$task->description}}</td>
                            <td>{{$trainingTask->trainee->first_name ." ". $trainingTask->trainee->last_name}}</td>
                            <td>
                                @if ($trainingTask->solution)
                                    <a href="{{ $trainingTask->solution }}" target="_blank">View Solution</a>
                                @else
                                    No Solution
                                @endif
                            </td>
                            <td>
                                <span id="mark_{{$trainingTask->id}}">{{$trainingTask->mark ?? '-'}}</span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="editMark({{$trainingTask->id}})">Edit Mark</button>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Mark</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body col-lg-12">
                    <input type="number" min="0" max="{{$task->mark}}" name="mark" id="editMarkInput" placeholder="Enter Mark" class="col-lg-12">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveMarkButton">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/html.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        function editMark(trainingTaskId) {
            var markElement = document.getElementById('mark_' + trainingTaskId);
            var mark = markElement.innerText;

            var modalTitleElement = document.getElementById('editModalLabel');
            var markInput = document.getElementById('editMarkInput');
            var saveButton = document.getElementById('saveMarkButton');

            modalTitleElement.innerText = 'Edit Mark';
            markInput.value = mark;

            saveButton.onclick = function () {
                var newMark = markInput.value;
                saveMark(trainingTaskId, newMark);
            };

            // Show the modal
            $('#editModal').modal('show');
        }

        function saveMark(trainingTaskId, newMark) {
            // Send an AJAX request to save the mark
            axios.post('{{ route("save.mark") }}', {
                trainingTaskId: trainingTaskId,
                mark: newMark
            })
                .then(function (response) {
                    // Update the mark element with the new value
                    var markElement = document.getElementById('mark_' + trainingTaskId);
                    markElement.innerText = newMark;

                    // Hide the modal
                    $('#editModal').modal('hide');

                    // Show a success message
                    toastr.success('The task is evaluated');
                })
                .catch(function (error) {
                    // Handle the error if needed
                    console.error(error);
                    toastr.error('Error occurred');
                });
        }
    </script>
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
                        url: '/tasks/' + id,
                        method: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function (response) {
                            reference.closest('tr').remove();
                            // Show the success message
                            Swal.fire(
                                'Deleted!',
                                'Task has been deleted.',
                                'success'
                            ).then(() => {
                                // Reload the page
                            });
                        },
                        error: function (xhr, status, error) {
                            console(error);
                            // Show the error message
                            Swal.fire(
                                'Error!',
                                'There was an error deleting Task.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
@endsection
