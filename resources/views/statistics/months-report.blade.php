@extends('layouts.report-pdf')

@section('title-header', "Reporte por meses")

@section('title', "REPORTE ESTADISTICO $year")

@section('content')

@if($closuresmoth !== null && count($closuresmoth))
<table class="table table-sm">
	<thead>
		<tr>
			<th>Mes</th>
			<th>Ingresos</th>
			<th>Egresos</th>
			<th>Total</th>
		</tr>
	</thead>
	@php
	$sum_entry=0;
	$sum_egress=0;
	$months = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	@endphp
	<tbody>
		@foreach($closuresmoth as $item)
		<tr>
			<td>{{ $months[$item->month -1] }}</td>
			<td>{{ number_format($item->entry, 2, ',', '.') }}</td>
			<td>{{ number_format($item->egress, 2, ',', '.') }}</td>
			<td>{{ number_format($item->entry - $item->egress, 2, ',', '.') }}</td>
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
		</tr>
	</tfoot>
</table>
@endif

@endsection