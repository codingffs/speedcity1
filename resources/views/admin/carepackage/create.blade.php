@extends('layouts.admin.master')

@section('title')
Care Package Plan
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('carepackage.index') }}">Care Package Plan</a></li>
        <li class="breadcrumb-item active">Create</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="dynamicAddRemove" method="POST"
                            action="{{ route('carepackage.store') }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Create Care Package Plan</h5>
                                </div>
                                <div class="card-body">

                                @csrf
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="title">Title <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="title" class="form-control" name="title"
                                            placeholder="Title" value="{{ old('title') }}" required />
                                        @error('title')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="amount">Amount <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="number" id="amount" class="form-control" name="amount"
                                            placeholder="Amount" value="{{ old('amount') }}" required />
                                        @error('amount')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="validity">Validity(In days) <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="number" id="validity" class="form-control" name="validity"
                                            placeholder="Validity" value="{{ old('validity') }}" required />
                                        @error('validity')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row" id="plan-div">
                                    <label class="col-sm-3 col-form-label">Package Plan <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-7">
                                        <input type="text" id="field_title_0" name="field_title[0]" placeholder="Package Plan" 
                                        class="form-control" />
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('carepackage.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    @push('scripts')
    
        <script type="text/javascript">
            var i = 0;
            $("#dynamic-ar").click(function () {
            i++;
                $("#plan-div").append('<div class="row mt-2 delete-div"><label class="col-sm-3 col-form-label" for="package_plan"></label><div class="col-sm-7"><input type="text" id="field_title_'
                    + i +'" name="field_title['+ i +']" placeholder="Package Plan" class="form-control value_field" required/></div><div class="col-sm-2"><button type="button" class="btn btn-outline-danger remove-input-field"><i class="fa fa-minus"></i></button></button></div></div>');
                if(i == 1) {
                    $("#field_title_0").attr('required', true);
                }
            });
            $(document).on('click', '.remove-input-field', function () {
                $(this).parent('div').parent('div').remove();
            });
        </script>
        <script>
            $(document).ready(function() {
                
                $("#dynamicAddRemove").validate({
                    rules: {
                        title: {
                            maxlength: 50,
                            remote: {
                                type: 'get',
                                url: '{{ route('care_title_exists') }}',
                                data: {
                                    'title': function() {
                                        return $("#title").val();
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
                        }else {
                            error.insertAfter(element);
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
