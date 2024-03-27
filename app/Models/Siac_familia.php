<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siac_familia extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    
    // indicamos la tabla por convencionalismo
    protected $table ='familia';

    // campos llenables
    protected $fillable = ['famdesc'];

    // desactivar timestamps
    public $timestamps = false;

}
