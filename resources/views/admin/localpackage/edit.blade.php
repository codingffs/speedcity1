@extends('layouts.admin.master')

@section('title')
Local Package
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('localpackage.index') }}">Local Package</a></li>
        <li class="breadcrumb-item active">Edit</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="office_edit" method="POST"
                            action="{{ route('localpackage.update', $office->id) }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Edit Local Package</h5>
                                </div>
                                <div class="card-body">

                                    @csrf
                                    @method('PATCH')

                                    <div class="mb-3 row">
                                        <input id="id" name="id" type="hidden" value="{{ $office->id }}"/>
                                        <label class="col-sm-3 col-form-label" for="branch_name">Branch Name <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="branch_name" class="form-control" name="branch_name"
                                                placeholder="Title" value="{{ old('branch_name', $office->branch_name) }}" required />
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
                                                placeholder="Branch Code" value="{{ old('branch_code', $office->branch_code) }}" required />
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
                                                placeholder="Street" value="{{ old('street', $office->street) }}" required />
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
                                                placeholder="City" value="{{ old('city', $office->city) }}" required />
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
                                                placeholder="State" value="{{ old('state', $office->state) }}" required />
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
                                                placeholder="Zip Code" value="{{ old('zip_code', $office->zip_code) }}" required />
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
                                                placeholder="Contact Detail" value="{{ old('contact', $office->contact) }}" required ></textarea>
                                            @error('contact')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('localpackage.index') }}" class="btn btn-secondary">Cancel</a>
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
                $("#office_edit").validate({
                    rules: {
                        // title: {
                        //     maxlength: 50,
                        //     remote: {
                        //         type: 'get',
                        //         url: '{{ route('check_title_exists_update') }}',
                        //         data: {
                        //             'id': function() {
                        //                 return $('#id').val();
                        //             },
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
                        } else {
                            error.insertAfter(element);
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
