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
<section id="panelRegistroEdicion">
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h2 class="panel-title">
                                    <div id="txtHeadingRegistroCarreras">Table</div>
                                </h2>
                            </div>
                            <div class="panel-body" style="padding-top=10ps;">
                              <div class="table-responsive">
                                <table class="table table-hover">
                                  <thead>
                                      <th>Carrera</th>
                                      <th>Opcion</th>
                                      <th>Clave</th>
                                      <th>Total</th>
                                  <?php include '../php/connection.php'; 
                                  $CARRERAS_QUERY = $ObjectITSA->graficaOpcionElegida();
                                  foreach ($CARRERAS_QUERY as $key) {?>
                                  <tr> 
                                    <td> <?php print($key['Carrera']); ?> </td>
                                    <td> <?php print($key['Opcion']); ?> </td>
                                    <td> <?php print($key['vClaveOpcion']); ?> </td>
                                    <td> <?php print($key['Total']); ?> </td>
                                  </tr>
                                  <?php } ?>
                                </table>  
                              </div>
                                <form class="form-horizontal" method="POST">
                                    <button type="button" class="btn btn-default" id="cancelarRegistro"><i class="fa fa-times-circle"></i> Cancelar</button>
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
                            <button type="button" class="btn btn-primary pull-right" id="btnNuevaOpcion">
                                  <i class="fa fa-table"></i> Tabla de Datos
                            </button><br><br>
                            <div class="demo-container">
                              <div id="chart"></div>
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
          $("#panelRegistroEdicion").hide();

          $("#btnNuevaOpcion").click(function(){
            $("#panelRegistroEdicion").hide();
            clearFields();
            $("#panelRegistroEdicion").show(150);
          });

          $("#cancelarRegistro").click(function() {
            $("#panelRegistroEdicion").hide(50);
            clearFields();
          });
        });

        function clearFields(){
            $("#idOpcion").val("0");
            $("#vClave").val("");
            $("#vOpcion").val("");
        }
    </script>

    <script type="text/javascript">
    $(function(){
    $.ajax({
      url:"../php/datos.php",
      type:"POST",
      data:{
        opcion:"1"
      },
      beforeSend:function(e){
      },
      success: function(e){
          var json = $.parseJSON(e);
          loadData(json);
      },
      error:function(e){
      }
    });

    function loadData(dataSource){
      $("#chart").dxChart({
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
              { valueField: "PP", name: "Propuesta Propia" },
              { valueField: "BP", name: "Banco de Proyecto" },
              { valueField: "INN", name: "Verano de Investigación" }
          ],
          title: "Gráfica Opción Elegida de Residencias",
          legend: {
              verticalAlignment: "bottom",
              horizontalAlignment: "center"
          },
          "export": {
              enabled: true
          },
        });
    }
  });
  </script>
</html>