<?php
	include '../php/connection.php';
	$carreras = $ObjectITSAFiles->getCarreras();
	$periodos = $ObjectITSAFiles->getPeriodos();



?>

<div class="col-md-2">
	<div class="form-group">
		<label>Numero de Control</label>
		<input class="form-control" type="text" name="filter" id="filter" onkeyup="findUsers()">
	</div>
</div>
<div class="col-md-2">
	<div class="form-group">
		<label>Carrera</label>
		<select class="form-control" name="carreras" id="carreras">
			<option value="0">Todos</option>
			<?php foreach ($carreras as $c): ?>
				<option value="<?php echo $c["idCarrera"]; ?>"><?php echo $c["vCarrera"] ?></option>
			<?php endforeach ?>
		</select>
	</div>
</div>
<div class="col-md-2">
	<div class="form-group">
		<label>Periodo</label>
		<select class="form-control" name="periodo" id="periodo">
			<option value="0">Todos</option>
			<?php foreach ($periodos as $p): ?>
				<option value="<?php echo $p["idPeriodo"]; ?>"><?php echo $p["vPeriodo"] ?></option>
			<?php endforeach ?>
		</select>
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		<button class="btn btn-primary" style="margin-top: 25px;" onclick="return findUsers()">Buscar</button>
	</div>
</div>

<div id="data"></div>
<script type="text/javascript">
		callAjax('',0,0);
		function findUsers(){
				$data 			= $("#filter").val();
				$idCarrera		= $("#carreras").val();
				$idPeriodo 		= $("#periodo").val();
				callAjax($data,$idCarrera,$idPeriodo);	
		}

		function callAjax($data,$idCarrera,$idPeriodo){

			$.ajax({
				  type: "POST",
				  url: 'helper/obtenerArchivosAsync.php',
				  data: {
				  			filter:$data,
				  			idCarrera:$idCarrera,
				  			idPeriodo:$idPeriodo
				  		},
				  beforeSend: function(){
				  			$("#data").html('<center><img width="250" height="250" style="margin-top:50px;" src="../img/loader.gif" /></center>');
				  },
				  success: function($res){
				  	$("#data").html($res);
				  }
				});
		}

</script>