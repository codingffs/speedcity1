<?php

namespace  App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BookOrder extends Model
{

    protected $table = "book_order";
    
    protected $fillable = [
        'id',
        'user_id',
        'local_services',
        'pickup_address',
        'sender_name',
        'pickup_contact',
        'pickup_others',
        'delivery_address',
        'receiver_name',
        'delivery_contact',
        'delivery_others',
        'parcel_type',
        'parcel_id',
        'parcel_weight',
        'total_amount',
        'status',
        'remark',
        'type'
    ];

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForhumans();
    }

    public function getOrderStatusAttribute($value){
        $orderstatus = Orderstatus::find($value);
        return $orderstatus->title;
    }
    
}
