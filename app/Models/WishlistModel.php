<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishlistModel extends Model
{
    use HasFactory;

    protected $table = 'wishlists';

    function product(){
        return $this->hasMany('\App\Models\Product','id');
    }
}
