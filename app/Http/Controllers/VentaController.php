<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Product;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        // guardar venta registrada
        $venta = new Venta();        
        $venta->fecha = now();
        $venta->ctecve = 0;
        $venta->pvtotal = 0;
        $venta->pvcash = 0;
        $venta->user_id = 0;
        $venta->pvtipopago = 0;
        $venta->save();

        // Obtener el último ID insertado
        $ultimoIdInsertado = $venta->id;        
        
        // Actualizar el stock de los productos vendidos
        $productosVendidos = $request->input('productos'); // Supongamos que es un array de productos
        foreach ($productosVendidos as $producto) {
            $productoModel = Product::find($producto['id']);
            if ($productoModel) {
                // Restar la cantidad vendida del stock
                $productoModel->stock -= $producto['cantidad'];
                $productoModel->save();
            }
        }        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show(Venta $venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venta $venta)
    {
        //
    }
}
