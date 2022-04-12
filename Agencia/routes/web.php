<?php

use Illuminate\Support\Facades\Route as Route;

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

//Route::get('/peticion', accion );
Route::get('/saludo', function ()
{
    return 'Hola mundo desde Laravel';
});
Route::get('/prueba', function ()
{
    return view('test');
});

// plantilla
Route::get('/inicio', function ()
{
    return view('inicio');
});

##### CRUD de regiones
Route::get('/regiones', function () {
    //obtenemos listado de regiones
    /*
    $regiones = DB::select('SELECT idRegion, regNombre

                                FROM regiones');
    */
    $regiones = DB::table('regiones')->get();

    return view('regiones', [ 'regiones'=>$regiones ]);
});

route::post(function (){});
##### CRUD de destinos
Route::get('/destinos', function () {
    //obtenemos listado de destinos

    //$destinos = DB::table('destinos')->get();

   //inner join
    $destinosJ= DB::table('destinos')
        ->join('regiones','destinos.idRegion','=','regiones.idRegion')
        ->select('destinos.*','regiones.regNombre')
        ->get();

//retorno simple
    //return view('destinos',[ 'destinos'=>$destinos ]);

    //retorno join
    return view('destinos',[ 'destinos'=>$destinosJ ]);
});
