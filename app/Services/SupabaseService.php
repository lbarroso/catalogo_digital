<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

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
    


} // class
