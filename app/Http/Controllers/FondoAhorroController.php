<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FondoAhorro;
use Barryvdh\DomPDF\Facade\Pdf;


class FondoAhorroController extends Controller
{
    public function index()
    {
        return view('fondo_ahorros.index');
    }

    public function buscar(Request $request)
    {
        $request->validate([
            'numero_expediente' => 'required|string',
        ]);

        $fondo = FondoAhorro::where('expediente', $request->numero_expediente)->first();

        return view('fondo_ahorros.index', compact('fondo'));
    }

    public function pdf($id)
    {
        $fondo = FondoAhorro::findOrFail($id);

        $pdf = PDF::loadView('fondo_ahorros.pdf', compact('fondo'));

        return $pdf->stream('Estado_de_cuenta.pdf');
    }
}
