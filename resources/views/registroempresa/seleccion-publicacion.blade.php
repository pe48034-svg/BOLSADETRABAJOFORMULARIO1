@extends('layouts.app')

@section('content')

<h1 class="fw-bold mb-4">
    Registro de Empresa
</h1>

@include('components.stepper', ['paso' => 1])

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-5">

        <h3 class="fw-bold mb-3">
            ¿Qué deseas publicar?
        </h3>

        <p class="text-muted mb-5">
            Selecciona una opción
        </p>

        <div class="row g-4">

            <!-- PRODUCTOS -->
            <div class="col-md-4">

                <a href="{{ url('registro/productos') }}"
                   class="card p-4 h-100 opcion-card text-decoration-none text-reset">

                    <h4>📦 Productos</h4>

                    <p class="text-muted">
                        Publica productos de tu empresa.
                    </p>

                </a>

            </div>


            <!-- SERVICIOS -->
            <div class="col-md-4">

                <a href="{{ url('registro/servicios') }}"
                   class="card p-4 h-100 opcion-card text-decoration-none text-reset">

                    <h4>🛠 Servicios</h4>

                    <p class="text-muted">
                        Publica servicios empresariales.
                    </p>

                </a>

            </div>


            <!-- BOLSA TRABAJO -->
            <div class="col-md-4">

                <a href="{{ url('registro/bolsa-trabajo') }}"
                   class="card p-4 h-100 opcion-card text-decoration-none text-reset">

                    <h4>💼 Bolsa de Trabajo</h4>

                    <p class="text-muted">
                        Publica ofertas laborales.
                    </p>

                </a>

            </div>

        </div>

    </div>

</div>

<style>

    .opcion-card{
        cursor:pointer;
        transition:0.3s;
        border-radius:20px;
    }

    .opcion-card:hover{
        transform:translateY(-5px);
        box-shadow:0 10px 25px rgba(0,0,0,0.08);
        border-color:#0d6efd;
    }

</style>

@endsection