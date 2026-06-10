@extends('layouts.app')

@section('content')

<style>
    .section-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 60px 20px;
        text-align: center;
        border-radius: 15px;
        margin-bottom: 40px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
    }

    .section-header h1 {
        font-size: 2.5rem;
        font-weight: 900;
        margin: 0 0 15px 0;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    .section-header p {
        font-size: 1.1rem;
        opacity: 0.95;
        margin: 0;
    }

    .card-trabajo {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .card-trabajo:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.15);
    }

    .card-trabajo .card-header-img {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }

    .card-trabajo .card-header-img img {
        max-height: 180px;
        width: auto;
        max-width: 100%;
        object-fit: contain;
    }

    .card-trabajo .card-body {
        display: flex;
        flex-direction: column;
        flex: 1;
        padding: 25px;
    }

    .card-trabajo .titulo-oferta {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .card-trabajo .empresa-nombre {
        color: #667eea;
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 12px;
    }

    .card-trabajo .badges-container {
        display: flex;
        gap: 8px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    .card-trabajo .badge-custom {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-modalidad {
        background: #e8f4f8;
        color: #0288d1;
    }

    .badge-categoria {
        background: #f3e5f5;
        color: #7b1fa2;
    }

    .card-trabajo .descripcion-oferta {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 15px;
        flex: 1;
    }

    .card-trabajo .info-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid #e0e0e0;
        gap: 10px;
        flex-wrap: wrap;
    }

    .card-trabajo .ubicacion-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #666;
        font-size: 0.9rem;
    }

    .card-trabajo .tiempo-badge {
        font-size: 0.85rem;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 15px;
    }

    .tiempo-activo {
        background: #c8e6c9;
        color: #2e7d32;
    }

    .tiempo-vencido {
        background: #ffcdd2;
        color: #c62828;
    }

    .card-trabajo .salario-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .card-trabajo .btn-detalle {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 12px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
        text-align: center;
        margin-top: 15px;
    }

    .card-trabajo .btn-detalle:hover {
        transform: scale(1.02);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .empty-state h3 {
        color: #2c3e50;
        margin-bottom: 10px;
    }

    @media (max-width: 768px) {
        .section-header h1 {
            font-size: 1.8rem;
        }

        .section-header p {
            font-size: 1rem;
        }

        .card-trabajo .info-footer {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="section-header">
    <h1>💼 Bolsa de Trabajo</h1>
    <p>Descubre las mejores oportunidades laborales en tu región</p>
</div>

@php
    $estadoSeleccionado = request('estado', 'publicadas');
    $query = request()->except('estado');
    $baseUrl = url('/publicidad/bolsa-trabajo');
    $publicadasUrl = $baseUrl . (count($query) ? '?' . http_build_query(array_merge($query, ['estado' => 'publicadas'])) : '?estado=publicadas');
    $vencidasUrl = $baseUrl . (count($query) ? '?' . http_build_query(array_merge($query, ['estado' => 'vencidas'])) : '?estado=vencidas');
    $tituloSeccion = $estadoSeleccionado === 'vencidas' ? 'Ofertas vencidas' : 'Ofertas publicadas';
    $descripcionSeccion = $estadoSeleccionado === 'vencidas'
        ? 'Estas ofertas ya han pasado su fecha límite de postulación.'
        : 'Estas ofertas están abiertas y disponibles para postulación.';
@endphp

<div class="mb-4 text-center">
    <nav class="nav nav-pills justify-content-center">
        <a href="{{ $publicadasUrl }}" class="nav-link {{ $estadoSeleccionado === 'publicadas' ? 'active' : '' }}">Publicadas</a>
        <a href="{{ $vencidasUrl }}" class="nav-link {{ $estadoSeleccionado === 'vencidas' ? 'active' : '' }}">Vencidas</a>
    </nav>
</div>

<div class="mb-4 text-center">
    <h2 class="fw-semibold">{{ $tituloSeccion }}</h2>
    <p class="text-muted mb-0">{{ $descripcionSeccion }}</p>
</div>

@if($ofertas->isEmpty())
    <div class="empty-state">
        <div class="empty-state-icon">📭</div>
        <h3>{{ $estadoSeleccionado === 'vencidas' ? 'No hay ofertas vencidas' : 'No hay ofertas disponibles' }}</h3>
        <p>
            {{ $estadoSeleccionado === 'vencidas'
                ? 'No hay publicaciones vencidas en este momento.'
                : 'En este momento no hay publicaciones activas de bolsa de trabajo. Vuelve pronto para ver nuevas oportunidades.'
            }}
        </p>
    </div>
@else
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 mb-5">
        @foreach($ofertas as $oferta)
            <div class="col">
                <div class="card card-trabajo">
                    @php
                        $imgExt = !empty($oferta->imagen_trabajo) ? strtolower(pathinfo($oferta->imagen_trabajo, PATHINFO_EXTENSION)) : null;
                        $imgAllowed = ['jpg','jpeg','png','gif','webp','svg'];
                    @endphp
                    @if(!empty($oferta->imagen_trabajo) && in_array($imgExt, $imgAllowed))
                        <div class="card-header-img">
                            <img src="{{ asset($oferta->imagen_trabajo) }}" alt="Imagen de la oferta">
                        </div>
                    @endif

                    <div class="card-body">
                        @php
                            $isVencida = \Carbon\Carbon::parse($oferta->fecha_limite_postulacion)->isPast();
                        @endphp
                        <div class="mb-2">
                            <span class="badge {{ $isVencida ? 'bg-danger' : 'bg-success' }} text-white px-3 py-2">
                                {{ $isVencida ? 'Vencida' : 'Activa' }}
                            </span>
                        </div>
                        <h5 class="titulo-oferta">{{ $oferta->titulo_puesto }}</h5>
                        <p class="empresa-nombre">{{ $oferta->nombre_empresa ?? 'Empresa' }}</p>

                        <div class="badges-container">
                            <span class="badge-custom badge-modalidad">{{ $oferta->modalidad }}</span>
                            <span class="badge-custom badge-categoria">{{ $oferta->categoria }}</span>
                        </div>

                        <p class="descripcion-oferta">
                            {{ Str::limit($oferta->descripcion_puesto, 120) }}
                        </p>

                        <div class="info-footer">
                            @php
                                $fechaLimite = \Carbon\Carbon::parse($oferta->fecha_limite_postulacion);
                                $ahora = \Carbon\Carbon::now();
                                if ($ahora->greaterThan($fechaLimite)) {
                                    $tiempoRestante = 'Publicación vencida';
                                    $tiempoClass = 'tiempo-vencido';
                                } else {
                                    $segundosRestantes = $fechaLimite->getTimestamp() - $ahora->getTimestamp();
                                    $dias = (int) floor($segundosRestantes / 86400);
                                    $horas = (int) floor(($segundosRestantes % 86400) / 3600);
                                    if ($dias > 0) {
                                        $tiempoRestante = $dias . ' día' . ($dias === 1 ? '' : 's');
                                        if ($horas > 0) {
                                            $tiempoRestante .= ' ' . $horas . 'h';
                                        }
                                    } else {
                                        $tiempoRestante = $horas . ' hora' . ($horas === 1 ? '' : 's');
                                    }
                                    $tiempoClass = 'tiempo-activo';
                                }
                            @endphp
                            <span class="ubicacion-badge">📍 {{ $oferta->ubicacion }}</span>
                            <span class="tiempo-badge {{ $tiempoClass }}">⏰ {{ $tiempoRestante }}</span>
                            <span class="salario-badge">S/ {{ number_format($oferta->salario_minimo, 2) }}</span>
                        </div>

                        <a href="{{ url('detalle-oferta/'.$oferta->id_aprobado) }}" class="btn-detalle">Ver Detalles →</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection