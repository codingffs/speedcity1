@extends('layouts.admin.master')

@section('title')Profile
    {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item active">Edit Profile</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="permission_Create" method="POST"
                            action="{{ route('update_profile') }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Edit Profile</h5>
                                </div>
                                <div class="card-body">

                                    @csrf

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="name">Name <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="name" class="form-control" name="name"
                                                placeholder="Name" value="{{ old('name', auth()->user()->name) }}"
                                                required />
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="email">Email <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="email" id="email" class="form-control" name="email"
                                                placeholder="Email" value="{{ old('name', auth()->user()->email) }}"
                                                required />
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="name">Phone <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="number" id="phone" class="form-control" name="phone"
                                                placeholder="Phone" value="{{ old('phone', auth()->user()->phone) }}"
                                                required />
                                            @error('phone')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="address">Address <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <textarea id="address" class="form-control" name="address"
                                                placeholder="Address"
                                                required>{{ old('address', auth()->user()->address) }}</textarea>
                                            @error('address')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    @if (auth()->user()->type == '2')
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label" for="about_supplier">About Supplier <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <textarea id="about_supplier" class="form-control" name="about_supplier"
                                                    placeholder="About Supplier"
                                                    required>{{ old('about_supplier', auth()->user()->about_supplier) }}</textarea>
                                                @error('about_supplier')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif

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
