@extends('layouts.admin.master')

@section('title')
Doctor 
@endsection

@push('css')
@endpush

@section('content')
    @component('components.breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('doctor.index') }}">Doctor</a></li>
        <li class="breadcrumb-item active">Create</li>
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
                        <form class="theme-form" id="user_Create" method="POST" action="{{ route('doctor.store') }}"
                            enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Create Doctor</h5>
                                </div>
                                <div class="card-body">

                                    @csrf
                            
                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="name">Name <span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="text" id="name" class="form-control" name="name"
                                                placeholder="Name" value="{{ old('name') }}" required />
                                            @error('name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <label class="col-sm-2 col-form-label" for="email">Email <span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="email" id="email" class="form-control" name="email"
                                                placeholder="Email" value="{{ old('email') }}" required />
                                            @error('email')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="office_phone_code">Office Phone Code <span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="text" id="office_phone_code" class="form-control" name="office_phone_code"
                                            placeholder="Office Phone Code" value="{{ old('office_phone_code') }}" required />
                                            @error('office_phone_code')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <label class="col-sm-2 col-form-label" for="office_phone">Office Phone <span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="number" id="office_phone" class="form-control" name="office_phone"
                                            placeholder="Office Phone" value="{{ old('office_phone') }}" required />
                                            @error('office_phone')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="home_phone_code">Home Phone Code</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="home_phone_code" class="form-control" name="home_phone_code"
                                                placeholder="Home Phone Code" value="{{ old('home_phone_code') }}" />
                                            @error('home_phone_code')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <label class="col-sm-2 col-form-label" for="home_phone">Home Phone</label>
                                        <div class="col-sm-4">
                                            <input type="number" id="home_phone" class="form-control" name="home_phone"
                                                placeholder="Home Phone" value="{{ old('home_phone') }}" />
                                            @error('home_phone')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="gender">Gender <span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <select name="gender" id="gender" class="form-control" required>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label" for="registration_number">Registration number <span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="number" id="registration_number" class="form-control" name="registration_number"
                                            placeholder="Registration number" value="{{ old('registration_number') }}" required />
                                            @error('registration_number')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="degree">Degree <span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <select name="degree[]" id="degree" class="form-control" multiple="multiple" required >
                                                @foreach($degree as $degre)
                                                <option value="{{ $degre->id }}">{{ $degre->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label" for="specialty">Specialty <span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <select name="specialty[]" id="specialty" class="form-control" multiple="multiple" required>
                                                <option value="Dentist">Dentist</option>
                                                <option value="Pain_Specialist">Pain Specialist</option>
                                                <option value="ms">MS</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="practice_start_date">Practice Start Date <span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="date" id="practice_start_date" class="form-control" name="practice_start_date"
                                                placeholder="Practice Start Date" value="{{ old('practice_start_date') }}" required />
                                            @error('practice_start_date')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <label class="col-sm-2 col-form-label" for="birth_date">Birth Date <span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="date" id="birth_date" class="form-control" name="birth_date"
                                                placeholder="Birth Date" value="{{ old('birth_date') }}" required />
                                            @error('birth_date')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="profile_picture">Profile picture <span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="file" id="profile_picture" class="form-control" name="profile_picture"
                                            placeholder="Profile picture" value="{{ old('profile_picture') }}" onchange="fileimgValidation()" required />
                                            @error('profile_picture')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <label class="col-sm-2 col-form-label" for="doctor_cv">CV </label>
                                        <div class="col-sm-4">
                                            <input type="file" id="doctor_cv" class="form-control" name="doctor_cv"
                                                placeholder="CV" value="{{ old('doctor_cv') }}" onchange="filecvValidation()"/>
                                            @error('doctor_cv')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="hospital_address_line_1">Home Address Line 1 <span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <textarea name="hospital_address_line_1" id="hospital_address_line_1" class="form-control" placeholder="House, Building, Company, Apartment" required></textarea>
                                            @error('hospital_address_line_1')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <label class="col-sm-2 col-form-label" for="hospital_address_line_2">Home Address Line 2 <span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <textarea name="hospital_address_line_2" id="hospital_address_line_2" class="form-control" placeholder="Area, Colony, Sector, Village" required></textarea>
                                            @error('address')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="hospital_address_landmark">Home Address-Landmark <span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="text" id="hospital_address_landmark" class="form-control" name="hospital_address_landmark"
                                                placeholder="Landmark" value="{{ old('hospital_address_landmark') }}" required />
                                            @error('hospital_address_landmark')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <label class="col-sm-2 col-form-label" for="hospital_address_country">Home Address-Country <span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <select name="hospital_address_country" id="hospital_address_country" class="form-control" required>
                                                <option selected disabled>Select Country</option>
                                                @foreach($country as $countrys)
                                                <option value="{{ $countrys->country_id }}">{{ $countrys->country_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('hospital_address_country')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="hospital_address_state">Home Address-State <span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <select name="hospital_address_state" id="hospital_address_state" class="form-control" required>
                                            </select>
                                            @error('hospital_address_state')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <label class="col-sm-2 col-form-label" for="hospital_address_town_city">Home Address-Town/City <span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <select name="hospital_address_town_city" id="hospital_address_town_city" class="form-control" required>
                                                <option class="city_select" selected disabled>Select State First</option>
                                            </select>
                                            @error('hospital_address_town_city')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="hospital_address_pincode">Home Address-Pincode <span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="number" id="hospital_address_pincode" class="form-control" name="hospital_address_pincode"
                                                placeholder="Pincode" value="{{ old('hospital_address_pincode') }}" required />
                                            @error('hospital_address_pincode')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <label class="col-sm-2 col-form-label" for="doctor_status">Status <span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <select name="doctor_status" id="doctor_status" class="form-control" required>
                                                <option value="" selected disabled>Select Status</option>
                                                <option value="Onboarding">Onboarding</option>
                                                <option value="Active">Active</option>
                                                <option value="On Hold">On Hold</option>
                                                <option value="Inactive">Inactive</option>
                                                <option value="Retired">Retired</option>
                                            </select>
                                            @error('doctor_status')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="consultation_fee_at_home">Consultation Fee at home <span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="number" id="consultation_fee_at_home" class="form-control" name="consultation_fee_at_home"
                                                placeholder="Consultation Fee at home" value="{{ old('consultation_fee_at_home') }}" required />
                                            @error('consultation_fee_at_home')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <label class="col-sm-2 col-form-label" for="consultation_fee_at_clinic">Consultation Fee at Clinic </label>
                                        <div class="col-sm-4">
                                            <input type="number" id="consultation_fee_at_clinic" class="form-control" name="consultation_fee_at_clinic"
                                                placeholder="Consultation Fee at Clinic" value="{{ old('consultation_fee_at_clinic') }}" />
                                            @error('consultation_fee_at_clinic')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        
                                        <label class="col-sm-2 col-form-label" for="rating">Rating </label>
                                        <div class="col-sm-10">
                                            <input type="number" id="rating" class="form-control" name="rating"
                                                placeholder="Rating" value="{{ old('rating') }}" />
                                            @error('rating')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="general_description">General Description </label>
                                        <div class="col-sm-10">
                                            <textarea name="general_description" id="general_description" class="form-control" placeholder="General Description" ></textarea>
                                            @error('general_description')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('doctor.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    
        <script type="text/javascript">
            $(document).ready(function() {
                CKEDITOR.replace('general_description');

                $("#user_Create").validate({ 
                    rules: {
                        office_phone:{
                            required: true,
                            number: true,
                            minlength: 10,
                            maxlength: 10
                        },
                        home_phone:{
                            number: true,
                            minlength: 10,
                            maxlength: 10
                        },
                        consultation_fee_at_home:{
                            required: true,
                            number: true,
                        },
                        consultation_fee_at_clinic:{
                            number: true,
                        },
                        email: {
                            maxlength: 90,
                            remote: {
                                type: 'get',
                                url: '{{ route('check_email_exists_in_users') }}',
                                data: {
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
                });
            });
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
