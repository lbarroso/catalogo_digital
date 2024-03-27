SELECT articulos.artcve,
$almcnt almcnt, 
articulos.artcve,
articulos.artdesc,
articulos.prvcve,
articulos.artstatus,
articulos.famcve,
articulos.codbarras,
'artmarca', 
'artestilo', 
'artcolor', 
'artseccion', 
'arttalla', 
((articul1.inviniuni+articul1.inventuni-articul1.invsaluni)*ARTHISt.artcap)+(articul1.invinires+articul1.inventres-articul1.invsalres) AS Er,
 'artimg', 
 '0',
 ((arthist.artprcventa*arthist.artiva/100)+arthist.artprcventa)/arthist.artcap AS pieza,
 arthist.artgms,
 arthist.artmed,
 '0', 
 '0', 
 '0', 
 'artdetalle', 
 '2024-11-03', 
 '2024-11-03'
FROM articulos INNER JOIN (arthist INNER JOIN articul1 ON (arthist.arthist = articul1.invhist) AND (arthist.artcve = articul1.artcve)) ON articulos.artcve = arthist.artcve
Where (((articulos.artstatus) = 'A' ) And (articul1.invmes = 2)  ) 
ORDER BY articulos.famcve, articulos.artcve, articul1.invtpoinv, articul1.invhist DESC

-- products con imagenes --
SELECT p.artcve, p.artdesc, p.artpesoum, p.stock, m.id, m.file_name, p.artseccion, c.name
FROM products p 
LEFT JOIN media m ON p.id = m.model_id 
INNER JOIN categories c ON p.category_id = c.id 
WHERE p.artstatus ='A' AND  p.artstatus='A' AND p.almcnt =2039
GROUP BY p.artcve 
ORDER BY p.category_id, p.artcve, p.artseccion;

-- articulos nuevos --
SELECT a.artcve,a.almcnt,a.artdesc,a.prvcve,a.artstatus,a.category_id,a.codbarras,a.artmarca,a.artestilo,a.artcolor,
a.artseccion,a.arttalla,a.stock,a.artimg,a.artprcosto,a.artprventa,a.artpesogrm,a.artpesoum,a.artganancia,
a.eximin,a.eximax,a.artdetalle,a.created_at,a.updated_at 
FROM articulos a
LEFT JOIN products b ON a.artcve = b.artcve
WHERE b.artcve IS NULL

-- actualizar precios y existencias en la tabla products
UPDATE products
JOIN articulos ON products.artcve = articulos.artcve
SET products.stock = articulos.stock,
    products.artprventa = articulos.artprventa
WHERE products.almcnt = 2031;

--Productos nuevos 
SELECT releases.artcve, products.artdesc, products.artpesoum, products.artprventa, products.artseccion, products.stock, categories.name, media.file_name, media.id
FROM releases
INNER JOIN products ON products.artcve = releases.artcve AND products.almcnt = releases.almcnt
INNER JOIN categories ON products.category_id = categories.id
INNER JOIN media ON products.id = media.model_id
WHERE releases.almcnt = 2039


--POSCION EXCEL
SELECT products.artcve, products.artdesc, products.artseccion, products.artpesoum, products.artprventa, products.stock
FROM products 
WHERE products.stock > 0 AND products.almcnt = 2039 
ORDER BY products.category_id, products.artcve, products.artseccion


UPDATE media
SET url = CONCAT('http://10.101.21.24/catalogo/public/storage/', id, '/', file_name)
WHERE almcnt=2039;

--banco de imagenes--
CREATE VIEW viewimages AS
SELECT products.artcve, products.codbarras,
media.id media_id, media.model_type, media.model_id, media.uuid, media.collection_name, media.name, media.file_name, media.mime_type, media.disk, media.conversions_disk,
media.size, media.manipulations, media.custom_properties, media.generated_conversions, media.responsive_images, media.order_column
FROM media
INNER JOIN products ON media.model_id = products.id
WHERE products.almcnt = 2039
GROUP BY products.id;

--reutilizar imagenes--SELECT products.id product_id, viewimages.media_id
SELECT products.id, viewimages.media_id,
viewimages.model_type, viewimages.model_id, viewimages.uuid, viewimages.collection_name, viewimages.name, viewimages.file_name, viewimages.mime_type, viewimages.disk, viewimages.conversions_disk, 
viewimages.size, viewimages.manipulations, viewimages.custom_properties, viewimages.generated_conversions, viewimages.responsive_images, viewimages.order_column
FROM products
INNER JOIN viewimages ON products.artcve = viewimages.artcve
WHERE products.almcnt = 2033

http://10.101.21.24/catalogo/public/storage/2512/conversions/
BAÑO-REDONDO-DE-LÁMINA-GALVANIZADA---5---2105-preview.jpg
BAÑO-REDONDO-DE-LÁMINA-GALVANIZADA---5---2105.jpg

