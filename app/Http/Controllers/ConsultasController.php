<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use PDO;

class ConsultasController extends Controller
{

	// canasta basica
	public function canastaBasica(Request $request)
	{
		$user = Auth::user();
		$host = $user->ip;

		// 1) Validaciones básicas
		$mes  = (int) $request->input('mes', now()->month);
		$anio = (int) $request->input('year', now()->year);

		$articulos = null;
		// Solo ejecutar consulta cuando el usuario haya dado clic en Filtrar
		
		if (!$request->has('filtrar')) {
			return view('consultas.canasta_basica', compact('articulos', 'mes', 'anio'));
		}		

		if ($mes < 1 || $mes > 12) $mes = now()->month;
		if ($anio < 2020 || $anio > (now()->year + 1)) $anio = now()->year;

		if (empty($host) || !filter_var($host, FILTER_VALIDATE_IP)) {
			return view('consultas.canasta_basica', [
				'articulos' => null,
				'mes' => $mes,
				'anio' => $anio,
			]);
		}

		// 2) Fechas (mejor con Carbon)
		$inicio = now()->setDate($anio, $mes, 1)->startOfMonth()->format('d/m/Y');
		$fin    = now()->setDate($anio, $mes, 1)->endOfMonth()->format('d/m/Y');

		// 3) Conexión dinámica SIN sobrescribir pgsql global
		$connectionName = 'siac_dynamic';

		Config::set("database.connections.$connectionName", [
			'driver'   => 'pgsql',
			'host'     => $host,
			'port'     => env('SIAC_PG_PORT', 5432),
			'database' => env('SIAC_PG_DATABASE', 'siac'),
			'username' => env('SIAC_PG_USERNAME', 'siacpgsql'),
			'password' => env('SIAC_PG_PASSWORD'),
			'charset'  => 'utf8',
			'prefix'   => '',
			'schema'   => 'public',

		]);

		DB::purge($connectionName);     // evita conexión cacheada
		DB::reconnect($connectionName); // fuerza conexión con la config nueva

		// 4) Ejecuta query (igual que la tuya)
		$articulos = DB::connection($connectionName)->select("
			SELECT 
				a.cancve, a.ctecve, f.locnom,
				SUM(CASE WHEN famcve = 4  AND ((comocimpventa - comoaimpventa) - (comocboni - comoaboni)) > 0 THEN 1 ELSE 0 END) AS Maiz,
				SUM(CASE WHEN famcve = 3  AND ((comocimpventa - comoaimpventa) - (comocboni - comoaboni)) > 0 THEN 1 ELSE 0 END) AS Frijol,
				SUM(CASE WHEN famcve = 2  AND ((comocimpventa - comoaimpventa) - (comocboni - comoaboni)) > 0 THEN 1 ELSE 0 END) AS Arroz,
				SUM(CASE WHEN famcve = 1  AND ((comocimpventa - comoaimpventa) - (comocboni - comoaboni)) > 0 THEN 1 ELSE 0 END) AS Azucar,
				SUM(CASE WHEN famcve = 5  AND ((comocimpventa - comoaimpventa) - (comocboni - comoaboni)) > 0 THEN 1 ELSE 0 END) AS Aceite,
				SUM(CASE WHEN famcve = 7  AND ((comocimpventa - comoaimpventa) - (comocboni - comoaboni)) > 0 THEN 1 ELSE 0 END) AS Leche,
				SUM(CASE WHEN famcve = 8  AND ((comocimpventa - comoaimpventa) - (comocboni - comoaboni)) > 0 THEN 1 ELSE 0 END) AS HnaTrig,
				SUM(CASE WHEN famcve = 9  AND ((comocimpventa - comoaimpventa) - (comocboni - comoaboni)) > 0 THEN 1 ELSE 0 END) AS HnaMaiz,
				SUM(CASE WHEN famcve = 10 AND ((comocimpventa - comoaimpventa) - (comocboni - comoaboni)) > 0 THEN 1 ELSE 0 END) AS Sal,
				SUM(CASE WHEN famcve = 11 AND ((comocimpventa - comoaimpventa) - (comocboni - comoaboni)) > 0 THEN 1 ELSE 0 END) AS Cafe,
				SUM(CASE WHEN famcve = 12 AND ((comocimpventa - comoaimpventa) - (comocboni - comoaboni)) > 0 THEN 1 ELSE 0 END) AS Galletas,
				SUM(CASE WHEN famcve = 13 AND ((comocimpventa - comoaimpventa) - (comocboni - comoaboni)) > 0 THEN 1 ELSE 0 END) AS Pastas,
				SUM(CASE WHEN famcve IN (25,72) AND ((comocimpventa - comoaimpventa) - (comocboni - comoaboni)) > 0 THEN 1 ELSE 0 END) AS AtunySard,
				SUM(CASE WHEN famcve = 32 AND ((comocimpventa - comoaimpventa) - (comocboni - comoaboni)) > 0 THEN 1 ELSE 0 END) AS Chiles,
				SUM(CASE WHEN famcve = 36 AND ((comocimpventa - comoaimpventa) - (comocboni - comoaboni)) > 0 THEN 1 ELSE 0 END) AS Detergentes,
				SUM(CASE WHEN famcve = 37 AND ((comocimpventa - comoaimpventa) - (comocboni - comoaboni)) > 0 THEN 1 ELSE 0 END) AS JabLav,
				SUM(CASE WHEN famcve = 38 AND ((comocimpventa - comoaimpventa) - (comocboni - comoaboni)) > 0 THEN 1 ELSE 0 END) AS BlanqYSuav,
				SUM(CASE WHEN famcve = 40 AND ((comocimpventa - comoaimpventa) - (comocboni - comoaboni)) > 0 THEN 1 ELSE 0 END) AS LimpLqPvo,
				SUM(CASE WHEN famcve = 42 AND ((comocimpventa - comoaimpventa) - (comocboni - comoaboni)) > 0 THEN 1 ELSE 0 END) AS PapelHig,
				SUM(CASE WHEN famcve = 43 AND ((comocimpventa - comoaimpventa) - (comocboni - comoaboni)) > 0 THEN 1 ELSE 0 END) AS Servilletas,
				SUM(CASE WHEN famcve = 51 AND ((comocimpventa - comoaimpventa) - (comocboni - comoaboni)) > 0 THEN 1 ELSE 0 END) AS ToallasFem,
				SUM(CASE WHEN famcve = 62 AND ((comocimpventa - comoaimpventa) - (comocboni - comoaboni)) > 0 THEN 1 ELSE 0 END) AS JabToc
			FROM desmovfamcancte_view AS a
			INNER JOIN clientes AS b
				ON (a.regcve = b.regcve AND a.unicve = b.unicve AND a.almcve = b.almcve AND a.cancve = b.cancve AND a.ctecve = b.ctecve)
			INNER JOIN histcli AS c
				ON (a.regcve = c.regcve AND a.unicve = c.unicve AND a.almcve = c.almcve AND a.cancve = c.cancve AND a.ctecve = c.ctecve AND b.cteulthist = c.ctehist)
			INNER JOIN estados AS d
				ON b.edocve = d.edocve
			INNER JOIN municipios AS e
				ON (b.edocve = e.edocve AND b.muncve = e.muncve)
			INNER JOIN localidad AS f
				ON (b.edocve = f.edocve AND b.muncve = f.muncve AND b.loccve = f.loccve)
			WHERE a.docfec >= ? AND a.docfec <= ?
			AND a.cancve IN (54,57,810) AND a.movcve = 51
			GROUP BY a.cancve, a.ctecve, f.locnom
			ORDER BY a.ctecve ASC
		", [$inicio, $fin]);

		return view('consultas.canasta_basica', compact('articulos', 'mes', 'anio'));
	}


} // class
