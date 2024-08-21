@extends('adminlte::page')

@section('title', 'Reporte')

@section('content_header')
    <h1 class="text-center">Vista previa del reporte</h1>
@stop

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h3>Reporte Generado</h3>
                        <img src="{{ asset('images/logo.png') }}" alt="Logo del Reporte" class="img-fluid mt-2" style="max-height: 100px;">
                    </div>
                    <div class="card-body">
                        <div class="embed-responsive embed-responsive-16by9">
                            <!-- Embed PDF -->
                            <iframe src="data:application/pdf;base64,{{ $pdfBase64 }}" class="embed-responsive-item" width="100%" height="600px"></iframe>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="javascript:void(0);" onclick="window.print()" class="btn btn-success mr-3">
                            <i class="fas fa-print"></i> Imprimir Reporte
                        </a>
                        <a href="{{ route('report.index') }}" class="btn btn-danger">
                            <i class="fas fa-sign-out-alt"></i> Salir
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
