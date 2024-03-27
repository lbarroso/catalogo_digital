<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cliente
 *
 * @property $id
 * @property $ctenom
 * @property $cterfc
 * @property $ctecp
 * @property $ctereg
 * @property $ctedir
 * @property $cteemail
 * @property $ctetel
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Cliente extends Model
{
    
    static $rules = [
		'ctenom' => 'required',

    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['ctenom','cterfc','ctecp','ctereg','ctedir','cteemail','ctetel'];



}
