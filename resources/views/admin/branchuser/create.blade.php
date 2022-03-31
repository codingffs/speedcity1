@extends('layouts.admin.master')

@section('title')
Branch User
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('branchuser.index') }}">Branch User</a></li>
        <li class="breadcrumb-item active">Create</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="branchuser_Create" method="POST"
                            action="{{ route('branchuser.store') }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Create Branch User</h5>
                                </div>
                                <div class="card-body">

                                @csrf
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="title">Branch Name <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="branch_name" class="form-control" name="branch_name"
                                            placeholder="Branch Name" value="{{ old('branch_name') }}" required />
                                        @error('branch_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="name">User Name <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="name" class="form-control" name="name" placeholder="User Name" value="{{ old('name') }}" required />
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
                                            placeholder="Mobile" required {{ old('mobile') }} />
                                        @error('mobile')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="silvicultural_requirements">Silvicultural Requirements</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="silvicultural_requirements" class="form-control" name="silvicultural_requirements"
                                            placeholder="silvicultural_requirements" required {{ old('silvicultural_requirements') }} />
                                        @error('silvicultural_requirements')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> --}}
                                {{-- <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="species_description">Species Description</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="species_description" class="form-control" name="species_description"
                                            placeholder="species_description" required {{ old('species_description') }} />
                                        @error('species_description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> --}}
                                {{-- <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="utility">Utility</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="utility" class="form-control" name="utility"
                                            placeholder="utility" required {{ old('utility') }}/>
                                        @error('utility')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="image">Image</label>
                                    <div class="col-sm-9">
                                        <input type="file" id="image" class="form-control" name="image"
                                        placeholder="image" value="{{ old('image') }}" required />                                       
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
                $("#branchuser_Create").validate({
                    errorPlacement: function(error, element) {
                        if (element.attr("type") == "text") {
                            error.appendTo(element.parent("div"));
                        }else {
                            error.insertAfter(element);
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
