@extends('admin.layout')

@section('content')

<h2 class="fw-bold mb-4">

    Bolsa de Trabajo

</h2>

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body">

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">

            @forelse($empresas as $empresa)

            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body d-flex flex-column">
                        <div class="mb-3">
                            <span class="badge bg-primary">{{ $empresa->modalidad }}</span>
                        </div>
                        <h5 class="card-title mb-2">{{ $empresa->titulo_puesto }}</h5>
                        <p class="text-muted mb-3">{{ $empresa->nombre_empresa ?? 'N/A' }}</p>
                        <p class="card-text text-secondary mb-4" style="min-height: 72px;">
                            {{ Str::limit($empresa->descripcion_puesto, 100) }}
                        </p>
                        <div class="mb-3">
                            <p class="mb-1"><strong>Ubicación:</strong></p>
                            <p class="mb-0">{{ $empresa->ubicacion }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-1"><strong>Salario:</strong></p>
                            <p class="mb-0">S/ {{ number_format($empresa->salario_minimo, 2) }} - S/ {{ number_format($empresa->salario_maximo, 2) }}</p>
                        </div>
                        <div class="mt-auto d-grid">
                            <button
                                class="btn btn-primary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modal{{ $empresa->id_aprobado }}"
                            >
                                Ver detalles
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            @empty

            <div class="col">
                <div class="alert alert-info mb-0">
                    No hay empresas aprobadas para mostrar.
                </div>
            </div>

            @endforelse

        </div>

    </div>

</div>

@foreach($empresas as $empresa)

<div class="modal fade" id="modal{{ $empresa->id_aprobado }}" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-sm">
            <div class="modal-header border-0">
                <div>
                    <h5 class="modal-title">{{ $empresa->titulo_puesto }}</h5>
                    <p class="text-muted mb-0">{{ $empresa->nombre_empresa ?? 'N/A' }} • {{ $empresa->modalidad }}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row gy-4">
                    <div class="col-lg-8">
                        <div class="mb-4">
                            <h6 class="fw-semibold">Descripción de la oferta</h6>
                            <p>{{ $empresa->descripcion_puesto }}</p>
                        </div>
                        <div class="mb-4">
                            <h6 class="fw-semibold">Requisitos</h6>
                            <p>{{ $empresa->requisitos }}</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="bg-light rounded-4 p-4 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <p class="text-uppercase text-secondary small mb-2">Detalles</p>
                                <p class="mb-2"><strong>Modalidad:</strong> {{ $empresa->modalidad }}</p>
                                <p class="mb-2"><strong>Ubicación:</strong> {{ $empresa->ubicacion }}</p>
                                <p class="mb-2"><strong>Categoría:</strong> {{ $empresa->categoria }}</p>
                                <p class="mb-2"><strong>Salario:</strong> S/ {{ number_format($empresa->salario_minimo, 2) }} - S/ {{ number_format($empresa->salario_maximo, 2) }}</p>
                            </div>
                            <div>
                                <a href="{{ asset($empresa->imagen_trabajo) }}" target="_blank" class="btn btn-outline-secondary btn-sm w-100 mb-2">Ver imagen trabajo</a>
                                @if(!empty($empresa->documento_aprobacion_pdf))
                                    <a href="{{ asset($empresa->documento_aprobacion_pdf) }}" target="_blank" class="btn btn-primary btn-sm w-100 mb-2">Ver documento aprobado</a>
                                    <form action="{{ url('admin/eliminar-documento/'.$empresa->id_aprobado) }}" method="POST" class="d-grid">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar documento</button>
                                    </form>
                                @else
                                    <p class="small text-muted">No hay documento aprobado aún.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="bg-white border rounded-4 p-4">
                            <h6 class="fw-semibold mb-3">Subir documento de validación</h6>
                            <form action="{{ url('admin/subir-documento/'.$empresa->id_aprobado) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <input type="file" name="documento_pdf" class="form-control" accept="application/pdf" required>
                                </div>
                                <button class="btn btn-success">Subir / Reemplazar documento</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection