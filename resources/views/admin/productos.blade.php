@extends('admin.layout')

@section('content')

<h2 class="fw-bold mb-4">

    Productos Aprobados

</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card border-0 shadow-sm rounded-4">

    <div class="table-responsive">

        <table class="table align-middle">

            <thead>

                <tr>

                    <th>Empresa</th>

                    <th>Producto</th>

                    <th>Categoría</th>

                    <th>Ubicación</th>

                    <th>Estado</th>

                    <th>Acciones</th>

                </tr>

            </thead>

            <tbody>

                @foreach($productos as $producto)

                <tr>

                    <td>

                        {{ $producto->nombre_empresa ?? 'N/A' }}

                    </td>

                    <td>

                        {{ $producto->nombre_producto }}

                    </td>

                    <td>

                        {{ $producto->categoria }}

                    </td>

                    <td>

                        {{ $producto->ubicacion_ciudad }}

                    </td>

                    <td>

                        <span class="badge bg-success">

                            APROBADO

                        </span>

                    </td>

                    <td>

                        <a
                            href="{{ url('admin/ver-producto-aprobado/'.$producto->id_aprobado) }}"
                            class="btn btn-primary btn-sm"
                        >

                            Ver

                        </a>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection