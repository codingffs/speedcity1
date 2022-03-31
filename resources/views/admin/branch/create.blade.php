@extends('layouts.admin.master')

@section('title')Branches 
    {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('branch.index') }}">Branches</a></li>
        <li class="breadcrumb-item active">Create</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="branch_Create" method="POST" action="{{ route('branch.store') }}"
                            enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Create Branch</h5>
                                </div>
                                <div class="card-body">

                                    @csrf
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="name">Branch Name <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="name" class="form-control" name="name"
                                                placeholder="Branch Name" value="{{ old('name') }}" required />
                                            @error('name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="owner_name">Owner Name <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="owner_name" class="form-control" name="owner_name"
                                                placeholder="Name" value="{{ old('owner_name') }}" required />
                                            @error('owner_name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="email">Email </label>
                                        <div class="col-sm-9">
                                            <input type="email" id="email" class="form-control" name="email"
                                                placeholder="Email" value="{{ old('email') }}" />
                                            @error('email')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="address">Address <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="address" class="form-control" name="address"
                                                placeholder="Address" value="{{ old('address') }}" required />
                                            @error('address')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="mobile">Mobile <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="mobile" class="form-control" name="mobile"
                                                placeholder="Mobile" value="{{ old('mobile') }}" required />
                                            @error('mobile')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="password">Password <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="password" id="password" class="form-control" name="password"
                                                placeholder="password" value="{{ old('password') }}" required />
                                            @error('password')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="confirm password" required/>
                                            @error('confirm_password')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('branch.index') }}" class="btn btn-secondary">Cancel</a>
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
                $("#branch_Create").validate({ 
                    rules: {
                        password:{
                            minlength: 6
                        },
                        confirm_password:{
                            minlength: 6,
                            equalTo: "#password",
                            return: true,
                        },
                        mobile:{
                            number: true,
                            minlength: 10,
                            maxlength: 10
                        },
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
