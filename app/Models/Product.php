<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Manipulations;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [ 
        'almcnt', 'artcve', 'artdesc', 'prvcve', 'artstatus', 'category_id', 'codbarras', 'artseccion', 'stock',  'artprcosto', 'artprventa', 'artpesogrm', 'artpesoum', 'created_at', 'updated_at',
    ];   
    
    protected function slug(): Attribute{
        return Attribute::make(
            set: fn ($value) => \Str::slug($this->name)
        );
    }
	
    // muchos productos pertenecen a una categoria
    public function category(){

        return $this->belongsTo(Category::class);
    }
	
	// conversion de media
	// cambiar tamaños de imagenes
    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();

        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

} // class
