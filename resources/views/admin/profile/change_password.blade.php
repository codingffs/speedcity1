@extends('layouts.admin.master')

@section('title')Change Password
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item active">Change Password</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="permission_Create" method="POST"
                            action="{{ route('change_password_post') }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Change Password</h5>
                                </div>
                                <div class="card-body">

                                    @csrf

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="current_password">Current Password <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="password" id="current_password" class="form-control" name="current_password"
                                                placeholder="Current Password" required />
                                            @error('current_password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="new_password">New Password <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="password" id="new_password" class="form-control" name="new_password"
                                                placeholder="New Password" required />
                                            @error('new_password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="new_confirm_password">New Current Password <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="password" id="new_confirm_password" class="form-control" name="new_confirm_password"
                                                placeholder="New Current Password" required />
                                            @error('new_confirm_password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $("#permission_Create").validate({
                    rules: {
                        new_confirm_password: {
                            required: true,
                            equalTo: "#new_password"
                        },
                    },
                    errorPlacement: function(error, element) {
                        if (element.attr("name") == "discount_type") {
                            error.appendTo(element.parent("div").parent("div").parent('div'));
                        } else {
                            error.insertAfter(element);
                        }
                    }
                });

                flatpickr('.flatpickr', {
                    dateFormat: "d-m-Y",
                });
            });
        </script>
    @endpush
@endsection
