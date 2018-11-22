<?php
	include "../php/helper.class.php";
	$helper = new helper();
?>

<section style="background:#efefe9; height:800px;">
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

                    <!-- <li><a href="#doner" data-toggle="tab" title="completed">
                         <span class="round-tabs five">
                              <i class="glyphicon glyphicon-ok"></i>
                         </span> </a>
                     </li>
-->
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
														  		<div class="col-md-6">
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
																	<div class="col-md-6">
														  			<div class="form-group">
														  				<label>Titulo</label>
														  				<input type="text" id="titulo" class="form-control" />
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
																	<input type="hidden" id="idMensaje" value="0"/>
																	<button class="btn btn-primary" onclick="return guardar()" id="guardar">
																		Guardar <i class="fa fa-save"></i>
																	</button>
																	<button class="btn btn-danger" onclick="limpiar()">
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
												<div class="col-md-6 col-md-offset-6">
													<div class="col-md-6">
														<div class="form-group">
															<label>Alumno</label>
															<select class="form-control" id="idAlumnoFilter" onchange="changeAlumno(this)">
																<option value="0">Selecciona...</option>
																<?php foreach ($helper->obtenerAlumnos() as $k) { ?>
																	<option value="<?php echo $k["id"];?>"><?php echo $k["descripcion"]; ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Activo</label>
															<select id="activo" class="form-control" onchange="changeItem(this)">
																<option value="-1">Todos</option>
																<option value="1">Si</option>
																<option value="0">No</option>
															</select>
														</div>
													</div>
												</div>
                        <table class="table table-hover" id="tablaMensajes">
													<tr>
														<th class="center">id mensaje</th>
														<th class="center">mensaje</th>
														<th class="center">activo</th>
													</tr>
												</table>
												<div id="paginador">

												</div>
                      </div>

                      <!--<div class="tab-pane fade" id="doner">
                          <h3 class="head text-center">Bootsnipp goodies</h3>
                          <p class="narrow text-center">
                              Lorem ipsum dolor sit amet, his ea mollis fabellas principes. Quo mazim facilis tincidunt ut, utinam saperet facilisi an vim.
                          </p>
                          <p class="text-center">
                    					<a href="" class="btn btn-success btn-outline-rounded green"> start using bootsnipp <span style="margin-left:10px;" class="glyphicon glyphicon-send"></span></a>
                					</p>
                      </div>-->

							<div class="clearfix"></div>
							</div>

</div>
</div>
</div>
</section>

<script type="text/javascript">
	cargarAlumnos(0,7,-1,0);
	function limpiar(){
		$("#mensaje").val("");
		$("#titulo").val("");
		$("#alumnos").val(0);
		$("#carreras").val(0);
		$("#idMensaje").val(0);
	}
	function changeItem(e){
		var idAlumno = $("#idAlumnoFilter").val();
		cargarAlumnos(0,7,e.value,idAlumno);
	}
	function changeAlumno(e){
		var activo = $("#activo").val();
		cargarAlumnos(0,7,activo,e.value);
	}
	function editar(id){
		alertify.confirm('ITSA', 'Estas seguro que deseas editar?',
											function(){
												$.ajax({
												 type:"POST",
												 url:"../php/helper.class.php",
												 data:{
													 "operacion":5,
													 "idMensaje":id
												 },
												 beforeSend: function(){

												 },
												 success: function(e){
													 var json = JSON.parse(e);

													 $('.nav-tabs a[href="#home"]').tab('show');
													 $("#idMensaje").val(json[0].idMensaje);
													 $("#mensaje").val(json[0].vMensaje);
													 $("#carreras").val(json[0].idCarrera);
													 $("#titulo").val(json[0].vTitulo);
													 cargarComboAlumnos(json[0].idCarrera,json[0].idAlumno);

												 },
												 error: function(e){

												 }
											 });
										 },
										 function(){
												alertify.error('Cancel');
										});
	}
	function DesactivarActivar(id,bit){
		var mensaje = "";

		if(mensaje == 0){
			mensaje = "Estas seguro que deseas desactivarlo?";
		}else{
			mensaje = "Estas seguro que deseas activarlo?";
		}
		alertify.confirm('ITSA', mensaje,
											function(){
												$.ajax({
												 type:"POST",
												 url:"../php/helper.class.php",
												 data:{
													 "operacion":4,
													 "idMensaje":id,
													 "activo":bit
												 },
												 beforeSend: function(){

												 },
												 success: function(e){

													 if(e == 1){
														 	var itemSelected = $("#activo").val();
															var idAlumno = $("#idAlumnoFilter").val();
													 		cargarAlumnos(0,7,itemSelected,idAlumno);
															if(bit == 1){
																alertify.success('Activado con exito');
															}else{
																alertify.success('Desactivado con exito');
															}

												 	 }else{
														 alertify.error('Ocurrio un error inesperado');
													 }
												 },
												 error: function(e){

												 }
											 });
										 },
										 function(){
											  alertify.error('Cancel');
										});

	}

	function cargarAlumnos(inicio,fin,filtroActivo,filtroIdAlumno){
		$.ajax({
			type:"POST",
			url:"../php/helper.class.php",
			data:{
				"operacion":3,
				"inicio":inicio,
				"fin":fin,
				"activo":filtroActivo,
				"idAlumno":filtroIdAlumno
			},
			beforeSend: function(){

			},
			success: function(e){
				var res = JSON.parse(e);
				$("#tablaMensajes").html(res.mensajes);
				$("#paginador").html(res.paginador);
			},
			error: function(e){
			}
		});
	}

	$("#carreras").change(function(e){
		cargarComboAlumnos(this.value,null);
	});

	function cargarComboAlumnos(idCarr,idAlumno){

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
					if(idAlumno != null){
						$("#alumnos").val(idAlumno);
					}
			 	 }
			});
	}
	function guardar(){
		var idAlumno = $("#alumnos").val();
		var mensaje = $("#mensaje").val().trim();
		var titulo = $("#titulo").val().trim();
		var idMensaje = $("#idMensaje").val();
		alertify.set('notifier','position', 'top-center');
		if(idAlumno == 0 || mensaje.trim() == "" || titulo.trim() == ""){
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
				"titulo":titulo,
				"idMensaje":idMensaje,
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
							alertify.notify("Guardado con exito", "success",5);
							 limpiar();
							var itemSelected = $("#activo").val();
							var idAlumno = $("#idAlumnoFilter").val();
							 cargarAlumnos(0,7,itemSelected,idAlumno);
						}else{
							 alertify.error(e, "", 0);
						}
						$("#alumnos").val(0);
						$("#mensaje").val("");
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
