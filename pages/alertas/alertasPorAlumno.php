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
		  				<select class="form-control">
		  					
		  				</select>
		  			</div>
		  		</div>
			    <div class="col-md-12">
					<div class="content col-md-6"> 
						<div class="form-group">
							<label>Selecciona un alumno</label>	
							<select class="form-control col-md-2">				
								<?php foreach ($helper->obtenerAlumnosPorCarrera(1) as $k) { ?>
									<option value="<?php echo $k["id"];?>"><?php echo $k["descripcion"] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Mensaje</label>
							<textarea class="form-control">
								
							</textarea>
						</div>
					</div>	
				</div>
				<center>
					<button class="btn btn-primary">
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