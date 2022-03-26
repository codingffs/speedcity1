@extends('layouts.admin.master')

@section('title')City 
    
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('city.index') }}">City</a></li>
        <li class="breadcrumb-item active">Create</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="city_Create" method="POST" action="{{ route('city.store') }}"
                            enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Create City</h5>
                                </div>
                                <div class="card-body">

                                    @csrf
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="sortname">State Name <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <select name="state_id" id="state_id" class="form-control" required >
                                                @foreach($state as $states)
                                                <option value="{{ $states->state_id }}">{{ $states->state_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('state_id')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="city_name">City Name <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="city_name" class="form-control" name="city_name"
                                                placeholder="City Name" value="{{ old('city_name') }}" required />
                                            @error('city_name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('city.index') }}" class="btn btn-secondary">Cancel</a>
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
                $("#city_Create").validate({ 
                    rules: {
                        city_name: {
                            maxlength: 90,
                            remote: {
                                type: 'get',
                                url: '{{ route('check_city_exists_in_state') }}',
                                data: {
                                    'state_id': function() {
                                        return $("#state_id").val();
                                    },
                                    'city_name': function() {
                                        return $("#city_name").val();
                                    }
                                },
                                dataFilter: function(data) {
                                var json = JSON.parse(data);
                                if (json.status == 1) {
                                    return "\"" + json.message + "\"";
                                } 
                                else {
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
