<?php

namespace  App\Models;

use Illuminate\Database\Eloquent\Model;

class BookOrder extends Model
{

    protected $table = "book_order";
    
    protected $fillable = [
        'id',
        'pickup_address',
        'sender_name',
        'pickup_contact',
        'pickup_others',
        'delivery_address',
        'receiver_name',
        'delivery_contact',
        'delivery_others',
        'parcel_type',
        'parcel_weight',
        'total_amount',
        'status',
        'remark',
    ];
    
}
