<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Reporte</title>
</head>

<body>
	<header id="main-header">
		<a id="logo-header" href="#">
			<img class="img-circle" src="images/logo.jpg" style="width: 100px; height:100px;  ">
		</a>
		<nav>
			<ul>
				<h4><b><i>GIMNASIO</i></b></h4>
			</ul>
		</nav>
	</header><br>
	<hr>
	<h4 align="center"><b><u>REPORTE ESTADISTICO AÑO {{ $year }}</u></b></h4>
	<h5></h5>
	@if($closuresmoth !== null && count($closuresmoth))
	<table class="table table-sm">
		<thead>
			<tr>
				<th>Año</th>
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
		<hr>
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
	}

	#main-header {
		height: 50px;
		width: 100%;
		left: 0;
		top: 0;

	}

	hr {
		border: 1px solid #57B9DF;
	}

	/*
 * Logo
 */
	#logo-header {
		float: left;
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
		padding-right: 300px;
	}

	nav ul li a {
		text-decoration: none;
		color: black;
	}


	.table {
		table-layout: fixed;
		width: 100%;
		border-collapse: collapse;
		border: 0.5px solid;
		border-color: rgba(0, 0, 0, 0.3);
	}

	th,
	td {
		padding: 2px;
		font-size: 15px;
		letter-spacing: 1px;
		text-align: center;
	}

	.margin {
		padding: 0;
	}


	thead {
		background-color: #57B9DF;
		color: #FFF;
	}


	.logo {
		padding-top: 10px;
		height: 50px;
		float: right;
		margin: 5px;
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