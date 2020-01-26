
<style>
  .panel-heading a:after {
    font-family:'Glyphicons Halflings';
    content:"\e114";
    float: right;
    color: grey;
}
.panel-heading a.collapsed:after {
    content:"\e080";
}
</style>

  <div class="panel-group" id="accordion">
      <div class="panel panel-default" id="panel1">
            <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-target="#collapseOne" 
                    href="#collapseOne">
                    Registro de proyecto
                  </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
                <div class="panel-body">
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
                          <label for="inputEmail3" class="col-lg-2 col-form-label" >Asesor Externo:</label>
                          <div class="col-lg-8">
                            <select class="form-control" data-live-search="true"  id="idAsesorExterno" name="idAsesorExterno" required>
                              <option value="0">Selecciona</option>
                              <?php foreach ($ObjectITSA->getAsesoresExternos() as $r) { ?>
                                  <option value="<?php echo $r["idAsesor"]; ?>"><?php echo $r["vUsuario"]; ?></option>
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
                        <!-- Add by Memo 24 Ene 2020 Se añade si el proyecto genera un impacto ambiental-->
                        <div class="form-group row">
                          <label for="inputEmail3" class="col-lg-2 col-form-label">Impacto Ambiental:</label>
                            <div class="col-lg-8">
                                <select class="form-control" name="bImpacto" id="bImpacto" required>
                                  <option value="0">NO</option>
                                  <option value="1">SI</option>
                                </select>
                            </div>  
                        </div>
                        <div class="form-group row">
                        <label for="asesorInterno" class="col-lg-2 col-form-label" >ASESOR(A) INTERNO(A):</label>
                        <div class="col-lg-8">
                          <input type="text" name="asesorInterno" id="asesorInterno" class="form-control" />
                          <div class="col-lg-8">
                          </div>
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
            </div>
      </div>      
      <div class="panel panel-default" id="panel2">
            <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-target="#collapseTwo" 
                    href="#collapseTwo">
                    Información del alumno
                  </a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse in">
              <div class="panel-body">
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
              </div>
            </div>
      </div>  
      <div class="panel panel-default" id="panel3">
            <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-target="#collapseThree" 
                    href="#collapseThree">
                    Estructura del anteproyecto
                  </a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse in">
              <div class="panel-body">
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
              </div>
            </div>
      </div>  
  </div>
  
  <button type="submit" name="registrarProyecto" id="guardarSolicitud" onclick="return validacionGuardar()" class="btn btn-lg btn-success">Guardar</button>
  <button class="btn btn-lg btn-warning">Limpiar</button>
  </form>
  <div id="salida">
  </div>
