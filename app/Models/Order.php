<?php

// app/Models/Order.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_id','docfec','sync_date','almcnt',
        'doccreated','docupdated',
        'ctecve','ctename',
        'artcve','artdesc','presentacion',
        'doccant','artprventa','importe',
    ];
}
