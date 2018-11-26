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
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap-select.min.css">

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
        <div class="container-fluid">
            <!-- <input type="hidden" id="idUsuario" value="<?php @session_start(); echo $_SESSION['idUsuario']; ?>"> -->
            <div class="row">
            <?php
              include '../php/connection.php';
              if($ObjectITSA->checkSession()){
                  if(!$ObjectITSA->checkPermission("residencia")) {
                      echo '<script language = javascript> self.location = "javascript:history.back(-1);" </script>';
                      exit;
                  }
              } else {
                  echo '<script language = javascript> self.location = "javascript:history.back(-1);" </script>';
                  exit;
              }
            ?>
                <div class="col-lg-12">
                    <h1 class="page-header">
                    </h1>
                    <?php
                        if(isset($_POST['registrarProyecto'])) {
                          /*$ObjectITSA->registerProject(
                            $_SESSION['idUsuario'],
                            $_SESSION['numeroControl'],
                            $_POST['idProyecto'],
                            $_POST['idPeriodo'],
                            $_POST['idOpcion'],
                            $_POST['idGiro'],
                            $_POST['idSector'],
                            $_FILES['Solicitud'],
                            $_FILES['Anteproyecto'],
                            $_FILES['Constancia']
                          );*/
                          $ObjectITSA1->saveSolicitud(
                                                            $_POST,
                                                            $_FILES['Constancia'],
                                                            $_SESSION['idUsuario'],
                                                            $_SESSION['numeroControl']
                                                      );
                        } else if (isset($_POST['ContinuarTab'])) {
                          $ObjectITSA->changeIntProcesss($_SESSION['idUsuario']);
                        } else if (isset($_POST['aceptacionPresentacion'])) {
                          $ObjectITSA->saveLetters(
                            $_SESSION['idUsuario'],
                            $_SESSION['numeroControl'],
                            $_FILES['presentacion'],
                            $_FILES['aceptacion']
                          );
                        } else if (isset($_POST['primerReporteForm'])) {
                          $ObjectITSA->saveFirstReport(
                            $_SESSION['idUsuario'],
                            $_SESSION['numeroControl'],
                            $_FILES['primerReporte']
                          );
                        } else if (isset($_POST['segundoReporteForm'])) {
                          $ObjectITSA->saveSecondReport(
                            $_SESSION['idUsuario'],
                            $_SESSION['numeroControl'],
                            $_FILES['segundoReporte']
                          );
                        } else if (isset($_POST['tercerReporteForm'])) {
                          $ObjectITSA->saveThirdReport(
                            $_SESSION['idUsuario'],
                            $_SESSION['numeroControl'],
                            $_FILES['tercerReporte']
                          );
                        }
                      ?>
                </div>
            </div>

            <!-- ... Your content goes here ... -->
            <div class="row">
              <div class="col-lg-12">
                <div class="alert alert-warning" align="center">
                  <strong>Atención!</strong> Antes de subir cualquier documento se recomienda pasar con su asesor para revisión previa.
                </div>
              </div>
            </div>
            <div class="row">
                <section class="design-process-section" id="process-tab" align="center">
                      <div class="col-lg-12">
                        <!-- design process steps-->
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs process-model more-icon-preocess" role="tablist">
                          <li role="presentation" class="<?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 1 ? 'active' : $ObjectITSA->getIntProcess($_SESSION['idUsuario']) > 1 ? 'visited' : '') ?>"">
                            <a href="#registrarProyecto" class="opcionHdr" aria-controls="registrarProyecto" role="tab" data-toggle="tab">
                              <i class="fa fa-briefcase"></i>
                              <p>Proyecto</p>
                            </a>
                          </li>

                          <li role="presentation" class="<?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 2 ? 'active' : $ObjectITSA->getIntProcess($_SESSION['idUsuario']) > 2 ? 'visited' : '') ?>">
                            <a href="#solicitudStatus" class="opcionHdr" aria-controls="solicitudStatus" role="tab" data-toggle="tab">
                              <i class="fa fa-hourglass-2"></i>
                              <p>Estado</p>
                            </a>
                          </li>

                          <li role="presentation" class="<?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 3 ? 'active' : $ObjectITSA->getIntProcess($_SESSION['idUsuario']) > 3 ? 'visited' : '') ?>">
                            <a href="#ctaAceptacion" class="opcionHdr" aria-controls="ctaAceptacion" role="tab" data-toggle="tab">
                              <i class="fa fa-folder-open"></i>
                              <p>Cartas</p>
                            </a>
                          </li>

                          <li role="presentation" class="<?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 4 ? 'active' : $ObjectITSA->getIntProcess($_SESSION['idUsuario']) > 4 ? 'visited' : '') ?>">
                            <a href="#1seguimiento" class="opcionHdr" aria-controls="1seguimiento" role="tab" data-toggle="tab">
                              <i class="fa fa-folder-open"></i>
                              <p>Primer</p>
                            </a>
                          </li>

                          <li role="presentation" class="<?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 5 ? 'active' : $ObjectITSA->getIntProcess($_SESSION['idUsuario']) > 5 ? 'visited' : '') ?>">
                            <a href="#2seguimiento" class="opcionHdr" aria-controls="2seguimiento" role="tab" data-toggle="tab">
                              <i class="fa fa-folder-open"></i>
                              <p>Segundo</p>
                            </a>
                          </li>

                          <li role="presentation" class="<?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 6 ? 'active' : $ObjectITSA->getIntProcess($_SESSION['idUsuario']) > 6 ? 'visited' : '') ?>">
                            <a href="#3seguimiento" class="opcionHdr" aria-controls="3seguimiento" role="tab" data-toggle="tab">
                             <i class="fa fa-folder-open"></i>
                              <p>Tercer</p>
                            </a>
                          </li>

                          <li role="presentation class="<?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 7 ? 'active' : $ObjectITSA->getIntProcess($_SESSION['idUsuario']) > 7 ? 'visited' : '') ?>">
                            <a href="#final" class="opcionHdr" aria-controls="final" role="tab" data-toggle="tab">
                              <i class="fa fa-folder"></i>
                              <p>Final</p>
                            </a>
                          </li>
                        </ul>
                        <!-- end design process steps-->
                        <!-- Tab panes -->
                        <div class="tab-content">
                          <!-- REGISTRAR PROYECTO -->
                          <div role="tabpanel" class="tab-pane <?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 1 ? 'active' : '') ?>" id="registrarProyecto">
                            <div class="design-process-content">
                              <h3 class="semi-bold">Registra tu proyecto</h3>
                              <p>Bienvenido al sistema de Residencias del Instituto Tecnológico Superior de Apatzingán</p>
                              <form method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                  <label for="inputEmail3" class="col-lg-2 col-form-label">Proyecto:</label>
                                  <div class="col-lg-8">
                                    <select class="form-control selectpicker" data-live-search="true" name="idProyecto" required>
                                      <option value="1">Proyecto Prueba</option>
                                      <option value="2">Proyecto Prueba2</option>
                                      <option value="3">Proyecto Prueba3</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="inputEmail3" class="col-lg-2 col-form-label">Periodo:</label>
                                  <div class="col-lg-8">
                                    <select class="form-control"  name="idPeriodo" required>
                                      <option value="1">Agosto 2018 - Enero 2019</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="inputEmail3" class="col-lg-2 col-form-label" >Opción:</label>
                                  <div class="col-lg-8">
                                    <select class="form-control" data-live-search="true" name="idOpcion" required>
                                      <option value="1">Propuesta alumno</option>
                                      <option value="2">Banco de proyectos</option>
                                      <option value="3">Trabajador</option>
                                    </select>
                                  </div>
                                </div>
                                 <div class="form-group row">
                                  <label for="inputEmail3" class="col-lg-2 col-form-label" >Giro:</label>
                                  <div class="col-lg-8">
                                    <select class="form-control" name="idGiro" required>
                                      <option value="1">Industrial</option>
                                      <option value="2">Servicios</option>
                                      <option value="3">Educativo</option>
                                    </select>
                                  </div>
                                </div>
                                 <div class="form-group row">
                                  <label for="inputEmail3" class="col-lg-2 col-form-label" >Sector:</label>
                                  <div class="col-lg-8">
                                    <select class="form-control" name="idSector" required>
                                      <option value="1">Público</option>
                                      <option value="2">Privado</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group row">
                                 <label for="asesorInterno" class="col-lg-2 col-form-label" >ASESOR(A) INTERNO(A):</label>
                                 <div class="col-lg-8">
                                   <input type="text" name="asesorInterno" class="form-control" />
                                 </div>
                               </div>
                               <div class="form-group row">
                                <label for="inputEmail3" class="col-lg-2 col-form-label" >ASESOR(A) EXTERNO(A):</label>
                                <div class="col-lg-8">
                                  <input type="text" name="asesorExterno" class="form-control" />
                                </div>
                              </div>
                               <div class="form-group row">
                                <label for="inputEmail3" class="col-lg-2 col-form-label" >PERSONA QUE FIRMARÁ DOCUMENTOS OFICIALES DE LA RESIDENCIA:</label>
                                <div class="col-lg-8">
                                  <input type="text" name="personasQueFirmaran" class="form-control" />
                                </div>
                              </div>
                              <hr>
                              <h3 class="semi-bold">Información del alumno</h3>
                              <div class="form-group row">
                               <label for="inputEmail3" class="col-lg-2 col-form-label" >Nombre:</label>
                               <div class="col-lg-8">
                                 <input type="text" name="nombreAlumno" value="<?php echo $_SESSION['nombre']; ?>" class="form-control" />
                               </div>
                             </div>
                             <div class="form-group row">
                              <label for="inputEmail3" class="col-lg-2 col-form-label" >Numero de control:</label>
                              <div class="col-lg-8">
                                <input type="text" name="numeroDeControl" value="<?php echo $_SESSION['numeroControl']; ?>" class="form-control" />
                              </div>
                            </div>
                            <div class="form-group row">
                             <label for="inputEmail3" class="col-lg-2 col-form-label" >Domicilio:</label>
                             <div class="col-lg-8">
                               <input type="text" name="domicilioAlumno" class="form-control" />
                             </div>
                            </div>
                            <div class="form-group row">
                             <label for="inputEmail3" class="col-lg-2 col-form-label" >Colonia:</label>
                             <div class="col-lg-8">
                               <input type="text" name="coloniaAlumno" class="form-control" />
                             </div>
                            </div>
                            <div class="form-group row">
                             <label for="inputEmail3" class="col-lg-2 col-form-label" >Ciudad y estado:</label>
                             <div class="col-lg-8">
                               <input type="text" name="ciudadEstado" class="form-control" />
                             </div>
                            </div>
                            <div class="form-group row">
                             <label for="inputEmail3" class="col-lg-2 col-form-label" >CP:</label>
                             <div class="col-lg-8">
                               <input type="text" name="cp" class="form-control" />
                             </div>
                            </div>
                            <div class="form-group row">
                             <label for="inputEmail3" class="col-lg-2 col-form-label" >Telefono:</label>
                             <div class="col-lg-8">
                               <input type="text" name="telefono" class="form-control" />
                             </div>
                            </div>
                            <div class="form-group row">
                             <label for="inputEmail3" class="col-lg-2 col-form-label" >Email:</label>
                             <div class="col-lg-8">
                               <input type="text" name="correo" class="form-control" />
                             </div>
                            </div>
                            <div class="form-group row">
                             <label for="inputEmail3" class="col-lg-2 col-form-label" >Seguro social:</label>
                             <div class="col-lg-4">
                               <select name="idSeguroSocial" class="form-control">
                                 <option value="1">IMSS</option>
                                 <option value="2">ISSTE</option>
                                 <option value="3">OTROS</option>
                               </select>
                             </div>
                             <div class="col-lg-4">
                               <input type="text" name="numeroSeguro" class="form-control"  placeholder="numeroSeguro" />
                             </div>
                            </div>
                                <!--<div class="form-group row">
                                  <label for="inputEmail3" class="col-lg-2 col-form-label">Solicitud:</label>
                                  <div class="col-lg-10">
                                    <input type="file" name="Solicitud" required>
                                  </div>
                                </div>-->
                                <!--<div class="form-group row">
                                  <label for="inputEmail3" class="col-lg-2 col-form-label">Anteproyecto:</label>
                                  <div class="col-lg-10">
                                    <input type="file" name="Anteproyecto" required>
                                  </div>
                                </div>-->
                                <div class="form-group row">
                                  <label for="inputEmail3" class="col-lg-2 col-form-label">Constancia:</label>
                                  <div class="col-lg-10">
                                    <input type="file" name="Constancia" required>
                                  </div>
                                </div>
                                <div>
                                  <button type="submit" name="registrarProyecto" class="btn btn-lg btn-success">Guardar</button>
                                  <button class="btn btn-lg btn-warning">Limpiar</button>
                                  <br><br>
                                </div>
                              </form>
                             </div>
                          </div>

                          <!-- ESPERA DE STATUS DE PROYECTO -->
                          <div role="tabpanel" class="tab-pane <?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 2 ? 'active' : '') ?>" id="solicitudStatus">
                            <div class="design-process-content">
                              <h3 class="semi-bold">Estado de Solicitud</h3>
                              <p>Te informamos que el proyecto que seleccionaste se encuentra en la etapa de :</p>
                              <p><?php echo $ObjectITSA->getProjectStatusTEXT($_SESSION['idUsuario']); ?></p>
                              <?php echo ($ObjectITSA->getProjectStatusINT($_SESSION['idUsuario']) == 5 ? '<br><br><form method="post" id="FormContinuar"><input type="hidden" name="ContinuarTab"><button type="submit" class="btn btn-info" name="Continuar" id="Continuar">Continuar</button></form><br><br>' : '') ?>
                              <?php echo ($ObjectITSA->getProjectStatusINT($_SESSION['idUsuario']) == 6 ? ($ObjectITSA->getRejectionTEXT($_SESSION['idUsuario'])) : '') ?>
                            </div>
                          </div>


                          <!-- CARTA DE ACEPTACION Y CARTA DE PRESENTACIÓN -->
                          <div role="tabpanel" class="tab-pane <?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 3 ? 'active' : '') ?>" id="ctaAceptacion">
                            <div class="design-process-content">
                              <h3 class="semi-bold">Documentos</h3>
                              <p>Carta de presentación y Carta de aceptación</p>
                              <form method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                  <label for="inputEmail3" class="col-lg-4 col-form-label">Carta de presentación:</label>
                                  <div class="col-lg-8">
                                    <input type="file" name="presentacion" required>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="inputEmail3" class="col-lg-4 col-form-label">Carta de aceptación:</label>
                                  <div class="col-lg-8">
                                    <input type="file" name="aceptacion" required>
                                  </div>
                                </div>
                                <div align="center">
                                  <button class="btn btn-success" type="submit" name="aceptacionPresentacion">Guardar</button>
                                  <button class="btn btn-warning">Limpiar</button>
                                </div>
                              </form>
                              <!-- <a href="#1seguimiento" aria-controls="1seguimiento" role="tab" data-toggle="tab">Siguiente</a> -->
                            </div>
                          </div>

                          <!-- PRIMER SEGUIMIENTO -->
                          <div role="tabpanel" class="tab-pane <?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 4 ? 'active' : '') ?>" id="1seguimiento">
                            <div class="design-process-content">
                              <h3 class="semi-bold">Primer seguimiento</h3>
                              <p>Primer seguimiento</p>
                              <form method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                  <label for="inputEmail3" class="col-lg-4 col-form-label">Primer Reporte:</label>
                                  <div class="col-lg-8">
                                    <input type="file" name="primerReporte" required>
                                  </div>
                                </div>
                                <div align="center">
                                  <button class="btn btn-success" type="submit" name="primerReporteForm">Guardar</button>
                                  <!-- <button class="btn btn-warning">Limpiar</button> -->
                                </div><br>
                              </form>
                            </div>
                            <a href="#2seguimiento" aria-controls="2seguimiento" role="tab" data-toggle="tab">Siguiente</a>
                          </div>

                          <!-- SEGUNDO SEGUIMIENTO -->
                          <div role="tabpanel" class="tab-pane <?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 5 ? 'active' : '') ?>" id="2seguimiento">
                            <div class="design-process-content">
                              <h3>Segundo seguimiento</h3>
                              <p>Segundo seguimiento</p>
                              <form method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                  <label for="inputEmail3" class="col-lg-4 col-form-label">Segundo Reporte:</label>
                                  <div class="col-lg-8">
                                    <input type="file" name="segundoReporte" required>
                                  </div>
                                </div>
                                <div align="center">
                                  <button class="btn btn-success" type="submit" name="segundoReporteForm">Guardar</button>
                                  <!-- <button class="btn btn-warning">Limpiar</button> -->
                                </div><br>
                              </form>
                            </div>
                            <a href="#3seguimiento" aria-controls="3seguimiento" role="tab" data-toggle="tab">Siguiente</a>
                          </div>

                          <!-- TERCER SEGUIMIENTO -->
                          <div role="tabpanel" class="tab-pane <?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 6 ? 'active' : '') ?>" id="3seguimiento">
                            <div class="design-process-content">
                              <h3>Tercer seguimiento</h3>
                              <p>Tercer seguimiento</p>
                              <form method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                  <label for="inputEmail3" class="col-lg-4 col-form-label">Tercer Reporte:</label>
                                  <div class="col-lg-8">
                                    <input type="file" name="tercerReporte" required>
                                  </div>
                                </div>
                                <div align="center">
                                  <button class="btn btn-success" type="submit" name="tercerReporteForm">Guardar</button>
                                  <!-- <button class="btn btn-warning">Limpiar</button> -->
                                </div><br>
                              </form>
                            </div>
                            <a href="#final" aria-controls="final" role="tab" data-toggle="tab">Siguiente</a>
                          </div>

                          <!-- FINAL -->
                          <div role="tabpanel" class="tab-pane <?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 7 ? 'active' : '') ?>" id="final">
                            <div class="design-process-content">
                              <h3>Documento final</h3>
                              <p>Documento final</p>
                            </div>
                          </div>

                      </div>
                </section>
            </div>
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
    <script type="text/javascript">
      $('#process-tab .opcionHdr').click(function(event){
        event.stopPropagation();
        event.preventDefault();
      });

      $('#Continuar').click(function(event){
        $('#Continuar').attr('disabled',true);
        $('#FormContinuar').submit();
      });

    </script>
</body>
</html>
