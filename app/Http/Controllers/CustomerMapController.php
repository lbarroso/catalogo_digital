<?php

namespace App\Http\Controllers;

use App\Models\CustomerLocal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerMapController extends Controller
{
    /**
     * Muestra el mapa de clientes georreferenciados del almacén actual.
     * Solo incluye registros con latitud y longitud válidas (no null, no 0).
     */
    public function index(Request $request)
    {
        $almcnt = (int) Auth::user()->almcnt;

        $points = CustomerLocal::query()
            ->where('almcnt', $almcnt)
            ->whereNotNull('latitud')
            ->whereNotNull('longitud')
            ->where(function ($q) {
                $q->where('latitud', '!=', 0)
                    ->where('longitud', '!=', 0);
            })
            ->select([
                'ctecve',
                'canal',
                'localidad',
                'encargado',
                'telefono',
                'nombre_sup',
                'ruta_sup',
                'latitud',
                'longitud',
            ])
            ->limit(5000)
            ->get();

        return view('admin.customers.map', [
            'almcnt' => $almcnt,
            'points' => $points,
        ]);
    }
}
