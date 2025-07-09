<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupabaseProduct extends Model
{
    use HasFactory;
    protected $connection = 'supabase';
    protected $table = 'products';
    protected $guarded = []; // para permitir todos los campos
}
