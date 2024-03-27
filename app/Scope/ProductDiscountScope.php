<?php

namespace App\Scope;

use App\Models\Product;
use Illuminate\Http\Request;
use DB;

trait ProductDiscountScope{


    public function scopeFindProductAdmin($query,Product $product){
        return $query->select(
            '*',
            DB::raw('0 as is_active')
        )->where('product_id',$product->id);
    }
}