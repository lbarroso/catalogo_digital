<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ImageController;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InventorySyncController;


/*

|--------------------------------------------------------------------------

| Web Routes

|--------------------------------------------------------------------------

|

| Here is where you can register web routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| contains the "web" middleware group. Now create something great!

|

*/



Route::get('/', function () {

    return view('welcome');

});



Auth::routes();



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// view test adminLte

//Route::get('/plantilla', [App\Http\Controllers\HomeController::class, 'adminlte'])->name('adminlte');



// productos

Route::apiResource('products',App\Http\Controllers\ProductController::class)->middleware('auth');
Route::resource('releases',App\Http\Controllers\ReleaseController::class)->middleware('auth');


Route::get('products/categories/all',[App\Http\Controllers\ProductController::class,'categories'])->name('products.categories');

Route::get('productcreate',[App\Http\Controllers\ProductController::class,'productcreate'])->name('product.create')->middleware('auth');

Route::post('productstore',[App\Http\Controllers\ProductController::class,'productstore'])->name('product.store')->middleware('auth');

Route::get('productvalidate',[App\Http\Controllers\ProductController::class,'productvalidate'])->name('product.validation');


Route::resource('categories',App\Http\Controllers\CategoryController::class)->middleware('auth');

Route::resource('proveedores',App\Http\Controllers\ProveedoreController::class)->middleware('auth');

Route::resource('clientes',App\Http\Controllers\ClienteController::class)->middleware('auth');

Route::resource('empresas',App\Http\Controllers\EmpresaController::class)->middleware('auth');

// imagenes
Route::controller(ImageController::class)->name('images.')->group(function () {

    Route::get('images/product/table/{product}','table');

    Route::post('images/store','store')->name('store');

    Route::delete('images/{image}','destroy');

});


// menu reportes
Route::prefix('reports')->group(function(){
    Route::get('diarios',[App\Http\Controllers\ProductController::class,'reportsdiarios'])->name('daily.days');
    Route::get('cenefas',[App\Http\Controllers\ProductController::class,'cenefas'])->name('cenefas');
    Route::get('descendente',[App\Http\Controllers\ProductController::class,'reportsdescendente'])->name('descendente');   
    
});



// posicion excel
Route::get('/posicionalmacen', [App\Http\Controllers\ProductController::class, 'posicionexport'])->name('posicion.almacen');

// punto de venta
Route::apiResource('pvproducts',App\Http\Controllers\PvproductController::class)->middleware('auth');

// articulos SIAC
Route::get('articulos',[App\Http\Controllers\ArticuloController::class,'index']);
Route::get('import',[App\Http\Controllers\ArticuloController::class,'import'])->name('import');

Route::get('familias',[App\Http\Controllers\SiacfamiliaController::class,'index']);

// catalogo con imagenes
Route::post('catalogo/pdf',[App\Http\Controllers\ProductController::class,'downloadDompdf'])->name('catalogo.pdf');
Route::get('catalogo/pdf/{almcnt}',[App\Http\Controllers\ProductController::class,'descargarcatalogopdf'])->name('catalogo.download.pdf');

// cenefas con precio
Route::post('cenefas/precio/pdf', [App\Http\Controllers\ProductController::class, 'cenefasetiquetaprecio'])->name('cenefas.precio.pdf');
// cenefas en blanco
Route::get('cenefa/blanco/pdf', [App\Http\Controllers\ProductController::class, 'cenefasblanco'])->name('cenefa.blanco.pdf');
// cenefas de una factura
Route::get('cenefas-factura',[App\Http\Controllers\ArticuloController::class,'cenefasFactura'])->name('cenefas.factura');

// reutilizar banco de imagenes
Route::get('/duplicate', [App\Http\Controllers\DuplicateController::class, 'index'])->name('duplicate');
// eliminar imagenes
//Route::get('/delete', [App\Http\Controllers\DeleteController::class, 'index'])->name('delete');

Route::get('/chart', [App\Http\Controllers\HighchartController::class, 'handleChart']);

// pagina web
Route::post('/setAlmcnt', [App\Http\Controllers\WebPageController::class, 'setAlmcnt'])->name('setAlmcnt');
Route::get('/logout-session', [App\Http\Controllers\WebPageController::class, 'logoutSession'])->name('logoutSession');

//Route::get('/tienda/home', [App\Http\Controllers\WebPageController::class, 'index'])->name('webpages.home');
Route::match(['get', 'post'], '/tienda/home', [App\Http\Controllers\WebPageController::class, 'index'])->name('webpages.home');
Route::get('/tienda/categorias', [App\Http\Controllers\WebPageController::class, 'categories'])->name('webpages.categories');
Route::get('/tienda/categoria', [App\Http\Controllers\WebPageController::class, 'shopcategory'])->name('webpages.shopcategory');
Route::get('/tienda/categoria/tipo/{type}/{category_id}', [App\Http\Controllers\WebPageController::class, 'shopcategory'])->name('webpages.shopcategory.type');
Route::get('/tienda/articulo/{product_id}', [App\Http\Controllers\WebPageController::class, 'productdetail'])->name('webpages.productdetail');
Route::match(['get', 'post'],'/tienda/buscar', [App\Http\Controllers\WebPageController::class, 'search'])->name('webpages.search');
// existencia
Route::post('/consultar-existencia', [App\Http\Controllers\ExistenciaController::class, 'consultarExistencia'])->name('consultarExistencia');

// fondo de ahorro
Route::get('/fondo-ahorro',[App\Http\Controllers\FondoAhorroController::class,'index'])->name('fondo_ahorro.index');
Route::post('/fondo-ahorro/buscar',[App\Http\Controllers\FondoAhorroController::class,'buscar'])->name('fondo_ahorro.buscar');
Route::get('/fondo-ahorro/pdf/{id}',[App\Http\Controllers\FondoAhorroController::class,'pdf'])->name('fondo_ahorro.pdf');

// SUPABSE
Route::get('/ver-imagenes-productos', [\App\Http\Controllers\ProductImageTestController::class, 'index']);
Route::get('/supabase/products', [\App\Http\Controllers\SupabaseProductController::class, 'index'])->name('supabase.products.index');
Route::get('/exportar-productos-csv', [\App\Http\Controllers\ProductImageTestController::class, 'exportToCsv'])->name('productos.exportar.csv');
//syncronizacion de pedidos
Route::get('admin/orders/sync', [OrderController::class,'syncFromSupabase'])->name('orders.sync');
// Listado + botón
Route::get ('orders',[OrderController::class,'index']) ->name('orders.index');         
// Acción de sincronizar
Route::post('orders/sync',[OrderController::class,'sync'])  ->name('orders.sync')->middleware('auth');
Route::post('/inventory/sync',[InventorySyncController::class, 'sync'])->name('inventory.sync')->middleware('auth');

