@extends('layouts.admin.master')

@section('title')
    Setting
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('settings.index') }}">Setting</a></li>
        <li class="breadcrumb-item active">Edit</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="setting_Edit" method="POST"
                            action="{{ route('settings.update', $Setting->id) }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Edit Setting</h5>
                                </div>
                                <div class="card-body">

                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="title">Title <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-5">
                                            <input type="text" id="title" class="form-control" name="title"
                                                placeholder="Title" value="{{ old('title', $Setting->title) }}" required />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="key">Key <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-5">
                                            <input type="text" id="key" class="form-control" name="key" placeholder="Key"
                                                value="{{ old('key', $Setting->key) }}" required />
                                                @error('key')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" name="type" value="{{ $Setting->type }}">
                                    
                                    @if ($Setting->type == 'File')
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label" for="value">Value</label>
                                            <div class="col-sm-5">
                                                <input type="file" id="value" class="form-control" name="value" />
                                                <img src="{{ asset('setting/' . $Setting->value) }}" width="100px">
                                                <input type="hidden" name="old_value" value="{{ $Setting->value }}">
                                            </div>
                                        </div>
                                    @endif

                                    @if ($Setting->type == 'Text')
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label" for="value">Value <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-5">
                                                <input type="text" id="value"
                                                    class="form-control" name="value" placeholder="Value"
                                                    value="{{ old('value', $Setting->type == 'Text' ? $Setting->value : '') }}" required />
                                            </div>
                                        </div>
                                    @endif

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('settings.index') }}" class="btn btn-secondary">Cancel</a>
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
                $("#setting_Edit").validate({
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

                $("#type").change(function(e) {
                    var type = $("#type").val();
                    if (type == "File") {
                        $("#value").attr("type", "file");
                    } else {
                        $("#value").attr("type", "text");
                    }
                });
            });
        </script>
    @endpush
@endsection
