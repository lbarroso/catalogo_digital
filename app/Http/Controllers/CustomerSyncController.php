<?php

namespace App\Http\Controllers;

use App\Models\CustomerLocal;
use App\Services\SupabaseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class CustomerSyncController extends Controller
{
    public function __construct(
        private SupabaseService $supabase
    ) {}

    public function syncToSupabase(): RedirectResponse
    {
        $user = Auth::user();

        if (!$user || !$user->almcnt) {
            return back()->with('error', 'No fue posible identificar el almacén del usuario autenticado.');
        }

        $almcnt = (int) $user->almcnt;
        $total = 0;

        try {
            CustomerLocal::query()
                ->where('almcnt', $almcnt)
                ->orderBy('id')
                ->chunkById(500, function ($chunk) use (&$total) {
                    $timestamp = now()->toDateTimeString();

                    $payload = $chunk
                        ->map(function (CustomerLocal $row) use ($timestamp) {
                            $externalId = $row->rpu
                                ? (string) $row->rpu
                                : ($row->rfc ?: null);

                            $notes = [
                                'fecha_pos'       => optional($row->fecha_pos)->format('Y-m-d'),
                                'fecha_apertura'  => optional($row->fecha_apertura)->format('Y-m-d'),
                                'capital_diconsa' => $row->capital_diconsa,
                                'capital_comunit' => $row->capital_comunit,
                                'ruta_sup'        => $row->ruta_sup,
                                'nombre_sup'      => $row->nombre_sup,
                            ];

                            return [
                                'almcnt'       => (int) $row->almcnt,
                                'ctecve'       => (int) $row->ctecve,
                                'cancve'       => $row->canal !== null ? (int) $row->canal : 57,

                                'name'         => $row->localidad ?: "Cliente {$row->ctecve}",
                                'contact_name' => $row->encargado,

                                'phone'        => $row->telefono,
                                'postal_code'  => $row->codigo_postal,
                                'city'         => $row->localidad,

                                'lat'          => $row->latitud !== null ? (float) $row->latitud : null,
                                'lng'          => $row->longitud !== null ? (float) $row->longitud : null,

                                'is_active'    => true,
                                'credit_limit' => 0,
                                'external_id'  => $externalId,
                                'notes'        => json_encode($notes, JSON_UNESCAPED_UNICODE),
                                'updated_at'   => $timestamp,
                            ];
                        })
                        ->filter(function (array $item) {
                            return !empty($item['almcnt'])
                                && !empty($item['ctecve'])
                                && !empty($item['cancve'])
                                && !empty($item['name']);
                        })
                        ->values()
                        ->all();

                    if (empty($payload)) {
                        
                        return;
                    }

                    $this->supabase->upsertCustomers($payload);
                    $total += count($payload);
                }, 'id');

            return back()->with(
                'success',
                "Sincronización completada: {$total} clientes enviados a Pedidos (almcnt={$almcnt})."
            );
        } catch (Throwable $e) {
            report($e);
            
            return back()->with(
                'error',
                $e->getMessage()
            );
        } 

    } // syncToSupabase


} // class