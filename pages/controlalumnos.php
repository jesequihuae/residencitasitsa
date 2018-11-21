<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="utf-8"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Alumnos</title>

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
            if(!$ObjectITSA->checkPermission("controlalumnos")) {
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
                    <h1 class="page-header"><i class="fa fa-user"></i> Alumnos </h1>
                   
                </div>
            </div>

            <!-- ... Your content goes here ... --> 
            <section id="registroAlumnos">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h2 class="panel-title">
                                   <div id="txtHeadingRegistroAlumnos">Registrar Alumno</div>
                                </h2>
                            </div>
                            <div class="panel-body">
                                 <form class="form-horizontal" method="POST">
                                    <input type="hidden" name="idAlumno" id="idAlumno" value="0">
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Nombre:</label>
                                       <div class="col-lg-9">
                                           <input type="text" class="form-control" name="vNombre" id="vNombre" placeholder="Nombre" required>
                                       </div>                                    
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Apellido Paterno:</label>
                                       <div class="col-lg-9">
                                           <input type="text" class="form-control" name="vApellidoPaterno" id="vApellidoPaterno" placeholder="Apellido Paterno" required>
                                       </div>                                    
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Apellido Materno:</label>
                                       <div class="col-lg-9">
                                           <input type="text" class="form-control" name="vApellidoMaterno" id="vApellidoMaterno" placeholder="Apellido Materno">
                                       </div>                                    
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Sexo:</label>
                                       <div class="col-lg-9">
                                           <select class="form-control">
                                               <option value="0">Femenino</option>
                                               <option value="1">Masculino</option>
                                           </select>
                                       </div>                                    
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Número control:</label>
                                       <div class="col-lg-9">
                                            <input type="text" class="form-control" name="vNumeroControl" id="vNumeroControl" placeholder="Número de Control" required>
                                       </div>                                    
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Semestre:</label>
                                       <div class="col-lg-9">
                                            <input type="number" min="0" max="20" class="form-control" name="vSemestre" id="vSemestre" placeholder="Semestre" required>
                                       </div>                                    
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Plan de Estudios:</label>
                                       <div class="col-lg-9">
                                            <input type="text" class="form-control" name="vPlanEstudios" id="vPlanEstudios" placeholder="Plan de Estudios" required>
                                       </div>                                    
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Plan de Estudios:</label>
                                       <div class="col-lg-9">
                                            <input type="text" class="form-control" name="vPlanEstudios" id="vPlanEstudios" placeholder="Plan de Estudios" required>
                                       </div>                                    
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Créditos Totales:</label>
                                       <div class="col-lg-9">
                                            <input type="number" class="form-control" name="iCreditosTotales" id="iCreditosTotales" placeholder="Créditos Totales" required>
                                       </div>                                    
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Créditos Acumulados:</label>
                                       <div class="col-lg-9">
                                            <input type="number" class="form-control" name="iCreditosAcumulados" id="iCreditosAcumulados" placeholder="Créditos Acumulados" required>
                                       </div>                                    
                                    </div>
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
                                <i class="fa fa-user"> Alumnos Registrados</i>
                            </h2>
                        </div>
                        <div class="panel-body">
                             <button type="button" class="btn btn-primary pull-right" id="btnNuevoAlumno">
                                <i class="fa fa-plus"></i> Nuevo Alumno
                             </button><br><br>
                             <div class="table-responsive">
                                 <table class="table table-hover">
                                     <thead>
                                         <th>ID</th>
                                         <th>Carrera</th>
                                         <th>Sexo</th>
                                         <th># Control</th>
                                         <th>Nombre</th>
                                         <th>Correo</th>
                                         <th>Semestre</th>
                                         <th>Plan de Estudios</th>
                                         <th>Creditos Totales</th>
                                         <th>Creditos Acumulados</th>
                                         <th>Porcentaje</th>
                                         <th>Periodo</th>
                                         <th>Situacion</th>
                                         <th>Servicio Social</th>
                                         <th>Actividades Complementarias</th>
                                         <th>Material en Especial</th>
                                         <th>Fecha Nacimiento</th>
                                         <th>Fecha Ingreso</th>
                                         <th>Fecha Termino</th>
                                     </thead>                                     
                                    <?php 
                                        $ALUMNOS_QUERY = $ObjectITSA->getAlumnos();
                                        while($ALUMNOS_ = $ALUMNOS_QUERY->FETCH(PDO::FETCH_ASSOC))  {
                                    ?>
                                     <tr>
                                         <td><?php echo $ALUMNOS_['idAlumno']; ?></td>
                                         <td><?php echo $ALUMNOS_['vCarrera']; ?></td>
                                         <td><?php echo ($ALUMNOS_['bSexo'] == 1 ? 'Masculino' : 'Femenino'); ?></td>
                                         <td><?php echo $ALUMNOS_['vNumeroControl']; ?></td>
                                         <td><?php echo $ALUMNOS_['vNombre'].' '.$ALUMNOS_['vApellidoPaterno'].' '.$ALUMNOS_['vApellidoMaterno']; ?></td>
                                         <td><?php echo $ALUMNOS_['vCorreoInstitucional']; ?></td>
                                         <td><?php echo $ALUMNOS_['vSemestre']; ?></td>
                                         <td><?php echo $ALUMNOS_['vPlanEstudios']; ?></td>
                                         <td><?php echo $ALUMNOS_['iCreditosTotales']; ?></td>
                                         <td><?php echo $ALUMNOS_['iCreditosAcumulados']; ?></td>
                                         <td><?php echo $ALUMNOS_['fPorcentaje']; ?></td>
                                         <td><?php echo $ALUMNOS_['iPeriodo']; ?></td>
                                         <td><?php echo $ALUMNOS_['vSituacion']; ?></td>
                                         <td><?php echo ($ALUMNOS_['bServicioSocial'] == 1 ? '<span class="label label-success"><i class="fa fa-check"></i></span>' : '<span class="label label-danger"><i class="fa fa-close"></i></span>'); ?></td>
                                         <td><?php echo ($ALUMNOS_['bActividadesComplementarias'] == 1 ? '<span class="label label-success"><i class="fa fa-check"></i></span>' : '<span class="label label-danger"><i class="fa fa-close"></i></span>'); ?></td>
                                         <td><?php echo ($ALUMNOS_['bMateriasEspecial']  == 1 ? '<span class="label label-success"><i class="fa fa-check"></i></span>' : '<span class="label label-danger"><i class="fa fa-close"></i></span>'); ?></td>
                                         <td><?php echo $ALUMNOS_['dFechaNacimiento']; ?></td>
                                         <td><?php echo $ALUMNOS_['dFechaIngreso']; ?></td>
                                         <td><?php echo $ALUMNOS_['dFechaTermino']; ?></td>
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
</body>
</html>
