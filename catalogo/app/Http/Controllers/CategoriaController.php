<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
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

        $categorias = Categoria::orderby('catNombre','asc')->get();

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
