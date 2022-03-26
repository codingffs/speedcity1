@extends('admin.authentication.custom_master')

@section('title')Login
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
                    <div class="login-form">
                        <form class="theme-form login-form" id="adminLoginFrm" method="POST" action="{{ route('login_submit') }}">
                            @csrf
                            <h3 class="login-heading">Login</h3>
                            @error('email')
                                <h6 class="text-danger">{{ $message }}</h6>
                            @enderror
                            @if (Session::has('success'))
                                <h6 class="text-success">{{ Session::get('success') }}</h6>
                            @endif
                            @if (Session::has('error'))
                                <h6 class="text-danger">{{ Session::get('error') }}</h6>
                            @endif

                            <div class="form-group">
                                <label for="email" class="label-bold">Admin Login</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                    required autocomplete="email" autofocus />
                            </div>
                            <div></div>

                            <div class="form-group">
                                <label for="password" class="label-bold">Password</label>
                                <input type="password" id="password" class="form-control" name="password" required />
                                <button type="button" id="btnToggle" class="toggle">
                                    <i id="eyeIcon" class="fa fa-eye eye"></i></button>
                            </div>
                            <div></div>
                            @error('password')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            <div class="main-forgot">
                                <div class="row align-items-center">
                                    <div class="col-md-12 text-center">
                                        <div class="frgt-pwd">
                                            <a href="{{ route('forget.password.get') }}" class="frgt-pwd-inline text-decoration-none">Forgot Password?</a>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="log-in-btn">
                                <button class="btn">Login</button>
                            </div>
                        </form>
                        {{-- <div class="sign-up ">
                            <span>Create new account ?</span><a href="{{ route('register') }}" class="text-decoration-none sign-up-a">Sign
                                up</a>
                        </div> --}}
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

                $("#btnToggle").click(function(e) {
                    var type = $("#password").attr("type");
                    if (type == "password") {
                        $("#password").prop("type", "text");
                    } else {
                        $("#password").prop("type", "password");
                    }
                });
            });
        </script>
    @endpush
@endsection