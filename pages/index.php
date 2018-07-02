<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="utf-8"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Cargar Cursos</title>

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
        if(!$ObjectDashboard->checkSession()){
          echo '<script language = javascript> self.location = "javascript:history.back(-1);" </script>';
          exit;
        }
     ?>



    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <input type="hidden" id="idUsuario" value="<?php @session_start(); echo $_SESSION['idUsuario']; ?>">
            <div class="row">
               
                <!-- <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-briefcase"></i> Cursos</h1>
                </div> -->
            </div>

            <!-- ... Your content goes here ... --> 

            <!-- <div class="row">
                <div class="col-lg-12">
                   <div class="panel panel-primary">
                     <div class="panel-heading">
                       <h4><i class="fa fa-briefcase"></i> Cursos</h4>
                     </div>
                     <?php 
                        include '../php/connection.php';
                        if($ObjectDashboard->isThereCoursesRegistered($_SESSION['idUsuario'])) {
                     ?>                        
                       <div class="panel-body">                         
                          <div class="row">
                            <div class="col-lg-12">   
                              <center>Cursos agregados</center>
                              <hr>
                              <div id="panelCursosAgregados"> 
                                <?php 
                                  include_once '../php/connection.php'; $ObjectDashboard->getDefaultCourse();
                                ?>                          
                              </div>  
                            </div>
                          </div> 
                          <hr>
                          <br> 
                          <div class="row">
                            <div class="col-lg-12" align="center">
                                <select class="form-control" style="width: 50%;" id="cursosOpciones">
                                  <?php include_once '../php/connection.php'; $ObjectDashboard->getCoursesOptions();?>
                                </select><br>
                                <center><button class="btn btn-info" id="addCourse">Agregar curso</button></center>
                            </div>
                          </div>  
                       </div>                       
                      <div class="panel-footer">
                        <div class="pull-right">                                
                            <a class="btn btn-danger" href="index">Cancelar</a>
                            <button type="submit" class="btn btn-success" name="guardarUsuario" id="guardarCursos">Guardar</button>
                        </div>
                        <div class="clearfix"></div>
                     </div>
                    <?php    
                      } else { ?>
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-lg-12">
                            <center><h3>¡Ya has registrado los cursos!</h3></center>
                            <br>
                            <center><p>Por el momento es todo lo necesario para estar inscrito formalmente en el Diplomado De las Artes en su modalidad Virtual.</p><br><p>Toda la información necesaria se estará dando en nuestra página de <a href="https://www.facebook.com/diplomadosdelasep.com.mx/">Facebook</a>. La plataforma estará disponible a partir de el día 8 de Septiembre del 2018.</p></center>
                          </div>
                        </div>
                      </div>
                    <?php }
                    ?>
                   </div>
                </div>
            </div> -->
        </div>
    </div>

</div>

 <!-- MODAL ACTIVAR/DESACTIVAR -->
  <div class="modal" id="modalSiONo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Atención!</h4>
        </div>
        <div class="modal-body" align="center">
          ¿Estás seguro de cargar los cursos seleccionados?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">No</button>
          <button type="button" class="btn btn-success" id="siGuardar" data-dismiss="modal">Sí</button>&nbsp;&nbsp;&nbsp;
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
          $("#addCourse").on('click', function(data) {
            // console.log(data);

            // alert($("#cursosOpciones").val());  

            var Panel = '<div class="panel panel-default panel-dissmisable">';
            Panel += '<div class="panel-heading">';
            Panel += '<input type="hidden" class="idAsesorCurso" value="'+$("#cursosOpciones").val()+'"/>';
            Panel += '<div class="pull-left">';
            Panel += '<strong><i class="fa fa-briefcase"></i> Curso: </strong>'+$("#cursosOpciones").find('option:selected').data("curso")+'<br>';
            Panel += '<strong><i class="fa fa-user"></i> Profesor: </strong>'+$("#cursosOpciones").find('option:selected').data("profesor")+'';
            Panel += '</div>';
            Panel += '<div class="pull-right"><div><a class="btn btn-danger btn-xs">Eliminar</a></div></div>';
            Panel += '<div class="clearfix"></div>';
            Panel += '</div>';
            Panel += '</div>';

            var ok = true;
            if ($('#panelCursosAgregados > div').length < 3) { 

              $("#panelCursosAgregados > .panel").each(function() {
                 if( ($("#cursosOpciones").val() == $(this).find(".idAsesorCurso").val())) {
                   ok = false;
                 }
              });   

              if(ok == true) {                
                 $("#panelCursosAgregados").append(Panel);
              } else {
                alert("Ya has agregado el curso seleccionado.")
              }
            } else {
              alert("Solo puedes agregar máximo 3 cursos en total");
            }

          });

          $("#panelCursosAgregados").on('click', 'a.btn', function () {
            // console.log("entra");
              $(this).closest('div.panel').hide('fast', function () {
                  $(this).remove();
              });
          });

          $("#cancelar").on('click', function(){
            location.reload();
          });

          $("#guardarCursos").on('click', function() {
              $("#modalSiONo").modal('show');
          });

          $("#siGuardar").on('click', function() {
              $("#siGuardar").attr('disabled','disabled');
              $("#modalSiONo").modal('hide');
              var json = "";

              $("#panelCursosAgregados > .panel").each(function() {
                json += $(this).find(".idAsesorCurso").val() + "?";
              });

              $.ajax({
                  type: 'POST',
                  url: '../php/savecourses.php',
                  data: {data: json, idUsuario: $("#idUsuario").val()},
                  success: function (data) {
                    console.log(data);
                    if(data == '1') {
                      alert("Se han registrado los cursos seleccionados");
                      location.reload();
                    }
                  }
              });
          });
        });
    </script>

</body>
</html>
