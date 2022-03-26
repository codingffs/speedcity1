@extends('layouts.admin.master')

@section('title')
SubFaq
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('subfaq.index') }}">SubFaq</a></li>
        <li class="breadcrumb-item active">Create</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="subfaq_Create" method="POST"
                            action="{{ route('subfaq.store') }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Create SubFaq</h5>
                                </div>
                                <div class="card-body">

                                @csrf
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="sortname">Faq Title <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select name="faq_id" id="faq_id" class="form-control" required >
                                            @foreach($faq as $faqtitle)
                                            <option value="{{ $faqtitle->id }}">{{ $faqtitle->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('faq_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="title">SubFaq Title <span
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
                                    <label class="col-sm-3 col-form-label" for="description">SubFaq Description</label>
                                    <div class="col-sm-9">
                                        <textarea type="text" id="description" class="form-control" name="description"
                                            placeholder="Description" required>{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('subfaq.index') }}" class="btn btn-secondary">Cancel</a>
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

                $("#subfaq_Create").validate({
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
