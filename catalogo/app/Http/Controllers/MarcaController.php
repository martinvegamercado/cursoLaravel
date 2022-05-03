<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;
use App\Models\Producto;
class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //obtener el listado de marcas y retornar la vista
           // $marcas = Marca::all();

        //ordenado y paginado con Paginate() y biitstrap
            $marcas = Marca::paginate('5');
        return view('marcas', ['marcas' => $marcas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('marcaCreate');
    }

    private function validateForm(Request $request)
    {

     //validate metodo de laravel
        $request -> validate(

        ['mkNombre'=> 'required|min:5|max:50' ],

        ['mkNombre.required'=>'El Campo es Obligatorio.',
        'mkNombre.min'=>'Minimo 5 Caracteres',
        'mkNombre.max'=>'Maximo 50 caracteres'
        ]);

    }
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // traigo dato
        $mkNombre = $request->mkNombre;
        //valido y muestro errores
        $this -> validateForm($request);
        //agrego dato instancio y asigno y guardo

        $Marca = new Marca;
        $Marca->mkNombre = $mkNombre;
        $Marca->save();

        //retorno con flashing
        return redirect('/marcas')->with(['mensaje'=> 'Marca:  ' . $mkNombre. ' Agregada Correctamente']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //busco la marca
      //  $Marcas =  Marca::where('idMarca',$id)->first();
        $Marca =  Marca::find($id);

        //retorno la vista con el arreglo
        return view('marcaEdit',['Marca' => $Marca]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $mkNombre = $request->mkNombre;
       // $idMarca = $request->idMarca;
        $this->validateForm($request);
        // obtengo los datos
        $Marca = Marca::find($request->idMarca);
        //asigno
        $Marca->mkNombre = $mkNombre;
        //guardo
        $Marca->save();
        //

        return redirect('/marcas')->with(['mensaje'=> 'Marca:  ' . $mkNombre. ' Modificada Correctamente']);
    }

    private function productoPorMarca( $idMarca )
    {
        //$check = Producto::where('idMarca', $idMarca)->first();
        $check = Producto::firstWhere('idMarca', $idMarca);
        //$check = Producto::where('idMarca', $idMarca)->count();
        return $check;
    }

    public function confirm($id)
    {
        //obtenemos datos de la marca
        $Marca = Marca::find($id);

        //si NO hay productos de ese marca
        if( !$this->productoPorMarca($id) )
        {
            //retornamos vista de confirmación
            return view('marcaDelete', [ 'Marca'=>$Marca ]);
        }
        //redirección con mensaje que no se puede eliminar
        return redirect('/marcas')
            ->with(
                [
                    'warning'=>'warning',
                    'mensaje'=>'No se puede eliminar la marca: '.$Marca->mkNombre.' ya que tiene productos relacionados.'
                ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request )
    {
        /*
         * $Marca = Marca::find($request->idMarca);
            $Marca->delete();
         */
        Marca::destroy( $request->idMarca );
        //retorno con flashing de mensaje ok
        return redirect('/marcas')
            ->with(['mensaje'=>'Marca: '.$request->mkNombre.' eliminada correctamente.']);
    }
}
