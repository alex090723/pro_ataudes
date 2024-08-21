@extends('adminlte::page')

@section('title', 'Backup')

@section('content_header')
    <h1 class="mb-4">Administración de Backups</h1>
@stop

@section('content')
    <div class="container">
        <!-- Cuadro de Pestañas -->
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="backupTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="create-tab" data-toggle="tab" href="#create" role="tab" aria-controls="create" aria-selected="true">Crear Backup</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="restore-tab" data-toggle="tab" href="#restore" role="tab" aria-controls="restore" aria-selected="false">Restaurar Backup</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="backupTabsContent">
                    <!-- Pestaña de Crear Backup -->
                    <div class="tab-pane fade show active" id="create" role="tabpanel" aria-labelledby="create-tab">
                        <h2 class="mb-4">Crear Backup al Instante</h2>
                        <form action="{{ route('backup.create') }}" method="POST" class="mb-5">
                            @csrf
                            <div class="form-group">
                                <label for="backup_type">Tipo de Backup</label>
                                <select class="form-control" id="backup_type" name="backup_type" required>
                                    <option value="database">Base de Datos</option>
                                    <option value="files">Archivos</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Crear Backup</button>
                        </form>

                        @if(session('status'))
                            <div class="alert alert-success mt-4 mb-5">
                                {{ session('status') }}
                            </div>
                        @endif

                        <!-- Botón para Abrir el Modal de Backup Programado -->
                        <h2 class="mb-4">Configurar Backup Programado</h2>
                        <button type="button" class="btn btn-primary mb-5" data-toggle="modal" data-target="#backupScheduleModal">
                            Configurar Backup Programado
                        </button>

                        <!-- Modal de Backup Programado -->
                        <div class="modal fade" id="backupScheduleModal" tabindex="-1" role="dialog" aria-labelledby="backupScheduleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="backupScheduleModalLabel">Configurar Backup Programado</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('backup.schedule') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="frequency">Frecuencia</label>
                                                <select class="form-control" id="frequency" name="frequency" required>
                                                    <option value="daily">Diario</option>
                                                    <option value="weekly">Semanal</option>
                                                    <option value="monthly">Mensual</option>
                                                    <option value="yearly">Anual</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="backup_type">Tipo de Backup</label>
                                                <select class="form-control" id="backup_type" name="backup_type" required>
                                                    <option value="database">Base de Datos</option>
                                                    <option value="files">Archivos</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Configurar Backup</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pestaña de Restaurar Backup -->
                    <div class="tab-pane fade" id="restore" role="tabpanel" aria-labelledby="restore-tab">
                        <h2 class="mb-4">Restaurar Backup</h2>
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($backups as $backup)
                                    <tr>
                                        <td>{{ basename($backup) }}</td>
                                        <td>
                                            <!-- Formulario para Restaurar el Backup -->
                                            <form action="{{ route('backup.restore') }}" method="POST" style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="backup_path" value="{{ $backup }}">
                                                <button type="submit" class="btn btn-warning btn-sm">Restaurar</button>
                                            </form>
                                            <a href="{{ Storage::disk('local')->url($backup) }}" class="btn btn-success btn-sm" target="_blank">Descargar</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <!-- Incluir el JS de Bootstrap si no está incluido ya -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@stop
