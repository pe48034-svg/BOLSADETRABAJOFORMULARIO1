@extends('layouts.app')

@section('content')

<style>
    .section-header {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 60px 20px;
        text-align: center;
        border-radius: 15px;
        margin-bottom: 40px;
        box-shadow: 0 10px 30px rgba(245, 87, 108, 0.2);
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

    .card-producto {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .card-producto:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(245, 87, 108, 0.15);
    }

    .card-producto .card-header-img {
        background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }

    .card-producto .card-header-img img {
        max-height: 200px;
        width: auto;
        max-width: 100%;
        object-fit: contain;
    }

    .card-producto .card-body {
        display: flex;
        flex-direction: column;
        flex: 1;
        padding: 25px;
    }

    .card-producto .titulo-producto {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .card-producto .empresa-nombre {
        color: #f5576c;
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 12px;
    }

    .card-producto .badges-container {
        display: flex;
        gap: 8px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    .card-producto .badge-custom {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-categoria {
        background: #ffeaa7;
        color: #d63031;
    }

    .badge-ubicacion {
        background: #fab1a0;
        color: #d63031;
    }

    .card-producto .descripcion-producto {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 15px;
        flex: 1;
    }

    .card-producto .info-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid #e0e0e0;
        gap: 10px;
        flex-wrap: wrap;
    }

    .card-producto .email-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #666;
        font-size: 0.85rem;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-producto .tiempo-badge {
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

    .card-producto .buttons-group {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .card-producto .btn-custom {
        flex: 1;
        border: none;
        border-radius: 10px;
        padding: 10px 15px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        text-decoration: none;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-detalle {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .btn-detalle:hover {
        transform: scale(1.02);
        box-shadow: 0 5px 15px rgba(245, 87, 108, 0.4);
        color: white;
    }

    .btn-telefono {
        background: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #c8e6c9;
    }

    .btn-telefono:hover {
        background: #c8e6c9;
        color: #2e7d32;
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

        .card-producto .info-footer {
            flex-direction: column;
            align-items: flex-start;
        }

        .card-producto .buttons-group {
            flex-direction: column;
        }

        .card-producto .btn-custom {
            width: 100%;
        }
    }
</style>

<div class="section-header">
    <h1>🛍️ Productos</h1>
    <p>Explora nuestro catálogo de productos disponibles</p>
</div>

@if($productos->isEmpty())
    <div class="empty-state">
        <div class="empty-state-icon">📦</div>
        <h3>No hay productos disponibles</h3>
        <p>En este momento no hay productos publicados. Vuelve pronto para ver nuevas ofertas.</p>
    </div>
@else
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 mb-5">
        @foreach($productos as $producto)
            <div class="col">
                <div class="card card-producto">
                    @php
                        $imgExt = !empty($producto->imagen_producto) ? strtolower(pathinfo($producto->imagen_producto, PATHINFO_EXTENSION)) : null;
                        $imgAllowed = ['jpg','jpeg','png','gif','webp','svg'];
                    @endphp
                    @if(!empty($producto->imagen_producto) && in_array($imgExt, $imgAllowed))
                        <div class="card-header-img">
                            <img src="{{ asset($producto->imagen_producto) }}" alt="Imagen del producto">
                        </div>
                    @endif

                    <div class="card-body">
                        <h5 class="titulo-producto">{{ $producto->nombre_producto }}</h5>
                        <p class="empresa-nombre">{{ $producto->nombre_empresa ?? 'Empresa' }}</p>

                        <div class="badges-container">
                            <span class="badge-custom badge-categoria">{{ $producto->categoria }}</span>
                            <span class="badge-custom badge-ubicacion">📍 {{ $producto->ubicacion_ciudad }}</span>
                        </div>

                        <p class="descripcion-producto">
                            {{ Str::limit($producto->descripcion, 120) }}
                        </p>

                        <div class="info-footer">
                            @php
                                $fechaFin = \Carbon\Carbon::parse($producto->fecha_fin);
                                $ahora = \Carbon\Carbon::now();
                                if ($ahora->greaterThan($fechaFin)) {
                                    $tiempoRestante = 'Vencido';
                                    $tiempoClass = 'tiempo-vencido';
                                } else {
                                    $segundosRestantes = $fechaFin->getTimestamp() - $ahora->getTimestamp();
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
                            <span class="email-badge">📧 {{ Str::limit($producto->correo_contacto, 20) }}</span>
                            <span class="tiempo-badge {{ $tiempoClass }}">{{ $tiempoRestante }}</span>
                        </div>

                        <div class="buttons-group">
                            <a href="{{ url('publicidad/productos/'.$producto->id_publico_producto) }}" class="btn-custom btn-detalle">
                                Ver →
                            </a>
                            <a href="tel:{{ $producto->telefono_contacto }}" class="btn-custom btn-telefono">
                                📞 {{ $producto->telefono_contacto }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection
