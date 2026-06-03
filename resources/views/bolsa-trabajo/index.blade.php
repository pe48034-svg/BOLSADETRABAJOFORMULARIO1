<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>

        El Porvenir Produce

    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body style="background:#f4f6f9;">

<!-- HERO -->

<section
    class="text-white py-5"
    style="
        background:
        linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.6)),
        url('{{ asset('fondoPrincipal/fondo.jpg') }}');

        background-size:cover;
        background-position:center;
    "
>

    <div class="container text-center">

        <h1 class="fw-bold display-4">

            El Porvenir Produce

        </h1>

        <p class="fs-5 mt-3">

            Encuentra oportunidades laborales,
            productos y servicios.

        </p>


        <!-- MENU -->

        <div class="mt-4">

            <a href="{{ url('/') }}" class="btn btn-light fw-bold">

                Bolsa de Trabajo

            </a>

            <a href="{{ url('registro/productos') }}" class="btn btn-outline-light">

                Productos

            </a>

            <a href="{{ url('registro/servicios') }}" class="btn btn-outline-light">

                Servicios

            </a>

        </div>

    </div>

</section>


<!-- CONTENIDO -->

<div class="container py-5">


    <!-- FILTROS -->

    <form method="GET">

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-4">

                    <input
                        type="text"
                        name="buscar"
                        class="form-control rounded-4"
                        placeholder="Buscar empleo..."
                        value="{{ request('buscar') }}"
                    >

                </div>

                <div class="col-md-3">

                    <select
                        name="modalidad"
                        class="form-select rounded-4"
                    >

                        <option value="">

                            Todas las modalidades

                        </option>

                        <option value="Presencial" {{ request('modalidad') == 'Presencial' ? 'selected' : '' }}>

                            Presencial

                        </option>

                        <option value="Virtual" {{ request('modalidad') == 'Virtual' ? 'selected' : '' }}>

                            Virtual

                        </option>

                        <option value="Hibrido" {{ request('modalidad') == 'Hibrido' ? 'selected' : '' }}>

                            Hibrido

                        </option>

                    </select>

                </div>

                <div class="col-md-3">
                    <select name="categoria" class="form-select rounded-4">
                        <option value="">Todas las categorías</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria }}" {{ request('categoria') == $categoria ? 'selected' : '' }}>{{ $categoria }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">

                    <button
                        class="btn btn-primary w-100 rounded-4"
                    >

                        Buscar

                    </button>

                </div>

            </div>

        </div>

    </div>

</form>

    <!-- OFERTAS -->

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

                    <div class="card-body p-3 d-flex flex-column">
                        <div class="mb-2">
                            <h5 class="fw-bold mb-1">{{ $oferta->titulo_puesto }}</h5>
                            <p class="text-muted mb-1">{{ $oferta->nombre_empresa ?? 'N/A' }}</p>
                            <span class="badge bg-secondary me-1">{{ $oferta->modalidad }}</span>
                            <span class="badge bg-info text-dark">{{ $oferta->categoria }}</span>
                        </div>

                        <p class="text-muted mb-2" style="font-size:.95rem;">{{ Str::limit($oferta->descripcion_puesto, 100) }}</p>

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
                            <a href="{{ url('detalle-oferta/'.$oferta->id_aprobado) }}" class="btn btn-outline-primary w-100 mb-2">Ver detalle</a>
                            <a href="{{ url('postular/'.$oferta->id_aprobado) }}" class="btn btn-primary w-100">Postular</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>

</body>
</html>
