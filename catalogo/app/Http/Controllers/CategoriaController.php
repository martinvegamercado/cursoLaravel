<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Producto;
class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Obtener el listado de categorias y devolver listado ordenado por nombre

        $categorias = Categoria::paginate(5);

        return view('categorias',['categorias'=>$categorias]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categoriaCreate');
    }
    //validacion

    private function validateForm(Request $request)

    {
        $request->validate(
            //reglas de validacion
            ['catNombre'=> 'required|min:5|max:50' ],
            ['catNombre.required'=>'El Campo es Obligatorio.',
            'catNombre.min'=>'Minimo 5 Caracteres',
            'catNombre.max'=>'Maximo 50 caracteres'
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
        $catNombre = $request->catNombre;

        //valido datos
        $this->validateForm($request);

        //agregar dato y guardo
        $Categoria = new Categoria;
        $Categoria->catNombre = $catNombre;
        $Categoria->save();
        //retorno vista con flashing

        return redirect('/categorias')->with(['mensaje'=> 'Categoria:  ' . $catNombre. ' Agregada Correctamente']);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $Categoria = Categoria::find($id);

        return view('catagoriaEdit', ['Categoria' => $Categoria]);
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
        // traigo el nombre de la categoria
        $catNombre = $request->catNombre;
        //valido reglas
        $this->validateForm($request);
        // busco la categoria a modificar
        $Categoria = Categoria::find($request->idCategoria);
        // asigno valores
        $Categoria->catNombre = $catNombre;
        //guardo
        $Categoria->save();

        //retorno vista con mensaje
        return redirect('/categorias')->with(['mensaje'=> 'Categoria:  ' . $catNombre. ' Modificada Correctamente']);
    }

//validar categoria producto

private function productoPorCategoria( $idCategoria )
{
    # code...
    $check = Producto::firstWhere('idCategoria', $idCategoria);

    return $check;
}





/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirm($id)
    {
        //obtenemos la categoria
      $Categoria = Categoria::find($id);
         //si NO hay productos de ese marca
         if(!$this->productoPorCategoria($id))
         {
            //retorno vista con el campo
            return view('categoriaDelete',['Categoria'=>$Categoria]);
         }
         //redirección con mensaje que no se puede eliminar
         return redirect('/categorias')
         ->with([
            'warning'=>'warning',
            'mensaje'=>'No se puede eliminar la categoria: '.$Categoria->catNombre.' ya que tiene productos relacionados.'

                ]);
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Categoria::destroy($request->idCategoria);

        return redirect('/categorias')
        ->with(['mensaje'=>'Categoria: '.$request->catNombre.' eliminada correctamente.']);
    }
}
