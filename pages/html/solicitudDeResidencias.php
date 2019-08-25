<div role="tabpanel" class="tab-pane <?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 1 ? 'active' : '') ?>" id="registrarProyecto">
  <div class="design-process-content">
        <div class="row">
    		<div class="col-md-12" style="padding-top:10px;">
    			<div class="tabbable-panel">
    				<div class="tabbable-line">
    					<ul class="nav nav-tabs ">
    						<li class="active">
    							<a href="#registroProtecto" data-toggle="tab">
    							Registro Proyecto </a>
    						</li>
    						<li>
    							<a href="#informacionAlumno" data-toggle="tab">
    							Informacion alumno </a>
    						</li>
                <li>
    							<a href="#estructuraAnteproyecto" data-toggle="tab">
    							Estructura del anteproyecto </a>
    						</li>
    						<li>
    							<a href="#cronograma" data-toggle="tab">
    							Cronograma </a>
    						</li>
    					</ul>
    					<div class="tab-content">
    						<div class="tab-pane active" id="registroProtecto">
                  <!--REGISTRO DE PROYECTO-->
                  <div>
                    <h3 class="semi-bold">Registra tu proyecto</h3>
                    <p>Bienvenido al sistema de Residencias del Instituto Tecnológico Superior de Apatzingán</p>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-lg-2 col-form-label">Proyecto:</label>
                        <div class="col-lg-8">
                          <select class="form-control selectpicker" data-live-search="true" name="idProyecto" id="idProyecto" required>
                            <?php foreach ($ObjectITSA->getAllProyectos() as $r) { ?>
                                <option value="<?php echo $r["idBancoProyecto"]; ?>"><?php echo $r["vNombreProyecto"]; ?></option>
                            <?php  } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-lg-2 col-form-label">Periodo:</label>
                        <div class="col-lg-8">
                          <select class="form-control"  name="idPeriodo" id="idPeriodo" required>
                            <?php foreach ($ObjectITSA->getAllPeriodos() as $r) { ?>
                                <option value="<?php echo $r["idPeriodo"]; ?>"><?php echo $r["vPeriodo"]; ?></option>
                            <?php  } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-lg-2 col-form-label" >Opción:</label>
                        <div class="col-lg-8">
                          <select class="form-control" data-live-search="true"  id="idOpcion" name="idOpcion" required>
                            <?php foreach ($ObjectITSA->getAllOpciones() as $r) { ?>
                                <option value="<?php echo $r["idOpcion"]; ?>"><?php echo $r["vOpcion"]; ?></option>
                            <?php  } ?>
                          </select>
                        </div>
                      </div>
                       <div class="form-group row">
                        <label for="inputEmail3" class="col-lg-2 col-form-label"   >Giro:</label>
                        <div class="col-lg-8">
                          <select class="form-control" name="idGiro" id="idGiro" required>
                            <?php foreach ($ObjectITSA->getAllGiros() as $r) { ?>
                                <option value="<?php echo $r["idGiro"]; ?>"><?php echo $r["vGiro"]; ?></option>
                            <?php  } ?>
                          </select>
                        </div>
                      </div>
                       <div class="form-group row">
                        <label for="inputEmail3" class="col-lg-2 col-form-label"  >Sector:</label>
                        <div class="col-lg-8">
                          <select class="form-control" name="idSector" id="idSector" required>
                            <?php foreach ($ObjectITSA->getAllSectores() as $r) { ?>
                                <option value="<?php echo $r["idSector"]; ?>"><?php echo $r["vSector"]; ?></option>
                            <?php  } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                       <label for="asesorInterno" class="col-lg-2 col-form-label" >ASESOR(A) INTERNO(A):</label>
                       <div class="col-lg-8">
                         <input type="text" name="asesorInterno" id="asesorInterno" class="form-control" />
                       </div>
                     </div>
                     <div class="form-group row">
                      <label for="inputEmail3" class="col-lg-2 col-form-label" >ASESOR(A) EXTERNO(A):</label>
                      <div class="col-lg-8">
                        <input type="text" name="asesorExterno" id="asesorExterno" class="form-control" />
                      </div>
                    </div>
                     <div class="form-group row">
                      <label for="inputEmail3" class="col-lg-2 col-form-label" >PERSONA QUE FIRMARÁ DOCUMENTOS OFICIALES DE LA RESIDENCIA:</label>
                      <div class="col-lg-8">
                        <input type="text" name="personasQueFirmaran" id="personasQueFirmaran" class="form-control" />
                      </div>
                    </div>
                  </div>
                  <!--  FIN DEL REGISTRO DE PROYECTO-->
    						</div>
    						<div class="tab-pane" id="informacionAlumno">
                  <!-- INFORMACION DEL ALUMNO-->
                  <div>
                      <h3 class="semi-bold">Información del alumno</h3>
                      <div class="form-group row">
                       <label for="inputEmail3" class="col-lg-2 col-form-label" >Nombre:</label>
                       <div class="col-lg-8">
                         <input type="text" name="nombreAlumno" id="nombreAlumno" value="<?php echo $_SESSION['nombre']; ?>" class="form-control" />
                       </div>
                     </div>
                     <div class="form-group row">
                      <label for="inputEmail3" class="col-lg-2 col-form-label" >Numero de control:</label>
                      <div class="col-lg-8">
                        <input type="text" name="numeroDeControl" id="numeroDeControl" value="<?php echo $_SESSION['numeroControl']; ?>" class="form-control" />
                      </div>
                    </div>
                    <div class="form-group row">
                     <label for="inputEmail3" class="col-lg-2 col-form-label" >Domicilio:</label>
                     <div class="col-lg-8">
                       <input type="text" name="domicilioAlumno" id="domicilioAlumno" class="form-control" />
                     </div>
                    </div>
                    <div class="form-group row">
                     <label for="inputEmail3" class="col-lg-2 col-form-label" >Colonia:</label>
                     <div class="col-lg-8">
                       <input type="text" name="coloniaAlumno" id="coloniaAlumno" class="form-control" />
                     </div>
                    </div>
                    <div class="form-group row">
                     <label for="inputEmail3" class="col-lg-2 col-form-label" >Ciudad y estado:</label>
                     <div class="col-lg-8">
                       <input type="text" name="ciudadEstado" id="ciudadEstado" class="form-control" />
                     </div>
                    </div>
                    <div class="form-group row">
                     <label for="inputEmail3" class="col-lg-2 col-form-label" >CP:</label>
                     <div class="col-lg-8">
                       <input type="text" name="cp" id="cp" class="form-control" />
                     </div>
                    </div>
                    <div class="form-group row">
                     <label for="inputEmail3" class="col-lg-2 col-form-label" >Telefono:</label>
                     <div class="col-lg-8">
                       <input type="text" name="telefono" id="telefono" class="form-control" />
                     </div>
                    </div>
                    <div class="form-group row">
                     <label for="inputEmail3"  class="col-lg-2 col-form-label" >Email:</label>
                     <div class="col-lg-8">
                       <input type="email" id="correo" name="correo" class="form-control" />
                     </div>
                    </div>
                    <div class="form-group row">
                     <label for="inputEmail3" class="col-lg-2 col-form-label" >Seguro social:</label>
                     <div class="col-lg-4">
                       <select name="idSeguroSocial" id="idSeguroSocial" class="form-control">
                         <option value="1">IMSS</option>
                         <option value="2">ISSTE</option>
                         <option value="3">OTROS</option>
                       </select>
                     </div>
                     <div class="col-lg-4">
                       <input type="text" name="numeroSeguro" id="numeroSeguro" class="form-control"  placeholder="numeroSeguro" />
                     </div>
                    </div>
                  </div>
                  <!-- FIN INFORMACION DEL ALUMNO-->
    						</div>
    						<div class="tab-pane" id="estructuraAnteproyecto">
                  <!-- ESTRUCTURA DEL PROYECTO -->
                  <div>
                    <h3 class="semi-bold">Estructura del anteproyecto</h3>
                    <div class="form-group row">
                     <label for="inputEmail3" class="col-lg-2 col-form-label" >Título del anteproyecto:</label>
                     <div class="col-lg-8">
                      <input class="form-control" type="text" id="tituloAnteproyecto" name="tituloAnteproyecto" placeholder="Título del anteproyecto"></input>
                     </div>
                    </div>
                    <div class="form-group row">
                     <label for="inputEmail3" class="col-lg-2 col-form-label" >Objectivos General y Específicos:</label>
                     <div class="col-lg-4">
                      <textarea class="form-control" type="text" id="objectivoGeneral" name="objectivoGeneral" placeholder="Objectivo general"></textarea>
                     </div>
                     <div class="col-lg-4">
                      <textarea class="form-control" type="text" id="objectivoEspecifico" name="objectivoEspecifico" placeholder="Objectivo especifico"></textarea>
                     </div>
                    </div>
                    <div class="form-group row">
                     <label for="inputEmail3" class="col-lg-2 col-form-label" >Alcances y delimitaciónes:</label>
                     <div class="col-lg-8">
                      <textarea class="form-control" type="text" id="alcancesDelimitaciones" name="alcancesDelimitaciones" placeholder="Alcances o delimitaciónes"></textarea>
                     </div>
                    </div>
                    <div class="form-group row">
                     <label for="inputEmail3" class="col-lg-2 col-form-label" >Descripción de las actividades:</label>
                     <div class="col-lg-8">
                      <textarea class="form-control" type="text" id="descripcionActividades" name="descripcionActividades" placeholder="Descripcion de las actividades"></textarea>
                     </div>
                    </div>
                    <div class="form-group row">
                     <label for="inputEmail3" class="col-lg-2 col-form-label" >Area o lugar de implementación:</label>
                     <div class="col-lg-8">
                      <textarea class="form-control" type="text" id="areaOLugarImplementacion" name="areaOLugarImplementacion" placeholder="Lugar de la implementación"></textarea>
                     </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail3" class="col-lg-2 col-form-label">Constancia:</label>
                      <div class="col-lg-10">
                        <input type="file" name="Constancia" required>
                      </div>
                    </div>
                  </div>
                  <!-- FIN DE ESTRUCTURA DEL PROYECTO -->
    						</div>
                <div class="tab-pane" id="cronograma">
                  <div>
                    <h3 class="semi-bold">Cronograma</h3>
                    <?php
                      if($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 1)
                      {
                          $_SESSION["idTipoDocumento"] = 3;
                          require "cronograma/cronogramaSeg.php";
                      }
                     ?>
                  </div>
    						</div>
    					</div>
    				</div>
    			</div>

    			<div class="tabbable-panel">
    				<div class="tabbable-line tabs-below">
    					<div class="tab-content">
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    <div>
      <button type="submit" name="registrarProyecto" id="guardarSolicitud" class="btn btn-lg btn-success" onclick="return validacionGuardar()">Guardar</button>
      <button class="btn btn-lg btn-warning">Limpiar</button>
      <br><br>
    </div>
    <div class="form-group" style="padding:10px;">
      <div id="salida">
      </div>
    </div>
   </div>
</div>
