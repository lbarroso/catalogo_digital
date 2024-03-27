<?php

namespace App\Scope;

use Illuminate\Http\Request;

trait CategoryScope{


    public function scopeSearch($query,Request $request){

        return $query->where('name','like',"%$request->search%");
    }
}