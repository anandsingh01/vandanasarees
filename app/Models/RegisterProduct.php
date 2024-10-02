<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterProduct extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','attribute_id','product_added_by','brands_id','section_id','product_name',
        'msp','sumofmsp','size','price','subtotal','cartqty','user_id','ip_address','user_email','status'];

    public  function getProducts(){
        return $this->belongsTo('App\Models\Product','product_id');
    }

    public  function getColor(){
        return $this->belongsTo('App\Models\AttributeValue','color_id_attr');
    }

    public function getBrands(){
        return $this->belongsTo('App\Models\Category','brands_id')
            ->where('category_type','brands');
    }

    public function getSection(){
        return $this->belongsTo('App\Models\Category','section_id')
            ->where('category_type','section');
    }

    function getSize(){
        return $this->belongsTo('App\Models\Product_size','id');
    }



    function getVendorDetails(){
        return $this->belongsTo('App\Models\User','product_added_by');
    }

//    function getCommissionDetails(){
//        return $this->belongsTo('App\Models\ComissionModel','category_id');
//    }




}
