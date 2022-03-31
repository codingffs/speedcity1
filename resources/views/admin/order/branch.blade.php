@extends('layouts.admin.master')

@section('title')Order 
    
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Order</a></li>
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
                        <form class="theme-form" id="city_Create" method="POST" action="{{ route('orders.update',$order->id) }}"
                            enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Order</h5>
                                </div>
                                <div class="card-body">

                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-3 row">
                                        <input name="id" id="id" type="hidden" value="{{ $order->id }}" />
                                        <label class="col-sm-3 col-form-label" for="branch_id">Branch Name <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <select name="branch_id" id="branch_id" class="form-control" required >
                                                @foreach($Branch as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('branch_id')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    @push('scripts')
    
        
    @endpush
@endsection
