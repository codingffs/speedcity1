@extends('admin.authentication.master')

@section('title')Sign Up
    {{ $title }}
@endsection
@push('css')
    <style>
        label.error {
            color: red !important;
        }

        .error {
            margin: 0px !important;
        }
    </style>
@endpush
@section('content')
    <section>
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <div class="login-card">
                        <form class="theme-form login-form" id="adminLoginFrm" method="POST"
                            action="{{ route('register_submit') }}">
                            @csrf
                            
                            <h4>Sign Up</h4>

                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" required autocomplete="email" autofocus data-error="name_error">
                                </div>
                                <div class="name_error"></div>
                            </div>

                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span> </label>
                                <div class="input-group">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus data-error="email_error">
                                </div>
                                <div class="email_error"></div>
                            </div>

                            <div class="form-group">
                                <label>Phone <span class="text-danger">*</span> </label>
                                <div class="input-group">
                                    <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus data-error="phone_error">
                                </div>
                                <div class="phone_error"></div>
                            </div>

                            <div class="form-group">
                                <label>Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required data-error="password_error">
                                    <div class="show-hide"><span class="show"> </span></div>
                                    @error('password')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="password_error"></div>
                            </div>
                            <div class="form-group">
                                @if (Route::has('password.request'))
                                    <a class="link" href="{{ route('password.request') }}">Forgot password?</a>
                                @endif
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $("#adminLoginFrm").validate({
                    errorPlacement: function(error, element) {
                        var attr = element.attr('data-error');
                        if (typeof attr !== 'undefined' && attr !== false) {
                            error.appendTo($("." + attr));
                        } else {
                            error.insertAfter(element);
                        }
                    }
                });

                $(".show-hide").click(function (e) { 
                    $("#password").prop("type", "text");      
                });
            });
        </script>
    @endpush
@endsection
