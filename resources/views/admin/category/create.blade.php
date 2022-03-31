@extends('layouts.admin.master')

@section('title')
Banner
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Banner</a></li>
        <li class="breadcrumb-item active">Create</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="categories_Create" method="POST"
                            action="{{ route('categories.store') }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Create Banner</h5>
                                </div>
                                <div class="card-body">

                                    @csrf

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="title">Title </label>
                                        <div class="col-sm-9">
                                            <input type="text" id="title" class="form-control" name="title"
                                                placeholder="Title" value="{{ old('title') }}" />
                                            @error('title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
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
                                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
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
                $("#categories_Create").validate({
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
