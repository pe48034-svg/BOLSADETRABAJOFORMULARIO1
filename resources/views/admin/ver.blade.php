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

                <strong>
                    Requisitos:
                </strong>

                <p>
                    {{ $empresa->requisitos }}
                </p>

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