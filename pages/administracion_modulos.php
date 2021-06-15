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
            if(!$ObjectITSA->checkPermission("administracion_modulos")) {
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
            if(isset($_POST) && isset($_POST['guardarRegistro'])) {
                $idModulo   = $_POST["idModulo"];
                $nombre     = $_POST["vNombre"];
                $bActive    = (isset($_POST['bActive']) ? '1' : '0');
                if($_POST['idModulo'] == 0) {
                    $ObjectITSA->registrarModulo
                    (
                        $nombre,
                        $bActive
                    );
                }else{
                    
                    $ObjectITSA->actualizarModulo
                    (
                        $idModulo,
                        $nombre,
                        $bActive
                    );
                }

            }
         ?>
                <!-- ... Your content goes here ... -->
                <section id="panelRegistroModulo">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h2 class="panel-title">
                                   <div id="txtHeadingRegistroAlumnos">Registrar Modulo</div>
                                </h2>
                            </div>
                            <div class="panel-body">
                                 <form class="form-horizontal" method="POST">
                                    <input type="hidden" name="idModulo" id="idModulo" value="0">
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Nombre:</label>
                                       <div class="col-lg-9">
                                           <input type="text" class="form-control" name="vNombre" id="vNombre" placeholder="Nombre" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Activo:</label>
                                       <div class="col-lg-9">
                                            <input type="checkbox" class="form-control" name="bActive" id="bActive">
                                       </div>
                                    </div>
                                    <button type="button" class="btn btn-default" id="cancelarRegistro"><i class="fa fa-times-circle"></i> Cancelar</button>
                                    <button type="submit" class="btn btn-info pull-right" name="guardarRegistro"><i class="fa fa-paper-plane"></i> Guardar</button>
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
                                <i class="fa fa-user"> Modulos </i>
                            </h2>
                        </div>
                        <div class="panel-body">
                        <button type="button" class="btn btn-primary pull-right" id="btnNuevoModulo">
                                <i class="fa fa-plus"></i> Nuevo Modulo
                             </button><br><br>
                             <div class="table-responsive">
                                 <table class="table table-hover" id="dtAlumnos">
                                     <thead>
                                         <th>ID</th>
                                         <th>Modulo</th>
                                         <th>Activo</th>
                                         <th>Editar</th>
                                     </thead>
                                    <?php
                                        $MODULOS_QUERY = $ObjectITSA->getModulos();
                                        while($modulos = $MODULOS_QUERY->FETCH(PDO::FETCH_ASSOC))  {
                                    ?>
                                     <tr>
                                         <td><?php echo $modulos['idModulo']; ?></td>
                                         <td><?php echo $modulos['vModulo']; ?></td>
                                         <td><?php echo $modulos['bActivo']; ?></td>
                                         <td>
                                            <center>
                                                <button
                                                    onclick="editar(this)"
                                                    type="button"
                                                    data-idModulo="<?php echo $modulos['idModulo']; ?>"
                                                    data-vModulo="<?php echo $modulos['vModulo']; ?>"
                                                    data-bActivo="<?php echo $modulos['bActivo']; ?>"
                                                    class="editar btn btn-primary btn-sm"
                                                    title="Editar Modulo">
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
    $("#dtAlumnos").DataTable();
    $("#panelRegistroModulo").hide();
    
    $("#btnNuevoModulo").click(function() {
            $("#panelRegistroModulo").hide(200);
            //clearFields();
            $("#panelRegistroModulo").show(200);
          });

          $("#cancelarRegistro").click(function(){
            $("#panelRegistroModulo").hide(200);
            //clearFields();
          });
    function editar(e){
            $("#panelRegistroModulo").hide(200);
            //clearFields();
            $("#idModulo").val($(e).data("idmodulo"));
            $("#vNombre").val($(e).data("vmodulo"));
             
            if($(e).data("bactivo") == '0'){
                $("#bActive").prop('checked', false);
            } else {
                $("#bActive").prop('checked', true);
            } 
            $("#panelRegistroModulo").show(200);
          //});
        }
</script>
</body>
</html>
