<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class ExistenciaController extends Controller
{
    
    public function consultarExistencia(Request $request)
    {
        date_default_timezone_set('America/Mexico_City');
        $mes = date('n');
        $artcve = $request->input('artcve');

        // Validar si 'almcnt' existe en la sesión o si se recibe por $request
        if (Session::has('almcnt')) {
            $almcnt = Session::get('almcnt');
        } elseif (!empty($request->id)) {
            $almcnt = $request->id;
            Session::put('almcnt', $almcnt); // Guardar en la sesión
        } else {
            return view('webpages.selectLocation');
        }

        $user =  User::where('almcnt',$almcnt)->first();

        if (is_null($user)) {
            return redirect()->back()->with('error', 'Error al conectar a la base de datos.');
        }

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

        // Conexión a la base de datos SIAC (PostgreSQL) y consulta con las variables
        $existencia = DB::connection('pgsql')->select(" 
SELECT 
    a.artcve, 
    ah.artcap,
    CASE 
        WHEN ah.artcap = 0 THEN 0
        ELSE ((ah.artprcventa * ah.artiva / 100) + ah.artprcventa) / ah.artcap 
    END AS pieza, 
    ((ar.inviniuni + ar.inventuni - ar.invsaluni) * ah.artcap) + (ar.invinires + ar.inventres - ar.invsalres) AS er,
    CASE 
        WHEN ah.artcap = 0 THEN 0
        ELSE (((ar.inviniuni + ar.inventuni - ar.invsaluni) * ah.artcap) + (ar.invinires + ar.inventres - ar.invsalres)) * (ah.artprcventa / ah.artcap)
    END AS Pvta
FROM 
    articulos as a 
INNER JOIN 
    (arthist as ah 
    INNER JOIN articul1 as ar ON (ar.invhist = ah.arthist) AND (ah.artcve = ar.artcve))
    ON a.artcve = ah.artcve
WHERE 
    ar.invmes = ? 
    AND a.artstatus = 'A' 
    AND a.artcve = ? 
    AND ((ar.inviniuni + ar.inventuni - ar.invsaluni) * ah.artcap) + (ar.invinires + ar.inventres - ar.invsalres) <> 0;

            ", [$mes, $artcve]);
        
           

        // El resultado es un array con un solo objeto, así que tomamos el primer elemento
        $existencia = $existencia ? $existencia[0] : null;
        
        

        // Retornar la existencia como respuesta JSON
        return response()->json(['articulo' => $existencia]);

    }

} // class
