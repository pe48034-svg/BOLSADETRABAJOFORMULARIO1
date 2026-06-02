@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-12">
        <h1 class="fw-bold mb-3">{{ $producto->nombre_producto }}</h1>
        <p class="text-muted mb-4">{{ $producto->nombre_empresa ?? 'N/A' }}</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            @php
                $imgExt = !empty($producto->imagen_producto) ? strtolower(pathinfo($producto->imagen_producto, PATHINFO_EXTENSION)) : null;
                $imgAllowed = ['jpg','jpeg','png','gif','webp','svg'];
            @endphp
            @if(!empty($producto->imagen_producto) && in_array($imgExt, $imgAllowed))
                <div class="mb-4 rounded-4 shadow-sm" style="background:#f8f9fa; max-height:380px; overflow:hidden; display:flex; align-items:center; justify-content:center;">
                    <img src="{{ asset($producto->imagen_producto) }}" class="img-fluid" alt="Imagen del producto" style="max-height:380px; width:auto; max-width:100%; object-fit:contain;">
                </div>
            @endif

            <div class="mb-4">
                <span class="badge bg-info text-dark me-1">{{ $producto->categoria }}</span>
                <span class="badge bg-secondary">{{ $producto->ubicacion_ciudad }}</span>
            </div>

            <h4 class="fw-bold mb-3">Descripción</h4>
            <p class="text-muted">{{ $producto->descripcion }}</p>

            <hr>

            <h4 class="fw-bold mb-3">Detalles del producto</h4>
            <div class="row g-3">
                <div class="col-md-6">
                    <strong>Ubicación</strong>
                    <p class="mb-0">{{ $producto->ubicacion_ciudad }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Correo</strong>
                    <p class="mb-0">{{ $producto->correo_contacto }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Teléfono</strong>
                    <p class="mb-0">{{ $producto->telefono_contacto }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Dirección atención</strong>
                    <p class="mb-0">{{ $producto->direccion_atencion }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Redes sociales</strong>
                    <p class="mb-0">{{ $producto->redes_sociales ?? 'No disponible' }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Publicado</strong>
                    <p class="mb-0">{{ $producto->fecha_inicio }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Vence</strong>
                    <p class="mb-0">{{ $producto->fecha_fin }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <div class="mb-4">
                <small class="text-uppercase text-muted">Contacto</small>
                <h5 class="fw-bold mb-3">Información</h5>
                <p class="mb-2"><strong>Empresa:</strong> {{ $producto->nombre_empresa }}</p>
                <p class="mb-2"><strong>Correo:</strong> {{ $producto->correo_contacto }}</p>
                <p class="mb-2"><strong>Teléfono:</strong> {{ $producto->telefono_contacto }}</p>
                <p class="mb-0"><strong>Dirección:</strong> {{ $producto->direccion_atencion }}</p>
            </div>

            <div class="d-grid gap-2">
                <a href="tel:{{ $producto->telefono_contacto }}" class="btn btn-primary">Llamar ahora</a>
                <a href="mailto:{{ $producto->correo_contacto }}" class="btn btn-outline-primary">Enviar correo</a>
                <a href="{{ url('publicidad/productos') }}" class="btn btn-secondary">Volver a Productos</a>
            </div>
        </div>
    </div>
</div>

@endsection