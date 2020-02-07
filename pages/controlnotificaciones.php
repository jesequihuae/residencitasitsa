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
    <link rel="stylesheet" href="../css/bootstrap-select.min.css">
    <link rel="stylesheet" href="../css/style.css">

    <!-- ALERTIFY JS-->
    <link  href="../css/alertify.min.css" rel="stylesheet" type="text/css">

    <!-- Default theme -->
    <link rel="stylesheet" href="../css/themes/default.min.css"/>

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
        include_once '../php/connection.php';
        if($ObjectITSA->checkSession()){
            if(!$ObjectITSA->checkPermission("controlnotificaciones")) {
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
                   <h1 class="page-header"><i class="fa fa-bell"></i> Notificaciones </h1>
                </div>
            </div>

            <div class="row">
                <?php 
                    if(isset($_POST['guardarRegistro'])) {
                        if($_POST['asignacion'] == 'A')
                            $ObjectITSA->guardarNotificacion(
                                $_POST['idAlumno'],
                                $_POST['vAviso']
                            );

                        if($_POST['asignacion'] == 'P')
                            $ObjectITSA->guardarNotificacion(
                                $_POST['idAlumno'],
                                $_POST['vAviso'],
                                true,
                                $_POST['idPeriodo']
                            );

                        print_r($_POST);
                    }
                ?>
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" method="POST">
                                 <center id="opcionesAlerta">
                          <label class="radio-inline">
                          <input type="radio" name="asignacion" checked value="A">Por Alumno
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="asignacion" value="P">Por Periodo
                          </label>
                        </center><br>
                                <div class="form-group" id="panelPorPeriodo">
                                  <label for="inputEmail4" class="control-label col-lg-3">Periodo:</label>
                                  <div class="col-lg-9">
                                    <select class="form-control selectpicker" data-live-search="true" name="idPeriodo" id="idPeriodo" required>
                                      <?php foreach ($ObjectITSA->getAllPeriodos() as $r) { ?>
                                          <option value="<?php echo $r["idPeriodo"]; ?>">
                                            <?php echo $r["vPeriodo"]; ?>
                                          </option>
                                      <?php  } ?>
                                    </select>
                                  </div>
                                </div>

                                <div class="form-group" id="panelPorAlumno">
                                  <label for="inputEmail4" class="control-label col-lg-3"># Control:</label>
                                  <div class="col-lg-9">
                                    <select class="form-control selectpicker" data-live-search="true" name="idAlumno" id="idAlumno" required>
                                      <?php foreach ($ObjectITSA->obtenerNumerosDeControl() as $r) { ?>
                                          <option value="<?php echo $r["idAlumno"]; ?>">
                                            <?php echo $r["vNumeroControl"] . ' - ' . $r["vNombre"] .' '. $r["vApellidoPaterno"] . ' ' . $r["vApellidoMaterno"]; ?>
                                          </option>
                                      <?php  } ?>
                                    </select>
                                  </div>
                                </div> 
                                <div class="form-group">
                                    <label class="control-label col-lg-3">Mensaje:</label>
                                    <div class="col-lg-9">
                                        <textarea class="form-control" name="vAviso" id="vAviso" placeholder="Mensaje" required></textarea>
                                    </div>                                    
                                </div>
                                <!-- <div class="form-group">
                                    <label class="control-label col-lg-3">¿Generar alerta?:</label>
                                    <div class="col-lg-9">
                                        <input type="checkbox" value="">
                                    </div>
                                </div> -->
                                <button 
                                    type="submit" 
                                    class="btn btn-info pull-right" 
                                    name="guardarRegistro">
                                        <i class="fa fa-paper-plane"></i> Guardar
                                </button>
                            </form>
                        </div>
                    </div>
            </div>

            <!-- ... Your content goes here ... -->

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
    <script src="../js/bootstrap-select.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#panelPorPeriodo").hide();

            $("input[name=asignacion]").click(function () {
                if($(this).val() == 'A') {
                  $("#panelPorPeriodo").hide(100);
                  $("#panelPorAlumno").show(100);
                }
                if($(this).val() == 'P') {
                  $("#panelPorAlumno").hide(100);
                  $("#panelPorPeriodo").show(100);
                }
            });
        });
    </script>
</body>
</html>
