@extends('layouts.admin.master')

@section('title')
    Setting
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('settings.index') }}">Setting</a></li>
        <li class="breadcrumb-item active">Create</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="setting_Create" method="POST" action="{{ route('settings.store') }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Create Setting</h5>
                                </div>
                                <div class="card-body">
                                    
                                    @csrf

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="title">Title <span class="text-danger">*</span></label>
                                        <div class="col-sm-5">
                                            <input type="text" id="title" class="form-control" name="title" placeholder="Title"  value="{{ old('title') }}" required />
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="type">Type <span class="text-danger">*</span></label>
                                        <div class="col-sm-5">
                                            <select name="type" id="type" class="form-control select2" required>
                                                <option value="Text" {{ old('type') == "Text" ? "selected" : "" }}>Text</option>
                                                <option value="File" {{ old('type') == "File" ? "selected" : "" }}>File</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="key">Key <span class="text-danger">*</span></label>
                                        <div class="col-sm-5">
                                            <input type="text" id="key" class="form-control" name="key" placeholder="Key"  value="{{ old('key') }}" required />
                                            @error('key')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="value">Value <span class="text-danger">*</span></label>
                                        <div class="col-sm-5">
                                            <input type="text" id="value" class="form-control" name="value" placeholder="Value" value="{{ old('value') }}" required />
                                        </div>
                                    </div>

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
        $(document).ready(function(){
            $("#setting_Create").validate(
                {
                    errorPlacement: function(error, element) {
                        if (element.attr("name") == "discount_type") {
                            error.appendTo(element.parent("div").parent("div").parent('div'));
                        } else {
                            error.insertAfter(element);
                        }
                    }
                }
            );
            
            flatpickr('.flatpickr', {
                dateFormat: "d-m-Y",
            });

            $("#type").change(function (e) { 
                var type = $("#type").val();
                if(type == "File"){
                    $("#value").attr("type", "file");
                } else {
                    $("#value").attr("type", "text");
                }
            });
        });
    </script>
@endpush
@endsection