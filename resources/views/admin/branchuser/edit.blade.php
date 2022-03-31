@extends('layouts.admin.master')

@section('title')
Branch User
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('branchuser.index') }}">Branch User</a></li>
        <li class="breadcrumb-item active">Edit</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="branchuser_edit" method="POST"
                            action="{{ route('branchuser.update', $BranchUser->id) }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Edit Branch User</h5>
                                </div>
                                @csrf
                                @method('PATCH')
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="title">Branch Name <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            {{-- <input type="text" id="branch_name" class="form-control" name="branch_name"
                                                placeholder="Branch Name" value="{{ old('branch_name', $BranchUser->branch_name) }}" required /> --}}
                                                <select name="branch_name" id="branch_name" class="form-control" required >
                                                    @foreach($branch as $value)
                                                    <option value="{{ $value->id }}" {{ isset($BranchUser->id) && $BranchUser->id == $value->id ? 'selected' : ''}}>{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            @error('branch_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <input type="hidden" id="id" value="{{ $BranchUser->id }}" name="id"/>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="email">Email <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="email" id="email" class="form-control" name="email"
                                                placeholder="Email" value="{{ old('email',$BranchUser->email) }}" required />
                                            @error('email')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="name">User Name <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="name" class="form-control" name="name" placeholder="User Name" value="{{ old('name', $BranchUser->name) }}" required />
                                            @error('name')
                                                <div class="text-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                   
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="mobile">Mobile No</label>
                                        <div class="col-sm-9">
                                            <input type="number" id="mobile" class="form-control" name="mobile"
                                                placeholder="Mobile" required value="{{ old('mobile', $BranchUser->mobile) }}" />
                                            @error('mobile')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    {{-- <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="silvicultural_requirements">Silvicultural Requirements</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="silvicultural_requirements" class="form-control" name="silvicultural_requirements"
                                                placeholder="silvicultural_requirements" required value="{{ old('silvicultural_requirements', $Species->silvicultural_requirements) }}" required/>
                                            @error('silvicultural_requirements')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="species_description">Species Description</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="species_description" class="form-control" name="species_description"
                                                placeholder="species_description" required value="{{ old('species_description', $Species->species_description) }}" required />
                                            @error('species_description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="utility">Utility</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="utility" class="form-control" name="utility"
                                                placeholder="utility" required value="{{ old('utility', $Species->utility) }}" required/>
                                            @error('utility')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="image">Image</label>
                                        <div class="col-sm-9">
                                            <input type="file" id="image" class="form-control" name="image"
                                            placeholder="image" value="{{ old('image', $BranchUser->image) }}" />                                        
                                            <img src="{{ asset('/branchuser'.'/'.$BranchUser->image) }}" width="100px" />
                                            @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
    
                                    </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('branchuser.index') }}" class="btn btn-secondary">Cancel</a>
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
                $("#branchuser_edit").validate({
                    rules: {
                        mobile: {
                            number: true,
                            minlength: 10,
                            maxlength: 10,
                            required: true
                        },
                        email: {
                            maxlength: 90,
                            remote: {
                                type: 'get',
                                url: '{{ route('check_email_exists_in_update') }}',
                                data: {
                                    'id': function() {
                                        return $("#id").val();
                                    },
                                    'email': function() {
                                        return $("#email").val();
                                    }
                                },
                                dataFilter: function(data) {
                                    var json = JSON.parse(data);
                                    if (json.status == 0) {
                                        return "\"" + json.message + "\"";
                                    } else {
                                        return 'true';
                                    }
                                }
                            }
                        },
                    },
                    errorPlacement: function(error, element) {
                        if (element.attr("type") == "text") {
                            error.appendTo(element.parent("div"));

                        } else {
                            error.insertAfter(element);
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
