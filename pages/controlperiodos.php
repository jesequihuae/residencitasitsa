<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="utf-8"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Periodos</title>

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
            if(!$ObjectITSA->checkPermission("controlperiodos")) {
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
                    <h1 class="page-header"><i class="fa fa-briefcase"></i> Periodos </h1>
                    <?php 
                        if(isset($_POST) && isset($_POST['guardarPeriodo'])){
                            if($_POST['idPeriodo'] == 0) {
                                $ObjectITSA->registrarPeriodo(
                                    $_POST['vPeriodo']
                                );
                            } else {

                            }
                        }
                        else if(isset($_POST['activarDesactivar'])) {
                                $ObjectITSA->changeStatusPeriodo(
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
                                    Periodo
                                </h2>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" method="POST">
                                    <input type="hidden" name="idPeriodo" id="idPeriodo" value="0">
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Periodo:</label>
                                       <div class="col-lg-9">
                                           <input type="text" class="form-control" name="vPeriodo" id="vPeriodo" placeholder="Periodo" required>
                                       </div>                                    
                                    </div>
                                    <button type="button" class="btn btn-default" id="cancelarRegistro"><i class="fa fa-times-circle"></i> Cancelar</button>
                                    <button type="submit" class="btn btn-info pull-right" name="guardarPeriodo"><i class="fa fa-paper-plane"></i> Guardar</button>
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
                          <h2 class="panel-title">Periodos registrados</h2>
                      </div>
                      <div class="panel-body">
                          <button type="button" class="btn btn-primary pull-right" id="btnNuevoPeriodo">
                                <i class="fa fa-plus"></i> Nuevo periodo
                          </button><br><br>
                          <div class="table-responsive">
                              <table class="table table-hover">
                                  <thead>
                                      <th>ID</th>
                                      <th>Periodo</th>
                                      <th>Estado</th>
                                      <th colspan="2"><center>Operaciones</center></th>
                                  </thead>
                                  <?php 
                                    $PERIODOS_QUERY = $ObjectITSA->getAllPeriodos();
                                    while($PERIODOS_ = $PERIODOS_QUERY->FETCH(PDO::FETCH_ASSOC))  {
                                  ?>
                                  <tr>
                                      <td><?php echo $PERIODOS_['idPeriodo']; ?></td>
                                      <td><?php echo $PERIODOS_['vPeriodo']; ?></td>
                                      <td>
                                          <?php 
                                            echo ($PERIODOS_['bActivo'] == 1 ? '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>');
                                          ?>
                                      </td>
                                      <td>
                                           <center>
                                                <button 
                                                    type="button"
                                                    data-idperiodo="<?php echo $PERIODOS_['idPeriodo']; ?>"
                                                    data-vperiodo="<?php echo $PERIODOS_['vPeriodo']; ?>"
                                                    class="editarPeriodo btn btn-primary btn-sm"
                                                    title="Editar Periodo">
                                                       <i class="fa fa-pencil"></i>
                                                </button>
                                            </center>
                                      </td>
                                      <td>  
                                          <center>
                                          <?php 
                                            echo ($PERIODOS_['bActivo'] == 1 ? '<button type="button" data-status="1" data-id="'.$PERIODOS_['idPeriodo'].'" class="cambiarStatus btn btn-danger btn-sm" title="Desactivar"><i class="fa fa-close"></i></button>' : '<button type="button" data-status="0" data-id="'.$PERIODOS_['idPeriodo'].'" class="cambiarStatus btn btn-success btn-sm" title="Activar"><i class="fa fa-check"></i></button>'); 
                                          ?>                                              
                                          </center>
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
    <script type="text/javascript">
        $(document).ready(function(){
          $("#panelRegistroEdicion").hide();

          $("#btnNuevoPeriodo").click(function(){
            $("#panelRegistroEdicion").hide(150);
            clearFields();
            $("#panelRegistroEdicion").show(150);
          });

          $("#cancelarRegistro").click(function(){
            $("#panelRegistroEdicion").hide(150);
            clearFields();
          });

          $(".editarPeriodo").click(function(){
            $("#panelRegistroEdicion").hide(150);
            clearFields();
            $("#idPeriodo").val($(this).data("idPeriodo"));
            $("#vPeriodo").val($(this).data("vperiodo"));
            $("#panelRegistroEdicion").show(150);
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
            $("#idPeriodo").val("0");
            $("#vPeriodo").val("");
        }
    </script>
</body>
</html>
