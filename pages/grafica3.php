<html>
<head>
  <title></title>

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
</head>
<body>
      <section id="pneldeRegistro3">
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h2 class="panel-title">
                                    <div id="txtHeadingRegistroCarreras">Table</div>
                                </h2>
                            </div>
                            <div class="panel-body" style="padding:10ps;">
                              <div class="table-responsive">
                                <table class="table table-hover">
                                  <thead>
                                      <th>Carrera</th>
                                      <th>Opcion</th>
                                      <th>Clave</th>
                                      <th>Total</th>
                                  <?php include '../php/connection.php'; 
                                  $idCarrera = $_POST['carreras'];
                                  $CARRERAS_QUERY = $ObjectITSA->graficaTotalGiro($idCarrera);
                                  foreach ($CARRERAS_QUERY as $key) {?>
                                  <tr> 
                                    <td> <?php print($key['Carrera']); ?> </td>
                                    <td> <?php print($key['Giro']); ?> </td>
                                    <td> <?php print($key['vClaveGiro']); ?> </td>
                                    <td> <?php print($key['Total']); ?> </td>
                                  </tr>
                                  <?php } ?>
                                </table>  
                              </div>
                                <form class="form-horizontal" method="POST">
                                    <button type="button" class="btn btn-default" id="cancerlarREgistro3"><i class="fa fa-times-circle"></i> Cancelar</button>
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
                                Grafica
                            </h2>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                              <div class="col-lg-5">
                                <?php
                                  $carreras = $ObjectITSA->getCarreras();
                                 ?>
                                <form class="form-inline" method="post">
                                  <select class="form-control" name="carreras2" id="carreras2">
                                   <?php foreach ($carreras as $c): ?>
                                      <option value="<?php echo $c["idCarrera"]; ?>">
                                        <?php echo $c["vCarrera"] ?>
                                      </option>
                                    <?php endforeach ?>
                                  </select>
                                </form>
                              </div>
                              <div class="col-lg-3">
                                <button 
                                  class="btn btn-primary" 
                                  onclick="return findData2()">
                                    <i class="fa fa-search"></i> Buscar
                                </button>
                              </div>
                              <!--<div class="clearfix"></div>-->
                              <div class="col-lg-4">
                                <button type="button" class="btn btn-primary pull-right" id="btnNuevaOpcion3">
                                      <i class="fa fa-table"></i> Tabla de Datos
                                </button>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-12">
                                <div class="demo-container col-lg-5">
                                  <div id="chart4"></div>
                                </div>
                                <div class="demo-container col-lg-6 col-lg-offset-1">
                                 <div id="chart5"></div>
                            
                                </div>
                              </div>
                                </div>
                        </div>
                    </div>
                </div>
              </div>
</body>

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
          $("#pneldeRegistro3").hide();
          $("#carreras").val($("#carreras option:first").val());

          $("#btnNuevaOpcion3").click(function(){
            $("#pneldeRegistro3").hide();
            clearFields();
            $("#pneldeRegistro3").show(150);
          });

          $("#cancerlarREgistro3").click(function() {
            $("#pneldeRegistro3").hide(50);
            clearFields();
          });
        });

        function clearFields(){
            $("#idOpcion").val("0");
            $("#vClave").val("");
            $("#vOpcion").val("");
        }
    </script>

<script>
  callAjaxSector($("#carreras2 option:first").val());
  callAjjacGraficaSector($("#carreras2 option:first").val());
  function findData2(){
      $idCarrera  = $("#carreras2").val();
      callAjaxSector($idCarrera);
      callAjjacGraficaSector($idCarrera);
  }

  $("#carreras2").change(function(){
        findData2();
  });

  function callAjaxSector($idCarrera){
      $.ajax({
      url:"../php/datos.php",
      type:"POST",
      data:{
        idCarrera:$idCarrera,
        opcion:"4"
      },
      beforeSend:function(e){
      },
      success: function(e){
          var json = $.parseJSON(e);
          loadDataSector(json);
      },
      error:function(e){
      }
    });
  }
  
  function loadDataSector(dataSource){
    $("#chart4").dxChart({
          dataSource: dataSource,
          commonSeriesSettings: {
            argumentField: "Carrera2",
            type: "bar",
            hoverMode: "allArgumentPoints",
            selectionMode: "allArgumentPoints",
            label: {
                visible: true,
                format: {
                    type: "fixedPoint",
                    precision: 0
                }
            }
            },
        series: [
            { valueField: "PUB", name: "Publico" },
            { valueField: "PRIV", name: "Privado" }
        ],
        title: "Sector",
        legend: {
            verticalAlignment: "bottom",
            horizontalAlignment: "center"
        },
        /*"export": {
            enabled: true
        },*/
      });
  }

  function callAjjacGraficaSector($idCarrera){
      $.ajax({
      url:"../php/datos.php",
      type:"POST",
      data:{
        opcion:"5",
        idCarrera:$idCarrera
      },
      beforeSend:function(e){
       
      },
      success: function(e){
          
          var json = $.parseJSON(e);
          loadDataGraficaSector(json);
      },
      error:function(e){

      }
    });
  }
  
  function loadDataGraficaSector(dataSource){

    $("#chart5").dxChart({
          dataSource: dataSource,
          commonSeriesSettings: {
            argumentField: "Sector",
            type: "bar",
            hoverMode: "allArgumentPoints",
            selectionMode: "allArgumentPoints",
            label: {
                visible: true,
                format: {
                    type: "fixedPoint",
                    precision: 0
                }
            }
            },
        series: [
            { valueField: "Hombre", name: "Hombre" },
            { valueField: "Mujer", name: "Mujer" }
        ],
        title: "Sexo",
        legend: {
            verticalAlignment: "bottom",
            horizontalAlignment: "center"
        }
      });
  }

</script>
</html>