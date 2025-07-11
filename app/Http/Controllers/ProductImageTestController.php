<?php
// app/Http/Controllers/ProductImageTestController.php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;

class ProductImageTestController extends Controller
{
    public function index()
    {
        $productos = Product::with('media')->where('almcnt',2039)->where('stock','>',0)->get();

        return view('products.productos-imagenes', compact('productos'));
    }


    public function exportToCsv()
    {

        $user =  Auth::user();

        $productos = \App\Models\Product::with('media')
        ->where('almcnt', $user->almcnt)
        ->where('stock', '>', 0)
        ->get();

        $filename = 'productos_supabase_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = [
            'id', 'category_id', 'name', 'code', 'barcode', 'description',
            'price', 'stock', 'unit', 'is_active', 'external_id',
            'created_at', 'updated_at', 'almcnt', 'image'
        ];

        $callback = function () use ($productos, $columns) {
            $output = fopen('php://output', 'w');

            // Agregar BOM para compatibilidad con Excel y UTF-8
            fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($output, $columns);

            foreach ($productos as $p) {


                fputcsv($output, [
                    $p->id,
                    $p->category_id,
                    $p->artdesc,
                    $p->artcve,
                    $p->codbarras,
                    $p->artdesc,
                    $p->artprventa,
                    $p->stock,
                    $p->artpesoum,
                    1, // is_active
                    $p->id, // external_id
                    date('Y-m-d'),
                    date('Y-m-d'),
                    $p->almcnt,
                    $image
                ]);
            }

            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }

}
