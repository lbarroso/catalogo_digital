<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerLocal extends Model
{
    use HasFactory;

    protected $table = 'customers_local';

    protected $fillable = [
        'almcnt',
        'ruta_sup',
        'nombre_sup',
        'canal',
        'ctecve',
        'encargado',
        'localidad',
        'fecha_nac',
        'rfc',
        'curp',
        'rpu',
        'sexo',
        'telefono',
        'codigo_postal',
        'fecha_pos',
        'rit',
        'capital_diconsa',
        'capital_comunit',
        'longitud',
        'latitud',
        'fecha_apertura',
    ];

    protected $casts = [
        'fecha_nac'      => 'date',
        'fecha_pos'      => 'date',
        'fecha_apertura' => 'date',
        'capital_diconsa'=> 'decimal:2',
        'capital_comunit'=> 'decimal:2',
        'longitud'       => 'decimal:8',
        'latitud'        => 'decimal:8',
    ];
    
}
