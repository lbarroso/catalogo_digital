<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siac_articulo extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = 'articulos';
    public $timestamps = false;
}
