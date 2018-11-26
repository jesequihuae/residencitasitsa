<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="utf-8"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Fechas</title>

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
            if(!$ObjectITSA->checkPermission("controlfechas")) {
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
                    <h1 class="page-header"><i class="fa fa-briefcase"></i> Fechas </h1>
                <?php 
                    if(isset($_POST) && isset($_POST['guardarFecha'])){
                        if($_POST['idFechaEntregaPeriodo']== 0){
                            $ObjectITSA->registrarFechaPeriodo(
                                    $_POST['idPeriodo'],
                                    $_POST['vDescripcion'],
                                    $_POST['dFechaInicioEntrega'],
                                    $_POST['dFechaFinalEntrega']
                            );
                        } else {
                            $ObjectITSA->actualizarFechaPeriodo(
                                    $_POST['idFechaEntregaPeriodo'],
                                    $_POST['idPeriodo'],
                                    $_POST['vDescripcion'],
                                    $_POST['dFechaInicioEntrega'],
                                    $_POST['dFechaFinalEntrega'] 
                            );
                        }
                    } 
                    else if(isset($_POST) && isset($_POST['eliminarFecha'])){
                       $ObjectITSA->eliminarFechaPeriodo($_POST['idFechaEliminar']);
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
                                    Fechas
                                </h2>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" method="POST">
                                    <input type="hidden" name="idFechaEntregaPeriodo" id="idFechaEntregaPeriodo" value="0">
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Periodo:</label>
                                       <div class="col-lg-9">
                                           <select class="form-control" id="idPeriodo" name="idPeriodo">
                                                <?php 
                                                    $PERIODOS_QUERY = $ObjectITSA->getAllPeriodos();
                                                    while($PERIODO_ = $PERIODOS_QUERY->FETCH(PDO::FETCH_ASSOC))  {
                                                        if($PERIODO_['bActivo'] == 1){
                                                ?>
                                                    <option value="<?php echo $PERIODO_['idPeriodo']; ?>"><?php echo $PERIODO_['vPeriodo']; ?></option>
                                                <?php 
                                                        }
                                                    } 
                                                ?>
                                           </select>
                                       </div>                                    
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Descripción:</label>
                                       <div class="col-lg-9">
                                           <input type="text" class="form-control" name="vDescripcion" id="vDescripcion" placeholder="Descripción" required>
                                       </div>                                    
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Fecha de Inicio:</label>
                                       <div class="col-lg-9">
                                           <input type="date" class="form-control" name="dFechaInicioEntrega" id="dFechaInicioEntrega" placeholder="Fecha inicio entrega" required>
                                       </div>                                    
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Fecha Final:</label>
                                       <div class="col-lg-9">
                                           <input type="date" class="form-control" name="dFechaFinalEntrega" id="dFechaFinalEntrega" placeholder="Fecha Final entrega" required>
                                       </div>                                    
                                    </div>
                                    <button type="button" class="btn btn-default" id="cancelarRegistro"><i class="fa fa-times-circle"></i> Cancelar</button>
                                    <button type="submit" class="btn btn-info pull-right" name="guardarFecha"><i class="fa fa-paper-plane"></i> Guardar</button>
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
                          <h2 class="panel-title">Fechas registradas</h2>
                      </div>
                      <div class="panel-body">
                          <button type="button" class="btn btn-primary pull-right" id="btnNuevaFecha">
                                <i class="fa fa-plus"></i> Nueva Fecha
                          </button><br><br>
                          <div class="table-responsive">
                              <table class="table table-hover">
                                  <thead>
                                    <th>ID</th>
                                    <th>Periodo</th>
                                    <th>Descripcion</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Final</th>
                                    <th colspan="2"><center>Operaciones</center></th>
                                  </thead>
                                  <?php 
                                    $FECHAS_QUERY = $ObjectITSA->getAllFechasEntrega();
                                    while($FECHAS_ = $FECHAS_QUERY->FETCH(PDO::FETCH_ASSOC))  {
                                  ?>
                                  <tr>
                                      <td><?php echo $FECHAS_['idFechaEntregaPeriodo']; ?></td>
                                      <td><?php echo $FECHAS_['vPeriodo']; ?></td>
                                      <td><?php echo $FECHAS_['vDescripcion']; ?></td>
                                      <td><?php echo $FECHAS_['dFechaInicioEntrega']; ?></td>
                                      <td><?php echo $FECHAS_['dFechaFinalEntrega']; ?></td>
                                      <td>
                                           <center>
                                                <button 
                                                    type="button"
                                                    data-idfechaentregaperiodo="<?php echo $FECHAS_['idFechaEntregaPeriodo']; ?>"
                                                    data-idperiodo="<?php echo $FECHAS_['idPeriodo']; ?>"
                                                    data-vdescripcion="<?php echo $FECHAS_['vDescripcion']; ?>"
                                                    data-dfechainicioentrega="<?php echo $FECHAS_['dFechaInicioEntrega']; ?>"
                                                    data-dfechafinalentrega="<?php echo $FECHAS_['dFechaFinalEntrega']; ?>"
                                                    class="editarFecha btn btn-primary btn-sm"
                                                    title="Editar Fecha">
                                                       <i class="fa fa-pencil"></i>
                                                </button>
                                            </center>
                                      </td>
                                      <td>
                                        <center>
                                          <button
                                            type="button"
                                            data-idfecha="<?php echo $FECHAS_['idFechaEntregaPeriodo']; ?>"
                                            class="eliminarFecha btn btn-danger btn-sm"
                                            >
                                            <i class="fa fa-trash"></i>
                                          </button>
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

    <!-- MODAL ELIMINAR-->
    <div class="modal" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Atención!</h4>
          </div>
          <div class="modal-body" align="center">
            <input type="hidden" id="idFechaEliminar" name="idFechaEliminar">
            <center><h2>¿Está seguro de eliminar?</h2></center>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning pull-right" data-dismiss="modal">No</button>
            <button type="submit" class="btn btn-success" name="eliminarFecha" id="btnEliminarFecha">Sí</button>&nbsp;&nbsp;&nbsp;
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

          $("#btnNuevaFecha").click(function(){
            $("#panelRegistroEdicion").hide();
            clearFields();
            $("#panelRegistroEdicion").show(150);
          });

          $("#cancelarRegistro").click(function(){
            $("#panelRegistroEdicion").hide(150);
            clearFields();
          });

          $(".editarFecha").click(function(){
            $("#panelRegistroEdicion").hide(150);
            clearFields();
            $("#idFechaEntregaPeriodo").val($(this).data("idfechaentregaperiodo"));
            $("#idPeriodo").val(parseInt($(this).data("idperiodo")));
            $("#vDescripcion").val($(this).data("vdescripcion"));
            $("#dFechaInicioEntrega").val($(this).data("dfechainicioentrega"));
            $("#dFechaFinalEntrega").val($(this).data("dfechafinalentrega"));
            $("#panelRegistroEdicion").show(150);
          });

          $(".eliminarFecha").click(function(){
            $("#idFechaEliminar").val($(this).data("idfecha"))
            $("#modalEliminar").modal('show');
          });
        });

        function clearFields(){
            $("#idFechaEntregaPeriodo").val("0");
            $("#vDescripcion").val("");
            $("#dFechaFinalEntrega").val("");
            $("#dFechaInicioEntrega").val("");
        }
    </script>
</body>
</html>
