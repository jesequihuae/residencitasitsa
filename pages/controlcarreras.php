<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="utf-8"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Carreras</title>

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

    <!-- DataTable CSS -->
    <link href="../css/datatable.min.css" rel="stylesheet" type="text/css">

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
            if(!$ObjectITSA->checkPermission("controlcarreras")) {
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
                    <h1 class="page-header"><i class="fa fa-briefcase"></i> Carreras </h1>
                    <?php
                        if(isset($_POST) && isset($_POST['guardarCarrera'])){
                            if($_POST['idCarrera'] == 0) {
                                $ObjectITSA->registrarCarrera(
                                    $_POST['vClave'],
                                    $_POST['vCarrera']
                                );
                            } else {
                                $ObjectITSA->actualizarCarrera(
                                    $_POST['idCarrera'],
                                    $_POST['vClave'],
                                    $_POST['vCarrera']
                                );
                            }
                        }
                        else if(isset($_POST['activarDesactivar'])) {
                                $ObjectITSA->changeStatusCarrera(
                                    $_POST['idActividadCambiarEstado'],
                                    $_POST['currentStatus']
                                );
                        }
                    ?>
                </div>
            </div>

            <!-- ... Your content goes here ... -->
            <section id="panelRegistroEdicion">
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h2 class="panel-title">
                                    <div id="txtHeadingRegistroCarreras">Registrar Carrera</div>
                                </h2>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" method="POST">
                                    <input type="hidden" name="idCarrera" id="idCarrera" value="0">
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Clave:</label>
                                       <div class="col-lg-9">
                                           <input type="text" class="form-control" name="vClave" id="vClave" placeholder="Clave" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Carrera:</label>
                                       <div class="col-lg-9">
                                           <input type="text" class="form-control" name="vCarrera" id="vCarrera" placeholder="Carrera" required>
                                       </div>
                                    </div>
                                    <button type="button" class="btn btn-default" id="cancelarRegistro"><i class="fa fa-times-circle"></i> Cancelar</button>
                                    <button type="submit" class="btn btn-info pull-right" name="guardarCarrera"><i class="fa fa-paper-plane"></i> Guardar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="row">
              <div class="col-lg-12">
                  <div class="panel panel-primary">
                      <div class="panel-heading">
                          <h2 class="panel-title">
                              Carreras registradas
                          </h2>
                      </div>
                      <div class="panel-body">
                          <button type="button" class="btn btn-primary pull-right" id="btnNuevaCarrera">
                                <i class="fa fa-plus"></i> Nueva Carrera
                          </button><br><br>
                          <div class="table-responsive">
                              <table class="table table-hover" id="dtCarreras">
                                  <thead>
                                      <th>ID</th>
                                      <th>Clave</th>
                                      <th>Carrera</th>
                                      <th>Estado</th>
                                      <th><center>Operaciones</center></th>
                                  </thead>
                                  <?php
                                    $CARRERAS_QUERY = $ObjectITSA->getAllCarreras();
                                    while($CARRERAS_ = $CARRERAS_QUERY->FETCH(PDO::FETCH_ASSOC))  {
                                  ?>
                                  <tr>
                                      <td><?php echo $CARRERAS_['idCarrera']; ?></td>
                                      <td><?php echo $CARRERAS_['vClave']; ?></td>
                                      <td><?php echo $CARRERAS_['vCarrera']; ?></td>
                                      <td>
                                          <?php
                                            echo ($CARRERAS_['bActivo'] == 1 ? '<span class="label label-success">Activa</span>' : '<span class="label label-danger">Inactiva</span>');
                                          ?>
                                      </td>
                                      <td>
                                            <center>
                                                  <button
                                                      type="button"
                                                      data-idcarrera="<?php echo $CARRERAS_['idCarrera']; ?>"
                                                      data-vclave="<?php echo $CARRERAS_['vClave']; ?>"
                                                      data-vcarrera="<?php echo $CARRERAS_['vCarrera']; ?>"
                                                      class="editarCarrera btn btn-primary btn-sm"
                                                      title="Editar Carrera">
                                                         <i class="fa fa-pencil"></i>
                                                  </button>
                                                  &nbsp;
                                             <?php
                                               echo ($CARRERAS_['bActivo'] == 1 ? '<button type="button" data-status="1" data-id="'.$CARRERAS_['idCarrera'].'" class="cambiarStatus btn btn-danger btn-sm" title="Desactivar"><i class="fa fa-close"></i></button>' : '<button type="button" data-status="0" data-id="'.$CARRERAS_['idCarrera'].'" class="cambiarStatus btn btn-success btn-sm" title="Activar"><i class="fa fa-check"></i></button>');
                                             ?>
                                             </center>
                                      </td>

                                  </tr>
                                  <?php } ?>
                              </table>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
        </div>
    </div>

    <!-- MODAL ACTIVAR/DESACTIVAR -->
    <div class="modal" id="modalActivarDesactivar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Atención!</h4>
          </div>
          <div class="modal-body" align="center">
            <input type="hidden" id="idActividadCambiarEstado" name="idActividadCambiarEstado">
            <input type="hidden" name="currentStatus" id="currentStatus">
            <h2 id="hdrActDes"></h2>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning pull-right" data-dismiss="modal">No</button>
            <button type="submit" class="btn btn-success" name="activarDesactivar" id="btnActivarDesactivar">Sí</button>&nbsp;&nbsp;&nbsp;
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
    <!-- DataTable CSS -->
    <script src="../js/datatable.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
          $("#dtCarreras").DataTable();
          $("#panelRegistroEdicion").hide();

          $("#btnNuevaCarrera").click(function(){
            $("#panelRegistroEdicion").hide();
            clearFields();
            $("#panelRegistroEdicion").show(150);
          });

          $("#cancelarRegistro").click(function() {
            $("#panelRegistroEdicion").hide(50);
            clearFields();
          });

          $(".editarCarrera").click(function(){
            $("#panelRegistroEdicion").hide(200);
            clearFields();
            $("#idCarrera").val($(this).data("idcarrera"));
            $("#vClave").val($(this).data("vclave"));
            $("#vCarrera").val($(this).data("vcarrera"));
            $("#panelRegistroEdicion").show(200);
          });

          $(".cambiarStatus").click(function(){
              var status = $(this).data("status");
              var id = $(this).data("id");
              $("#idActividadCambiarEstado").val(id);
              if(status==1) {
                $("#hdrActDes").text("¿Está seguro de desactivar?");
              } else {
                $("#hdrActDes").text("¿Está seguro de activar?");
              }
              $("#currentStatus").val(status);
              $("#modalActivarDesactivar").modal('show');
            });
        });

        function clearFields(){
            $("#idCarrera").val("0");
            $("#vClave").val("");
            $("#vCarrera").val("");
        }
    </script>
</body>
</html>
