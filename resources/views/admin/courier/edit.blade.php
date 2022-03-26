@extends('layouts.admin.master')

@section('title')Courierlist Item 
   
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('Courierlist.index') }}">Courierlist Item</a></li>
        <li class="breadcrumb-item active">Edit</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="Courierlist_edit" method="POST" action="{{ route('Courierlist.update', $CourierItems->id) }}"
                            enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Edit CourierItems</h5>
                                </div>
                                <div class="card-body">

                                    @csrf
                                    @method('PATCH')

                                    <div class="mb-3 row">
                                        <input name="id" id="id" type="hidden" value="{{ $CourierItems->id }}"/>
                                        <label class="col-sm-3 col-form-label" for="country_name">Country Name <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="item_name" class="form-control" name="item_name"
                                                placeholder="item Name" value="{{ $CourierItems->item_name }}" />
                                            @error('item_name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="description">Description <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <textarea type="text" id="description" class="form-control" name="description"
                                                placeholder="description" value="{{ $CourierItems->description }}" required >{{ $CourierItems->description }}
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

                $("#Courierlist_edit").validate({
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
