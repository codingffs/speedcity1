@extends('layouts.admin.master')

@section('title')
Medical Appliance
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('medicalappliance.index') }}">Medical Appliance</a></li>
        <li class="breadcrumb-item active">Create</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="medicalcategories_Create" method="POST"
                            action="{{ route('medicalappliance.store') }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Create Medical Appliance</h5>
                                </div>
                                <div class="card-body">

                                    @csrf

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="title">Title <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="title" class="form-control" name="title"
                                                placeholder="Title" value="{{ old('title') }}" required />
                                            @error('title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="description">Description <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <textarea  id="description" class="form-control" name="description"
                                                placeholder="description" value="{{ old('description') }}" required >
                                            </textarea>
                                            @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="price"> Price<span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="price" class="form-control" name="price"
                                                placeholder="price" value="{{ old('price') }}" required />
                                                @error('price')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="medicalcategory"> Medical Category<span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                                <select name="medicalcategory" id="medicalcategory" class="form-control" required >
                                                    @foreach($medicalcategory as $medicalcategory)
                                                    <option value="{{ $medicalcategory->id }}">{{ $medicalcategory->title }}</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="image">Image <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="file" id="image" class="form-control" name="image"
                                                placeholder="image" value="{{ old('image') }}" required />
                                            @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('medicalappliance.index') }}" class="btn btn-secondary">Cancel</a>
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
                CKEDITOR.replace('description');
                $("#medicalcategories_Create").validate({
                    rules: {
                        title: {
                            maxlength: 50,
                            remote: {
                                type: 'get',
                                url: '{{ route('check_medical_title_exists') }}',
                                data: {
                                    'title': function() {
                                        return $("#title").val();
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
                        if (element.attr("type") == "text") {
                            error.appendTo(element.parent("div"));
                        } else if (element.attr("type") == "file") {
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
