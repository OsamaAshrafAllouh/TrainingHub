@extends('Dashboard.master')

@section('title')
    Edit Program
@endsection


@section('js')
    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/html.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>


    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        document.getElementById('field_id').addEventListener('change', function() {
            var fieldId = this.value;
            var advisorSelect = document.getElementById('advisor_id');
            advisorSelect.innerHTML = '<option value="">Select Advisor</option>'; // Clear previous options

            if (fieldId !== '') {
                // Send AJAX request to retrieve accepted advisors for the selected field
                axios.get('/get-advisors/' + fieldId)
                    .then(function(response) {
                        var advisors = response.data;

                        // Populate advisor select dropdown with retrieved data
                        advisors.forEach(function(advisor) {
                            var option = document.createElement('option');
                            option.value = advisor.id;
                            option.textContent = advisor.first_name + advisor.last_name ;
                            advisorSelect.appendChild(option);
                        });
                    })
                    .catch(function(error) {
                        console.error(error);
                    });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to be executed when the page is loaded
            console.log('Page loaded');

            // Your code here...
            // ...

            // Call the function or code that needs to be executed on page load
            togglePriceField();
            $("#msg").show().delay(7000).fadeOut();
            var avatar1 = new KTImageInput('kt_image_5');
        });

        function togglePriceField() {
            console.log('Function called');

            var typeSelect = document.getElementById('type');
            var priceField = document.getElementById('price');

            if (typeSelect.value === 'free') {
                priceField.disabled = true;
                priceField.value = ''; // Clear the value
            } else {
                priceField.disabled = false;
            }
        }
    </script>
    <script>
        $("#msg").show().delay(7000).fadeOut();
    </script>

    <script>
        var avatar1 = new KTImageInput('kt_image_5');
    </script>
@endsection


@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
				<span class="card-icon">
                    <i class="flaticon2-favourite text-primary"></i>
				</span>
                <h3 class="card-label">Edit Program</h3>
            </div>

        </div>
        <div class="card-body">
            <form id="Program-form" method="POST" action="{{ route('programs.update', $program->id) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <div class="col-lg-12">
                        <div style="text-align: center">

                            <div class="image-input image-input-empty image-input-outline" id="kt_image_5"
                                 style="background-image: url({{ $program->image ? asset('images/' . $program->image) : asset('admin/assets/media/users/blank2.jpg') }})">
                                <div class="image-input-wrapper"></div>
                                <label
                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                    data-action="change" data-toggle="tooltip" title=""
                                    data-original-title="Program Image">
                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg"/>
                                    <input type="hidden" name="image"/>
                                </label>
                                <span
                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                    data-action="cancel" data-toggle="tooltip" title="Remove Image">
															<i class="ki ki-bold-close icon-xs text-muted"></i>
														</span>
                                <span
                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                    data-action="remove" data-toggle="tooltip" title="Remove Program image">
															<i class="ki ki-bold-close icon-xs text-muted"></i>
														</span>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-group row py-4">
                    <div class="col-lg-6">
                        <label for="name">Program Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                               name="name" id="name" value="{{ old('name',$program->name) }}"
                               placeholder="Enter Program Name" required/>
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-6">
                        <label for="hours">Program Hours<span class="text-danger">*</span></label>
                        <input type="number" min="3" max="250"
                               class="form-control {{ $errors->has('hours') ? 'is-invalid' : '' }}"
                               name="hours" id="hours" required value="{{ old('hours', $program->hours) }}"
                               placeholder="Program Hours"/>
                        @if($errors->has('hours'))
                            <div class="invalid-feedback">
                                {{ $errors->first('hours') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group row py-4">
                    <div class="col-lg-6">
                        <label for="start_date">Start Date<span class="text-danger">*</span></label>
                        <input type="date" class="form-control {{ $errors->has('start_date') ? 'is-invalid' : '' }}"
                               name="start_date" id="start_date" value="{{ old('start_date', $program->start_date) }}"
                               placeholder="Enter Program Start Date" required/>
                        @if($errors->has('start_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('start_date') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-6">
                        <label for="end_date">End Date<span class="text-danger">*</span></label>
                        <input type="date" class="form-control {{ $errors->has('end_date') ? 'is-invalid' : '' }}"
                               name="end_date" id="end_date" value="{{ old('end_date', $program->end_date) }}"
                               placeholder="Enter Program End Date" required/>
                        @if($errors->has('end_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('end_date') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group row py-4">
                    <div class="col-xl-6">
                        <!--begin::Input-->
                        <div class="form-group">
                            <label>Program Level<span class="text-danger">*</span></label>
                            <select name="level" id="level" class="form-control" required>
                                <option value="">Select Option</option>
                                <option
                                    value="beginner" {{ old('level', $program->level) === 'beginner' ? 'selected' : '' }}>
                                    Beginner
                                </option>
                                <option
                                    value="intermediate" {{ old('level', $program->level) === 'intermediate' ? 'selected' : '' }}>
                                    Intermediate
                                </option>
                                <option
                                    value="advanced" {{ old('level', $program->level) === 'advanced' ? 'selected' : '' }}>
                                    Advanced
                                </option>
                            </select>
                            @if($errors->has('level'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('level') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <!--begin::Input-->
                        <div class="form-group">
                            <label>Program Type<span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-control" required  onchange="togglePriceField()">
                                <option value="">Select Option</option>
                                <option value="paid" {{ old('type', $program->type) === 'paid' ? 'selected' : '' }}>
                                    Paid
                                </option>
                                <option value="free" {{ old('type', $program->type) === 'free' ? 'selected' : '' }}>
                                    Free
                                </option>
                            </select>
                            @if($errors->has('type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('type') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group row py-4">
                    <div class="col-lg-6">
                        <label for="price">Price<span class="text-danger">*</span></label>
                        <input type="number" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                               name="price" id="price" value="{{ old('price', $program->price) }}"
                               placeholder="Enter Program Price" required/>
                        @if($errors->has('price'))
                            <div class="invalid-feedback">
                                {{ $errors->first('price') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-6">
                        <label for="number">Number of Participants<span class="text-danger">*</span></label>
                        <input type="number" min="3" max="250"
                               class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}"
                               name="number" id="number" required value="{{ old('number', $program->number) }}"
                               placeholder="Number Of Participants"/>
                        @if($errors->has('number'))
                            <div class="invalid-feedback">
                                {{ $errors->first('number') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group row py-4">
                    <div class="col-xl-6">
                        <!--begin::Input-->
                        <div class="form-group">
                            <label>Program Duration<span class="text-danger">*</span></label>
                            <select id="duration" name="duration" class="form-control" required>
                                <option value="days" {{ old('duration',$program->duration) === 'days' ? 'selected' : '' }}>Days</option>
                                <option value="weeks" {{ old('duration',$program->duration) === 'weeks' ? 'selected' : '' }}>Weeks</option>
                                <option value="months" {{ old('duration',$program->duration) === 'months' ? 'selected' : '' }}>Months
                                </option>
                                <option value="years" {{ old('duration',$program->duration) === 'years' ? 'selected' : '' }}>Years</option>
                            </select>
                            @if($errors->has('duration'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('duration') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <!--begin::Input-->
                        <div class="form-group">
                            <label>Program Language<span class="text-danger">*</span></label>
                            <select name="language" id="language" class="form-control" required>
                                <option value="">Select a Language</option>
                                <option value="English" {{ old('language',$program->language) === 'English' ? 'selected' : '' }}>English
                                </option>
                                <option value="Arabic" {{ old('language',$program->language) === 'Arabic' ? 'selected' : '' }}>Arabic
                                </option>
                                <option value="French" {{ old('language',$program->language) === 'French' ? 'selected' : '' }}>French
                                </option>
                            </select>
                            @if($errors->has('language'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('language') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-xl-6">
                        <!--begin::Input-->
                        <div class="form-group">
                            <label>Program Field<span class="text-danger">*</span></label>
                            <select required name="field_id" id="field_id" class="form-control">
                                <option value="">Select Option</option>
                                @foreach($fields as $field)
                                    <option
                                        value="{{ $field->id }}" {{ old('field_id',$program->field_id) == $field->id ? 'selected' : '' }}>
                                        {{ $field->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if($errors->has('field_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('field_id') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <!--begin::Input-->
                        <div class="form-group">
                            <label>Program Advisor<span class="text-danger">*</span></label>
                            <select required name="advisor_id" id="advisor_id" class="form-control">
                                <option value="">Select Advisor</option>
                                <option value="{{ $advisor->id }}" selected >
                                    {{ $advisor->first_name }}
                                </option>
                            </select>
                            @if($errors->has('advisor_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('advisor_id') }}
                                </div>
                            @endif
                        </div>
                    </div>


                </div>

                <div class="form-group row pt-4">
                    <div class="col-lg-12">
                        <label>Program Description</label>
                        <textarea name="description" class="textarea form-control "
                                  style="height: 150px"
                                  value="{{ old('description', $program->description) }}">{{ old('description', $program->description) }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-12">
                        <!-- Save Program button -->
                        <button type="submit" class="btn btn-sm btn-light-primary er fs-6 px-8 py-4">
                            <i class="la la-save"></i> Save Program
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
@endsection

