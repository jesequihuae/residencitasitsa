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

    <!-- ALERTIFY JS-->
<script src="../js/alertify.min.js"></script>
<link rel="stylesheet" href="../css/alertify.min.css" />
<link rel="stylesheet" href="../css/default.min.css" />

<link rel="shortcut icon" href="../img/logo.ico" />

<link rel="stylesheet" href="../css/ItsaStyle.css" />

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
                          $ObjectITSA1->saveReports(
                            $_SESSION['idUsuario'],
                            $_SESSION['numeroControl'],
                            $_FILES['fileEvaluacion'],
                            $_FILES['fileFormatoAsesoria'],
                            4, 
                            5,
                            'PrimerReporte'
                          );
                        } else if (isset($_POST['segundoReporteForm'])) {
                          $ObjectITSA1->saveReports(
                            $_SESSION['idUsuario'],
                            $_SESSION['numeroControl'],
                            $_FILES['fileEvaluacion'],
                            $_FILES['fileFormatoAsesoria'],
                            4, 
                            6,
                            'SegundoReporte'
                          );
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

                          <!--<li title="reporte 3" role="presentation" class="<?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 6 ? 'active' : $ObjectITSA->getIntProcess($_SESSION['idUsuario']) > 6 ? 'visited' : '') ?>">
                            <a href="#3seguimiento" class="opcionHdr" onclick="descagarSeguimiento(7,<?php echo $ObjectITSA->getIntProcess($_SESSION['idUsuario']) ?>)" aria-controls="3seguimiento" role="tab" data-toggle="tab">
                             <i class="fa fa-folder-open"></i>
                              <p>Tercer</p>
                            </a>
                          </li>-->

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
                          <form method="post" enctype="multipart/form-data" >
                            <?php include_once("html/solicitudDeResidencias.php"); ?>
                          </form>
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
                                <div class="row">
                                  <div class="col-md-12">
                                      <div class="col-md-12">
                                        <p>Primer seguimiento</p>
                                      </div>
                                      <form method="post" enctype="multipart/form-data">
                                        <div class="col-md-12">
                                            <div class="col-md-3 col-md-offset-3">
                                              <div class="col-md-12">
                                                  <strong>
                                                    <a href="<?php echo $ObjectITSA1->getSeguimientoById(5); ?>" target="_blank">Evaluación</a>
                                                  </strong>
                                              </div>
                                              <div class="col-md-12">
                                                <input type="file" name="fileEvaluacion" />
                                              </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="col-md-12">
                                                    <strong>
                                                    Formato de asesoria
                                                    </strong>
                                                </div>
                                                <div class="col-md-12">
                                                  <input type="file" name="fileFormatoAsesoria" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="margin-top:20px;">
                                          <button class="btn btn-primary" name="primerReporteForm">Guardar</button>
                                        </div>
                                      </form>
                                  </div>
                                </div>
                            </div>
                          </div>

                          <!-- SEGUNDO SEGUIMIENTO -->
                          <div role="tabpanel" class="tab-pane <?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 5 ? 'active' : '') ?>" id="2seguimiento">
                            <?php $numSeg = $ObjectITSA->getIntProcess($_SESSION['idUsuario']); ?>
                            <div class="design-process-content">
                              <div class="row">
                                  <div class="col-md-12">
                                      <p>Segundo seguimiento</p>
                                  </div>
                                  <form method="post" enctype="multipart/form-data">
                                        <div class="col-md-12">
                                            <div class="col-md-3 col-md-offset-3">
                                              <div class="col-md-12">
                                                 <strong>
                                                    <a href="<?php echo $ObjectITSA1->getSeguimientoById(6); ?>" target="_blank">Evaluación</a>
                                                  </strong>
                                              </div>
                                              <div class="col-md-12">
                                                <input type="file" name="fileEvaluacion" />
                                              </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="col-md-12">
                                                    <strong>
                                                    Formato de asesoria
                                                    </strong>
                                                </div>
                                                <div class="col-md-12">
                                                  <input type="file" name="fileFormatoAsesoria" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="margin-top:20px;">
                                          <button class="btn btn-primary" name="segundoReporteForm">Guardar</button>
                                        </div>
                                    </form>
                              </div>
                             </div>
                          </div>
                          <!-- FINAL -->
                          <div role="tabpanel" class="tab-pane <?php echo ($ObjectITSA->getIntProcess($_SESSION['idUsuario']) == 7 ? 'active' : '') ?>" id="final">
                            <div class="design-process-content">
                              <table class="table table-bordered">
                                <tr>
                                  <th>Documento</th>
                                  <th>Estado (AI)</th>
                                  <th>Estado (AE)</th>
                                  <th>Descargar</th>
                                </tr>
                                <?php foreach($ObjectITSA1->getAllDocumentsByAlumno($_SESSION['idUsuario']) as $row){?>
                                  <tr>
                                    <td><?php echo $row["vNombre"]; ?></td>
                                    <td><?php echo ($row["bAceptadoAI"] == 0)?"NO":"SI"; ?></td>
                                    <td><?php echo ($row["bAceptadoAE"] == 0)?"NO":"SI"; ?></td>
                                    <td><a target="_blank" href="<?php echo $row["vRuta"];?>"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                                  </tr>
                                <?php } ?>
                              </table>
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
        //window.open('http://residenciasitsa.diplomadosdelasep.com.mx/pages/exportFilesTbsOdt/exportFileSeguimiento.php?idSeg='+idSeg,'_blank');
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
      data:
            {
              "operacion":"3",
              "idDocumento":3
            },
      beforeSend: function(e){

      },
      success: function(e){
        var res           = $.parseJSON(e);
        var json          = res.cronograma;
        var semanaInicio  = res.semanaInicio;
        var semanaFin     = res.semanaFin;
        $(".rowsAdded").remove();
        var nombreActual = "",nombreAnterior;
        contador = 0;
        for(var i in json){
          if(contador>=(semanaInicio-1) && contador<semanaFin){
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



            }
            nombreAnterior = nombreActual;
          }
          contador++;
        }


        for(var i in json){
          if(isReal){
            $("#"+json[i]["i"]+json[i]["j"]).prop("checked",true);
          }else{
            $("#pro"+json[i]["i"]+json[i]["j"]).prop("checked",true);
          }
        }
        contador = 0;
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
  
    var idTipoDeDocumento = <?php echo (isset($_SESSION["idTipoDocumento"])?$_SESSION["idTipoDocumento"]:0); ?>;
  
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
        location.href = "residencia.php";
      },
      error: function(e){
        $("#salida").html(e);
        
        response = -1;
      }
    });

    return response;
  }

  function validacionGuardar(){

    var idProyecto = 0,idPeriodo = 0;

    idProyecto              = $("#idProyecto").val();
    idPeriodo               = $("#idPeriodo").val();
    idOpcion                = $("#idOpcion").val();
    idGiro                  = $("#idGiro").val();
    idSector                = $("#idSector").val();
    bImpacto                = $("#bImpacto").val();
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
