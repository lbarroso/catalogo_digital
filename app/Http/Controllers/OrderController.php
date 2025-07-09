<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SupabaseService;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    protected SupabaseService $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->middleware('auth');
        $this->supabase = $supabase;
    }

    /**
     * Muestra el listado de pedidos y botón de sincronización.
     */
    public function index()
    {
        // 1️⃣ Obtengo el almacén del usuario autenticado
        $almcnt = auth()->user()->almcnt;

        // 2️⃣ Filtro primero por almacén, luego ordeno y pagino
        $orders = Order::where('almcnt', $almcnt)
                    ->orderByDesc('docfec')
                    ->paginate(25);

        // 3️⃣ Paso la colección a la vista
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Sincroniza pedidos desde Supabase al MySQL local.
     */
    public function sync(Request $r)
    {
        $almcnt = auth()->user()->almcnt;
        $rows   = $this->supabase->fetchOrdersByAlmcnt($almcnt);
        $total  = count($rows);

        // Mapear y upsert en bloque
        $batch = array_map(fn($r) => [
            'order_id'     => $r['id'],
            'docfec'       => Carbon::parse($r['order_date'])->toDateTimeString(),
            'sync_date'    => Carbon::parse($r['sync_date'])->toDateTimeString(),
            'almcnt'       => $r['almcnt'],
            'doccreated'   => Carbon::parse($r['doccreated'])->toDateTimeString(),
            'docupdated'   => Carbon::parse($r['docupdated'])->toDateTimeString(),
            'ctecve'       => $r['ctecve'],
            'ctename'      => $r['cliente_name'],
            'artcve'       => $r['code'],
            'artdesc'      => $r['product_name'],
            'presentacion' => $r['unit'],
            'doccant'      => $r['quantity'],
            'artprventa'   => $r['unit_price'],
            'importe'      => $r['quantity'] * $r['unit_price'],
            'created_at'   => now(),
            'updated_at'   => now(),
        ], $rows);

        DB::transaction(function() use($batch) {
            Order::upsert(
                $batch,
                ['order_id','artcve','almcnt'],   // clave única compuesta
                ['doccant','artprventa','importe',
                 'artdesc','docupdated','sync_date']
            );
        });

        return back()->with('success', "Sincronizados $total artículos de pedido.");
    }
}
