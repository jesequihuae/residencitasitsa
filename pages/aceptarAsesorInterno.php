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

<div id="wrapper">
  <div id="page-wrapper">
      <div class="container-fluid">
        <!-- Navigation -->
        <?php include('../modules/navbar.php'); ?>
        <?php
            include '../php/connection.php';
            if($ObjectITSA->checkSession()){

                if(!$ObjectITSA->checkPermission("aceptarAsesorInterno")) {
                    echo '<script language = javascript> self.location = "javascript:history.back(-1);" </script>';
                    exit;
                }
            } else {
                echo '<script language = javascript> self.location = "javascript:history.back(-1);" </script>';
                exit;
            }
        ?>
        <div class="col-md-12" style="margin-top:40px;">
            <table class="table table-bordered">
                <th>Nombre</th>
            </table>
        </div>
        <?php
            //echo "maickol";
            //print_r($ObjectITSA1->getAlumnosByIdAsesor($_SESSION["idUsuario"]));
        ?>
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


