@extends('layouts.admin.master')

@section('title')
Local Package
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('localPackage.index') }}">Local Package</a></li>
        <li class="breadcrumb-item active">Create</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="localpackage_Create" method="POST"
                            action="{{ route('localPackage.store') }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Create Local Package</h5>
                                </div>
                                <div class="card-body">

                                @csrf
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="itemsID">Item Name <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select name="itemsID" id="itemsID" class="form-control" required >
                                            @foreach($CourierItems as $CourierItems)
                                            <option value="{{ $CourierItems->id }}">{{ $CourierItems->item_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('itemsID')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="source_address">Souce Address <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="source_address" class="form-control" name="source_address"
                                            placeholder="Source Address" value="{{ old('source_address') }}" required />
                                        @error('source_address')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="destination_address">Destination Address <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="destination_address" class="form-control" name="destination_address"
                                            placeholder="Destination Address" value="{{ old('destination_address') }}" required />
                                        @error('destination_address')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="city">City <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="city" class="form-control" name="city"
                                            placeholder="City" value="{{ old('city') }}" required />
                                        @error('city')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="state">State <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="state" class="form-control" name="state"
                                            placeholder="State" value="{{ old('state') }}" required />
                                        @error('state')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="zip_code">Zip Code <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="zip_code" class="form-control" name="zip_code"
                                            placeholder="Zip Code" value="{{ old('zip_code') }}" required />
                                        @error('zip_code')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="distance">Distance <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="Distance" class="form-control" name="distance"
                                            placeholder="distance" value="{{ old('distance') }}" required />
                                        @error('zip_code')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="price_per_km">Price(km) <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="price_per_km" class="form-control" name="price_per_km"
                                            placeholder="Price(km)" value="{{ old('price_per_km') }}" required />
                                        @error('price_per_km')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="notes">Notes <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <textarea id="notes" class="form-control" name="notes"
                                            placeholder="Notes" value="{{ old('notes') }}" required ></textarea>
                                        @error('notes')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('localPackage.index') }}" class="btn btn-secondary">Cancel</a>
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
                $("#localpackage_Create").validate({
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
