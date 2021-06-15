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
<div id="wrapper" style="margin-top:30px;"> 

    <!-- Navigation -->
    <?php include('../modules/navbar.php'); ?>
    <?php
        include '../php/connection.php';
        if($ObjectITSA->checkSession()){
            if(!$ObjectITSA->checkPermission("admin_usuarios")) {
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
         <?php 
            if(isset($_POST) && isset($_POST['guardarUsuario'])) {
                $idUsuario      = $_POST["idUsuario"];
                $Nombre         = $_POST["vNombre"];
                $Contrasenia    = $_POST["vContrasenia"];
                $idTipoUsuario  = $_POST["idTipoUsuario"];
                $idCarrera      = $_POST["idCarrera"];

                $bActive     = (isset($_POST['bActive']) ? '1' : '0');
                if($_POST['idUsuario'] == 0) {
                    $ObjectITSA->registroUsuario
                    (
                        $Nombre,
                        $Contrasenia,
                        $idTipoUsuario,
                        $bActive,
                        $idCarrera
                    );
                }else{
                    
                    $ObjectITSA->actualizarUsuario
                    (
                        $idUsuario,
                        $Nombre,
                        $Contrasenia,
                        $idTipoUsuario,
                        $bActive,
                        $idCarrera
                    );
                }

            }
         ?>
                <!-- ... Your content goes here ... -->
                <section id="panelRegistroUsuario">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h2 class="panel-title">
                                   <div id="txtHeadingRegistroAlumnos">Usuario</div>
                                </h2>
                            </div>
                            <div class="panel-body">
                                 <form class="form-horizontal" method="POST">
                                    <input type="hidden" name="idUsuario" id="idUsuario" value="0">
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Usuario:</label>
                                       <div class="col-lg-9">
                                           <input type="text" class="form-control" name="vNombre" id="vNombre" placeholder="Nombre" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Tipo de Usuario:</label>
                                        <div class="col-lg-9">
                                        <select class="form-control selectpicker" data-live-search="true" name="idTipoUsuario" id="idTipoUsuario" required>
                                        <?php foreach ($ObjectITSA->getTipoUsuario() as $r) { ?>
                                            <option value="<?php echo $r["idTipoUsuario"]; ?>"><?php echo $r["vTipoUsuario"]; ?></option>
                                        <?php  } ?>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="frmCarrera" style="display:none;">
                                        <label class="control-label col-lg-3">Carrera:</label>
                                        <div class="col-lg-9">
                                        <select class="form-control selectpicker" data-live-search="true" name="idCarrera" id="idCarrera" required>
                                        <?php foreach ($ObjectITSA->getCarreras() as $r) { ?>
                                            <option value="<?php echo $r["idCarrera"]; ?>"><?php echo $r["vCarrera"]; ?></option>
                                        <?php  } ?>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Contraseña:</label>
                                       <div class="col-lg-9">
                                           <input type="text" class="form-control" name="vContrasenia" id="vContrasenia" placeholder="Contraseña " required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Repite la Contraseña:</label>
                                       <div class="col-lg-9">
                                           <input type="text" class="form-control" name="vRepContrasenia" id="vRepContrasenia" placeholder="Repite la contraseña" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Activo:</label>
                                       <div class="col-lg-9">
                                            <input type="checkbox" class="form-control" name="bActive" id="bActive">
                                       </div>
                                    </div>
                                    <button type="button" class="btn btn-default" id="cancelarRegistro"><i class="fa fa-times-circle"></i> Cancelar</button>
                                    <button type="submit" class="btn btn-info pull-right" name="guardarUsuario"><i class="fa fa-paper-plane"></i> Guardar</button>
                                 </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h2 class="panel-title">
                                <i class="fa fa-user"> Usuarios </i>
                            </h2>
                        </div>
                        <div class="panel-body">
                        <button type="button" class="btn btn-primary pull-right" id="btnNuevoUsuario">
                                <i class="fa fa-plus"></i> Nuevo Usuario
                             </button><br><br>
                             <div class="table-responsive">
                                 <table class="table table-hover" id="dtUsuarios">
                                     <thead>
                                         <th>ID</th>
                                         <th>Usuario</th>
                                         <th>Tipo Usuario</th>
                                         <th>Activo</th>
                                         <th>Editar</th>
                                     </thead>
                                    <?php
                                        $USUARIOS_QUERY = $ObjectITSA->getUsuarios();
                                        while($usuarios = $USUARIOS_QUERY->FETCH(PDO::FETCH_ASSOC))  {
                                    ?>
                                     <tr>
                                         <td><?php echo $usuarios['idUsuario']; ?></td>
                                         <td><?php echo $usuarios['vUsuario']; ?></td>
                                         <td><?php echo $usuarios['vTipoUsuario']; ?></td>
                                         <td><?php echo $usuarios['bActivo']; ?></td>
                                         <td>
                                            <center>
                                                <button
                                                    onclick="editar(this)"
                                                    type="button"
                                                    data-idUsuario="<?php echo $usuarios['idUsuario']; ?>"
                                                    data-vUsuario="<?php echo $usuarios['vUsuario']; ?>"
                                                    data-idTipoUsuario="<?php echo $usuarios['idTipoUsuario']; ?>"
                                                    data-vContrasena="<?php echo $usuarios['vContrasena']; ?>"
                                                    data-bActivo="<?php echo $usuarios['bActivo']; ?>"
                                                    data-idCarrera="<?php echo $usuarios['idCarrera']; ?>"
                                                    class="editar btn btn-primary btn-sm"
                                                    title="Editar Usuario">
                                                       <i class="fa fa-pencil"></i>
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
    $("#dtUsuarios").DataTable();
    $("#panelRegistroUsuario").hide();
    

    $("#idTipoUsuario").change((e) => {
        if($("#idTipoUsuario").val() ==  3){
            $("#frmCarrera").attr("style","display:block");
        }else{
            $("#frmCarrera").attr("style","display:none");
        }
    });

    $("#btnNuevoUsuario").click(function() {
            $("#panelRegistroUsuario").hide(200);
            //clearFields();
            $("#panelRegistroUsuario").show(200);
          });

          $("#cancelarRegistro").click(function(){
            $("#panelRegistroUsuario").hide(200);
            //clearFields();
          });
    function editar(e){
            $("#panelRegistroUsuario").hide(200);
            //clearFields();
            $("#vNombre").val($(e).data("vusuario"));
            $("#idUsuario").val($(e).data("idusuario"));
            $("#idTipoUsuario").val($(e).data("idtipousuario"));
            if($(e).data("idtipousuario") == 3){
                $("#frmCarrera").attr("style","display:block");
                $("#idCarrera").val($(e).data("idcarrera"));
            }else{
                $("#frmCarrera").attr("style","display:none");
            }
            $("#vContrasenia").val($(e).data("vcontrasena"));
            $("#vRepContrasenia").val($(e).data("vcontrasena"));
            if($(e).data("bactivo") == '0'){
                $("#bActive").prop('checked', false);
            } else {
                $("#bActive").prop('checked', true);
            } 
            $("#panelRegistroUsuario").show(200);
          //});
        }
</script>
</body>
</html>
