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

		public function registerProject($idAlumno, $NumeroControl, $idProyecto, $idPeriodo, $idOpcion, $idGiro, $idSector, $Solicitud, $Anteproyecto, $Constancia) {
			try {
				$carpeta = '../files/'.$NumeroControl;
				if (!file_exists($carpeta)) {
				    mkdir($carpeta, 0777, true);
				}

				$NombreSolicitud = explode('.', $Solicitud['name']);
				$NombreAnteproyecto = explode('.', $Anteproyecto['name']);
				$NombreConstancia = explode('.', $Constancia['name']);

				$RutaSolicitud = '../files/'.$NumeroControl.'/Solicitud.'. $NombreSolicitud[1];
				$RutaAnteproyecto = '../files/'.$NumeroControl.'/Anteproyecto.'. $NombreAnteproyecto[1];
				$RutaConstancia = '../files/'.$NumeroControl.'/Constancia.'. $NombreConstancia[1];


				$SQL = $this->CONNECTION->PREPARE("INSERT INTO proyectoseleccionado (idBancoProyecto, idAlumno, idPeriodo, idOpcion, idGiro, idEstado, idSector) VALUES (:idBancoProyecto, :idAlumno, :idPeriodo, :idOpcion, :idGiro, 3, :idSector)");

				$this->CONNECTION->beginTransaction();

				$SuccessSolicitud = move_uploaded_file($Solicitud['tmp_name'], $RutaSolicitud);
				$SuccessAnteproyecto = move_uploaded_file($Anteproyecto['tmp_name'], $RutaAnteproyecto);
				$SuccessConstancia = move_uploaded_file($Constancia['tmp_name'], $RutaConstancia);

				if($SuccessSolicitud && $SuccessAnteproyecto && $SuccessConstancia) {

					$UNA = "asdadsda";

					$SQL->bindParam(":idBancoProyecto", $idProyecto);
					$SQL->bindParam(":idAlumno",$idAlumno);
					$SQL->bindParam(":idPeriodo",$idPeriodo);
					$SQL->bindParam(":idOpcion", $idOpcion);
					$SQL->bindParam(":idGiro", $idGiro);
					$SQL->bindParam(":idSector", $idSector);
					$SQL->execute();

					$IDProyectoSeleccionado = $this->CONNECTION->lastInsertId();

					$SQLINTPROCESS = $this->CONNECTION->PREPARE("UPDATE alumnos SET iProceso = 2 WHERE idAlumno = :idAlumno");
					$SQLINTPROCESS->bindParam(":idAlumno", $idAlumno);
					$SQLINTPROCESS->execute();

					$SQLSolicitud = $this->CONNECTION->PREPARE("INSERT INTO documentos (idProyectoSeleccionado,idAlumno,idTipoDocumento,idEstado,vNombre,vRuta) VALUES (:idProyectoSeleccionado,:idAlumno,2,4,:vNombre,:vRuta)");

					$SQLSolicitud->bindParam(":idProyectoSeleccionado", $IDProyectoSeleccionado);
					$SQLSolicitud->bindParam(":vNombre",$UNA);
					$SQLSolicitud->bindParam(":vRuta",$RutaSolicitud);
					$SQLSolicitud->bindParam(":idAlumno", $idAlumno);
					$SQLSolicitud->execute();

					$SQLAnteproyecto = $this->CONNECTION->PREPARE("INSERT INTO documentos (idProyectoSeleccionado,idAlumno,idTipoDocumento,idEstado,vNombre,vRuta) VALUES (:idProyectoSeleccionado,:idAlumno,3,4,:vNombre,:vRuta) ");

					$SQLAnteproyecto->bindParam(":idProyectoSeleccionado", $IDProyectoSeleccionado);
					$SQLAnteproyecto->bindParam(":vNombre",$UNA);
					$SQLAnteproyecto->bindParam(":vRuta",$RutaAnteproyecto);
					$SQLAnteproyecto->bindParam(":idAlumno", $idAlumno);
					$SQLAnteproyecto->execute();

					$SQLConstancia = $this->CONNECTION->PREPARE("INSERT INTO documentos (idProyectoSeleccionado,idAlumno,idTipoDocumento,idEstado,vNombre,vRuta) VALUES (:idProyectoSeleccionado,:idAlumno,1,4,:vNombre,:vRuta) ");

					$SQLConstancia->bindParam(":idProyectoSeleccionado", $IDProyectoSeleccionado);
					$SQLConstancia->bindParam(":vNombre",$UNA);
					$SQLConstancia->bindParam(":vRuta",$RutaConstancia);
					$SQLConstancia->bindParam(":idAlumno",$idAlumno);
					$SQLConstancia->execute();						

					$this->CONNECTION->commit();
					echo '<div class="alert alert-dismissable alert-success">Proyecto Registrado correctamente!
							<button type="button" class="close" data-dismiss="alert">x</button>
					  	  </div>';	
				} else {
					$this->CONNECTION->rollback();
					unlink($RutaConstancia);
					unlink($RutaAnteproyecto);
					unlink($RutaSolicitud);
					echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: al subir los documentos. Intentalo nuevamente
							<button type="button" class="close" data-dismiss="alert">x</button>
					 	  </div>';
				}
			} catch (PDOException $e) {
				$this->CONNECTION->rollback();
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
				 	  </div>';
			}
		}

		public function saveLetters($idAlumno, $NumeroControl ,$cartaPresentacion, $cartaAceptacion) {
			try {
				$NombrePresentacion = explode('.', $cartaPresentacion['name']);
				$NombreAceptacion = explode('.', $cartaAceptacion['name']);

				$RutaPresentacion = '../files/'.$NumeroControl.'/Presentacion.'. $NombrePresentacion[1];
				$RutaAceptacion = '../files/'.$NumeroControl.'/Aceptacion.'. $NombreAceptacion[1];

				$SuccessPresentacion = move_uploaded_file($cartaPresentacion['tmp_name'], $RutaPresentacion);
				$SuccessAceptacion = move_uploaded_file($cartaAceptacion['tmp_name'], $RutaAceptacion);


				$SQLIdProyecto = $this->CONNECTION->PREPARE("SELECT idProyectoSeleccionado FROM proyectoseleccionado WHERE idAlumno = :idAlumno");
				$this->CONNECTION->beginTransaction();

				if($SuccessAceptacion && $RutaPresentacion) {
					$SQLIdProyecto->bindParam(":idAlumno",$idAlumno);
					$SQLIdProyecto->execute();
					$IDProyecto = $SQLIdProyecto->fetch(PDO::FETCH_ASSOC);

					$UNA = "asdadsda";

					$SQLPresentacion = $this->CONNECTION->PREPARE("INSERT INTO documentos (idProyectoSeleccionado,idAlumno,idTipoDocumento,idEstado,vNombre,vRuta) VALUES (:idProyectoSeleccionado,:idAlumno,4,4,:vNombre,:vRuta)");

					$SQLPresentacion->bindParam(":idProyectoSeleccionado",$IDProyecto['idProyectoSeleccionado']);
					$SQLPresentacion->bindParam(":vNombre",$UNA);
					$SQLPresentacion->bindParam(":vRuta",$RutaPresentacion);
					$SQLPresentacion->bindParam(":idAlumno",$idAlumno);
					$SQLPresentacion->execute();

					$SQLAceptacion = $this->CONNECTION->PREPARE("INSERT INTO documentos (idProyectoSeleccionado,idAlumno,idTipoDocumento,idEstado,vNombre,vRuta) VALUES (:idProyectoSeleccionado,:idAlumno,9,4,:vNombre,:vRuta)");

					$SQLAceptacion->bindParam(":idProyectoSeleccionado",$IDProyecto['idProyectoSeleccionado']);
					$SQLAceptacion->bindParam(":vNombre",$UNA);
					$SQLAceptacion->bindParam(":vRuta",$RutaAceptacion);
					$SQLAceptacion->bindParam(":idAlumno", $idAlumno);
					$SQLAceptacion->execute();

					$SQLINTPROCESS = $this->CONNECTION->PREPARE("UPDATE alumnos SET iProceso = 4 WHERE idAlumno = :idAlumno");
					$SQLINTPROCESS->bindParam(":idAlumno", $idAlumno);
					$SQLINTPROCESS->execute();

					$this->CONNECTION->commit();
					echo '<div class="alert alert-dismissable alert-success">Archivos registrados correctamente!
							<button type="button" class="close" data-dismiss="alert">x</button>
						  </div>';
				} else {
					$this->CONNECTION->rollback();
					unlink($RutaPresentacion);
					unlink($RutaAceptacion);
					echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: al subir los documentos. Intentalo nuevamente
							<button type="button" class="close" data-dismiss="alert">x</button>
					 	  </div>';
				}
			} catch (PDOException $e) {
				$this->CONNECTION->rollback();
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
				 	  </div>';
			}
		}

		public function saveFirstReport($idAlumno, $NumeroControl, $Reporte) {
			try {
				$NombreReporte = explode('.', $Reporte['name']);
				$RutaReporte = '../files/'.$NumeroControl.'/PrimerReporte.'. $NombreReporte[1];
				$SuccessReporte = move_uploaded_file($Reporte['tmp_name'], $RutaReporte);

				$SQLIdProyecto = $this->CONNECTION->PREPARE("SELECT idProyectoSeleccionado FROM proyectoseleccionado WHERE idAlumno = :idAlumno");
				$this->CONNECTION->beginTransaction();

				if($SuccessReporte) {
					$SQLIdProyecto->bindParam(":idAlumno",$idAlumno);
					$SQLIdProyecto->execute();
					$IDProyecto = $SQLIdProyecto->fetch(PDO::FETCH_ASSOC);

					$UNA = "asdadsda";

					$SQLReporte = $this->CONNECTION->PREPARE("INSERT INTO documentos (idProyectoSeleccionado,idAlumno,idTipoDocumento,idEstado,vNombre,vRuta) VALUES (:idProyectoSeleccionado,:idAlumno,5,4,:vNombre,:vRuta)");

					$SQLReporte->bindParam(":idProyectoSeleccionado",$IDProyecto['idProyectoSeleccionado']);
					$SQLReporte->bindParam(":vNombre",$UNA);
					$SQLReporte->bindParam(":vRuta",$RutaReporte);
					$SQLReporte->bindParam(":idAlumno",$idAlumno);
					$SQLReporte->execute();

					$SQLINTPROCESS = $this->CONNECTION->PREPARE("UPDATE alumnos SET iProceso = 5 WHERE idAlumno = :idAlumno");
					$SQLINTPROCESS->bindParam(":idAlumno", $idAlumno);
					$SQLINTPROCESS->execute();

					$this->CONNECTION->commit();
					echo '<div class="alert alert-dismissable alert-success">Archivos registrados correctamente!
							<button type="button" class="close" data-dismiss="alert">x</button>
						  </div>';
				} else {
					$this->CONNECTION->rollback();
					echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: al subir los documentos. Intentalo nuevamente
							<button type="button" class="close" data-dismiss="alert">x</button>
					 	  </div>';
				}

			} catch (PDOException $e) {				
				$this->CONNECTION->rollback();
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
				 	  </div>';
			}
		}

		public function saveSecondReport($idAlumno, $NumeroControl, $Reporte) {
			try {
				$NombreReporte = explode('.', $Reporte['name']);
				$RutaReporte = '../files/'.$NumeroControl.'/SegundoReporte.'. $NombreReporte[1];
				$SuccessReporte = move_uploaded_file($Reporte['tmp_name'], $RutaReporte);

				$SQLIdProyecto = $this->CONNECTION->PREPARE("SELECT idProyectoSeleccionado FROM proyectoseleccionado WHERE idAlumno = :idAlumno");
				$this->CONNECTION->beginTransaction();

				if($SuccessReporte) {
					$SQLIdProyecto->bindParam(":idAlumno",$idAlumno);
					$SQLIdProyecto->execute();
					$IDProyecto = $SQLIdProyecto->fetch(PDO::FETCH_ASSOC);

					$UNA = "asdadsda";

					$SQLReporte = $this->CONNECTION->PREPARE("INSERT INTO documentos (idProyectoSeleccionado,idAlumno,idTipoDocumento,idEstado,vNombre,vRuta) VALUES (:idProyectoSeleccionado,:idAlumno,6,4,:vNombre,:vRuta)");

					$SQLReporte->bindParam(":idProyectoSeleccionado",$IDProyecto['idProyectoSeleccionado']);
					$SQLReporte->bindParam(":vNombre",$UNA);
					$SQLReporte->bindParam(":vRuta",$RutaReporte);
					$SQLReporte->bindParam(":idAlumno",$idAlumno);
					$SQLReporte->execute();

					$SQLINTPROCESS = $this->CONNECTION->PREPARE("UPDATE alumnos SET iProceso = 6 WHERE idAlumno = :idAlumno");
					$SQLINTPROCESS->bindParam(":idAlumno", $idAlumno);
					$SQLINTPROCESS->execute();

					$this->CONNECTION->commit();
					echo '<div class="alert alert-dismissable alert-success">Archivos registrados correctamente!
							<button type="button" class="close" data-dismiss="alert">x</button>
						  </div>';
				} else {
					$this->CONNECTION->rollback();
					echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: al subir los documentos. Intentalo nuevamente
							<button type="button" class="close" data-dismiss="alert">x</button>
					 	  </div>';
				}

			} catch (PDOException $e) {				
				$this->CONNECTION->rollback();
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
				 	  </div>';
			}
		}

		public function saveThirdReport($idAlumno, $NumeroControl, $Reporte) {
			try {
				$NombreReporte = explode('.', $Reporte['name']);
				$RutaReporte = '../files/'.$NumeroControl.'/TercerReporte.'. $NombreReporte[1];
				$SuccessReporte = move_uploaded_file($Reporte['tmp_name'], $RutaReporte);

				$SQLIdProyecto = $this->CONNECTION->PREPARE("SELECT idProyectoSeleccionado FROM proyectoseleccionado WHERE idAlumno = :idAlumno");
				$this->CONNECTION->beginTransaction();

				if($SuccessReporte) {
					$SQLIdProyecto->bindParam(":idAlumno",$idAlumno);
					$SQLIdProyecto->execute();
					$IDProyecto = $SQLIdProyecto->fetch(PDO::FETCH_ASSOC);

					$UNA = "asdadsda";

					$SQLReporte = $this->CONNECTION->PREPARE("INSERT INTO documentos (idProyectoSeleccionado,idAlumno,idTipoDocumento,idEstado,vNombre,vRuta) VALUES (:idProyectoSeleccionado,:idAlumno,7,4,:vNombre,:vRuta)");

					$SQLReporte->bindParam(":idProyectoSeleccionado",$IDProyecto['idProyectoSeleccionado']);
					$SQLReporte->bindParam(":vNombre",$UNA);
					$SQLReporte->bindParam(":vRuta",$RutaReporte);
					$SQLReporte->bindParam(":idAlumno",$idAlumno);
					$SQLReporte->execute();

					$SQLINTPROCESS = $this->CONNECTION->PREPARE("UPDATE alumnos SET iProceso = 7 WHERE idAlumno = :idAlumno");
					$SQLINTPROCESS->bindParam(":idAlumno", $idAlumno);
					$SQLINTPROCESS->execute();

					$this->CONNECTION->commit();
					echo '<div class="alert alert-dismissable alert-success">Archivos registrados correctamente!
							<button type="button" class="close" data-dismiss="alert">x</button>
						  </div>';
				} else {
					$this->CONNECTION->rollback();
					echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: al subir los documentos. Intentalo nuevamente
							<button type="button" class="close" data-dismiss="alert">x</button>
					 	  </div>';
				}

			} catch (PDOException $e) {				
				$this->CONNECTION->rollback();
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
				 	  </div>';
			}
		}

		public function getIntProcess($idAlumno) {
			try {
				$SQL = $this->CONNECTION->prepare("SELECT iProceso FROM alumnos WHERE idAlumno = :idAlumno");
				$SQL->bindParam(":idAlumno", $idAlumno);
				$SQL->execute();
				$intProceso = $SQL->fetch(PDO::FETCH_ASSOC);

				return $intProceso['iProceso'];
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
				 	  </div>';
			}
		}

		public function getProjectStatusTEXT($idAlumno) {
			try {
				$SQL = $this->CONNECTION->PREPARE("SELECT E.vEstado, PS.idEstado  FROM proyectoseleccionado PS INNER JOIN estados E ON PS.idEstado = E.idEstado WHERE PS.idAlumno = :idAlumno");
				$SQL->bindParam(":idAlumno", $idAlumno);
				$SQL->execute();

				$TextEstado = $SQL->fetch(PDO::FETCH_ASSOC);


				$tipo = '';

				switch ($TextEstado['idEstado']) {
					case 1 :
						$tipo = '-primary';
						break;

					case 2 :
						$tipo = '-default';
						break;
					case 3 :
						$tipo = '-warning';
						break;

					case 4 :
						$tipo = '-primary';
						break;

					case 5 :
						$tipo = '-success';
						break;
					
					case 6 :
						$tipo = '-danger';
						break;

					default:
						$tipo = '';
						break;
				}


				return '<span class="label label'.$tipo.'">'.$TextEstado['vEstado'].'</span>';
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
				 	  </div>';
			}
		}

		public function getProjectStatusINT($idAlumno) {
			try {
				$SQL = $this->CONNECTION->PREPARE("SELECT idEstado FROM proyectoseleccionado WHERE idAlumno = :idAlumno");
				$SQL->bindParam(":idAlumno", $idAlumno);
				$SQL->execute();

				$TextEstado = $SQL->fetch(PDO::FETCH_ASSOC);				

				return $TextEstado['idEstado'];
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
				 	  </div>';
			}
		}

		public function changeIntProcesss($idAlumno) {
			try {

				$SQL = $this->CONNECTION->PREPARE("SELECT iProceso FROM alumnos WHERE idAlumno = :idAlumno");
				$SQL->bindParam(":idAlumno",$idAlumno);
				$SQL->execute();

				$STATUSBEFORE_ = $SQL->fetch(PDO::FETCH_ASSOC);
				$STATUSNOW_ = ($STATUSBEFORE_['iProceso'] + 1); 

				$SQLNUEVO = $this->CONNECTION->PREPARE("UPDATE alumnos SET iProceso = :iProceso WHERE idAlumno = :idAlumno");
				$SQLNUEVO->bindParam(":iProceso", $STATUSNOW_);
				$SQLNUEVO->bindParam(":idAlumno", $idAlumno);
				$SQLNUEVO->execute();
				
				echo '';
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
				 	  </div>';
			}
		}

		public function getRejectionTEXT($idAlumno) {
			try {	
				$SQL = $this->CONNECTION->PREPARE("SELECT vMotivoNoAceptacion FROM proyectoseleccionado WHERE idAlumno = :idAlumno");
				$SQL->bindParam(":idAlumno", $idAlumno);
				$SQL->execute();

				$Motivo = $SQL->fetch(PDO::FETCH_ASSOC);

				echo '<div class="well">
					Te informamos que tu solicitud de proyecto para las Residencias fue <strong>Rechazado</strong> se anexan los motivos del rechazo:<br><br>
					'.$Motivo['vMotivoNoAceptacion'].'
					</div>';
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
			@session_unset($_SESSION['nombre']);
			@session_unset($_SESSION['idUsuario']);
			@session_unset($_SESSION['numeroControl']);
			@session_unset($_SESSION['navbar']);
			@session_unset($_SESSION['permisos']);
			@session_destroy();
			header('Location: ../index.php');
		}

		public function checkPermission($Pagina) {
			@session_start();
			if(in_array($Pagina, $_SESSION['permisos'])) {
				return true;
			} else {				
				return false;
			}
		}
	}

?>