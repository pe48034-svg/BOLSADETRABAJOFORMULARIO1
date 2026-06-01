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
                               required>

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Correo Electrónico
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

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Representante Responsable
                        </label>

                        <input type="text"
                               name="responsable_representante"
                               class="form-control"
                               required>

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Documento Validación
                        </label>

                        <input type="file"
                               name="documento_validacion"
                               class="form-control"
                               required>

                    </div>

                    <div class="col-12 mb-4">

                        <label class="form-label">
                            Dirección
                        </label>

                        <textarea name="direccion"
                                  class="form-control"
                                  rows="3"
                                  required></textarea>

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

                        <label class="form-label">
                            Título Puesto
                        </label>

                        <input type="text"
                               name="titulo_puesto"
                               class="form-control"
                               required>

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Categoría
                        </label>

                        <input type="text"
                               name="categoria"
                               class="form-control"
                               required>

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Modalidad
                        </label>

                        <select name="modalidad"
                                class="form-select"
                                required>

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

                        <label class="form-label">
                            Ubicación
                        </label>

                        <select name="ubicacion"
                                class="form-select"
                                required>

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

                        <label class="form-label">
                            Salario Mínimo
                        </label>

                        <input type="number"
                               step="0.01"
                               name="salario_minimo"
                               class="form-control"
                               required>

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Salario Máximo
                        </label>

                        <input type="number"
                               step="0.01"
                               name="salario_maximo"
                               class="form-control"
                               required>

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Fecha Inicio
                        </label>

                        <input type="date"
                               name="fecha_inicio_convocatoria"
                               class="form-control"
                               required>

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Fecha Límite
                        </label>

                        <input type="date"
                               name="fecha_limite_postulacion"
                               class="form-control"
                               required>

                    </div>

                    <div class="col-12 mb-4">

                        <label class="form-label">
                            Descripción Puesto
                        </label>

                        <textarea name="descripcion_puesto"
                                  rows="4"
                                  class="form-control"
                                  required></textarea>

                    </div>

                    <div class="col-12 mb-4">

                        <label class="form-label">
                            Requisitos
                        </label>

                        <textarea name="requisitos"
                                  rows="4"
                                  class="form-control"
                                  required></textarea>

                    </div>

                    <div class="col-12 mb-4">

                        <label class="form-label">
                            Imagen Trabajo
                        </label>

                        <input type="file"
                               name="imagen_trabajo"
                               class="form-control"
                               required>

                    </div>

                </div>

                <button type="submit"
                        class="btn btn-success">

                    Registrar Publicación

                </button>

            </div>

        </form>

    </div>

</div>

<script>

    function mostrarBolsaTrabajo()
    {
        document.getElementById('formEmpresa').style.display = 'none';

        document.getElementById('formBolsaTrabajo').style.display = 'block';
    }

</script>

@endsection