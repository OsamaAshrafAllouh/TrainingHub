<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->
<head>
    <title>Advisor Sign Up </title>
    @include('Dashboard.css')

</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body"
      class="header-mobile-fixed subheader-enabled aside-enabled aside-fixed aside-secondary-enabled page-loading">
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-3 wizard d-flex flex-column flex-lg-row flex-column-fluid wizard" id="kt_login">
        <!--begin::Aside-->
        <div class="login-aside d-flex flex-column flex-row-auto">
            <!--begin::Aside Top-->
            <div class="d-flex flex-column-auto flex-column pt-5 px-30">
                <!--begin::Aside header-->
                <a href="#" class="login-logo py-6">
                    <img src="{{asset('admin/assets/media/logos/logoo.png')}}" class="max-h-70px" alt=""/>
                </a>
                <!--end::Aside header-->
                <!--begin: Wizard Nav-->
                <div class="wizard-nav pt-5 pt-lg-10">
                    <!--begin::Wizard Steps-->
                    <div class="wizard-steps">
                        <!--begin::Wizard Step 1 Nav-->
                        <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                            <div class="wizard-wrapper">
                                <div class="wizard-icon">
                                    <i class="wizard-check ki ki-check"></i>
                                    <span class="wizard-number">1</span>
                                </div>
                                <div class="wizard-label">
                                    <h3 class="wizard-title">Personal Information</h3>
                                    <div class="wizard-desc">Setup Your Account Details</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Wizard Step 1 Nav-->
                        <!--begin::Wizard Step 2 Nav-->
                        <div class="wizard-step" data-wizard-type="step">
                            <div class="wizard-wrapper">
                                <div class="wizard-icon">
                                    <i class="wizard-check ki ki-check"></i>
                                    <span class="wizard-number">2</span>
                                </div>
                                <div class="wizard-label">
                                    <h3 class="wizard-title">Other Details</h3>
                                    <div class="wizard-desc">some other Information</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Wizard Step 2 Nav-->
                        <!--begin::Wizard Step 3 Nav-->
                        <div class="wizard-step" data-wizard-type="step">
                            <div class="wizard-wrapper">
                                <div class="wizard-icon">
                                    <i class="wizard-check ki ki-check"></i>
                                    <span class="wizard-number">3</span>
                                </div>
                                <div class="wizard-label">
                                    <h3 class="wizard-title">Files & Documentations</h3>
                                    <div class="wizard-desc">some attachments</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Wizard Step 3 Nav-->
                        <!--begin::Wizard Step 4 Nav-->
                        <div class="wizard-step" data-wizard-type="step">
                            <div class="wizard-wrapper">
                                <div class="wizard-icon">
                                    <i class="wizard-check ki ki-check"></i>
                                    <span class="wizard-number">4</span>
                                </div>
                                <div class="wizard-label">
                                    <h3 class="wizard-title">Completed!</h3>
                                    <div class="wizard-desc">Review and Submit</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Wizard Step 4 Nav-->
                    </div>
                    <!--end::Wizard Steps-->
                </div>
                <!--end: Wizard Nav-->
            </div>
            <!--end::Aside Top-->
            <!--begin::Aside Bottom-->
            <div
                class="aside-img-wizard d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center pt-2 pt-lg-5"
                style="background-position-y: calc(100% + 3rem); background-image: url({{asset('admin/assets/media/svg/illustrations/Register.jpg')}})"></div>
            <!--end::Aside Bottom-->
        </div>
        <!--begin::Aside-->
        <!--begin::Content-->
        <div class="login-content flex-column-fluid d-flex flex-column p-10">
            <!--begin::Top-->
            <div class="text-right d-flex justify-content-center">
                <div class="top-signup text-right d-flex justify-content-end pt-5 pb-lg-0 pb-10">
                    <div class="text-muted font-weight-bold font-size-h4">Create Trainee Account?
                        <a href="{{route('trainees.create')}}"
                           class="text-primary font-weight-bolder">Sign UP</a></div>
                </div>
            </div>
            <!--end::Top-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-row-fluid flex-center">
                <!--begin::Signin-->
                <div class="login-form login-form-signup">
                    <!--begin::Form-->
                    <form class="form" action="{{route('advisors.store')}}" method="POST"
                          id="kt_login_signup_form1" enctype="multipart/form-data">
                        @csrf
                        <!--begin: Wizard Step 1-->
                        <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                            <!--begin::Title-->
                            <div class="pb-10 pb-lg-15">
                                <h3 class="font-weight-bolder text-dark display5">Create Advisor Account</h3>

                                <div class="text-muted font-weight-bold font-size-h4">Already have an Account ?
                                    <a href="{{route('login')}}"
                                       class="text-primary font-weight-bolder">Sign In</a></div>
                            </div>
                            <!--begin::Title-->
                            <!--begin::Form Group-->
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">First Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                               name="first_name" id="first_name" placeholder="First Name"
                                               value="{{old('first_name', '')}}"/>
                                    </div>
                                </div>
                                <!--end::Form Group-->
                                <!--begin::Form Group-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">Last Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                               name="last_name" id="last_name" placeholder="Last Name"
                                               value="{{old('last_name', '')}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">Email <span
                                        class="text-danger">*</span></label>
                                <input type="email"
                                       class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                       name="email" id="email" placeholder="Email" value="{{old('email', '')}}"/>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">Phone<span
                                                class="text-danger">*</span></label>
                                        <input type="tel"
                                               class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                               name="phone" id="phone" placeholder="phone"
                                               value="{{old('phone', '')}}"/>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">Educational
                                            qualification <span class="text-danger">*</span></label>
                                        <select name="education" id="education"
                                                class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6">
                                            <option value="" selected="selected">Select Option</option>
                                            <option value="High School">High School</option>
                                            <option value="Diploma Degree">Diploma degree</option>
                                            <option value="Bachelor Degree">Bachelor's Degree</option>
                                            <option value="Master Degree">Master's Degree</option>
                                            <option value="Doctoral Degree">Doctoral Degree</option>
                                        </select>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <!--begin::Input-->
                                <div class="form-group">
                                    <label class="font-size-h6 font-weight-bolder text-dark">Specialization</label>

                                    <select name="field[]" multiple id="field"
                                            class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6">
                                        @foreach($fields as $field)
                                            <option value="{{ $field->id }}">{{ $field->name }}</option>
                                        @endforeach
                                    </select>


                                </div>
                                <!--end::Input-->
                            </div>


                            <!--end::Form Group-->
                        </div>
                        <!--end: Wizard Step 1-->
                        <!--begin: Wizard Step 2-->
                        <div class="pb-5" data-wizard-type="step-content">
                            <!--begin::Title-->
                            <div class="pt-lg-0 pt-5 pb-15">
                                <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Other Details</h3>
                            </div>
                            <!--begin::Title-->
                            <!--begin::Row-->
                            <div class="row">
                                <div class="col-xl-6">
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">Address Line <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                               name="address" id="address" placeholder="Address Line"/>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <div class="col-xl-6">
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">City <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                               name="city" id="city" placeholder="Enter Your city"/>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>

                            <!--end::Form Group-->
                            <!--begin::Form Group-->
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">Preferred Language: </label>
                                <select name="language" id="language"
                                        class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6">
                                    <option value="English" selected="selected">Select a language Type Option</option>
                                    <option value="English">English</option>
                                    <option value="Arabic">Arabic</option>
                                    <option value="French">French</option>
                                </select>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->

                        </div>
                        <!--end: Wizard Step 2-->
                        <!--begin: Wizard Step 3-->
                        <div class="pb-5" data-wizard-type="step-content">

                            <div class="pt-lg-0 pt-5 pb-15">
                                <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Files &
                                    Documentations</h3>
                                <div class="text-muted font-weight-bold font-size-h4">Information
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">CV Or Resume<span
                                        class="text-danger">*</span></label>
                                <input type="file" accept=".pdf,.docx"
                                       class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                       name="cv" id="cv" placeholder="cv" value="{{old('cv', '')}}"/>
                            </div>


                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">Certification<span
                                        class="text-danger">*</span></label>
                                <input type="file" accept=".pdf,.docx,.jpeg,.jpg,.png,.doc"
                                       class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                       name="certification" id="certification" placeholder="certification"
                                       value="{{old('certification', '')}}"/>
                            </div>

                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">Other Filess</label>
                                <input type="file"
                                       class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6"
                                       name="otherFile[]" multiple id="otherFile" placeholder="Other File"
                                       value="{{old('otherFile', '')}}"/>
                            </div>
                        </div>

                        <!--end: Wizard Step 3-->
                        <!--begin: Wizard Step 4-->
                        <div class="pb-5" data-wizard-type="step-content">
                            <!--begin::Title-->
                            <div class="pt-lg-0 pt-5 pb-15">
                                <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Complete</h3>
                                <div class="text-muted font-weight-bold font-size-h4">Complete Your Signup And Become A
                                    Member!
                                </div>
                            </div>
                            <!--end::Title-->
                            <!--begin::Section-->
                            <h4 class="font-weight-bolder mb-3">Personal Information</h4>
                            <div class="text-dark-50 font-weight-bold line-height-lg mb-8">
                                <div id="first_name_output"></div>
                                <div id="last_name_output"></div>
                                <div id="phone_output"></div>
                                <div id="email_output"></div>
                                <div id="education_output"></div>
                                <div id="field_output"></div>
                            </div>
                            <!--end::Section-->
                            <!--begin::Section-->
                            <h4 class="font-weight-bolder mb-3">Other Details</h4>
                            <div class="text-dark-50 font-weight-bold line-height-lg mb-8">
                                <div id="address_output"></div>
                                <div id="city_output"></div>
                                <div id="payment_output"></div>
                                <div id="language_output"></div>
                            </div>
                            <!--end::Section-->
                            <!--begin::Section-->
                            <!--end::Section-->
                        </div>
                        <!--end: Wizard Step 4-->
                        <!--begin: Wizard Actions-->
                        <div class="d-flex justify-content-between pt-3">
                            <div class="mr-2">
                                <button type="button"
                                        class="btn btn-light-primary font-weight-bolder font-size-h6 pl-6 pr-8 py-4 my-3 mr-3"
                                        data-wizard-type="action-prev">
										<span class="svg-icon svg-icon-md mr-1">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Left-2.svg-->
											<svg xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                 viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<polygon points="0 0 24 0 24 24 0 24"/>
													<rect fill="#000000" opacity="0.3"
                                                          transform="translate(15.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-15.000000, -12.000000)"
                                                          x="14" y="7" width="2" height="10" rx="1"/>
													<path
                                                        d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z"
                                                        fill="#000000" fill-rule="nonzero"
                                                        transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997)"/>
												</g>
											</svg>
                                            <!--end::Svg Icon-->
										</span>Previous
                                </button>
                            </div>
                            <div>
                                <button type="submit"
                                        class="btn btn-primary font-weight-bolder font-size-h6 pl-5 pr-8 py-4 my-3"
                                        data-wizard-type="action-submit"
                                        id="kt_login_singin_form_submit_button">Submit
                                    <span class="svg-icon svg-icon-md ml-2">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Right-2.svg-->
											<svg xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                 viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<polygon points="0 0 24 0 24 24 0 24"/>
													<rect fill="#000000" opacity="0.3"
                                                          transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)"
                                                          x="7.5" y="7.5" width="2" height="9" rx="1"/>
													<path
                                                        d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                                        fill="#000000" fill-rule="nonzero"
                                                        transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)"/>
												</g>
											</svg>
                                        <!--end::Svg Icon-->
										</span></button>
                                <button type="button"
                                        class="btn btn-primary font-weight-bolder font-size-h6 pl-8 pr-4 py-4 my-3"
                                        data-wizard-type="action-next">Next Step
                                    <span class="svg-icon svg-icon-md ml-1">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Right-2.svg-->
											<svg xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                 viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<polygon points="0 0 24 0 24 24 0 24"/>
													<rect fill="#000000" opacity="0.3"
                                                          transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)"
                                                          x="7.5" y="7.5" width="2" height="9" rx="1"/>
													<path
                                                        d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                                        fill="#000000" fill-rule="nonzero"
                                                        transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)"/>
												</g>
											</svg>
                                        <!--end::Svg Icon-->
										</span></button>
                            </div>
                        </div>
                        <!--end: Wizard Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Signin-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Login-->
</div>
<script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
<!--begin::Global Config(global config for global JS scripts)-->
<script>var KTAppSettings = {
        "breakpoints": {"sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200},
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#1BC5BD",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#6993FF",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#F3F6F9",
                    "dark": "#212121"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#1BC5BD",
                    "secondary": "#ECF0F3",
                    "success": "#C9F7F5",
                    "info": "#E1E9FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#212121",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#ECF0F3",
                "gray-300": "#E5EAEE",
                "gray-400": "#D6D6E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#80808F",
                "gray-700": "#464E5F",
                "gray-800": "#1B283F",
                "gray-900": "#212121"
            }
        },
        "font-family": "Poppins"
    };</script>
<script>
    const firstNameInput = document.getElementById('first_name');
    const lastNameInput = document.getElementById('last_name');
    const phoneInput = document.getElementById('phone');
    const emailInput = document.getElementById('email');


    const educationSelect = document.querySelector('select[name="education"]');
    const educationDiv = document.querySelector('#education_output');

    const addressInput = document.getElementById('address');
    const cityInput = document.getElementById('city');
    const languageSelect = document.querySelector('select[name="language"]');
    const languageDiv = document.querySelector('#language_output');

    // Get output elements
    const firstNameOutput = document.getElementById('first_name_output');
    const lastNameOutput = document.getElementById('last_name_output');
    const phoneOutput = document.getElementById('phone_output');
    const emailOutput = document.getElementById('email_output');
    const addressOutput = document.getElementById('address_output');
    const cityOutput = document.getElementById('city_output');


    // Add event listeners to form input elements
    firstNameInput.addEventListener('input', updateFirstName);
    lastNameInput.addEventListener('input', updateLastName);
    phoneInput.addEventListener('input', updatePhone);
    emailInput.addEventListener('input', updateEmail);
    addressInput.addEventListener('input', updateAddress);
    cityInput.addEventListener('input', updateCity);


    // Define event listener functions
    function updateFirstName() {
        firstNameOutput.textContent = 'First Name : ' + firstNameInput.value;
    }

    function updateLastName() {
        lastNameOutput.textContent = 'Last Name : ' + lastNameInput.value;
    }

    function updatePhone() {
        phoneOutput.textContent = 'Phone : ' + phoneInput.value;
    }

    function updateEmail() {
        emailOutput.textContent = 'Email : ' + emailInput.value;
    }

    function updateAddress() {
        addressOutput.textContent = 'Address : ' + addressInput.value;
    }

    function updateCity() {
        cityOutput.textContent = 'City : ' + cityInput.value;
    }

    educationSelect.addEventListener('change', () => {
        educationDiv.textContent = 'Educational Qualification : ' + educationSelect.value;
    });

    languageSelect.addEventListener('change', () => {
        languageDiv.textContent = 'Preferred Language : ' + languageSelect.value;
    });


</script>

@include('Dashboard.js')
<script src="{{asset('admin/assets/js/pages/custom/login/singup.js')}}"></script>
<!--end::Page Scripts-->
</body>
<!--end::Body-->
</html>
