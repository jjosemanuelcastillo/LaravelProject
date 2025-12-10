<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'order_date'
    ];
    function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
}
