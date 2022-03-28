@extends('layouts.admin.master')

@section('title')
Species
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('species.index') }}">Species</a></li>
        <li class="breadcrumb-item active">Edit</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="species_edit" method="POST"
                            action="{{ route('species.update', $Species->id) }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Edit Species</h5>
                                </div>
                                @csrf
                                @method('PATCH')
                                <div class="card-body">

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="title">Species Name <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="species_name" class="form-control" name="species_name"
                                                placeholder="species_name" value="{{ old('title', $Species->species_name) }}" required />
                                            @error('species_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="scientific_name">Scientific Name <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="scientific_name" class="form-control" name="scientific_name" placeholder="species_name" value="{{ old('scientific_name', $Species->scientific_name) }}" required />
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
                                                placeholder="family" required  value="{{ old('family', $Species->family) }}" required />
                                            @error('family')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="silvicultural_requirements">Silvicultural Requirements</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="silvicultural_requirements" class="form-control" name="silvicultural_requirements"
                                                placeholder="silvicultural_requirements" required value="{{ old('silvicultural_requirements', $Species->silvicultural_requirements) }}" required/>
                                            @error('silvicultural_requirements')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="species_description">Species Description</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="species_description" class="form-control" name="species_description"
                                                placeholder="species_description" required value="{{ old('species_description', $Species->species_description) }}" required />
                                            @error('species_description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="utility">Utility</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="utility" class="form-control" name="utility"
                                                placeholder="utility" required value="{{ old('utility', $Species->utility) }}" required/>
                                            @error('utility')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="image">Image</label>
                                        <div class="col-sm-9">
                                            <input type="file" id="image" class="form-control" name="image"
                                            placeholder="image" value="{{ old('image', $Species->image) }}" />                                        
                                            <img src="{{ asset('/species'.'/'.$Species->image) }}" width="100px" />
                                            @error('species_description')
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
                $("#species_edit").validate({
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
