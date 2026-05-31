@extends('admin.layout')

@section('content')

<h2 class="fw-bold mb-4">

    Formularios de Productos

</h2>

<div class="card border-0 shadow rounded-4">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="ps-4">

                            Empresa

                        </th>

                        <th>

                            Producto

                        </th>

                        <th>

                            Categoría

                        </th>

                        <th>

                            Ubicación

                        </th>

                        <th>

                            Estado

                        </th>

                        <th width="260">

                            Acciones

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($productos as $producto)

                    <tr>

                        <!-- EMPRESA -->

                        <td class="ps-4 fw-semibold">

                            {{ $producto->nombre_empresa }}

                        </td>


                        <!-- PRODUCTO -->

                        <td>

                            {{ $producto->nombre_producto }}

                        </td>


                        <!-- CATEGORIA -->

                        <td>

                            {{ $producto->categoria }}

                        </td>


                        <!-- UBICACION -->

                        <td>

                            {{ $producto->ubicacion_ciudad }}

                        </td>


                        <!-- ESTADO -->

                        <td>

                            <span class="badge bg-warning text-dark px-3 py-2">

                                Pendiente

                            </span>

                        </td>


                        <!-- ACCIONES -->

                        <td>

                            <div class="d-flex gap-2 flex-wrap">

                                <!-- VER -->

                                <a
                                    href="{{ url('admin/ver-producto/'.$producto->id_empresa_producto) }}"
                                    class="btn btn-primary btn-sm"
                                >

                                    Ver

                                </a>


                                <!-- APROBAR -->

                                <a
                                    href="{{ url('admin/ver-producto/'.$producto->id_empresa_producto) }}"
                                    class="btn btn-success btn-sm"
                                >

                                    Aprobar

                                </a>


                                <!-- RECHAZAR -->

                                <form
                                    action="{{ url('admin/rechazar-producto/'.$producto->id_empresa_producto) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Deseas rechazar este producto?')"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                    >

                                        Rechazar

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6" class="text-center py-5">

                            <div class="text-muted">

                                No existen formularios registrados.

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection