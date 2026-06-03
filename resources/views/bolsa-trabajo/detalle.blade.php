<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>

        Detalle Oferta

    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>

<body style="background:#f4f6f9;">

<div class="container py-5">

    <div class="card border-0 shadow rounded-4">

        <div class="card-body p-5">
            <div class="row gx-5 gy-4">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <span class="badge bg-primary me-2"><i class="bi bi-geo-alt-fill me-1"></i> {{ $oferta->modalidad }}</span>
                        <span class="badge bg-secondary me-2"><i class="bi bi-tags me-1"></i> {{ $oferta->categoria }}</span>
                        <span class="badge bg-info text-dark"><i class="bi bi-geo me-1"></i> {{ $oferta->ubicacion }}</span>
                    </div>

                    <h1 class="fw-bold mb-3">{{ $oferta->titulo_puesto }}</h1>
                    <p class="text-muted mb-4">{{ $oferta->nombre_empresa ?? 'N/A' }}</p>

                    @php
                        $imgExt = !empty($oferta->imagen_trabajo) ? strtolower(pathinfo($oferta->imagen_trabajo, PATHINFO_EXTENSION)) : null;
                        $imgAllowed = ['jpg','jpeg','png','gif','webp','svg'];
                    @endphp
                    @if(!empty($oferta->imagen_trabajo) && in_array($imgExt, $imgAllowed))
                        <div class="mb-4 rounded-4 shadow-sm" style="background:#f8f9fa; max-height:320px; overflow:hidden; display:flex; align-items:center; justify-content:center;">
                            <img src="{{ asset($oferta->imagen_trabajo) }}" class="img-fluid" alt="Imagen de la oferta" style="max-height:320px; width:auto; max-width:100%; object-fit:contain;">
                        </div>
                    @elseif(!empty($oferta->imagen_trabajo) && $imgExt === 'pdf')
                        <div class="mb-4">
                            <a href="{{ asset($oferta->imagen_trabajo) }}" target="_blank" class="btn btn-outline-primary mb-3">📄 Ver documento de la oferta</a>
                            <div class="ratio ratio-16x9">
                                <iframe src="{{ asset($oferta->imagen_trabajo) }}" frameborder="0"></iframe>
                            </div>
                        </div>
                    @endif

                    <p>{{ $oferta->descripcion_puesto }}</p>

                    <hr>

                    <h4>Requisitos</h4>
                    @if(!empty($oferta->requisitos))
                        @php
                            $lines = preg_split('/\r\n|\r|\n/', trim($oferta->requisitos));
                        @endphp
                        <ul>
                            @foreach($lines as $line)
                                @if(trim($line) !== '')
                                    <li>{{ $line }}</li>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No especificado.</p>
                    @endif
                </div>

                <div class="col-lg-4">
                    <div class="bg-light rounded-4 p-4 h-100 shadow-sm">
                        <p class="text-uppercase text-muted small mb-2">Resumen</p>
                        <div class="mb-3">
                            <p class="mb-1 text-muted"><i class="bi bi-currency-dollar me-1"></i> Salario</p>
                            <h4 class="fw-bold">S/ {{ number_format($oferta->salario_minimo, 2) }} - S/ {{ number_format($oferta->salario_maximo, 2) }}</h4>
                        </div>
                        <p class="mb-2"><i class="bi bi-people me-1"></i><strong>Modalidad:</strong> {{ $oferta->modalidad }}</p>
                        <p class="mb-2"><i class="bi bi-geo-alt me-1"></i><strong>Ubicación:</strong> {{ $oferta->ubicacion }}</p>
                        <p class="mb-2"><i class="bi bi-calendar-x me-1"></i><strong>Fecha límite:</strong> {{ $oferta->fecha_limite_postulacion }}</p>
                        <p class="mb-0"><i class="bi bi-calendar-event me-1"></i><strong>Publicado en:</strong> {{ $oferta->fecha_inicio_convocatoria }}</p>
                        <a href="{{ url('postular/'.$oferta->id_aprobado) }}" class="btn btn-primary w-100 rounded-4 mt-4">Postular ahora</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

</body>
</html>