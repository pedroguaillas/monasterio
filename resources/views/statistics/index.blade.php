@extends('adminlte::page')

@section('title', 'Administración')

@section('content_header')
<!-- <h1 class="text-center">Tiempo Real</h1> -->
@stop

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $countcustomers }}</h3>

                <p>Usuario</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-stalker"></i>
            </div>
            <a href="#" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ '6:00 - 22:00' }}</h3>

                <p>Horarios</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
            <a href="#" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ 'Promedio' }}</h3>

                <p>Edades</p>
            </div>
            <div class="icon">
                <i class="ion ion-cash"></i>
            </div>
            <a href="#" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ 'Estadisticas' }}</h3>

                <p>{{ 'Estadisticas' }}</p>
            </div>
            <div class="icon">
                <i class="ion ion-pricetags"></i>
            </div>
            <a href="#" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
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
            <a target="_blank" href="{{ route('reporte') }}" class="btn btn-white btn-sm">
                <i class="far fa-file-pdf"></i>
            </a>
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
            @endphp
            <tbody>
                @foreach($closures as $item)
                <tr>
                    <input type="hidden" class="serdelete_val" value="{{$item->date}}">

                    <td style="width: 25%;">{{ $item->date }}</td>
                    <td style="width: 25%;">{{ number_format($item->entry, 2, ',', '.') }}</td>
                    <td style="width: 25%;">{{ number_format($item->egress, 2, ',', '.') }}</td>
                    <td>{{ number_format($item->entry - $item->egress, 2, ',', '.') }}</td>
                    <td class="text-center" width="150px">
                        <button onClick="collapseAnio({{$item->date}})" class="btn btn-success btn-sm">+</button>

                        <a target="_blank" href="{{ route('monthReport', $item->date) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="far fa-file-pdf"></i>
                        </a>

                    </td>
                </tr>
                <tr>
                    <td id="{{ 'anio' .$item->date }}" colspan="5">
                    </td>
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
<script>
    let moths = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]

    function collapseAnio(anio) {
        $.ajax({
            type: 'GET',
            url: "{{url('admin/statistics/bymonth')}}/" + anio,
            success: (res) => {
                let part = '<table style="width: 100%;">'
                part += '<tbody>'
                jQuery.each(res.closuresmoth, function(index, val) {
                    let month = Number(val.month) - 1
                    part += '<tr style="font-style: italic;">'
                    part += '<td style="width: 25%;">' + moths[month] + '</td>'
                    part += '<td style="width: 25%;">' + val.entry + '</td>'
                    part += '<td style="width: 25%;">' + val.egress + '</td>'
                    part += '<td>' + formatter.format((Number(val.entry) - Number(val.egress))) + '</td>'
                    part += '<td style="width: 1em;">'
                    part += '<button onClick="collapseMonth(' + month + ', ' + anio + ')" class="btn btn-success btn-sm">+</button>'
                    part += '</td>'
                    part += '</tr>'
                    part += '<tr>'
                    part += '<td id="' + anio + 'mes' + month + '" colspan="5">'
                    part += '</td>'
                    part += '</tr>'
                })
                part += '</tbody>'
                part += '</table>'

                $('#anio' + anio).html(part)
            },
            error: (err) => console.log(err)
        })
    }

    function collapseMonth(month, year) {
        $.ajax({
            type: 'GET',
            url: "{{url('admin/statistics/byweek')}}/" + month + '/year/' + year,
            success: (res) => {
                let part = '<table style="width: 100%;">'
                part += '<tbody>'
                jQuery.each(res.closuresweek, function(index, val) {
                    part += '<tr style="font-style: italic;">'
                    part += '<td style="width: 25%;">' + val.date + '</td>'
                    part += '<td style="width: 25%;">' + val.entry + '</td>'
                    part += '<td style="width: 25%;">' + val.egress + '</td>'
                    part += '<td>' + formatter.format((Number(val.entry) - Number(val.egress))) + '</td>'
                    part += '<td style="width: 1em;">'
                    part += '<button class="btn btn-success btn-sm">+</button>'
                    part += '</td>'
                    part += '</tr>'
                })
                part += '</tbody>'
                part += '</table>'

                console.log(part)

                $('#' + year + 'mes' + month).html(part)
            },
            error: (err) => console.log(err)
        })
    }

    // Create our number formatter.
    var formatter = new Intl.NumberFormat('es-EC', {
        //     style: 'currency',
        //     currency: 'USD',

        //     // These options are needed to round to whole numbers if that's what you want.
        minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
        maximumFractionDigits: 2, // (causes 2500.99 to be printed as $2,501)
    })
</script>
@stop