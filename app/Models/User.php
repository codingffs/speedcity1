<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Laravel\Passport\HasApiTokens;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'code',
        'name',
        'username',
        'email',
        'phone',
        'mobile_no',
        'gst_registered',
        'trading_name',
        'bank_account_name',
        'bsb',
        'account_no',
        'mailing_address',
        'address',
        'about_supplier',
        'joining_date',
        'password',
        'status',
        'type',
        'user_type',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'home_phone_code',
        'home_phone',
        'office_phone_code',
        'office_phone',
        'profile_picture',
        'gender',
        'degree',
        'specialty',
        'practice_start_date',
        'general_description',
        'birth_date',
        'hospital_address_line_1',
        'hospital_address_line_2',
        'hospital_address_town_city',
        'hospital_address_landmark',
        'hospital_address_state',
        'hospital_address_country',
        'hospital_address_pincode',
        'rating',
        'doctor_status',
        'consultation_fee_at_clinic',
        'consultation_fee_at_home',
        'registration_number',
        'doctor_cv',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->hasOne(Role::class, 'id', 'type');
    }
}
