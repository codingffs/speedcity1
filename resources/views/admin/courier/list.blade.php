@extends('layouts.admin.master')

@section('title')
Courierlist Item
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
    @endpush

    @section('content')
        @component('components.breadcrumb')
            <li class="breadcrumb-item">Courier Items </li>
        @endcomponent

        <div class="container-fluid">
            <div class="row">
                <!-- Feature Unable /Disable Order Starts-->
                <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Countries Items
                            {{-- @can('country-create') --}}
                                <a href="{{ route('Courierlist.create') }}" class="btn btn-primary float_right">Create Courier Item</a>
                            {{-- @endcan --}}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data_table" class="display" id="basic-2">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Item Name</th>
                                        <th>Option</th>
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
                ajax: "{{ route('Courierlist.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'item_name',
                        name: 'item_name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
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
                                    toastr.options =
                                    {
                                    "closeButton" : true,
                                    "progressBar" : true
                                    }
                                    toastr.success("Courierlist Deleted Successfully!");
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
