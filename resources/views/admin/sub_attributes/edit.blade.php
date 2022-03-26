@extends('layouts.admin.master')

@section('title')
    Sub Attribute
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('sub_attributes', $SubAttribute->id) }}">Sub Attribute</a></li>
        <li class="breadcrumb-item active">Edit</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="attributes_Edit" method="POST"
                            action="{{ route('sub_attributes.update', $SubAttribute->id) }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Edit Sub Attribute</h5>
                                </div>
                                <div class="card-body">

                                    @csrf

                                    <input type="hidden" name="attribute_id" value="{{ $SubAttribute->attribute_id }}">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="name">Sub Attribute Name <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="name" class="form-control" name="name"
                                                placeholder="Name" value="{{ old('name', $SubAttribute->name) }}" required />
                                            @error('name')
                                                <label class="error">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('sub_attributes', $SubAttribute->attribute_id) }}" class="btn btn-secondary">Cancel</a>
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
                $("#attributes_Edit").validate({
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
