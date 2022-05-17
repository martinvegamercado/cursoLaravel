@extends('layouts.plantilla')
@section('contenido')

    <h1>Modificar  un  producto</h1>

    <div class="alert bg-light p-4 col-8 mx-auto border shadow">
        <form action="/producto/update" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="form-group mb-4">
                <label for="prdNombre">Nombre del Producto</label>
                <input type="text" name="prdNombre"
                    value="{{ old('prdNombre' , $producto->prdNombre)}}"
                    class="form-control" id="prdNombre">
            </div>
            <input type="hidden" name="idProducto"
                value="{{$producto->idProducto }}">

             <input type="hidden" name="imgActual"
                value="{{$producto->prdImagen }}">

            <label for="prdPrecio">Precio del Producto</label>
            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <div class="input-group-text">$</div>
                </div>
                <input type="number" name="prdPrecio"
                value="{{ old('prdPrecio' , $producto->prdPrecio)}}"
                       class="form-control" id="prdPrecio" min="0" step="0.01">
            </div>

            <div class="form-group mb-4">
                <label for="idMarca">Marca</label>
                <select class="form-select" name="idMarca" id="idMarca">
                    <option value="">Seleccione una marca</option>
                    @foreach ($marcas as $marca )
                    <option  {{ old('idMarca' , $producto->idMarca) == $marca->idMarca ? 'selected' : '' }}  value="{{ $marca->idMarca}}" >{{ $marca->mkNombre}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-4">
                <label for="idCategoria">Categoría</label>
                <select class="form-select" name="idCategoria" id="idCategoria">
                    <option value="">Seleccione una categoría</option>
                    @foreach ($categorias as $categoria )
                    <option {{ old('idCategoria' , $producto->idCategoria) == $categoria->idCategoria ? 'selected' : '' }}  value="{{ $categoria->idCategoria}}" >{{ $categoria->catNombre}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-4">
                <label for="prdDescripcion">Descripción del Producto</label>
                <textarea name="prdDescripcion" class="form-control"
                 id="prdDescripcion">{{old('prdDescripcion' , $producto->prdDescripcion)}}</textarea>
            </div>

            <div>
                Imagen actual:
                <figure class="pt-3 d-flex justify-content-center">
                    <img src="/productosimagenes/{{ $producto->prdImagen }}" class="img-thumbnail">
                </figure>
            </div>

            Modificar Imagen (Opcional):
            <div class="custom-file mt-1 mb-4">
                <input type="file" name="prdImagen"  class="custom-file-input" id="customFileLang" lang="es">
                <label class="custom-file-label" for="customFileLang" data-browse="Buscar en disco">Seleccionar Archivo: </label>
            </div>

            <button class="btn btn-dark mr-3 px-4">Modificar producto</button>
            <a href="/productos" class="btn btn-outline-secondary">
                Volver a panel de productos
            </a>

        </form>
    </div>

    @if( $errors->any() )
    <div class="alert alert-danger col-8 mx-auto">
        <ul>
            @foreach( $errors->all() as $error )
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@endsection
