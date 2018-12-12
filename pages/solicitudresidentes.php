<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="utf-8"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Solicitudes</title>

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
    <?php 
        include '../php/connection.php';
        if($ObjectITSA->checkSession()){  
            if(!$ObjectITSA->checkPermission("solicitudresidentes")) {
                echo '<script language = javascript> self.location = "javascript:history.back(-1);" </script>';
                exit;
            }
        } else {
            echo '<script language = javascript> self.location = "javascript:history.back(-1);" </script>';
            exit;
        }
    ?>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- <input type="hidden" id="idUsuario" value="<?php @session_start(); echo $_SESSION['idUsuario']; ?>"> -->
            <div class="row">

                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-briefcase"></i> Solicitudes </h1>
                    <?php 
                        if(isset($_POST) && isset($_POST['btnAceptarRechazar'])) {
                            if($_POST['aceptarRechazar'] == 1) {
                                $ObjectITSA->aceptarSolicitud($_POST['idProyectoAceptarRechazar']);
                            }
                            else if($_POST['aceptarRechazar'] == 0) {
                                $ObjectITSA->rechazarSolicitud($_POST['idProyectoAceptarRechazar'], $_POST['taMotivoRechazo']);
                            }
                        }
                    ?>
                </div>
            </div>

            <!-- ... Your content goes here ... --> 
            <div class="row">
              <div class="col-lg-12">
                  <div class="panel panel-primary">
                      <div class="panel-heading">
                          <h2 class="panel-title">
                              Solicitudes
                          </h2>
                      </div>
                      <div class="panel-body">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Buscar" id="busqueda" name="busqueda">
                                <div class="input-group-btn">
                                    <button class="btn btn-default" type="button" id="buscarCoincidencias" name="buscarCoincidencias">
                                        <i class="glyphicon glyphicon-search"></i>
                                    </button>
                                </div>
                            </div>

                           <div class="table-responsive">
                              <table class="table table-hover" id="tableSolicitudesFiltro">
                                  <thead>
                                    <th>ID</th>
                                    <th>Proyecto</th>
                                    <th>Número Control</th>
                                    <th>Alumno</th>
                                    <th>Periodo</th>                                    
                                    <th>Opcion</th>
                                    <th>Giro</th>
                                    <th>Estado</th>
                                    <th>Sector</th>
                                    <th colspan="2"><center>Operaciones</center></th>
                                </thead>
                              </table>
                              <table class="table table-hover" id="tableSolicitudes">
                                <thead>
                                    <th>ID</th>
                                    <th>Proyecto</th>
                                    <th>Número Control</th>
                                    <th>Alumno</th>
                                    <th>Periodo</th>                                    
                                    <th>Opcion</th>
                                    <th>Giro</th>
                                    <th>Estado</th>
                                    <th>Sector</th>
                                    <th colspan="2"><center>Operaciones</center></th>
                                </thead>
                                <?php 
                                    $SOLICITUDES_QUERY = $ObjectITSA->getSolicitudesResidenciasByJefeCarrera($_SESSION['idUsuario']);
                                    while($SOLICITUDES_ = $SOLICITUDES_QUERY->FETCH(PDO::FETCH_ASSOC))  {
                                  ?>
                                <tr>
                                    <td><?php echo $SOLICITUDES_['idProyectoSeleccionado']; ?></td>
                                    <td><?php echo $SOLICITUDES_['vNombreProyecto']; ?></td>
                                    <td><?php echo $SOLICITUDES_['vNumeroControl']; ?></td>
                                    <td><?php echo $SOLICITUDES_['vNombre'].' '.$SOLICITUDES_['vApellidoPaterno'].' '.$SOLICITUDES_['vApellidoMaterno']; ?></td>
                                    <td><?php echo $SOLICITUDES_['vPeriodo']; ?></td>
                                    <td><?php echo $SOLICITUDES_['vOpcion']; ?></td>
                                    <td><?php echo $SOLICITUDES_['vGiro']; ?></td>
                                    <td>
                                        <?php 
                                            echo ($SOLICITUDES_['idEstado'] == 3 ? '<span class="label label-warning">'.$SOLICITUDES_['vEstado'].'</span>' : '');
                                            echo ($SOLICITUDES_['idEstado'] == 4 ? '<span class="label label-default">'.$SOLICITUDES_['vEstado'].'</span>' : '');
                                            echo ($SOLICITUDES_['idEstado'] == 5 ? '<span class="label label-success">'.$SOLICITUDES_['vEstado'].'</span>' : '');
                                            echo ($SOLICITUDES_['idEstado'] == 6 ? '<span class="label label-danger">'.$SOLICITUDES_['vEstado'].'</span>' : '');
                                        ?>
                                    </td>
                                    <td><?php echo $SOLICITUDES_['vSector']; ?></td>
                                    <td>
                                        <?php if($SOLICITUDES_['idEstado'] == 3) { ?>
                                        <center>
                                            <button 
                                                type="button"
                                                data-idproyecto="<?php echo $SOLICITUDES_['idProyectoSeleccionado']; ?>"
                                                data-numerocontrol="<?php echo $SOLICITUDES_['vNumeroControl']; ?>"
                                                data-nombrecompleto="<?php echo $SOLICITUDES_['vNombre'].' '.$SOLICITUDES_['vApellidoPaterno'].' '.$SOLICITUDES_['vApellidoMaterno']; ?>"
                                                class="aceptarSolicitud btn btn-success btn-sm"
                                                title="Aceptar Solicitud">
                                                   <i class="fa fa-check"></i>
                                            </button>
                                        </center>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($SOLICITUDES_['idEstado'] == 3) { ?>
                                        <center>
                                            <button 
                                                type="button"
                                                data-idproyecto="<?php echo $SOLICITUDES_['idProyectoSeleccionado']; ?>"
                                                data-numerocontrol="<?php echo $SOLICITUDES_['vNumeroControl']; ?>"
                                                data-nombrecompleto="<?php echo $SOLICITUDES_['vNombre'].' '.$SOLICITUDES_['vApellidoPaterno'].' '.$SOLICITUDES_['vApellidoMaterno']; ?>"
                                                class="rechazarSolicitud btn btn-danger btn-sm"
                                                title="Rechazar Solicitud">
                                                   <i class="fa fa-close"></i>
                                            </button>
                                        </center>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php 
                                    } 
                                ?>
                              </table>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
        </div>
    </div>
    <!-- MODAL ACTIVAR/DESACTIVAR -->
    <div class="modal" id="modalAceptarRechazar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post" class="form-horizontal">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><center><h4 id="TituloModal"></h4></center></h4>
          </div>
          <div class="modal-body" align="center">
            <input type="hidden" id="idProyectoAceptarRechazar" name="idProyectoAceptarRechazar">
            <input type="hidden" id="aceptarRechazar" name="aceptarRechazar">
            <h2 id="hdrActDes"></h2>
            <br><br>
            <div class="form-group" id="grupoRechazo">
               <label class="control-label col-lg-4">Motivo de Rechazo</label>
               <div class="col-lg-8">
                <textarea class="form-control" name="taMotivoRechazo" id="taMotivoRechazo"></textarea>
               </div>                                    
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning pull-right" data-dismiss="modal">No</button>
            <button type="submit" class="btn btn-success" name="btnAceptarRechazar" id="btnAceptarRechazar">Sí</button>&nbsp;&nbsp;&nbsp;
          </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
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
    <script type="text/javascript">
        $(document).ready(function(){ 
            $("#tableSolicitudesFiltro").hide();

            $(".aceptarSolicitud").click(function(){
                $("#aceptarRechazar").val("1");
                $("#idProyectoAceptarRechazar").val($(this).data("idproyecto"));
                $("#TituloModal").text("Solicitud de " + $(this).data("numerocontrol") + " | " + $(this).data("nombrecompleto"));
                $("#hdrActDes").text("¿Está seguro de aceptar la solicitud?");
                document.getElementById("grupoRechazo").style.display = "none";
                $('#taMotivoRechazo').prop('required',false);
                $("#modalAceptarRechazar").modal('show');
            });

            $(".rechazarSolicitud").click(function() {
                $("#aceptarRechazar").val("0");
                $("#idProyectoAceptarRechazar").val($(this).data("idproyecto"));
                $("#TituloModal").text("Solicitud de " + $(this).data("numerocontrol") + " | " + $(this).data("nombrecompleto"));
                $("#hdrActDes").text("¿Está seguro de rechazar la solicitud?");
                document.getElementById("grupoRechazo").style.display = "";
                $('#taMotivoRechazo').prop('required',true);
                $("#modalAceptarRechazar").modal('show');
            });

            $("#buscarCoincidencias").click(function(){
                if($("#busqueda").val() != "") {
                    $("#tableSolicitudes").hide();
                    // $.ajax({

                    // });
                } else {
                    $("#tableSolicitudesFiltro").hide();
                    $("#tableSolicitudes").show();
                }
            });
        });
    </script>
</body>
</html>
