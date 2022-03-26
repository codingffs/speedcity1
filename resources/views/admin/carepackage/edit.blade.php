@extends('layouts.admin.master')

@section('title')
Care Package Plan
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('carepackage.index') }}">Care Package Plan</a></li>
        <li class="breadcrumb-item active">Edit</li>
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="theme-form" id="carepackage_edit" method="POST"
                            action="{{ route('carepackage.update', $carepackage->id) }}" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Edit Care Package Plan</h5>
                                </div>
                                <div class="card-body">

                                    @csrf
                                    @method('PATCH')
                                    <meta name="csrf-token" content="{{ csrf_token() }}">

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="title">Title <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="hidden" name="id" id="id" value="{{ $carepackage->id }}"/>
                                            <input type="text" id="title" class="form-control" name="title"
                                                placeholder="Title" value="{{ old('title', $carepackage->title) }}" required />
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
                                                placeholder="Amount" value="{{ old('amount', $carepackage->amount) }}" required />
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
                                                placeholder="Validity" value="{{ old('amount', $carepackage->validity) }}" required />
                                            @error('validity')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    @if($packageplan != '[]')
                                    <div class="mb-3 row" id="plan-div">
                                        <input type = "hidden" name="total_package" id="total_package" value="{{ count($packageplan) }}">
                                        @foreach($packageplan as $key => $value)
                                        <div class="mb-2 row mt-2 delete-div">
                                            <label class="col-sm-3 col-form-label">{{ ($key == 0) ? "Package Plan" : ''}} </label>
                                            <div class="col-sm-7">
                                                <input type="hidden" name="field_id[{{ $key }}]" id="field_id" value="{{ $value->id }}"/>
                                                <input type="text" id="field_title_{{ $key }}" name="field_title[{{ $key }}]" placeholder="Package Plan" 
                                                class="form-control" value="{{ $value->title }}" required/>
                                            </div>
                                            @if($key == 0)
                                            <div class="col-sm-2">
                                                <button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                            @else
                                            <div class="col-sm-2">
                                                <button data-id="{{ $value->id }}" type="button" class="btn btn-outline-danger delete-plan">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                    @elseif($packageplan == '[]')
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
                                    @endif
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
    
    @push('scripts')
    <script type="text/javascript">
        var i = $("#total_package").val();
        $("#dynamic-ar").click(function () {
            $("#plan-div").append('<div class="mb-2 row mt-2 delete-div"><label class="col-sm-3 col-form-label" for="package_plan"></label><div class="col-sm-7"><input type="text" id="field_title_'+ i +'" name="field_title['
                + i +']" placeholder="Package Plan" class="form-control" required/></div><div class="col-sm-2"><button type="button" class="btn btn-outline-danger remove-input-field"><i class="fa fa-minus"></i></button></div></div>');
            i++;
        });
        $(document).on('click', '.remove-input-field', function () {
            $(this).parent('div').parent('div').remove();
        });
        
    </script>
        <script>
            $(document).ready(function() {
                $(document).on('click', '.delete-plan', function(){
                    var id = $(this).data("id");
                    var csrf_token = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "POST",
                        url: "{{ route('remove_added_package') }}",
                        data: {
                            "id": id,
                            "_token": csrf_token
                        },
                        cache: false,
                        success: function (data) {
                            console.log(data);
                        }
                    });
                    $(this).parent('div').parent('div').remove();
                });

                $("#carepackage_edit").validate({
                    rules: {
                        title: {
                            maxlength: 50,
                            remote: {
                                type: 'get',
                                url: '{{ route('care_title_exists_update') }}',
                                data: {
                                    'id': function() {
                                        return $('#id').val();
                                    },
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
                        } else if(element.attr("type") == "number") {
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
