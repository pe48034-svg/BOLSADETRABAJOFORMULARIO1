@extends('layouts.app')

@section('content')

<h1 class="fw-bold mb-4">Publicidad - Bolsa de Trabajo</h1>

<p class="text-muted mb-4">
    Aquí se muestran únicamente las publicaciones activas de Bolsa de Trabajo.
</p>

@if($ofertas->isEmpty())
    <div class="alert alert-secondary">No hay ofertas de bolsa de trabajo disponibles en este momento.</div>
@else
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
        @foreach($ofertas as $oferta)
            <div class="col">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">

                    @php
                        $imgExt = !empty($oferta->imagen_trabajo) ? strtolower(pathinfo($oferta->imagen_trabajo, PATHINFO_EXTENSION)) : null;
                        $imgAllowed = ['jpg','jpeg','png','gif','webp','svg'];
                    @endphp
                    @if(!empty($oferta->imagen_trabajo) && in_array($imgExt, $imgAllowed))
                        <div class="mb-2 rounded-4 shadow-sm" style="background:#f8f9fa; max-height:180px; overflow:hidden; display:flex; align-items:center; justify-content:center;">
                            <img src="{{ asset($oferta->imagen_trabajo) }}" class="img-fluid" alt="Imagen de la oferta" style="max-height:180px; width:auto; max-width:100%; object-fit:contain;">
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="fw-bold mb-2">{{ $oferta->titulo_puesto }}</h5>
                        <p class="text-muted mb-2">{{ $oferta->nombre_empresa ?? 'N/A' }}</p>
                        <div class="mb-3">
                            <span class="badge bg-secondary me-1">{{ $oferta->modalidad }}</span>
                            <span class="badge bg-info text-dark">{{ $oferta->categoria }}</span>
                        </div>
                        <p class="text-muted mb-3" style="font-size:.95rem;">
                            {{ Str::limit($oferta->descripcion_puesto, 100) }}
                        </p>
                        <div class="mt-auto">
                            @php
                                $fechaLimite = \Carbon\Carbon::parse($oferta->fecha_limite_postulacion);
                                $ahora = \Carbon\Carbon::now();
                                if ($ahora->greaterThan($fechaLimite)) {
                                    $tiempoRestante = 'Publicación vencida';
                                    $tiempoClass = 'bg-danger';
                                } else {
                                    $segundosRestantes = $fechaLimite->getTimestamp() - $ahora->getTimestamp();
                                    $dias = (int) floor($segundosRestantes / 86400);
                                    $horas = (int) floor(($segundosRestantes % 86400) / 3600);
                                    if ($dias > 0) {
                                        $tiempoRestante = 'Quedan ' . $dias . ' día' . ($dias === 1 ? '' : 's');
                                        if ($horas > 0) {
                                            $tiempoRestante .= ' y ' . $horas . ' hora' . ($horas === 1 ? '' : 's');
                                        }
                                    } else {
                                        $tiempoRestante = 'Quedan ' . $horas . ' hora' . ($horas === 1 ? '' : 's');
                                    }
                                    $tiempoClass = 'bg-success';
                                }
                            @endphp
                            <div class="d-flex justify-content-between align-items-center mb-3 gap-2 flex-wrap">
                                <span class="text-secondary small">{{ $oferta->ubicacion }}</span>
                                <span class="badge {{ $tiempoClass }} text-white">{{ $tiempoRestante }}</span>
                                <span class="badge bg-primary">S/ {{ number_format($oferta->salario_minimo, 2) }} - S/ {{ number_format($oferta->salario_maximo, 2) }}</span>
                            </div>
                            <a href="{{ url('detalle-oferta/'.$oferta->id_aprobado) }}" class="btn btn-outline-primary w-100">Ver detalle</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection

