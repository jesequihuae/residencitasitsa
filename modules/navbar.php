<?php include_once '../php/connection.php'; ?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">ITSA</a>
        </div>
        <?php @session_start(); ?>

        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <!-- Top Navigation: Right Menu -->
        <ul class="nav navbar-right navbar-top-links">
            <?php 
                if($_SESSION['tipoUsuario'] == 1) {
            ?>
                <li class="nav-item">
                    <a class="nav-link" href="../pages/notificaciones.php">
                        <?php 
                            $Notificaciones = $ObjectITSA->obtenerNumeroNotificaciones($_SESSION['idUsuario']);
                            if($Notificaciones > 0) {  
                        ?>
                        <i class="fa fa-bell">
                            <span class="badge badge-danger" style="background-color: red;">
                                <?php echo $Notificaciones; ?>
                            </span>
                        </i>
                        <?php 
                            } else { 
                        ?>
                            <i class="fa fa-bell-o"></i>
                        <?php } ?>
                    </a>
                  </li>
            <?php
                }
            ?>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i><?php @session_start(); echo 'Hola '.@$_SESSION['nombre']; ?><b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-user">
                  <!--   <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                    </li>
                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    </li> -->
                    <!-- <li class="divider"></li> -->
                    <li><a href="../php/logout.php"><i class="fa fa-sign-out fa-fw"></i> Salir de sesión</a>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- Sidebar -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu" >
                    <li>
                        <a href="index.php" class="active"><!-- <i class="fa fa-globe fa-fw"></i>  --><center> Bienvenido </center></a>
                    </li>
                    <?php @session_start(); echo @$_SESSION['navbar']; ?>
                </ul>
            </div>
        </div>
    </nav>
