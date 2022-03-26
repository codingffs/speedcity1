@extends('admin.authentication.custom_master')

@section('title')Register
@endsection
@section('styles')

    <style>
        label.error {
            color: red !important;
        }

        .error {
            margin: 0px !important;
        }

    </style>
@endsection
@section('content')
    <div class="container-fluid p-0">
        <div class="login-page">
            <div class="row">

                @includeIf('auth.login_sidebar')

                <div class="col-lg-5 offset-lg-1 col-md-5 ">
                    <div class="artisan-logo-1 register-logo">
                        <img src="{{ url('setting/'.logoimage('logo')) }}" alt="" srcset="" class="img-fluid">
                    </div>
                    <div class="login-form register-form">
                        <form class="theme-form  " id="adminLoginFrm" method="POST"
                            action="{{ route('register_submit') }}">
                            @csrf

                            <h3 class="login-heading">Register</h3>

                            @error('email')
                                <h6 class="text-danger">{{ $message }}</h6>
                            @enderror

                            @if (Session::has('success'))
                                <h6 class="text-success">{{ Session::get('success') }}</h6>
                            @endif
                            @if (Session::has('error'))
                                <h6 class="text-danger">{{ Session::get('error') }}</h6>
                            @endif

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="email" autofocus
                                            maxlength="25">
                                    </div>
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label for="email" class="label-bold">Email <span
                                                class="text-danger">*</span></label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" maxlength="60">
                                    </div>
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mobile No <span class="text-danger">*</span> </label>
                                        <input id="mobile_no" type="number"
                                            class="form-control @error('mobile_no') is-invalid @enderror" name="mobile_no"
                                            value="{{ old('mobile_no') }}" required autocomplete="mobile_no">
                                    </div>
                                    @error('mobile_no')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone </label>
                                        <input id="phone" type="number"
                                            class="form-control @error('phone') is-invalid @enderror" name="phone"
                                            value="{{ old('phone') }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>GST Registered <span class="text-danger">*</span> </label>
                                        <br>
                                        <label for="gst_registered_yes">
                                            <input id="gst_registered_yes" type="radio" name="gst_registered"
                                                value="{{ old('gst_registered', 'Yes') }}"
                                                {{ old('gst_registered') == 'Yes' ? 'checked' : '' }} checked required>
                                            Yes
                                        </label>
                                        <label for="gst_registered_no">
                                            <input id="gst_registered_no" type="radio" name="gst_registered"
                                                value="{{ old('gst_registered', 'No') }}"
                                                {{ old('gst_registered') == 'No' ? 'checked' : '' }} required> No
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Trading Name <span class="text-danger">*</span> </label>
                                        <input id="trading_name" type="text"
                                            class="form-control @error('trading_name') is-invalid @enderror"
                                            name="trading_name" value="{{ old('trading_name') }}" required>
                                    </div>
                                    @error('trading_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Bank Account Name <span class="text-danger">*</span> </label>
                                        <input id="bank_account_name" type="text"
                                            class="form-control @error('bank_account_name') is-invalid @enderror"
                                            name="bank_account_name" value="{{ old('bank_account_name') }}" required>
                                    </div>
                                    @error('bank_account_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>BSB <span class="text-danger">*</span> </label>
                                        <input id="bsb" type="text" class="form-control @error('bsb') is-invalid @enderror"
                                            name="bsb" value="{{ old('bsb') }}" required>
                                    </div>
                                    @error('bsb')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Account No <span class="text-danger">*</span> </label>
                                        <input id="account_no" type="text"
                                            class="form-control @error('account_no') is-invalid @enderror" name="account_no"
                                            value="{{ old('account_no') }}" required>
                                    </div>
                                    @error('account_no')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mailing Address <span class="text-danger">*</span> </label>
                                        <input id="mailing_address" type="text"
                                            class="form-control @error('mailing_address') is-invalid @enderror"
                                            name="mailing_address" value="{{ old('mailing_address') }}" required>
                                    </div>
                                    @error('mailing_address')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="permission_to_use_images_on_internet"><input type="checkbox"
                                                id="permission_to_use_images_on_internet" value="1"> Permission to use
                                            images on
                                            internet</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password" class="label-bold">Password <span
                                                class="text-danger">*</span></label>
                                        <input type="password" id="password" class="form-control" name="password"
                                            minlength="8" required />
                                        <button type="button" id="btnToggle" class="toggle">
                                            <i id="eyeIcon" class="fa fa-eye eye"></i></button>
                                    </div>

                                    @error('password')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="confirm_password" class="label-bold">Confirm Password <span
                                                class="text-danger">*</span></label>
                                        <input type="password" id="confirm_password" class="form-control"
                                            name="confirm_password" required />
                                        <button type="button" id="btnToggle2" class="toggle">
                                            <i id="eyeIcon" class="fa fa-eye eye"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="log-in-btn">
                                <button class="btn">Register</button>
                            </div>
                        </form>
                        <div class="sign-up register-sign-up">
                            <span>Already have an account ?</span><a href="{{ route('login') }}"
                                class="text-decoration-none sign-up-a">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $("#adminLoginFrm").validate({
                    rules: {
                        email: {
                            maxlength: 90,
                            remote: {
                                type: 'get',
                                url: '{{ route('check_email_exists_in_users') }}',
                                data: {
                                    'email': function() {
                                        return $("#email").val();
                                    }
                                },
                                dataFilter: function(data) {
                                    var json = JSON.parse(data);
                                    if (json.status == 0) {
                                        return "\"" + json.message + "\"";
                                    } else {
                                        return 'true';
                                    }
                                }
                            }
                        },
                        mobile_no: {
                            required: true,
                            number: true,
                            minlength: 10,
                            maxlength: 10
                        },
                        confirm_password: {
                            required: true,
                            equalTo: "#password"
                        },
                    },
                    messages: {
                        email: {
                            remote: "Email already in use!"
                        },
                    },
                    errorPlacement: function(error, element) {
                        if (element.attr("name") == "email22") {
                            error.appendTo(element.parent("div").next("div"));
                        } else {
                            error.insertAfter(element);
                        }
                    }
                });

                $("#btnToggle").click(function(e) {
                    var type = $("#password").attr("type");
                    if (type == "password") {
                        $("#password").prop("type", "text");
                    } else {
                        $("#password").prop("type", "password");
                    }
                });

                $("#btnToggle2").click(function(e) {
                    var type = $("#confirm_password").attr("type");
                    if (type == "password") {
                        $("#confirm_password").prop("type", "text");
                    } else {
                        $("#confirm_password").prop("type", "password");
                    }
                });

            });
        </script>
    @endpush
@endsection
