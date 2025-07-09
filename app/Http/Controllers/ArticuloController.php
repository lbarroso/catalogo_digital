<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Articulo;
use App\Models\Siac_articulo;
use App\Models\Siac_arthist;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Barryvdh\DomPDF\Facade\Pdf;



class ArticuloController extends Controller
{
    protected $config;
    protected $almcnt;
    protected $user;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        
        $user =  Auth::user();

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

        //
        $articulos = DB::connection('pgsql')->select(" ");

        return view('siac.articulos.index', compact('articulos'));

    } //  function

    /**importado de datos del SIAC a la base local */
    /**si ya existen registros en la tabla products entonces agrega nuevos */
    public function import()
    {
        $user =  Auth::user();
        $mes = date('n');
        date_default_timezone_set('America/Mexico_City');
        $fecha  = date('Y-m-d\TH:i:s');        

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
        $articulosSiac = DB::connection('pgsql')->select("  SELECT 
        a.famcve, 
        a.artcve,
        a1.invtpoinv, 
        a.artdesc, 
        ah.artcap,
        a.prvcve,
        a.artstatus,
        a.codbarras,
        ah.artmed,
        ah.artgms, 
        ROUND((((ah.artprcventa * ah.artiva / 100) + (ah.artprcventa * ah.artiepsvta / 100) + ah.artprcventa) / ah.artcap), 2) AS pieza,  
        ((a1.inviniuni + a1.inventuni - a1.invsaluni) * ah.artcap) + (a1.invinires + a1.inventres - a1.invsalres) AS Er
    FROM 
        articulos a
    INNER JOIN 
        (arthist ah
        INNER JOIN 
        articul1 a1 ON (ah.arthist = a1.invhist) AND (ah.artcve = a1.artcve)) 
        ON a.artcve = ah.artcve 
    WHERE 
        a.artstatus = 'A' 
        AND a1.invmes = EXTRACT(MONTH FROM CURRENT_DATE)
        AND ((a1.inviniuni + a1.inventuni - a1.invsaluni) * ah.artcap) + (a1.invinires + a1.inventres - a1.invsalres) > 0
    ORDER BY 
        a.famcve, 
        a.artcve, 
        a1.invtpoinv, 
        a1.invhist DESC;");

        // Conexión a la base de datos Inventario (MySQL)
        $articulosInventario = [];

        foreach ($articulosSiac as $articuloSiac) 
        {
            $presentacion = $articuloSiac->artcap.'/'.$articuloSiac->artgms.'/'.$articuloSiac->artmed;
            $product = utf8_encode($articuloSiac->artdesc);
            // Agregar el artículo al array para insertar en la base de datos de Inventario
            $articulosInventario[] = [
                'almcnt' => $user->almcnt,
                'artcve' => $articuloSiac->artcve,
                'artdesc' => trim($product),
                'category_id' => $articuloSiac->famcve,
                'codbarras' => trim($articuloSiac->codbarras),
                'stock' => $articuloSiac->er,
                'prvcve' => $articuloSiac->prvcve,
                'artprcosto' => $articuloSiac->pieza,
                'artprventa' => $articuloSiac->pieza,                
                'artpesogrm' => $articuloSiac->artgms,
                'artseccion' => $articuloSiac->invtpoinv,
                'artpesoum' => $presentacion,
            ];

        }

        // Vaciar todos los registros
        Articulo::truncate();

        // Insertar en la base de datos de Inventario (MySQL)
        Articulo::insert($articulosInventario);

        /**
         * procedimiento para agregar o actualizar
         */

        // contar el número de registros
        $numRegistros = Product::where('almcnt', $user->almcnt)->count();

        if($numRegistros > 0 ){

            // actualizar el stock a 0 donde almcnt coincida
            Product::where('almcnt', $user->almcnt)->update(['stock' => 0]);

            // actualizar precios y existencias
            $numRegistrosActualizados = DB::update('UPDATE products
            JOIN articulos ON products.artcve = articulos.artcve
            SET products.stock = articulos.stock,
                products.artprventa = articulos.artprventa,
                products.artseccion = articulos.artseccion
            WHERE products.almcnt = ?', [$user->almcnt]);

            // agregar nuevos
            $articulos = DB::select("SELECT a.almcnt,a.artcve,a.artdesc,a.prvcve,a.artstatus,a.category_id,a.codbarras,a.artmarca,a.artestilo,a.artcolor, a.artseccion,a.arttalla,a.stock,a.artimg,a.artprcosto,a.artprventa,a.artpesogrm,a.artpesoum,a.artganancia, a.eximin,a.eximax,a.artdetalle,a.created_at,a.updated_at 
            FROM articulos a 
            LEFT JOIN products b ON a.artcve = b.artcve AND a.almcnt = b.almcnt            
            WHERE b.artcve IS NULL AND a.almcnt =".$user->almcnt);

            // Conexión a la base de datos Inventario (MySQL)
            $articulosInventario = [];

            foreach ($articulos as $articuloSiac) 
            {
                
                // Agregar el artículo al array para insertar en la base de datos de Inventario
                $articulosInventario[] = [
                    'almcnt' => $user->almcnt,
                    'artcve' => $articuloSiac->artcve,
                    'artdesc' => $articuloSiac->artdesc,
                    'prvcve' => $articuloSiac->prvcve,
                    'artstatus' => $articuloSiac->artstatus,               
                    'category_id' => $articuloSiac->category_id,               
                    'codbarras' => $articuloSiac->codbarras,
                    'artseccion' => $articuloSiac->artseccion,
                    'stock' => $articuloSiac->stock,      
                    'artprcosto' => $articuloSiac->artprcosto,
                    'artprventa' => $articuloSiac->artprventa,                
                    'artpesogrm' => $articuloSiac->artpesogrm,
                    'artpesoum' => $articuloSiac->artpesoum,
                ];

            }

            // agregar nuevos products
            Product::insert($articulosInventario);

            // Obtener el número de registros insertados
            $numRegistrosInsertados = count($articulosInventario);

        }else{

            // transferir los registros de la tabla "articulos" a la tabla "products"
            // Obtener todos los registros de la tabla articulos
            $articulos = Articulo::where('almcnt', $user->almcnt)->get();

            // Conexión a la base de datos Inventario (MySQL)
            $articulosInventario = [];

            foreach ($articulos as $articuloSiac) 
            {
                
                // Agregar el artículo al array para insertar en la base de datos de Inventario
                $articulosInventario[] = [
                    'almcnt' => $user->almcnt,
                    'artcve' => $articuloSiac->artcve,
                    'artdesc' => $articuloSiac->artdesc,
                    'prvcve' => $articuloSiac->prvcve,
                    'artstatus' => $articuloSiac->artstatus,               
                    'category_id' => $articuloSiac->category_id,               
                    'codbarras' => $articuloSiac->codbarras,
                    'artseccion' => $articuloSiac->artseccion,
                    'stock' => $articuloSiac->stock,      
                    'artprcosto' => $articuloSiac->artprcosto,
                    'artprventa' => $articuloSiac->artprventa,                
                    'artpesogrm' => $articuloSiac->artpesogrm,
                    'artpesoum' => $articuloSiac->artpesoum,
                    'created_at' => $fecha, 
                    'updated_at' => $fecha,
                ];

            }
            
            // agregar nuevos products
            Product::insert($articulosInventario);            

            // Obtener el número de registros insertados
            $numRegistrosInsertados = count($articulosInventario);
            $numRegistrosActualizados = 0;            

        } // else
        
        return redirect()->route('products.index')->with('success', 'Transferencia de articulos completada registros nuevos ('.$numRegistrosInsertados.'), registros actualizados ('.$numRegistrosActualizados.')');
    }    


    public function cenefasFactura(Request $request)
   {
        $user = Auth::user();
        
        // Validar la entrada
        $request->validate([
            'docnumdoc' => 'required|integer'
        ]);

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

        $products = DB::connection('pgsql')->select("
            SELECT  art.artdesc, ah.artpesoum, ah.artpesogrm,
                    ROUND((((ah.artprcventa * ah.artiva / 100) + (ah.artprcventa * ah.artiepsvta / 100) + ah.artprcventa) / ah.artcap), 2) AS pieza
            FROM documentos 
            INNER JOIN docdeta ON (documentos.docord = docdeta.docord) 
                AND (documentos.almcve = docdeta.almcve) 
                AND (documentos.unicve = docdeta.unicve) 
                AND (documentos.regcve = docdeta.regcve)
            INNER JOIN ARTHIST ah ON (docdeta.artcve = ah.artcve) 
                AND (docdeta.arthist = ah.arthist)
            INNER JOIN ARTICULOS art ON (docdeta.artcve = art.artcve) 
            WHERE documentos.docnumdoc = :docnumdoc
            GROUP BY documentos.docord, docdeta.artcve, art.artdesc, ah.artprcventa, ah.artiva, ah.artiepsvta,
                art.prvcve, art.famcve, ah.lineacve, ah.artcap, ah.artmed, ah.artgms, ah.artpesoum, ah.artpesogrm, 
                ah.arthist, art.artulthist, docdeta.docurped, docdeta.doccanped, docdeta.docursur, docdeta.doccansur, 
                documentos.docnumdoc
            ORDER BY art.famcve;  ", ['docnumdoc' => $request->docnumdoc]);
    
        // Convertir el arreglo de resultados en una colección de Laravel
        $products = collect($products);  // Convertimos el resultado en una colección

        // Generar el PDF con los productos
        $pdf = Pdf::loadView('pdf.cenefas-factura', ['products' => $products]);
    
        // Retornar el PDF para su descarga
        return $pdf->stream('CenefasFactura' . $request->docnumdoc . '.pdf');  

   }
  

   /*** 
    SELECT 
        a.famcve, 
        a.artcve,
        a1.invtpoinv, 
        a.artdesc, 
        ah.artcap,
        a.prvcve,
        a.artstatus,
        a.codbarras,
        ah.artmed,
        ah.artgms, 
        ROUND((((ah.artprcventa * ah.artiva / 100) + (ah.artprcventa * ah.artiepsvta / 100) + ah.artprcventa) / ah.artcap), 2) AS pieza,  
        ((a1.inviniuni + a1.inventuni - a1.invsaluni) * ah.artcap) + (a1.invinires + a1.inventres - a1.invsalres) AS Er
    FROM 
        articulos a
    INNER JOIN 
        (arthist ah
        INNER JOIN 
        articul1 a1 ON (ah.arthist = a1.invhist) AND (ah.artcve = a1.artcve)) 
        ON a.artcve = ah.artcve 
    WHERE 
        a.artstatus = 'A' 
        AND a1.invmes = EXTRACT(MONTH FROM CURRENT_DATE)
        AND ((a1.inviniuni + a1.inventuni - a1.invsaluni) * ah.artcap) + (a1.invinires + a1.inventres - a1.invsalres) > 0
    ORDER BY 
        a.famcve, 
        a.artcve, 
        a1.invtpoinv, 
        a1.invhist DESC;
    **/
   
} // class
