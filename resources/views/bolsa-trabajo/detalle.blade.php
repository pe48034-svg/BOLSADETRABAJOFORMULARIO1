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

</head>

<body style="background:#f4f6f9;">

<div class="container py-5">

    <div class="card border-0 shadow rounded-4">

        <div class="card-body p-5">

            <h1 class="fw-bold">

                {{ $oferta->titulo_puesto }}

            </h1>

            <h5 class="text-muted mb-4">

                {{ $oferta->nombre_empresa ?? 'N/A' }}

            </h5>

            <p>

                {{ $oferta->descripcion_puesto }}

            </p>

            <hr>

            <h4>

                Requisitos

            </h4>

            <p>

                {{ $oferta->requisitos }}

            </p>

            <hr>

            <p>

                <strong>Modalidad:</strong>

                {{ $oferta->modalidad }}

            </p>

            <p>

                <strong>Ubicación:</strong>

                {{ $oferta->ubicacion }}

            </p>

            <p>

                <strong>Salario:</strong>

                S/
                {{ $oferta->salario_minimo }}

                -

                S/
                {{ $oferta->salario_maximo }}

            </p>

            <a
                href="{{ url('postular/'.$oferta->id_aprobado) }}"
                class="btn btn-primary rounded-4"
            >

                Postular

            </a>

        </div>

    </div>

</div>

</body>
</html>