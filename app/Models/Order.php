<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'first_name',
        'last_name',
        'company',
        'country',
        'address1',
        'address2',
        'city',
        'state',
        'postcode',
        'phone',
        'email',
        'notes',
        'payment_method',
        'subtotal',
        'shipping_fee',
        'coupon_price',
        'total',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
