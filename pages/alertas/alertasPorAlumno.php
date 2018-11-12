<?php
	include "../php/helper.class.php";
	$helper = new helper();
?>

<div class="row">
	
	<div class="col-md-6 col-md-offset-2">
		<div class="panel panel-default">
		  <div class="panel-heading">
		    <h3 class="panel-title">Administración de alertas</h3>
		  </div>
		  <div class="panel-body">
		  		<div class="col-md-12">
		  			<div class="form-group">
		  				<label>Carrera</label>
		  				<select class="form-control" id="carreras">
		  					<option value="0">Selecciona una carrera</option>
		  					<?php foreach ($helper->getCarreras() as $k) { ?>
		  						<option value="<?php echo $k["id"];?>"><?php echo $k["descripcion"]; ?></option>
		  					<?php } ?>
		  				</select>
		  			</div>
		  		</div>
			    <div class="col-md-12">
					<div class="content col-md-6"> 
						<div class="form-group">
							<label>Selecciona un alumno</label>	
							<select class="form-control col-md-2" id="alumnos">			
								<?php foreach ($helper->obtenerAlumnosPorCarrera(1) as $k) { ?>
									<option value="<?php echo $k["id"];?>"><?php echo $k["descripcion"]; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Mensaje</label>
							<textarea class="form-control" id="mensaje">
								
							</textarea>
						</div>
					</div>	
				</div>
				<center>
					<button class="btn btn-primary" onclick="return guardar()" id="guardar">
						Guardar <i class="fa fa-save"></i>
					</button>
					<button class="btn btn-danger">
						Cancelar <i class="fa fa-save"></i>
					</button>
				</center>
			</div>
	</div>
	</div>
</div>
<script type="text/javascript">
	$("#carreras").change(function(e){
		idCarr = this.value;
		$.ajax({
			  type: "POST",
			  url: '../php/helper.class.php',
			  data: {
			  			idCarrera:idCarr,
			  			operacion:1
			  		},
			  beforeSend: function(){
			  			
			  },
			  success: function(res){
			  	$("#alumnos").html(res);
			  	 //alertify.success('custom message.');
			  	 /*alertify.prompt(
			  	 		'Prompt Title',
			  	 		'Prompt Message',
			  	 		'Prompt Value'
               			,
               			function(evt, value) 
               			{ 
               				alertify.success('You entered: ' + value);
               			}
               			,function()
               			{ 
               				alertify.error('Cancel'); 
               			}
               		);*/
               		//alertify.set('notifier','position', 'top-center');
               		//alertify.success('Guardado con exito');
			 	 }
			});
	});
	function guardar(){
		var idAlumno = $("#alumnos").val();
		var mensaje = $("#mensaje").val();
		alertify.set('notifier','position', 'top-center');
		alertify.warning("Estamos procesando la información", "", 0);
		$("#guardar").prop("disabled",true);
		//alertify.set('notifier','position', 'top-center');
		//var notification = alertify.warning('Estamos procesando la información', 'success', 5, function(){  console.log('dismissed'); });
		//notification.dismiss();

		return null;
	}

		
</script>