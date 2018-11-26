<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="utf-8"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Proyectos</title>

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
            if(!$ObjectITSA->checkPermission("controlempresas")) {
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
                   <h1 class="page-header"><i class="fa fa-briefcase"></i> Empresas </h1>
                   <?php 
                        if(isset($_POST) && isset($_POST['guardarEmpresa'])) {
                            if($_POST['idEmpresa'] == 0) {
                                $ObjectITSA->registrarEmpresa(
                                    $_POST['vNombreEmpresa'],
                                    $_POST['vCorreoElectronico'],
                                    $_POST['vDireccion'],
                                    $_POST['vTitular'],
                                    $_POST['vContacto']
                                );
                            } else {
                                $ObjectITSA->actualizarEmpresa(
                                    $_POST['idEmpresa'],
                                    $_POST['vNombreEmpresa'],
                                    $_POST['vCorreoElectronico'],
                                    $_POST['vDireccion'],
                                    $_POST['vTitular'],
                                    $_POST['vContacto']
                                );
                            }
                        } 
                   ?>
                </div>
            </div>

            <!-- ... Your content goes here ... --> 
            <section id="panelRegistroEdicion">
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h2 class="panel-title">
                                    Empresas
                                </h2>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" method="POST">
                                    <input type="hidden" name="idEmpresa" id="idEmpresa" value="0">
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Nombre Empresa:</label>
                                       <div class="col-lg-9">
                                           <input type="text" class="form-control" name="vNombreEmpresa" id="vNombreEmpresa" placeholder="Nombre de Empresa" required>
                                       </div>                                    
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Correo Electrónico:</label>
                                       <div class="col-lg-9">
                                           <input type="email" class="form-control" name="vCorreoElectronico" id="vCorreoElectronico" placeholder="Correo Electrónico" required>
                                       </div>                                    
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Direccion:</label>
                                       <div class="col-lg-9">
                                           <textarea class="form-control" id="vDireccion" name="vDireccion" required></textarea>
                                       </div>                                    
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Titular:</label>
                                       <div class="col-lg-9">
                                           <input type="text" class="form-control" name="vTitular" id="vTitular" placeholder="Titular" required>
                                       </div>                                    
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Contacto:</label>
                                       <div class="col-lg-9">
                                           <input type="text" class="form-control" name="vContacto" id="vContacto" placeholder="Contacto" required>
                                       </div>                                    
                                    </div>
                                    <button 
                                        type="button" 
                                        class="btn btn-default" 
                                        id="cancelarRegistro">
                                            <i class="fa fa-times-circle"></i> 
                                        Cancelar
                                    </button>
                                    <button 
                                        type="submit" 
                                        class="btn btn-info pull-right" 
                                        name="guardarEmpresa">
                                        <i class="fa fa-paper-plane"></i> 
                                        Guardar
                                    </button>
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
                              Empresas
                          </h2>
                      </div>
                      <div class="panel-body">
                          <button type="button" class="btn btn-primary pull-right" id="btnNuevaEmpresa">
                                <i class="fa fa-plus"></i> Nueva empresa
                          </button><br><br>
                          <div class="table-responsive">
                              <table class="table table-hover">
                                  <thead>
                                      <th>ID</th>
                                      <th>Nombre</th>
                                      <th>Correo Electrónico</th>
                                      <th>Dirección</th>
                                      <th>Titular</th>
                                      <th>Contacto</th>
                                      <th>Editar</th>
                                  </thead>
                                  <?php 
                                    $EMPRESAS_QUERY = $ObjectITSA->getAllEmpresas();
                                    while($EMPRESAS_ = $EMPRESAS_QUERY->FETCH(PDO::FETCH_ASSOC))  {
                                  ?>
                                  <tr>
                                      <td><?php echo $EMPRESAS_['idEmpresa']; ?></td>
                                      <td><?php echo $EMPRESAS_['vNombreEmpresa']; ?></td>
                                      <td><?php echo $EMPRESAS_['vCorreoElectronico']; ?></td>
                                      <td><?php echo $EMPRESAS_['vDireccion']; ?></td>
                                      <td><?php echo $EMPRESAS_['vTitular']; ?></td>
                                      <td><?php echo $EMPRESAS_['vContacto']; ?></td>
                                      <td>
                                           <center>
                                                <button 
                                                    type="button"
                                                    data-idempresa="<?php echo $EMPRESAS_['idEmpresa']; ?>"
                                                    data-nombre="<?php echo $EMPRESAS_['vNombreEmpresa']; ?>"
                                                    data-correoelectronico="<?php echo $EMPRESAS_['vCorreoElectronico']; ?>"
                                                    data-direccion="<?php echo $EMPRESAS_['vDireccion']; ?>"
                                                    data-titular="<?php echo $EMPRESAS_['vTitular']; ?>"
                                                    data-contacto="<?php echo $EMPRESAS_['vContacto']; ?>"
                                                    class="editarEmpresa btn btn-primary btn-sm"
                                                    title="Editar Periodo">
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
    <script type="text/javascript">
        $(document).ready(function(){
          $("#panelRegistroEdicion").hide();

          $("#btnNuevaEmpresa").click(function(){
            $("#panelRegistroEdicion").hide(150);
            clearFields();
            $("#panelRegistroEdicion").show(150);
          });

          $("#cancelarRegistro").click(function() {
            $("#panelRegistroEdicion").hide(150);
            clearFields();
          });

          $(".editarEmpresa").click(function(){
            $("#panelRegistroEdicion").hide(150);
            clearFields();
            $("#idEmpresa").val($(this).data("idempresa"));
            $("#vNombreEmpresa").val($(this).data("nombre"));
            $("#vCorreoElectronico").val($(this).data("correoelectronico"));
            $("#vDireccion").val($(this).data("direccion"));
            $("#vTitular").val($(this).data("titular"));
            $("#vContacto").val($(this).data("contacto"));
            $("#panelRegistroEdicion").show(150);
          });
        });

        function clearFields(){
            $("#idEmpresa").val("0");
            $("#vNombreEmpresa").val("");
            $("#vCorreoElectronico").val("");
            $("#vDireccion").val("");
            $("#vTitular").val("");
            $("#vContacto").val("");
        }
    </script>
</body>
</html>
