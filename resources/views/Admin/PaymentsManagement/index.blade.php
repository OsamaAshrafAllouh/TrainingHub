@extends('Dashboard.master')

@section('title')
    Payments
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
                <h3 class="card-label">Payments</h3>
            </div>
            <div class="card-toolbar">
                <a href="{{route('fields.create')}}"
                   class="btn btn-sm btn-light-primary er fs-6 px-8 py-4" data-bs-toggle="modal"
                   data-bs-target="#kt_modal_new_target" data-toggle="modal"
                   data-target="#exampleModal">
                    <i class="la la-plus"></i> Create new Field
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
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($payments as $payment)
                    <tr data-entry-id="{{ $payment->id }}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$payment->name}}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-clean btn-icon" data-toggle="modal"
                               data-target="#editModal" title="Edit details"
                               data-field-id="{{ $payment->id }}" data-field-name="{{ $payment->name }}">
                                <i class="la la-edit"></i>
                            </a>
                            <a onclick="deleteRows('{{$payment->id}}', this)"
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
    <form  method="POST" action="{{ route("payments.store") }}" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Payment Method</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row pt-4">

                            <div class="col-lg-12">
                                <label for="name">Field Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                       name="name" id="name" value="{{ old('name', '') }}"
                                       placeholder="Enter Payment Name" required/>
                                @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
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
    @if(!$payments->isEmpty())
        <form  id="editForm" method="POST" action="{{ route("payments.update", $payment->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Payment Method</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row pt-4">

                                <div class="col-lg-12">
                                    <label for="name">Payment Method Name<span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                           name="name" id="name" value="{{ old('name') }}"
                                           placeholder="Enter Field Name" required/>

                                    @if($errors->has('name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name') }}
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

        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var fieldId = button.data('field-id'); // Extracting the field ID from the button
            var fieldName = button.data('field-name'); // Extracting the field name from the button

            // Update the form action
            var form = $('#editForm');
            var action = form.attr('action');
            action = action.replace(/\/\d+$/, '/' + fieldId); // Replace the last segment of the URL with the field ID
            form.attr('action', action);

            // Update the input field value
            var inputName = form.find('#name');
            inputName.val(fieldName);

            // Add the 'is-invalid' class to the input field if there are errors
            if (fieldName) {
                inputName.removeClass('is-invalid');
            } else {
                inputName.addClass('is-invalid');
            }
        });

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
                        url: '/payments/' + id,
                        method: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function (response) {
                            reference.closest('tr').remove();
                            // Show the success message
                            Swal.fire(
                                'Deleted!',
                                'Payment way has been deleted.',
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
                                'There was an error deleting Payment way.',
                                'error'
                            );
                        }
                    });
                }
            });

        }
    </script>


@endsection
