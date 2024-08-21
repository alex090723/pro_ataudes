@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Ataudes Josue 1:9</h1>
@stop

@section('content')
    <p>Bienvenido al Menú del Sistema, {{ Auth::user()->name }}!</p>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Resumen</h3>
        </div>
        <div class="card-body">

            <!-- Primera fila -->
            <div class="row">
                <!-- Widget para Reportes -->
                <div class="col-lg-4 col-6">
                    <div class="small-box" style="border-radius: 10px; position: relative; padding: 20px; background: #e0f7fa; color: #004d40;">
                        <div class="inner" style="text-align: center;">
                            <h3>{{ $numeroReportes }}</h3>
                            <p>Reportes Totales</p>
                        </div>
                        <div class="icon" style="position: absolute; top: 10px; right: 10px; font-size: 4rem; color: rgba(0, 0, 0, 0.7);">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <img src="https://cdn-icons-png.flaticon.com/512/1928/1928440.png" alt="Report Icon" style="position: absolute; bottom: -10px; left: 15px; width: 50px; opacity: 0.7;">
                    </div>
                </div>

                <!-- Widget para Ventas -->
                <div class="col-lg-4 col-6">
                    <div class="small-box" style="border-radius: 10px; position: relative; padding: 20px; background: #b9fbc0; color: #004d40;">
                        <div class="inner" style="text-align: center;">
                            <h3>{{ $numeroVentas }}</h3>
                            <p>Ventas Totales</p>
                        </div>
                        <div class="icon" style="position: absolute; top: 10px; right: 10px; font-size: 4rem; color: rgba(0, 0, 0, 0.7);">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <img src="https://cdn-icons-png.flaticon.com/512/2164/2164825.png" alt="Ventas Icon" style="position: absolute; bottom: -10px; left: 15px; width: 50px; opacity: 0.7;">
                    </div>
                </div>

                <!-- Widget para Carrozas -->
                <div class="col-lg-4 col-6">
                    <div class="small-box" style="border-radius: 10px; position: relative; padding: 20px; background: #f0f4c3; color: #004d40;">
                        <div class="inner" style="text-align: center;">
                            <h3>{{ $numeroCarrozas }}</h3>
                            <p>Carrozas Totales</p>
                        </div>
                        <div class="icon" style="position: absolute; top: 10px; right: 10px; font-size: 4rem; color: rgba(0, 0, 0, 0.7);">
                            <i class="fas fa-car-side"></i>
                        </div>
                        <img src="https://cdn-icons-png.flaticon.com/512/809/809018.png" alt="Carrozas Icon" style="position: absolute; bottom: -10px; left: 15px; width: 50px; opacity: 0.7;">
                    </div>
                </div>

                <!-- Widget para Personas -->
                <div class="col-lg-4 col-6">
                    <div class="small-box" style="border-radius: 10px; position: relative; padding: 20px; background: #d6cdd0; color: #333;">
                        <div class="inner" style="text-align: center;">
                            <h3>{{ $numeroPersonas }}</h3>
                            <p>Personas Totales</p>
                        </div>
                        <div class="icon" style="position: absolute; top: 10px; right: 10px; font-size: 4rem; color: rgba(0, 0, 0, 0.7);">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <img src="https://cdn-icons-png.flaticon.com/512/64/64572.png" alt="Personas Icon" style="position: absolute; bottom: -10px; left: 15px; width: 50px; opacity: 0.7;">
                    </div>
                </div>

                <!-- Widget para Inventario de Materiales -->
                <div class="col-lg-4 col-6">
                    <div class="small-box" style="border-radius: 10px; position: relative; padding: 20px; background: #f3e5f5; color: #333;">
                        <div class="inner" style="text-align: center;">
                            <h3>{{ $numeroInventarioMateriales }}</h3>
                            <p>Inventario Materiales Totales</p>
                        </div>
                        <div class="icon" style="position: absolute; top: 10px; right: 10px; font-size: 4rem; color: rgba(0, 0, 0, 0.7);">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <img src="https://cdn-icons-png.flaticon.com/512/1047/1047578.png" alt="Inventario Materiales Icon" style="position: absolute; bottom: -10px; left: 15px; width: 50px; opacity: 0.7;">
                    </div>
                </div>

                <!-- Widget para Inventario de Productos -->
                <div class="col-lg-4 col-6">
                    <div class="small-box" style="border-radius: 10px; position: relative; padding: 20px; background: #e8eaf6; color: #333;">
                        <div class="inner" style="text-align: center;">
                            <h3>{{ $numeroProductos }}</h3>
                            <p>Inventario Productos Totales</p>
                        </div>
                        <div class="icon" style="position: absolute; top: 10px; right: 10px; font-size: 4rem; color: rgba(0, 0, 0, 0.7);">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <img src="https://cdn-icons-png.flaticon.com/512/1047/1047578.png" alt="Inventario Productos Icon" style="position: absolute; bottom: -10px; left: 15px; width: 50px; opacity: 0.7;">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            Resumen de los módulos
        </div>
    </div>

@stop

@section('css')
    <!-- Puedes agregar CSS adicional aquí -->
@stop

@section('js')
    <!-- Incluye librerías de gráficos como Chart.js o cualquier otra librería -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar', // Tipo de gráfico: bar, line, pie, etc.
                data: {
                    labels: ['Reportes', 'Ventas', 'Carrozas', 'Personas', 'Materiales', 'Productos'],
                    datasets: [{
                        label: 'Resumen',
                        data: [
                            {{ $numeroReportes }},
                            {{ $numeroVentas }},
                            {{ $numeroCarrozas }},
                            {{ $numeroPersonas }},
                            {{ $numeroInventarioMateriales }},
                            {{ $numeroProductos }}
                        ],
                        backgroundColor: [
                            'rgba(224, 247, 250, 0.2)',
                            'rgba(185, 251, 192, 0.2)',
                            'rgba(240, 244, 195, 0.2)',
                            'rgba(214, 205, 208, 0.2)',
                            'rgba(243, 229, 245, 0.2)',
                            'rgba(232, 234, 246, 0.2)'
                        ],
                        borderColor: [
                            'rgba(224, 247, 250, 1)',
                            'rgba(185, 251, 192, 1)',
                            'rgba(240, 244, 195, 1)',
                            'rgba(214, 205, 208, 1)',
                            'rgba(243, 229, 245, 1)',
                            'rgba(232, 234, 246, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@stop
