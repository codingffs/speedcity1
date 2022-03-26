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
                
                @includeIf('auth.login_sidebar');

                <div class="col-md-5 offset-md-1">
                    <div class="login-form">
                        <form class="theme-form login-form" id="adminLoginFrm" method="POST"
                            action="{{ route('reset.password.post') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">
                            <h3 class="login-heading">Reset Password</h3>

                            @if (Session::has('error'))
                                <h6 class="text-danger">{{ Session::get('error') }}</h6>
                            @endif

                            <div class="form-group">
                                <label for="password" class="label-bold">Password</label>
                                <input type="password" id="password" class="form-control" name="password" required />
                                @if ($errors->has('password'))
                                    <p class="text-danger">{{ $errors->first('password') }}</p>
                                @endif
                            </div>
                            <div></div>

                            <div class="form-group">
                                <label for="password-confirm" class="label-bold">Confirm Password</label>
                                <input type="password" id="password-confirm" class="form-control"
                                    name="password_confirmation" required />
                                @if ($errors->has('password_confirmation'))
                                    <p class="text-danger">{{ $errors->first('password_confirmation') }}</p>
                                @endif
                            </div>
                            <div></div>

                            <div class="log-in-btn">
                                <button class="btn">Reset Password</button>
                            </div>
                        </form>
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
                        } else if (element.attr("name") == "password_confirmation") {
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
