<?php

// app/Http/Controllers/SupabaseProductController.php
namespace App\Http\Controllers;

use App\Models\SupabaseProduct;

class SupabaseProductController extends Controller
{
    public function index()
    {
        $productos = SupabaseProduct::orderBy('name')->get();

        return view('supabase.products.index', compact('productos'));
    }
}