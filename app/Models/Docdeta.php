<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Docdeta extends Model
{
    use HasFactory;
    
    protected $table = 'docdetas';

    protected $fillable = [ 'docmes', 'docord', 'artcve', 'codbarras', 'artdesc', 'artprcosto', 'artdescto',
        'artprventa', 'docimporte', 'artpesogrm', 'artpesoum', 'artganancia', 'doccant', 'docstatus', 'docsession', 'numberid', 'user_id', 'uuid'
    ];  

}
