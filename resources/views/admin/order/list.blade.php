@extends('layouts.admin.master')

@section('title')
Orders
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item">Orders </li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <!-- Feature Unable /Disable Order Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Orders
                                {{-- <a href="{{ route('localPackage.create') }}" class="btn btn-primary float_right">Create
                                    Order</a> --}}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data_table" class="display" id="basic-2">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User ID</th>
                                        <th>Local Services</th>
                                        <th>Pickup Address</th>
                                        <th>Sender Name</th>
                                        <th>Delivery Address</th>
                                        <th>Receiver Name</th>
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
                processing: true,
                serverSide: true,
                ajax: "{{ route('orders.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'user_id',
                        name: 'user_id'
                    },
                    {
                        data: 'local_services',
                        name: 'local_services'
                    },
                    {
                        data: 'pickup_address',
                        name: 'pickup_address'
                    },
                    {
                        data: 'sender_name',
                        name: 'sender_name'
                    },
                    {
                        data: 'delivery_address',
                        name: 'delivery_address'
                    },
                    {
                        data: 'receiver_name',
                        name: 'receiver_name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // $(document).on('click', ".delete_btn", function(event) {
            //     swal.fire({
            //         title: 'Are you sure?',
            //         text: "You won't be able to revert this!",
            //         icon: 'warning',
            //         showCancelButton: true,
            //         confirmButtonClass: "btn btn-danger",
            //         cancelButtonClass: "btn btn-primary",
            //         confirmButtonText: 'Yes, delete it!',
            //         inputValidator: (value) => {
            //             if (!value) {
            //                 return 'You need to write something!'
            //             }
            //         }
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //             var url = $(this).attr('data-url');
            //             var token = '<?php echo csrf_token(); ?>';
            //             $.ajax({
            //                 type: 'POST',
            //                 url: url,
            //                 data: {
            //                     _token: token,
            //                     _method: 'DELETE',
            //                 },
            //                 success: function(data) {
            //                     if (data.status == 1) {
            //                         table.draw();
            //                         toastr.options =
            //                         {
            //                         "closeButton" : true,
            //                         "progressBar" : true
            //                         }
            //                         toastr.success("Order Deleted Successfully!");
            //                     } else {
            //                         return false;
            //                     }
            //                 }
            //             });
            //         }
            //     });
            // });

        });
    </script>
@endpush
