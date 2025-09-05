@extends('Dashboard.master')

@section('title')
    Advisor Profile
@endsection

@section('css')

@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header py-3">
            <div class="card-title align-items-start flex-column">
                <h3 class="card-label font-weight-bolder text-dark">Personal Information</h3>
                <span class="text-muted font-weight-bold font-size-sm mt-1">Update your personal informaiton</span>
            </div>
            <div class="card-toolbar">
                <div class="card-toolbar" style="margin-left: 311px;">
                    <button type="button" class="btn btn-primary mr-2" onclick="submitForm()">Save Changes</button>
                    <button type="reset" class="btn btn-secondary" onclick="resetForm()">Reset</button>
                </div>
            </div>

        </div>

        <form id="personal-info-form" method="POST" action="{{ route('advisor-profile.save') }}" enctype="multipart/form-data">
            @csrf
        <div class="card-body">
            <div class="row">
                <label class="col-xl-3"></label>
                <div class="col-lg-9 col-xl-6">
                    <h5 class="font-weight-bold mb-6">Trainee Info</h5>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">Image</label>
                <div class="col-lg-9 col-xl-6">
                    <div class="image-input image-input-outline" id="kt_profile_avatar" style="background-image: url({{asset('admin/assets/media/users/blank2.png')}})">
                        <div class="image-input-wrapper" style="background-image: url({{ $advisor->image ? asset('images/' . $advisor->image) : asset('admin/assets/media/users/300_21.jpg') }})"></div>
                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                            <i class="fa fa-pen icon-sm text-muted"></i>
                            <input type="file" name="image" accept=".png, .jpg, .jpeg">
                            <input type="hidden" name="image">
                        </label>
                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="" data-original-title="Cancel avatar">
                <i class="ki ki-bold-close icon-xs text-muted"></i>
            </span>
                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="" data-original-title="Remove avatar">
                <i class="ki ki-bold-close icon-xs text-muted"></i>
            </span>
                    </div>
                    <span class="form-text text-muted">Allowed file types: png, jpg, jpeg.</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">First Name</label>
                <div class="col-lg-9 col-xl-6">
                    <input class="form-control form-control-lg form-control-solid" type="text"
                           value="{{ old('first_name', $advisor->first_name) }}" name="first_name" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">Last Name</label>
                <div class="col-lg-9 col-xl-6">
                    <input class="form-control form-control-lg form-control-solid" name="last_name" type="text" value="{{$advisor->last_name}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">Educational qualification</label>
                <div class="col-lg-9 col-xl-6">
                    <select name="education" id="education" class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6">
                        <option value="" selected="selected">Select Option</option>
                        <option value="High School" {{ $advisor->education === 'High School' ? 'selected' : '' }}>High School</option>
                        <option value="Diploma Degree" {{ $advisor->education === 'Diploma Degree' ? 'selected' : '' }}>Diploma degree</option>
                        <option value="Bachelor Degree" {{ $advisor->education === 'Bachelor Degree' ? 'selected' : '' }}>Bachelor's Degree</option>
                        <option value="Master Degree" {{ $advisor->education === 'Master Degree' ? 'selected' : '' }}>Master's Degree</option>
                        <option value="Doctoral Degree" {{ $advisor->education === 'Doctoral Degree' ? 'selected' : '' }}>Doctoral Degree</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">Specialization</label>
                <div class="col-lg-9 col-xl-6">
                    <select name="field[]"  multiple id="field" class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6">
                        @foreach($fields as $field)
                            <option value="{{ $field->id }}" {{ in_array($field->id, $advisor->fields->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $field->name }}</option>
                        @endforeach
                    </select>
                    <span class="form-text text-muted">previous Specialization not removed , contact manager if you want delete one </span>

                </div>
            </div>
            <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">Language</label>
                <div class="col-lg-9 col-xl-6">
                    <select name="language" id="language" class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6">
                        <option value="English" {{ $advisor->language == 'English' ? 'selected' : '' }}>English</option>
                        <option value="Arabic" {{ $advisor->language == 'Arabic' ? 'selected' : '' }}>Arabic</option>
                        <option value="French" {{ $advisor->language == 'French' ? 'selected' : '' }}>French</option>
                    </select>
                </div>
            </div>


            <div class="row">
                <label class="col-xl-3"></label>
                <div class="col-lg-9 col-xl-6">
                    <h5 class="font-weight-bold mt-10 mb-6">Contact Info</h5>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">Contact Phone</label>
                <div class="col-lg-9 col-xl-6">
                    <div class="input-group input-group-lg input-group-solid">
                        <div class="input-group-prepend">
																	<span class="input-group-text">
																		<i class="la la-phone"></i>
																	</span>
                        </div>
                        <input type="text" name="phone" class="form-control form-control-lg form-control-solid" value="{{$advisor->phone}}"
                               placeholder="Phone">
                    </div>
                    <span class="form-text text-muted">We'll never share your email with anyone else.</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
                <div class="col-lg-9 col-xl-6">
                    <div class="input-group input-group-lg input-group-solid">
                        <div class="input-group-prepend">
																	<span class="input-group-text">
																		<i class="la la-at"></i>
																	</span>
                        </div>
                        <input type="text" class="form-control form-control-lg form-control-solid"
                               value="{{$advisor->email}}" placeholder="Email" disabled>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">Address</label>
                <div class="col-lg-9 col-xl-6">
                    <div class="input-group input-group-lg input-group-solid">
                        <input type="text" name="address" class="form-control form-control-lg form-control-solid"
                               placeholder="Username" value="{{$advisor->address}}">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">City</label>
                <div class="col-lg-9 col-xl-6">
                    <div class="input-group input-group-lg input-group-solid">
                        <input type="text" name="city" class="form-control form-control-lg form-control-solid"
                               placeholder="Username" value="{{$advisor->city}}">
                    </div>
                </div>
            </div>


            <div class="row">
                <label class="col-xl-3"></label>
                <div class="col-lg-9 col-xl-6">
                    <h5 class="font-weight-bold mt-10 mb-6">Documents & files</h5>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">CV</label>
                <div class="col-lg-9 col-xl-6">
                    <div class="input-group input-group-lg ">
                        @if($advisor->cv)
                            <a href="{{ $advisor->cv}}" class="btn btn-primary" target="_blank"
                               rel="noopener noreferrer">Download CV</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">Certification</label>
                <div class="col-lg-9 col-xl-6">
                    <div class="input-group input-group-lg ">
                        @if($advisor->certification)
                            <a href="{{ $advisor->certification }}" class="btn btn-primary" target="_blank"
                               rel="noopener noreferrer">Download Certification</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">other file</label>
                <div class="col-lg-9 col-xl-6">
                    <div class="input-group input-group-lg">
                        @if(count($advisor->otherFile ?? []) > 0)
                            @foreach($advisor->otherFile as $otherFileUrl)
                                <a href="{{ $otherFileUrl }}" class="btn btn-primary" target="_blank"
                                   rel="noopener noreferrer">Related File</a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>

@endsection


@section('js')
    <script>
        function submitForm() {
            // Get the form element
            const form = document.getElementById('personal-info-form');

            // Submit the form
            form.submit();
        }

        function resetForm() {
            // Get the form element
            const form = document.getElementById('personal-info-form');

            // Reset the form
            form.reset();
        }
    </script>
    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/html.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>

    <!--begin::Page Scripts(used by this page)-->
    <script src="{{asset('admin/assets/js/pages/widgets.js')}}"></script>
    <script src="{{asset('admin/assets/js/pages/custom/profile/profile.js')}}"></script>
    <!--end::Page Scripts-->
@endsection
