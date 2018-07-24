<?php 

	class ITSA {

		private $CONNECTION;

		public function __construct($BD){
			$this->CONNECTION = $BD;
		}

		public function login($Datos) {
			try {
				$SQL = $this->CONNECTION->prepare("SELECT idTipoUsuario, idUsuario FROM usuarios WHERE vUsuario = :usuario AND vContrasena = :contrasena AND bActivo = 1");
				$SQL->bindParam(":usuario", $Datos['usuario']);
				$SQL->bindParam(":contrasena", $Datos['contrasena']);
				$SQL->execute(); 

				if($SQL->rowCount() > 0) { 
					$Usuario = $SQL->fetch(PDO::FETCH_ASSOC);
					if($Usuario['idTipoUsuario'] == 1) { #ALUMNOS
						$SQLALUMNO = $this->CONNECTION->prepare("SELECT * FROM alumnos WHERE idUsuario = :idUsuario");
						$SQLALUMNO->bindParam(":idUsuario", $Usuario['idUsuario']);
						$SQLALUMNO->execute();	
						$Alumno = $SQLALUMNO->fetch(PDO::FETCH_ASSOC);			
						@session_start();					
				    	$_SESSION['nombre'] = $Alumno['vNombre'].' '.$Alumno['vApellidoPaterno'];
				    	$_SESSION['idUsuario'] = $Alumno['idAlumno'];
				    	$_SESSION['numeroControl'] = $Alumno['vNumeroControl'];
					} else if ($Usuario['idTipoUsuario'] == 2) { #ADMINISTRADOR
						// $SQLADMINISTRADOR = $this->CONNECTION->prepare("SELECT * FROM ")
						@session_start();	
						$_SESSION['nombre'] = "Administrador";
						$_SESSION['idUsuario'] = $Usuario['idUsuario'];
						$_SESSION['numeroControl'] = "";
					} else if ($Usuario['idTipoUsuario'] == 3) { #JEFE DE CARRERA
						$SQLJEFE = $this->CONNECTION->prepare("SELECT * FROM jefescarrera WHERE idUsuario = :idUsuario");
						$SQLJEFE->bindParam(":idUsuario", $Usuario['idUsuario']);
						$SQLJEFE->execute();
						$JEFE = $SQLJEFE->fetch(PDO::FETCH_ASSOC);			
						@session_start();					
				    	$_SESSION['nombre'] = $Alumno['vNombre'];
				    	$_SESSION['idUsuario'] = $Alumno['idJefeCarrera'];
				    	$_SESSION['numeroControl'] = "";
					}
					# PERMISOS DE BARRA DE NAVEGACION
					$SQLMODULOS = $this->CONNECTION->prepare("SELECT DISTINCT modulos.idModulo, modulos.vModulo FROM permisos INNER JOIN modulos ON permisos.idModulo = modulos.idModulo WHERE permisos.idTipoUsuario = :idTipoUsuario AND permisos.bActivo = 1 AND modulos.bActivo = 1");
					$SQLMODULOS->bindParam(":idTipoUsuario", $Usuario['idTipoUsuario']);
					$SQLMODULOS->execute();

					$SQLSUBMODULOS = $this->CONNECTION->prepare("SELECT	submodulos.vSubmodulo, submodulos.vRuta FROM permisos INNER JOIN submodulos ON permisos.idSubmodulo = submodulos.idSubmodulo WHERE permisos.idTipoUsuario = :idTipoUsuario AND submodulos.bActivo = 1 AND permisos.bActivo = 1 AND permisos.idModulo = :idModulo");

					$NAVBAR_ = "";
					$PERMISOS = array();

					while($Modulos = $SQLMODULOS->fetch(PDO::FETCH_ASSOC)) {
						$arraySubmodulos = array(
							':idTipoUsuario'=>$Usuario['idTipoUsuario'],
							':idModulo'=>$Modulos['idModulo']
						);	
						$SQLSUBMODULOS->execute($arraySubmodulos);
						// <i class="fa fa-wrench fa-fw"></i>
						$NAVBAR_ .= '<li><a href="#">'.$Modulos['vModulo'].'<span class="fa arrow"></span></a>';
						$NAVBAR_ .= '<ul class="nav nav-second-level">';
						while($submodulos = $SQLSUBMODULOS->fetch(PDO::FETCH_ASSOC)) {
							$NAVBAR_ .= '<li><a href="'.$submodulos['vRuta'].'.php">'.$submodulos['vSubmodulo'].'</a></li>';
							array_push($PERMISOS, $submodulos['vRuta']);
						}
						$NAVBAR_ .= '</ul></li>';
					}
					$_SESSION['navbar'] = $NAVBAR_;
					$_SESSION['permisos'] = $PERMISOS;

					header('Location: pages/');
				} else {
					echo '<div class="alert alert-dismissable alert-danger">Lo sentimos, usuario y/o contraseña no coinciden!
							<button type="button" class="close" data-dismiss="alert">x</button>
					  	 </div>';
				}
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
					<button type="button" class="close" data-dismiss="alert">x</button>
				  </div>';
			}
		}

		public function checkSession() {
			@session_start();
			if(!empty($_SESSION['idUsuario']) && !empty($_SESSION['nombre']))
				return true;

			return false;
		}

		public function logout() {
			@session_start();
			session_unset($_SESSION['nombre']);
			session_unset($_SESSION['idUsuario']);
			session_unset($_SESSION['numeroControl']);
			session_unset($_SESSION['navbar']);
			session_unset($_SESSION['permisos']);
			session_destroy();
			header('Location: ../index.php');
		}

		public function checkPermission($Pagina) {
			@session_start();
			if(in_array($Pagina, $_SESSION['permisos'])) {
				echo true;
			} else {				
				echo false;
			}
		}
	}

?>