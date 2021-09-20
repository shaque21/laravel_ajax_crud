<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['product_name','procate_id'];

    public function product_category(){
        return $this->belongsTo('App\Models\ProductCategory','procate_id','id');
    }
}
