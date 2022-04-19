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

Route::get('/region/create', function ()
{
    return view('regionCreate');
});

Route::post('/region/store', function ()
{
    $regNombre = request()->regNombre;
    //insertamos en tabla regiones
    /*DB::insert(
                'INSERT INTO regiones
                            ( regNombre )
                        VALUE
                            ( :regNombre )',
                [ $regNombre ]
            );*/
    DB::table('regiones')
            ->insert([ 'regNombre'=>$regNombre ]);

    return redirect('/regiones')
                ->with(['mensaje'=>'Región '.$regNombre.' agregada correctamente']);
});

Route::get('/region/edit/{id}', function ($id)
{
    //obtenemos datos de la región por su ID
    /*$region = DB::select('SELECT idRegion, regNombre
                            FROM regiones
                            WHERE idRegion = :idRegion',
                        [ $id ]);*/
    $region = DB::table('regiones')
                    ->where( 'idRegion', $id )
                    ->first(); //fetch
    //retornamos vista del formulario con sus datos cargados
    return view('regionEdit', [ 'region' => $region ]);
});

Route::post('/region/update', function ()
{
    $idRegion  = request()->idRegion;
    $regNombre = request()->regNombre;
    /*DB::update( 'UPDATE regiones
                    SET
                        regNombre = :regNombre
                    WHERE idRegion = :idRegion',
                [ $regNombre, $idRegion ]);*/
    DB::table('regiones')
        ->where( 'idRegion', $idRegion )
        ->update( [ 'regNombre'=>$regNombre ] );
    return redirect('/regiones')
        ->with(['mensaje'=>'Región '.$regNombre.' modificada correctamente']);
});

Route::get('/region/delete/{id}', function ($id)
{    
    //borrar region
    /*DB::delete( 'DELETE FROM regiones
                    WHERE idRegion = :idRegion',
                [ $id]);*/
    DB::table('regiones')
        ->where( 'idRegion', $id )
        ->delete();
    return redirect('/regiones')
        ->with(['mensaje'=>'Región Eliminada correctamente']);
});





##### CRUD de destinos

Route::get('/destinos', function () {
    //obtenemos listado de destinos

    //$destinos = DB::table('destinos')->get();

   //inner join
    $destinosJ= DB::table('destinos')
        ->orderBy('destNombre', 'asc')
        ->join('regiones','destinos.idRegion','=','regiones.idRegion')
        ->select('destinos.*','regiones.regNombre')
        ->get();

//retorno simple
    //return view('destinos',[ 'destinos'=>$destinos ]);

    //retorno join
    return view('destinos',[ 'destinos'=>$destinosJ ]);
});

Route::get('destino/create', function () {
    //paso las regiones para llenar el combo
    $regionesd = DB::table('regiones')->get();
    return view('destinoCreate',['regiones'=>$regionesd]);
});

Route::post('destino/create', function () {
    //inserto las regiones
    $destNombre = request()->destNombre;
    $idRegion = request()->idRegion;
    $destPrecio  = request()->destPrecio;
    $destAsientos = request()->destAsientos;
    $destDisponibles = request()->destDisponibles;

 /*DB::insert(
                'INSERT INTO destinos
                            ( destNombre )
                        VALUE
                            ( :destNombre ,  )',
                [ $destNombre ]
            );*/
            DB::table('destinos')
            ->insert([ 'destNombre'=>$destNombre , 'idRegion'=>$idRegion , 'destPrecio'=>$destPrecio ,'destAsientos'=>$destAsientos ,'destDisponibles'=>$destDisponibles]);
    return redirect('/destinos')
                ->with(['mensaje'=>'Destino  ' .$destNombre. ' agregado correctamente']);

});

Route::get('/destino/edit/{id}', function ($id) {
    
$destino = DB::table('destinos')->where('idDestino', $id)
->join('regiones','destinos.idRegion','=','regiones.idRegion')
->select('destinos.*','regiones.*')
->first();;



$regionesd = DB::table('regiones')->get();
return view('destinoEdit', [ 'destino' => $destino , 'regiones'=>$regionesd]);
});

Route::post('/destino/update', function () {

    $idDestino = request()->idDestino;
    $destNombre = request()->destNombre;
    $idRegion = request()->idRegion;
    $destPrecio  = request()->destPrecio;
    $destAsientos = request()->destAsientos;
    $destDisponibles = request()->destDisponibles;

        DB::table('destinos')
        ->where('idDestino',$idDestino)
        ->update(['destNombre'=> $destNombre , 'idRegion'=>$idRegion , 'destPrecio'=>$destPrecio ,'destAsientos'=>$destAsientos ,'destDisponibles'=>$destDisponibles]);

        return redirect('/destinos')
        ->with(['mensaje'=>'Destino  ' .$destNombre. ' Modificado correctamente']);
});

Route::get('/destino/delete/{id}', function ( $id )
{
   $destino = DB::table('destinos as d')
               ->join('regiones as r','d.idRegion','=','r.idRegion')
               ->select('d.*','r.*')
               ->where( 'd.idDestino', $id )
               ->first();

    return view('/destinoDelete', [ 'destino' => $destino ]);
});
Route::post('/destino/destroy', function ()
{
    $idDestino = request()->idDestino;
    $destNombre = request()->destNombre;
    DB::table('destinos')
        ->where( 'idDestino', $idDestino )
        ->delete();
    return redirect('/destinos')
        ->with(['mensaje'=>'Destino '.$destNombre.' eliminado correctamente']);

});