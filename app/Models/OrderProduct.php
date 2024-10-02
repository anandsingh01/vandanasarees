<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = 'order_product';

    public function productss()
    {
        return $this->belongsToMany(Product::class, 'order_product')->withPivot('quantity');
    }

}
