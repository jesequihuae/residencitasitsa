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
            if(!$ObjectITSA->checkPermission("fileManager")) {
                echo '<script language = javascript> self.location = "javascript:history.back(-1);" </script>';
                exit;
            }
        } else {
            echo '<script language = javascript> self.location = "javascript:history.back(-1);" </script>';
            exit;
        }
    ?>

          <div class="col-md-2">
          	<div class="form-group">
          		<label>Numero de Control</label>
          		<input class="form-control" type="text" name="filter" id="filter" onkeyup="findUsers()">
          	</div>
          </div>
          <div class="col-md-2">
          	<div class="form-group">
          		<label>Carrera</label>
          		<select class="form-control" name="carreras" id="carreras">
          			<option value="0">Todos</option>
          			<?php foreach ($carreras as $c): ?>
          				<option value="<?php echo $c["idCarrera"]; ?>"><?php echo $c["vCarrera"] ?></option>
          			<?php endforeach ?>
          		</select>
          	</div>
          </div>
          <div class="col-md-2">
          	<div class="form-group">
          		<label>Periodo</label>
          		<select class="form-control" name="periodo" id="periodo">
          			<option value="0">Todos</option>
          			<?php foreach ($periodos as $p): ?>
          				<option value="<?php echo $p["idPeriodo"]; ?>"><?php echo $p["vPeriodo"] ?></option>
          			<?php endforeach ?>
          		</select>
          	</div>
          </div>
          <div class="row">
          	<div class="col-md-2">
          		<button class="btn btn-primary" style="margin-top: 25px;" onclick="return findUsers()">Buscar</button>
          	</div>
          </div>

          <div id="data"></div>
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
<script type="text/javascript">
		callAjax('',0,0);
		function findUsers(){
				$data 			= $("#filter").val();
				$idCarrera		= $("#carreras").val();
				$idPeriodo 		= $("#periodo").val();
				callAjax($data,$idCarrera,$idPeriodo);
		}

		function callAjax($data,$idCarrera,$idPeriodo){
			$.ajax({
				  type: "POST",
				  url: 'helper/obtenerArchivosAsync.php',
				  data: {
				  			filter:$data,
				  			idCarrera:$idCarrera,
				  			idPeriodo:$idPeriodo
				  		},
				  beforeSend: function(){
				  			$("#data").html('<center><img width="250" height="250" style="margin-top:50px;" src="../img/loader.gif" /></center>');
				  },
				  success: function($res){
				  	$("#data").html($res);
				  }
				});
		}

</script>
