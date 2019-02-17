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
      <section id="panelRegistroEdicion2">
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
                                      <th>Giro</th>
                                      <th>Clave</th>
                                      <th>Total</th>
                                  <?php include '../php/connection.php'; 
                                  if (isset($_POST['carreras'])) {
                                    $CARRERAS_QUERY = $ObjectITSA->graficaTotalGiro($_POST['carreras']);
                                  }
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
                                    <button type="button" class="btn btn-default" id="cancelarRegistro2"><i class="fa fa-times-circle"></i> Cancelar</button>
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
                                  <select class="form-control" name="carreras" id="carreras">
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
                                  onclick="return findData()">
                                    <i class="fa fa-search"></i> Buscar
                                </button>
                              </div>
                              <!--<div class="clearfix"></div>-->
                              <div class="col-lg-4">
                                <button type="button" class="btn btn-primary pull-right" id="btnNuevaOpcion2">
                                      <i class="fa fa-table"></i> Tabla de Datos
                                </button>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-12">
                                <div class="demo-container col-lg-5">
                                  <div id="chart2"></div>
                                </div>
                                <div class="demo-container col-lg-6 col-lg-offset-1">
                                 <div id="chart3"></div>
                            
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
          $("#panelRegistroEdicion2").hide();
          $("#carreras").val($("#carreras option:first").val());

          $("#btnNuevaOpcion2").click(function(){
            $("#panelRegistroEdicion2").hide();
            clearFields();
            $("#panelRegistroEdicion2").show(150);
          });

          $("#cancelarRegistro2").click(function() {
            $("#panelRegistroEdicion2").hide(50);
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
  callAjax($("#carreras option:first").val());
  callAjaxGraficaGiro($("#carreras option:first").val());
  function findData(){
      $idCarrera  = $("#carreras").val();
      callAjax($idCarrera);
      callAjaxGraficaGiro($idCarrera);
  }

  $("#carreras").change(function(){
        findData();
  });

  function callAjax($idCarrera){
      $.ajax({
      url:"../php/datos.php",
      type:"POST",
      data:{
        idCarrera:$idCarrera,
        opcion:"2"
      },
      beforeSend:function(e){
        //activar automaticamente el cambio del select
      },
      success: function(e){
          var json = $.parseJSON(e);
          loadData(json);
      },
      error:function(e){
      }
    });
  }
  
  function loadData(dataSource){
    $("#chart2").dxChart({
          dataSource: dataSource,
          commonSeriesSettings: {
            argumentField: "Carrera",
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
            { valueField: "IDS", name: "Industrial" },
            { valueField: "SER", name: "Servicios" },
            { valueField: "EDU", name: "Educativo" }
        ],
        title: "Giro",
        legend: {
            verticalAlignment: "bottom",
            horizontalAlignment: "center"
        },
        /*"export": {
            enabled: true
        },*/
      });
  }

  function callAjaxGraficaGiro($idCarrera){
      $.ajax({
      url:"../php/datos.php",
      type:"POST",
      data:{
        opcion:"3",
        idCarrera:$idCarrera
      },
      beforeSend:function(e){
       
      },
      success: function(e){
          var json = $.parseJSON(e);
          loadDataGraficaGiro(json);
      },
      error:function(e){

      }
    });
  }
  
  function loadDataGraficaGiro(dataSource){
    $("#chart3").dxChart({
          dataSource: dataSource,
          commonSeriesSettings: {
            argumentField: "Giro",
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