<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Empresa
 *
 * @property $id
 * @property $regnom
 * @property $regtel
 * @property $regemail
 * @property $regmun
 * @property $regloc
 * @property $regedo
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Empresa extends Model
{
    
    static $rules = [
		'regnom' => 'required',
		'regtel' => 'required', 
		'regedo' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['regnom','regtel','regemail','regmun','regloc','regedo'];



}
