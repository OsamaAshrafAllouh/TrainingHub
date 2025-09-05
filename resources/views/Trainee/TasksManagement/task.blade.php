@extends('Dashboard.master')

@section('title')
    Show Task
@endsection

@section('css')

@endsection

@section('content')
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="card card-custom">
                <div class="card-body p-0">
                    <!--begin::Invoice-->
                    <div class="row justify-content-center pt-8 px-8 pt-md-27 px-md-0">
                        <div class="col-md-9">
                            <div class="rounded-xl overflow-hidden w-100 max-h-md-250px mb-50">
                                <img src="{{asset('admin/assets/media/bg/pg-invoices-7.png')}}" class="w-100" alt="">
                            </div>
                            <!--end: Invoice header-->
                            <!--begin: Invoice body-->
                            <div class="row border-bottom pb-10">
                                <div class="col-md-12 py-md-20 pr-md-20">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th class="pt-5 pb-9 pl-0 font-weight-bolder text-muted font-size-lg text-uppercase">
                                                    Task Details
                                                </th>
                                                <th class="pt-1 pb-9 text-center font-weight-bolder text-muted font-size-lg text-uppercase">
                                                    #
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="font-weight-bolder font-size-lg">
                                                <td class="border-top-0 pl-0 pt-7 d-flex align-items-center">
                                            <span class="navi-icon mr-2">
                                                <i class="fa fa-genderless text-danger font-size-h2"></i>
                                            </span>Program
                                                </td>
                                                <td class="text-center pt-7">{{$task->Program->name}}</td>
                                            </tr>
                                            <tr class="font-weight-bolder border-bottom-0 font-size-lg">
                                                <td class="border-top-0 pl-0 py-4 d-flex align-items-center">
                                            <span class="navi-icon mr-2">
                                                <i class="fa fa-genderless text-success font-size-h2"></i>
                                            </span>Start Date
                                                </td>
                                                <td class="border-top-0 text-center py-4">{{$task->start_date}}</td>
                                            </tr>
                                            <tr class="font-weight-bolder border-bottom-0 font-size-lg">
                                                <td class="border-top-0 pl-0 py-4 d-flex align-items-center">
                                            <span class="navi-icon mr-2">
                                                <i class="fa fa-genderless text-primary font-size-h2"></i>
                                            </span>End Date
                                                </td>
                                                <td class="border-top-0 text-center py-4">{{$task->end_date}}</td>
                                            </tr>

                                            <tr class="font-weight-bolder border-bottom-0 font-size-lg">
                                                <td class="border-top-0 pl-0 py-4 d-flex align-items-center">
                                                      <span class="navi-icon mr-2">
                                                          <i class="fa fa-genderless text-warning font-size-h2"></i>
                                                      </span>Can Solve or Edit Task
                                                </td>
                                                <td class="border-top-0 text-center py-4">
                                                    @if ($task->start_date <= now() && $task->end_date >= now() && !$task->marks)
                                                        <span
                                                            class="label font-weight-bold label-lg label-light-success label-inline">Yes</span>
                                                    @elseif($task->start_date > now())
                                                        <span
                                                            class="label font-weight-bold label-lg label-light-danger label-inline">No , Submission not available yet </span>
                                                    @elseif($task->marks)
                                                        <span
                                                            class="label font-weight-bold label-lg label-light-danger label-inline">No , Task is  Evaluated </span>
                                                    @else
                                                        <span
                                                            class="label font-weight-bold label-lg label-light-danger label-inline">No , The specified time for solving the task has been completed </span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="font-weight-bolder border-bottom-0 font-size-lg">
                                                <td class="border-top-0 pl-0 py-4 d-flex align-items-center">
                                                             <span class="navi-icon mr-2">
                                                                 <i class="fa fa-genderless text-info font-size-h2"></i>
                                                             </span>Submit task
                                                </td>
                                                <td class="border-top-0 text-center py-4">
                                                    @if ($task->solution)
                                                        <span
                                                            class="label font-weight-bold label-lg label-light-success label-inline">Yes</span>
                                                    @else
                                                        <span
                                                            class="label font-weight-bold label-lg label-light-danger label-inline">No</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="font-weight-bolder border-bottom-0 font-size-lg">
                                                <td class="border-top-0 pl-0 py-4 d-flex align-items-center">
                                            <span class="navi-icon mr-2">
                                                <i class="fa fa-genderless text-secondary font-size-h2"></i>
                                            </span>Mark Weight
                                                </td>
                                                <td class="border-top-0 text-center py-4">{{$task->mark}}</td>
                                            </tr>
                                            <tr class="font-weight-bolder border-bottom-0 font-size-lg">
                                                <td class="border-top-0 pl-0 py-4 d-flex align-items-center">
                                            <span class="navi-icon mr-2">
                                                <i class="fa fa-genderless text-danger font-size-h2"></i>
                                            </span>Task Description
                                                </td>
                                                <td class="border-top-0 text-center py-4">{{$task->description}}</td>
                                            </tr>
                                            <tr class="font-weight-bolder border-bottom-0 font-size-lg">
                                                <td class="border-top-0 pl-0 py-4 d-flex align-items-center">
                                            <span class="navi-icon mr-2">
                                                <i class="fa fa-genderless text-success font-size-h2"></i>
                                            </span>Task File
                                                </td>
                                                <td class="border-top-0 text-center py-4">
                                                    @if (count($task->related_file ?? []) > 0)
                                                        @foreach ($task->related_file as $otherFileUrl)
                                                            <a href="{{ $otherFileUrl }}" class="btn btn-primary"
                                                               target="_blank" rel="noopener noreferrer">Related
                                                                File</a>
                                                        @endforeach
                                                    @else
                                                        <span class="text-muted">No File</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @if ($task->solution)
                                                <tr class="font-weight-bolder border-bottom-0 font-size-lg">
                                                    <td class="border-top-0 pl-0 py-4 d-flex align-items-center">
                                                            <span class="navi-icon mr-2">
                                                                <i class="fa fa-genderless text-warning font-size-h2"></i>
                                                            </span>
                                                        Task Solution
                                                    </td>
                                                    <td class="border-top-0 text-center py-4">
                                                        @if($task->solution)
                                                            <a href="{{ $task->solution}}" class="btn btn-primary"
                                                               target="_blank"
                                                               rel="noopener noreferrer">Download Solution</a>
                                                        @endif

                                                    </td>
                                                </tr>
                                            @endif

                                            <tr class="font-weight-bolder border-bottom-0 font-size-lg">
                                                <td class="border-top-0 pl-0 py-4 d-flex align-items-center">
                                                     <span class="navi-icon mr-2">
                                                         <i class="fa fa-genderless text-secondary font-size-h2"></i>
                                                     </span>
                                                    Task Evaluation
                                                </td>
                                                <td class="border-top-0 text-center py-4">
                                                    @if ($task->marks)
                                                        {{ $task->marks }}
                                                        <br>

                                                        <span
                                                            class="label font-weight-bold label-lg label-light-danger label-inline">Cannot Edit Your Submission</span>
                                                    @else
                                                        Not Evaluated Yet
                                                    @endif
                                                </td>
                                            </tr>


                                            @if ($task->start_date <= now() && $task->end_date >= now() && !$task->solution )
                                                <tr class="font-weight-bolder border-bottom-0 font-size-lg">
                                                    <td class="border-top-0 pl-0 py-4 d-flex align-items-center">
                                                            <span class="navi-icon mr-2">
                                                                <i class="fa fa-genderless text-success font-size-h2"></i>
                                                            </span>
                                                        Submit Task Solution
                                                    </td>
                                                    <td class="border-top-0 text-center py-4">
                                                        <form method="POST" action="{{ route('Training-tasks.store') }}"
                                                              enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="task_id" value="{{ $task->id }}">
                                                            <input type="file" class="form-control" name="solution"
                                                                   required>
                                                            <button type="submit" class="btn btn-primary mt-3">Submit
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @elseif ($task->solution && $task->end_date >= now() && !$task->marks)
                                                <tr class="font-weight-bolder border-bottom-0 font-size-lg">
                                                    <td class="border-top-0 pl-0 py-4 d-flex align-items-center">
                                                          <span class="navi-icon mr-2">
                                                              <i class="fa fa-genderless text-info font-size-h2"></i>
                                                          </span>
                                                        Can Edit Task
                                                    </td>
                                                    <td class="border-top-0 text-center py-4">
                                                        <a href="{{ route('Training-tasks.edit', $task->id) }}"
                                                           class="btn btn-sm btn-clean btn-icon" data-toggle="modal"
                                                           data-target="#editModal" title="Solve Task">
                                                            <i class="la la-check-circle"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--end: Invoice body-->
                        </div>
                    </div>
                    <!-- begin: Invoice action-->
                    <div class="row justify-content-center py-8 px-8 py-md-28 px-md-0">
                        <div class="col-md-9">
                            <div class="d-flex font-size-sm flex-wrap">

                                <a class="btn btn-primary font-weight-bolder py-4 mr-3 mr-sm-14 my-1"
                                   href="{{ route('Training-tasks.index') }}">Back</a>

                            </div>
                        </div>
                    </div>
                    <!-- end: Invoice action-->
                    <!--end::Invoice-->
                </div>

            </div>
        </div>
        <form method="POST" action="{{ route("Training-tasks.update", $task->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Task Submission</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row pt-4">

                                <div class="col-lg-12">
                                    <label for="taskFile">Task File</label>
                                    <input type="file" class="form-control-file" id="taskFile" name="solution">
                                    @if($errors->has('solution'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('solution') }}
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
    </div>

@endsection


@section('js')
    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/html.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script>
        // Event listener for checkbox change
        $(document).on('change', 'input[name="select"]', function () {
            var advisorId = $(this).data('id');
            var isChecked = $(this).prop('checked');

            // AJAX call to update advisor approval status
            $.ajax({
                url: '/sendmail/' + advisorId,
                type: 'GET',
                success: function (response) {
                    // Handle success response
                    if (isChecked) {
                        toastr.success('Advisor is now approved.');
                    } else {
                        toastr.warning('Advisor is now not approved.');
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    toastr.error('Error occurred. Please try again.');
                }
            });
        });
    </script>

@endsection
