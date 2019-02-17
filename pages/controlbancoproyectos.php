<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="utf-8"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Banco de Proyectos</title>

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
            if(!$ObjectITSA->checkPermission("controlbancoproyectos")) {
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
                   <h1 class="page-header"><i class="fa fa-briefcase"></i> Banco de Proyectos </h1>
                   <?php
                    if(isset($_POST) && isset($_POST['guardarProyecto'])) {
                        if($_POST['idBancoProyecto'] == 0) {
                            $ObjectITSA->registrarProyecto(
                                $_POST['idEmpresa'],
                                $_POST['idCarrera'],
                                $_POST['idEstado'],
                                $_POST['idPeriodo'],
                                $_POST['vNombreProyecto'],
                                $_POST['vDescripcion'],
                                $_POST['vArea'],
                                $_POST['vPropuestaDe'],
                                $_POST['iTotalResidentes']
                            );
                        } else {
                            $ObjectITSA->actualizarProyecto(
                                $_POST['idBancoProyecto'],
                                $_POST['idEmpresa'],
                                $_POST['idCarrera'],
                                $_POST['idEstado'],
                                $_POST['idPeriodo'],
                                $_POST['vNombreProyecto'],
                                $_POST['vDescripcion'],
                                $_POST['vArea'],
                                $_POST['vPropuestaDe'],
                                $_POST['iTotalResidentes']
                            );
                        }
                    } else if(isset($_POST) && isset($_POST['activarDesactivar'])) {
                        $ObjectITSA->cambiarEstadoProyecto(
                            $_POST['idBancoProyectoCambiasStatus'],
                            $_POST['currentStatus']
                        );
                    }
                   ?>
                </div>
            </div>

            <!-- ... Your content goes here ... -->
            <section id="panelRegistroEdicion">
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-2">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h2 class="panel-title">
                                    Proyecto
                                </h2>
                            </div>
                            <div class="panel-body">
                                <form method="post" class="form-horizontal">
                                    <input type="hidden" name="idBancoProyecto" id="idBancoProyecto" value="0">
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Empresa:</label>
                                       <div class="col-lg-9">
                                          <select id="idEmpresa" name="idEmpresa" class="form-control">
                                              <?php
                                                $EMPRESAS_QUERY = $ObjectITSA->getAllEmpresas();
                                                while($EMPRESAS_ = $EMPRESAS_QUERY->FETCH(PDO::FETCH_ASSOC))  {
                                              ?>
                                                <option value="<?php echo $EMPRESAS_['idEmpresa']; ?>"><?php echo $EMPRESAS_['vNombreEmpresa']; ?></option>
                                              <?php } ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Carrera:</label>
                                       <div class="col-lg-9">
                                          <select id="idCarrera" name="idCarrera" class="form-control">
                                              <?php
                                                $CARRERAS_QUERY = $ObjectITSA->getAllCarreras();
                                                while($CARRERAS_ = $CARRERAS_QUERY->FETCH(PDO::FETCH_ASSOC))  {
                                                    if($CARRERAS_['bActivo'] == 1) {
                                              ?>
                                                <option value="<?php echo $CARRERAS_['idCarrera']; ?>"><?php echo $CARRERAS_['vCarrera']; ?></option>
                                              <?php
                                                    }
                                                 }
                                                ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Periodo:</label>
                                       <div class="col-lg-9">
                                          <select id="idPeriodo" name="idPeriodo" class="form-control">
                                              <?php
                                                $PERIODOS_QUERY = $ObjectITSA->getAllPeriodos();
                                                while($PERIODOS_ = $PERIODOS_QUERY->FETCH(PDO::FETCH_ASSOC))  {
                                                    if($PERIODOS_['bActivo'] == 1) {
                                              ?>
                                                <option value="<?php echo $PERIODOS_['idPeriodo']; ?>"><?php echo $PERIODOS_['vPeriodo']; ?></option>
                                              <?php
                                                    }
                                                 }
                                                ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Disponibilidad:</label>
                                       <div class="col-lg-9">
                                          <select id="idEstado" name="idEstado" class="form-control">
                                              <?php
                                                $ESTADOS_QUERY = $ObjectITSA->getAllEstados();
                                                while($ESTADOS_ = $ESTADOS_QUERY->FETCH(PDO::FETCH_ASSOC))  {
                                                    if($ESTADOS_['idEstado'] == 1 || $ESTADOS_['idEstado'] == 2) {
                                              ?>
                                                <option value="<?php echo $ESTADOS_['idEstado']; ?>"><?php echo $ESTADOS_['vEstado']; ?></option>
                                              <?php
                                                    }
                                                 }
                                                ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Proyecto:</label>
                                       <div class="col-lg-9">
                                           <input type="text" class="form-control" name="vNombreProyecto" id="vNombreProyecto" placeholder="Nombre de Proyecto" required>
                                       </div>
                                    </div>
                                     <div class="form-group">
                                       <label class="control-label col-lg-3">Descripción:</label>
                                       <div class="col-lg-9">
                                           <textarea class="form-control" name="vDescripcion" id="vDescripcion" required></textarea>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Área:</label>
                                       <div class="col-lg-9">
                                           <input type="text" class="form-control" name="vArea" id="vArea" placeholder="Area" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Propuesta de:</label>
                                       <div class="col-lg-9">
                                           <input type="text" class="form-control" name="vPropuestaDe" id="vPropuestaDe" placeholder="Propuesta de" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Total de residentes:</label>
                                       <div class="col-lg-9">
                                           <input type="number" min="0" class="form-control" name="iTotalResidentes" id="iTotalResidentes" placeholder="Total de Residentes" required>
                                       </div>
                                    </div>
                                    <button type="button" class="btn btn-default" id="cancelarRegistro"><i class="fa fa-times-circle"></i> Cancelar</button>
                                    <button type="submit" class="btn btn-info pull-right" name="guardarProyecto"><i class="fa fa-paper-plane"></i> Guardar</button>
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
                          <h2 class="panel-title">Proyectos registrados</h2>
                      </div>
                      <div class="panel-body">
                        <div class="form-group">
                            <input type="file" name="file" required>
                        </div>
                          <button type="button" class="btn btn-primary pull-right" id="btnNuevoProyecto">
                                <i class="fa fa-plus"></i> Nuevo Proyecto
                          </button>
                          <button type="button" class="btn btn-success pull-right" id="btnSubirExcel">
                                <i class="fa fa-plus"></i> Subir Excel
                          </button><br><br>
                          <div class="table-responsive">
                              <table class="table table-hover" id="dtControlProyectos">
                                  <thead>
                                      <th>ID</th>
                                      <th>Empresa</th>
                                      <th>Carrera</th>
                                      <th>Disponibilidad</th>
                                      <th>Proyecto</th>
                                      <th>Descripcion</th>
                                      <th>Area</th>
                                      <th>Propuesta</th>
                                      <th># Residentes</th>
                                      <th>Estado</th>
                                      <th>Operaciones</th>
                                  </thead>
                                  <?php
                                    $PROYECTOS_QUERY = $ObjectITSA->getAllProyectos();
                                    while($PROYECTOS_ = $PROYECTOS_QUERY->FETCH(PDO::FETCH_ASSOC))  {
                                  ?>
                                  <tr>
                                    <td><?php echo $PROYECTOS_['idBancoProyecto']; ?></td>
                                    <td><?php echo $PROYECTOS_['vNombreEmpresa']; ?></td>
                                    <td><?php echo $PROYECTOS_['vCarrera']; ?></td>
                                    <td><?php echo $PROYECTOS_['vEstado']; ?></td>
                                    <td><?php echo $PROYECTOS_['vNombreProyecto']; ?></td>
                                    <td><?php echo $PROYECTOS_['vDescripcion']; ?></td>
                                    <td><?php echo $PROYECTOS_['vArea']; ?></td>
                                    <td><?php echo $PROYECTOS_['vPropuestaDe']; ?></td>
                                    <td><?php echo $PROYECTOS_['iTotalResidentes']; ?></td>
                                    <td>
                                          <center>
                                              <?php
                                                echo ($PROYECTOS_['bActive'] == 1 ? '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>');
                                              ?>
                                          </center>
                                      </td>
                                      <td>
                                            <center>
                                                <button
                                                  class="editarProyecto btn btn-primary btn-sm"
                                                  data-idbancoproyecto="<?php echo $PROYECTOS_['idBancoProyecto']; ?>"
                                                  data-idempresa="<?php echo $PROYECTOS_['idEmpresa']; ?>"
                                                  data-idperiodo="<?php echo $PROYECTOS_['idPeriodo']; ?>"
                                                  data-idcarrera="<?php echo $PROYECTOS_['idCarrera']; ?>"
                                                  data-proyecto="<?php echo $PROYECTOS_['vNombreProyecto']; ?>"
                                                  data-idestado="<?php echo $PROYECTOS_['idEstado']; ?>"
                                                  data-descripcion="<?php echo $PROYECTOS_['vDescripcion']; ?>"
                                                  data-area="<?php echo $PROYECTOS_['vArea']; ?>"
                                                  data-propuestade="<?php echo $PROYECTOS_['vPropuestaDe']; ?>"
                                                  data-totalresidentes="<?php echo $PROYECTOS_['iTotalResidentes']; ?>  "
                                                  title="Editar"
                                                >
                                                  <i class="fa fa-pencil"></i>
                                                </button>
                                              &nbsp;
                                              <?php
                                                echo ($PROYECTOS_['bActive'] == 1 ? '<button type="button" data-status="1" data-id="'.$PROYECTOS_['idBancoProyecto'].'" class="cambiarStatus btn btn-danger btn-sm" title="Desactivar"><i class="fa fa-close"></i></button>' : '<button type="button" data-status="0" data-id="'.$PROYECTOS_['idBancoProyecto'].'" class="cambiarStatus btn btn-success btn-sm" title="Activar"><i class="fa fa-check"></i></button>');
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
            <input type="hidden" id="idBancoProyectoCambiasStatus" name="idBancoProyectoCambiasStatus">
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
          $("#dtControlProyectos").DataTable();
          $("#panelRegistroEdicion").hide();

          $("#btnNuevoProyecto").click(function(){
            $("#panelRegistroEdicion").hide(150);
            clearFields();
            $("#panelRegistroEdicion").show(150);
          });

          $("#cancelarRegistro").click(function() {
            $("#panelRegistroEdicion").hide(150);
            clearFields();
          });

          $(".editarProyecto").click(function(){
            $("#panelRegistroEdicion").hide(150);
            clearFields();
            $("#idBancoProyecto").val($(this).data("idbancoproyecto"));
            $("#idEmpresa").val(parseInt($(this).data("idempresa")));
            $("#idCarrera").val(parseInt($(this).data("idcarrera")));
            $("#idPeriodo").val(parseInt($(this).data("idperiodo")));
            $("#idEstado").val(parseInt($(this).data("idestado")));
            $("#vNombreProyecto").val($(this).data("proyecto"));
            $("#vDescripcion").val($(this).data("descripcion"));
            $("#vArea").val($(this).data("area"));
            $("#vPropuestaDe").val($(this).data("propuestade"));
            $("#iTotalResidentes").val(parseInt($(this).data("totalresidentes")));
            $("#panelRegistroEdicion").show(150);
          });

           $(".cambiarStatus").click(function(){
              var status = $(this).data("status");
              var id = $(this).data("id");
              $("#idBancoProyectoCambiasStatus").val(id);
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
            $("#idBancoProyecto").val("0");
            $("#idEmpresa").val(parseInt("1"));
            $("#idCarrera").val(parseInt("1"));
            $("#idPeriodo").val(parseInt("1"));
            $("#vNombreProyecto").val("");
            $("#vDescripcion").val("");
            $("#vArea").val("");
            $("#vPropuestaDe").val("");
            $("#iTotalResidentes").val("");
        }
    </script>
</body>
</html>
