@extends('layouts.admin.master')

@section('title')Local Package 
    
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('doctor.index') }}">Local Package</a></li>
        <li class="breadcrumb-item active">Local Package Details</li>
    @endcomponent
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div> 
   @endif
   
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Local Package Details</h5>
                                    <a href="{{ route('localPackage.index') }}" class="btn btn-primary float_right">Back</a>
                                </div>
                                <div class="card-body">
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="itemsID">Items Name </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ getItemName($localPackage->itemsID) }}
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="source_address">Source Address </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $localPackage->source_address }}
                                    </div>
                                </div>
                                
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="destination_address">Destination Address </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $localPackage->destination_address }}
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="city">City </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $localPackage->city }}
                                    </div>
                                </div>
                                
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="state">State</label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $localPackage->state }}
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="zip_code">Zip Code</label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $localPackage->zip_code }}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="distance">Distance </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $localPackage->distance }}
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="price_per_km">price(km) </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $localPackage->price_per_km }}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="notes">Notes </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $localPackage->notes }}
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    @push('scripts')
    
        <script type="text/javascript">
           
            function fileimgValidation() {
                $(document).find(".file_error").remove();
                var fileInput = document.getElementById('profile_picture');
                var filePath = fileInput.value;
                
                if(filePath != null){
                    // Allowing file type
                    var allowedExtensions = /(\.jpg|\.png|\.jpeg)$/i;
                    if (!allowedExtensions.exec(filePath)) {
                        $('#profile_picture').parent('div').append("<span class='file_error text-danger'>Valid FIle Type: jpg,png,jpeg</span>");
                    fileInput.value = '';
                    return false;
                }
                }
            }
            function filecvValidation() {
                $(document).find(".file_error").remove();
                var fileInput = document.getElementById('doctor_cv');
                var filePath = fileInput.value;
                
                if(filePath != null){
                    // Allowing file type
                    var allowedExtensions = /(\.jpg|\.pdf|\.docx|\.jpeg)$/i;
                    if (!allowedExtensions.exec(filePath)) {
                        $('#doctor_cv').parent('div').append("<span class='file_error text-danger'>Valid FIle Type: jpg,pdf,docx,jpeg</span>");
                    fileInput.value = '';
                    return false;
                }
                }
            }
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();

            today = yyyy + '-' + mm + '-' + dd;
            $('#birth_date').attr('max',today);
            $('#practice_start_date').attr('min',today);
        </script>
        {{-- country,city,state --}}
    <script>
    $('#hospital_address_state').append('<option value="">Select Country First</option>');
        $('#hospital_address_country').change(function(){
            var cid = $(this).val();
            var url = '{{ route("getStates", "id") }}';
            url = url.replace('id', cid);
            
        if(cid){
        $.ajax({
           type:"get",
           url: url,
           success:function(res)
           {       
                if(res)
                {
                    $("#hospital_address_state").empty();
                    $("#hospital_address_town_city").empty();
                    $("#hospital_address_state").append('<option selected disabled>Select State</option>');
                    $.each(res,function(key,value){
                        $("#hospital_address_state").append('<option value="'+key+'">'+value+'</option>');
                    });
                    $('#hospital_address_town_city').append('<option value="">Select State First</option>');
                }
           }
        });
        }
    });
    $('#hospital_address_state').change(function(){
        var sid = $(this).val();
        var url = '{{ route("getCities", "id") }}';
        url = url.replace('id', sid);    
        if(sid){
        $.ajax({
           type:"get",
           url: url,
           dataType : 'json',
           success:function(res)
           {       
                if(res)
                {
                    $("#hospital_address_town_city").empty();
                    $("#hospital_address_town_city").remove(".city_select")
                    $("#hospital_address_town_city").append('<option selected disabled>Select City</option>');
                    $.each(res,function(key,value){
                        $("#hospital_address_town_city").append('<option value="'+key+'">'+value+'</option>');
                    });
                }
           }
        });
        }
    }); 
    </script>
        
    @endpush
@endsection
