<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="utf-8"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Residencia</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="../css/metisMenu.min.css" rel="stylesheet">
    <!-- Timeline CSS -->
    <link href="../css/timeline.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../css/startmin.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="../css/morris.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/jquery.datetimepicker.css" type="text/css">
    <link rel="stylesheet" href="../css/bootstrap-select.min.css">
    <link rel="stylesheet" href="../css/style.css">

    <!-- ALERTIFY JS-->
    <link  href="../css/alertify.min.css" rel="stylesheet" type="text/css">

    <!-- Default theme -->
    <link rel="stylesheet" href="../css/themes/default.min.css"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include('../modules/navbar.php'); ?>

    <!-- Page Content -->
    <div id="page-wrapper">
        <table id="Cronograma" style="margin-top:30px;">
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
    </div>  

</div>

<!-- jQuery -->
<script src="../js/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="../js/metisMenu.min.js"></script>
<!-- Custom Theme JavaScript -->
<script src="../js/startmin.js"></script>
<script src="../js/jquery.datetimepicker.full.min.js"></script>
<script src="../js/index.js"></script>
<script src="../js/bootstrap-select.js"></script>
<script src="../js/alertify.js"></script>
</body>
</html>

<script type="text/javascript">
    var contador = 0;
    /**
     * METODO QUE MUESTRA MENSAJES EN PANTALLA CON ALERTIFY
     */
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
    /**
     * METODO DONDE PRECARGAMOS EL CRONOGRAMA SI ES QUE EXISTE UNO
     * EN LA BASE DE DATOS
     */
    precargarCronograma();
	function precargarCronograma(){
		$.ajax({
			url:'../php/cronograma.php',
			type:'POST',
			dataType: "json",
			data:
						{
							"operacion":"3",
							"idDocumento":3
						},
			beforeSend: function(e){

			},
			success: function(json){
                
				$(".rowsAdded").remove();
				var nombreActual = "",nombreAnterior;
				contador = 0;
				for(var i in json){
                    console.log(i);
					nombreActual = json[i]["vNombre"];
                    var semanas  = "";
                    console.log(nombreActual);
					if(nombreActual != nombreAnterior){
							for(j = 0;j<24;j++){					
								semanas += '<td><input type="checkbox" name="checkbox1" id="'+contador+''+j+'" /></td>';
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


			},
			error: function(e){
				console.log(e);
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
		var idTipoDeDocumento = 3;
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