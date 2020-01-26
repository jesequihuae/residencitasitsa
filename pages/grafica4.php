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
                                  <select class="form-control" name="carreras3" id="carreras3">
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
                            </div>
                            <div class="row" style="justify-content:center;">
                              <div class="col-lg-12" style="justify-content:center;">
                                <div class="demo-container col-lg-8" style="justify-content:center;">
                                  <div id="chartAmbiental"></div>
                                </div>
                              </div>
                                </div>
                        </div>
                    </div>
                </div>
              </div>
</body>

  <script>
    callAjaxAmbiente($("#carreras3 option:first").val());

    function findData2(){
      $idCarrera  = $("#carreras3").val();
      callAjaxAmbiente($idCarrera);
    }

    $("#carreras3").change(function(){
          findData2();
    });
    function callAjaxAmbiente($idCarrera){
        $.ajax({
        url:"../php/datos.php",
        type:"POST",
        data:{
          idCarrera:$idCarrera,
          opcion:"6"
        },
        beforeSend:function(e){
        },
        success: function(e){
            var json = $.parseJSON(e);
            loadDataAmbiente(json);
        },
        error:function(e){
        }
      });
    }

    function loadDataAmbiente(dataSource){
    $("#chartAmbiental").dxChart({
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
            { valueField: "IA", name: "Impacto Ambiental" }
        ],
        title: "Impacto Ambiental",
        legend: {
            verticalAlignment: "bottom",
            horizontalAlignment: "center"
        },
        "export": {
            enabled: true
        },
      });
  }
  </script>

</html>