@extends('Dashboard.master')

@section('title')
    Courses
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
                <h3 class="card-label">Programs </h3>
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                   style="margin-top: 13px !important">
                <thead>
                <tr>

                    <th>#</th>
                    <th>Image</th>
                    <th>Program Name</th>
                    <th>Advisor</th>
                    <th>Hours</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Number of Trainee</th>
                    <th>Duration</th>
                    <th>Level</th>
                    <th>Language</th>
                    <th>Field ID</th>
                    <th>Program Description</th>
                    <th>Actions</th>

                </tr>
                </thead>
                <tbody>
                @foreach($programs as $program)
                    <tr data-entry-id="{{ $program->id }}">
                        <td>{{$loop->iteration}}</td>
                        <td>
                            @if ($program->image)
                                <img class="pr-4" src="{{ asset('images/' . $program->image) }}" height="50px"
                                     width="50px"
                                     alt="Logo">
                            @else
                                <img class="pr-4" src="{{asset('admin/assets/media/users/blank2.jpg')}}" height="50px"
                                     width="50px"
                                     alt="Logo">
                            @endif
                        </td>
                        <td>{{ $program->name }}</td>
                        <td>
                            @if ($program->advisor)
                                <a href="{{ route('advisors.show', $program->advisor->id) }}">{{ $program->advisor->first_name . " " . $program->advisor->last_name }}</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $program->hours }}</td>
                        <td>{{ $program->start_date }}</td>
                        <td>{{ $program->end_date }}</td>
                        <td>{{ $program->type }}</td>
                        <td>
                            @if($program->type == 'free')
                                -
                            @else
                                {{ $program->price }}
                            @endif
                        </td>

                        <td>{{ $program->number }}</td>
                        <td>{{ $program->duration }}</td>
                        <td>{{ $program->level }}</td>
                        <td>{{ $program->language }}</td>
                        <td>{{ $program->field->name ?? 'N/A' }}</td>
                        <td>{{ $program->description ?? '--' }}</td>
                        <td>
                            <a href="{{ route('showTrainees', $program->id) }}"
                               class="btn btn-sm btn-clean btn-icon"
                               title="show Trainee in Course">
                                <i class="la la-eye-dropper"></i>
                            </a>
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

@endsection
