@extends('layouts.admin.master')

@section('title')Domestic Package
    
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('domesticpackage.index') }}">Domestic Package Item </a></li>
        <li class="breadcrumb-item active">Create</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="domesticpackage_create" method="POST" action="{{ route('domesticpackage.store') }}"
                            enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Create Domestic Package </h5>
                                </div>
                                <div class="card-body">

                                    @csrf
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="item_name">Item Name <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="item_name" class="form-control" name="item_name"
                                                placeholder="item name" value="{{ old('item_name') }}" required />
                                            @error('item_name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="source_city	">Source City <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="source_city	" class="form-control" name="source_city"
                                                placeholder="source city" value="{{ old('source_city') }}" required />
                                            @error('source_city')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="destination_city">Destination City <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="destination_city" class="form-control" name="destination_city"
                                                placeholder="Destination City" value="{{ old('destination_city') }}" required />
                                            @error('destination_city')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="price">Price <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="price" class="form-control" name="price"
                                                placeholder="Price" value="{{ old('price') }}" required />
                                            @error('price')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="notes">Notes <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <textarea id="notes" class="form-control" name="notes"
                                                placeholder="Notes" value="{{ old('notes') }}" required >
                                            </textarea>
                                            @error('notes')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('domesticpackage.index') }}" class="btn btn-secondary">Cancel</a>
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
                CKEDITOR.replace('notes');

                $("#domesticpackage_create").validate({ 
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
