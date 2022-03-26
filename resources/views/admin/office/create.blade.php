@extends('layouts.admin.master')

@section('title')
Office
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('offices.index') }}">Office</a></li>
        <li class="breadcrumb-item active">Create</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="office_Create" method="POST"
                            action="{{ route('offices.store') }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Create Office</h5>
                                </div>
                                <div class="card-body">

                                @csrf
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="branch_name">Branch Name <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="branch_name" class="form-control" name="branch_name"
                                            placeholder="Branch Name" value="{{ old('branch_name') }}" required />
                                        @error('branch_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="branch_code">Branch Code <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="branch_code" class="form-control" name="branch_code"
                                            placeholder="Branch Code" value="{{ old('branch_code') }}" required />
                                        @error('branch_code')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="street">Street <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="street" class="form-control" name="street"
                                            placeholder="Street" value="{{ old('street') }}" required />
                                        @error('street')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="city">City <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="city" class="form-control" name="city"
                                            placeholder="City" value="{{ old('city') }}" required />
                                        @error('city')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="state">State <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="state" class="form-control" name="state"
                                            placeholder="State" value="{{ old('state') }}" required />
                                        @error('state')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="zip_code">Zip Code <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="zip_code" class="form-control" name="zip_code"
                                            placeholder="Zip Code" value="{{ old('zip_code') }}" required />
                                        @error('zip_code')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="contact">Contact Detail <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <textarea id="contact" class="form-control" name="contact"
                                            placeholder="Contact Detail" value="{{ old('contact') }}" required ></textarea>
                                        @error('contact')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('offices.index') }}" class="btn btn-secondary">Cancel</a>
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
                CKEDITOR.replace('contact');
                $("#office_Create").validate({
                    rules: {
                        // title: {
                        //     maxlength: 50,
                        //     remote: {
                        //         type: 'get',
                        //         url: '{{ route('check_title_exists') }}',
                        //         data: {
                        //             'title': function() {
                        //                 return $("#title").val();
                        //             }
                        //         },
                        //         dataFilter: function(data) {
                        //             var json = JSON.parse(data);
                        //             if (json.status == 0) {
                        //                 return "\"" + json.message + "\"";
                        //             } else {
                        //                 return 'true';
                        //             }
                        //         }
                        //     }
                        // },
                    },
                    errorPlacement: function(error, element) {
                        if (element.attr("type") == "text") {
                            error.appendTo(element.parent("div"));
                        }else {
                            error.insertAfter(element);
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
