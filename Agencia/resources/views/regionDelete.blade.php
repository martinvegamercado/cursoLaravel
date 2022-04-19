@extends( 'layouts.plantilla' )

@section('contenido')

    <h1>Confirmación de baja de una Region</h1>
    <div class="bg-light border-secondary col-6 mx-auto
                    shadow rounded p-4 text-danger">
        Se eliminará la Region: <br>
        <span class="lead">{{ $region->regNombre }}</span>
              
        <form action="/region/destroy" method="post">
            @csrf
            <input type="hidden" name="idRegion"
                   value="{{ $region->idRegion }}">
                   <input type="hidden" name="regNombre"
                   value="{{ $region->regNombre }}">
            <button class="btn btn-danger btn-block my-3">
                Confirmar baja
            </button>
            <a href="/regiones" class="btn btn-outline-secondary btn-block">
                Volver a panel
            </a>
        </form>
    </div>
    <script>

        Swal.fire(
            '¡Advertencia!',
            'Si pulsa el botón "Confirmar baja", se eliminará la region seleccionada.',
            'warning'
        );

    </script>

@endsection
