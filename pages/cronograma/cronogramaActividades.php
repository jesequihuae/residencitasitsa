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
		.top{
			margin-top: 10px;
		}
	</style>

</head>
<body>

	<div class="row">
		<div class="col-md-2">
			<div class="form-group">
				<label>Selecciona un documento</label>
				<select class="form-control" id="SDocumento" onchange="precargarCronograma(this)" name="documentos">

				</select>
			</div>
		</div>
	</div>
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
			<?php
				for($i = 0;$i<24;$i++){
					echo "<td id=\"semana$i\">".($i+1)."</td>";
				}
			?>
		</tr>


	</table>
	<button id="agregar" class="btn btn-info top"> Agregar Actividad</button>
	<button id="guardar" class="btn btn-primary top" onclick="return guardar()"> Guardar cronograma</button>
	<button id="cancelar" class="btn btn-danger top" onclick="cancelar()"> Cancelar</button>
	<div id="salida">

	</div>
</body>
<script type="text/javascript">
	var contador = 0;
	cargarSelect();

	function mostrarMensaje(mensaje,tipoMensaje){
		alertify.set('notifier','position', 'top-center');
		if(tipoMensaje == 1){
				alertify.notify(mensaje, 'success', 5, function(){  console.log('dismissed'); });
		}else if(tipoMensaje == 2){
			alertify.notify(mensaje, 'error', 5, function(){  console.log('dismissed'); });
		}

	}
	function cancelar(){
		contador = 0;
		$(".rowsAdded").remove();
		mostrarMensaje("Cancelador",1);
	}
	function precargarCronograma(e){
		$.ajax({
			url:'../php/cronograma.php',
			type:'POST',
			dataType: "json",
			data:
						{
							"operacion":"3",
							"idDocumento":e.value
						},
			beforeSend: function(e){

			},
			success: function(json){
				$(".rowsAdded").remove();
				var nombreActual = "",nombreAnterior;
				contador = 0;
				for(var i in json){
					nombreActual = json[i]["vNombre"];
					var semanas  = "";
					if(nombreActual != nombreAnterior){
							for(j = 0;j<24;j++){

							//	if(json[i]["i"] == i && json[i]["j"] == j){
								//	semanas += '<td><input type="checkbox" checked name="checkbox1" id="'+contador+''+j+'" /></td>';
								//}else{
									semanas += '<td><input type="checkbox" name="checkbox1" id="'+contador+''+j+'" /></td>';
								//}
							}
							$("#Cronograma").append(
													"<tr class='rowsAdded'>"+
														"<td><input placeholder='Actividad' value='"+json[i]["vNombre"]+"' id='actividad"+contador+"'  /></td>"+semanas+
													"</tr>"
												);
							contador++;
					}
					nombreAnterior = nombreActual;
				}


				for(var i in json){
						$("#"+json[i]["i"]+json[i]["j"]).prop("checked",true);
				}

				console.log(json);
			},
			error: function(e){
				console.log(e);
			}
		});
	}

	function cargarSelect(){
		$.ajax({
			url:'../php/cronograma.php',
			type:'POST',
			data:{"operacion":"2"},
			beforeSend: function(e){

			},
			success: function(e){
				$("#SDocumento").append(e);
			},
			error: function(e){
				$("#salida").html(e);
			}
		});
	}

	$("#agregar").click(function(e){
		var semanas;
		for($j = 0;$j<24;$j++){
			semanas += '<td><input type="checkbox" name="checkbox1" id="'+contador+''+$j+'" /></td>';
		}
		$("#Cronograma").append(
								"<tr class='rowsAdded'>"+
									"<td><input placeholder='Actividad' id='actividad"+contador+"'  /></td>"+semanas+
								"</tr>"
							 );
		contador++;
	});
	function guardar(){
		var cronograma = "[";
		var idTipoDeDocumento = $("#SDocumento").val();
		var rowCount = 0;
		for(i = 0;i < contador;i++){
			cronograma += "{\"actividad"+i+"\":\""+$("#actividad"+i).val()+"\",\"idTipoDeDocumento\":\""+idTipoDeDocumento+"\",\"i"+i+"\":"+i+",";
			for(j = 0; j<24;j++){
					cronograma += "\"valor"+i+""+j+"\":\""+$("#"+i+""+j).is(":checked")+"\",\"iSemana"+i+""+j+"\":\""+$("#semana"+j).text().trim()+"\",\"j"+i+""+j+"\":"+j+",";
			}
			//QUITAMOS LA ULTIMA COMA PARA QUE NO TRUENE AL ENVIAR AL SERVIDOR
			cronograma = cronograma.slice(0,-1);
			cronograma += "},";
		}
		//QUITAMOS LA ULTIMA COMA PARA QUE NO TRUENE AL ENVIAR AL SERVIDOR
		cronograma = cronograma.slice(0,-1);
		cronograma+=']';

		console.log(cronograma);
		if(contador > 0){
				$.ajax({
					url: '../php/cronograma.php',
					type:'POST',
					data:
							{
								"cronograma":cronograma,
								"operacion":1,
								"size":24,
								"idTipoDeDocumento":idTipoDeDocumento
							},
					beforeSend: function(e){

					},
					success: function(e){
						$("#salida").html(e);
						mostrarMensaje("Guardado con exito",1);
					},
					error: function(e){
						$("#salida").html(e);
						mostrarMensaje("Algo salio mal...",2);
					}
				});
			}else{
				mostrarMensaje("No hay ninguna actividad por guardar...",2);
			}
			return false;
	}
</script>
</html>
