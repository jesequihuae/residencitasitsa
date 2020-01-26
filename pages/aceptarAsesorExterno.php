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

                if(!$ObjectITSA->checkPermission("aceptarAsesorExterno")) {
                    echo '<script language = javascript> self.location = "javascript:history.back(-1);" </script>';
                    exit;
                }
            } else {
                echo '<script language = javascript> self.location = "javascript:history.back(-1);" </script>';
                exit;
            }
        ?>
        <div class="col-md-12" style="margin-top:40px;">
            <table class="table table-bordered" id="dtAlumos">
                <thead>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Numero de control</th>
                    <th>Correo</th>
                    <th>Seguimientos</th>
                </thead>
                <?php foreach($ObjectITSA1->getAlumnosByIdAsesor($_SESSION["idUsuario"]) AS $row){ ?>
                    <tr>
                        <td><?php echo $row["vNombre"]; ?></td>
                        <td><?php echo $row["vApellidoPaterno"]; ?></td>
                        <td><?php echo $row["vApellidoMaterno"]; ?></td>
                        <td><?php echo $row["vNumeroControl"]; ?></td>
                        <td><?php echo $row["vCorreoInstitucional"]; ?></td>
                        <td><button class="btn btn-success"  data-idAlumno = "<?php echo $row["idAlumno"]; ?>" onclick="verSeguimientos(this)">Ver</button></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <?php
            //echo "maickol";
            //print_r($ObjectITSA1->getAlumnosByIdAsesor($_SESSION["idUsuario"]));
        ?>
        </div>
     </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalSeguimientos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Sesguimientos</h4>
      </div>
      <div class="modal-body">
        <div id="bodySeguimientos"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button> 
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
<!-- DataTable CSS -->
<script src="../js/datatable.min.js"></script>
<script>    
    $(document).ready(function(){
        $("#dtAlumos").DataTable();
    });
    function verSeguimientos(e){
        var idAlumno        = $(e).attr("data-idalumno");
        console.log(idAlumno);
        $.ajax({
            url:"../php/helper.class.php",
            type:"POST",
            data:{
                "operacion":6,
                "idAlumno":idAlumno
            },
            beforeSend:function(e){

            },
            success:function(e){
                $("#bodySeguimientos").html(e);
            },
            error:function(e){
                console.log(e);
            }
        });
        $("#modalSeguimientos").modal("show");
    }

    function aceptar(e){
        var idDocumento = $(e).attr("data-idDocumento");
        $.ajax({
            url:"../php/helper.class.php",
            type:"POST",
            data:{
                "operacion":7,
                "idDocumento":idDocumento,
                "rechazar":0
            },
            beforeSend:function(e){

            },
            success:function(e){
                console.log(e);
            },
            error:function(e){
                console.log(e);
            }
        });
    }
    function rechazar(e){
        var idDocumento = $(e).attr("data-idDocumento");
        $.ajax({
            url:"../php/helper.class.php",
            type:"POST",
            data:{
                "operacion":7,
                "idDocumento":idDocumento,
                "rechazar":1
            },
            beforeSend:function(e){

            },
            success:function(e){
                console.log(e);
            },
            error:function(e){
                console.log(e);
            }
        });
    }
</script>