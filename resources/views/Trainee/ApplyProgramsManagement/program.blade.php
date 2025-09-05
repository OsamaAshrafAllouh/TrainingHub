@extends('Dashboard.master')

@section('title')
    Accepted Program
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
                <h3 class="card-label">Accepted Program </h3>
            </div>
            <div class="card-toolbar">


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
                    <th>Image</th>
                    <th>Program Name</th>
                    <th>Advisor</th>
                    <th>Hours</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Level</th>
                    <th>Language</th>
                    <th>Field</th>
                    <th>Program Description</th>
                    <th>Action</th>

                </tr>
                </thead>
                <tbody>
                @if(!$programs->isEmpty())
                    @foreach($programs as $program)
                        <tr data-entry-id="{{ $program->id }}">
                            <td>{{$loop->iteration}}</td>
                            <td>
                                @if ($program->program->image)
                                    <img class="pr-4" src="{{ asset('images/' . $program->program->image) }}"
                                         height="50px"
                                         width="50px"
                                         alt="Logo">
                                @else
                                    <img class="pr-4" src="{{asset('admin/assets/media/users/blank2.jpg')}}"
                                         height="50px"
                                         width="50px"
                                         alt="Logo">
                                @endif
                            </td>
                            <td>{{ $program->program->name }}</td>
                            <td>
                                @if ($program->program->advisor)
                                    <a href="{{ route('advisors.show', $program->program->advisor->id) }}">{{ $program->program->advisor->first_name . " " . $program->program->advisor->last_name }}</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $program->program->hours }}</td>

                            @if($program->program->start_date <= now() && $program->program->end_date > now())
                                <td data-field="Status" data-autohide-disabled="false" aria-label="3"
                                    class="datatable-cell"><span style="width: 108px;"><span
                                            class="label font-weight-bold label-lg  label-light-primary label-inline">Available</span></span>
                                </td>
                            @elseif($program->program->start_date >= now())
                                <td data-field="Status" data-autohide-disabled="false" aria-label="3"
                                    class="datatable-cell"><span style="width: 108px;"><span
                                            class="label font-weight-bold label-lg  label-light-danger label-inline">Not Start Yet</span></span>
                                </td>

                            @else
                                <td data-field="Status" data-autohide-disabled="false" aria-label="3"
                                    class="datatable-cell"><span style="width: 108px;"><span
                                            class="label font-weight-bold label-lg  label-light-danger label-inline">Finished program</span></span>
                                </td>
                            @endif
                            <td>{{ $program->program->start_date }}</td>
                            <td>{{ $program->program->end_date }}</td>
                            <td>{{ $program->program->type }}</td>
                            <td>    @if($program->program->type == 'free')
                                    No fees
                                @else
                                    {{ $program->program->price }}
                                @endif
                            </td>
                            <td>{{ $program->program->duration }}</td>
                            <td>{{ $program->program->level }}</td>
                            <td>{{ $program->program->language }}</td>
                            <td>{{ $program->program->field->name ?? 'N/A' }}</td>
                            <td>{{ $program->program->description ?? 'No Description' }}</td>
                            <td>
                                <a href="{{ route('calendar.view', $program->id) }}"
                                   class="btn btn-sm btn-clean btn-icon" title="View Calendar">
                                    <i class="la la-calendar"></i>
                                </a>
                            </td>

                        </tr>
                    @endforeach
                @endif
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
