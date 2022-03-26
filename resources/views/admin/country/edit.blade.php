@extends('layouts.admin.master')

@section('title')Country 
   
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('country.index') }}">Country</a></li>
        <li class="breadcrumb-item active">Edit</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="country_Edit" method="POST" action="{{ route('country.update', $Country->country_id) }}"
                            enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Edit Country</h5>
                                </div>
                                <div class="card-body">

                                    @csrf
                                    @method('PATCH')

                                    <div class="mb-3 row">
                                        <input name="country_id" id="country_id" type="hidden" value="{{ $Country->country_id }}"/>
                                        <label class="col-sm-3 col-form-label" for="country_name">Country Name <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="country_name" class="form-control" name="country_name"
                                                placeholder="Country Name" value="{{ $Country->country_name }}" />
                                            @error('country_name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="sortname">Sortname <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="sortname" class="form-control" name="sortname"
                                                placeholder="Sortname" value="{{ $Country->sortname }}" required />
                                            @error('sortname')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('country.index') }}" class="btn btn-secondary">Cancel</a>
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
                $("#country_Edit").validate({
                    rules: {
                        country_name: {
                            required: true,
                            maxlength: 50,
                            remote: {
                                type: 'get',
                                url: '{{ route('check_country_exists_update') }}',
                                data: {
                                    'country_id': function() {
                                        return $('#country_id').val();
                                    },
                                    'country_name': function() {
                                        return $("#country_name").val();
                                    }
                                },
                                dataFilter: function(data) {
                                    var json = JSON.parse(data);
                                    if (json.status == 1) {
                                        return "\"" + json.message + "\"";
                                    } else {
                                        return 'true';
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
            });
        </script>
    @endpush
@endsection
