@extends('Dashboard.master')

@section('title')
    Tasks
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
                <h3 class="card-label">Tasks Management</h3>
            </div>
            <div class="card-toolbar">
                <a href="{{route('tasks.create')}}"
                   class="btn btn-sm btn-light-primary er fs-6 px-8 py-4" data-bs-toggle="modal"
                   data-bs-target="#kt_modal_new_target" data-toggle="modal"
                   data-target="#exampleModal">
                    <i class="la la-plus"></i> Create new Task
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
                            <a href="{{ route('tasks.edit', $task->id) }}"
                               class="btn btn-sm btn-clean btn-icon" data-toggle="modal"
                               data-target="#editModal" title="Edit Task">
                                <i class="la la-edit"></i>
                            </a>
                            <a onclick="deleteRows('{{$task->id}}', this)"
                               class="btn btn-sm btn-clean btn-icon btn-delete" title="Delete">
                                <i class="nav-icon la la-trash"></i>
                            </a>
                        </td>


                    </tr>
                @endforeach

                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>
    <form method="POST" action="{{ route('tasks.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row pt-4">

                            <div class="col-lg-12">
                                <label for="name">Task Description<span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                       name="description" id="description" value="{{ old('description', '') }}"
                                       placeholder="Enter Task Description" required/>
                                @if($errors->has('description'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('description') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row pt-4">
                            <div class="col-lg-12">
                                <label for="name">Program<span class="text-danger">*</span></label>
                                <select name="program_id" required class="form-control">
                                    <option value="">Select Option</option>
                                    @foreach ($programs as $program)
                                        <option
                                            value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                                            {{ $program->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($errors->has('program_id'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('program_id') }}
                                    </div>
                                @endif
                            </div>

                        </div>

                        <div class="form-group row pt-4">

                            <div class="col-lg-6">
                                <label for="name">Task Start Date<span class="text-danger">*</span></label>
                                <input type="date"
                                       class="form-control {{ $errors->has('start_date') ? 'is-invalid' : '' }}"
                                       name="start_date" id="start_date" value="{{ old('start_date', '') }}"
                                       placeholder="Enter start Date of Task" required/>
                                @if($errors->has('start_date'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('start_date') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Task End Data<span class="text-danger">*</span></label>
                                <input type="date"
                                       class="form-control {{ $errors->has('end_date') ? 'is-invalid' : '' }}"
                                       name="end_date" id="end_date" value="{{ old('end_date', '') }}"
                                       placeholder="Enter End Date of Task" required/>
                                @if($errors->has('end_date'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('end_date') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row pt-4">

                            <div class="col-lg-6">
                                <label for="name">Task Mark<span class="text-danger">*</span></label>
                                <input type="number" class="form-control {{ $errors->has('mark') ? 'is-invalid' : '' }}"
                                       name="mark" id="mark" value="{{ old('mark', '') }}"
                                       placeholder="Enter start Date of Task" required/>
                                @if($errors->has('mark'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('mark') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-lg-6">
                                <label for="name">Task File</label>
                                <input type="file" multiple
                                       class="form-control {{ $errors->has('related_file') ? 'is-invalid' : '' }}"
                                       name="related_file[]" id="related_file" value="{{ old('related_file', '') }}"
                                       placeholder="File Related to Task" />
                                @if($errors->has('related_file'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('related_file') }}
                                    </div>
                                @endif
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
    @if(!$tasks->isEmpty())
        <form method="POST" action="{{ route("tasks.update", $task->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Task</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row pt-4">
                                <div class="col-lg-12">
                                    <label for="name">Task Description<span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                           name="description" id="description" value="{{ old('description',$task->description) }}"
                                           placeholder="Enter Task Description" required/>
                                    @if($errors->has('description'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('description') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row pt-4">
                                <div class="col-lg-12">
                                    <label for="name">Program<span class="text-danger">*</span></label>
                                    <select name="program_id" required class="form-control">
                                        <option value="">Select Option</option>
                                        @foreach ($programs as $program)
                                            <option
                                                value="{{ $program->id }}" {{ old('program_id',$task->program_id) == $program->id ? 'selected' : '' }}>
                                                {{ $program->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('program_id'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('program_id') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row pt-4">
                                <div class="col-lg-6">
                                    <label for="name">Task Start Date<span class="text-danger">*</span></label>
                                    <input type="date"
                                           class="form-control {{ $errors->has('start_date') ? 'is-invalid' : '' }}"
                                           name="start_date" id="start_date" value="{{ old('start_date',$task->start_date) }}"
                                           placeholder="Enter start Date of Task" required/>
                                    @if($errors->has('start_date'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('start_date') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="col-lg-6">
                                    <label for="name">Task End Data<span class="text-danger">*</span></label>
                                    <input type="date"
                                           class="form-control {{ $errors->has('end_date') ? 'is-invalid' : '' }}"
                                           name="end_date" id="end_date" value="{{ old('end_date',$task->end_date) }}"
                                           placeholder="Enter End Date of Task" required/>
                                    @if($errors->has('end_date'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('end_date') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row pt-4">
                                <div class="col-lg-6">
                                    <label for="name">Task Mark<span class="text-danger">*</span></label>
                                    <input type="number"
                                           class="form-control {{ $errors->has('mark') ? 'is-invalid' : '' }}"
                                           name="mark" id="mark" value="{{ old('mark',$task->mark) }}"
                                           placeholder="Enter start Date of Task" required/>
                                    @if($errors->has('mark'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('mark') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="col-lg-6">
                                    <label for="name">Task File</label>
                                    <input type="file" multiple
                                           class="form-control {{ $errors->has('related_file') ? 'is-invalid' : '' }}"
                                           name="related_file[]" id="related_file" value="{{ old('related_file') }}"
                                           placeholder="File Related to Task" />
                                    @if($errors->has('related_file'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('related_file') }}
                                        </div>
                                    @endif
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
                    </div>
                </div>
            </div>
        </form>

    @endif
@endsection


@section('js')

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
