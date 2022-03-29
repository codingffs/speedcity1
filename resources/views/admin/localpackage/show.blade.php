@extends('layouts.admin.master')

@section('title')Local Package 
    
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('localPackage.index') }}">Local Package</a></li>
        <li class="breadcrumb-item active">Local Package Details</li>
    @endcomponent
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div> 
   @endif
   
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Local Package Details</h5>
                                    <a href="{{ route('localPackage.index') }}" class="btn btn-primary float_right">Back</a>
                                </div>
                                <div class="card-body">
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="itemsID">Items Name </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ getItemName($localPackage->itemsID) }}
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="source_address">Source Address </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $localPackage->source_address }}
                                    </div>
                                </div>
                                
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="destination_address">Destination Address </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $localPackage->destination_address }}
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="city">City </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $localPackage->city }}
                                    </div>
                                </div>
                                
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="state">State</label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $localPackage->state }}
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="zip_code">Zip Code</label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $localPackage->zip_code }}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="distance">Distance </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $localPackage->distance }}
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="price_per_km">price(km) </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $localPackage->price_per_km }}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="notes">Notes </label>
                                    <div class="col-sm-4 margin-div">
                                        : {!! $localPackage->notes !!}
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    @push('scripts')
    
        
    @endpush
@endsection
