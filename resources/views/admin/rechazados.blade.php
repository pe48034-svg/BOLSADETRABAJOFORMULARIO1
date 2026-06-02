<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ofertas Rechazadas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:#f4f6fb;">

<div class="d-flex">

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

        <a href="{{ url('admin/validacion-formularios') }}" class="d-block mb-4 text-dark text-decoration-none">
            📄 Validación de Formularios de Bolsa de Trabajo
        </a>

        <a href="{{ url('admin/rechazados') }}" class="d-block mb-4 text-dark text-decoration-none">
            ❌ Rechazados Bolsa de Trabajo
        </a>

        <a href="{{ url('admin/bolsa-trabajo') }}" class="d-block mb-4 text-dark text-decoration-none">
            💼 Bolsa de Trabajo
        </a>

        <a href="#" class="d-block mb-4 text-dark text-decoration-none">
            📦 Productos
        </a>

        <a href="#" class="d-block mb-4 text-dark text-decoration-none">
            🛠 Servicios
        </a>

    </div>

    <div class="flex-grow-1 p-4">

        <h1 class="fw-bold mb-4">Rechazados Bolsa de Trabajo</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <table class="table align-middle table-sm">
                    <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>RUC</th>
                        <th>Teléfono</th>
                        <th>Oferta</th>
                        <th>Categoría</th>
                        <th>Ubicación</th>
                        <th>Documento</th>
                        <th>Fecha Rechazo</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($empresas as $empresa)
                        <tr>
                            <td>
                                <strong>{{ $empresa->nombre_empresa ?? 'N/A' }}</strong>
                                <br>
                                <small class="text-muted">{{ $empresa->correo_electronico ?? 'N/A' }}</small>
                            </td>
                            <td>{{ $empresa->ruc ?? 'N/A' }}</td>
                            <td>{{ $empresa->telefono ?? 'N/A' }}</td>
                            <td>{{ $empresa->titulo_puesto }}</td>
                            <td>{{ $empresa->categoria ?? 'N/A' }}</td>
                            <td>{{ $empresa->ubicacion ?? 'N/A' }}</td>
                            <td>
                                @if(!empty($empresa->documento_validacion))
                                    <a href="{{ asset($empresa->documento_validacion) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        Ver
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $fecha = $empresa->fecha_rechazo ?? null;
                                    if ($fecha) {
                                        echo \Carbon\Carbon::parse($fecha)->format('d/m/Y');
                                    } else {
                                        echo 'N/A';
                                    }
                                @endphp
                            </td>
                            <td>
                                <form action="{{ url('admin/restaurar/' . ($empresa->id_rechazado ?? $empresa->id_empresa)) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        Restaurar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">No hay ofertas rechazadas.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
