@extends('layouts.admin.master')

@section('title') 
Staff
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('staff.index') }}">Staff</a></li>
        <li class="breadcrumb-item active">Edit</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="user_Edit" method="POST" action="{{ route('staff.update', $User->id) }}"
                            enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Edit Staff</h5>
                                </div>
                                <div class="card-body">

                                    @csrf
                                    @method('PATCH')

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="name">Name <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="name" class="form-control" name="name"
                                                placeholder="Name" value="{{ old('name', $User->name) }}" required />
                                            @error('name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="email">Email <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="email" id="email" class="form-control" name="email"
                                                placeholder="Email" value="{{ old('email', $User->email) }}" readonly required />
                                            @error('email')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="phone">Phone <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="number" id="phone" class="form-control" name="phone"
                                                placeholder="Phone" value="{{ old('phone', $User->phone) }}" required />
                                            @error('phone')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="address">Address <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <textarea name="address" id="address" class="form-control" placeholder="Address" required>{{ old('address', $User->address) }}</textarea>
                                            @error('address')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">User Role <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <select name="type" id="type" class="form-control" required>
                                                @foreach ($Role as $value)
                                                    <option value="{{ $value->id }}" {{ $User->type == $value->id ? "selected" : "" }}>{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('staff.index') }}" class="btn btn-secondary">Cancel</a>
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
                $("#user_Edit").validate({
                    rules: {
                        phone:{
                            maxlength: 10,
                            minlength: 10,
                            number: true,
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
            });
        </script>
    @endpush
@endsection
