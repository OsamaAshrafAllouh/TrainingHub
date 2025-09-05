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
                <h3 class="card-label">All Tasks to this program</h3>
            </div>
            <div class="card-toolbar">
                <a href="{{route('programs.index')}}"
                   class="btn btn-sm btn-light-primary er fs-6 px-8 py-4">
                    <i class="la la-retweet"></i> Back
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
                    <th>Task Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Mark</th>
                    <th>Files</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($tasks as $task)
                    <tr data-entry-id="{{ $task->id }}">
                        <td>{{$loop->iteration}}</td>
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

@endsection
