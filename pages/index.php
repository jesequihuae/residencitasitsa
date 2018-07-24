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

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- <input type="hidden" id="idUsuario" value="<?php @session_start(); echo $_SESSION['idUsuario']; ?>"> -->
            <div class="row">
            <?php 
              include '../php/connection.php';
              if(!$ObjectITSA->checkSession()){ 
                 echo '<script language = javascript> self.location = "javascript:history.back(-1);" </script>';
                 exit;
              }
            ?>
                <div class="col-lg-12">
                    <h1 class="page-header"></h1>
                </div>
            </div>

            <!-- ... Your content goes here ... --> 
            <div class="row">
                <section class="design-process-section" id="process-tab" align="center">
                      <div class="col-lg-12"> 
                        <!-- design process steps--> 
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs process-model more-icon-preocess" role="tablist">
                          <li role="presentation" class="active"><a href="#discover" aria-controls="discover" role="tab" data-toggle="tab"><i class="fa fa-search" aria-hidden="true"></i>
                            <p>Discover</p>
                            </a></li>
                          <li role="presentation"><a href="#strategy" aria-controls="strategy" role="tab" data-toggle="tab"><i class="fa fa-send-o" aria-hidden="true"></i>
                            <p>Strategy</p>
                            </a></li>
                          <li role="presentation"><a href="#optimization" aria-controls="optimization" role="tab" data-toggle="tab"><i class="fa fa-qrcode" aria-hidden="true"></i>
                            <p>Optimization</p>
                            </a></li>
                          <li role="presentation"><a href="#content" aria-controls="content" role="tab" data-toggle="tab"><i class="fa fa-newspaper-o" aria-hidden="true"></i>
                            <p>Content</p>
                            </a></li>
                          <li role="presentation"><a href="#reporting" aria-controls="reporting" role="tab" data-toggle="tab"><i class="fa fa-clipboard" aria-hidden="true"></i>
                            <p>Reporting</p>
                            </a></li>
                        </ul>
                        <!-- end design process steps--> 
                        <!-- Tab panes -->
                        <div class="tab-content">
                          <div role="tabpanel" class="tab-pane active" id="discover">
                            <div class="design-process-content">
                              <h3 class="semi-bold">Discovery</h3>
                             <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincid unt ut laoreet dolore magna aliquam erat volutpat</p>
                             </div>
                          </div>
                          <div role="tabpanel" class="tab-pane" id="strategy">
                            <div class="design-process-content">
                              <h3 class="semi-bold">Strategy</h3>
                              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincid unt ut laoreet dolore magna aliquam erat volutpat</p>
                              </div>
                          </div>
                          <div role="tabpanel" class="tab-pane" id="optimization">
                            <div class="design-process-content">
                              <h3 class="semi-bold">Optimization</h3>
                              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincid unt ut laoreet dolore magna aliquam erat volutpat</p>
                               </div>
                          </div>
                          <div role="tabpanel" class="tab-pane" id="content">
                            <div class="design-process-content">
                              <h3 class="semi-bold">Content</h3>
                              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincid unt ut laoreet dolore magna aliquam erat volutpat</p>              
                              </div>
                          </div>
                          <div role="tabpanel" class="tab-pane" id="reporting">
                            <div class="design-process-content">
                              <h3>Reporting</h3>
                              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincid unt ut laoreet dolore magna aliquam erat volutpat. </p>
                          </div>
                        </div>
                      </div>
                </section>
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
     <script src="../js/index.js"></script>
</body>
</html>
