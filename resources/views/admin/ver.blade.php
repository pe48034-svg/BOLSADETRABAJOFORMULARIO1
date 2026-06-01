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

    <div class="card shadow border-0 rounded-4">

        <div class="card-body p-5">

            <h2 class="fw-bold mb-4">
                {{ $empresa->nombre_empresa ?? 'N/A' }}
            </h2>

            <div class="row g-4">

                <div class="col-md-6">

                    <div class="border rounded-4 p-3">

                        <strong>RUC</strong>

                        <br>

                        {{ $empresa->ruc }}

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="border rounded-4 p-3">

                        <strong>Correo</strong>

                        <br>

                        {{ $empresa->correo_electronico }}

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="border rounded-4 p-3">

                        <strong>Teléfono</strong>

                        <br>

                        {{ $empresa->telefono }}

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="border rounded-4 p-3">

                        <strong>Responsable</strong>

                        <br>

                        {{ $empresa->responsable_representante }}

                    </div>

                </div>

                <div class="col-12">

                    <div class="border rounded-4 p-3">

                        <strong>Dirección</strong>

                        <br>

                        {{ $empresa->direccion }}

                    </div>

                </div>

            </div>

            <hr class="my-5">

            <h4 class="fw-bold mb-4">
                Oferta Laboral
            </h4>

            <div class="border rounded-4 p-4">

                <h3>
                    {{ $empresa->titulo_puesto }}
                </h3>

                <p>
                    {{ $empresa->descripcion_puesto }}
                </p>

                <strong>Requisitos:</strong>

                @if(!empty($empresa->requisitos))
                    @php $lines = preg_split('/\r\n|\r|\n/', trim($empresa->requisitos)); @endphp
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

                <p>
                    <strong>Modalidad:</strong>
                    {{ $empresa->modalidad }}
                </p>

                <p>
                    <strong>Ubicación:</strong>
                    {{ $empresa->ubicacion }}
                </p>

                <p>
                    <strong>Salario:</strong>

                    S/
                    {{ $empresa->salario_minimo }}
                    -
                    S/
                    {{ $empresa->salario_maximo }}
                </p>

                    <!-- Imagen trabajo -->
                    @if(!empty($empresa->imagen_trabajo))
                        @php
                            $imgExt = strtolower(pathinfo($empresa->imagen_trabajo, PATHINFO_EXTENSION));
                            $imgAllowed = ['jpg','jpeg','png','gif','webp','svg'];
                        @endphp
                        <div class="mt-4">
                            <h5 class="mb-2">Imagen / archivo de la publicación</h5>
                            <div class="mb-3 d-flex gap-2 flex-wrap">
                                <a href="{{ asset($empresa->imagen_trabajo) }}" target="_blank" class="btn btn-outline-success btn-sm">🔎 Abrir archivo</a>
                                @if(in_array($imgExt, $imgAllowed))
                                    <span class="badge bg-secondary">Imagen</span>
                                @elseif($imgExt === 'pdf')
                                    <span class="badge bg-primary">PDF</span>
                                @else
                                    <span class="badge bg-secondary">Archivo</span>
                                @endif
                            </div>
                            @if(in_array($imgExt, $imgAllowed))
                                <div class="rounded-4 shadow-sm overflow-hidden" style="background:#f8f9fa; max-height:240px; display:flex; align-items:center; justify-content:center;">
                                    <img src="{{ asset($empresa->imagen_trabajo) }}" alt="Imagen trabajo" class="img-fluid" style="max-height:240px; width:auto; max-width:100%; object-fit:contain;">
                                </div>
                            @elseif($imgExt === 'pdf')
                                <div class="ratio ratio-4x3">
                                    <iframe src="{{ asset($empresa->imagen_trabajo) }}" frameborder="0"></iframe>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Documento de la empresa -->
                    @if(!empty($empresa->documento_validacion))
                        <div class="mt-4">
                            <h5 class="mb-2">Documento subido por la empresa</h5>
                            <a href="{{ asset($empresa->documento_validacion) }}" target="_blank" class="btn btn-outline-warning btn-sm mb-2">📄 Ver documento de validación</a>
                            <div class="ratio ratio-4x3">
                                <iframe src="{{ asset($empresa->documento_validacion) }}" frameborder="0"></iframe>
                            </div>
                        </div>
                    @endif

                    <!-- Documento aprobado (PDF) -->
                    @if(!empty($empresa->documento_aprobacion_pdf))
                        <div class="mt-4">
                            <h5 class="mb-2">Documento aprobado</h5>
                            <a href="{{ asset($empresa->documento_aprobacion_pdf) }}" target="_blank" class="btn btn-outline-primary btn-sm mb-2">📄 Abrir PDF aprobado</a>
                            <div class="ratio ratio-4x3">
                                <iframe src="{{ asset($empresa->documento_aprobacion_pdf) }}" frameborder="0"></iframe>
                            </div>
                        </div>
                    @endif

            </div>


            <!-- BOTONES -->

            <div class="mt-4 d-flex gap-2">

                <!-- APROBAR -->

                <form
                    action="{{ url('admin/aprobar/'.$empresa->id_empresa) }}"
                    method="POST"
                >

                    @csrf

                    <button class="btn btn-success">

                        Aprobar

                    </button>

                </form>


                <!-- RECHAZAR -->

                <form
                    action="{{ url('admin/rechazar/'.$empresa->id_empresa) }}"
                    method="POST"
                >

                    @csrf

                    <button class="btn btn-danger">

                        Rechazar

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