@extends('Dashboard.master')

@section('title')
    Update Password
@endsection

@section('css')

@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header py-3">
            <div class="card-title align-items-start flex-column">
                <h3 class="card-label font-weight-bolder text-dark">Change Password</h3>
                <span class="text-muted font-weight-bold font-size-sm mt-1">Change your account password</span>
            </div>
            <div class="card-toolbar">
                <div class="card-toolbar" style="margin-left: 311px;">
                    <button type="button" class="btn btn-primary mr-2" onclick="submitForm()">Save Changes</button>
                    <button type="reset" class="btn btn-secondary" onclick="resetForm()">Cancel</button>
                </div>
            </div>


        </div>
        <div class="card-body">
            <!--begin::Form-->
            <form id="passwordForm" class="form"
                  action="{{route('password.update',\Illuminate\Support\Facades\Auth::user()->id)}}"
                  method="POST">
                @csrf
                <!--end::Alert-->
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label text-alert">Current Password</label>
                    <div class="col-lg-9 col-xl-6">
                        <input name="oldPassword" type="password"
                               class="form-control form-control-lg form-control-solid mb-2" value=""
                               placeholder="Current password" required>
                        <a href="{{route('password.request')}}" class="text-sm font-weight-bold">Forgot password ?</a>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label text-alert">New Password</label>
                    <div class="col-lg-9 col-xl-6">
                        <input id="password" type="password"
                               class="form-control form-control-lg form-control-solid"
                               name="password"
                               autocomplete="new-password" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label text-alert">Verify Password</label>
                    <div class="col-lg-9 col-xl-6">
                        <input id="password_confirmation" type="password"
                               class="form-control form-control-lg form-control-solid"
                               name="password_confirmation" autocomplete="new-password" required>
                    </div>

                </div>

            </form>
            <!--end::Form-->

        </div>
    </div>

@endsection


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        function submitForm() {
            var form = document.getElementById('passwordForm');
            var oldPassword = form.elements['oldPassword'].value;
            var newPassword = form.elements['password'].value;
            var confirmPassword = form.elements['password_confirmation'].value;

            axios.put('/password/update/{{ \Illuminate\Support\Facades\Auth::user()->id }}', {
                oldPassword: oldPassword,
                password: newPassword,
                password_confirmation: confirmPassword
            })
                .then(function (response) {
                    toastr.success(response.data.message);
                    form.reset();
                })
                .catch(function (error) {
                    if (error.response && error.response.data && error.response.data.message) {
                        toastr.warning(error.response.data.message);
                    } else {
                        toastr.error('An error occurred while updating the password.');
                    }
                });
        }

        function resetForm() {
            var form = document.getElementById('passwordForm');
            form.reset();
        }
    </script>
@endsection
