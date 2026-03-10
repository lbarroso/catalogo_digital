<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Carbon;

class SupabaseService
{
    protected string $baseUrl;
    protected array  $headers;

    public function __construct()
    {
        // Base URL apuntando a la REST API (rest/v1) de Supabase
        $this->baseUrl = rtrim(config('services.supabase.url'), '/').'/rest/v1';
        $apiKey = config('services.supabase.key');

        $this->headers = [
            'apikey'        => $apiKey,
            'Authorization' => 'Bearer '.$apiKey,
            'Accept'        => 'application/json',
        ];
    }


    /**
     * Llama a la función RPC get_orders_by_almcnt(p_almcnt).
     *
     * @param int $almcnt
     * @return array
     */
    public function fetchOrdersByAlmcnt(int $almcnt): array
    {
        try {
            // HTTP POST a /rpc/get_orders_by_almcnt
            $resp = Http::withHeaders($this->headers)
                ->post("{$this->baseUrl}/rpc/get_orders_by_almcnt", [
                    'p_almcnt' => $almcnt
                ]);

            $resp->throw(); // lanza si status >= 400
            return $resp->json();
            // dd($resp->json());

        } catch (RequestException $e) {
            $msg = $e->response?->body() ?? $e->getMessage();
            throw new \RuntimeException("Error RPC Supabase: $msg");
        }
    }    

/**
 * Obtiene pedidos desde Supabase filtrando por almacén y cliente (ctecve).
 */
public function fetchOrdersByAlmcntCtecve(int $almcnt, int $ctecve, string $order_date): array
{
    try {
        $resp = Http::withHeaders($this->headers)
            ->post("{$this->baseUrl}/rpc/get_orders_by_almcnt_ctecve", [
                'p_almcnt' => $almcnt,
                'p_ctecve' => $ctecve,
                'p_order_date' => $order_date
            ]);

        $resp->throw(); // lanza excepción si hay error HTTP

        return $resp->json();

    } catch (RequestException $e) {
        $msg = $e->response?->body() ?? $e->getMessage();
        throw new \RuntimeException("Error RPC Supabase (get_orders_by_almcnt_ctecve): $msg");
    }
}

/**
 * Obtiene pedidos desde Supabase filtrando por almacén y fecha.
 */
public function fetchOrdersByAlmcntDate(int $almcnt, string $fecha): array
{
    // Normaliza la fecha (lanza InvalidArgumentException si es inválida)    
    $fecha = Carbon::parse($fecha)->toDateString();   // 'YYYY-MM-DD'
    
    try {
        $resp = Http::withHeaders($this->headers)
            ->post("{$this->baseUrl}/rpc/get_orders_by_almcnt_date", [
                'p_almcnt' => $almcnt,
                'p_date' => $fecha                
            ]);

        $resp->throw(); // lanza excepción si hay error HTTP

        return $resp->json();

    } catch (RequestException $e) {
        $msg = $e->response?->body() ?? $e->getMessage();
        throw new \RuntimeException("Error RPC Supabase (get_orders_by_almcnt_date): $msg");
    }
} // fetchOrdersByAlmcntDate


    /**
     * Obtiene todos los pedidos para un almacén dado.
     *
     * @param int $almcnt
     * @return array
     * @throws \RuntimeException
     */
    public function getOrdersByAlmcnt(int $almcnt): array
    {
        try {
            $response = Http::withHeaders($this->headers)
                ->get("{$this->baseUrl}/orders", [
                    'select' => '*',
                    'almcnt' => "eq.{$almcnt}",
                ]);

            $response->throw(); // lanza excepción si status >= 400

            return $response->json();
        } catch (RequestException $e) {
            // Aquí tienes la respuesta completa para debug
            $status = $e->response?->status();
            $body   = $e->response?->body();
            throw new \RuntimeException(
                "Error HTTP $status al consultar Supabase: $body"
            );
        }
    }

    /**
     * Upsert masivo de pedidos en Supabase.
     *
     * @param array $rows
     * @return array
     * @throws \RuntimeException
     */
    public function upsertOrders(array $rows): array
    {
        try {
            $response = Http::withHeaders(array_merge(
                    $this->headers,
                    ['Prefer' => 'resolution=merge-duplicates']
                ))
                ->post("{$this->baseUrl}/orders", $rows);

            $response->throw();

            return $response->json();
        } catch (RequestException $e) {
            $status = $e->response?->status();
            $body   = $e->response?->body();
            throw new \RuntimeException(
                "Error HTTP $status al hacer upsert en Supabase: $body"
            );
        }
    }

    /**
     * Upsert masivo de productos en Supabase (stock, price, description, image...).
     *
     * @param array $rows
     * @return array
     * @throws \RuntimeException
     */
    public function upsertProducts(array $rows): array
    {
        try {
            $url = "{$this->baseUrl}/products?on_conflict=code,almcnt";
    
            $response = Http::withHeaders(array_merge(
                    $this->headers,
                    ['Prefer' => 'resolution=merge-duplicates,return=representation']
                ))
                ->post($url, $rows);
    
            $response->throw();
            return $response->json() ?? [];
    
        } catch (RequestException $e) {
            $status = $e->response?->status();
            $body   = $e->response?->body();
            throw new \RuntimeException(
                "Error HTTP $status al hacer upsert de productos en Supabase: $body"
            );
        }
    }
    

    /**
     * Pone a cero el stock de todos los products de un almcnt dado.
     *
     * @param int $almcnt
     * @return void
     * @throws \RuntimeException
     */
    public function resetStockByAlmcnt(int $almcnt): void
    {
        try {
            // PATCH /products?almcnt=eq.{almcnt} con { stock: 0 }
            $response = Http::withHeaders($this->headers)
                ->patch("{$this->baseUrl}/products?almcnt=eq.{$almcnt}", [
                    'stock' => 0
                ]);

            $response->throw();
        } catch (RequestException $e) {
            $status = $e->response?->status();
            $body   = $e->response?->body();
            throw new \RuntimeException(
                "Error HTTP $status al resetear stock en Supabase: $body"
            );
        }
    }
    

/* ============================================================
 *  CREA USUARIO EN SUPABASE AUTH (auth.users) CON SERVICE ROLE KEY
 * ============================================================ */
public function createAuthUser(string $email, string $password): array
{
    $authUrl = rtrim(config('services.supabase.url'), '/') . '/auth/v1';
    $serviceKey = config('services.supabase.service_role_key');

    try {
        $response = Http::withHeaders([
                'apikey'        => $serviceKey,
                'Authorization' => 'Bearer ' . $serviceKey,
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',   // ← IMPORTANTE
            ])
            ->post("$authUrl/admin/users", [
                'email'         => $email,
                'password'      => $password,
                'email_confirm' => true,
                'state'         => 'active'
            ]);

        $response->throw();

        return $response->json()['user'] ?? $response->json();

    } catch (RequestException $e) {
        $msg = $e->response?->body() ?? $e->getMessage();
        throw new \RuntimeException("Error creando usuario en AUTH: $msg");
    }
}




    /* ============================================================
     *  INSERTA REGISTRO EN TABLA public.users
     * ============================================================ */
    public function insertPublicUser(array $data): array
    {
        try {
            $response = Http::withHeaders(array_merge(
                    $this->headers,
                    ['Prefer' => 'return=representation'] // Para obtener el registro insertado
                ))
                ->post("{$this->baseUrl}/users", [$data]); // Array de 1 registro

            $response->throw();
            return $response->json()[0] ?? $response->json();

        } catch (RequestException $e) {
            $status = $e->response?->status();
            $body   = $e->response?->body();

            throw new \RuntimeException(
                "Error al insertar usuario en public.users: HTTP $status → $body"
            );
        }
    }



    /* ============================================================
     *  ELIMINA USUARIO DE AUTH (ROLLBACK)
     * ============================================================ */
    public function deleteAuthUser(string $authUserId): void
    {
        $authUrl = rtrim(config('services.supabase.url'), '/') . '/auth/v1';

        try {
            $response = Http::withHeaders([
                    'apikey'        => config('services.supabase.key'),
                    'Authorization' => 'Bearer '.config('services.supabase.key'),
                ])
                ->delete("$authUrl/admin/users/{$authUserId}");

            $response->throw();

        } catch (RequestException $e) {
            $msg = $e->response?->body() ?? $e->getMessage();
            throw new \RuntimeException("Error eliminando usuario de AUTH: $msg");
        }
    }


    public function listPublicUsers(): array
    {
        try {
            $response = Http::withHeaders($this->headers)
                ->get("{$this->baseUrl}/users?select=*");
    
            $response->throw();
            return $response->json();
    
        } catch (\Exception $e) {
            throw new \RuntimeException("Error obteniendo public.users: ".$e->getMessage());
        }
    }


    /* ============================================================
    *  LISTAR TODOS LOS auth.users (requiere service role key)
    * ============================================================ */
    public function listAuthUsers(): array
    {
        $authUrl = rtrim(config('services.supabase.url'), '/') . '/auth/v1';
        $serviceKey = config('services.supabase.service_role_key');

        try {
            $response = Http::withHeaders([
                'apikey'        => $serviceKey,
                'Authorization' => 'Bearer ' . $serviceKey,
                'Accept'        => 'application/json',
            ])->get("$authUrl/admin/users");

            $response->throw();
            return $response->json()['users'] ?? $response->json();

        } catch (\Exception $e) {
            throw new \RuntimeException("Error obteniendo auth.users: ".$e->getMessage());
        }
    }
        


    /**
     * Upsert masivo de clientes en Supabase.
     *
     * @param array $rows
     * @return array
     * @throws \RuntimeException
     */
    public function upsertCustomers(array $rows): array
    {
        try {
            $url = "{$this->baseUrl}/customers?on_conflict=almcnt,ctecve,cancve";
            

            $response = Http::withHeaders(array_merge(
                    $this->headers,
                    [
                        'Prefer'       => 'resolution=merge-duplicates,return=representation',
                        'Content-Type' => 'application/json',
                        'Accept'       => 'application/json',
                    ]
                ))
                ->timeout(30)
                ->post($url, $rows);

            $response->throw();

            return $response->json() ?? [];

        } catch (RequestException $e) {
            $status = $e->response?->status();
            $body   = $e->response?->body();

            throw new \RuntimeException(
                "Error HTTP $status al hacer upsert de clientes en Supabase: $body"
            );
        }
    }

} // class
