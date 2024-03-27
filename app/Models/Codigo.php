<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Codigo extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'codigo'];

    // desactivar timestamps
    public $timestamps = false;
}
