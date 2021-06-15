<?php
	include '../php/connection.php';
	$carreras = $ObjectITSAFiles->getCarreras();

	$periodos = $ObjectITSAFiles->getPeriodos();

?>

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
<link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../css/jquery.datetimepicker.css" type="text/css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/styleFiles.css">
<!-- ALERTIFY JS-->
<script src="../js/alertify.min.js"></script>
<link rel="stylesheet" href="../css/alertify.min.css" />
<link rel="stylesheet" href="../css/default.min.css" />

<link rel="shortcut icon" href="../img/logo.ico" />

<link rel="stylesheet" href="../css/ItsaStyle.css" />


<div id="wrapper">
  <div id="page-wrapper">
      <div class="container-fluid">
        <!-- Navigation -->
        <?php include('../modules/navbar.php'); ?>
        <?php
            include '../php/connection.php';
            if($ObjectITSA->checkSession()){
                if(!$ObjectITSA->checkPermission("adminEvaluacionesPorSeguimiento")) {
                    echo '<script language = javascript> self.location = "javascript:history.back(-1);" </script>';
                    exit;
                }
            } else {
                echo '<script language = javascript> self.location = "javascript:history.back(-1);" </script>';
                exit;
            }
        ?>
            <?php 
                if(isset($_POST["guardarSeguimiento"])){
                    $ObjectITSA1->saveEvaluacion($_POST["idTipoDeDocumento"],$_FILES["file"],$_SESSION["idUsuario"]);
                }
            ?>
            <div class="col-md-12" style="margin-top:40px;">

                <table class="table table-bordered">
                    <tr>
                        <th>ID Documento</th>
                        <th>Nombre</th>
                        <th>Evaluación</th>
                        <th>Cargado</th>
                    </tr>
                    <?php foreach($ObjectITSA1->getSeguimientos() as $row){ ?>
                        <tr>
                            <td><?php echo $row["idTipoDocumento"]; ?></td>
                            <td><?php echo $row["vNombre"]; ?></td>
                            <td>
                                <form method="POST" enctype="multipart/form-data">
                                    <input type="file" name="file" /> 
                                    <input type="hidden" name="idTipoDeDocumento" value="<?php echo $row["idTipoDocumento"]; ?>" />
                                    <input type="submit" class="btn btn-primary" value="Guardar" name="guardarSeguimiento" />
                                </form>
                            </td>
                            <td>
                                <?php if($row["cargado"] == 1){ ?>
                                    <i class="fa fa-check-circle-o fa-4x" aria-hidden="true"></i>
                                <?php }else{ ?>
                                    <i class="fa fa-exclamation-triangle fa-4x" aria-hidden="true"></i>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
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


