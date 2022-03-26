@extends('layouts.admin.master')

@section('title')Supplier
    {{ $title }}
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('suppliers') }}">Supplier</a></li>
        <li class="breadcrumb-item active">Edit</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="suppliers_Edit" method="POST"
                            action="{{ route('suppliers.update', $Supplier->id) }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Edit Supplier</h5>
                                </div>
                                <div class="card-body">

                                    @csrf

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="name">Name <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-5">
                                            <input type="text" id="name" class="form-control" name="name"
                                                placeholder="Name" value="{{ $Supplier->name }}" required />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="email">Email <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-5">
                                            <input type="email" id="email" class="form-control" name="email"
                                                placeholder="Email" value="{{ $Supplier->email }}" required />
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="phone">Phone <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-5">
                                            <input type="number" id="phone" class="form-control" name="phone"
                                                placeholder="Phone" value="{{ $Supplier->phone }}" required />

                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="address">Address <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-5">
                                            <input type="text" id="address" class="form-control" name="address"
                                                placeholder="Address" value="{{ $Supplier->address }}" required />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="about_supplier">About Supplier <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-5">
                                            <textarea class="form-control" name="about_supplier" id="about_supplier"
                                                placeholder="About Supplier" rows="3" cols="5"
                                                required>{{ $Supplier->about_supplier }}</textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="joining_date">Joining Date <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-5">
                                            <input type="text" id="joining_date" class="form-control flatpickr"
                                                name="joining_date" placeholder="Joining Date"
                                                value="{{ $Supplier->joining_date != '' ? date('d-m-Y', strtotime($Supplier->joining_date)) : '' }}"
                                                required />
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('suppliers') }}" class="btn btn-secondary">Cancel</a>
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
                $("#suppliers_Edit").validate({
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
