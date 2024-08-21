@extends('adminlte::page')

@section('title', 'Reportes')

@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
@endsection

@section('content_header')
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <h2>Reportes</h2>
  <p>Lista de reportes</p>
@endsection

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

<!-- Tabla de reportes -->
<div class="card">
  <div class="card-body">
    <table id="cc" class="table table-striped table-bordered" style="width:100%">
      <thead>
        <tr>
          <th>#</th>
          <th>Tipo</th>
          <th>Detalles</th>
          <th>Fecha y Hora</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
      @foreach($reportes as $index => $reporte)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $reporte->Tipo_reporte }}</td>
            <td>{{ $reporte->Detalles_reportes }}</td>
            <td>{{ $reporte->Fecha }}</td>
            <td>

              @can('editar-reporte')
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editreportes{{ $reporte->Id_reportes }}">
                <i class="fa fa-edit"></i>
              </button>
              @endcan

            </td>
          </tr>

          <!-- Modal de editar reporte -->
          <div class="modal fade" id="editreportes{{ $reporte->Id_reportes }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
              <div class="modal-content border-primary shadow-lg">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Editar Reporte</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('reportes.update', ['id' => $reporte->Id_reportes]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                      <label for="Tipo_reporte" class="form-label">Tipo de Reporte</label>
                      <input type="text" class="form-control" id="Tipo_reporte" name="Tipo_reporte" maxlength="255" value="{{ $reporte->Tipo_reporte }}" required>
                    </div>
                    <div class="mb-3">
                      <label for="Detalles_reportes" class="form-label">Detalles Reportes</label>
                      <input type="text" class="form-control" id="Detalles_reportes" name="Detalles_reportes" maxlength="255" value="{{ $reporte->Detalles_reportes }}" required>
                    </div>
                    <div class="mb-3">
                      <label for="Fecha" class="form-label">Fecha</label>
                      <input type="date" class="form-control" id="Fecha" name="Fecha" value="{{ $reporte->Fecha }}" required>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-primary">Actualizar Reporte</button>
                    </div>
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

<!-- Botón para abrir el modal de INSERTAR -->
@can('crear-reporte')
<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addreportes" type="button">Agregar reporte</button>
@endcan


<!-- Modal de INSERTAR -->
<div class="modal fade" id="addreportes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content border-primary shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar un nuevo reporte</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('reportes.store') }}" method="post">
          @csrf
          <div class="mb-3">
            <label for="Tipo_reporte" class="form-label">Tipo de Reporte</label>
            <input type="text" class="form-control" id="Tipo_reporte" name="Tipo_reporte" placeholder="Ingrese el tipo de reporte" required>
          </div>
          <div class="mb-3">
            <label for="Detalles_reportes" class="form-label">Detalles Reportes</label>
            <input type="text" class="form-control" id="Detalles_reportes" name="Detalles_reportes" placeholder="Ingrese los detalles del reporte" required>
          </div>
          <div class="mb-3">
            <label for="Fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="Fecha" name="Fecha" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Agregar Reporte</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('js')
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#cc').DataTable({
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
        }
      });
    });
  </script>
@endsection
