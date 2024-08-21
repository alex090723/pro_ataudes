@extends('adminlte::page')

@section('title', 'Cuentas por Cobrar')

@section('content_header')
    <h1>Lista de Cuentas por Cobrar</h1>
@stop

<style>
  .modal-content {
    background-color: #f8f9fa; /* Color de fondo */
    border-radius: 0.5rem; /* Bordes redondeados */
  }
  .form-control {
    border-radius: 0.25rem; /* Bordes redondeados en los campos */
  }
  .btn-primary {
    background-color: #007bff; /* Color de fondo del botón primario */
    border-color: #007bff; /* Color del borde del botón primario */
  }
  .btn-secondary {
    background-color: #6c757d; /* Color de fondo del botón secundario */
    border-color: #6c757d; /* Color del borde del botón secundario */
  }
  .modal-header {
    background-color: #007bff; /* Color de fondo del encabezado del modal */
    color: #fff; /* Color del texto del encabezado del modal */
  }
  .modal-footer {
    background-color: #f1f1f1; /* Color de fondo del pie de página del modal */
  }

</style>
@section('content')
@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-12 text-right">
                <!-- Botón de Agregar Plan de Pago (si es necesario) -->
            </div>
        </div>

        <!-- Tabla de Cuentas por Cobrar -->
        <div class="card">
            <div class="col-md-12">
                <table class="table table-striped table-bordered" id="cuentasPorCobrarTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Factura</th>
                            <th>Fecha Factura</th>
                            <th>Monto Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cuentas as $index => $cuenta)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $cuenta->nombre_cliente }}</td>
                                <td>{{ $cuenta->numero_factura }}</td>
                                <td>{{ date('d/m/Y', strtotime($cuenta->fecha_factura)) }}</td>
                                <td>{{ number_format($cuenta->monto_total, 2) }}</td>
                                <td>
                                    <!-- Botón para Agregar Plan de Pago -->
                                    @can('editar-venta')
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#ModalAgregarPlanPago" data-id="{{ $cuenta->id_cuenta_cobrar }}" data-nombre="{{ $cuenta->nombre_cliente }}">
                                    <i class="fas fa-edit text-dark-blue"></i>
                                        Agregar Plan de Pago
                                    </button>
                                    @endcan

                                    <!-- Botón para Editar Cuenta -->
                                  
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para Agregar Plan de Pago -->
    <div class="modal fade" id="ModalAgregarPlanPago" tabindex="-1" aria-labelledby="ModalAgregarPlanPagoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content border-primary shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalAgregarPlanPagoLabel">Agregar Plan de Pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="agregarPlanPagoForm" action="{{ route('plan_pago.store') }}" method="POST">
                        @csrf
                        <input type="hidden" id="plan-cuenta-id" name="id_cuenta_cobrar">
                        <input type="hidden" name="monto_abono" value="0">
                        <div class="mb-3">
                            <label for="cliente-nombre" class="form-label">Nombre del Cliente</label>
                            <input type="text" class="form-control" id="cliente-nombre" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="numero_cuotas" class="form-label">Número de Cuotas</label>
                            <input type="number" class="form-control" id="numero_cuotas" name="numero_cuotas" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento Cuotas</label>
                            <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Agregar Plan de Pago</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Cuenta -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content border-primary shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Cuenta por Cobrar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id" name="id_cuenta_cobrar">

                        <div class="mb-3">
                            <label for="edit-cliente" class="form-label">Cliente</label>
                            <input type="text" class="form-control" id="edit-cliente" name="cliente" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-numero_factura" class="form-label">Número de Factura</label>
                            <input type="text" class="form-control" id="edit-numero_factura" name="numero_factura" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-fecha_factura" class="form-label">Fecha de Factura</label>
                            <input type="date" class="form-control" id="edit-fecha_factura" name="fecha_factura" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-monto_total" class="form-label">Monto Total</label>
                            <input type="text" class="form-control" id="edit-monto_total" name="monto_total" readonly>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Actualizar Cuenta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#cuentasPorCobrarTable').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    lengthMenu: "Mostrar _MENU_",
                    zeroRecords: "Nada encontrado - disculpas",
                    info: "Página _PAGE_ de _PAGES_",
                    infoEmpty: "No records available",
                    infoFiltered: "(Filtrado de _MAX_ registros totales)",
                    search: 'Buscar:',
                    paginate: {
                        next: 'Siguiente',
                        previous: 'Anterior'
                }
            },
            pageLength: 5, // Mostrar 10 registros por página
            lengthChange: false // Ocultar opción para cambiar el número de registros por página
        });

            // Manejo del modal de agregar plan de pago
            $('#ModalAgregarPlanPago').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var idCuentaCobrar = button.data('id');
                var nombreCliente = button.data('nombre');
                var modal = $(this);
                modal.find('#plan-cuenta-id').val(idCuentaCobrar);
                modal.find('#cliente-nombre').val(nombreCliente);
            });

          

            // Manejo del formulario de agregar plan de pago
            $('#agregarPlanPagoForm').on('submit', function(event) {
                event.preventDefault();

                var form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        window.location.href = "{{ route('plan_pago.index') }}";
                    },
                    error: function(xhr) {
                        alert('Error al agregar el plan de pago');
                    }
                });
            });
        });
    </script>
@stop
