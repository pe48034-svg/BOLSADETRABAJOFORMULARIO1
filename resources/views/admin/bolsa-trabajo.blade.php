@extends('admin.layout')

@section('content')

<h2 class="fw-bold mb-4">

    Bolsa de Trabajo

</h2>

<div class="card border-0 shadow-sm rounded-4">

    <div class="table-responsive">

        <table class="table align-middle">

            <thead>

                <tr>

                    <th>Empresa</th>

                    <th>Oferta</th>

                    <th>Modalidad</th>

                    <th>Ubicación</th>

                    <th>Acciones</th>

                </tr>

            </thead>

            <tbody>

                @foreach($empresas as $empresa)

                <tr>

                    <td>

                        {{ $empresa->nombre_empresa }}

                    </td>

                    <td>

                        {{ $empresa->titulo_puesto }}

                    </td>

                    <td>

                        {{ $empresa->modalidad }}

                    </td>

                    <td>

                        {{ $empresa->ubicacion }}

                    </td>

                    <td>

                        <button
                            class="btn btn-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modal{{ $empresa->id_aprobado }}"
                        >

                            Ver

                        </button>

                    </td>

                </tr>



                <!-- MODAL -->

                <div
                    class="modal fade"
                    id="modal{{ $empresa->id_aprobado }}"
                    tabindex="-1"
                >

                    <div class="modal-dialog modal-lg">

                        <div class="modal-content">

                            <div class="modal-header">

                                <h5 class="modal-title">

                                    {{ $empresa->nombre_empresa }}

                                </h5>

                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                ></button>

                            </div>

                            <div class="modal-body">

                                <h4>

                                    {{ $empresa->titulo_puesto }}

                                </h4>

                                <p>

                                    {{ $empresa->descripcion_puesto }}

                                </p>

                                <p>

                                    <strong>Requisitos:</strong>

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

                                <hr>

                                <!-- FORM SUBIR PDF -->

                                <form
                                    action="{{ url('admin/subir-documento/'.$empresa->id_aprobado) }}"
                                    method="POST"
                                    enctype="multipart/form-data"
                                >

                                    @csrf

                                    <label class="form-label fw-bold">

                                        Documento de Validación PDF

                                    </label>

                                    <input
                                        type="file"
                                        name="documento_pdf"
                                        class="form-control mb-3"
                                        required
                                    >

                                    <button class="btn btn-success">

                                        Validar

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection