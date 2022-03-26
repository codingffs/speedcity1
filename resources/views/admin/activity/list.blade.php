@extends('layouts.admin.master')

@section('title')Activity Log
    {{ $title }}
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item">Activity Log </li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <!-- Feature Unable /Disable Order Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Activity Log
                        </h5>
                    </div>

                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="">Start Date</label>
                                <input type="text" name="start_date" id="start_date"
                                    class="form-control flatpickr activity_filter">
                            </div>

                            <div class="col-md-3">
                                <label for="">End Date</label>
                                <input type="text" name="end_date" id="end_date"
                                    class="form-control flatpickr activity_filter">
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data_table" class="display" id="basic-2">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Subject</th>
                                        <th>Action By</th>
                                        <th>Date</th>
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
                    url: "{{ route('activity_log') }}",
                    data: function(d) {
                        d.start_date = $('#start_date').val(),
                        d.end_date = $('#end_date').val()
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'subject',
                        name: 'subject'
                    },
                    {
                        data: 'action_by',
                        name: 'action_by'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                ]
            });

            $('.activity_filter').change(function() {
                table.draw();
            });

            var startpicker =  flatpickr('#start_date', {
                dateFormat: "Y-m-d",
                maxDate: $('#end_date').attr('value'),
                onClose: function(selectedDates, dateStr, instance) {
                    endpicker.set('minDate', dateStr);
                },
            });
            
            var endpicker =  flatpickr('#end_date', {
                dateFormat: "Y-m-d",
                minDate: $('#start_date').attr('value'),
                onClose: function(selectedDates, dateStr, instance) {
                    startpicker.set('maxDate', dateStr);
                },
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
