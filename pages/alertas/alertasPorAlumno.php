<?php
	include "../php/helper.class.php";
	$helper = new helper();
?>

<section style="background:#efefe9;">
        <div class="container">
            <div class="row">
                <div class="board">
                    <!-- <h2>Welcome to IGHALO!<sup>™</sup></h2>-->
                    <div class="board-inner">
                    <ul class="nav nav-tabs" id="myTab">
                    <div class="liner"></div>
                     <li class="active">
		                     <a href="#home" data-toggle="tab" title="welcome">
			                      <span class="round-tabs one">
			                              <i class="glyphicon glyphicon-home"></i>
			                      </span>
		                  		</a>
										 </li>
                     <li>
											 <a href="#settings" data-toggle="tab" title="blah blah">
                         <span class="round-tabs four">
                              <i class="glyphicon glyphicon-comment"></i>
                         </span>
                     		</a>
									 		</li>

                     <li><a href="#doner" data-toggle="tab" title="completed">
                         <span class="round-tabs five">
                              <i class="glyphicon glyphicon-ok"></i>
                         </span> </a>
                     </li>

                     </ul></div>

                     <div class="tab-content">
                      <div class="tab-pane fade in active" id="home">
												<!--FORMULARIO DE MENSAJES-->
												<div class="row" id="divContent">

													<div class="col-md-10 col-md-offset-1">
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
												<div class="row" id="divLoad">
													<center>
														<div id="load">

														</div>
													</center>
												</div>
												<!--FIN DEL FORMULARIO DE MENSAJES-->
                      </div>
                      <div class="tab-pane fade" id="settings">
                        <table class="table table-bordered">
													<tr>
														<th class="center">id mensaje</th>
														<th class="center">mensaje</th>
														<th class="center">activo</th>
													</tr>
													<tr id="bodyTable">

													<tr>
												</table>
                      </div>
                      <div class="tab-pane fade" id="doner">
                          <h3 class="head text-center">Bootsnipp goodies</h3>
                          <p class="narrow text-center">
                              Lorem ipsum dolor sit amet, his ea mollis fabellas principes. Quo mazim facilis tincidunt ut, utinam saperet facilisi an vim.
                          </p>
                          <p class="text-center">
                    					<a href="" class="btn btn-success btn-outline-rounded green"> start using bootsnipp <span style="margin-left:10px;" class="glyphicon glyphicon-send"></span></a>
                					</p>
                      </div>

							<div class="clearfix"></div>
							</div>

</div>
</div>
</div>
</section>

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
		if(idAlumno == 0 || mensaje.trim() == ""){
			alertify.error("Campos vacios");
			return;
		}


		$("#guardar").prop("disabled",true);
		$.ajax({
			type:"POST",
			 url: '../php/helper.class.php',
			 data:{
			 	"idAlumno":idAlumno,
			 	"mensaje":mensaje,
				"bActive":1,
			 	operacion:2
			 },
			 beforeSend: function(e){
			 	$("#divContent").addClass("hide");
			 	$("#divLoad").addClass("show");
			 	$("#load").html("<img src='../img/loader.gif' />");
			 },
			 success: function(e){
				$("#divContent").removeClass("hide");
 			 	$("#divLoad").removeClass("show");

				$("#divContent").addClass("show");
 			 	$("#divLoad").addClass("hide");
					if(e == 1){
						 alertify.success("Guardado con exito", "", 0);
					}else{
						 alertify.error(e, "", 0);
					}
				$("#guardar").prop("disabled",false);
			},
			error: function(e){
					$("#guardar").prop("disabled",false);
			}
		});
		//alertify.set('notifier','position', 'top-center');
		//var notification = alertify.warning('Estamos procesando la información', 'success', 5, function(){  console.log('dismissed'); });
		//notification.dismiss();

		return null;
	}


</script>
