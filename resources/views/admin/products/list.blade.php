@extends('layouts.admin.master')

@section('title')
    Products
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item">Products </li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <!-- Feature Unable /Disable Order Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Products
                            @can('product-create')
                                <a href="{{ route('products.create') }}" class="btn btn-primary float_right">Create Product</a>
                            @endcan
                        </h5>
                    </div>

                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-2">
                                <select name="category" id="category" class="form-control select2 product_filter">
                                    <option value="">Select Category</option>
                                    @foreach ($Category as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <select name="sort_by" id="sort_by" class="form-control select2 product_filter">
                                    <option value="">Select Sort By Date</option>
                                    <option value="asc">Ascending</option>
                                    <option value="desc">Descending</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <select name="status" id="status" class="form-control select2 product_filter">
                                    <option value="">All</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Approve">Approve</option>
                                    <option value="Reject">Reject</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data_table" class="display" id="basic-2">
                                <thead>
                                    <tr>
                                        <th>Number</th>
                                        <th>SKU</th>
                                        <th>Name</th>
                                        <th>Cost</th>
                                        <th>Retail</th>
                                        <th>Quantity</th>
                                        <th>Supplier</th>
                                        <th>Barcode</th>
                                        <th>Category</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Sync</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Feature Unable /Disable Ends-->
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            var table = $('#data_table').DataTable({
                aaSorting: [],
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('products') }}",
                    data: function(d) {
                        d.category = $('#category').val(),
                        d.sort_by = $('#sort_by').val(),
                        d.status = $('#status').val()
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'sku',
                        name: 'sku'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'cost_of_good',
                        name: 'cost_of_good'
                    },
                    {
                        data: 'retail_price',
                        name: 'retail_price'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'supplier_name',
                        name: 'supplier_name'
                    },
                    {
                        data: 'barcode',
                        name: 'barcode'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'sync',
                        name: 'sync'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('.product_filter').change(function() {
                table.draw();
            });

            $(document).on("change", ".status", function() {
                var status = $(this).val();
                var id = $(this).find(':selected').data('id');

                $.ajax({
                    type: "POST",
                    url: "{{ route('products_change_status') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "status": status,
                        "id": id
                    },
                    beforeSend: function() {
                        $('body').waitMe({
                            effect: 'bounce',
                            text: '',
                            bg: 'rgba(255, 255, 255, 0.7)',
                            color: '#000',
                            maxSize: '',
                            waitTime: -1,
                            textPos: 'vertical',
                            fontSize: '',
                            source: '',
                            onClose: function() {}
                        });
                    },
                    success: function(response) {
                        if (response.status == 1) {
                            $('body').removeAttr('class');
                            table.draw();
                        }
                    }
                });

            });

            $(document).on('click', ".delete_btn", function(event) {
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
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
                        var url = $(this).attr('data-url');
                        var token = '<?php echo csrf_token(); ?>';
                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: {
                                _token: token,
                                _method: 'DELETE',
                            },
                            success: function(data) {
                                if (data.status == 1) {
                                    table.draw();
                                } else {
                                    return false;
                                }
                            }
                        });
                    }
                });
            });

        });
    </script>
@endpush
