<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="utf-8"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Control asesores externos</title>

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
    <?php 
        include '../php/connection.php';
        if($ObjectITSA->checkSession()){  
            if(!$ObjectITSA->checkPermission("controlasesorexterno")) {
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
                    <h1 class="page-header"><!-- <i class="fa fa-file-o"></i> --> Control de asesores externos </h1>
                    <?php 
                        if(isset($_POST['guardarUsuario'])) {
                            if($_POST['idAI'] == 0) {
                                $ObjectITSA->registrarAsesorExterno(
                                    $_POST['vUsuario'],
                                    $_POST['vContrasena']
                                );
                            } else {
                                $ObjectITSA->actualizarAsesorExterno(
                                    $_POST['idAI'],
                                    $_POST['vUsuario'],
                                    $_POST['vContrasena']
                                );
                            }
                        }
                        else if(isset($_POST['activarDesactivar'])) {
                            $ObjectITSA->changeStatusAsesorExterno(
                                $_POST['idUsuarioCambiarEstado'],
                                $_POST['currentStatus']
                            );
                        }
                    ?>
                </div>
            </div>

            <!-- ... Your content goes here ... --> 
            <section id="panelRegistroEdicionAI">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h2 class="panel-title">Asesor externo</h2>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" method="POST">
                                    <input type="hidden" name="idAI" id="idAI" value="0">
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Usuario:</label>
                                       <div class="col-lg-9">
                                           <input type="text" class="form-control" name="vUsuario" id="vUsuario" placeholder="Usuario" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Contraseña:</label>
                                       <div class="col-lg-9">
                                           <input type="text" class="form-control" name="vContrasena" id="vContrasena" placeholder="Contraseña" required>
                                       </div>
                                    </div>
                                    <button 
                                        type="button" 
                                        class="btn btn-default" 
                                        id="cancelarRegistro">
                                            <i class="fa fa-times-circle"></i> Cancelar
                                    </button>
                                    <button 
                                        type="submit" 
                                        class="btn btn-info pull-right" 
                                        name="guardarUsuario">
                                            <i class="fa fa-paper-plane"></i> Guardar
                                    </button>
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
                                
                            </h2>
                        </div>
                        <div class="panel-body">
                        <button type="button" class="btn btn-primary pull-right" id="btnNuevoAsesor">
                                <i class="fa fa-plus"></i> Nuevo asesor
                          </button><br><br>
                            <div class="table-responsive">
                                <table class="table table-hover" id="AITable">
                                    <thead>
                                        <!-- <th>ID</th> -->
                                        <th>Usuario</th>
                                        <th>Contraseña</th>
                                        <th>Estado</th>
                                        <th><center>Editar</center></th>
                                        <th><center>Status</center></th>
                                    </thead>
                                    <?php 
                                        $AI_QUERY = $ObjectITSA->getAsesoresExternos();
                                        while($AI_QUERY_ = $AI_QUERY->FETCH(PDO::FETCH_ASSOC))  {
                                    ?>
                                    <tbody>
                                        <td><?php echo $AI_QUERY_['vUsuario']; ?></td>
                                        <td><?php echo $AI_QUERY_['vContrasena']; ?></td>
                                        <td>
                                          <?php
                                            echo ($AI_QUERY_['bActivo'] == 1 ? '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>');
                                          ?>
                                        </td>
                                        <td align="center">
                                            <button
                                                  type="button"
                                                  data-idasesor="<?php echo $AI_QUERY_['idAsesor']; ?>"
                                                  data-asesor="<?php echo $AI_QUERY_['vUsuario']; ?>"
                                                  data-contrasena="<?php echo $AI_QUERY_['vContrasena']; ?>"
                                                  class="editarAsesor btn btn-primary btn-sm"
                                                  title="Editar asesor">
                                                     <i class="fa fa-pencil"></i>
                                              </button>
                                        </td>
                                        <td>
                                            <center>
                                                <?php
                                               echo ($AI_QUERY_['bActivo'] == 1 ? '<button type="button" data-status="1" data-id="'.$AI_QUERY_['idAsesor'].'" class="cambiarStatus btn btn-danger btn-sm" title="Desactivar"><i class="fa fa-close"></i></button>' : '<button type="button" data-status="0" data-id="'.$AI_QUERY_['idAsesor'].'" class="cambiarStatus btn btn-success btn-sm" title="Activar"><i class="fa fa-check"></i></button>');
                                             ?>
                                            </center>
                                        </td>
                                    </tbody>
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
            <input type="hidden" id="idUsuarioCambiarEstado" name="idUsuarioCambiarEstado">
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
     <script src="../js/datatable.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#panelRegistroEdicionAI").hide();
            $("#AITable").DataTable({
                "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron coincidencias",
                "info": "Página _PAGE_ de _PAGES_",
                "infoEmpty": "No se encontraron registros",
                "infoFiltered": "(filtrados de _MAX_ registros totales)",
                "search": "Buscar",
                "paginate": {
                    "first":      "Primera",
                    "last":       "Ultima",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                }   
              }
            });

            $("#cancelarRegistro").click(function() {
                $("#panelRegistroEdicionAI").hide(50);
                clearFields();
            });

            $(".editarAsesor").click(function(){
                $("#panelRegistroEdicionAI").hide(200);
                clearFields();
                $("#idAI").val($(this).data("idasesor"));
                $("#vUsuario").val($(this).data("asesor"));
                $("#vContrasena").val($(this).data("contrasena"));
                $("#panelRegistroEdicionAI").show(200);
              });

            $("#btnNuevoAsesor").click(function(){
                $("#panelRegistroEdicionAI").hide(200);
                clearFields();
                $("#panelRegistroEdicionAI").show(200);
            });

            $(".cambiarStatus").click(function(){
              var status = $(this).data("status");
              var id = $(this).data("id");
              $("#idUsuarioCambiarEstado").val(id);
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
            $("#idAI").val("0");
            $("#vUsuario").val("");
            $("#vContrasena").text("");
        }
    </script>
</body>
</html>
