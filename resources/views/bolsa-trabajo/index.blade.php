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

            <button class="btn btn-light fw-bold">

                Bolsa de Trabajo

            </button>

            <button class="btn btn-outline-light">

                Productos

            </button>

            <button class="btn btn-outline-light">

                Servicios

            </button>

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

                <div class="col-md-8">

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

                        <option value="Presencial">

                            Presencial

                        </option>

                        <option value="Virtual">

                            Virtual

                        </option>

                        <option value="Hibrido">

                            Hibrido

                        </option>

                    </select>

                </div>

                <div class="col-md-1">

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

    @foreach($ofertas as $oferta)

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between">

                <div>

                    <h3 class="fw-bold">

                        {{ $oferta->titulo_puesto }}

                    </h3>

                    <p class="text-muted mb-1">

                        {{ $oferta->nombre_empresa }}

                    </p>

                    <p class="mb-2">

                        {{ $oferta->ubicacion }}

                        -
                        {{ $oferta->modalidad }}

                    </p>

                    <h5 class="text-primary fw-bold">

                        S/
                        {{ $oferta->salario_minimo }}

                        -

                        S/
                        {{ $oferta->salario_maximo }}

                    </h5>

                    <p class="text-muted">

                        {{ Str::limit($oferta->descripcion_puesto, 120) }}

                    </p>

                </div>

                <div class="text-end">

                    <a
                        href="{{ url('detalle-oferta/'.$oferta->id_aprobado) }}"
                        class="btn btn-outline-primary mb-2"
                    >

                        Ver detalle

                    </a>

                    <br>

                    <a
                        href="{{ url('postular/'.$oferta->id_aprobado) }}"
                        class="btn btn-primary"
                    >

                        Postular

                    </a>

                </div>

            </div>

        </div>

    </div>

    @endforeach

</div>

</body>
</html>