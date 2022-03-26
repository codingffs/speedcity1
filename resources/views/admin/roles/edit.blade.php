@extends('layouts.admin.master')

@section('title')Roles
   
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
        <li class="breadcrumb-item active">Edit</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="roles_Edit" method="POST"
                            action="{{ route('roles.update', $Role->id) }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Edit Role</h5>
                                </div>
                                <div class="card-body">

                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="name">Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="name" class="form-control" name="name"
                                                placeholder="Name" value="{{ old('name', $Role->name) }}" required />
                                            @error('name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="permission_checkbox">Select All</label>
                                        <div class="col-sm-9">
                                            <input type="checkbox" id="permission_checkbox" class="m-2" />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Permission</label>
                                        <div class="col-sm-9">
                                            <div class="row">
                                                @foreach ($permission as $value)

                                                    <div class="col-md-3">
                                                        <label for="permission_{{ $value->id }}"><input type="checkbox"
                                                                id="permission_{{ $value->id }}"
                                                                class="m-2 permission_checkbox" name="permission[]"
                                                                value="{{ $value->id }}"
                                                                {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}
                                                                {{ in_array($value->id, old('permission') ?: []) ? 'checked' : '' }} />{{ $value->name }}</label>
                                                    </div>

                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
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
                $("#roles_Edit").validate({
                    errorPlacement: function(error, element) {
                        if (element.attr("name") == "discount_type") {
                            error.appendTo(element.parent("div").parent("div").parent('div'));
                        } else {
                            error.insertAfter(element);
                        }
                    }
                });

                $("#permission_checkbox").change(function() {

                    if ($(this).prop('checked') == true) {
                        $('.permission_checkbox').prop('checked', true);
                    } else {
                        $('.permission_checkbox').prop('checked', false);
                    }
                });

                flatpickr('.flatpickr', {
                    dateFormat: "d-m-Y",
                });
            });
        </script>
    @endpush
@endsection
