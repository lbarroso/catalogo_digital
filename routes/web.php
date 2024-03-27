<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;



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
Route::get('catalogopdf',[App\Http\Controllers\ProductController::class,'downloadDompdf'])->name('catalogo.pdf');

// reutilizar banco de imagenes
Route::get('/duplicate', [App\Http\Controllers\DuplicateController::class, 'index'])->name('duplicate');