@extends('layouts.plantilla')
@section('contenido')

    <h1>Panel de administración de productos</h1>

    @if( session('mensaje') )
        <div class="alert alert-success">
            {{ session('mensaje') }}
        </div>
    @endif

    <div class="row my-3 text-start">
        <div class="col-11">
            <a href="" class="btn btn-outline-secondary">
                Dashboard
            </a>
        </div>
        <div class="col-1 text-end">
            <a href="" class="btn btn-outline-secondary">
                <i class="bi bi-plus-square"></i>
                Agregar
            </a>
        </div>
    </div>


    <div class="row mt-3">
        @foreach ($Productos as $Producto )


        <figure class="col-3">
            <img src=" productosimagenes/{{$Producto->prdImagen }} " class="img-thumbnail">
        </figure>
        <div class="col-8">
            <h2>{{ $Producto->prdNombre }}</h2>
            <span class="precio3">$ {{ $Producto->prdPrecio }}</span>
            <p>
                Marca: {{ $Producto->mkNombre }} <br>
                Categoría: {{ $Producto->catNombre }} <br>
                {{ $Producto->prdDescripcion }}
            </p>
        </div>
        <div class="col-1 d-grid d-md-block">
            <a href="/productos/edit/{{ $Producto->idProducto }}" class="btn btn-outline-secondary me-1">
                <i class="bi bi-pencil-square"></i>
                Modificar
            </a>
            <a href="/productos/delete/{{ $Producto->idProducto }}" class="btn btn-outline-secondary me-1">
                <i class="bi bi-trash"></i>
                &nbsp;Eliminar&nbsp;
            </a>
        </div>

        @endforeach
    </div>
{{ $Productos->links() }}

@endsection
