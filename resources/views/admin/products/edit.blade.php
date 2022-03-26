@extends('layouts.admin.master')

@section('title')
    Products
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('products') }}">Products</a></li>
        <li class="breadcrumb-item active">Edit</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="products_Edit" method="POST"
                            action="{{ route('products.update', $Product->id) }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    
                                    <div class="row">
                                        <div class="col-md-10">
                                            <h5>Edit Product</h5>
                                        </div>
                                        <div class="col-md-2 text-right">
                                            @if ($Product->shopify_sync == 0 && $Product->status == "Approve" && $Product->product_status == "Publish")
                                                <a href="{{ route('product_add_to_shopify', $Product->id) }}" class="btn btn-primary">Sync</a>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="card-body">

                                    @csrf

                                    <div class="row">

                                        <div class="col-sm-6 mb-3">
                                            <label class="col-form-label" for="product_type">Product Type <span
                                                    class="text-danger">*</span></label>
                                            <select name="product_type" id="product_type" class="form-control select2"
                                                required>
                                                <option value="">Select Product Type</option>
                                                <option value="Simple Product"
                                                    {{ $Product->product_type == 'Simple Product' ? 'selected' : '' }}>
                                                    Simple Product</option>
                                                <option value="Variable Product"
                                                    {{ $Product->product_type == 'Variable Product' ? 'selected' : '' }}>
                                                    Variable Product</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-6 mb-3">
                                            <label class="col-form-label" for="name">Product Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="name" class="form-control" name="name"
                                                placeholder="Name" value="{{ $Product->name }}" required />
                                        </div>

                                        @if (auth()->user()->type == 1)
                                            <div class="col-sm-6 mb-3">
                                                <label class="col-form-label" for="supplier_id">Supplier<span
                                                        class="text-danger">*</span></label>
                                                <select name="supplier_id" id="supplier_id" class="form-control {{ $Product->user->type == '1' ? "select2" : "disabled" }}"
                                                    required>
                                                    <option value="">Select Supplier</option>
                                                    @foreach ($Supplier as $item)
                                                        <option value="{{ $item->id }}" {{ $Product->supplier_id == $item->id ? "selected" : "" }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif

                                        <div class="col-sm-12 mb-3">
                                            <label class="col-form-label" for="description">Description <span
                                                    class="text-danger">*</span></label>
                                            <textarea rows="4" id="description" class="form-control" name="description"
                                                placeholder="Description" required>{{ $Product->description }}</textarea>
                                        </div>

                                        <div class="col-sm-6 mb-3 simple_product_div"
                                            style="display: {{ $Product->product_type == 'Variable Product' ? 'none' : '' }}">
                                            <label class="col-form-label" for="quantity">Quantity <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" id="quantity" class="form-control simple_product_required"
                                                name="quantity" placeholder="Quantity" value="{{ $Product->quantity }}"
                                                {{ $Product->product_type == 'Variable Product' ? '' : 'required' }} />
                                        </div>

                                        <div class="col-sm-6 mb-3 simple_product_div"
                                            style="display: {{ $Product->product_type == 'Variable Product' ? 'none' : '' }}">
                                            <label class="col-form-label" for="cost_of_good">Cost of Good <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" id="cost_of_good"
                                                class="form-control simple_product_required" name="cost_of_good"
                                                placeholder="Cost of Good" value="{{ $Product->cost_of_good }}"
                                                {{ $Product->product_type == 'Variable Product' ? '' : 'required' }} />
                                        </div>

                                        <div class="col-sm-6 mb-3 simple_product_div"
                                            style="display: {{ $Product->product_type == 'Variable Product' ? 'none' : '' }}">
                                            <label class="col-form-label" for="retail_price">Retail Price <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" id="retail_price"
                                                class="form-control simple_product_required" name="retail_price"
                                                placeholder="Retail Price" value="{{ $Product->retail_price }}"
                                                {{ $Product->product_type == 'Variable Product' ? '' : 'required' }} />
                                        </div>

                                        {{-- <div class="col-sm-6 mb-3">
                                            <label class="col-form-label" for="expected_date">Expected Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="expected_date" class="form-control flatpickr"
                                                name="expected_date" placeholder="Expected Date"
                                                value="{{ date('d-m-Y', strtotime($Product->expected_date)) }}"
                                                required />
                                        </div>

                                        <div class="col-sm-6 mb-3">
                                            <label class="col-form-label" for="received_date">Received Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="received_date" class="form-control flatpickr"
                                                name="received_date" placeholder="Received Date"
                                                value="{{ date('d-m-Y', strtotime($Product->received_date)) }}"
                                                required />
                                        </div> --}}

                                        {{-- <div class="col-sm-6 mb-3">
                                            <label class="col-form-label" for="delivery_date">Delivery Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="delivery_date" class="form-control flatpickr"
                                                name="delivery_date" placeholder="Delivery Date"
                                                value="{{ date('d-m-Y', strtotime($Product->delivery_date)) != '01-01-1970'? date('d-m-Y', strtotime($Product->delivery_date)): '' }}"
                                                required />
                                        </div> --}}

                                        <div class="col-sm-12 mb-3">
                                            <label class="col-form-label" for="upload_images">Upload Images</label>
                                            <div class="image_upload_show">
                                                @foreach ($Product->product_images as $prod_image)
                                                    <span>
                                                        <img class="image_pre_disp"
                                                            id="upload_image_{{ $prod_image->id }}"
                                                            src="{{ asset('product/' . $prod_image->image) }}">
                                                        <a href="javascript:void(0)" data-id="{{ $prod_image->id }}"
                                                            class="btn btn-sm btn-danger delete_image_btn">X</a>
                                                    </span>
                                                @endforeach
                                            </div>
                                            <input type="file" id="upload_images" class="form-control"
                                                name="upload_images[]" accept="image/*" multiple />
                                        </div>

                                        <div class="col-sm-6 mb-3">
                                            <label class="col-form-label" for="category">Category <span
                                                    class="text-danger">*</span></label>
                                            @php
                                                $category_id = $Product->category_id;
                                            @endphp
                                            <select name="category_id[]" class="form-control select2" multiple="multiple"
                                                required>
                                                @foreach ($Category as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ in_array($item->id, $category_id) ? 'selected' : '' }}>
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="row attribute_div"
                                            style="display: {{ $Product->product_type == 'Simple Product' ? 'none' : '' }}">
                                            <div class="col-sm-6 mb-3">
                                                <label class="col-form-label" for="attribute">Attributes <span
                                                        class="text-danger">*</span></label>
                                                @php
                                                    $attribute_id = $Product->attribute_id;
                                                @endphp
                                                <select name="attribute_id[]" id="attribute_id"
                                                    class="form-control select2 attribute_select" multiple required>
                                                    @foreach ($Attribute as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ !empty($attribute_id) && in_array($item->id, $attribute_id) ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-sm-12 mb-3">
                                                <button type="button" class="btn btn-primary float_right"
                                                    id="add_new_attribute">+ Add New Variation</button>
                                            </div>
                                        </div>

                                        <input type="hidden" id="attribute_no" value="1">
                                    </div>

                                    <div class="row append_attribute attribute_div"
                                        style="display: {{ $Product->product_type == 'Simple Product' ? 'none' : '' }}">

                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button name="product_status" type="submit" class="btn btn-primary"
                                        value="Draft">Draft</button>
                                    <button name="product_status" type="submit" class="btn btn-success"
                                        value="Publish">Publish</button>
                                    <a href="{{ route('products') }}" class="btn btn-secondary">Cancel</a>
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
                $("#products_Edit").validate({
                    rules: {
                        name: {
                            remote: {
                                type: 'POST',
                                url: '{{ route('check_name_exists_in_products') }}',
                                data: {
                                    '_token': '{{ csrf_token() }}',
                                    'name': function() {
                                        return $("#name").val();
                                    },
                                    "id": "{{ Request::segment(3) }}"
                                },
                                dataFilter: function(data) {
                                    var json = JSON.parse(data);
                                    if (json.status == 0) {
                                        return "\"" + json.message + "\"";
                                    } else {
                                        return true;
                                    }
                                }
                            }
                        },
                    },
                    errorPlacement: function(error, element) {
                        if (element.attr("name") == "discount_type") {
                            error.appendTo(element.parent("div").parent("div").parent('div'));
                        } else {
                            error.insertAfter(element);
                        }
                    }
                });

                $("#product_type").change(function(e) {
                    var product_type = $(this).val();
                    if (product_type == "Variable Product") {
                        $(".simple_product_div").hide();
                        $(".simple_product_required").prop("required", false);
                        $(".simple_product_required").val("");
                        $(".attribute_div").show();
                        $("#attribute_id").prop("required", true);
                        $(".attribute_select").select2();
                    } else {
                        $(".simple_product_div").show();
                        $(".simple_product_required").prop("required", true);
                        $(".attribute_div").hide();
                        $("#attribute_id").prop("required", false);
                    }
                });

                flatpickr('.flatpickr', {
                    dateFormat: "d-m-Y",
                });

                var imagesPreview = function(input, placeToInsertImagePreview) {
                    $(".remove_dynamic_image").remove();
                    if (input.files) {
                        var filesAmount = input.files.length;

                        for (i = 0; i < filesAmount; i++) {
                            var reader = new FileReader();

                            reader.onload = function(event) {
                                $($.parseHTML('<img class="image_pre_disp remove_dynamic_image">')).attr('src',
                                        event.target.result)
                                    .appendTo(
                                        placeToInsertImagePreview);
                            }

                            reader.readAsDataURL(input.files[i]);
                        }
                    }

                };

                $('#upload_images').on('change', function() {
                    imagesPreview(this, 'div.image_upload_show');
                });

                $("#add_new_attribute").click(function(e) {
                    add_new_attribute();
                });

                function add_new_attribute() {

                    var attribute_id = $("#attribute_id").val();
                    var attribute_no = $("#attribute_no").val();
                    var product_id = '{{ $Product->id }}';
                    $_token = "{{ csrf_token() }}";
                    $('.append_attribute').empty();
                    $.ajax({
                        type: "post",
                        url: "{{ route('get_dynamic_attribute') }}",
                        data: {
                            "attribute_id": attribute_id,
                            "attribute_no": attribute_no,
                            "product_id": product_id,
                            "_token": $_token
                        },
                        cache: false,
                        dataType: "html",
                        success: function(response) {
                            var data = $.parseJSON(response);
                            $('.append_attribute').append(data.html);
                            $(".select2_dynamic").select2();

                        }
                    });
                }

                $(".delete_image_btn").click(function(e) {
                    swal.fire({
                        title: 'Are you sure?',
                        text: "You want to delete this item!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: "btn btn-danger",
                        cancelButtonClass: "btn btn-primary",
                        confirmButtonText: 'Yes, delete it!',
                        inputValidator: (value) => {
                            if (!value) {
                                return 'You need to write something!'
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var id = $(this).data("id");
                            var current = $(this);
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('product_image_delete') }}",
                                data: {
                                    "id": id,
                                    "_token": "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    if (response.status == 1) {
                                        $("#upload_image_" + id).remove();
                                        current.remove();
                                    }
                                }
                            });
                        }
                    });

                });

                $(document).on("click", ".add_more", function() {
                    var attribute_id = $("#attribute_id").val();
                    var attribute_no = $('.admin_sku').length + 1;

                    $_token = "{{ csrf_token() }}";
                    $.ajax({
                        type: "post",
                        url: "{{ route('get_dynamic_attribute') }}",
                        data: {
                            "attribute_id": attribute_id,
                            "attribute_no": attribute_no,
                            "_token": $_token
                        },
                        cache: false,
                        dataType: "html",
                        success: function(response) {
                            var data = $.parseJSON(response);
                            $('.append_attribute').append("<h2>Attribute " + attribute_no +
                                "</h2>");
                            $('.append_attribute').append(data.html);
                            $(".select2_dynamic").select2();

                        }
                    });
                });

                $("#cost_of_good").keyup(function(e) {
                    var cost_of_good = $(this).val();
                    var retail_price = parseFloat(cost_of_good) + ((parseFloat(cost_of_good) / 100) * 45);
                    $("#retail_price").val(retail_price);
                });

                add_new_attribute();
            });
        </script>
    @endpush
@endsection
