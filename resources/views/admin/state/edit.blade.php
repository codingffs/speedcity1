@extends('layouts.admin.master')

@section('title')State 
   
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('state.index') }}">State</a></li>
        <li class="breadcrumb-item active">Edit</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="state_Edit" method="POST" action="{{ route('state.update', $State->state_id) }}"
                            enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Edit State</h5>
                                </div>
                                <div class="card-body">

                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-3 row">
                                        <input name="state_id" id="state_id" type="hidden" value="{{ $State->state_id }}"/>
                                        <label class="col-sm-3 col-form-label" for="sortname">Country Name <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <select name="country_id" id="country_id" class="form-control" required >
                                                @foreach($country as $countrys)
                                                <option value="{{ $countrys->country_id }}" {{ isset($State->country_id) && $State->country_id == $countrys->country_id ? 'selected' : ''}}>{{ $countrys->country_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('country_id')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="state_name">State Name <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="state_name" class="form-control" name="state_name"
                                                placeholder="state Name" value="{{ $State->state_name }}" required />
                                            @error('state_name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('state.index') }}" class="btn btn-secondary">Cancel</a>
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
                $("#state_Edit").validate({
                    rules: {
                    state_name: {
                            maxlength: 90,
                            remote: {
                                type: 'get',
                                url: '{{ route('check_state_exists_in_update') }}',
                                data: {
                                    'country_id': function() {
                                        return $("#country_id").val();
                                    },
                                    'state_id': function() {
                                        return $("#state_id").val();
                                    },
                                    'state_name': function() {
                                        return $("#state_name").val();
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
                });
            });
        </script>
    @endpush
@endsection
