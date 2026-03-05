<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductResetController extends Controller
{
    /**
     * Elimina todos los productos y sus imágenes (MediaLibrary) del almacén
     * del usuario autenticado. Solo usa Auth::user()->almcnt (nunca request).
     */
    public function resetByCurrentAlmcnt(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Debe iniciar sesión para realizar esta acción.');
        }

        $user = Auth::user();
        $almcnt = $user->almcnt;

        if ($almcnt === null || $almcnt === '') {
            return redirect()->back()
                ->with('error', 'No se pudo determinar el almacén del usuario.');
        }

        $deleted = 0;

        try {
            DB::transaction(function () use ($almcnt, &$deleted) {
                Product::where('almcnt', $almcnt)
                    ->chunkById(100, function ($products) use (&$deleted) {
                        foreach ($products as $product) {
                            $product->clearMediaCollection('images');
                            $product->delete();
                            $deleted++;
                        }
                    });
            });
            // UPDATE empresas set regleyenda = null WHERE id=2011;
            Empresa::where('id', $almcnt)->update(['regleyenda' => null]);
            
        } catch (\Throwable $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar productos: ' . $e->getMessage());
        }

        return redirect()->back()
            ->with('success', "Se eliminaron {$deleted} productos e imágenes del almacén {$almcnt}.");
    }
}
