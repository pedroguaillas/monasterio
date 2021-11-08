@extends('adminlte::page')

@section('title', 'Administración')

@section('content_header')
<!-- <h1 class="text-center">Tiempo Real</h1> -->
@stop

@section('content')
<!-- /.row -->
<div class="row">
    <!-- /.col-md-6 -->
    <div class="col-lg-6">
        <!-- card -->
        <!-- Donut chart -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="far fa-chart-bar"></i>
                    Sede monastario <span id="general_total">1.434,00</span>
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
                <!-- <div id="donut-chart" style="height: 300px;"></div> -->
                <div class="col-md-12">
                    <div class="chart-responsive">
                        <div id="donut-chart-general" style="height: 300px;"></div>
                        <!-- <canvas id="pieChart" height="150"></canvas> -->
                    </div>
                    <!-- ./chart-responsive -->
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.card-body-->
    </div>
    <!-- /.card -->
    <!-- /.col-md-6 -->
    <div class="col-lg-6">
        <!-- card -->
        <!-- Donut chart -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="far fa-chart-bar"></i>
                    Sede Zeus <span id="members_total">1.200,00</span>
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
                <!-- <div id="donut-chart" style="height: 300px;"></div> -->
                <div class="col-md-12">
                    <div class="chart-responsive">
                        <div id="donut-chart-current" style="height: 300px;"></div>
                        <!-- <canvas id="pieChart" height="150"></canvas> -->
                    </div>
                    <!-- ./chart-responsive -->
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.card-body-->
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
    $(function() {
        /*
         * DONUT CHART
         * -----------
         */

        var data = [{
                label: 'Agosto',
                color: '#00c0ef'
            }, {
                label: 'Septiembre',
                color: '#3c8dbc'
            },
            {
                label: 'Octubre',
                color: '#0073b7'
            }
        ]

        // General -----------------------------

        data[0].data = 244
        data[1].data = 322
        data[2].data = 323

        loadChart(data, 'donut-chart-general')

        $('#general_total').text(formatter.format(444))
        $('#general_c_months').text(formatter.format(544))
        $('#general_interest').text(formatter.format(656))
        $('#general_c_year').text(formatter.format(766))

        // Current ----------------------------

        data[0].data = 546
        data[1].data = 666
        data[2].data = 627

        loadChart(data, 'donut-chart-current')

        let members_total = 755
        $('#members_total').text(formatter.format(655))
        $('#members_c_months').text(formatter.format(326))
        $('#members_interest').text(formatter.format(845))
        $('#members_c_year').text(formatter.format(622))
    })

    function loadChart(data, id) {
        $.plot('#' + id, data, {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    innerRadius: 0.5,
                    label: {
                        show: true,
                        radius: 2 / 3,
                        formatter: labelFormatter,
                        threshold: 0.1
                    }
                }
            },
            legend: {
                show: false
            }
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

    /*
     * Custom Label formatter
     * ----------------------
     */
    function labelFormatter(label, series) {
        return '<div style="font-size:12px; text-align:center; color: #fff; font-weight: 400;">' +
            Math.round(series.percent) + '%</div>'
    }
</script>
@stop