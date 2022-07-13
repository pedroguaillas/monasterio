@extends('adminlte::page')

@section ( 'plugins.flot' , true)

@section('title', 'Administración')

@section('css')
@livewireStyles
@endsection

@section('content')

@hasrole('Jefe')
<br />
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $countcustomers }}</h3>

                <p>Usuarios</p>
            </div>
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <a href="{{ route('admin.graficocliente') }}" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
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
                <i class="fa fa-clock"></i>
            </div>
            <a href="#" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ (int)$averange }}</h3>

                <p>Edades</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-bar"></i>
            </div>
            <a href="#" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ number_format($total, 2, ",", ".") }}</h3>

                <p>{{ 'Estadísticas' }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-pie"></i>
            </div>
            <a href="#" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>

<livewire:livewire-charts />

<div class="card" id="collapseExample">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fa fa-statistics"></i>
            Reporte Estadístico
        </h3>

        <div class="card-tools">
            <a target="_blank" href="{{ route('reportegeneral') }}" class="btn btn-white btn-sm">
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
                <tr data-widget="expandable-table" aria-expanded="true">
                    <td style="width: 25%;">{{ $item->year }}</td>
                    <td style="width: 25%;">{{ number_format($item->entry, 2, ',', '.') }}</td>
                    <td style="width: 25%;">{{ number_format($item->egress, 2, ',', '.') }}</td>
                    <td>{{ number_format($item->entry - $item->egress, 2, ',', '.') }}</td>
                    <td style="text-align: right;">
                        <div class="btn-group" role="group">
                            <button onClick="collapseAnio({{$item->year}})" class="btn btn-success btn-sm mr-1">+</button>

                            <a target="_blank" href="{{ route('reportepormeses', $item->year) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="far fa-file-pdf"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <tr class="expandable-body">
                    <td id="{{ 'anio' .$item->year }}" colspan="5">
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
@endhasrole

@stop

@section('js')
@livewireScripts
@livewireChartsScripts
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    let moths = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]

    function collapseAnio(anio) {
        $.ajax({
            type: 'GET',
            url: "{{url('admin/statistics/bymonth')}}/" + anio,
            success: (res) => {
                let part = '<div class="p-0">'
                part += '<table style="width: 100%;" class="table table-hover">'
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
                    part += '<tr class="expandable-body">'
                    part += '<td id="' + anio + 'mes' + month + '" colspan="5">'
                    part += '</td>'
                    part += '</tr>'
                })
                part += '</tbody>'
                part += '</table>'
                part += '</div>'

                $('#anio' + anio).html(part)
            },
            error: (err) => console.log(err)
        })
    }

    function collapseMonth(month, year) {
        $.ajax({
            type: 'GET',
            url: "{{url('admin/statistics/byweek')}}/" + (month + 1) + '/year/' + year,
            success: (res) => {
                let part = '<table style="width: 100%;">'
                part += '<tbody>'
                jQuery.each(res.closuresweek, function(index, val) {
                    part += '<tr style="font-style: italic;">'
                    part += '<td style="width: 25%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + val.date + '</td>'
                    part += '<td style="width: 25%;">' + val.entry + '</td>'
                    part += '<td style="width: 25%;">' + val.egress + '</td>'
                    part += '<td>' + formatter.format((Number(val.entry) - Number(val.egress))) + '</td>'
                    part += '<td></td>'
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