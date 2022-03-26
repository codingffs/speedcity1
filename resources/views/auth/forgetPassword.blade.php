@extends('admin.authentication.custom_master')

@section('title')Reset Password
    {{ $title }}
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
            <div class="row align-items-center">                
                @includeIf('auth.login_sidebar')
                <div class="col-lg-5 offset-lg-1 col-md-5 ">
                    <div class="artisan-logo-1">
                        <img src="{{ url('setting/'.logoimage('logo')) }}" alt="" srcset="" class="img-fluid">
                    </div>
                    <div class="login-form frgt-form ">
                        <form class="theme-form" id="adminLoginFrm" method="POST"
                            action="{{ route('forget.password.post') }}">
                            @csrf
                            <h3 class="login-heading">Reset Password</h3>

                            @error('email')
                                <h6 class="text-danger">{{ $message }}</h6>
                            @enderror

                            @if (Session::has('success'))
                                <h6 class="text-success">{{ Session::get('success') }}</h6>
                            @endif

                            <div class="form-group">
                                <label for="email" class="label-bold">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                    required autocomplete="email" autofocus />
                            </div>
                            <div></div>

                            <div class="log-in-btn reset-btn">
                                <div class="row">
                                    <div class="col-lg-7 col-md-9 ">
                                        <button class="btn ">Send Password Reset Link</button>
                                    </div>
                                    
                                </div>
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
                    errorPlacement: function(error, element) {
                        if (element.attr("name") == "email") {
                            error.appendTo(element.parent("div").next("div"));
                        } else if (element.attr("name") == "password") {
                            error.appendTo(element.parent("div").next("div"));
                        } else {
                            error.insertAfter(element);
                        }
                    }
                });

                $(".show-hide").click(function(e) {
                    $("#password").prop("type", "text");
                });
            });
        </script>
    @endpush
@endsection
