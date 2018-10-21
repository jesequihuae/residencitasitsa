<!DOCTYPE html>
<html>
<head>
	<title>Cronograma de actividades</title>
	<style type="text/css">
		.red{
			background: red;
		}
		.color-head{
			background-color: #E4F1F8;
		}
		table th{
			border:1px solid;
			width: 50px;
			text-align: center;
		}
		table td{
			border:1px solid;
			width: 50px;
			text-align: center;

		}
	</style>
	<script type="text/javascript" src="../../js/jquery.js"></script>
</head>
<body>
	<table id="Cronograma">
		<tr class="color-head">
			<th rowspan="2">Actividades</th>
			<th colspan="4">1</th>
			<th colspan="4">2</th>
			<th colspan="4">3</th>
			<th colspan="4">4</th>
			<th colspan="4">5</th>
			<th colspan="4">6</th>
		</tr>
		<tr class="color-head">
			<td>1</td>
			<td>2</td>
			<td>3</td>
			<td>4</td>

			<td>6</td>
			<td>5</td>
			<td>7</td>
			<td>8</td>

			<td>9</td>
			<td>10</td>
			<td>11</td>
			<td>12</td>

			<td>13</td>
			<td>14</td>
			<td>15</td>
			<td>16</td>

			<td>17</td>
			<td>18</td>
			<td>19</td>
			<td>20</td>

			<td>22</td>
			<td>23</td>
			<td>24</td>
			<td>25</td>
		</tr>
	
	</table>
	<button id="agregar"> Agregar</button>
</body>
<script type="text/javascript">
	var $contador = 0;
	$("#agregar").click(function(e){
		localStorage.setItem("actividades",$contador);
		var semanas;
		for($j = 0;$j<24;$j++){ 	
			semanas += '<td><input type="checkbox" name="checkbox1" id="'+$contador+''+$j+'" /></td>';
		}
		$("#Cronograma").append(
								"<tr>"+
									"<td><input placeholder='Actividad'  /></td>"+semanas+
								"</tr>"
							 );
		$contador++;
	});
</script>
</html>