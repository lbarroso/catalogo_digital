<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Release;
use App\Models\Empresa;
use App\Service\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Excel;
use App\Exports\PosicionExport;
use App\Exports\CatalogoExport;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user =  Auth::user();
        
        if($request->ajax()){
            // ordenar por categoria ASC   
            // y stock mayor a 0
            // y almcnt del usuario autenticado
            // y con relacion a categoria            
            return response()->json(['data' => Product::with('category')->Where('almcnt',$user->almcnt)->Where('stock','>',0)->orderBy('category_id')->get()]);
        }

        return view('products.index');        
    }


    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ProductService $service)
    {
        $validator = $service->validationStore($request);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->all()],400);
        }        

        //
        $data = $request->all();

        Product::create($data);

        return response()->json(['success'=>'Producto Guardado']);        
    }

    /**
     * agregar nuevo producto
     *
     * forma personalizada
     * 
     */    
    public function productStore(Request $request)
    {

        //
        $reglas = [
            'artdesc' => 'required|max:255',
            'category_id' => 'required'
            
        ];
        $request->validate($reglas);

        // dd($request);
        $data = $request->all();

        Product::create($data);
        
        // regresar
        return redirect()->route('products.index')->with('success', 'Nuevo producto agregado correctamente');
    } // productStore

    /**
     * formulario 
     *
     * agregar nuevo producto
     * 
     */    
    public function productCreate()
    {

        return view('products.formcreate');

    } // productCreate   


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->all();

        $product->update($data);

        return response()->json(['success'=>'Producto Guardado']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();

        return response()->json(['success'=>'Producto eliminado']);        
    }

    /**
     * listado categorias llamada desde product.js
     */
    public function categories(){
        return response()->json(Category::orderBy('name')->get());
    }

    /**
     * codigo barras duplicado
     */
    public function existeCodigo($codbarras)
    {
        
        if(strlen($codbarras) == 0 || $codbarras == ' ') return false;
        /*
        $productoExistente = Product::where('codbarras', $codbarras)->exists();

        if ($productoExistente) {
            return "El código '$codbarras' ya existe en otro producto. <br>";
        } else return false;
        */
        return false;

    }

    /**
     * producto duplicado
     */
    public function existeProducto($artdesc)
    {
        
        if($artdesc == ' ' || strlen($artdesc) == 0) return 'Debe escribir la descripción del producto.';
        /*
        $productoExistente = Product::where('artdesc', $artdesc)->exists();

        if ($productoExistente) {
            return "El producto '$artdesc' ya existe en otro producto.";
            
        } else return false;
        */
        return false;
        
    }


    /**
     * form product validate
     */
    public function productValidate(Request $request)
    {
        // request from view products/formcreate
        $error = $this->existeCodigo(trim($request->codbarras));        
        $error .= $this->existeProducto(trim($request->artdesc));                
        $error .= ((float)$request->artprcosto > (float)$request->artprventa) ?  'El precio de costo No puede ser mayor que de venta' : false;
        if($error == false) echo 'success';
        else echo $error;

    } // function
    
    // reporte posicion excel
    public function posicionExport()    
    {
        date_default_timezone_set('America/Mexico_City');
        $fecha  = date('Y-m-d\TH:i:s');
        return Excel::download(new PosicionExport, 'posicionAlmacen'.$fecha.'.xls');
        // return (new PosicionExport)->download('PosicionExport.csv', Excel::CSV, ['Content-Type' => 'text/csv']);
        // return (new posicionExport)->store('invoices.xlsx', 's3');
        // return new CatalogoExport();
    }
    

    

    // vista reportes diarios
    function reportsDiarios()
    {
        $user =  Auth::user();

        $tiposInventarios = Product::where('almcnt',$user->almcnt)->orderBy('artseccion','ASC')->distinct()->pluck('artseccion');

        return view('reports.diarios', compact('tiposInventarios') );
    }    

    // vista reportes diarios
    function reportsDescendente()
    {
        return view('reports.inventarios');
    }        
    

    // catalogo pdf
    public function downloadDompdf(Request $request)
    {
        $user =  Auth::user();

        date_default_timezone_set('America/Mexico_City');

        $fecha  = date('d-m-Y\TH:i:s');

        $tipoinv = $request->input('artseccion');

        $artprventa = $request->input('artprventa');

        $empresa = Empresa::find($user->almcnt);

        // productos
        $products = Product::select('products.artcve', 'products.artprventa', 'products.artseccion', 'products.artdesc', 'products.artpesoum', 'products.stock', 'media.id', \DB::raw('media.name AS image'), 'categories.name')
        ->leftJoin('media', 'products.id', '=', 'media.model_id')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->where('products.artstatus', 'A')
        ->where('almcnt', $user->almcnt)
        ->where('stock', '>', 0)
        ->where('artseccion', $tipoinv)
        ->orderBy('products.category_id')
        ->orderBy('products.artcve')
        ->groupBy('products.artcve') // Agrupar por products.artcve para evitar duplicados
        ->get();
        
        // categorias
        $categories = Product::select('name')        
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->where('stock', '>', 0)
        ->where('almcnt', $user->almcnt)
        ->where('artseccion', $tipoinv)
        ->orderBy('categories.name')
        ->distinct()
        ->get();    

        // novedades
        $releases = Product::query()
        ->from('products as p')
        ->select([        
        'p.artcve',
        'p.artdesc',
        'p.artpesoum',
        'm.file_name',
        'm.id',
        ])
        ->join('media as m', function ($join) {
        $join->on('m.id', '=', DB::raw("(
            SELECT m2.id
            FROM media m2
            WHERE m2.model_type = 'App\\\\Models\\\\Product'
            AND m2.model_id   = p.id
            ORDER BY m2.id DESC
            LIMIT 1
        )"));
        })
        ->where('p.almcnt', $user->almcnt)
        ->where('p.artestilo', 'oferta')
        ->orderBy('p.category_id', 'asc')
        ->get();
                
        $pdf = Pdf::loadView('pdf.catalogo',['products' => $products, 'categories' => $categories, 'empresa'=>$empresa, 'releases'=>$releases, 'artprventa' =>$artprventa ]);

        return $pdf->stream('CatalogoDigital'.$fecha.'.pdf');
    }

   // cenefas
   public function cenefas(Request $request)
   {
        $user =  Auth::user();
        $tipoinv = 1;

        $tiposInventarios = Product::where('almcnt',$user->almcnt)->orderBy('artseccion')->distinct()->pluck('artseccion');

        // categorias
        $categories = Product::select('name','categories.id')        
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->where('stock', '>', 0)
        ->where('almcnt', $user->almcnt)
        ->where('artseccion', $tipoinv)
        ->orderBy('categories.name',)
        ->distinct()
        ->get();    
        
        return view('reports.cenefas', compact('categories','tiposInventarios'));
   }


    // cenefas con precio con tipo de inventario
    public function cenefasEtiquetaPrecio(Request $request)
    {
        $user = Auth::user();
        $fecha = date('d-m-Y\TH:i:s');
        
        // Configuración de la base de datos
        $config = [
            'driver' => 'pgsql',
            'host' => $user->ip,
            'port' => 5432,
            'database' => 'siac',
            'username' => 'gpsdiconsa',
            'password' => 'Gp5D1con54',
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
        ];   

        // Establecer la configuración de la base de datos
        Config::set('database.connections.pgsql', $config);

        // Conexión a la base de datos SIAC (PostgreSQL)
        $products = DB::connection('pgsql')->select("
            SELECT
                a.artdesc,
                a.artcve,
                ah.artmed,
                ah.artgms,
                ROUND(
                    (
                        (ah.artprcventa * ah.artiva     / 100) +
                        (ah.artprcventa * ah.artiepsvta / 100) +
                        ah.artprcventa
                    ) / ah.artcap,
                    2
                ) AS pieza
            FROM articulos a
            INNER JOIN arthist ah
                ON a.artcve = ah.artcve
            INNER JOIN articul1 a1
                ON a1.artcve  = ah.artcve
            AND a1.invhist = ah.arthist
            WHERE a.artstatus = 'A' AND invtpoinv = :invtpoinv
            AND a1.invmes = EXTRACT(MONTH FROM CURRENT_DATE)
            AND (
                    ((a1.inviniuni + a1.inventuni - a1.invsaluni) * ah.artcap) +
                    (a1.invinires + a1.inventres - a1.invsalres)
                ) > 0
            ORDER BY
                a.famcve,
                a.artcve,
                a1.invtpoinv,
                a1.invhist DESC; ", ['invtpoinv' => $request->artseccion]);
        
        // Convertir el arreglo de resultados en una colección de Laravel
        $products = collect($products);  // Convertimos el resultado en una colección        

        // Generar el PDF con los productos
        $pdf = Pdf::loadView('pdf.cenefas-factura', ['products' => $products]);

        // Retornar el PDF para su descarga
        return $pdf->stream('CenefasConPrecio' . $fecha . '.pdf');  
    }


   // cenefas
   public function cenefasBlanco(Request $request)
   {
 
       $pdf = Pdf::loadView('pdf.cenefa');

       return $pdf->stream('CenefasBlanco.pdf');
   }



    /**
     * Genera y descarga el catálogo en PDF.
     */
    public function descargarCatalogoPdf(Request $request)
    {
        // 1) Parámetros base
        $almcnt          = $request->input('almcnt', 2039);      // 2039 por defecto
        $mostrarPrecios  = $request->boolean('precios', false);  // ¿mostrar precio?
        $empresa         = Empresa::findOrFail($almcnt);
        $fechaFile       = now('America/Mexico_City')->format('d-m-Y_His');

        /* 2) Productos (Eloquent + relationships) */
        $products = Product::with(['media:id,model_id,name', 'category:id,name'])
            ->select('id','category_id','artcve','artprventa','artseccion',
                     'artdesc','artpesoum','stock')
            ->where([
                ['almcnt',  $almcnt],
                ['artstatus','A'],
            ])
            ->where('stock','>',0)
            ->orderBy('category_id')
            ->orderBy('artcve')
            ->get();

        /* 3) Categorías únicas derivadas de la colección anterior  */
        $categories = $products->pluck('category.name')->unique()->sort()->values();

        /* 4) Productos “novedad” (relación Release → Product) */
        $releases = Product::query()
            ->from('products as p')
            ->select([
                'p.id',
                'p.artcve',
                'p.artdesc',
                'p.artpesoum',
                'm.file_name',
            ])
            ->join('media as m', function ($join) {
                $join->on('m.id', '=', DB::raw("(
                    SELECT m2.id
                    FROM media m2
                    WHERE m2.model_type = 'App\\\\Models\\\\Product'
                    AND m2.model_id   = p.id
                    ORDER BY m2.id DESC
                    LIMIT 1
                )"));
            })
            ->where('p.almcnt', $almcnt)
            ->where('p.artestilo', 'oferta')
            ->orderBy('p.category_id', 'asc')
            ->get();

        /* 5) Render-PDF */
        $pdf = Pdf::loadView(
            'pdf.catalogo',
            compact('products','categories','releases','empresa','mostrarPrecios')
        )->setPaper('letter','portrait');

        return $pdf->stream("CatalogoDigital-{$fechaFile}.pdf");
    }

    // ============== MÉTODOS PARA PRODUCTOS EN OFERTA ==============

    /**
     * Mostrar productos en oferta
     * 
     * @return \Illuminate\Http\Response
     */
    public function productosOferta()
    {
        $user = Auth::user();
        
        // Obtener productos en oferta del almacén del usuario autenticado
        $productos = Product::with(['media', 'category'])
            ->where('almcnt', $user->almcnt)
            ->where('artestilo', 'oferta')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('products.productos-oferta', compact('productos'));
    }

    /**
     * Agregar producto a oferta por clave (artcve)
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function agregarProductoOferta(Request $request)
    {
        $request->validate([
            'artcve' => 'required|string|max:50'
        ]);

        $user = Auth::user();
        $artcve = trim($request->artcve);

        try {
            // Buscar el producto por clave en el almacén del usuario
            $producto = Product::where('artcve', $artcve)
                ->where('almcnt', $user->almcnt)
                ->first();

            if (!$producto) {
                return response()->json([
                    'success' => false,
                    'message' => "No se encontró un producto con la clave '{$artcve}' en este almacén."
                ], 404);
            }

            // Verificar si ya está en oferta
            if ($producto->artestilo === 'oferta') {
                return response()->json([
                    'success' => false,
                    'message' => "El producto '{$producto->artdesc}' ya está en oferta."
                ], 400);
            }

            // Actualizar el campo artestilo a 'oferta'
            $producto->update(['artestilo' => 'oferta']);

            return response()->json([
                'success' => true,
                'message' => "Producto '{$producto->artdesc}' agregado exitosamente a ofertas.",
                'producto' => [
                    'id' => $producto->id,
                    'artcve' => $producto->artcve,
                    'artdesc' => $producto->artdesc,
                    'artprventa' => $producto->artprventa
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor. Inténtalo nuevamente.'
            ], 500);
        }
    }

    /**
     * Eliminar producto de oferta
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function eliminarProductoOferta(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:products,id'
        ]);

        $user = Auth::user();

        try {
            // Buscar el producto por ID en el almacén del usuario
            $producto = Product::where('id', $request->id)
                ->where('almcnt', $user->almcnt)
                ->where('artestilo', 'oferta')
                ->first();

            if (!$producto) {
                return response()->json([
                    'success' => false,
                    'message' => 'Producto no encontrado en ofertas.'
                ], 404);
            }

            // Actualizar el campo artestilo a 'producto'
            $producto->update(['artestilo' => 'producto']);

            return response()->json([
                'success' => true,
                'message' => "Producto '{$producto->artdesc}' eliminado exitosamente de ofertas."
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor. Inténtalo nuevamente.'
            ], 500);
        }
    }

    /**
     * Buscar producto por clave para vista previa (opcional)
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function buscarProductoPorClave(Request $request)
    {
        $request->validate([
            'artcve' => 'required|string|max:50'
        ]);

        $user = Auth::user();
        $artcve = trim($request->artcve);

        $producto = Product::with(['media', 'category'])
            ->where('artcve', $artcve)
            ->where('almcnt', $user->almcnt)
            ->first();

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => "No se encontró un producto con la clave '{$artcve}'."
            ], 404);
        }

        return response()->json([
            'success' => true,
            'producto' => [
                'id' => $producto->id,
                'artcve' => $producto->artcve,
                'artdesc' => $producto->artdesc,
                'artprventa' => $producto->artprventa,
                'stock' => $producto->stock,
                'artestilo' => $producto->artestilo,
                'categoria' => $producto->category->name ?? 'Sin categoría',
                'imagen' => $producto->getFirstMediaUrl('images', 'thumb')
            ]
        ]);
    }

} // class
