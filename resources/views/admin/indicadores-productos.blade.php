@extends('admin.layout')

@section('content')

<div class="page-header">
    <h2>Indicadores - Productos</h2>
    <p class="text-muted">Métricas específicas de publicaciones de productos.</p>
</div>

<div class="row gy-4">
    <div class="col-md-6">
        <div class="indicator-card">
            <div class="indicator-title">Publicaciones</div>
            <div class="indicator-value">--</div>
            <div class="indicator-meta">Total de publicaciones de productos</div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="indicator-card">
            <div class="indicator-title">Productos aprobados</div>
            <div class="indicator-value">--</div>
            <div class="indicator-meta">Cantidad de productos aprobados</div>
        </div>
    </div>
</div>

@endsection
