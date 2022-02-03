<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Reporte por meses</title>
</head>

<body>
	<header id="main-header">
		<a id="logo-header" href="#">
			<img class="img-circle" src="{{ public_path('images/logo.jpg') }}" style="width: 100px; height:100px;">
		</a>
	</header>
	<hr>
	<h4 align="center"><b><u>REPORTE ESTADISTICO {{ $year }}</u></b></h4>

	<div class="marca-de-agua">
		<img alt="Marca de agua" src="{{ public_path('images/marca.jpg') }}" />
	</div>
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
	<footer>
		<h6 align="center"> Derechos Reserados &copy; 2021</h6>
	</footer>
</body>

</html>

<style>
	body {
		margin: 0;
		padding: 0;
		font-size: 1em;
		line-height: 1.5em;
		font-family: Arial, Helvetica, sans-serif;
	}

	.marca-de-agua {
		background-repeat: no-repeat;
		background-position: center;
		width: 100%;
		height: auto;
		margin: auto;
	}

	.marca-de-agua img {
		padding: 0;
		width: 100%;
		height: auto;
		opacity: 0.4;
		position: absolute;
	}

	#main-header {
		height: 50px;
		width: 100%;
		left: 0;
		top: 0;
	}

	hr {
		border: 4px solid #232E63;
		margin-left: 0%;
		margin-right: 20%
	}

	/*
 * Logo
 */
	#logo-header {
		float: right;
		padding: 1px;
		text-decoration: none;
	}

	#logo-header .site-name {
		display: block;
	}

	#logo-header .site-desc {
		display: block;
		font-weight: 300;
		font-size: 0.8em;
		color: #999;
	}

	.logo {
		padding-top: 10px;
		height: 50px;
		float: right;
		margin: 5px;
	}

	/*
 * Navegación
 */
	nav {
		float: right;
	}

	nav ul {
		margin: 0;
		padding: 0;
		list-style: none;
		padding-right: 10px;
	}

	nav ul li a {
		text-decoration: none;
		color: black;
	}

	table {
		border: 0.1px solid #544F4F;
		font-family: Arial, Helvetica, sans-serif;
		width: 100%;
		border-spacing: 0;
	}

	th {
		border: 0.1px solid #544F4F;
		font-size: 15px;
		letter-spacing: 1px;
		text-align: center;
	}

	td {
		border: 0.1px solid #544F4F;
		font-size: 15px;
		letter-spacing: 1px;
		text-align: center;
	}

	thead {
		background-color: #544F4F;
		color: #FFF;
	}

	footer {
		color: black;
		width: 100%;
		height: 81px;
		position: absolute;
		bottom: 0;
		left: 0;
	}
</style>