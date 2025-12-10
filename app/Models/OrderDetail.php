<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details'; // tu tabla
    protected $fillable = ['order_id', 'product_id', 'cantity', 'price'];
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id'); // Asegúrate de que 'product_id' sea la columna correcta
    }
}
