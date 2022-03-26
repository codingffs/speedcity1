@extends('layouts.admin.master')

@section('title')Courierlist Item 
    
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('Courierlist.index') }}">Courierlist</a></li>
        <li class="breadcrumb-item active">Create</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="Courierlist_create" method="POST" action="{{ route('Courierlist.store') }}"
                            enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Create Courierlist Item</h5>
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
                                        <label class="col-sm-3 col-form-label" for="description">Description <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <textarea id="description" class="form-control" name="description"
                                                placeholder="description" value="{{ old('description') }}" required >
                                            </textarea>
                                            @error('description')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('Courierlist.index') }}" class="btn btn-secondary">Cancel</a>
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

                $("#Courierlist_create").validate({ 
                    errorPlacement: function(error, element) {
                        if (element.attr("name") == "discount_type") {
                            error.appendTo(element.parent("div").parent("div").parent('div'));
                        } else {
                            error.insertAfter(element);
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
