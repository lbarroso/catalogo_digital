<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siac_arthist extends Model
{
    use HasFactory;

    use HasFactory;
    protected $connection ='pgsql';
    protected $table ='arthist';
    public $timestamps = false;

}
