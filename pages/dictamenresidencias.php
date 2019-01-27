<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="utf-8"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Dictámenes de Residencias</title>

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
            if(!$ObjectITSA->checkPermission("dictamenresidencias")) {
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
                    <h1 class="page-header"><i class="fa fa-briefcase"></i> Dictámenes de Residencias </h1>
                   
                </div>
            </div>

            <!-- ... Your content goes here ... --> 
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h2 class="panel-title"> Anteproyectos Aceptados</h2>
                    </div> 
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="dtAceptados">
                                <thead>
                                    <th>ID</th>
                                    <th>Control</th>
                                    <th>Nombre Alumno</th>
                                    <th>Correo</th>
                                    <th>Telefono</th>
                                    <th>Sexo</th>
                                    <th>Anteproyecto</th>
                                    <th>Empresa/Dependencia</th>
                                    <th>Asesor Interno</th>
                                    <th>Asesor Externo</th>
                                </thead>
                                <tbody>
                                    <?php
                                        $ACEPTADOS_QUERY = $ObjectITSA->getDictamenAceptados();
                                        while($ACEPTADOS_ = $ACEPTADOS_QUERY->FETCH(PDO::FETCH_ASSOC))  {
                                    ?>
                                    <tr>
                                        <td><?php echo $ACEPTADOS_['idAlumno']; ?></td>
                                        <td><?php echo $ACEPTADOS_['vNumeroControl']; ?></td>
                                        <td><?php echo $ACEPTADOS_['vNombre'].' '.$ACEPTADOS_['vApellidoPaterno'].' '.$ACEPTADOS_['vApellidoMaterno']; ?></td>
                                        <td><?php echo $ACEPTADOS_['vCorreoInstitucional']; ?></td>
                                        <td><?php echo $ACEPTADOS_['telefono']; ?></td>
                                        <td><?php echo ($ACEPTADOS_['bSexo'] == 0 ? 'H' : 'M') ?></td>
                                        <td><?php echo $ACEPTADOS_['vNombreProyecto']; ?></td>
                                        <td><?php echo $ACEPTADOS_['vNombreEmpresa']; ?></td>
                                        <td><?php echo $ACEPTADOS_['asesorInterno']; ?></td>
                                        <td><?php echo $ACEPTADOS_['asesorExterno']; ?></td>
                                    </tr>
                                    <?php 
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h2 class="panel-title"> Anteproyectos Rechazados</h2>
                    </div> 
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="dtRechazados">
                                <thead>
                                    <th>ID</th>
                                    <th>Control</th>
                                    <th>Nombre Alumno</th>
                                    <th>Correo</th>
                                    <th>Telefono</th>
                                    <th>Sexo</th>
                                    <th>Anteproyecto</th>
                                    <th>Empresa/Dependencia</th>
                                    <th>Asesor Interno</th>
                                    <th>Asesor Externo</th>
                                </thead>
                                <tbody>
                                    <?php
                                        $RECHAZADOS_QUERY = $ObjectITSA->getDictamenRechazados();
                                        while($RECHAZADOS_ = $RECHAZADOS_QUERY->FETCH(PDO::FETCH_ASSOC))  {
                                    ?>
                                    <tr>
                                        <td><?php echo $RECHAZADOS_['idAlumno']; ?></td>
                                        <td><?php echo $RECHAZADOS_['vNumeroControl']; ?></td>
                                        <td><?php echo $RECHAZADOS_['vNombre'].' '.$RECHAZADOS_['vApellidoPaterno'].' '.$RECHAZADOS_['vApellidoMaterno']; ?></td>
                                        <td><?php echo $RECHAZADOS_['vCorreoInstitucional']; ?></td>
                                        <td><?php echo $RECHAZADOS_['telefono']; ?></td>
                                        <td><?php echo ($RECHAZADOS_['bSexo'] == 0 ? 'H' : 'M') ?></td>
                                        <td><?php echo $RECHAZADOS_['vNombreProyecto']; ?></td>
                                        <td><?php echo $RECHAZADOS_['vNombreEmpresa']; ?></td>
                                        <td><?php echo $RECHAZADOS_['asesorInterno']; ?></td>
                                        <td><?php echo $RECHAZADOS_['asesorExterno']; ?></td>
                                    </tr>
                                    <?php 
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
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
    <script src="../js/datatable.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#dtAceptados").DataTable();
            $("#dtRechazados").DataTable();
        });
    </script>
</body>
</html>
