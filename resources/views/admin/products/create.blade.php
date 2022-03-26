@extends('layouts.admin.master')

@section('title')
    Products
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('products') }}">Products</a></li>
        <li class="breadcrumb-item active">Create</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="products_Create" method="POST"
                            action="{{ route('products.store') }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Create Product</h5>
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
                                                <option value="Simple Product" selected>Simple Product</option>
                                                <option value="Variable Product">Variable Product</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-6 mb-3">
                                            <label class="col-form-label" for="name">Product Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="name" class="form-control" name="name"
                                                placeholder="Name" required />
                                        </div>

                                        @if (auth()->user()->type == 1)
                                            <div class="col-sm-6 mb-3">
                                                <label class="col-form-label" for="supplier_id">Supplier <span
                                                        class="text-danger">*</span></label>
                                                <select name="supplier_id" id="supplier_id" class="form-control select2"
                                                    required>
                                                    <option value="">Select Supplier</option>
                                                    @foreach ($Supplier as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif

                                        <div class="col-sm-12 mb-3">
                                            <label class="col-form-label" for="description">Description <span
                                                    class="text-danger">*</span></label>
                                            <textarea rows="4" id="description" class="form-control" name="description"
                                                placeholder="Description" required></textarea>
                                        </div>

                                        <div class="col-sm-6 mb-3 simple_product_div">
                                            <label class="col-form-label" for="quantity">Quantity <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" id="quantity" class="form-control simple_product_required"
                                                name="quantity" placeholder="Quantity" />
                                        </div>

                                        <div class="col-sm-6 mb-3 simple_product_div">
                                            <label class="col-form-label" for="cost_of_good">Cost of Good <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" id="cost_of_good"
                                                class="form-control simple_product_required" name="cost_of_good"
                                                placeholder="Cost of Good" required />
                                        </div>

                                        <div class="col-sm-6 mb-3 simple_product_div">
                                            <label class="col-form-label" for="retail_price">Retail Price <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" id="retail_price"
                                                class="form-control simple_product_required" name="retail_price"
                                                placeholder="Retail Price" required />
                                        </div>

                                        {{-- <div class="col-sm-6 mb-3">
                                            <label class="col-form-label" for="expected_date">Expected Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="expected_date" class="form-control flatpickr"
                                                name="expected_date" placeholder="Expected Date" required />
                                        </div>

                                        <div class="col-sm-6 mb-3">
                                            <label class="col-form-label" for="received_date">Received Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="received_date" class="form-control flatpickr"
                                                name="received_date" placeholder="Received Date" required />
                                        </div> --}}

                                        {{-- <div class="col-sm-6 mb-3">
                                            <label class="col-form-label" for="delivery_date">Delivery Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="delivery_date" class="form-control flatpickr"
                                                name="delivery_date" placeholder="Delivery Date" required />
                                        </div> --}}

                                        <div class="col-sm-12 mb-3">
                                            <label class="col-form-label" for="upload_images">Upload Images <span
                                                    class="text-danger">*</span></label>
                                            <div class="image_upload_show">

                                            </div>
                                            <input type="file" id="upload_images" class="form-control"
                                                name="upload_images[]" accept="image/*" multiple required />
                                        </div>

                                        <div class="col-sm-6 mb-3">
                                            <label class="col-form-label" for="category">Category <span
                                                    class="text-danger">*</span></label>
                                            <select name="category_id[]" class="form-control select2" multiple="multiple"
                                                required>
                                                @foreach ($Category as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <input type="hidden" id="attribute_no" value="1">
                                        
                                    </div>

                                    <div class="row attribute_div">

                                        <div class="col-sm-6 mb-3 attribute_div">
                                            <label class="col-form-label" for="attribute_id">Attributes <span
                                                    class="text-danger">*</span></label>
                                            <select name="attribute_id[]" id="attribute_id" class="form-control select2"
                                                multiple>
                                                @foreach ($Attribute as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-12 mb-3">
                                            <button type="button" class="btn btn-primary float_right"
                                                id="add_new_attribute">+ Add New Variation</button>
                                        </div>

                                    </div>

                                    <div class="row append_attribute attribute_div">

                                    </div>

                                </div>
                                <div class="card-footer">
                                    @if (auth()->user()->type == '1')
                                        <button name="product_status" type="submit" class="btn btn-primary"
                                            value="Draft">Draft</button>
                                        <button name="product_status" type="submit" class="btn btn-success"
                                            value="Publish">Publish</button>
                                    @else
                                        <button name="product_status" type="submit" class="btn btn-primary"
                                            value="Draft">Submit</button>
                                    @endif
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
                $("#products_Create").validate({
                    rules: {
                        name: {
                            remote: {
                                type: 'POST',
                                url: '{{ route('check_name_exists_in_products') }}',
                                data: {
                                    '_token': '{{ csrf_token() }}',
                                    'name': function() {
                                        return $("#name").val();
                                    }
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

                flatpickr('.flatpickr', {
                    dateFormat: "d-m-Y",
                });

                $("#product_type").change(function(e) {
                    var product_type = $(this).val();
                    if (product_type == "Variable Product") {
                        $(".simple_product_div").hide();
                        $(".simple_product_required").prop("required", false);
                        $(".simple_product_required").val("");
                        $(".attribute_div").show();
                        $("#attribute_id").prop("required", true);
                    } else {
                        $(".simple_product_div").show();
                        $(".simple_product_required").prop("required", true);
                        $(".attribute_div").hide();
                        $("#attribute_id").prop("required", false);
                    }
                    $(".select2").select2();
                });

                $("#product_type").val("Simple Product").change();

                var imagesPreview = function(input, placeToInsertImagePreview) {
                    $(".image_upload_show").empty()
                    if (input.files) {
                        var filesAmount = input.files.length;

                        for (i = 0; i < filesAmount; i++) {
                            var reader = new FileReader();

                            reader.onload = function(event) {
                                $($.parseHTML('<img class="image_pre_disp">')).attr('src', event.target.result)
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

                    var attribute_id = $("#attribute_id").val();
                    var attribute_no = $("#attribute_no").val();
                    $_token = "{{ csrf_token() }}";
                    $('.append_attribute').empty();
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
            });
        </script>
    @endpush
@endsection
