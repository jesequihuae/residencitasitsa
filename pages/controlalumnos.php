<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="utf-8"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Control de alumnos</title>

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

    <link rel="shortcut icon" href="../img/logo.ico" />
    <link rel="stylesheet" href="../css/ItsaStyle.css" />

    <!-- ALERTIFY JS-->
    <script src="../js/alertify.min.js"></script>
    <link rel="stylesheet" href="../css/alertify.min.css" />
    <link rel="stylesheet" href="../css/default.min.css" />

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
                    <?php
                        if(isset($_POST) && isset($_POST['guardarAlumno'])) {
                            if($_POST['idAlumno'] == 0) {

                                $SC = (isset($_POST['bServicioSocial']) ? '1' : '0');
                                $ME = (isset($_POST['bMateriasEspecial']) ? '1' : '0');
                                $AC = (isset($_POST['bActividadesComplementarias']) ? '1' : '0');

                                $ObjectITSA->registrarAlumno(
                                    $_POST['idCarrera'],
                                    $_POST['idSexo'],
                                    $_POST['vNumeroControl'],
                                    $_POST['vNombre'],
                                    $_POST['vApellidoPaterno'],
                                    $_POST['vApellidoMaterno'],
                                    $_POST['vSemestre'],
                                    $_POST['vPlanEstudios'],
                                    $_POST['dFechaIngreso'],
                                    $_POST['dFechaTermino'],
                                    $_POST['iCreditosTotales'],
                                    $_POST['iCreditosAcumulados'],
                                    $_POST['fPorcentaje'],
                                    $_POST['idPeriodo'],
                                    $_POST['fPromedio'],
                                    $_POST['vSituacion'],
                                    $SC,
                                    $AC,
                                    $ME,
                                    $_POST['vCorreoInstitucional'],
                                    $_POST['dFechaNacimiento']
                                );
                            } else {

                                $SC = (isset($_POST['bServicioSocial']) ? '1' : '0');
                                $ME = (isset($_POST['bMateriasEspecial']) ? '1' : '0');
                                $AC = (isset($_POST['bActividadesComplementarias']) ? '1' : '0');

                                $ObjectITSA->actualizarAlumno(
                                    $_POST['idAlumno'],
                                    $_POST['idCarrera'],
                                    $_POST['idSexo'],
                                    $_POST['vNumeroControl'],
                                    $_POST['vNombre'],
                                    $_POST['vApellidoPaterno'],
                                    $_POST['vApellidoMaterno'],
                                    $_POST['vSemestre'],
                                    $_POST['vPlanEstudios'],
                                    $_POST['dFechaIngreso'],
                                    $_POST['dFechaTermino'],
                                    $_POST['iCreditosTotales'],
                                    $_POST['iCreditosAcumulados'],
                                    $_POST['fPorcentaje'],
                                    $_POST['idPeriodo'],
                                    $_POST['fPromedio'],
                                    $_POST['vSituacion'],
                                    $SC,
                                    $AC,
                                    $ME,
                                    $_POST['vCorreoInstitucional'],
                                    $_POST['dFechaNacimiento']
                                );
                            }
                        }
                    ?>
                </div>
            </div>

            <!-- ... Your content goes here ... -->
            <section id="panelRegistroEdicion">
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
                                           <select class="form-control" name="idSexo" id="idSexo">
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
                                        <label class="control-label col-lg-3">Carrera</label>
                                        <div class="col-lg-9">
                                            <?php
                                                $CARRERAS_QUERY = $ObjectITSA->getCarreras();
                                            ?>
                                            <select class="form-control" name="idCarrera" id="idCarrera">
                                                <?php while($CARRERAS_ = $CARRERAS_QUERY->FETCH(PDO::FETCH_ASSOC))  { ?>
                                                    <option value="<?php echo $CARRERAS_['idCarrera'] ?>"><?php echo $CARRERAS_['vClave'].' - '.$CARRERAS_['vCarrera']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Plan de Estudios:</label>
                                       <div class="col-lg-9">
                                            <input type="text" class="form-control" name="vPlanEstudios" id="vPlanEstudios" placeholder="Plan de Estudios" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Situación:</label>
                                       <div class="col-lg-9">
                                            <input type="text" class="form-control" name="vSituacion" id="vSituacion" placeholder="Situación" required>
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
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Porcentaje:</label>
                                       <div class="col-lg-9">
                                            <input type="text" class="form-control" name="fPorcentaje" id="fPorcentaje" placeholder="Porcentaje" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Periodo:</label>
                                       <div class="col-lg-9">
                                            <!--<input type="text" class="form-control" name="iPeriodo" id="iPeriodo" placeholder="Periodo" required>-->
                                            <?php
                                                $periodos = $ObjectITSA->getAllPeriodos();
                                            ?>
                                            <select class="form-control" name="idPeriodo" id="idPeriodo">
                                                <?php while($row = $periodos->FETCH(PDO::FETCH_ASSOC))  { ?>
                                                    <option value="<?php echo $row['idPeriodo'] ?>"><?php echo $row['vPeriodo']; ?></option>
                                                <?php } ?>
                                            </select>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Promedio:</label>
                                       <div class="col-lg-9">
                                            <input type="text" class="form-control" name="fPromedio" id="fpromedio" placeholder="Promedio" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Correo Institucional:</label>
                                       <div class="col-lg-9">
                                            <input type="text" class="form-control" name="vCorreoInstitucional" id="vCorreoInstitucional" placeholder="Correo Institucional" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Fecha Ingreso:</label>
                                       <div class="col-lg-9">
                                            <input type="date" class="form-control" name="dFechaIngreso" id="dFechaIngreso" placeholder="Fecha Ingreso" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Fecha Termino:</label>
                                       <div class="col-lg-9">
                                            <input type="date" class="form-control" name="dFechaTermino" id="dFechaTermino" placeholder="Fecha Termino" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Fecha Nacimiento:</label>
                                       <div class="col-lg-9">
                                            <input type="date" class="form-control" name="dFechaNacimiento" id="dFechaNacimiento" placeholder="Fecha de Nacimiento" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Servicio Social:</label>
                                       <div class="col-lg-9">
                                            <input type="checkbox" class="form-control" name="bServicioSocial" id="bServicioSocial">
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Actividades Complementarias:</label>
                                       <div class="col-lg-9">
                                            <input type="checkbox" class="form-control" name="bActividadesComplementarias" id="bActividadesComplementarias">
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Materias Especial:</label>
                                       <div class="col-lg-9">
                                            <input type="checkbox" class="form-control" name="bMateriasEspecial" id="bMateriasEspecial">
                                       </div>
                                    </div>
                                    <button type="button" class="btn btn-default" id="cancelarRegistro"><i class="fa fa-times-circle"></i> Cancelar</button>
                                    <button type="submit" class="btn btn-info pull-right" name="guardarAlumno"><i class="fa fa-paper-plane"></i> Guardar</button>
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
                                 <table class="table table-hover" id="dtAlumnos">
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
                                         <th>Editar</th>
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
                                         <td>
                                            <center>
                                                <button
                                                    onclick="editarAl(this)"
                                                    type="button"
                                                    data-idalumno="<?php echo $ALUMNOS_['idAlumno']; ?>"
                                                    data-idcarrera="<?php echo $ALUMNOS_['idCarrera']; ?>"
                                                    data-bsexo="<?php echo $ALUMNOS_['bSexo']; ?>"
                                                    data-vnumerocontrol="<?php echo $ALUMNOS_['vNumeroControl']; ?>"
                                                    data-vnombre="<?php echo $ALUMNOS_['vNombre']; ?>"
                                                    data-vapellidopaterno="<?php echo $ALUMNOS_['vApellidoPaterno']; ?>"
                                                    data-vapellidomaterno="<?php echo $ALUMNOS_['vApellidoMaterno']; ?>"
                                                    data-vsemestre="<?php echo $ALUMNOS_['vSemestre']; ?>"
                                                    data-vplanestudios="<?php echo $ALUMNOS_['vPlanEstudios']; ?>"
                                                    data-dfechaingreso="<?php echo $ALUMNOS_['dFechaIngreso']; ?>"
                                                    data-dfechatermino="<?php echo $ALUMNOS_['dFechaTermino']; ?>"
                                                    data-icreditostotales="<?php echo $ALUMNOS_['iCreditosTotales']; ?>"
                                                    data-icreditosacumulados="<?php echo $ALUMNOS_['iCreditosAcumulados']; ?>"
                                                    data-fporcentaje="<?php echo $ALUMNOS_['fPorcentaje']; ?>"
                                                    data-idperiodo="<?php echo $ALUMNOS_['iPeriodo']; ?>"
                                                    data-fpromedio="<?php echo $ALUMNOS_['fPromedio']; ?>"
                                                    data-vsituacion="<?php echo $ALUMNOS_['vSituacion']; ?>"
                                                    data-bserviciosocial="<?php echo $ALUMNOS_['bServicioSocial']; ?>"
                                                    data-bactividadescomplementarias="<?php echo $ALUMNOS_['bActividadesComplementarias']; ?>"
                                                    data-bmateriaespecial="<?php echo $ALUMNOS_['bMateriasEspecial']; ?>"
                                                    data-vcorreoinstitucional="<?php echo $ALUMNOS_['vCorreoInstitucional']; ?>"
                                                    data-dfechaNacimiento="<?php echo $ALUMNOS_['dFechaNacimiento']; ?>"
                                                    class="editarAlumno btn btn-primary btn-sm"
                                                    title="Editar Alumno">
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
        $(document).ready(function(){
          $("#dtAlumnos").DataTable({
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
          $("#panelRegistroEdicion").hide();

          $("#btnNuevoAlumno").click(function() {
            $("#panelRegistroEdicion").hide(200);
            clearFields();
            $("#panelRegistroEdicion").show(200);
          });

          $("#cancelarRegistro").click(function(){
            $("#panelRegistroEdicion").hide(200);
            clearFields();
          });

        //  $(".editarAlumno").click(function(){

        });
        function editarAl(e){
            $("#panelRegistroEdicion").hide(200);
            clearFields();
            $("#idAlumno").val($(e).data("idalumno"));
            $("#vNombre").val($(e).data("vnombre"));
            $("#vApellidoPaterno").val($(e).data("vapellidopaterno"));
            $("#vApellidoMaterno").val($(e).data("vapellidomaterno"));
            $("#vNumeroControl").val($(e).data("vnumerocontrol"));
            $("#vSemestre").val($(e).data("vsemestre"));
            $("#vPlanEstudios").val($(e).data("vplanestudios"));
            $("#vSituacion").val($(e).data("vsituacion"));
            $("#iCreditosTotales").val($(e).data("icreditostotales"));
            $("#iCreditosAcumulados").val($(e).data("icreditosacumulados"));
            $("#fPorcentaje").val($(e).data("fporcentaje"));
            $("#idPeriodo").val($(e).data("idperiodo"));
            $("#fpromedio").val($(e).data("fpromedio"));
            $("#vCorreoInstitucional").val($(e).data("vcorreoinstitucional"));
            $("#dFechaIngreso").val($(e).data("dfechaingreso"));
            $("#dFechaTermino").val($(e).data("dfechatermino"));
            $("#dFechaNacimiento").val($(e).data("dfechanacimiento"));
            if($(e).data("bserviciosocial") == '0'){
                $("#bServicioSocial").prop('checked', false);
            } else {
                $("#bServicioSocial").prop('checked', true);
            }
            if($(e).data("bactividadescomplementarias") == '0'){
                $("#bActividadesComplementarias").prop('checked', false);
            } else {
                $("#bActividadesComplementarias").prop('checked', true);
            }
            if($(e).data("bmateriaespecial") == '0'){
                $("#bMateriasEspecial").prop('checked', false);
            } else {
                $("#bMateriasEspecial").prop('checked', true);
            }
            $("#panelRegistroEdicion").show(200);
          //});
        }
        function clearFields(){
            $("#idAlumno").val("0");
            $("#vNombre").val("");
            $("#vApellidoPaterno").val("");
            $("#vApellidoMaterno").val("");
            $("#vNumeroControl").val("");
            $("#vSemestre").val("");
            $("#vPlanEstudios").val("");
            $("#vSituacion").val("");
            $("#iCreditosTotales").val("");
            $("#iCreditosAcumulados").val("");
            $("#fPorcentaje").val("");
            $("#iPeriodo").val("");
            $("#fpromedio").val("");
            $("#vCorreoInstitucional").val("");
            $("#dFechaIngreso").val("");
            $("#dFechaTermino").val("");
            $("#dFechaNacimiento").val("");
            $("#bServicioSocial").prop('checked', false);
            $("#bActividadesComplementarias").prop('checked', false);
            $("#bMateriasEspecial").prop('checked', false);
        }
    </script>
</body>
</html>
