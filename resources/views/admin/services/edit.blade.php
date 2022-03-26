@extends('layouts.admin.master')

@section('title')
    Service
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Service</a></li>
        <li class="breadcrumb-item active">Edit</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="services_edit" method="POST"
                            action="{{ route('services.update', $Services->id) }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Edit Service</h5>
                                </div>
                                <div class="card-body">

                                    @csrf
                                    @method('PATCH')

                                    <div class="mb-3 row">
                                        <input id="id" name="id" type="hidden" value="{{ $Services->id }}"/>
                                        <label class="col-sm-3 col-form-label" for="title">Service Title <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="title" class="form-control" name="title"
                                                placeholder="Title" value="{{ old('title', $Services->title) }}" required />
                                            @error('title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="title">Service Description <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <textarea type="text" id="description" class="form-control" name="description"
                                                placeholder="Description" required>{!! $Services->description !!}</textarea>
                                            @error('description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="image">Service Image <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="file" id="image" class="form-control" name="image"
                                                placeholder="Image" value="{{ old('image', $Services->image) }}" />
                                            @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            @if(isset($Services->image))
                                            <img class="mt-2" src="{{ url('images/services'.'/'.$Services->image) }} " width="80" height="70" />
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancel</a>
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

                $("#services_edit").validate({
                    rules: {
                        title: {
                            maxlength: 50,
                            remote: {
                                type: 'get',
                                url: '{{ route('check_title_edit_exists_service') }}',
                                data: {
                                    'id': function() {
                                        return $('#id').val();
                                    },
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
                        } else {
                            error.insertAfter(element);
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
