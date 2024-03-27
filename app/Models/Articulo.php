<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'almcnt', 'artcve', 'artdesc', 'prvcve', 'artstatus', 'category_id', 'codbarras', 'artmarca', 'artestilo', 
        'artcolor', 'artseccion', 'arttalla', 'stock', 'artimg', 'artprcosto', 'artprventa', 'artpesogrm', 'artpesoum', 
        'artganancia', 'eximin', 'eximax', 'artdetalle', 'created_at', 'updated_at',        
    ];

}

