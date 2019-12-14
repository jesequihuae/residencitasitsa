<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="utf-8"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Notificaciones</title>

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
    <link rel="stylesheet" href="../css/style.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div id="wrapper">

    <?php include('../modules/navbar.php'); ?>
    <?php
        include_once '../php/connection.php';
        if($ObjectITSA->checkSession()){
            if($_SESSION['tipoUsuario'] != 1) {
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

            <!-- ... Your content goes here ... --> 
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-user"></i> Alumnos </h1>
                
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <?php 
                    @session_start();
                        $NOTIFICACIONES_QUERY = $ObjectITSA->obtenerNotificacionesAlumno($_SESSION['idUsuario']);
                        while($NOTIFICACIONES_ = $NOTIFICACIONES_QUERY->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <?php if($NOTIFICACIONES_['bVista'] == 0) { ?>
                            <div class="panel panel-primary">
                                <div class="panel-heading">                                    
                                    <i class="fa fa-bell"></i> <?php echo $NOTIFICACIONES_['dFecha']; ?>
                                </div>
                                <div class="panel-body">
                                    <?php echo str_replace(array("\r\n", "\r", "\n"), "<br />",$NOTIFICACIONES_['tTexto']); ?>
                                </div>
                            </div>
                        <?php } else { ?>
                             <div class="panel panel-default">
                                <div class="panel-heading">                                   
                                    <i class="fa fa-bell-o"></i> <?php echo $NOTIFICACIONES_['dFecha']; ?>
                                </div>
                                <div class="panel-body">
                                    <?php echo str_replace(array("\r\n", "\r", "\n"), "<br />",$NOTIFICACIONES_['tTexto']); ?>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <!-- <?php $ObjectITSA->actualizarNotificacionesVistas($_SESSION['idUsuario']); ?> -->
                </div>
            </div>

        </div>
    </div>
</div>
    <!-- jQuery -->

    
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

    </script>

</body>
</html>
