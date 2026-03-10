<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SupabaseService;
use App\Models\Order;
use App\Models\Articulo;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; // Importa la fachada de la librería de PDF

class OrderController extends Controller
{
    protected SupabaseService $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->middleware('auth');
        $this->supabase = $supabase;
    }

    /**
     * Dashboard principal de pedidos con filtros avanzados y análisis BI
     */
    public function index(Request $request)
    {
        // Obtener almacén del usuario autenticado
        $almcnt = auth()->user()->almcnt;

        // Construir consulta base agrupada para paginación
        $query = Order::where('almcnt', $almcnt);

        // Obtener órdenes agrupadas con paginación
        $orders = $query->select(
            'order_id',
            'ctecve',
            'ctename',
            'sync_date',
            DB::raw('COUNT(artcve) as pedida'),
            DB::raw('sync_date as ultima_compra'),
            DB::raw('SUM(doccant * artprventa) as total_ventas')
        )
        ->where('sync_date', '>=', Carbon::now()->subMonths(3))
        ->groupBy('order_id', 'ctecve', 'ctename', 'sync_date')
        ->orderBy('sync_date', 'desc');

        // Aplicar filtros específicos para consultas agrupadas
        $this->aplicarFiltrosAgrupados($orders, $request);

        // Aplicar paginación
        $orders = $orders->paginate(25);

        // Calcular KPIs principales
        // $kpis = $this->calcularKPIs($almcnt, $request);

        // Agrupar pedidos por cliente con métricas adicionales
        $orders_agrupados = $this->agruparPedidosPorCliente($orders);

        // Datos para gráfico de rentabilidad
        $chartData = $this->prepararDatosGrafico($orders_agrupados);
        $chart_labels = $chartData['chart_labels'];
        $chart_data = $chartData['chart_data'];

        // Obtener última sincronización
        $ultima_sync = Order::where('almcnt', $almcnt)
            ->orderBy('sync_date', 'desc')
            ->first()?->sync_date;

        // Verificar si es solicitud de exportación
        if ($request->get('export') === 'excel') {
            // Para exportar, necesitamos todos los registros sin paginación
            $exportQuery = Order::where('almcnt', $almcnt);
            $this->aplicarFiltros($exportQuery, $request);
            return $this->exportarExcel($exportQuery->get());
        }

        return view('admin.orders.index', compact(
            'orders',
            'orders_agrupados',
            'chart_labels',
            'chart_data',
            'ultima_sync'
        ));
    }

    /**
     * Aplicar filtros a la consulta
     */
    private function aplicarFiltros($query, Request $request)
    {
        // Filtro por rango de fechas
        if ($request->filled('fecha_desde')) {
            $query->whereDate('docfec', '>=', $request->fecha_desde);
        }
        
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('docfec', '<=', $request->fecha_hasta);
        }

        // Filtro por número de pedido
        if ($request->filled('order_id')) {
            $query->where('order_id', $request->order_id);
        }

        // Filtro por cliente (clave)
        if ($request->filled('cliente_clave')) {
            $query->where('ctecve', $request->cliente_clave);
        }

        // Filtro por nombre de cliente
        if ($request->filled('cliente_nombre')) {
            $query->where('ctename', 'like', '%' . $request->cliente_nombre . '%');
        }

        // Filtro por artículo
        if ($request->filled('articulo_clave')) {
            $query->where('artcve', $request->articulo_clave);
        }
    }

    /**
     * Aplicar filtros específicos para consultas agrupadas
     */
    private function aplicarFiltrosAgrupados($query, Request $request)
    {
        // Aplicar filtros básicos
        $this->aplicarFiltros($query, $request);

        // Filtro por rango de venta (usando HAVING para consultas agrupadas)
        if ($request->filled('rango_venta')) {
            $rango = $request->rango_venta;
            switch ($rango) {
                case '0-100':
                    $query->having('total_ventas', '>=', 0)->having('total_ventas', '<=', 100);
                    break;
                case '100-500':
                    $query->having('total_ventas', '>=', 100)->having('total_ventas', '<=', 500);
                    break;
                case '500-1000':
                    $query->having('total_ventas', '>=', 500)->having('total_ventas', '<=', 1000);
                    break;
                case '1000+':
                    $query->having('total_ventas', '>=', 1000);
                    break;
            }
        }

        // Aplicar ordenamiento para consultas agrupadas
        $orden = $request->get('ordenar', 'fecha_desc');
        switch ($orden) {
            case 'fecha_asc':
                $query->orderBy('docfec', 'asc');
                break;
            case 'venta_desc':
                $query->orderBy('total_ventas', 'desc');
                break;
            case 'venta_asc':
                $query->orderBy('total_ventas', 'asc');
                break;
            case 'cliente':
                $query->orderBy('ctename', 'asc');
                break;
            default:
                $query->orderBy('docfec', 'desc');
                break;
        }
    }

    /**
     * Calcular KPIs principales del dashboard
     */
    private function calcularKPIs($almcnt, Request $request)
    {
        // Consulta base para KPIs
        $queryKPI = Order::where('almcnt', $almcnt);
        $this->aplicarFiltros($queryKPI, $request);

        // KPIs básicos
        $total_ventas = $queryKPI->sum('importe');
        $total_pedidos = $queryKPI->count();
        $clientes_activos = $queryKPI->distinct('ctecve')->count();
        $ticket_promedio = $total_pedidos > 0 ? $total_ventas / $total_pedidos : 0;

        // KPIs avanzados para alertas
        $fechaLimite = Carbon::now()->subDays(30);
        $clientes_inactivos = Order::where('almcnt', $almcnt)
            ->where('docfec', '<', $fechaLimite)
            ->distinct('ctecve')
            ->count();

        // Simulación de productos bajo stock (ajustar según tu lógica)
        $productos_bajo_stock = Articulo::where('almcnt', $almcnt)
            ->where('stock', '<', 10)
            ->count();

        // Cliente más rentable
        $mejor_cliente = Order::where('almcnt', $almcnt)
            ->select('ctename', DB::raw('SUM(importe) as total'))
            ->groupBy('ctecve', 'ctename')
            ->orderBy('total', 'desc')
            ->first();

        return [
            'total_ventas' => $total_ventas,
            'total_pedidos' => $total_pedidos,
            'clientes_activos' => $clientes_activos,
            'ticket_promedio' => $ticket_promedio,
            'clientes_inactivos' => $clientes_inactivos,
            'productos_bajo_stock' => $productos_bajo_stock,
            'mejor_cliente' => $mejor_cliente?->ctename ?? 'N/A',
        ];
    }

    /**
     * Agregar métricas avanzadas a los pedidos agrupados
     */
    private function agruparPedidosPorCliente($pedidosAgrupados)
    {
        $almcnt = auth()->user()->almcnt;
        $resultado = [];
        
        foreach ($pedidosAgrupados as $pedido) {
            // Calcular frecuencia de compra para este cliente
            $totalPedidosCliente = Order::where('almcnt', $almcnt)
                ->where('ctecve', $pedido->ctecve)
                ->distinct('order_id')
                ->count();
            
            $primerPedido = Order::where('almcnt', $almcnt)
                ->where('ctecve', $pedido->ctecve)
                ->min('docfec');
            
            $mesesActivo = Carbon::parse($primerPedido)->diffInMonths(Carbon::now()) + 1;
            $frecuencia = $mesesActivo > 0 ? round($totalPedidosCliente / $mesesActivo, 1) : 0;

            // Calcular ticket promedio para este cliente
            $ticketPromedio = DB::table(DB::raw('(SELECT order_id, SUM(doccant * artprventa) as total_order FROM orders WHERE almcnt = ' . $almcnt . ' AND ctecve = ' . $pedido->ctecve . ' GROUP BY order_id) as pedidos_cliente'))
                ->selectRaw('AVG(total_order) as promedio')
                ->first();

            $resultado[] = [
                'order_id' => $pedido->order_id,
                'ctecve' => $pedido->ctecve,
                'ctename' => $pedido->ctename,
                'pedida' => $pedido->pedida,
                'ultima_compra' => Carbon::parse($pedido->ultima_compra)->format('d/m/Y'),
                'total_ventas' => $pedido->total_ventas,
                'frecuencia' => $frecuencia,
                'ticket_promedio' => $ticketPromedio->promedio ?? 0,
                'docfec' => $pedido->docfec,
            ];
        }

        return collect($resultado);
    }

    /**
     * Preparar datos para gráfico de rentabilidad
     */
    private function prepararDatosGrafico($orders_agrupados)
    {
        $labels = [];
        $data = [];

        foreach ($orders_agrupados->take(10) as $cliente) {
            $labels[] = substr($cliente['ctename'], 0, 20) . '...';
            $data[] = $cliente['total_ventas'];
        }

        return [
            'chart_labels' => $labels,
            'chart_data' => $data,
        ];
    }

    /**
     * Mostrar detalle de productos de un pedido específico
     */
    public function detallePedido(Request $request)
    {
        $orderId = $request->get('order_id');
        $almcnt = auth()->user()->almcnt;

        // Obtener productos del pedido ordenados por descripción
        $productos = Order::where('almcnt', $almcnt)
            ->where('order_id', $orderId)
            ->orderBy('artdesc', 'asc')
            ->get();

        if ($productos->isEmpty()) {
            return response()->json(['error' => 'Pedido no encontrado'], 404);
        }

        // Obtener información del pedido
        $infoPedido = $productos->first();
        $totalPedido = $productos->sum(function($item) {
            return $item->doccant * $item->artprventa;
        });

        return view('admin.orders.detalle-pedido', compact(
            'productos',
            'infoPedido',
            'totalPedido'
        ));
    }

    /**
     * Análisis detallado de un cliente específico
     */
    public function analisisCliente(Request $request)
    {
        $clienteId = $request->get('cliente_id');
        $almcnt = auth()->user()->almcnt;

        // Obtener datos del cliente
        $cliente = Order::where('almcnt', $almcnt)
            ->where('ctecve', $clienteId)
            ->first();

        if (!$cliente) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        // Estadísticas del cliente
        $estadisticas = Order::where('almcnt', $almcnt)
            ->where('ctecve', $clienteId)
            ->selectRaw('
                COUNT(*) as total_ordenes,
                SUM(importe) as total_gastado,
                AVG(importe) as promedio_orden,
                MAX(docfec) as ultima_compra,
                MIN(docfec) as primera_compra
            ')
            ->first();

        // Productos más comprados
        $productos_top = Order::where('almcnt', $almcnt)
            ->where('ctecve', $clienteId)
            ->select('artcve', 'artdesc', DB::raw('SUM(doccant) as total_cantidad'), DB::raw('SUM(importe) as total_importe'))
            ->groupBy('artcve', 'artdesc')
            ->orderBy('total_importe', 'desc')
            ->limit(5)
            ->get();

        // Tendencia de compras por mes
        $tendencia = Order::where('almcnt', $almcnt)
            ->where('ctecve', $clienteId)
            ->selectRaw('MONTH(docfec) as mes, YEAR(docfec) as año, SUM(importe) as total')
            ->groupBy('mes', 'año')
            ->orderBy('año', 'desc')
            ->orderBy('mes', 'desc')
            ->limit(12)
            ->get();

        return view('admin.orders.analisis-cliente', compact(
            'cliente',
            'estadisticas',
            'productos_top',
            'tendencia'
        ));
    }

    /**
     * Exportar datos a Excel
     */
    private function exportarExcel($orders)
    {
        $filename = 'pedidos_' . date('Y-m-d_H-i-s') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // Encabezados
        fputcsv($output, [
            'ID Pedido',
            'Fecha',
            'Cliente (Clave)',
            'Cliente (Nombre)',
            'Artículo (Clave)',
            'Artículo (Descripción)',
            'Cantidad',
            'Precio Unitario',
            'Importe Total',
            'Presentación'
        ]);
        
        // Datos
        foreach ($orders as $order) {
            fputcsv($output, [
                $order->order_id,
                $order->docfec,
                $order->ctecve,
                $order->ctename,
                $order->artcve,
                $order->artdesc,
                $order->doccant,
                $order->artprventa,
                $order->importe,
                $order->presentacion
            ]);
        }
        
        fclose($output);
        exit;
    }

   /**
     * Sincroniza pedidos desde Supabase al MySQL local.
     */
    public function sync(Request $r)
    {
        $almcnt = auth()->user()->almcnt;
        $rows   = $this->supabase->fetchOrdersByAlmcnt($almcnt);
        $total  = count($rows);
        // dd($rows);
        if ($total === 0) {
            return back()->with('error', 'No se encontraron pedidos para sincronizar.');
        }

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
            'artdesc'      => trim($r['product_name']), 
            'presentacion' => $r['unit'],
            'doccant'      => $r['quantity'],
            'artprventa'   => $r['unit_price'],
            'importe'      => $r['quantity'] * $r['unit_price'],
            'created_at'   => now(),
            'updated_at'   => now(),
        ], $rows);

        try {
            DB::transaction(function() use($batch) {
                Order::upsert(
                    $batch,
                    ['order_id','artcve','almcnt'],   // clave única compuesta
                    ['doccant','artprventa','importe','artdesc','docupdated','sync_date']
                );
            });

            return back()->with('success', "✅ Sincronización exitosa: $total registros actualizados.");

        } catch (\Exception $e) {
            return back()->with('error', "❌ Error en sincronización: " . $e->getMessage());
        }
    }


/**
 * Sincroniza pedidos de un cliente específico (ctecve) desde Supabase al MySQL local.
 */
public function syncByCliente(Request $r)
{
    $almcnt = auth()->user()->almcnt;
    $ctecve = $r->input('ctecve');
    $order_date = $r->input('order_date')? Carbon::parse($r->input('order_date'))->toDateString() : today()->toDateString();
    
    if (!$ctecve) {
        return back()->with('error', 'Debes seleccionar un cliente (ctecve) para sincronizar.');
    }

    // 1. Obtener datos desde Supabase filtrando por almacén y cliente
    $rows = $this->supabase->fetchOrdersByAlmcntCtecve($almcnt, $ctecve, $order_date);
    $total = count($rows);

    if ($total === 0) {
        return back()->with('error', "No se encontraron pedidos para sincronizar del cliente $ctecve.");
    }

    // 2. Mapear datos para upsert
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
        'artdesc'      => trim($r['product_name']),
        'presentacion' => $r['unit'],
        'doccant'      => $r['quantity'],
        'artprventa'   => $r['unit_price'],
        'importe'      => $r['quantity'] * $r['unit_price'],
        'created_at'   => now(),
        'updated_at'   => now(),
    ], $rows);

    try {
        DB::transaction(function () use ($batch){

            // 3.1 Upsert local
            Order::upsert(
                $batch,
                ['order_id','artcve','almcnt'], // clave única compuesta
                ['doccant','artprventa','importe','artdesc','docupdated','sync_date']
            );

        });

        return back()->with('success', "✅ Sincronización exitosa: $total registros actualizados del cliente $ctecve.");

    } catch (\Exception $e) {
        return back()->with('error', "❌ Error en sincronización: " . $e->getMessage());
    }
}

/**
 * Sincroniza pedidos de una fecha específica desde Supabase al MySQL local.
 */
public function syncByDate(Request $r)
{
    $almcnt = auth()->user()->almcnt;
    $fecha = $r->input('docfec');

    if (!$fecha) {
        return back()->with('error', 'Debes seleccionar una fecha para sincronizar.');
    }

    // 1. Obtener datos desde Supabase filtrando por almacén y fecha
    $rows = $this->supabase->fetchOrdersByAlmcntDate($almcnt, $fecha);
    $total = count($rows);

    if ($total === 0) {
        return back()->with('error', "No se encontraron pedidos para sincronizar de la fecha " . Carbon::parse($fecha)->format('d/m/Y') . ".");
    }

    // 2. Mapear datos para upsert
    $batch = array_map(fn($r) => [
        'order_id'          => $r['order_id'],
        'external_item_id'  => $r['order_item_id'],
        'docfec'            => Carbon::parse($r['order_date'])->toDateString(),
        'sync_date'         => $r['sync_date'] ? Carbon::parse($r['sync_date'])->toDateTimeString() : null,
        'almcnt'            => $r['almcnt'],
        'doccreated'        => $r['doccreated'] ? Carbon::parse($r['doccreated'])->toDateTimeString() : null,
        'docupdated'        => $r['docupdated'] ? Carbon::parse($r['docupdated'])->toDateTimeString() : null,
        'ctecve'            => $r['ctecve'],
        'ctename'           => $r['cliente_name'],
        'artcve'            => $r['code'],
        'artdesc'           => trim((string) $r['product_name']),
        'presentacion'      => $r['unit'] ?? 1,
        'doccant'           => $r['quantity'],
        'artprventa'        => $r['unit_price'],
        'importe'           => $r['quantity'] * $r['unit_price'],
        'created_at'        => now(),
        'updated_at'        => now(),
    ], $rows);

    try {
        DB::transaction(function () use ($batch){

            // 3.1 Upsert local
            Order::upsert(
                $batch,
                ['external_item_id'],
                [
                    'docfec',
                    'sync_date',
                    'almcnt',
                    'doccreated',
                    'docupdated',
                    'ctecve',
                    'ctename',
                    'artcve',
                    'artdesc',
                    'presentacion',
                    'doccant',
                    'artprventa',
                    'importe',
                    'updated_at',
                ]
            );

        });

        return back()->with('success', "✅ Sincronización exitosa: $total registros actualizados de la fecha " . Carbon::parse($fecha)->format('d/m/Y') . ".");

    } catch (\Exception $e) {
        return back()->with('error', "❌ Error en sincronización: " . $e->getMessage());
    }
} // syncByDate



    public function detallePdf(Request $request)
    {
        // Obtener el ID del pedido y el almacén del usuario autenticado
        $orderId = $request->get('order_id');
        $almcnt = auth()->user()->almcnt;

        // Buscar los productos del pedido por order_id y almcnt
        /*
        $productos = Order::where('almcnt', $almcnt)
            ->where('order_id', $orderId)
            ->orderBy('artdesc', 'asc') // Ordenar los productos por descripción
            ->get();
        */

        $productos = Order::query()
            ->select([
                'orders.order_id',
                'orders.docfec',
                'orders.sync_date',
                'orders.almcnt',
                'orders.ctecve',
                'orders.ctename',
                'products.category_id',
                'orders.artcve',
                'orders.artdesc',
                'orders.doccant',
                'orders.presentacion',
                'orders.artprventa',
                'orders.importe',
            ])
            ->leftJoin('products', function ($join) {
                $join->on('orders.artcve', '=', 'products.artcve')
                    ->on('orders.almcnt', '=', 'products.almcnt');
            })
            ->where('orders.almcnt', $almcnt)
            ->where('orders.order_id', $orderId)
            ->groupBy('orders.id')
            ->orderBy('products.category_id')
            ->get();

        // Si no se encuentran productos, devolver un error 404
        if ($productos->isEmpty()) {
            return response()->json(['error' => 'Pedido no encontrado'], 404);
        }

        // Obtener información general del pedido del primer producto
        $infoPedido = $productos->first();

        // Calcular el total del pedido sumando el precio * cantidad de cada producto
        $totalPedido = $productos->sum(function($item) {
            return $item->doccant * $item->artprventa;
        });

        // Cargar la vista Blade que servirá de plantilla para el PDF
        // 'pdf.detalle-pedido' debe ser el nombre de tu vista
        $pdf = PDF::loadView('admin/orders/detalle-pedido-pdf', compact(
            'productos',
            'infoPedido',
            'totalPedido'
        ));

        // Descargar el PDF con un nombre de archivo específico
        return $pdf->download("detalle_pedido_{$orderId}.pdf");
    }

} // class
