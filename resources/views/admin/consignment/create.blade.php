@extends('layouts.admin.master')

@section('title')
    Consignment
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('consignment') }}">Consignment</a></li>
        <li class="breadcrumb-item active">Create</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">

                        <form class="theme-form" method="GET" action="" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Create Consignment</h5>
                                </div>
                                <div class="card-body">

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="supplier_id">Supplier <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <select name="supplier_id" class="form-control select2"
                                                onchange="this.form.submit()">
                                                <option value="">Select Supplier</option>
                                                @foreach ($Supplier as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ request()->get('supplier_id') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3"></div>

                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-primary">+ Add Item</button>
                                        </div>
                                    </div>

                                </div>
                        </form>

                        <form class="theme-form" id="Consignment_Create" method="POST"
                            action="{{ route('consignment.store') }}" enctype="multipart/form-data">

                            @csrf
                            <input type="hidden" name="supplier_id" value="{{ request()->get('supplier_id') }}">

                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered display">
                                            <thead>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th>Attribute</th>
                                                    <th>SKU</th>
                                                    <th>Order Quantity</th>
                                                    <th>Received Quantity</th>
                                                    <th>Tax</th>
                                                    <th>Price</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $products = App\Models\Product::where('supplier_id', request()->get('supplier_id'))->get();
                                                @endphp
                                                    <tr>
                                                        <td>
                                                            <select name="product_id[]" class="form-control select2 product_id" required>
                                                                <option value="">Select Product</option>
                                                                @foreach ($products as $item)
                                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            <input type="number" name="attribute[]"
                                                                class="form-control attribute">
                                                        </td>
                                                        <td>
                                                            <input type="number" name="sku[]"
                                                                class="form-control sku">
                                                        </td>
                                                        <td>
                                                            <select name="tax[]" class="form-control select2 tax">
                                                                <option value="GST">GST</option>
                                                                <option value="GST Free">GST Free</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="price[]" class="form-control price">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger">Delete</button>
                                                        </td>
                                                    </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <label for="expected_date">Expected Date</label>
                                    <input type="text" name="expected_date" id="expected_date"
                                        class="form-control flatpickr">

                                    <label for="received_date">Received Date</label>
                                    <input type="text" name="received_date" id="received_date"
                                        class="form-control flatpickr">
                                </div>

                                <div class="col-md-4"></div>

                                <div class="col-md-4">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <label>Price : </label>
                                        </div>
                                        <div class="col-md-6">
                                            <label>$10800.00</label>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Tax : </label>
                                        </div>
                                        <div class="col-md-6">
                                            <label>+ $200.00</label>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Shipping : </label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" name="shipping" class="form-control" id="shipping"
                                                placeholder="Shipping">
                                        </div>
                                        <hr>

                                        <div class="col-md-6">
                                            <label>Total : </label>
                                        </div>
                                        <div class="col-md-6">
                                            <label>$11300.00</label>
                                        </div>

                                    </div>
                                </div>
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
                $("#Consignment_Create").validate({
                    errorPlacement: function(error, element) {
                        if (element.attr("name") == "discount_type") {
                            error.appendTo(element.parent("div").parent("div").parent('div'));
                        } else {
                            error.insertAfter(element);
                        }
                    }
                });

                flatpickr('.flatpickr', {
                    dateFormat: "d-m-Y",
                });

                $(".product_id").change(function (e) { 
                    var product_id = $(this).val();

                    $.ajax({
                        type: "POST",
                        url: "{{ route('get_product_detail_for_consignment') }}",
                        data: { "_token" : "{{ csrf_token() }}", "product_id" : product_id },
                        success: function (response) {
                            
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
