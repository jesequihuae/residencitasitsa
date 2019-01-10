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
                          $ObjectITSA1->saveLetters(
                            $_SESSION['idUsuario'],
                            $_SESSION['numeroControl'],
                            $_FILES['presentacion'],
                            $_FILES['aceptacion']
                          );
                        } else if (isset($_POST['primerReporteForm'])) {
                          /*$ObjectITSA->saveFirstReport(
                            $_SESSION['idUsuario'],
                            $_SESSION['numeroControl'],
                            $_FILES['primerReporte']
                          );*/
                        } else if (isset($_POST['segundoReporteForm'])) {
                          /*$ObjectITSA->saveSecondReport(
                            $_SESSION['idUsuario'],
                            $_SESSION['numeroControl'],
                            $_FILES['segundoReporte']
                          );*/
                        } else if (isset($_POST['tercerReporteForm'])) {
                          /*$ObjectITSA->saveThirdReport(
                            $_SESSION['idUsuario'],
                            $_SESSION['numeroControl'],
                            $_FILES['tercerReporte']
                          );*/
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
                              <p>Solicitud</p>
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

                          <li title="Reporte 1" role="presentation" class="<?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 4 ? 'active' : $ObjectITSA->getIntProcess($_SESSION['idUsuario']) > 4 ? 'visited' : '') ?>">
                            <a href="#1seguimiento" onclick="descagarSeguimiento(5,<?php echo $ObjectITSA->getIntProcess($_SESSION['idUsuario']) ?>)" class="opcionHdr" aria-controls="1seguimiento" role="tab" data-toggle="tab">
                              <i class="fa fa-folder-open"></i>
                              <p>Primer</p>
                            </a>
                          </li>

                          <li title="Reporte 2" role="presentation" class="<?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 5 ? 'active' : $ObjectITSA->getIntProcess($_SESSION['idUsuario']) > 5 ? 'visited' : '') ?>">
                            <a href="#2seguimiento" class="opcionHdr" onclick="descagarSeguimiento(6,<?php echo $ObjectITSA->getIntProcess($_SESSION['idUsuario']) ?>)" aria-controls="2seguimiento" role="tab" data-toggle="tab">
                              <i class="fa fa-folder-open"></i>
                              <p>Segundo</p>
                            </a>
                          </li>

                          <li title="reporte 3" role="presentation" class="<?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 6 ? 'active' : $ObjectITSA->getIntProcess($_SESSION['idUsuario']) > 6 ? 'visited' : '') ?>">
                            <a href="#3seguimiento" class="opcionHdr" onclick="descagarSeguimiento(7,<?php echo $ObjectITSA->getIntProcess($_SESSION['idUsuario']) ?>)" aria-controls="3seguimiento" role="tab" data-toggle="tab">
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
                              <hr>
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
                            <hr>
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
                                <hr>
                                <!--CRONOGRAMA-->
                                <h3 class="semi-bold">Cronograma</h3>
                                <?php
                                  if($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 1)
                                  {
                                      $_SESSION["idTipoDocumento"] = 3;
                                      require "cronograma/cronogramaSeg.php";
                                  }
                                 ?>
                                 <br>
                                <div>
                                   <!--FIN CRONOGRAMA-->
                                  <button type="submit" name="registrarProyecto" id="guardarSolicitud" class="btn btn-lg btn-success" onclick="return validacionGuardar()">Guardar</button>
                                  <button class="btn btn-lg btn-warning">Limpiar</button>
                                  <br><br>
                                </div>
                              </form>
                              <div class="form-group" style="padding:10px;">



                                <div id="salida">

                                </div>

                              </div>
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
                             <?php $numSeg = $ObjectITSA->getIntProcess($_SESSION['idUsuario']); ?>
                            <div class="design-process-content">
                                <div class="row">
                                  <div class="col-md-12">
                                    <h3 class="semi-bold">Primer seguimiento, Lo pronosticado</h3>
                                     <?php
                                        if($numSeg == 4)
                                        {
                                          //$_SESSION["idTipoDocumento"] = 5;
                                          require "cronograma/cronogramaPronosticado.php";
                                        }
                                      ?>
                                  </div>
                                  <div class="col-md-12">

                                      <h3 class="semi-bold">Primer seguimiento Lo Real</h3>
                                      <p>Primer seguimiento</p>
                                      <!--<form method="post" enctype="multipart/form-data">
                                        <div class="form-group row">
                                          <label for="inputEmail3" class="col-lg-4 col-form-label">Primer Reporte:</label>
                                          <div class="col-lg-8">
                                            <input type="file" name="primerReporte" required>
                                          </div>
                                        </div>
                                        <div align="center">
                                          <button class="btn btn-success" type="submit" name="primerReporteForm">Guardar</button>

                                        </div><br>
                                      </form>-->
                                      <?php
                                        if($numSeg == 4)
                                        {
                                          $_SESSION["idTipoDocumento"] = 5;
                                          require "cronograma/cronogramaSeg.php";
                                        }
                                      ?>
                                  </div>
                                </div>
                            </div>
                            <a href="#2seguimiento" aria-controls="2seguimiento" role="tab" data-toggle="tab">Siguiente</a>
                          </div>

                          <!-- SEGUNDO SEGUIMIENTO -->
                          <div role="tabpanel" class="tab-pane <?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 5 ? 'active' : '') ?>" id="2seguimiento">
                            <?php $numSeg = $ObjectITSA->getIntProcess($_SESSION['idUsuario']); ?>
                            <div class="design-process-content">
                              <div class="row">
                                <div class="col-md-12">
                                  <h3 class="semi-bold">Segundo seguimiento Lo Pronosticado</h3>
                                   <?php
                                        if($numSeg == 5)
                                        {
                                          //$_SESSION["idTipoDocumento"] = 6;
                                          require "cronograma/cronogramaPronosticado.php";
                                        }
                                    ?>
                                </div>
                                <div class="col-md-12">
                                  <h3 class="semi-bold">Segundo seguimiento Lo Pronosticado</h3>
                                    <p>Segundo seguimiento</p>
                                    <!--<form method="post" enctype="multipart/form-data">
                                      <div class="form-group row">
                                        <label for="inputEmail3" class="col-lg-4 col-form-label">Segundo Reporte:</label>
                                        <div class="col-lg-8">
                                          <input type="file" name="segundoReporte" required>
                                        </div>
                                      </div>
                                      <div align="center">
                                        <button class="btn btn-success" type="submit"  name="segundoReporteForm">Guardar</button>

                                      </div><br>
                                    </form>-->
                                    <?php
                                      if($numSeg == 5)
                                      {
                                        $_SESSION["idTipoDocumento"] = 6;
                                          require "cronograma/cronogramaSeg.php";
                                      }
                                    ?>
                             </div>
                            <!--<a href="#3seguimiento" aria-controls="3seguimiento" role="tab" data-toggle="tab">Siguiente</a>-->
                                </div>
                              </div>
                          </div>

                          <!-- TERCER SEGUIMIENTO -->
                          <div role="tabpanel" class="tab-pane <?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 6 ? 'active' : '') ?>" id="3seguimiento">
                            <?php $numSeg = $ObjectITSA->getIntProcess($_SESSION['idUsuario']); ?>
                            <div class="design-process-content">
                              <h3 class="semi-bold">Tercer seguimiento Lo Pronosticado</h3>
                               <?php
                                        if($numSeg == 6)
                                        {
                                          //$_SESSION["idTipoDocumento"] = 7;
                                          require "cronograma/CronogramaPronosticado.php";
                                        }
                                    ?>
                              <p>Tercer seguimiento</p>
                              <!--<form method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                  <label for="inputEmail3" class="col-lg-4 col-form-label">Tercer Reporte:</label>
                                  <div class="col-lg-8">
                                    <input type="file" name="tercerReporte" required>
                                  </div>
                                </div>
                                <div align="center">
                                  <button class="btn btn-success" type="submit" name="tercerReporteForm">Guardar</button>

                                </div><br>
                              </form>-->
                            </div>
                            <?php
                              if($numSeg == 6)
                              {
                                $_SESSION["idTipoDocumento"] = 7;
                                  require "cronograma/cronogramaSeg.php";
                              }
                            ?>
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
    <script src="../js/alertify.js"></script>
</body>
<script type="text/javascript">
  $('#process-tab .opcionHdr').click(function(event){
    event.stopPropagation();
    event.preventDefault();
  });

  $('#Continuar').click(function(event){
    $('#Continuar').attr('disabled',true);
    $('#FormContinuar').submit();
  });

  function descagarSeguimiento(idSeg,vaSeg){
    if(idSeg <= vaSeg){
        window.open('http://localhost:8080/residencitasitsa/pages/exportFilesTbsOdt/exportFileSeguimiento.php?idSeg='+idSeg,'_blank');
    }else{
      alertify.alert('ITSA', 'No disponible aun!', function(){ alertify.success('Ok'); });

    }
  }

  var contador = 0;
  cargarSelect();3
  precargarCronograma(false);

  function mostrarMensaje(mensaje,tipoMensaje){
    alertify.set('notifier','position', 'top-center');
    if(tipoMensaje == 1){
        alertify.notify(mensaje, 'success', 5, function(){  console.log('dismissed'); });
    }else if(tipoMensaje == 2){
      alertify.notify(mensaje, 'error', 5, function(){  console.log('dismissed'); });
    }

  }
  function cancelarActividades(){
    contador = 0;
    $(".rowsAdded").remove();
    mostrarMensaje("Cancelado",1);
    return false;
  }

  function precargarCronograma(isReal){


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
          nombreActual = json[i]["vNombre"];
          var semanas  = "";
          if(nombreActual != nombreAnterior){

              if(isReal){
                 for(j = 0;j<24;j++){

                //  if(json[i]["i"] == i && json[i]["j"] == j){
                  //  semanas += '<td><input type="checkbox" checked name="checkbox1" id="'+contador+''+j+'" /></td>';
                  //}else{
                    semanas += '<td><input disabled type="checkbox" name="checkbox1" id="'+contador+''+j+'" /></td>';
                  //}
                }
                $("#CronogramaPronosticado").append(
                          "<tr class='rowsAdded'>"+
                            "<td><input placeholder='Actividad' value='"+json[i]["vNombre"]+"' id='actividad"+contador+"'>"+json[i]["vNombre"]+"</input></td>"+semanas+
                          "</tr>"
                        );
              }else{
                for(j = 0;j<24;j++){

                //  if(json[i]["i"] == i && json[i]["j"] == j){
                  //  semanas += '<td><input type="checkbox" checked name="checkbox1" id="'+contador+''+j+'" /></td>';
                  //}else{
                    semanas += '<td><input disabled type="checkbox" name="checkbox1" id="pro'+contador+''+j+'" /></td>';
                  //}
                }
                $("#CronogramaPronosticado").append(
                          "<tr class='rowsAdded'>"+
                            "<td><label placeholder='Actividad' value='"+json[i]["vNombre"]+"' id='proactividad"+contador+"'>"+json[i]["vNombre"]+"</label></td>"+semanas+
                          "</tr>"
                        );
              }


              contador++;
          }
          nombreAnterior = nombreActual;
        }


        for(var i in json){
          if(isReal){
            $("#"+json[i]["i"]+json[i]["j"]).prop("checked",true);
          }else{
            $("#pro"+json[i]["i"]+json[i]["j"]).prop("checked",true);
          }
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

  function agregarActividad(){
     var semanas;
    for($j = 0;$j<24;$j++){
      semanas += '<td><input type="checkbox" name="checkbox1" id="'+contador+''+$j+'" /></td>';
    }
    $("#Cronograma").append(
                "<tr class='rowsAdded'>"+
                  "<td><input class='form-control' placeholder='Actividad' id='actividad"+contador+"'  /></td>"+semanas+
                "</tr>"
               );
    contador++;
    return false;
  }

  function guardar(){
    var response = 1;
    var cronograma = "[";

    var idTipoDeDocumento = <?php echo (isset($_SESSION["idTipoDocumento"])?$_SESSION["idTipoDocumento"]:0); ?>;

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
            mostrarMensaje("Cronograma guardado con exito ",1);
            console.log(e);
            if(idTipoDeDocumento != 3){
              location.href = "residencia.php";
            }else{
              response = 1;
            }

          },
          error: function(e){
            $("#salida").html(e);
            //mostrarMensaje("Algo salio mal...",2);
            response = -1;
          }
        });
      }else{
        //mostrarMensaje("No hay ninguna actividad por guardar...",2);
        response = 0;
      }
      return response;
  }

  function validacionGuardar(){

    var idProyecto = 0,idPeriodo = 0;

    idProyecto              = $("#idProyecto").val();
    idPeriodo               = $("#idPeriodo").val();
    idOpcion                = $("#idOpcion").val();
    idGiro                  = $("#idGiro").val();
    idSector                = $("#idSector").val();
    asesorInterno           = $("#asesorInterno").val();
    asesorExterno           = $("#asesorExterno").val();
    personasQueFirmaran     = $("#personasQueFirmaran").val();


    nombreAlumno            = $("#nombreAlumno").val();
    numeroDeControl         = $("#numeroDeControl").val();
    domicilioAlumno         = $("#domicilioAlumno").val();
    coloniaAlumno           = $("#coloniaAlumno").val();
    ciudadEstado            = $("#ciudadEstado").val();
    correo                  = $("#correo").val();
    cp                      = $("#cp").val();
    telefono                = $("#telefono").val();
    correo                  = $("#correo").val();
    idSeguroSocial          = $("#idSeguroSocial").val();
    numeroSeguro            = $("#numeroSeguro").val();


    tituloAnteproyecto        = $("#tituloAnteproyecto").val();
    objectivoGeneral          = $("#objectivoGeneral").val();
    objectivoEspecifico       = $("#objectivoEspecifico").val();
    alcancesDelimitaciones    = $("#alcancesDelimitaciones").val();
    descripcionActividades    = $("#descripcionActividades").val();
    areaOLugarImplementacion  = $("#areaOLugarImplementacion").val();

    alertify.set('notifier','position', 'top-center');
    if(idProyecto == 0){
      alertify.notify('Proyecto obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }
    if(idPeriodo == 0){
      alertify.notify('Periodo obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }
    if(idOpcion == 0){
      alertify.notify('Opcion obligatoria', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }
    if(idGiro == 0){
      alertify.notify('Giro obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }
    if(idSector == 0){
      alertify.notify('Sector obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }
    if(asesorInterno == ""){
      alertify.notify('Asesor interno obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }
    if(asesorExterno == ""){
      alertify.notify('Asesor externo obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }
    if(personasQueFirmaran == ""){
      alertify.notify('Personas que firmaran obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }



    if(nombreAlumno == ""){
      alertify.notify('Nombre del alumno obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }
    if(numeroDeControl == ""){
      alertify.notify('Numero de control obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }
    if(domicilioAlumno == ""){
      alertify.notify('Domicilio obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }
    if(coloniaAlumno == ""){
      alertify.notify('Colonia obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }
    if(ciudadEstado == ""){
      alertify.notify('Ciudad y Estado obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }
    if(cp == ""){
      alertify.notify('Codigo postal obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }
    if(telefono == ""){
      alertify.notify('telefono obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }
    if(correo == ""){
      alertify.notify('Correo obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }
    if(idSeguroSocial == 0){
      alertify.notify('Seguro obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }
    if(numeroSeguro == 0){
      alertify.notify('Numero de seguro obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }

    if(tituloAnteproyecto == ""){
      alertify.notify('Titulo del anteproyecto obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }
    if(objectivoGeneral == ""){
      alertify.notify('Objectivo general obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }
    if(objectivoEspecifico == ""){
      alertify.notify('Objectivo especifico obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }
    if(alcancesDelimitaciones == ""){
      alertify.notify('Alcances y delimitaciónes obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }
    if(descripcionActividades == ""){
      alertify.notify('Descripcion de las actividades obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }
    if(areaOLugarImplementacion == ""){
      alertify.notify('Lugar de la implementacion obligatorio', 'error', 5, function(){  console.log('dismissed'); });
      return false;
    }
    var guardarCron = guardar();
    if(guardarCron == 0){
      alertify.alert('ITSA', 'Debes de seleccionar por lo menos una actividad en el cronograma', function(){ alertify.success('Ok'); });
    }else if(guardarCron == -1){
      alertify.alert('ITSA', 'Algo salio mal al guardar el cronograma', function(){ alertify.success('Ok'); });
    }



  }
</script>
</html>
