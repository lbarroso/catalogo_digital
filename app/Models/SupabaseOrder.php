<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupabaseOrder extends Model
{
    use HasFactory;
    protected $connection = 'supabase';
    protected $table = 'orders';    
}
