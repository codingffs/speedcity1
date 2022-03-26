@extends('layouts.admin.master')

@section('title')Doctor 
    
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('doctor.index') }}">Doctor</a></li>
        <li class="breadcrumb-item active">Doctor Details</li>
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
                                    <h5>Doctor Details</h5>
                                    <a href="{{ route('doctor.index') }}" class="btn btn-primary float_right">Back</a>
                                </div>
                                <div class="card-body">
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="name">Name </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $doctor->name }}
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="email">Email </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $doctor->email }}
                                    </div>
                                </div>
                                
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="office_phone_code">Office Phone Code </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $doctor->office_phone_code }}
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="office_phone">Office Phone </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $doctor->office_phone }}
                                    </div>
                                </div>
                                
                                <div class="mb-3 row">
                                    @if(isset($doctor->home_phone_code))
                                    <label class="col-sm-2 col-form-label" for="home_phone_code">Home Phone Code</label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $doctor->home_phone_code }}
                                    </div>
                                    @endif
                                    @if(isset($doctor->home_phone))
                                    <label class="col-sm-2 col-form-label" for="home_phone">Home Phone</label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $doctor->home_phone }}
                                    </div>
                                    @endif
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="gender">Gender </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $doctor->gender }}
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="registration_number">Registration number </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $doctor->registration_number }}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="degree">Degree </label>
                                    <div class="col-sm-4 margin-div">:
                                        @foreach($degree as $value)
                                         {{ getDegree($value) }}
                                        @endforeach
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="specialty">Specialty </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $doctor->specialty }}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="practice_start_date">Practice Start Date </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $doctor->practice_start_date }}
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="birth_date">Birth Date </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $doctor->birth_date }}
                                    </div>
                                </div>
                                
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="hospital_address_line_1">Home Address Line 1 </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $doctor->hospital_address_line_1 }} 
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="hospital_address_line_2">Home Address Line 2 </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $doctor->hospital_address_line_2 }} 
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="hospital_address_landmark">Home Address-Landmark </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $doctor->hospital_address_landmark }}
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="hospital_address_country">Home Address-Country </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ getcountryname($doctor->hospital_address_country) }}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="hospital_address_state">Home Address-State </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ getstatename($doctor->hospital_address_state) }}
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="hospital_address_town_city">Home Address-Town/City </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ getCityname($doctor->hospital_address_town_city) }} 
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="hospital_address_pincode">Home Address-Pincode </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $doctor->hospital_address_pincode }}
                                    </div>
                                    <label class="col-sm-2 col-form-label" for="doctor_status">Status </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $doctor->doctor_status }}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="consultation_fee_at_home">Consultation Fee at home </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $doctor->consultation_fee_at_home }}
                                    </div>
                                    @if(isset($doctor->consultation_fee_at_clinic))
                                    <label class="col-sm-2 col-form-label" for="consultation_fee_at_clinic">Consultation Fee at Clinic </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $doctor->consultation_fee_at_clinic }}
                                    </div>
                                    @endif 
                                </div>
                                <div class="mb-3 row">
                                    @if(isset($doctor->rating))
                                    <label class="col-sm-2 col-form-label" for="rating">Rating </label>
                                    <div class="col-sm-4 margin-div">
                                        : {{ $doctor->rating }}
                                    </div>
                                    @endif
                                </div>
                                <div class="mb-3 row">
                                    @if(isset($doctor->general_description))
                                    <label class="col-sm-2 col-form-label" for="general_description">General Description </label>
                                    <div class="col-sm-10 margin-div">
                                        : {!! $doctor->general_description !!}
                                    </div>
                                    @endif
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="profile_picture">Profile picture </label>
                                    <div class="col-sm-4 margin-div">
                                        <img class="mt-2" src="{{ url('images/profile'.'/'.$doctor->profile_picture) }} " width="100" height="70" />
                                    </div>
                                    @if(isset($doctor->doctor_cv))
                                    <label class="col-sm-2 col-form-label" for="doctor_cv">CV </label>
                                    <div class="col-sm-4 margin-div">
                                        <img class="mt-2" src="{{ url('images/doctor_cv'.'/'.$doctor->doctor_cv) }} " width="100" height="70" />
                                    </div>
                                    @endif
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
