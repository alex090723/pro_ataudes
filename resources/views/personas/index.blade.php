@extends('adminlte::page')

@section('title', 'Personas')

@section('content_header')
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <div class="container">
    <div class="row mb-3">
      <div class="col-md-12 text-end"> <!-- Cambiado text-right a text-end para Bootstrap 5 -->
        <!-- Botón de Agregar Registros -->
        @can('crear-persona')
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ModalIngresarPersona">
            Agregar Registros
          </button>
        @endcan

      </div>
    </div>
    <h2>Personas</h2>
  </div>
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

  /* Opcional: Ajusta la posición del botón si es necesario */
.container {
  position: relative;
}

.btn-success {
  position: absolute;
  top: 10px; /* Ajusta la distancia desde el borde superior */
  right: 10px; /* Ajusta la distancia desde el borde derecho */
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
                <!-- Botón de Agregar Registros -->
                
            </div>
        </div>

      <!-- Modal para Ingresar Persona -->
<div class="modal fade" id="ModalIngresarPersona" tabindex="-1" aria-labelledby="ModalIngresarPersonaLabel" aria-hidden="true">
    <<div class="modal-dialog modal-dialog-scrollable">
  <div class="modal-content border-primary shadow-lg">
            <!-- Encabezado del Modal -->
            <div class="modal-header">
                <h4 class="modal-title">Agregar Persona</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Cuerpo del Modal -->
            <div class="modal-body">
                <div class="container mt-3">
                    <form action="{{ route('personas.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Nombre -->
                                <div class="mb-3">
                                    <label for="Nombre_persona" class="form-label">Nombre Completo</label>
                                    <input type="text" class="form-control w-100" id="Nombre_persona" name="Nombre_persona" 
                                    required  pattern="^[a-zA-Z0-9\s]+$" 
                                    title="Solo se permiten letras.">
                                    @error('Nombre_persona')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- DNI -->
                                <div class="mb-3">
                                    <label for="DNI_persona" class="form-label">Número de Identidad</label>
                                    <input type="text" class="form-control w-100" id="DNI_persona" name="DNI_persona" 
                                    required 
                                    pattern="^[0-9\-]+$" title="Solo se permiten números y guiones (-).">
                                    @error('DNI_persona')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Sexo -->
                                <div class="mb-3">
                                    <label for="Sexo_persona" class="form-label">Sexo</label>
                                    <select class="form-select w-100" id="Sexo_persona" name="Sexo_persona" required>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                    @error('Sexo_persona')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Edad -->
                                <div class="mb-3">
                                    <label for="Edad_persona" class="form-label">Edad</label>
                                    <input type="number" class="form-control w-100" id="Edad_persona" name="Edad_persona" 
                                    required  min="0" max="120">
                                    @error('Edad_persona')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Estado Civil -->
                                <div class="mb-3">
                                    <label for="Estado_Civil" class="form-label">Estado Civil</label>
                                    <select class="form-select w-100" id="Estado_Civil" name="Estado_Civil" required>
                                        <option value="SOLTERO">Soltero</option>
                                        <option value="CASADO">Casado</option>
                                        <option value="DIVORCIADO">Divorciado</option>
                                        <option value="VIUDO">Viudo</option>
                                    </select>
                                    @error('Estado_Civil')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Tipo de Persona -->
                                <div class="mb-3">
                                    <label for="Tipo_persona" class="form-label">Tipo de Persona</label>
                                    <select class="form-select w-100" id="Tipo_persona" name="Tipo_persona" required onchange="toggleFields()">
                                        <option value="CLIENTE">Cliente</option>
                                        <option value="EMPLEADO">Empleado</option>
                                        <option value="PROVEEDOR">Proveedor</option>
                                    </select>
                                    @error('Tipo_persona')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Usuario Registro -->
                                <div class="mb-3">
                                    <label for="Usuario_registro" class="form-label">Usuario Registro</label>
                                    <input type="text" class="form-control w-100" id="Usuario_registro" name="Usuario_registro" required value="{{ auth()->user()->name }}" readonly>
                                    @error('Usuario_registro')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- País -->
                                <div class="mb-3">
                                    <label for="Pais" class="form-label">País</label>
                                    <select class="form-control w-100" id="Pais" name="Pais" required>
                                      <option value="Honduras">Honduras</option>
                                    </select>
                                    @error('Pais')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Departamento -->
                                <div class="mb-3">
                                  <label for="Departamento" class="form-label">Departamento</label>
                                  <select class="form-control w-100" id="Departamento" name="Departamento" required>
                                    <option value= "" disabled selected>Selecciona un departamento</option>
                                    <option value="Atlántida">Atlántida</option>
                                    <option value="Choluteca">Choluteca</option>
                                    <option value="Colón">Colón</option>
                                    <option value="Comayagua">Comayagua</option>
                                    <option value="Copán">Copán</option>
                                    <option value="Cortés">Cortés</option>
                                    <option value="El Paraíso">El Paraíso</option>
                                    <option value="Francisco Morazán">Francisco Morazán</option>
                                    <option value="Gracias a Dios">Gracias a Dios</option>
                                    <option value="Intibucá">Intibucá</option>
                                    <option value="Islas de la Bahía">Islas de la Bahía</option>
                                    <option value="La Paz">La Paz</option>
                                    <option value="Lempira">Lempira</option>
                                    <option value="Ocotepeque">Ocotepeque</option>
                                    <option value="Olancho">Olancho</option>
                                    <option value="Santa Bárbara">Santa Bárbara</option>
                                    <option value="Valle">Valle</option>
                                    <option value="Yoro">Yoro</option>
                                  </select>
                                  @error('Departamento')
                                  <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                                <!-- Municipio -->
                                <div class="mb-3">
                                    <label for="Municipio" class="form-label">Municipio</label>
                                    <input type="text" class="form-control w-100" id="Municipio" name="Municipio" 
                                    required pattern="^[a-zA-Z\s]+$">
                                    @error('Municipio')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Colonia -->
                                <div class="mb-3">
                                    <label for="Colonia" class="form-label">Colonia</label>
                                    <input type="text" class="form-control w-100" id="Colonia" name="Colonia" 
                                    required pattern="^[a-zA-Z\s]+$">
                                    @error('Colonia')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="Email" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control w-100" id="Email" name="Email" required>
                                    @error('Email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Teléfono -->
                                <div class="mb-3">
                                    <label for="Numero_telefono" class="form-label">Número de Teléfono</label>
                                    <input type="text" class="form-control w-100" id="Numero_telefono" name="Numero_telefono" 
                                    required pattern="^[0-9\-]+$" title="Solo se permiten números y guiones (-).">
                                    @error('Numero_telefono')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Tipo de Teléfono -->
                                <div class="mb-3">
                                    <label for="Tipo_telefono" class="form-label">Tipo de Teléfono</label>
                                    <select class="form-select w-100" id="Tipo_telefono" name="Tipo_telefono" required>
                                        <option value="PERSONAL">Personal</option>
                                        <option value="CASA">Casa</option>
                                        <option value="TRABAJO">Trabajo</option>
                                    </select>
                                    @error('Tipo_telefono')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Campos específicos para Empleado -->
                        <div id="empleadoFields" class="d-none">
                            <div class="mb-3">
                                <label for="Cargo" class="form-label">Cargo</label>
                                <input type="text" class="form-control w-100" id="Cargo" name="Cargo">
                                @error('Cargo')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="Fecha_contratacion" class="form-label">Fecha de Contratación</label>
                                <input type="date" class="form-control w-100" id="Fecha_contratacion" name="Fecha_contratacion">
                                @error('Fecha_contratacion')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- Campos específicos para Proveedor -->
                        <div id="proveedorFields" class="d-none">
                            <div class="mb-3">
                                <label for="Detalle_material" class="form-label">Detalle de Material</label>
                                <input type="text" class="form-control w-100" id="Detalle_material" name="Detalle_material"
                                pattern="^[a-zA-Z0-9\s]+$" 
                                    title="Solo se permiten letras.">
                                @error('Detalle_material')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="Fecha_compra" class="form-label">Fecha de Compra</label>
                                <input type="date" class="form-control w-100" id="Fecha_compra" name="Fecha_compra">
                                @error('Fecha_compra')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- Botón de Envío -->
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar Persona</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
        <!-- Tabla dentro de un cuadro -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <span>Personas Registradas</span>
                    <!-- Botón para mostrar/ocultar columnas -->
                    <button id="toggleColumnsButton" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive">
                 <table id="personasTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>Sexo</th>
                            <th>Edad</th>
                            <th>Estado Civil</th>
                            <th>Tipo</th>
                            <th>Usuario Registro</th>
                            <th>Fecha Registro</th>
                            <th class="additional-columns">País</th>
                            <th class="additional-columns">Departamento</th>
                            <th class="additional-columns">Municipio</th>
                            <th class="additional-columns">Colonia</th>
                            <th class="additional-columns">Email</th>
                            <th class="additional-columns">Teléfono</th>
                            <th class="additional-columns">Tipo Teléfono</th>
                            <th class="additional-columns">Cargo</th>
                            <th class="additional-columns">Detalle Material</th>
                            <th class="additional-columns">Fecha Compra</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($personas as $index => $persona)
                        <tr id="row-{{ $index + 1 }}">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $persona->Nombre_persona }}</td>
                            <td>{{ $persona->DNI_persona }}</td>
                            <td>{{ $persona->Sexo_persona }}</td>
                            <td>{{ $persona->Edad_persona }}</td>
                            <td>{{ $persona->Estado_Civil }}</td>
                            <td>{{ $persona->Tipo_persona }}</td>
                            <td>{{ $persona->Usuario_registro }}</td>
                            <td>{{ $persona->Fecha_registro }}</td>
                            <td class="additional-columns">{{ $persona->Pais }}</td>
                            <td class="additional-columns">{{ $persona->Departamento }}</td>
                            <td class="additional-columns">{{ $persona->Municipio }}</td>
                            <td class="additional-columns">{{ $persona->Colonia }}</td>
                            <td class="additional-columns">{{ $persona->Email }}</td>
                            <td class="additional-columns">{{ $persona->Numero_Telefono }}</td>
                            <td class="additional-columns">{{ $persona->Tipo_Telefono }}</td>
                            <td class="additional-columns">{{ $persona->Cargo }}</td>
                            <td class="additional-columns">{{ $persona->Detalle_material }}</td>
                            <td class="additional-columns">{{ $persona->Fecha_compra }}</td>
                            <td>
                                <!-- Botones de acción -->
                                @can('editar-persona')
                                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editPersona{{ $persona->Id_persona }}">
                                  <i class="fa fa-edit"></i>
                                  </button>
                                @endcan

                                <!-- Otros botones -->
                            </td>
                        </tr>
                        <!-- Modal de editar persona -->
                         <div class="modal fade" id="editPersona{{ $persona->Id_persona }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content border-primary shadow-lg">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Editar Persona</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <form action="{{ route('personas.update', ['id' => $persona->Id_persona]) }}" method="post">
                                  @csrf
                                  @method('PUT')
                                  <div class="row">
                                    <div class="col-md-6">
                                      <!-- Campos del formulario de edición -->
                                       <div class="mb-3">
                                        <label for="Nombre_persona" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="Nombre_persona" name="Nombre_persona" value="{{ old('Nombre_persona', $persona->Nombre_persona) }}"
                                        required  pattern="^[a-zA-Z0-9\s]+$" 
                                    title="Solo se permiten letras.">
                                      </div>
                                      <div class="mb-3">
                                        <label for="DNI_persona" class="form-label">Número de Identidad</label>
                                        <input type="text" class="form-control" id="DNI_persona" name="DNI_persona" value="{{ old('DNI_persona', $persona->DNI_persona) }}"
                                        required 
                                        pattern="^[0-9\-]+$" title="Solo se permiten números y guiones (-).">
                                      </div>
                                      <div class="mb-3">
                                        <label for="Sexo_persona" class="form-label">Sexo</label>
                                        <select class="form-select" id="Sexo_persona" name="Sexo_persona">
                                          <option value="M" {{ old('Sexo_persona', $persona->Sexo_persona) == 'M' ? 'selected' : '' }}>Masculino</option>
                                          <option value="F" {{ old('Sexo_persona', $persona->Sexo_persona) == 'F' ? 'selected' : '' }}>Femenino</option>
                                        </select>
                                      </div>
                                      <div class="mb-3">
                                        <label for="Edad_persona" class="form-label">Edad</label>
                                        <input type="number" class="form-control" id="Edad_persona" name="Edad_persona" value="{{ old('Edad_persona', $persona->Edad_persona) }}"
                                        required  min="0" max="120">
                                      </div>
                                      <div class="mb-3">
                                        <label for="Estado_Civil" class="form-label">Estado Civil</label>
                                        <select class="form-select" id="Estado_Civil" name="Estado_Civil">
                                          <option value="SOLTERO" {{ old('Estado_Civil', $persona->Estado_Civil) == 'SOLTERO' ? 'selected' : '' }}>Soltero</option>
                                          <option value="CASADO" {{ old('Estado_Civil', $persona->Estado_Civil) == 'CASADO' ? 'selected' : '' }}>Casado</option>
                                          <option value="DIVORCIADO" {{ old('Estado_Civil', $persona->Estado_Civil) == 'DIVORCIADO' ? 'selected' : '' }}>Divorciado</option>
                                          <option value="VIUDO" {{ old('Estado_Civil', $persona->Estado_Civil) == 'VIUDO' ? 'selected' : '' }}>Viudo</option>
                                        </select>
                                      </div>
                                      <div class="mb-3">
                                        <label for="Tipo_persona" class="form-label">Tipo Persona</label>
                                        <select class="form-select" id="Tipo_persona" name="Tipo_persona" onchange="showAdditionalFields(this.value)">
                                          <option value="Cliente" {{ old('Tipo_persona', $persona->Tipo_persona) == 'Cliente' ? 'selected' : '' }}>Cliente</option>
                                          <option value="Empleado" {{ old('Tipo_persona', $persona->Tipo_persona) == 'Empleado' ? 'selected' : '' }}>Empleado</option>
                                          <option value="Proveedor" {{ old('Tipo_persona', $persona->Tipo_persona) == 'Proveedor' ? 'selected' : '' }}>Proveedor</option>
                                        </select>
                                      </div>
                                      <div class="mb-3">
                                        <label for="Usuario_registro" class="form-label">Usuario Registro</label>
                                        <input type="text" class="form-control" id="Usuario_registro" name="Usuario_registro" value="{{ auth()->user()->name }}" readonly>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <!-- Campos de direcciones -->
                                      <div class="mb-3">
                                        <label for="Pais" class="form-label">País</label>
                                        <input type="text" class="form-control @error('Pais') is-invalid @enderror" id="Pais" name="Pais" 
                                        value="{{ old('Pais', $persona->direcciones->Pais ?? 'Honduras') }}" 
                                        required maxlength="255" pattern="[a-zA-Z\s]+" title="Solo letras y espacios" readonly>
                                        @error('Pais')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                      </div>
                                      <div class="mb-3">
                                        <label for="Departamento" class="form-label">Departamento</label>
                                        <select class="form-select @error('Departamento') is-invalid @enderror" id="Departamento" name="Departamento">
                                          <option value="" disabled selected>Selecciona un departamento</option>
                                          @foreach ([
                                            'Atlántida', 'Choluteca', 'Colón', 'Comayagua', 'Copán', 'Cortés', 'El Paraíso',
                                            'Francisco Morazán', 'Gracias a Dios', 'Intibucá', 'Islas de la Bahía', 'La Paz',
                                            'Lempira', 'Ocotepeque', 'Olancho', 'Santa Bárbara', 'Valle', 'Yoro'
                                            ] as $departamento)
                                            <option value="{{ $departamento }}" {{ old('Departamento', $persona->direcciones->Departamento ?? '') == $departamento ? 'selected' : '' }}>
                                            {{ $departamento }}
                                          </option>
                                          @endforeach
                                        </select>
                                        @error('Departamento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                      </div>
                                      <div class="mb-3">
                                        <label for="Municipio" class="form-label">Municipio</label>
                                        <input type="text" class="form-control" id="Municipio" name="Municipio" value="{{ old('Municipio', $persona->direcciones->Municipio ?? '') }}"
                                         pattern="^[a-zA-Z\s]+$">
                                      </div>
                                      <div class="mb-3">
                                        <label for="Colonia" class="form-label">Colonia</label>
                                        <input type="text" class="form-control" id="Colonia" name="Colonia" value="{{ old('Colonia', $persona->direcciones->Colonia ?? '') }}"
                                         pattern="^[a-zA-Z\s]+$">
                                      </div>
                                      <!-- Campos de email -->
                                       <div class="mb-3">
                                        <label for="Email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="Email" name="Email" value="{{ old('Email', $persona->email->Email ?? '') }}">
                                      </div>
                                      <!-- Campos de teléfono -->
                                       <div class="mb-3">
                                        <label for="Numero_Telefono" class="form-label">Número de Teléfono</label>
                                        <input type="text" class="form-control" id="Numero_Telefono" name="Numero_Telefono" value="{{ old('Numero_Telefono', $persona->telefono->Numero_Telefono ?? '') }}"
                                        pattern="^[0-9\-]+$" title="Solo se permiten números y guiones (-).">
                                      </div>
                                      <div class="mb-3">
                                        <label for="Tipo_Telefono" class="form-label">Tipo Teléfono</label>
                                        <select class="form-select" id="Tipo_Telefono" name="Tipo_Telefono">
                                          <option value="Personal" {{ old('Tipo_Telefono', $persona->telefono->Tipo_Telefono ?? '') == 'Personal' ? 'selected' : '' }}>Personal</option>
                                          <option value="Casa" {{ old('Tipo_Telefono', $persona->telefono->Tipo_Telefono ?? '') == 'Casa' ? 'selected' : '' }}>Casa</option>
                                          <option value="Trabajo" {{ old('Tipo_Telefono', $persona->telefono->Tipo_Telefono ?? '') == 'Trabajo' ? 'selected' : '' }}>Trabajo</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- Campos específicos para Empleado -->
                                   <div id="editEmpleadoFields" style="display: none;">
                                    <div class="mb-3">
                                      <label for="Cargo" class="form-label">Cargo</label>
                                      <input type="text" class="form-control" id="Cargo" name="Cargo" value="{{ old('Cargo', $persona->empleados->Cargo ?? '') }}"
                                      pattern="^[a-zA-Z\s]+$">
                                    </div>
                                    <div class="mb-3">
                                      <label for="Fecha_contratacion" class="form-label">Fecha de Contratación</label>
                                      <input type="date" class="form-control" id="Fecha_contratacion" name="Fecha_contratacion" value="{{ old('Fecha_contratacion', $persona->empleados->Fecha_contratacion ?? '') }}">
                                    </div>
                                  </div>
                                  <!-- Campos específicos para Proveedor -->
                                   <div id="editProveedorFields" style="display: none;">
                                    <div class="mb-3">
                                      <label for="Detalle_material" class="form-label">Detalle Material</label>
                                      <input type="text" class="form-control" id="Detalle_material" name="Detalle_material" value="{{ old('Detalle_material', $persona->proveedores->Detalle_material ?? '') }}"
                                      pattern="^[a-zA-Z\s]+$">
                                    </div>
                                    <div class="mb-3">
                                      <label for="Fecha_compra" class="form-label">Fecha de Compra</label>
                                      <input type="date" class="form-control" id="Fecha_compra" name="Fecha_compra" value="{{ old('Fecha_compra', $persona->proveedores->Fecha_compra ?? '') }}">
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Actualizar</button>
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
          </div>
          @stop
          

@section('css')
  <!-- Incluye aquí los estilos adicionales si es necesario -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
@endsection     

@section('js')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

    <script>
   document.addEventListener('DOMContentLoaded', function() {
    const table = $('#personasTable').DataTable({
        autoWidth: false,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json",
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "Nada encontrado - disculpa",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "No hay registros disponibles",
            infoFiltered: "(filtrado de _MAX_ registros totales)",
            search: "Buscar:",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            }
        },
        pageLength: 5, // Mostrar 10 registros por página
        lengthChange: false // Ocultar opción para cambiar el número de registros por página
    });

    // Inicializa la visibilidad de las columnas
    const additionalColumns = document.querySelectorAll('.additional-columns');
    additionalColumns.forEach(column => {
        column.classList.add('d-none'); // Oculta las columnas inicialmente
    });

    // Manejo del tipo de persona
    const tipoPersonaSelect = document.getElementById('Tipo_persona');
    const empleadoFields = document.getElementById('empleadoFields');
    const proveedorFields = document.getElementById('proveedorFields');

    tipoPersonaSelect.addEventListener('change', function() {
        const tipoPersona = tipoPersonaSelect.value;

        // Oculta ambos conjuntos de campos
        empleadoFields.classList.add('d-none');
        proveedorFields.classList.add('d-none');

        // Muestra los campos específicos basados en el tipo de persona seleccionado
        if (tipoPersona === 'EMPLEADO') {
            empleadoFields.classList.remove('d-none');
        } else if (tipoPersona === 'PROVEEDOR') {
            proveedorFields.classList.remove('d-none');
        }
    });

    // Manejo de mostrar/ocultar columnas
    const toggleColumnsButton = document.getElementById('toggleColumnsButton');
    toggleColumnsButton.addEventListener('click', function() {
        additionalColumns.forEach(column => {
            column.classList.toggle('d-none');
        });

        // Actualiza el ícono del botón
        const icon = toggleColumnsButton.querySelector('i');
        icon.classList.toggle('fa-plus', additionalColumns[0].classList.contains('d-none'));
        icon.classList.toggle('fa-minus', !additionalColumns[0].classList.contains('d-none'));
    });
});
</script>
@stop