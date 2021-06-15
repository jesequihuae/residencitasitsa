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
    <!-- DataTable CSS -->
    <link href="../css/jquery.treeview.css" rel="stylesheet" type="text/css">
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
            if(!$ObjectITSA->checkPermission("revision_seguimientos")) {
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
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h2 class="panel-title">
                            <div id="txtHeadingRegistroAlumnos">Alumnos en proceso</div>
                        </h2>
                    </div> 
                    <div class="panel-body">
                    <div class="table-responsive">
                    <table class="table table-hover" id="dtAlumnos">
                        <thead>
                            <th>Numero de Control</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Proceso</th>
                            <th>Detalle</th>
                        </thead>
                        <?php
                            $ALUMNOS_SEGUIMIENTO = $ObjectITSA->getAlumnosEnSeguimiento();
                            while($alumnos = $ALUMNOS_SEGUIMIENTO->FETCH(PDO::FETCH_ASSOC))  {
                        ?>
                        <tr>
                            <td><?php echo $alumnos['vNumeroControl']; ?></td>
                            <td><?php echo $alumnos['vNombre']; ?></td>
                            <td><?php echo $alumnos['vApellidoPaterno']; ?></td>
                            <td><?php echo $alumnos['vApellidoMaterno']; ?></td>
                            <td><?php echo $alumnos['Descripcion']; ?></td>
                            <td>
                                <form method="POST" action="revision_seguimientos">
                                    <input name="idalumno" type="hidden" value="<?php echo $alumnos["idAlumno"];?>" />
                                    <input name="idproceso" type="hidden" value="<?php echo $alumnos["idProceso"];?>" />
                                    <button class="btn btn-primary">Detalle</button>
                                </form>
                            </td>
                            <td>
                        </td>
                        </tr>
                    <?php } ?>
                    </table>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12" style="display:<?php if($_POST){ echo "block"; } else { echo "none"; } ?>">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h2 class="panel-title">
                            <div id="txtDetalle">Detalle</div>
                        </h2>
                    </div> 
                    <div class="panel-body">
                        <?php 
                            if($_POST["idproceso"] == 1){
                                
                            }
                        ?>
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
<!--TREEVIEW-->
<script src="../js/jquery.treeview.js"></script>
<!-- DataTable CSS -->
<script src="../js/datatable.min.js"></script>
<!--JQUERY TREEVIEW-->
<script src="../js/datatable.min.js"></script>

<script>
    
</script>
</body>
</html>
