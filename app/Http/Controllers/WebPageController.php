<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class WebPageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Validar si 'almcnt' existe en la sesión o si se recibe por $request
        if (Session::has('almcnt')) {
            $almcnt = Session::get('almcnt');
        } elseif (!empty($request->id)) {
            $almcnt = $request->id;
            Session::put('almcnt', $almcnt); // Guardar en la sesión
        } else {
            return view('webpages.selectLocation');
        }

        $empresa = Empresa::find($almcnt);

        $categories = Product::inRandomOrder()->select('name','categories.id','categories.type')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->where('stock', '>', 0)
        ->where('almcnt', $almcnt)
        ->where('artseccion', 1)
        ->orderBy('categories.name')
        ->distinct()
        ->limit(4)
        ->get();

        // novedades
        $releases = DB::select(" SELECT products.artdesc, products.artprventa, products.id AS product_id, products.stock, categories.name, media.file_name, media.id
        FROM releases
        INNER JOIN products ON products.artcve = releases.artcve AND products.almcnt = releases.almcnt
        INNER JOIN categories ON products.category_id = categories.id
        INNER JOIN media ON products.id = media.model_id
        WHERE releases.almcnt =".$almcnt." GROUP BY products.artcve");

        // mas vendidos
        $sellers = Product::inRandomOrder()
        ->select('products.artprventa', 'products.artdesc', 'products.id AS product_id', 'media.id', \DB::raw('media.name AS image'), 'categories.name')
        ->leftJoin('media', 'products.id', '=', 'media.model_id')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->where('products.artstatus', 'A')
        ->where('almcnt', $almcnt)
        ->where('stock', '>', 0)
        ->where('artseccion', 1)
        ->whereNotNull('media.name') // Agrega esta condición para seleccionar solo productos con imagen
        ->groupBy('products.artcve', 'categories.name', 'products.artprventa', 'products.artdesc')
        ->orderBy('products.category_id')
        ->orderBy('products.artcve')
        ->limit(5)
        ->get();    
        
        // productos
        $products = Product::select('products.artprventa', 'products.id AS product_id', 'products.artdesc', 'media.model_id',  'media.id', \DB::raw('media.name AS image'), 'categories.name')
        ->leftJoin('media', 'products.id', '=', 'media.model_id')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->where('products.artstatus', 'A')
        ->where('almcnt', $almcnt)
        ->where('stock', '>', 0)
        ->where('artseccion', 1)
        ->orderBy('products.category_id')
        ->orderBy('products.artcve')
        ->groupBy('products.artcve') // Agrupar por products.artcve para evitar duplicados
        ->limit(15)
        ->get();
        

      // Definir el número de registros que quieres limitar para cada sección
      $limit = 4;

      // Obtener productos de la sección "Productos Alimenticios y Bebidas"
      $foodAndBeverages = Category::whereIn('name', [
              'AZUCAR', 'ARROZ', 'FRIJOL', 'MAIZ', 'ACEITE COMESTIBLE', 'MANTECA', 'LECHE INDUSTRIALIZADA',
              'HARINA DE TRIGO', 'HARINA DE MAIZ', 'SAL', 'TE Y CAFES', 'GALLETAS', 'PASTAS PARA SOPA',
              'GRANOS Y SEMILLAS', 'ATOLES Y AVENAS', 'HARINA PREPARADA Y REPOSTERIA', 'ALIMENTOS INFANTILES',
              'CEREALES INDUSTRIALIZADOS Y SOYA', 'CHOCOLATE Y PREPARADOS PARA BEBIDAS', 'CAJETA, MERMELADA Y MIEL',
              'GELATINAS, FLANES Y POSTRES', 'FRUTA FRESCA, VERDURAS Y LEGUMBRES', 'JUGOS Y NECTARES',
              'CONCENTRADOS PARA BEBIDAS', 'PESCADOS Y MARISCOS ENLATADOS', 'COMIDAS PREPARADAS',
              'CALDOS Y CONCENTRADOS PARA SOPA', 'VEGETALES ENVASADOS', 'SALSAS Y PURES', 
              'ACEITUNAS Y VERDURAS ENCURTIDAS', 'MAYONESAS, MOSTAZAS Y ADEREZOS', 'CHILES ENLATADOS',
              'MOLES, ADOBOS Y CHILES SECOS', 'CARNES ENVASADAS', 'EMBUTIDOS Y QUESOS', 'LACTEOS', 
              'DULCES Y CARAMELOS', 'ESPECIAS Y CONDIMENTOS', 'PAN', 'HUEVO', 'DESAYUNOS', 'AGUA Y REFRESCOS EMBOTELLADOS',
              'COMPLEMENTOS ALIMENTICIOS', 'DESPENSAS', 'PRODUCTOS DE AMARANTO'
          ])
          ->inRandomOrder()
          ->limit($limit)
          ->get();

        // Obtener productos de la sección "Productos para el Hogar y Cuidado Personal"
        $homeAndPersonalCare = Category::whereIn('name', [
            'ANALGESICOS Y MEDICAMENTOS', 'CIGARROS Y CERILLOS', 'DETERGENTES', 'JABON DE LAVANDERIA',
            'BLANQUEADORES Y SUAVIZANTES', 'INSECT. RATICID. DESINF. AROMATIZ.', 'LIMPIADORES LIQUIDOS Y EN POLVO',
            'PANUELOS FACIALES', 'PAPEL HIGIENICO', 'SERVILLETAS Y TOALLAS', 'PLATOS, CUBIERTOS Y VASOS DESECHAB',
            'PAPEL, ENVOLTURA Y BOLSAS', 'PANALES DESECHABLES', 'CREMAS Y CEPILLOS DENTALES', 'ALCOHOL', 'ALGODON',
            'ARTICULOS PARA CURACION', 'TOALLAS SANITARIAS', 'DESODORANTES, TALCOS Y COSMETICOS', 'PERFUMERIA PARA BEBE',
            'ARTICULOS PARA BEBE', 'JABONES DE TOCADOR', 'SHAMPOO, ENJUAGUES Y FIJADORES', 'CREMA PARA MANOS Y CARA',
            'ACCESORIOS PARA USO PERSONAL', 'VELAS Y VELADORAS', 'LOCIONES Y COLONIAS', 'ROPA', 'ARTICULOS ESCOLARES',
            'JUGUETERIA'
        ])
        ->inRandomOrder()
        ->limit($limit)
        ->get();          

        // Obtener productos de la sección "Accesorios y Artículos para el Hogar"
        $householdItems = Category::whereIn('name', [
            'UTENSILIOS DE ALUMINIO Y ACERO', 'UTENSILIOS DE LOZA Y PELTRE', 'UTENSILIOS DE PLASTICO',
            'UTENSILIOS DE LAMINA GALVANIZADA', 'ESCOBAS, TRAPEADORES Y FIBRAS', 'FOCOS Y MATERIAL ELECTRICO',
            'PILAS Y LINTERNAS', 'CAJAS DE CARTON', 'FRUTAS FRESCAS, SECAS Y CONGELADAS', 'APLICADORES Y GRASA PARA CALZADO',
            'FERRETERIA Y ACCESORIOS', 'CALZADO', 'ALIMENTO PECUARIO', 'MATERIALES DE CONSTRUCCION',
            'FERTILIZANTES', 'TARJETAS TELEFONICAS Y RECARGAS TA', 'BUZONES Y ESTAMPILLAS POSTALES', 'ENVASES',
            'UTENSILIOS ELECTRICOS', 'LINEA BLANCA Y ELECTRODOMESTICOS', 'CILINDROS PARA COMBUSTIBLES'
        ])
        ->inRandomOrder()
        ->limit($limit)
        ->get();

        return view('webpages.home', compact('empresa', 'categories', 'products','releases','sellers', 'foodAndBeverages', 'homeAndPersonalCare', 'householdItems') );
    }

    /**
     * vitas por categorias
     */
    public function shopCategory(Request $request)
    {
        // Validar si 'almcnt' existe en la sesión o si se recibe por $request
        if (Session::has('almcnt')) {
            $almcnt = Session::get('almcnt');
        } elseif (!empty($request->id)) {
            $almcnt = $request->id;
            Session::put('almcnt', $almcnt); // Guardar en la sesión
        } else {
            return view('webpages.selectLocation');
        }

        $empresa = Empresa::find($almcnt);    

        $type = !empty($request->type) ? $request->type : "basicos";
        $orden = $request->input('orden'); // Recibimos el filtro seleccionado
        $category_id = !empty($request->category_id) ? $request->category_id : 0;
    
        $categories = Product::select('categories.name', 'categories.id',\DB::raw('COUNT(products.id) as count'))
            ->join('categories', function ($join) use ($type) {
                $join->on('products.category_id', '=', 'categories.id')
                     ->where('categories.type', '=', $type);
            })
            ->where('products.stock', '>', 0)
            ->where('products.almcnt', $almcnt)
            ->groupBy('categories.name')
            ->orderBy('categories.name')
            ->get();        
    
        // Construimos la consulta base
        $query = Product::select('products.artdesc', 'products.artpesoum', 'products.artprventa', 'products.category_id', 'products.id AS product_id', 'media.id', \DB::raw('media.name AS image'))
            ->join('categories', function ($join) use ($type) {
                $join->on('products.category_id', '=', 'categories.id')
                     ->where('categories.type', '=', $type);
            })
            ->leftJoin('media', 'products.id', '=', 'media.model_id')
            ->where('products.stock', '>', 0)
            ->where('products.almcnt', $almcnt)
            ->groupBy('products.artcve');
    
        // Agregar la condición de categoría si $category_id es distinto de cero
        if ($category_id != 0) {
            $query->where('products.category_id', $category_id);
        }
    
        // Aplicamos el filtro de orden
        if ($orden == 'bajo') {
            $query->orderBy('products.artprventa', 'asc');
        } elseif ($orden == 'alto') {
            $query->orderBy('products.artprventa', 'desc');
        } elseif ($orden == 'az') {
            $query->orderBy('products.artdesc', 'asc');
        } elseif ($orden == 'za') {
            $query->orderBy('products.artdesc', 'desc');
        } else {
            // Ordenar por defecto
            $query->orderBy('products.artdesc');
        }
    
        $products = $query->paginate(16); // Usar paginate para limitar a 16 registros por página
    
        if($type == 'basicos') {
            $typeArray = ['Alimentos Básicos', 'Higiene y Cuidado Personal', 'Artículos para el Hogar y otros','higiene','accesorios'];
        } else if($type == 'higiene') {
            $typeArray = ['Higiene y Cuidado Personal', 'Alimentos Básicos', 'Artículos para el Hogar y otros','basicos','accesorios'];
        } else {
            $typeArray = ['Artículos para el Hogar y otros', 'Alimentos Básicos', 'Higiene y Cuidado Personal','basicos','higiene'];
        }
    
        return view('webpages.shopcategory', compact('empresa','categories','products', 'typeArray', 'type', 'category_id'));
    }

    /**
     * mostrar los detalles de un producto específico.
     */
    public function productDetail(Request $request)
    {
        // Validar si 'almcnt' existe en la sesión o si se recibe por $request
        if (Session::has('almcnt')) {
            $almcnt = Session::get('almcnt');
        } elseif (!empty($request->id)) {
            $almcnt = $request->id;
            Session::put('almcnt', $almcnt); // Guardar en la sesión
        } else {
            return view('webpages.selectLocation');
        }

        $empresa = Empresa::find($almcnt);
        $type = !empty($request->type) ? $request->type : "basicos";
        $product_id = !empty($request->product_id) ? $request->product_id : false;

        $categories = Product::inRandomOrder()->select('name','categories.id','categories.type')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->where('stock', '>', 0)
        ->where('almcnt', $almcnt)
        ->where('artseccion', 1)
        ->orderBy('categories.name')
        ->distinct()
        ->limit(4)
        ->get();

        $product = Product::select('products.category_id', 'products.codbarras', 'products.artcve','products.artprventa', 'products.artpesogrm','products.artpesoum', 'products.artdesc', 'media.id', 'media.file_name', \DB::raw('media.name AS image'))
        ->leftjoin('media', 'products.id', '=', 'media.model_id')
        ->where('products.id', $product_id)
        ->first();
        
        // para consultar existencia
        $artcve = $product->artcve;

        // productos relacionados
        $relatedProducts = Product::select('products.id AS product_id', 'products.artdesc', 'products.artpesoum', 'products.artprventa', 'media.id', \DB::raw('media.name AS image'), 'media.file_name')
        ->Join('media', 'products.id', '=', 'media.model_id')
        ->where('products.category_id', $product->category_id)
        ->where('almcnt', $almcnt)
        ->inRandomOrder() // Ordenar aleatoriamente
        ->limit(4)
        ->get();
    
      
        return view('webpages.productdetail', compact('empresa', 'categories', 'type', 'product', 'relatedProducts','artcve'));
    }

    public function categories(Request $request)
    {
        // Validar si 'almcnt' existe en la sesión o si se recibe por $request
        if (Session::has('almcnt')) {
            $almcnt = Session::get('almcnt');
        } elseif (!empty($request->id)) {
            $almcnt = $request->id;
            Session::put('almcnt', $almcnt); // Guardar en la sesión
        } else {
            return view('webpages.selectLocation');
        }

        $empresa = Empresa::find($almcnt);
        $type = !empty($request->type) ? $request->type : "basicos";
        $product_id = !empty($request->product_id) ? $request->product_id : false;

        $categories = Product::inRandomOrder()->select('name','categories.id','type')        
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->where('stock', '>', 0)
        ->where('almcnt', $almcnt)
        ->where('artseccion', 1)
        ->orderBy('categories.name')
        ->distinct()
        ->limit(10)
        ->get();   

        // Definir el número de registros que quieres limitar para cada sección
        $limit = 4;

        $foodAndBeverages = Category::select('categories.id','categories.type','categories.name')->whereIn('categories.name', [
            'AZUCAR', 'ARROZ', 'FRIJOL', 'MAIZ', 'ACEITE COMESTIBLE', 'MANTECA', 'LECHE INDUSTRIALIZADA',
            'HARINA DE TRIGO', 'HARINA DE MAIZ', 'SAL', 'TE Y CAFES', 'GALLETAS', 'PASTAS PARA SOPA',
            'GRANOS Y SEMILLAS', 'ATOLES Y AVENAS', 'HARINA PREPARADA Y REPOSTERIA', 'ALIMENTOS INFANTILES',
            'CEREALES INDUSTRIALIZADOS Y SOYA', 'CHOCOLATE Y PREPARADOS PARA BEBIDAS', 'CAJETA, MERMELADA Y MIEL',
            'GELATINAS, FLANES Y POSTRES', 'FRUTA FRESCA, VERDURAS Y LEGUMBRES', 'JUGOS Y NECTARES',
            'CONCENTRADOS PARA BEBIDAS', 'PESCADOS Y MARISCOS ENLATADOS', 'COMIDAS PREPARADAS',
            'CALDOS Y CONCENTRADOS PARA SOPA', 'VEGETALES ENVASADOS', 'SALSAS Y PURES', 
            'ACEITUNAS Y VERDURAS ENCURTIDAS', 'MAYONESAS, MOSTAZAS Y ADEREZOS', 'CHILES ENLATADOS',
            'MOLES, ADOBOS Y CHILES SECOS', 'CARNES ENVASADAS', 'EMBUTIDOS Y QUESOS', 'LACTEOS', 
            'DULCES Y CARAMELOS', 'ESPECIAS Y CONDIMENTOS', 'PAN', 'HUEVO', 'DESAYUNOS', 'AGUA Y REFRESCOS EMBOTELLADOS',
            'COMPLEMENTOS ALIMENTICIOS', 'DESPENSAS', 'PRODUCTOS DE AMARANTO'
        ]) 
        ->join('products', 'categories.id', '=', 'products.category_id')
        ->where('products.stock', '>', 0)
        ->inRandomOrder()
        ->groupBy('categories.id')
        ->limit($limit)
        ->distinct()
        ->get(['categories.*']);  // Seleccionamos solo las columnas de la tabla 'categories'
    
        // Obtener productos de la sección "Productos para el Hogar y Cuidado Personal"
        $homeAndPersonalCare = Category::select('categories.id','categories.type','categories.name')->whereIn('name', [
            'ANALGESICOS Y MEDICAMENTOS', 'CIGARROS Y CERILLOS', 'DETERGENTES', 'JABON DE LAVANDERIA',
            'BLANQUEADORES Y SUAVIZANTES', 'INSECT. RATICID. DESINF. AROMATIZ.', 'LIMPIADORES LIQUIDOS Y EN POLVO',
            'PANUELOS FACIALES', 'PAPEL HIGIENICO', 'SERVILLETAS Y TOALLAS', 'PLATOS, CUBIERTOS Y VASOS DESECHAB',
            'PAPEL, ENVOLTURA Y BOLSAS', 'PANALES DESECHABLES', 'CREMAS Y CEPILLOS DENTALES', 'ALCOHOL', 'ALGODON',
            'ARTICULOS PARA CURACION', 'TOALLAS SANITARIAS', 'DESODORANTES, TALCOS Y COSMETICOS', 'PERFUMERIA PARA BEBE',
            'ARTICULOS PARA BEBE', 'JABONES DE TOCADOR', 'SHAMPOO, ENJUAGUES Y FIJADORES', 'CREMA PARA MANOS Y CARA',
            'ACCESORIOS PARA USO PERSONAL', 'VELAS Y VELADORAS', 'LOCIONES Y COLONIAS', 'ROPA', 'ARTICULOS ESCOLARES',
            'JUGUETERIA'
        ])
        ->join('products', 'categories.id', '=', 'products.category_id')
        ->where('products.stock', '>', 0)        
        ->inRandomOrder()
        ->groupBy('categories.id')
        ->limit($limit)
        ->get();          
        
        // Obtener productos de la sección "Accesorios y Artículos para el Hogar"
        $householdItems = Category::select('categories.id','categories.type','categories.name')->whereIn('name', [
            'UTENSILIOS DE ALUMINIO Y ACERO', 'UTENSILIOS DE LOZA Y PELTRE', 'UTENSILIOS DE PLASTICO',
            'UTENSILIOS DE LAMINA GALVANIZADA', 'ESCOBAS, TRAPEADORES Y FIBRAS', 'FOCOS Y MATERIAL ELECTRICO',
            'PILAS Y LINTERNAS', 'CAJAS DE CARTON', 'FRUTAS FRESCAS, SECAS Y CONGELADAS', 'APLICADORES Y GRASA PARA CALZADO',
            'FERRETERIA Y ACCESORIOS', 'CALZADO', 'ALIMENTO PECUARIO', 'MATERIALES DE CONSTRUCCION',
            'FERTILIZANTES', 'TARJETAS TELEFONICAS Y RECARGAS TA', 'BUZONES Y ESTAMPILLAS POSTALES', 'ENVASES',
            'UTENSILIOS ELECTRICOS', 'LINEA BLANCA Y ELECTRODOMESTICOS', 'CILINDROS PARA COMBUSTIBLES'
        ])
        ->join('products', 'categories.id', '=', 'products.category_id')
        ->where('products.stock', '>', 0)              
        ->inRandomOrder()
        ->groupBy('categories.id')
        ->limit($limit)
        ->get();
                
        return view('webpages.categories', compact('empresa', 'categories', 'foodAndBeverages', 'homeAndPersonalCare','householdItems'));
    }

    /**
     * buscar por clave SIAC
     */
    public function search(Request $request)
    {
        
        // Validar si 'almcnt' existe en la sesión o si se recibe por $request
        if (Session::has('almcnt')) {
            $almcnt = Session::get('almcnt');
        } elseif (!empty($request->id)) {
            $almcnt = $request->id;
            Session::put('almcnt', $almcnt); // Guardar en la sesión
        } else {
            return view('webpages.selectLocation');
        }

        $empresa = Empresa::find($almcnt);

        $string = $request->input('string'); // Recibir el valor de la variable $string
        
        $products = Product::select('products.artpesoum','products.id AS product_id', 'products.artdesc', 'products.artprventa', 'media.id', \DB::raw('media.name AS image'), 'media.file_name')
            ->Join('media', 'products.id', '=', 'media.model_id')
            ->where('products.almcnt', $almcnt)
            ->where(function($query) use ($string) {
                $query->where('products.artcve', 'LIKE', '%' . $string . '%')
                    ->orWhere('products.artdesc', 'LIKE', '%' . $string . '%');
            })
            ->groupBy('products.artcve')
            ->get();

        return view('webpages.search', compact('empresa', 'products'));
    }


    // Método para manejar el almacenamiento de la sesión
    public function setAlmcnt(Request $request)
    {
        $almcnt = $request->input('almcnt');
        Session::put('almcnt', $almcnt);
        return redirect()->route('webpages.home');
    }

    public function logoutSession()
    {
        // Destruir toda la sesión
        Session::flush();
    
        // Redirigir a la página de inicio o cualquier otra página
        return redirect()->route('webpages.home')->with('message', 'Sesión finalizada correctamente.');
    }
    

} // class
