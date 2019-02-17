<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Residencias - ITSA</title>
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- MetisMenu CSS -->
        <link href="css/metisMenu.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="css/startmin.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">



        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

        <div class="container">
            <div class="row">
                <?php

                  if(isset($_POST) && isset($_POST['login'])) {
                    include_once 'php/connection.php';
                    $ObjectITSA->login($_POST);

                  }

                ?>
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Por favor inicia sesión</h3>
                        </div>
                        <div class="panel-body">
                            <form method="post">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Numero de Contról" name="usuario" type="text" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Contraseña" name="contrasena" type="password"  required >
                                    </div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <button type="submit" href="index.html" class="btn btn-lg btn-success btn-block" name="login">Iniciar Sesión</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


         <!-- jQuery -->
        <script src="js/jquery.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <!-- Metis Menu Plugin JavaScript -->
        <script src="js/metisMenu.min.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="js/startmin.js"></script>

    </body>
</html>
