<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupabaseOrder extends Model
{
    use HasFactory;
    protected $connection = 'supabase';
    protected $table = 'orders';    

}

/******************************************************************
 * 
 * 
 * esto devolverá hasta 50 productos frecuentes de cada cliente del almacén 2039, con todas las columnas que definiste 
 * (customer_id, product_id, name, code, unit, image, price, volume, frequency, avg_days_ago, score).
SELECT * FROM public.get_frequent_products_by_warehouse(2039);

-- Función para obtener los 50 productos frecuentes de cada cliente
-- de un almacén dado (almcnt) en los últimos 6 meses.
CREATE OR REPLACE FUNCTION public.get_frequent_products_by_warehouse(
  p_almcnt integer
)
RETURNS TABLE (
  customer_id    bigint,
  product_id     bigint,
  name           text,
  code           text,
  unit           text,
  image          text,
  price          numeric,
  volume         numeric,
  frequency      bigint,
  avg_days_ago   double precision,
  score          double precision
) AS $$
WITH supervised_customers AS (
  -- 1) Todos los clientes de ese almacén
  SELECT DISTINCT o.customer_id
  FROM public.orders o
  WHERE o.almcnt = p_almcnt
),
base AS (
  -- 2) Métricas por cliente y producto
  SELECT
    o.customer_id,
    oi.product_id,
    SUM(oi.quantity)                             AS volume,
    COUNT(DISTINCT oi.order_id)                  AS frequency,
    AVG(EXTRACT(EPOCH FROM (NOW() - o.order_date)) / 86400) AS avg_days_ago,
    -- Score híbrido: volumen ajustado por recencia × frecuencia
    (SUM(oi.quantity) / (AVG(EXTRACT(EPOCH FROM (NOW() - o.order_date)) / 86400) + 1))
      * COUNT(DISTINCT oi.order_id)              AS score
  FROM public.order_items oi
  JOIN public.orders o
    ON oi.order_id = o.id
  WHERE o.almcnt      = p_almcnt
    AND o.order_date >= NOW() - INTERVAL '6 months'
    AND o.customer_id IN (SELECT customer_id FROM supervised_customers)
  GROUP BY o.customer_id, oi.product_id
),
ranked AS (
  -- 3) Numeramos los productos por cliente según score
  SELECT
    b.*,
    ROW_NUMBER() OVER (
      PARTITION BY b.customer_id
      ORDER BY b.score DESC
    ) AS rn
  FROM base b
)
-- 4) Seleccionamos sólo los top 50 por cliente
SELECT
  r.customer_id,
  r.product_id,
  p.name,
  p.code,
  p.unit,
  p.image,
  p.price,
  r.volume,
  r.frequency,
  r.avg_days_ago,
  r.score
FROM ranked r
JOIN public.products p
  ON p.id = r.product_id
WHERE r.rn <= 50
ORDER BY r.customer_id, r.score DESC;
$$ LANGUAGE sql STABLE;


// Cómo usarla en el SQL Editor de Supabase:

WITH supervised_customers AS (
  SELECT DISTINCT o.customer_id
  FROM public.orders o
  WHERE o.almcnt = 2039
),
base AS (
  SELECT
    o.customer_id,
    oi.product_id,
    SUM(oi.quantity)                             AS volume,
    COUNT(DISTINCT oi.order_id)                  AS frequency,
    AVG(EXTRACT(EPOCH FROM (NOW() - o.order_date)) / 86400) AS avg_days_ago,
    (SUM(oi.quantity) / (AVG(EXTRACT(EPOCH FROM (NOW() - o.order_date)) / 86400) + 1))
      * COUNT(DISTINCT oi.order_id)              AS score
  FROM public.order_items oi
  JOIN public.orders o
    ON oi.order_id = o.id
  WHERE o.almcnt      = 2039
    AND o.order_date >= NOW() - INTERVAL '6 months'
    AND o.customer_id IN (SELECT customer_id FROM supervised_customers)
  GROUP BY o.customer_id, oi.product_id
),
ranked AS (
  SELECT
    b.*,
    ROW_NUMBER() OVER (
      PARTITION BY b.customer_id
      ORDER BY b.score DESC
    ) AS rn
  FROM base b
)
SELECT
  r.customer_id,
  r.product_id,
  p.name,
  p.code,
  p.unit,
  p.image,
  p.price,
  r.volume,
  r.frequency,
  r.avg_days_ago,
  r.score
FROM ranked r
JOIN public.products p
  ON p.id = r.product_id
WHERE r.rn <= 50
ORDER BY r.customer_id, r.score DESC;

// puedes listar todas tus funciones y procedimientos definidos en el esquema public con cualquiera de estas consultas SQL:

SELECT
  n.nspname   AS schema,
  p.proname   AS function_name,
  pg_get_function_arguments(p.oid)  AS arguments,
  pg_get_function_result(p.oid)     AS return_type,
  p.prokind    AS kind  -- 'f' = function, 'p' = procedure
FROM pg_proc p
JOIN pg_namespace n ON n.oid = p.pronamespace
WHERE n.nspname = 'public'
ORDER BY p.proname;

 */



 /**********************************************************************

 CREATE OR REPLACE FUNCTION public.get_frequent_products_by_user_id(
  p_user_id UUID,
  p_since    TIMESTAMP DEFAULT NOW() - INTERVAL '6 months',
  p_limit    INTEGER   DEFAULT 100
)
RETURNS TABLE (
  product_id   BIGINT,
  name         TEXT,
  code         TEXT,
  unit         TEXT,
  image        TEXT,
  price        NUMERIC,
  volume       NUMERIC,
  frequency    BIGINT,
  avg_days_ago DOUBLE PRECISION,
  score        DOUBLE PRECISION
) AS $$
WITH base AS (
  SELECT
    oi.product_id,
    SUM(oi.quantity)                                    AS volume,
    COUNT(DISTINCT oi.order_id)                         AS frequency,
    AVG(EXTRACT(EPOCH FROM (NOW() - o.order_date)) / 86400) AS avg_days_ago,
    (SUM(oi.quantity) / (AVG(EXTRACT(EPOCH FROM (NOW() - o.order_date)) / 86400) + 1))
      * COUNT(DISTINCT oi.order_id)                     AS score
  FROM public.order_items oi
  JOIN public.orders o
    ON oi.order_id = o.id
  WHERE o.user_id    = p_user_id
    AND o.order_date >= p_since
  GROUP BY oi.product_id
)
SELECT
  b.product_id,
  p.name,
  p.code,
  p.unit,
  p.image,
  p.price,
  b.volume,
  b.frequency,
  b.avg_days_ago,
  b.score
FROM base b
JOIN public.products p
  ON p.id = b.product_id
ORDER BY b.score DESC
LIMIT p_limit;
$$ LANGUAGE sql STABLE;

-- 2) Para probar la función en el SQL Editor:
SELECT * FROM public.get_frequent_products_by_user_id('95696e33-cb0f-4282-b380-a18723962088');

-- Eliminar la función get_frequent_products_by_user_id de Supabase
DROP FUNCTION IF EXISTS public.get_frequent_products_by_user_id(
  UUID,
  TIMESTAMP,
  INTEGER
);

  */

  /*****************************************************************************************
    DROP FUNCTION public.get_orders_by_almcnt;
    
   Aquí tienes la versión actualizada de la función, que añade el filtro para que solo devuelva pedidos cuyo order_date sea a partir del primer día del mes en curso:
   
    CREATE OR REPLACE FUNCTION public.get_orders_by_almcnt(p_almcnt integer)
  RETURNS TABLE(
      id            bigint,
      order_date    timestamp without time zone,
      sync_date     timestamp without time zone,
      almcnt        integer,
      doccreated    timestamp without time zone,
      docupdated    timestamp without time zone,
      ctecve        integer,
      cliente_name  character varying,
      quantity      integer,
      unit_price    numeric,
      code          character varying,
      product_name  character varying,
      unit          character varying
  )
  LANGUAGE sql
  STABLE
  AS $$
      SELECT
          o.id,
          o.order_date,
          o.sync_date,
          o.almcnt,
          o.created_at   AS doccreated,
          o.updated_at   AS docupdated,
          c.ctecve,
          c.name         AS cliente_name,
          oi.quantity,
          oi.unit_price,
          p.code,
          p.name         AS product_name,
          p.unit
      FROM public.orders o
      JOIN public.customers c         ON o.customer_id   = c.id
      LEFT JOIN public.order_items oi ON oi.order_id     = o.id
      LEFT JOIN public.products    p  ON oi.product_id   = p.id
      WHERE o.almcnt = p_almcnt
        AND o.order_date >= CURRENT_DATE - INTERVAL '7 days';
  $$;

   *************************************************************************************/

     /*****************************************************************************************
    DROP FUNCTION public.get_orders_by_almcnt_ctecve;
                  

   Aquí tienes la versión actualizada de la función, que añade el filtro para que solo devuelva pedidos cuyo order_date sea a partir del primer día del mes en curso:
   
    CREATE OR REPLACE FUNCTION public.get_orders_by_almcnt_ctecve(p_almcnt integer, p_ctecve integer)
  RETURNS TABLE(
      id            bigint,
      order_date    timestamp without time zone,
      sync_date     timestamp without time zone,
      almcnt        integer,
      doccreated    timestamp without time zone,
      docupdated    timestamp without time zone,
      ctecve        integer,
      cliente_name  character varying,
      quantity      integer,
      unit_price    numeric,
      code          character varying,
      product_name  character varying,
      unit          character varying
  )
  LANGUAGE sql
  STABLE
  AS $$
      SELECT
          o.id,
          o.order_date,
          o.sync_date,
          o.almcnt,
          o.created_at   AS doccreated,
          o.updated_at   AS docupdated,
          c.ctecve,
          c.name         AS cliente_name,
          oi.quantity,
          oi.unit_price,
          p.code,
          p.name         AS product_name,
          p.unit
      FROM public.orders o
      JOIN public.customers c         ON o.customer_id   = c.id
      LEFT JOIN public.order_items oi ON oi.order_id     = o.id
      LEFT JOIN public.products    p  ON oi.product_id   = p.id
      WHERE o.almcnt = p_almcnt        
        AND c.ctecve = p_ctecve
        AND o.order_date >= CURRENT_DATE - INTERVAL '7 days';
  $$;
   *************************************************************************************/