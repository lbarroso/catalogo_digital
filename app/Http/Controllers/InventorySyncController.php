<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\SupabaseService;
use Illuminate\Support\Facades\Auth;

class InventorySyncController extends Controller
{
    protected SupabaseService $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->middleware('auth');
        $this->supabase = $supabase;
    }

    /**
     * Sincroniza inventario:
     * 1) Reset stock = 0 en Supabase
     * 2) Upsert de productos locales (sin duplicados)
     */
    public function sync(Request $request)
    {
        $almcnt = Auth::user()->almcnt;

        try {
            // 1) Resetear stock
            $this->supabase->resetStockByAlmcnt($almcnt);

            /* 2) Traer sólo un registro por artcve (el de menor id) */
            $productos = Product::where('almcnt', $almcnt)
                ->whereIn('id', function ($q) use ($almcnt) {
                    $q->selectRaw('MIN(id)')
                      ->from('products')
                      ->where('almcnt', $almcnt)
                      ->whereIn('artseccion', [1, 6])
                      ->groupBy('artcve');
                })
                ->get();

            /* 3) Construir payload con nombre de imagen */
            $payload = $productos->map(function ($p) {
                // ---- nombre de la imagen / placeholder ----
                $imageName = $p->hasMedia('images')
                    ? $p->artcve.'.'.pathinfo(
                            $p->getFirstMediaPath('images'),
                            PATHINFO_EXTENSION
                      )
                    : 'placeholder.png';

                    // productos canasta basica
                    $canastaCategoryIds = [1,2,3,4,5,7,8,9,10,11,12,13,25,32,36,37,38,40,42,43,51,62,72];
                    $categoryId = (int) $p->category_id;
                    $is_canasta_basica = in_array($categoryId, $canastaCategoryIds, true) ? 1 : 0;

                return [
                    'category_id' => $p->category_id,
                    'name'        => $p->artdesc,
                    'code'        => $p->artcve,
                    'barcode'     => $p->codbarras,
                    'description' => $p->artestilo,
                    'price'       => $p->artprventa,
                    'stock'       => $p->stock,
                    'unit'        => $p->artpesoum,
                    'is_active'   => true,
                    'external_id' => $is_canasta_basica,
                    'created_at'  => optional($p->created_at)->toIso8601String(),
                    'updated_at'  => optional($p->updated_at)->toIso8601String(),
                    'almcnt'      => $p->almcnt,
                    'image'       => $imageName,      // ← aquí va el nombre
                ];
            })->toArray();

            // 4) Upsert en Supabase
            $result = $this->supabase->upsertProducts($payload);

            return response()->json([
                'success' => true,
                'synced'  => count($payload),
                'result'  => $result,
            ]);
        } catch (\Throwable $e) {
            \Log::error("SyncInventoryError: {$e->getMessage()}", [
                'almcnt' => $almcnt,
                'exception' => $e,
            ]);

            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
