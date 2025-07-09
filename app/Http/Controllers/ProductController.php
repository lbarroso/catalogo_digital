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
            return response()->json(['data' => Product::with('category')->Where('almcnt',$user->almcnt)->Where('stock','>',0)->get()]);
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
        $releases = DB::select(" SELECT releases.artcve, products.artdesc, products.artpesoum, products.artprventa, products.artseccion, products.stock, categories.name, media.file_name, media.id
        FROM releases
        INNER JOIN products ON products.artcve = releases.artcve AND products.almcnt = releases.almcnt
        INNER JOIN categories ON products.category_id = categories.id
        INNER JOIN media ON products.id = media.model_id
        WHERE releases.almcnt =".$user->almcnt);        
        
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

    // cenefas con precio
    public function cenefasEtiquetaPrecio(Request $request)
    {
        $user = Auth::user();

        // Establecer la zona horaria
        date_default_timezone_set('America/Mexico_City');
    
        // Obtener la fecha actual
        $fecha = date('d-m-Y\TH:i:s');
    
        // Validar la entrada
        $request->validate([
            'category_id' => 'required|integer'
        ]);
    
        $category_id = $request->input('category_id');
        $tipoinv = !empty($request->input('artseccion')) ? $request->input('artseccion') : 1;
        
        // $tipoinv = 6;
    
        // Construir la consulta base de productos
        $query = Product::select(
                'products.artprventa',
                'products.artdesc',
                'products.artpesoum',
                'products.category_id'
            )            
            
            ->where('products.artstatus', 'A')
            ->where('almcnt', $user->almcnt)
            ->where('stock', '>', 0)
            ->where('artseccion', $tipoinv)
            ->orderBy('products.category_id')
            ->orderBy('products.artcve')
            ->groupBy('products.artprventa', 'products.artdesc', 'products.artpesoum', 'products.category_id')
            ->distinct(); // Añadido para asegurarse de que no haya duplicados
    
        // Incluir la condición de categoría si el category_id es mayor a cero
        if ($category_id > 0) {
            $query->where('products.category_id', $category_id);
        }
    
        // Obtener los productos
        $products = $query->get();
    
        // Generar el PDF con los productos
        $pdf = Pdf::loadView('pdf.cenefas', ['products' => $products]);
    
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
        $releases = Release::where('almcnt', $almcnt)
            ->with(['product.media','product.category'])
            ->whereHas('product', fn($q)=>$q->where('stock','>',0))
            ->get()
            ->map->product
            ->unique('artcve')
            ->values();      // colección lista para la vista

        /* 5) Render-PDF */
        $pdf = Pdf::loadView(
            'pdf.catalogo',
            compact('products','categories','releases','empresa','mostrarPrecios')
        )->setPaper('letter','portrait');

        return $pdf->stream("CatalogoDigital-{$fechaFile}.pdf");
    }


   

} // class
