<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <!-- <a class="navbar-brand" href="#">Startmin</a> -->
        </div>

        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>


        <!-- Top Navigation: Right Menu -->
        <ul class="nav navbar-right navbar-top-links">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i><b class="caret"></b>
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
                        <a href="#" class="active"><!-- <i class="fa fa-globe fa-fw"></i>  --><center> Bienvenido </center></a>
                    </li>
                    <?php @session_start(); echo $_SESSION['navbar']; ?>
                </ul>
            </div>
        </div>
    </nav>