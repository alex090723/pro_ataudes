@extends('adminlte::page')

@section('title', 'Planes de Pago')

@section('content_header')
    <h1>Lista de Planes de Pago</h1>
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
                <!-- Botón de Agregar Plan de Pago -->

            </div>
        </div>

        <!-- Tabla de Planes de Pago -->
        <div class="card">
            <div class="col-md-12">
                <table class="table table-striped table-bordered" id="planesTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Número de Factura</th>
                            <th>Nombre Cliente</th>
                            <th>Saldo Pendiente</th>
                            <th>Número de Cuotas</th>
                            <th>Monto por Cuota</th>
                            <th>Monto Abono</th>
                            <th>Fecha Vencimiento Cuotas</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($planes as $index => $plan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $plan->numero_factura }}</td>
                                <td>{{ $plan->nombre_cliente }}</td>
                                <td>{{ number_format($plan->saldo_pendiente, 2) }}</td>
                                <td>{{ $plan->numero_cuotas }}</td>
                                <td>{{ number_format($plan->monto_cuotas, 2) }}</td>
                                <td>{{ number_format($plan->monto_abono, 2) }}</td>
                                <td>{{ $plan->fecha_vencimiento_cuotas ? date('d/m/Y', strtotime($plan->fecha_vencimiento_cuotas)) : 'N/A' }}</td>
                                <td>{{ $plan->estatus == 1 ? 'Pendiente' : 'Pagado' }}</td>
                                <td>
                                    <!-- Botones para Editar -->
                                    @can('editar-venta')
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#ModalEditarPlanPago"
                                    data-id="{{ $plan->id_plan_pago }}"
                                    data-id_cuenta_cobrar="{{ $plan->id_cuenta_cobrar }}"
                                    data-numero_cuotas="{{ $plan->numero_cuotas }}"
                                    data-monto_abono="{{ $plan->monto_abono }}"
                                    data-fecha_vencimiento_cuotas="{{ $plan->fecha_vencimiento_cuotas }}">
                                    Agregar Abono
                                    </button>
                                    @endcan
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
                <form action="{{ route('plan_pago.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="select-id_cuenta_cobrar" class="form-label">Número de Factura</label>
                        <select class="form-control" id="select-id_cuenta_cobrar" name="id_cuenta_cobrar" required>
                            @foreach($facturas as $factura)
                                <option value="{{ $factura->id_cuenta_cobrar }}">{{ $factura->numero_factura }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="numero_cuotas" class="form-label">Número de Cuotas</label>
                        <input type="number" class="form-control" id="numero_cuotas" name="numero_cuotas" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento Cuotas</label>
                        <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" required>
                    </div>
                    <div class="mb-3">
                        <label for="monto_abono" class="form-label">Monto Abono</label>
                        <input type="number" step="0.01" class="form-control" id="monto_abono" name="monto_abono" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="metodo" class="form-label">Método de Pago</label>
                        <select class="form-control" id="metodo" name="metodo" required>
                            <option value="Transferencia">Transferencia</option>
                            <option value="Efectivo">Efectivo</option>
                        </select>
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


<!-- Modal para Editar Plan de Pago -->
<div class="modal fade" id="ModalEditarPlanPago" tabindex="-1" aria-labelledby="ModalEditarPlanPagoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalEditarPlanPagoLabel">Editar Plan de Pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('plan_pago.update', 'plan_pago_id') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-3">
                        <label for="edit-select-id_cuenta_cobrar" class="form-label">Número de Factura</label>
                        <input type="text" class="form-control" id="edit-select-id_cuenta_cobrar" name="id_cuenta_cobrar" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="edit-numero_cuotas" class="form-label">Número de Cuotas</label>
                        <input type="number" class="form-control" id="edit-numero_cuotas" name="numero_cuotas" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-fecha_vencimiento_cuotas" class="form-label">Fecha de Vencimiento Cuotas</label>
                        <input type="date" class="form-control" id="edit-fecha_vencimiento_cuotas" name="fecha_vencimiento_cuotas" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-monto_abono" class="form-label">Monto Abono</label>
                        <input type="number" step="0.01" class="form-control" id="edit-monto_abono" name="monto_abono" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-metodo" class="form-label">Método de Pago</label>
                        <select class="form-control" id="edit-metodo" name="metodo" required>
                            <option value="Transferencia">Transferencia</option>
                            <option value="Efectivo">Efectivo</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar Plan de Pago</button>
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
    $('#ModalEditarPlanPago').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id');
        var idCuentaCobrar = button.data('id_cuenta_cobrar');
        var numeroCuotas = button.data('numero_cuotas');
        var montoAbono = button.data('monto_abono');
        var fechaVencimientoCuotas = button.data('fecha_vencimiento_cuotas');
        var metodo = button.data('metodo'); // Campo para el método

        var modal = $(this);
        modal.find('form').attr('action', '/plan_pago/' + id); // Actualiza la URL del formulario
        modal.find('#edit-id').val(id);
        modal.find('#edit-select-id_cuenta_cobrar').val(idCuentaCobrar); // Establece el número de factura en el campo readonly
        modal.find('#edit-numero_cuotas').val(numeroCuotas);
        modal.find('#edit-monto_abono').val(montoAbono);
        modal.find('#edit-fecha_vencimiento_cuotas').val(fechaVencimientoCuotas);
        modal.find('#edit-metodo').val(metodo); // Establece el método seleccionado
        
    });
});
</script>



@stop
