<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ImageController extends Controller
{
    public function table(Product $product){

        $images = $product->getMedia('images')->values()->all();

        return response()->json($images);
    }


    public function store(Request $request){

        $request->validate([
            'image' => 'required|image',
            'is_first_image' => 'required',
            'product_id' => 'required'
        ]);


        $product = Product::findOrFail($request->product_id);

        if($request->is_first_image){
            $medias = $product->getMedia('images',['first' => true]);

            if(count($medias) > 0){
                foreach ($medias as $key => $media) {
                    $media->forgetCustomProperty('first');
                    $media->save();
                }
            }

            $product->addMedia($request->file('image'))
            ->withCustomProperties(['first' => true])
            ->toMediaCollection('images');


        }else{
            $product->addMedia($request->file('image'))->toMediaCollection('images');
        }

        return response()->json(['success' => 'Se ha guarado correctamente']);

    }


    public function destroy(Media $image){

        if($image->hasCustomProperty('first')){
            $image->delete();
            $product = Product::find(request()->product_id);

            $media = $product->getMedia('images')->first();

            if($media){
                $media->setCustomProperty('first',true);
                $media->save();
            }

        }else{
            $image->delete();
        }
    }
}
