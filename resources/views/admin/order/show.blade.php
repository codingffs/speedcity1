@extends('layouts.admin.master')

@section('title')Order 
    
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('localPackage.index') }}">Order</a></li>
        <li class="breadcrumb-item active">Order Details</li>
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
                                    <h5>Order Details</h5>
                                    <a href="{{ route('orders.index') }}" class="btn btn-primary float_right">Back</a>
                                </div>
                                <div class="card-body">
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="parcel_id">Parcel Id </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $order->parcel_id }}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="user_id">User Id </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $order->user_id }}
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="local_services">Local Services </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $order->local_services }}
                                    </div>
                                </div>
                                
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="pickup_address">Pickup Address </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $order->pickup_address }}
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="delivery_address">Delivery Address </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $order->delivery_address }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="sender_name">Sender Name </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $order->sender_name }}
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="receiver_name">Receiver Name </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $order->receiver_name }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="pickup_others">Pickup Others </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $order->pickup_others }}
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="delivery_others">Delivery Others </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $order->delivery_others }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="parcel_type">Parcel Type </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $order->parcel_type }}
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="parcel_weight">Parcel Weight </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $order->parcel_weight }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="total_amount">Total Amount </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $order->total_amount }}
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="status">Status </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ ($order->status == "0")?'Pending': (($order->status == "1")?'Inprogress': (($order->status == "2")?'Completed': (($order->status == "3")?'Cancel':''))) }}
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
