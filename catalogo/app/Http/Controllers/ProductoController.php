<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Marca;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

         //join completo
        /*  $Productos = Producto::join('categorias', 'productos.idCategoria','=','categorias.idCategoria')
        ->join('marcas', 'productos.idMarca','=','marcas.idMarca')
        ->select('productos.*' , 'categorias.catNombre' , 'marcas.mkNombre')
        ->paginate(2);*/

        $Productos = Producto::with(['getMarca' , 'getCategoria'])->paginate(2);
       return view('productos',['Productos'=>$Productos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $marcas = Marca::all();
        $categorias = Categoria::all();
        return view('productoCreate' ,['marcas'=>$marcas ,
         'categorias'=>$categorias]);
    }

    //validacion

    private function validarForm(Request $request)
    {

        //validamos

        $request->validate(
            [
                'prdNombre' => 'required|min:2|max:30',
                'prdPrecio' => 'required|numeric|min:0',
                'idMarca' => 'required|integer',
                'idCategoria' => 'required|integer',
                'prdDescripcion' => 'required|min:2|max:150',
                'prdImagen' => 'mimes:jpg,jpeg,png,gif,svg,webp|max:2048'
            ],
        [
            'prdNombre.required'=>'El campo "Nombre del producto" es obligatorio.',
            'prdNombre.min'=>'El campo "Nombre del producto" debe tener como mínimo 2 caractéres.',
            'prdNombre.max'=>'El campo "Nombre" debe tener 30 caractéres como máximo.',
            'prdPrecio.required'=>'Complete el campo Precio.',
            'prdPrecio.numeric'=>'Complete el campo Precio con un número.',
            'prdPrecio.min'=>'Complete el campo Precio con un número positivo.',
            'idMarca.required'=>'Seleccione una marca.',
            'idMarca.integer'=>'Seleccione una marca.',
            'idCategoria.required'=>'Seleccione una categoría.',
            'idCategoria.integer'=>'Seleccione una categoría.',
            'prdDescripcion.required'=>'Complete el campo Descripción.',
            'prdDescripcion.min'=>'Complete el campo Descripción con al menos 3 caractéres',
            'prdDescripcion.max'=>'Complete el campo Descripción con 150 caractéres como máxino.',
            'prdImagen.mimes'=>'Debe ser una imagen.',
            'prdImagen.max'=>'Debe ser una imagen de 2MB como máximo.'
        ]
    );
    }
    //
    private function subirImagen(Request $request)
    {
        // si no enviaron imagen 'noDisponible.png' agregar
        $prdImagen = 'noDisponible.png';

        // si no enviaron imagen 'imgActual' update
        if($request->has('imgActual')){

            $prdImagen = $request->imgActual;
        }


        //si enviaron un archivo una imagen
        if($request->file('prdImagen'))
        {
            //renombramos archivo
            $extension = $request->file('prdImagen')->extension();
            $prdImagen = time().'.'.$extension;
            //subir archivo
            $request->file('prdImagen')
            ->move( public_path('productosimagenes'), $prdImagen );
        }

    return $prdImagen;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validamos
        $this->validarForm($request);
        //subir imagen
       $prdImagen =  $this->subirImagen($request);
        //instanciar
        $Producto = New Producto;
        $Producto->prdNombre = $request->prdNombre;
        $Producto->prdPrecio = $request->prdPrecio;
        $Producto->idMarca = $request->idMarca;
        $Producto->idCategoria = $request->idCategoria;
        $Producto->prdDescripcion = $request->prdDescripcion;
        $Producto->prdImagen = $prdImagen;
        $Producto->prdActivo = 1;
        $Producto->save();

        return redirect('/productos')
        ->with( [ 'mensaje'=>'Producto: '.$request->prdNombre.' agregado correctamente.' ] );

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //obtenemos datos del producto
        $producto = Producto::find($id);
        //obtenemos listados de marcas y categorias
        $marcas=Marca::all();
        $categorias= Categoria::all();
        return view('productoEdit',['marcas'=>$marcas ,
                                    'categorias'=>$categorias,
                                    'producto'=>$producto
                                   ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request )
    {
        //validacion
        $this->validarForm($request);
       // subir imagen
        $prdImagen =  $this->subirImagen($request);
        //obtenemos datos de producto por id
        $producto = Producto::find($request->idProducto);
        //asignamos valores
        $producto->prdNombre = $request->prdNombre;
        $producto->prdPrecio = $request->prdPrecio;
        $producto->idMarca = $request->idMarca;
        $producto->idCategoria = $request->idCategoria;
        $producto->prdDescripcion = $request->prdDescripcion;
        $producto->prdImagen = $prdImagen;
        $producto->prdActivo = 1;
        //guardamos
        $producto->save();
        //redireccion
        return redirect('/productos')
        ->with( [ 'mensaje'=>'Producto: '.$request->prdNombre.' Modificado correctamente.' ] );
    }


 /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function confirm($id)
    {

        $Producto = Producto::with(['getMarca' , 'getCategoria'])->find($id);
        return view('productoDelete' ,['Producto'=>$Producto]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Producto::destroy($request->idProducto);

        return redirect('/productos')
        ->with(['mensaje'=>'Producto: '.$request->prdNombre.' eliminado correctamente.']);
    }
}
