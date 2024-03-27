<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Release
 *
 * @property $id
 * @property $artcve
 * @property $almcnt
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Release extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 20;

        // desactivar timestamps
        public $timestamps = false;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['artcve','almcnt'];



}
