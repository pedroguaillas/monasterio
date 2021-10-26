@extends('adminlte::page')

@section('title', 'Administración')

@section('content_header')
<!-- <h1 class="text-center">Tiempo Real</h1> -->
@stop

@section('content')
<!-- <p>
    <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
        Reporte por año
    </a>
</p> -->
<!-- <div class="collapse" id="collapseExample"> -->
<div class="card" id="collapseExample">
    <div class="card-header">
        <h3 class="card-title">
            Reporte Estadístico
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        @if($closures !== null && count($closures))
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Año</th>
                    <th>Ingresos</th>
                    <th>Egresos</th>
                    <th>Total</th>
                    <th style="width: 1em"></th>
                </tr>
            </thead>
            @php
            $sum_entry=0;
            $sum_egress=0;
            $months = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            @endphp
            <tbody>
                @foreach($closures as $item)
                <tr>
                    <td>{{ $item->date }}</td>
                    <td>{{ number_format($item->entry, 2, ',', '.') }}</td>
                    <td>{{ number_format($item->egress, 2, ',', '.') }}</td>
                    <td>{{ number_format($item->entry - $item->egress, 2, ',', '.') }}</td>
                    <livewire:statistics-month :year="$item->date">
                </tr>
                @php
                $sum_entry += $item->entry;
                $sum_egress += $item->egress;
                @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>TOTAL</th>
                    <th>{{ number_format($sum_entry, 2, ',', '.') }}</th>
                    <th>{{ number_format($sum_egress, 2, ',', '.') }}</th>
                    <th>{{ number_format($sum_entry - $sum_egress, 2, ',', '.') }}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        @endif
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- jQuery Mapael -->
<script src="{{ asset('plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
<!-- ChartJS -->
<!-- FLOT CHARTS -->
<script src="{{ asset('plugins/flot/jquery.flot.js') }}"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="{{ asset('plugins/flot/plugins/jquery.flot.resize.js') }}"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="{{ asset('plugins/flot/plugins/jquery.flot.pie.js') }}"></script>
@stop