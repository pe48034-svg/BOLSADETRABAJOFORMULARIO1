@extends('layouts.app')

@section('content')

<h1 class="fw-bold mb-4">Publicidad - Servicios</h1>

<p class="text-muted mb-4">
    Esta sección presenta la publicidad de servicios en un sitio independiente del portal general.
</p>

<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body">
        <h3 class="fw-bold mb-3">Publica tus servicios</h3>
        <p class="text-muted">
            Registra tus servicios y conecta con clientes que buscan soluciones empresariales.
        </p>
        <a href="{{ url('registro/servicios') }}" class="btn btn-primary me-2">Registrar servicio</a>
        <span class="badge bg-secondary">Próximamente listado público</span>
    </div>
</div>

@endsection
