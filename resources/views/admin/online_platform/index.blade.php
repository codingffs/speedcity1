@extends('layouts.admin.master')

@section('title')
    Sync Platform
@endsection

@push('css')
    <style>

    </style>
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('online_platform') }}">Sync Platform</a></li>
        <li class="breadcrumb-item active">Create</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="online_platform_Create" method="POST"
                            action="{{ route('online_platform.store') }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Sync Platform</h5>
                                </div>
                                <div class="card-body">

                                    @csrf

                                    <div class="mb-3 row">
                                        <label class="col-md-3" for="all_checkbox"
                                            style="text-align: right">All</label>
                                        <div class="col-sm-9">
                                            @php
                                                $all_checked = '';
                                                if (!empty($OnlinePlatform)) {
                                                    if ($OnlinePlatform->shopify == 1 && $OnlinePlatform->facebook == 1 && $OnlinePlatform->instagram == 1) {
                                                        $all_checked = 'checked';
                                                    }
                                                }
                                            @endphp
                                            <div class="form-check form-switch">
                                                <input type="checkbox" id="all_checkbox" role="switch" class="form-check-input" name="all_checkbox" value="1"
                                                    {{ $all_checked }} />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3" for="shopify">
                                            Shopify</label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input checkbox_check" role="switch"
                                                    id="shopify" name="shopify" value="1"
                                                    {{ !empty($OnlinePlatform) && $OnlinePlatform->shopify == 1 ? 'checked' : '' }} />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3" for="facebook">
                                            Facebook</label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input checkbox_check" role="switch" id="facebook" name="facebook"
                                                value="1"
                                                {{ !empty($OnlinePlatform) && $OnlinePlatform->facebook == 1 ? 'checked' : '' }} />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3" for="instagram">
                                            Instagram</label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input checkbox_check" role="switch" id="instagram" name="instagram"
                                                value="1"
                                                {{ !empty($OnlinePlatform) && $OnlinePlatform->instagram == 1 ? 'checked' : '' }} />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-sm-12">
                                            <input type="checkbox" id="po_for_individual" name="po_for_individual" value="1"
                                                {{ !empty($OnlinePlatform) && $OnlinePlatform->po_for_individual == 1 ? 'checked' : '' }} />
                                            <label for="po_for_individual">Create PO for individual items approved.</label>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-sm-12">
                                            <input type="checkbox" id="po_for_supplier" name="po_for_supplier" value="1"
                                                {{ !empty($OnlinePlatform) && $OnlinePlatform->po_for_supplier == 1 ? 'checked' : '' }} />
                                            <label for="po_for_supplier">Create PO one supplier for the items approved
                                                today.</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
                $("#permission_Create").validate({
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

                $("#all_checkbox").change(function(e) {
                    all_checkbox();
                });

                function all_checkbox() {
                    if ($("#all_checkbox").prop('checked') == true) {
                        $(".checkbox_check").prop("checked", true);
                    } else {
                        $(".checkbox_check").prop("checked", false);
                    }
                }
            });
        </script>
    @endpush
@endsection
