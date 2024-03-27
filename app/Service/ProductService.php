<?php

namespace App\Service;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductService{


    public function validationStore(Request $request){
        $validator = Validator::make($request->all(),[
            'artdesc' => [
                'required',
                Rule::unique('products')
            ],
                        
            'artprventa' => 'required',
            'category_id' => 'required',
        ]);

        return $validator;
    }

}