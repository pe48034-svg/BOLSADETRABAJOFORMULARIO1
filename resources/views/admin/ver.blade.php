<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Ver Empresa
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body style="background:#f4f6f9;">

<div class="container py-5">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">{{ $empresa->nombre_empresa ?? 'Empresa' }}</h2>
            <p class="text-muted mb-0">Detalle completo de la empresa y su oferta laboral.</p>
        </div>
        <a href="{{ url('admin/validacion-formularios') }}" class="btn btn-outline-secondary">Volver a validación</a>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-5">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h4 class="fw-semibold mb-4">Datos de la empresa</h4>
                    <div class="row gy-3">
                        <div class="col-12 col-md-6">
                            <div class="border rounded-4 p-3 bg-white">
                                <div class="text-muted small">RUC</div>
                                <div class="fw-semibold">{{ $empresa->ruc ?? 'No especificado' }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="border rounded-4 p-3 bg-white">
                                <div class="text-muted small">Correo</div>
                                <div class="fw-semibold">{{ $empresa->correo_electronico ?? 'No especificado' }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="border rounded-4 p-3 bg-white">
                                <div class="text-muted small">Teléfono</div>
                                <div class="fw-semibold">{{ $empresa->telefono ?? 'No especificado' }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="border rounded-4 p-3 bg-white">
                                <div class="text-muted small">Responsable</div>
                                <div class="fw-semibold">{{ $empresa->responsable_representante ?? 'No especificado' }}</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="border rounded-4 p-3 bg-white">
                                <div class="text-muted small">Dirección</div>
                                <div class="fw-semibold">{{ $empresa->direccion ?? 'No especificado' }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="border rounded-4 p-3 bg-white">
                                <div class="text-muted small">Estado</div>
                                <div class="fw-semibold">{{ $empresa->estado ?? 'Pendiente' }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="border rounded-4 p-3 bg-white">
                                <div class="text-muted small">Categoría</div>
                                <div class="fw-semibold">{{ $empresa->categoria ?? 'No especificado' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-7">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-lg-row justify-content-between gap-3">
                        <div>
                            <h4 class="fw-semibold mb-3">Oferta laboral</h4>
                            <h5 class="mb-2">{{ $empresa->titulo_puesto ?? 'Sin título' }}</h5>
                        </div>
                        <div class="text-end text-muted">ID: {{ $empresa->id_empresa ?? 'N/A' }}</div>
                    </div>

                    <p class="text-secondary mb-4">{{ $empresa->descripcion_puesto ?? 'No hay descripción disponible.' }}</p>

                    <div class="row g-3">
                        <div class="col-6">
                            <div class="border rounded-4 p-3 bg-white">
                                <div class="text-muted small">Modalidad</div>
                                <div class="fw-semibold">{{ $empresa->modalidad ?? 'No especificado' }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded-4 p-3 bg-white">
                                <div class="text-muted small">Ubicación</div>
                                <div class="fw-semibold">{{ $empresa->ubicacion ?? 'No especificado' }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded-4 p-3 bg-white">
                                <div class="text-muted small">Salario mínimo</div>
                                <div class="fw-semibold">{{ $empresa->salario_minimo ? 'S/ ' . number_format($empresa->salario_minimo, 2, ',', '.') : 'No especificado' }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded-4 p-3 bg-white">
                                <div class="text-muted small">Salario máximo</div>
                                <div class="fw-semibold">{{ $empresa->salario_maximo ? 'S/ ' . number_format($empresa->salario_maximo, 2, ',', '.') : 'No especificado' }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded-4 p-3 bg-white">
                                <div class="text-muted small">Inicio convocatoria</div>
                                <div class="fw-semibold">{{ !empty($empresa->fecha_inicio_convocatoria) ? \Carbon\Carbon::parse($empresa->fecha_inicio_convocatoria)->format('d/m/Y') : 'No especificado' }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded-4 p-3 bg-white">
                                <div class="text-muted small">Límite postulación</div>
                                <div class="fw-semibold">{{ !empty($empresa->fecha_limite_postulacion) ? \Carbon\Carbon::parse($empresa->fecha_limite_postulacion)->format('d/m/Y') : 'No especificado' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 border rounded-4 p-3 bg-white">
                        <div class="text-muted small mb-2">Requisitos</div>
                        @if(!empty($empresa->requisitos))
                            @php $lines = preg_split('/\r\n|\r|\n/', trim($empresa->requisitos)); @endphp
                            <ul class="mb-0">
                                @foreach($lines as $line)
                                    @if(trim($line) !== '')
                                        <li>{{ $line }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted mb-0">No especificado.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-2 g-3 mt-3">
                @if(!empty($empresa->imagen_trabajo))
                    @php
                        $imgExt = strtolower(pathinfo($empresa->imagen_trabajo, PATHINFO_EXTENSION));
                        $imgAllowed = ['jpg','jpeg','png','gif','webp','svg'];
                    @endphp
                    <div class="col">
                        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h6 class="mb-1">Imagen / archivo de la publicación</h6>
                                        <p class="text-muted small mb-0">{{ strtoupper($imgExt) }}</p>
                                    </div>
                                    <a href="{{ asset($empresa->imagen_trabajo) }}" target="_blank" class="btn btn-sm btn-outline-success">Abrir</a>
                                </div>
                                @if(in_array($imgExt, $imgAllowed))
                                    <div class="rounded-4 shadow-sm overflow-hidden" style="background:#f8f9fa; min-height:180px; display:flex; align-items:center; justify-content:center;">
                                        <img src="{{ asset($empresa->imagen_trabajo) }}" alt="Imagen publicación" class="img-fluid" style="max-height:220px; width:auto; max-width:100%; object-fit:contain;">
                                    </div>
                                @elseif($imgExt === 'pdf')
                                    <div class="ratio ratio-4x3">
                                        <iframe src="{{ asset($empresa->imagen_trabajo) }}" frameborder="0"></iframe>
                                    </div>
                                @else
                                    <p class="text-muted">Archivo disponible para abrir en nueva pestaña.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($empresa->documento_validacion))
                    <div class="col">
                        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h6 class="mb-1">Documento de validación</h6>
                                        <p class="text-muted small mb-0">Subido por la empresa</p>
                                    </div>
                                    <a href="{{ asset($empresa->documento_validacion) }}" target="_blank" class="btn btn-sm btn-outline-warning">Abrir</a>
                                </div>
                                <div class="ratio ratio-4x3">
                                    <iframe src="{{ asset($empresa->documento_validacion) }}" frameborder="0"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($empresa->documento_aprobacion_pdf))
                    <div class="col">
                        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h6 class="mb-1">Documento aprobado</h6>
                                        <p class="text-muted small mb-0">PDF administrativo</p>
                                    </div>
                                    <a href="{{ asset($empresa->documento_aprobacion_pdf) }}" target="_blank" class="btn btn-sm btn-outline-primary">Abrir</a>
                                </div>
                                <div class="ratio ratio-4x3">
                                    <iframe src="{{ asset($empresa->documento_aprobacion_pdf) }}" frameborder="0"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @php
        $rol = session('usuario')->rol ?? null;
    @endphp
    <div class="card shadow-sm border-0 rounded-4 mt-4">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-sm-row gap-2">
                @if($rol !== 'Analista')
                    <form action="{{ url('admin/aprobar/'.$empresa->id_empresa) }}" method="POST" class="w-100 confirm-password-action" data-confirm-message="Aprobar esta solicitud?">
                        @csrf
                        <button class="btn btn-success w-100">Aprobar</button>
                    </form>
                    <form action="{{ url('admin/rechazar/'.$empresa->id_empresa) }}" method="POST" class="w-100 confirm-password-action" data-confirm-message="Rechazar esta solicitud?">
                        @csrf
                        <button class="btn btn-danger w-100">Rechazar</button>
                    </form>
                @endif
                <a href="{{ url('admin/validacion-formularios') }}" class="btn btn-secondary w-100">Volver</a>
            </div>
        </div>
    </div>

</div>

</body>

</html>

                    </button>

                </form>


                <!-- VOLVER -->

                <a
                    href="{{ url('admin/validacion-formularios') }}"
                    class="btn btn-secondary"
                >
                    Volver
                </a>

            </div>

        </div>

    </div>

</div>

</body>

</html>