<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    
    protected $fillable = ['pvfecha', 'ctecve', 'pvtotal', 'pvcash', 'pvtipopago', 'user_id', 'uuid', 'pvstatus'];
    
}
