<!DOCTYPE html>
<html lang="en">
<head>

    <link rel="stylesheet" type="text/css" href="https://cdn3.devexpress.com/jslib/18.2.4/css/dx.common.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn3.devexpress.com/jslib/18.2.4/css/dx.light.css" />
    <!-- <meta charset="utf-8"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Estadísticas</title>
</head>
<body>
<div id="wrapper">

    <!-- Navigation -->
    <?php include('../modules/navbar.php'); ?>
    <?php 
        include '../php/connection.php';
        if($ObjectITSA->checkSession()){  
            if(!$ObjectITSA->checkPermission("controlcarreras")) {
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
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-bar-chart"></i> Estadísticas </h1> 
                </div>
            </div>
            <ul class="nav nav-tabs">
              <li class="active" onclick=""><a data-toggle="tab" href="#grafica1">Grafica de Opcion</a></li>
              <li onclick=""><a data-toggle="tab" href="#grafica2">Grafica de Giro</a></li>
              <li onclick=""><a data-toggle="tab" href="#grafica3">Grafica de Sector</a></li>
            </ul>
            
            <div class="tab-content">

              <div id="grafica1" class="tab-pane fade  in active">
                <?php include 'grafica1.php' ?>
              </div>

              <div id="grafica2" class="tab-pane fade">
                <?php include 'grafica2.php' ?>
              </div>

              <div id="grafica3" class="tab-pane fade">
                <?php include 'grafica3.php' ?>
              </div>

            </div>
        </div>
    </div>
</div>
</body>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.0/knockout-min.js"></script>
  <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/18.2.4/js/dx.all.js"></script>
  <script>
        /*function onClick(){
            setTimeout(function () {
                $("#chart").dxChart("instance").render().innerHTML;
                $("#chart2").dxChart("instance").render().innerHTML;
            },0);
        }*/
  </script>
</html>