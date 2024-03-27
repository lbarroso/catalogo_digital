<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Docdeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PvproductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $docord = !empty($request->docord) ? $request->docord : 0;
        
        if($request->ajax()){
            return response()->json(['data' => Docdeta::where('movcve', 51)
                ->where('user_id', Auth::user()->id)
                ->where('docord', $docord)
                ->get()
            ]);
        }
        
        return view('pventa.index');
    } // index

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
        
        $codigo = trim($request->codigo);
                
        $resultado = DB::select(" SELECT p.id, p.artcve, p.codbarras, p.artdesc, p.artpesoum, p.artpesogrm, p.artprcosto, p.artprventa
        FROM products p
        LEFT JOIN codigos c ON p.id = c.product_id
        WHERE (p.id ='$codigo' OR p.artcve ='$codigo' OR p.codbarras = '$codigo') OR  c.codigo ='$codigo' LIMIT 1 ");

        $product = count($resultado) > 0 ? (object) $resultado[0] : false;

        // guardar datos en db        
        if($product)
        {
            $docdeta = new Docdeta();        
            $docdeta->product_id = $product->id;
            $docdeta->artcve = !empty($product->artcve) ? $product->artcve : false;
            $docdeta->codbarras = !empty($product->codbarras) ? $product->codbarras : false;
            $docdeta->artdesc = !empty($product->artdesc) ? $product->artdesc : false;
            $docdeta->artpesoum = !empty($product->artpesoum) ? $product->artpesoum : false;
            $docdeta->artpesogrm = !empty($product->artpesogrm) ? $product->artpesogrm : false;
            $docdeta->artprcosto = !empty($product->artprcosto) ? $product->artprcosto : 0;
            $docdeta->artprventa = !empty($product->artprventa) ? $product->artprventa : 0;
            $docdeta->docimporte = !empty($product->artprventa) ? $product->artprventa : 0;
            $docdeta->user_id = Auth::user()->id;
            // $docdeta->docsession = $sesionActual['_token'];
            $docdeta->save();
        }elseif($codigo[0] == '+'){
            $docdeta = new Docdeta();
            $docdeta->artdesc = "PRODUCTO SIN DESCRIPCION";
            $docdeta->artprventa = $codigo;
            $docdeta->user_id = Auth::user()->id;
            $docdeta->save();
        }
        
        return false;
        
    } // store

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        
        // Busca el registro por su ID
        $docdeta = Docdeta::find($request->id);
        return response()->json($docdeta);
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
    public function update(Request $request)
    {
        
        $docdeta = Docdeta::find($request->id);
        $docimporte = $request->input('doccant') * $docdeta->artprventa;
        $docdeta->update([
            'doccant' => $request->input('doccant'),
            'docimporte' =>  $docimporte
        ]);

        return response()->json(['success'=>'Producto Guardado']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {   
        
        $docdeta = Docdeta::find($request->id);

        $docdeta->delete();

        return response()->json(['success'=>'Producto eliminado']);

    }
}
