<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Validación de Formularios</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body style="background:#f4f6fb;">

<div class="d-flex">

    <!-- SIDEBAR -->

    <div style="
        width:250px;
        min-height:100vh;
        background:white;
        border-right:1px solid #ddd;
        padding:30px;
    ">

        <h1 style="
            color:#2563eb;
            font-weight:bold;
        ">
            Gestión Empresarial
        </h1>

        <br><br>

        <a href="{{ url('admin/validacion-formularios') }}"
           class="d-block mb-4 text-dark text-decoration-none">
            📄 Validación de Formularios
        </a>

        <a href="{{ url('admin/bolsa-trabajo') }}"
           class="d-block mb-4 text-dark text-decoration-none">
            💼 Bolsa de Trabajo
        </a>

        <a href="#"
           class="d-block mb-4 text-dark text-decoration-none">
            📦 Productos
        </a>

        <a href="#"
           class="d-block mb-4 text-dark text-decoration-none">
            🛠 Servicios
        </a>

    </div>


    <!-- CONTENIDO -->

    <div class="flex-grow-1 p-4">

        <h1 class="fw-bold mb-4">
            Validación de Formularios
        </h1>

        <div class="card shadow border-0 rounded-4">

            <div class="card-body">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Empresa</th>

                            <th>Oferta</th>

                            <th>Estado</th>

                            <th>Acciones</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($empresas as $empresa)

                        <tr>

                            <td>

                                <strong>
                                    {{ $empresa->nombre_empresa ?? 'N/A' }}
                                </strong>

                                <br>

                                <small class="text-muted">
                                    {{ $empresa->correo_electronico ?? 'N/A' }}
                                </small>

                            </td>

                            <td>

                                {{ $empresa->titulo_puesto }}

                            </td>

                            <td>

                                <span class="badge bg-warning text-dark">

                                    {{ $empresa->estado }}

                                </span>

                            </td>

                            <td>

                                <!-- VER -->

                                <a
                                    href="{{ url('admin/ver/'.$empresa->id_empresa) }}"
                                    class="btn btn-primary btn-sm"
                                >
                                    Ver
                                </a>


                                <!-- APROBAR -->

                                <form
                                    action="{{ url('admin/aprobar/'.$empresa->id_empresa) }}"
                                    method="POST"
                                    style="display:inline-block;"
                                >

                                    @csrf

                                    <button class="btn btn-success btn-sm">

                                        Aprobar

                                    </button>

                                </form>


                                <!-- RECHAZAR -->

                                <form
                                    action="{{ url('admin/rechazar/'.$empresa->id_empresa) }}"
                                    method="POST"
                                    style="display:inline-block;"
                                >

                                    @csrf

                                    <button class="btn btn-danger btn-sm">

                                        Rechazar

                                    </button>

                                </form>

                            </td>

                        </tr>


                        <!-- MODAL -->

                        <div class="modal fade"
                             id="modal{{ $empresa->id_empresa }}"
                             tabindex="-1">

                            <div class="modal-dialog modal-lg modal-dialog-centered">

                                <div class="modal-content border-0 rounded-4">

                                    <!-- HEADER -->

                                    <div class="modal-header">

                                        <div>

                                            <h4 class="fw-bold mb-1">

                                                {{ $empresa->nombre_empresa ?? 'N/A' }}

                                            </h4>

                                            <small class="text-muted">

                                                RUC:
                                                {{ $empresa->ruc ?? 'N/A' }}

                                            </small>

                                        </div>

                                        <button type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal">
                                        </button>

                                    </div>


                                    <!-- BODY -->

                                    <div class="modal-body">

                                        <div class="row">

                                            <div class="col-md-6 mb-3">

                                                <div class="p-3 bg-light rounded-3">

                                                    <small class="text-muted">
                                                        Responsable
                                                    </small>

                                                    <br>

                                                    <strong>
                                                        {{ $empresa->responsable_representante }}
                                                    </strong>

                                                </div>

                                            </div>


                                            <div class="col-md-6 mb-3">

                                                <div class="p-3 bg-light rounded-3">

                                                    <small class="text-muted">
                                                        Correo
                                                    </small>

                                                    <br>

                                                    <strong>
                                                        {{ $empresa->correo_electronico }}
                                                    </strong>

                                                </div>

                                            </div>


                                            <div class="col-md-6 mb-3">

                                                <div class="p-3 bg-light rounded-3">

                                                    <small class="text-muted">
                                                        Teléfono
                                                    </small>

                                                    <br>

                                                    <strong>
                                                        {{ $empresa->telefono }}
                                                    </strong>

                                                </div>

                                            </div>


                                            <div class="col-md-6 mb-3">

                                                <div class="p-3 bg-light rounded-3">

                                                    <small class="text-muted">
                                                        Dirección
                                                    </small>

                                                    <br>

                                                    <strong>
                                                        {{ $empresa->direccion }}
                                                    </strong>

                                                </div>

                                            </div>

                                        </div>


                                        <hr>


                                        <h5 class="fw-bold mb-3">

                                            Publicación Laboral

                                        </h5>


                                        <div class="border rounded-4 p-4 bg-light">

                                            <h5 class="fw-bold">

                                                {{ $empresa->titulo_puesto }}

                                            </h5>

                                            <br>

                                            <p>

                                                {{ $empresa->descripcion_puesto }}

                                            </p>

                                            <p>

                                                <strong>
                                                    Requisitos:
                                                </strong>

                                                {{ $empresa->requisitos }}

                                            </p>

                                            <div class="d-flex gap-3 flex-wrap">

                                                <span class="badge bg-primary">
                                                    {{ $empresa->modalidad }}
                                                </span>

                                                <span class="badge bg-success">
                                                    {{ $empresa->categoria }}
                                                </span>

                                                <span class="badge bg-dark">
                                                    {{ $empresa->ubicacion }}
                                                </span>

                                            </div>

                                            <br>

                                            <p>

                                                <strong>
                                                    Salario:
                                                </strong>

                                                S/
                                                {{ $empresa->salario_minimo }}

                                                -

                                                S/
                                                {{ $empresa->salario_maximo }}

                                            </p>

                                        </div>

                                    </div>


                                    <!-- FOOTER -->

                                    <div class="modal-footer">

                                        <!-- APROBAR -->

                                        <form method="POST"
                                              action="/admin/aprobar/{{ $empresa->id_empresa }}">

                                            @csrf

                                            <button class="btn btn-success">

                                                Aprobar

                                            </button>

                                        </form>


                                        <!-- RECHAZAR -->

                                        <form method="POST"
                                              action="/admin/rechazar/{{ $empresa->id_empresa }}">

                                            @csrf

                                            <button class="btn btn-danger">

                                                Rechazar

                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>