@extends('layouts.admin.master')

@section('title')Branch 
    {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Branch</a></li>
        <li class="breadcrumb-item active">Edit</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="Branch_Edit" method="POST" action="{{ route('branch.update', $User->id) }}"
                            enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Edit Branch</h5>
                                </div>
                                <div class="card-body">

                                    @csrf
                                    @method('PATCH')

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="name">Branch Name <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="name" class="form-control" name="name"
                                                placeholder="Branch Name" value="{{ old('name',$User->name) }}" required />
                                            @error('name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="owner_name">Owner Name <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="owner_name" class="form-control" name="owner_name"
                                                placeholder="Name" value="{{ old('owner_name',$User->owner_name) }}" required />
                                            @error('owner_name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="email">Email </label>
                                        <div class="col-sm-9">
                                            <input type="email" id="email" class="form-control" name="email"
                                                placeholder="Email" value="{{ old('email',$User->email) }}" />
                                            @error('email')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="address">Address <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="address" class="form-control" name="address"
                                                placeholder="Address" value="{{ old('address',$User->address) }}" required />
                                            @error('address')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="mobile">Mobile <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="mobile" class="form-control" name="mobile"
                                                placeholder="Mobile" value="{{ old('mobile',$User->mobile) }}" required />
                                            @error('mobile')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
{{-- 
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="password">Password <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="number" id="password" class="form-control" name="password"
                                                placeholder="password" value="{{ old('password',$User->owner_name) }}" required />
                                            @error('password')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input name="confirm_password" id="confirm_password" class="form-control" placeholder="confirm password" required/>
                                            @error('confirm_password')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div> --}}

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
                $("#Branch_Edit").validate({
                    rules: {
                        mobile:{
                            number: true,
                            minlength: 10,
                            maxlength: 10
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
