@extends('layouts.app')

@section('content')

<h1 class="fw-bold mb-4">
    Registro Servicios
</h1>

@include('components.stepper', ['paso' => 2])

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-5">

        <form action="{{ url('guardar-servicio') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <!-- ================================= -->
            <!-- INFORMACION EMPRESA -->
            <!-- ================================= -->

            <div id="formEmpresa">

                <h4 class="mb-4">
                    Información Empresa
                </h4>

                <div class="row">

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Nombre Empresa
                        </label>

                        <input type="text"
                               name="nombre_empresa"
                               class="form-control"
                               required>

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            RUC
                        </label>

                        <input type="text"
                               name="ruc"
                               class="form-control"
                               maxlength="11"
                               pattern="\d{11}"
                               title="Ingrese 11 dígitos de RUC"
                               required>

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Correo
                        </label>

                        <input type="email"
                               name="correo_electronico"
                               class="form-control"
                               required>

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Teléfono
                        </label>

                        <input type="text"
                               name="telefono"
                               class="form-control"
                               required>

                    </div>

                </div>

                <button type="button"
                        class="btn btn-primary"
                        onclick="mostrarServicio()">

                    Continuar

                </button>

            </div>



            <!-- ================================= -->
            <!-- INFORMACION SERVICIO -->
            <!-- ================================= -->

            <div id="formServicio" style="display:none;">

                <h4 class="mb-4">
                    Información Servicio
                </h4>
                <div class="row">

                    <div class="col-md-6 mb-4">

                        <label class="form-label">Nombre Servicio</label>

                        <input type="text" name="nombre_servicio" class="form-control" required>

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">Categoría</label>

                        <input type="text" name="categoria" class="form-control" required>

                    </div>

                    <div class="col-12 mb-4">

                        <label class="form-label">Descripción</label>

                        <textarea name="descripcion" class="form-control" rows="4" required></textarea>

                    </div>

                    <div class="col-12 mb-4">

                        <label class="form-label">Requisitos</label>

                        <textarea name="requisitos" class="form-control" rows="3"></textarea>

                        <small class="text-muted">Ej: experiencia mínima, certificaciones o habilidades específicas.</small>

                    </div>

                    <div class="col-12">
                        <button class="btn btn-success">Registrar Servicio</button>
                    </div>

                </div>

            </div>

        </form>

    </div>
window.mostrarServicio = function
</div>



<script>

    function mostrarServicio()
    {
        const container = document.getElementById('formEmpresa');
        const controls = container.querySelectorAll('input, textarea, select');

        for (let i = 0; i < controls.length; i++) {
            const el = controls[i];
            if (!el.checkValidity()) {
                el.reportValidity();
                return;
            }
        }

        document.getElementById('formEmpresa').style.display = 'none';
        document.getElementById('formServicio').style.display = 'block';
    }

</script>

@endsection