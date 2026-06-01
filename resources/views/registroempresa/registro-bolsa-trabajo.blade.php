@extends('layouts.app')

@section('content')

<h1 class="fw-bold mb-4">
    Registro Bolsa de Trabajo
</h1>

@include('components.stepper', ['paso' => 2])

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-5">

        <form action="{{ url('guardar-bolsa-trabajo') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            <!-- ================================= -->
            <!-- INFORMACION EMPRESA -->
            <!-- ================================= -->

            <div id="formEmpresa">

                <h4 class="mb-4">
                    Información Empresa
                </h4>

                <div class="row">

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Nombre Empresa</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                            <input type="text" name="nombre_empresa" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">RUC</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                            <input type="text" name="ruc" class="form-control" maxlength="11" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Correo Electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="correo_electronico" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Teléfono</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input type="text" name="telefono" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Representante Responsable</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="responsable_representante" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Documento Validación</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                            <input type="file" name="documento_validacion" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-12 mb-4">
                        <label class="form-label">Dirección</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                            <textarea name="direccion" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>

                </div>

                <button type="button"
                        class="btn btn-primary"
                        onclick="mostrarBolsaTrabajo()">

                    Continuar

                </button>

            </div>



            <!-- ================================= -->
            <!-- PUBLICACION TRABAJO -->
            <!-- ================================= -->

            <div id="formBolsaTrabajo" style="display:none;">

                <h4 class="mb-4">
                    Información Publicación
                </h4>

                <div class="row">

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Título Puesto</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                            <input type="text" name="titulo_puesto" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Categoría</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-tags"></i></span>
                            <input type="text" name="categoria" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Modalidad</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-geo"></i></span>
                            <select name="modalidad" class="form-select" required>

                            <option value="">
                                Seleccionar
                            </option>

                            <option value="Presencial">
                                Presencial
                            </option>

                            <option value="Virtual">
                                Virtual
                            </option>

                            <option value="Hibrido">
                                Híbrido
                            </option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Ubicación</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                            <select name="ubicacion" class="form-select" required>

                            <option value="">
                                Seleccionar
                            </option>

                            <option>Trujillo Centro</option>
                            <option>La Esperanza</option>
                            <option>El Porvenir</option>
                            <option>Florencia de Mora</option>
                            <option>Huanchaco</option>
                            <option>Laredo</option>
                            <option>Moche</option>
                            <option>Salaverry</option>
                            <option>Victor Larco</option>
                            <option>Alto Trujillo</option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Salario Mínimo</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                            <input type="number" step="0.01" name="salario_minimo" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Salario Máximo</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                            <input type="number" step="0.01" name="salario_maximo" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Fecha Inicio</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                            <input type="date" name="fecha_inicio_convocatoria" class="form-control" value="{{ old('fecha_inicio_convocatoria', \Carbon\Carbon::now()->addDay()->format('Y-m-d')) }}" readonly required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Fecha Límite</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-x"></i></span>
                            <input type="date" name="fecha_limite_postulacion" class="form-control" value="{{ old('fecha_limite_postulacion', \Carbon\Carbon::now()->addMonth()->format('Y-m-d')) }}" readonly required>
                        </div>
                    </div>

                    <div class="col-12 mb-4">
                        <label class="form-label">Descripción Puesto</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                            <textarea name="descripcion_puesto" rows="4" class="form-control" required></textarea>
                        </div>
                    </div>

                    <div class="col-12 mb-4">
                        <label class="form-label">Requisitos</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-list-check"></i></span>
                            <textarea name="requisitos" rows="4" class="form-control" required></textarea>
                        </div>
                        <small class="text-muted">Indica requisitos importantes (experiencia, estudios, certificaciones). Ej: "2 años de experiencia en ventas, título técnico"</small>
                    </div>

                    <div class="col-12 mb-4">
                        <label class="form-label">Imagen Trabajo</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-image"></i></span>
                            <input type="file" name="imagen_trabajo" class="form-control" required>
                        </div>
                        <small class="text-muted">Sube una imagen JPG/PNG que represente la oferta (opcional pero recomendada).</small>
                    </div>

                </div>

                <button type="submit"
                        class="btn btn-success">

                    Registrar Publicación

                </button>
                <div class="mt-2">
                    <small class="text-muted">La publicación será revisada por el equipo. La aprobación puede demorar 1-2 días hábiles.</small>
                </div>

            </div>

        </form>

    </div>

</div>

<script>

    function mostrarBolsaTrabajo()
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
        document.getElementById('formBolsaTrabajo').style.display = 'block';
    }

</script>

@endsection