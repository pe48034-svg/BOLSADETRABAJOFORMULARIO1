@extends('layouts.app')

@section('content')

<h1 class="fw-bold mb-4">Publicidad - Productos</h1>

<p class="text-muted mb-4">
    Aquí se muestran únicamente los productos disponibles y vigentes.
</p>

@if($productos->isEmpty())
    <div class="alert alert-secondary">No hay productos disponibles en este momento.</div>
@else
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
        @foreach($productos as $producto)
            <div class="col">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">

                    @php
                        $imgExt = !empty($producto->imagen_producto) ? strtolower(pathinfo($producto->imagen_producto, PATHINFO_EXTENSION)) : null;
                        $imgAllowed = ['jpg','jpeg','png','gif','webp','svg'];
                    @endphp
                    @if(!empty($producto->imagen_producto) && in_array($imgExt, $imgAllowed))
                        <div class="mb-2 rounded-4 shadow-sm" style="background:#f8f9fa; max-height:200px; overflow:hidden; display:flex; align-items:center; justify-content:center;">
                            <img src="{{ asset($producto->imagen_producto) }}" class="img-fluid" alt="Imagen del producto" style="max-height:200px; width:auto; max-width:100%; object-fit:contain;">
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="fw-bold mb-2">{{ $producto->nombre_producto }}</h5>
                        <p class="text-muted mb-2">{{ $producto->nombre_empresa ?? 'N/A' }}</p>
                        <div class="mb-3">
                            <span class="badge bg-info text-dark me-1">{{ $producto->categoria }}</span>
                            <span class="badge bg-secondary">{{ $producto->ubicacion_ciudad }}</span>
                        </div>
                        <p class="text-muted mb-3" style="font-size:.95rem;">
                            {{ Str::limit($producto->descripcion, 100) }}
                        </p>
                        <div class="mt-auto">
                            @php
                                $fechaFin = \Carbon\Carbon::parse($producto->fecha_fin);
                                $ahora = \Carbon\Carbon::now();
                                if ($ahora->greaterThan($fechaFin)) {
                                    $tiempoRestante = 'Publicación vencida';
                                    $tiempoClass = 'bg-danger';
                                } else {
                                    $segundosRestantes = $fechaFin->getTimestamp() - $ahora->getTimestamp();
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
                                <span class="text-secondary small">{{ $producto->correo_contacto }}</span>
                                <span class="badge {{ $tiempoClass }} text-white">{{ $tiempoRestante }}</span>
                            </div>
                            <a href="{{ url('publicidad/productos/'.$producto->id_publico_producto) }}" class="btn btn-outline-primary w-100 mb-2">
                                Ver detalle
                            </a>
                            <a href="tel:{{ $producto->telefono_contacto }}" class="btn btn-outline-primary w-100">
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
