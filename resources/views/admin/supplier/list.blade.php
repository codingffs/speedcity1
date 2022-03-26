@extends('layouts.admin.master')

@section('title')Suppliers
    {{ $title }}
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item">Suppliers </li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <!-- Feature Unable /Disable Order Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Suppliers
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data_table" class="display" id="basic-2">
                                <thead>
                                    <tr>
                                        <th>Serial Number</th>
                                        <th>Supplier Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Items</th>
                                        <th>Approval</th>
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
                ajax: {
                    url: "{{ route('suppliers') }}",
                    data: function(d) {
                        d.status = $('#select_status').val()
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('<div class="dataTables_length" id="kt_profile_overview_table_length">' +
                '<label>Status: ' +
                '<select name="kt_profile_overview_table_length select_status_box" id = "select_status" aria-controls="kt_profile_overview_table" class="select_status_box" style="width: 200px;">' +
                '<option value="all">All</option>' +
                '<option value="Pending">Pending</option>' +
                '<option value="Approve">Approve</option>' +
                '<option value="Reject">Reject</option>' +
                '</select> </label></div>').appendTo("#data_table_filter");

            $(".dataTables_filter label").addClass("pull-right");

            $(document).on('change', '.select_status_box', function() {
                var status = $(this).val();
                table.draw();
            });

            $(document).on('click', ".approve_btn", function(event) {
                swal.fire({
                    title: 'Alert',
                    text: "Are you sure approve this user!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: "btn btn-danger",
                    cancelButtonClass: "btn btn-primary",
                    confirmButtonText: 'Yes, approve it!',
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
                                _method: 'POST',
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
                            success: function(data) {
                                if (data.status == 1) {
                                    table.draw();
                                    $('body').removeAttr('class');
                                } else {
                                    return false;
                                }
                            }
                        });
                    }
                });
            });

            $(document).on('click', ".reject_btn", function(event) {
                swal.fire({
                    title: 'Alert',
                    text: "Are you sure reject this user!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: "btn btn-danger",
                    cancelButtonClass: "btn btn-primary",
                    confirmButtonText: 'Yes, reject it!',
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
                                _method: 'POST',
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
                            success: function(data) {
                                if (data.status == 1) {
                                    table.draw();
                                    $('body').removeAttr('class');
                                } else {
                                    return false;
                                }
                            }
                        });
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
