<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
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

//ruteo sin metodo con vista directa
Route::view('/inicio', 'inicio');

####crud de marcas ######

use App\Http\Controllers\MarcaController;


Route::get('/marcas',[MarcaController::class,'index']);

Route::get('/marca/create',[MarcaController::class, 'create']);

Route::post('/marca/store', [MarcaController::class, 'store']);

Route::get('/marca/edit/{id}', [MarcaController::class, 'edit']);

Route::patch('/marca/update',[MarcaController::class, 'update']);

Route::get('/marca/delete/{id}', [ MarcaController::class, 'confirm' ] );

Route::delete('/marca/destroy', [ MarcaController::class, 'destroy' ] );


####crud de categorias ######


Route::get('/categorias', [CategoriaController::class, 'index']);

Route::get('/categoria/create', [CategoriaController::class, 'create']);

Route::post('/categoria/store', [CategoriaController::class, 'store']);

Route::get('/categoria/edit/{id}', [CategoriaController::class, 'edit']);

Route::patch('/categoria/update',[CategoriaController::class, 'update']);

Route::get('/categoria/delete/{id}',[CategoriaController::class, 'confirm']);

Route::delete('/categoria/destroy', [CategoriaController::class, 'destroy']);

########   crud de productos  #######
use App\Http\Controllers\ProductoController;

Route::get('/productos', [ ProductoController::class, 'index' ]);

Route::get('/producto/create', [ ProductoController::class, 'create' ]);

Route::post('/producto/store', [ProductoController::class, 'store']);
