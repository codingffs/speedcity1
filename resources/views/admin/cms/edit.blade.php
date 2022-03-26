@extends('layouts.admin.master')

@section('title')
    Cms
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('cms.index') }}">Cms</a></li>
        <li class="breadcrumb-item active">Edit</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="cms_edit" method="POST"
                            action="{{ route('cms.update', $cms->id) }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Edit Cms</h5>
                                </div>
                                <div class="card-body">

                                    @csrf
                                    @method('PATCH')

                                    <div class="mb-3 row">
                                        <input id="id" name="id" type="hidden" value="{{ $cms->id }}"/>
                                        <label class="col-sm-3 col-form-label" for="title">Cms Title <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="title" class="form-control" name="title"
                                                placeholder="Title" value="{{ old('title', $cms->title) }}" required />
                                            @error('title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="title">Cms Description </label>
                                        <div class="col-sm-9">
                                            <textarea type="text" id="description" class="form-control" name="description"
                                                placeholder="Description" >{!! $cms->description !!}</textarea>
                                            @error('description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="image">Cms Image </label>
                                        <div class="col-sm-9">
                                            <input type="file" id="image" class="form-control" name="image"
                                                placeholder="Image" value="{{ old('image', $cms->image) }}" />
                                            @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            @if(isset($cms->image))
                                            <img class="mt-2" src="{{ url('images/cms'.'/'.$cms->image) }} " width="80" height="70" />
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('cms.index') }}" class="btn btn-secondary">Cancel</a>
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

                $("#cms_edit").validate({
                    // rules: {
                    //     title: {
                    //         maxlength: 50,
                    //         remote: {
                    //             type: 'get',
                    //             url: '{{ route('check_title_edit_exists_service') }}',
                    //             data: {
                    //                 'id': function() {
                    //                     return $('#id').val();
                    //                 },
                    //                 'title': function() {
                    //                     return $("#title").val();
                    //                 }
                    //             },
                    //             dataFilter: function(data) {
                    //                 var json = JSON.parse(data);
                    //                 if (json.status == 0) {
                    //                     return "\"" + json.message + "\"";
                    //                 } else {
                    //                     return 'true';
                    //                 }
                    //             }
                    //         }
                    //     },
                    // },
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
