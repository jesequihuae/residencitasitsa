<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="utf-8"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Control ODT</title>

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
        include '../php/connection.php';
        if($ObjectITSA->checkSession()){  
            if(!$ObjectITSA->checkPermission("controlodt")) {
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
                    <h1 class="page-header"><!-- <i class="fa fa-file-o"></i> --> Control ODT </h1>
                    <?php 
                        if(isset($_POST) && isset($_POST['guardarOdt'])){
                            #Actualizar
                            $ObjectITSA->actualizarODT(
                                $_POST['idOdt'],
                                $_POST['vNombreOdt'],
                                $_POST['rutaOdt'],
                                $_FILES['FileODT']
                            );
                        }
                    ?>
                </div>
            </div>

            <!-- ... Your content goes here ... --> 
            <section id="panelRegistroEdicionOdt">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h2 class="panel-title"><i class="fa fa-file-o"></i>  ODT</h2>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="idOdt" id="idOdt" value="0">
                                    <input type="hidden" name="rutaOdt" id="rutaOdt" value="">
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">Nombre:</label>
                                       <div class="col-lg-9">
                                           <input type="text" class="form-control" name="vNombreOdt" id="vNombreOdt" placeholder="Nombre" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3">ODT:</label>
                                       <div class="col-lg-9">
                                           <input type="file" accept=".odt" name="FileODT" id="FileODT">
                                           <p class="help-block"><div id="textFileInput"></div></p>
                                       </div>
                                    </div>
                                    <button type="button" class="btn btn-default" id="cancelarRegistro"><i class="fa fa-times-circle"></i> Cancelar</button>
                                    <button type="submit" class="btn btn-info pull-right" name="guardarOdt"><i class="fa fa-paper-plane"></i> Guardar</button>
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
                                <i class="fa fa-file-o"></i>  Control ODT's
                            </h2>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="odtTable">
                                    <thead>
                                        <!-- <th>ID</th> -->
                                        <th>Nombre</th>
                                        <th>Ruta</th>
                                        <th><center>Descargar</center></th>
                                        <th><center>Editar</center></th>
                                    </thead>
                                    <?php 
                                        $ODT_QUERY = $ObjectITSA->getAllODT();
                                        while($ODT_ = $ODT_QUERY->FETCH(PDO::FETCH_ASSOC))  {
                                    ?>
                                    <tbody>
                                        <td><?php echo $ODT_['vNombreOdt']; ?></td>
                                        <td><?php echo $ODT_['vRuta']; ?></td>
                                        <td>
                                            <center>
                                                <a href="../php/downloadodt.php?name=<?php echo $ODT_['vNombreOdt'].'.odt'; ?>&file=../pages/exportFilesTbsOdt/filesOdt/<?php echo $ODT_['vRuta']; ?>" class="btn btn-xs btn-info" title="Descargar Archivo">
                                                    <i class="fa fa-cloud-download"></i>
                                                </a>
                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                                <button 
                                                    type="button"
                                                    data-idodt="<?php echo $ODT_['idOdt']; ?>"
                                                    data-vnombre="<?php echo $ODT_['vNombreOdt']; ?>"
                                                    data-ruta="<?php echo $ODT_['vRuta']; ?>"
                                                    class="btn btn-info btn-xs editarOdt" 
                                                    title="Editar">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                            </center>
                                        </td>
                                    </tbody>
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
     <script src="../js/datatable.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#panelRegistroEdicionOdt").hide({
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

            $("#cancelarRegistro").click(function() {
                $("#panelRegistroEdicionOdt").hide(50);
                clearFields();
            });

            $(".editarOdt").click(function(){
                $("#panelRegistroEdicionOdt").hide(200);
                clearFields();
                $("#textFileInput").text("Si no se selecciona un archivo se dejará el existente.");
                $("#idOdt").val($(this).data("idodt"));
                $("#vNombreOdt").val($(this).data("vnombre"));
                $("#rutaOdt").val($(this).data("ruta"));
                $("#panelRegistroEdicionOdt").show(200);
              });
        });

        function clearFields(){
            $("#idOdt").val("0");
            $("#vNombreOdt").val("");
            $("#textFileInput").text("");
            $('#FileODT').prop('required', false);
        }
    </script>
</body>
</html>
