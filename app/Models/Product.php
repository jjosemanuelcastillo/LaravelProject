<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image_url',
        'stock_quantity',
        'category_id',
        'supplier_id',
    ];

    use HasFactory;
    public function orderDetails()
    {
        return $this->hasMany(orderDetails::class, 'product_id');
    }
}
