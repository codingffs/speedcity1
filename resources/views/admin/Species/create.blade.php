@extends('layouts.admin.master')

@section('title')
Species
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('species.index') }}">Species</a></li>
        <li class="breadcrumb-item active">Create</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="species_Create" method="POST"
                            action="{{ route('species.store') }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Create Species</h5>
                                </div>
                                <div class="card-body">

                                @csrf
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="title">Species Name <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="species_name" class="form-control" name="species_name"
                                            placeholder="species_name" value="{{ old('title') }}" required />
                                        @error('species_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="scientific_name">Scientific Name <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="scientific_name" class="form-control" name="scientific_name" placeholder="species_name" value="{{ old('scientific_name') }}" />
                                        @error('scientific_name')
                                            <div class="text-danger">{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                               
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="family">Family</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="family" class="form-control" name="family"
                                            placeholder="family" required {{ old('family') }} />
                                        @error('family')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="silvicultural_requirements">Silvicultural Requirements</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="silvicultural_requirements" class="form-control" name="silvicultural_requirements"
                                            placeholder="silvicultural_requirements" required {{ old('silvicultural_requirements') }} />
                                        @error('silvicultural_requirements')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="species_description">Species Description</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="species_description" class="form-control" name="species_description"
                                            placeholder="species_description" required {{ old('species_description') }} />
                                        @error('species_description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="utility">Utility</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="utility" class="form-control" name="utility"
                                            placeholder="utility" required {{ old('utility') }}/>
                                        @error('utility')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="species_description">Image</label>
                                    <div class="col-sm-9">
                                        <input type="file" id="image" class="form-control" name="image"
                                        placeholder="image" value="{{ old('image') }}" required />                                        @error('species_description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('species.index') }}" class="btn btn-secondary">Cancel</a>
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

                $("#species_Create").validate({
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
