<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="utf-8"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Index</title>

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
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/styleFiles.css">

    <!-- ALERTIFY JS-->
    <link  href="../css/alertify.min.css" rel="stylesheet" type="text/css">

    <!-- Default theme -->
    <!-- <link rel="stylesheet" href="../css/themes/default.min.css"/> -->



     <!-- jQuery -->
    <script src="../js/jquery.min.js"></script>

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
      if(!$ObjectITSA->checkSession()){
         // echo '<script language = javascript> self.location = "javascript:history.back(-1);" </script>';
         // exit;
      }
    ?>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
            
                <div class="col-lg-12">
                    <h1 class="page-header"></h1>
                </div>
            </div>

            <!-- ... Your content goes here ... -->
            <center>
                <img src="../img/itsa.png" width="250">
            </center>
            <?php
                switch (@$_GET["opt"]) {
                case '1':
                    include 'adminFiles/filesManager.php';
                break;
                case '2':
                    include 'cronograma/cronogramaActividades.php';
                break;
                case '3':
                    include 'alertas/alertasPorAlumno.php';
                break;
                default:

                    break;
                 }
            ?>

        </div>
    </div>
    <div class="row">
      <!--<pre>
        <?php //print_r($_SESSION); ?>
      </pre>-->

       <!-- <img src="https://www.paypalobjects.com/webstatic/es_MX/mktg/logos-buttons/redesign/btn_10.png" alt="PayPal" />-->
    </div>
</div>


    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../js/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="../js/startmin.js"></script>
    <script src="../js/jquery.datetimepicker.full.min.js"></script>
    <script src="../js/index.js"></script>

     <!--ALERTIFY JS-->
    <script src="../js/alertify.min.js"></script>

         <script src="../js/pdfobject.min.js"></script>

        <script type="text/javascript">
            $(document).on("click", ".open-AddBookDialog", function () {
                 var myBookId = $(this).data('id');
                 PDFObject.embed(myBookId, "#example1");
                $("#myModal").modal();
            });
        </script>
</body>
</html>
