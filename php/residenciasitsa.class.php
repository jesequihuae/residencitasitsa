<?php

	class ITSA {

		private $CONNECTION;

		public function __construct($BD){
			$this->CONNECTION = $BD;
		}

		public function login($Datos) {
			try {
				$SQL = $this->CONNECTION->prepare(
					"SELECT
						idTipoUsuario,
						idUsuario
					 FROM usuarios
					 WHERE vUsuario = :usuario AND vContrasena = :contrasena AND bActivo = 1");
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
				    	$_SESSION['nombre'] = $JEFE['vNombre'];
				    	$_SESSION['idUsuario'] = $JEFE['idJefeCarrera'];
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
					$_SESSION['tipoUsuario'] = $Usuario['idTipoUsuario'];
					header('Location: pages/');
					// print_r($_SESSION);
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
				$UUIDPresentacion   = uniqid();

				$NombreAceptacion   = explode('.', $cartaAceptacion['name']);
				$UUIDAceptacion		= uniqid();

				$RutaPresentacion = '../files/'.$NumeroControl.'/Presentacion.'. $UUIDPresentacion;
				$RutaAceptacion = '../files/'.$NumeroControl.'/Aceptacion.'. $UUIDAceptacion;

				$SuccessPresentacion = move_uploaded_file($cartaPresentacion['tmp_name'], $RutaPresentacion);
				$SuccessAceptacion = move_uploaded_file($cartaAceptacion['tmp_name'], $RutaAceptacion);


				$SQLIdProyecto = $this->CONNECTION->PREPARE(
					"SELECT 
						idProyectoSeleccionado 
					FROM proyectoseleccionado 
					WHERE idAlumno = :idAlumno");
				$this->CONNECTION->beginTransaction();

				if($SuccessAceptacion && $RutaPresentacion) {
					$SQLIdProyecto->bindParam(":idAlumno",$idAlumno);
					$SQLIdProyecto->execute();
					$IDProyecto = $SQLIdProyecto->fetch(PDO::FETCH_ASSOC);

					$UNA = "asdadsda";

					$SQLPresentacion = $this->CONNECTION->PREPARE(
						"INSERT INTO documentos (
							idProyectoSeleccionado,
							idAlumno,
							idTipoDocumento,
							idEstado,
							vNombre,
							vRuta,
							UUID
							)
							VALUES
							(:idProyectoSeleccionado,
							:idAlumno,
							4,
							4,
							:vNombre,
							:vRuta,
							:UUID
							)");

					$SQLPresentacion->bindParam(":idProyectoSeleccionado",$IDProyecto['idProyectoSeleccionado']);
					$SQLPresentacion->bindParam(":vNombre",$UNA);
					$SQLPresentacion->bindParam(":vRuta",$RutaPresentacion);
					$SQLPresentacion->bindParam(":idAlumno",$idAlumno);
					$SQLPresentacion->bindParam(":UUID",$UUIDPresentacion);
					$SQLPresentacion->execute();

					$SQLAceptacion = $this->CONNECTION->PREPARE(
						"INSERT INTO documentos (
							idProyectoSeleccionado,
							idAlumno,
							idTipoDocumento,
							idEstado,
							vNombre,
							vRuta,
							UUID
							)
							VALUES
							(:idProyectoSeleccionado,
							:idAlumno,
							9,
							4,
							:vNombre,
							:vRuta,
							:UUID
							)");

					$SQLAceptacion->bindParam(":idProyectoSeleccionado",$IDProyecto['idProyectoSeleccionado']);
					$SQLAceptacion->bindParam(":vNombre",$UNA);
					$SQLAceptacion->bindParam(":vRuta",$RutaAceptacion);
					$SQLAceptacion->bindParam(":idAlumno", $idAlumno);
					$SQLAceptacion->bindParam(":UUID", $UUIDAceptacion);
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
		/**
		 * MODIFICACION HECHA POR MAICKOL RODRIGUEZ,
		 * SE MODIFICO PARA LA NUEVA FORMA DE LAS RESIDENCIAS 
		 * Y LOS CAMBIOS QUE PIDIO 
		 */
		public function saveReports($idAlumno, $NumeroControl,$fileEvaluacion,$fileFormatoAsesoria,$idEstadoDocumento,$idTipoDocumento,$vNumeroReporte) {
			try {
				
				$folder = '../files/'.$NumeroControl;
				
				if(!file_exists($folder)){
					mkdir($folder,777,true);
				}
			
				$RutaArchivoEvaluacion	     	 = '../files/'.$NumeroControl.'/'.$vNumeroReporte;
				if(!file_exists($RutaArchivoEvaluacion)){
					mkdir($RutaArchivoEvaluacion,777,true);
				}

				$RutaArchivoEvaluacion .=  "/".$fileEvaluacion['name'];
				$SuccessEvaluacion 			 	 = move_uploaded_file($fileEvaluacion['tmp_name'], $RutaArchivoEvaluacion);
				
			

				$RutaArchivoFormatoAsesoria   	 = '../files/'.$NumeroControl.'/'.$vNumeroReporte;
				if(!file_exists($RutaArchivoFormatoAsesoria)){
					mkdir($RutaArchivoFormatoAsesoria,777,true);
				}
				$RutaArchivoFormatoAsesoria .= "/".$fileFormatoAsesoria['name'];
				$SuccessFormatoAsesoria		 	 = move_uploaded_file($fileFormatoAsesoria['tmp_name'], $RutaArchivoFormatoAsesoria);


				$SQLIdProyecto = $this->CONNECTION->PREPARE(
					"SELECT 
						idProyectoSeleccionado 
					 FROM proyectoseleccionado 
					 WHERE idAlumno = :idAlumno");
				$this->CONNECTION->beginTransaction();
				
				$jsonRutas = "[{\"evaluacionNombre\":\"".$RutaArchivoEvaluacion."\",\"formatpAsesoriaNombre\":\"".$RutaArchivoFormatoAsesoria."\"}]";
				$jsonNombre = "[{\"evaluacionNombre\":\"".$fileEvaluacion['name']."\",\"formatpAsesoriaNombre\":\"".$fileFormatoAsesoria['name']."\"}]";

				if($SuccessEvaluacion && $SuccessFormatoAsesoria) {
					$SQLIdProyecto->bindParam(":idAlumno",$idAlumno);
					$SQLIdProyecto->execute();
					$IDProyecto = $SQLIdProyecto->fetch(PDO::FETCH_ASSOC);


					$SQLReporte = $this->CONNECTION->PREPARE(
						"INSERT INTO documentos
							(
								idProyectoSeleccionado,
								idAlumno,
								idTipoDocumento,
								idEstado,
								vNombre,
								vRuta
							) 
							VALUES 
							(
								:idProyectoSeleccionado,
								:idAlumno,
								:idTipoDocumento,
								:idEstado,
								:vNombre,
								:vRuta
							)");

					$SQLReporte->bindParam(":idProyectoSeleccionado",$IDProyecto['idProyectoSeleccionado']);
					$SQLReporte->bindParam(":vNombre",$jsonNombre);
					$SQLReporte->bindParam(":idTipoDocumento",$idTipoDocumento);
					$SQLReporte->bindParam(":idEstado",$idEstadoDocumento);
					$SQLReporte->bindParam(":vRuta",$jsonRutas); // SE METIO UN JSON PARA PODER TENER LOS ARCHIVOS QUE SE GUARDAN
															// EN LA NUEVA EVALUACION, Y PARA NO MODIFICAR LA BASE DE DATOS SE METIO EL JSON
					$SQLReporte->bindParam(":idAlumno",$idAlumno);
					$SQLReporte->execute();

					$SQLINTPROCESS = $this->CONNECTION->PREPARE(
						"UPDATE alumnos 
						 	SET iProceso = ".$idTipoDocumento."
						 WHERE idAlumno = :idAlumno"
						 );
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
			@session_unset($_SESSION['tipoUsuario']);
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


		/* ADMINISTRADOR */
		public function getAlumnos() {
			try {
				$SQL = $this->CONNECTION->PREPARE("SELECT
													  A.idAlumno,
													  A.idCarrera,
													  C.vCarrera,
													  A.idUsuario,
													  A.bSexo,
													  A.vNumeroControl,
													  A.vNombre,
													  A.vApellidoPaterno,
													  A.vApellidoMaterno,
													  A.vSemestre,
													  A.vPlanEstudios,
													  A.dFechaIngreso,
													  A.dFechaTermino,
													  A.iCreditosTotales,
													  A.iCreditosAcumulados,
													  A.fPorcentaje,
													  A.iPeriodo,
													  A.fPromedio,
													  A.vSituacion,
													  A.bServicioSocial,
													  A.bActividadesComplementarias,
													  A.bMateriasEspecial,
													  A.vCorreoInstitucional,
													  A.dFechaNacimiento
													FROM alumnos A
													INNER JOIN carreras C
													ON A.idCarrera = C.idCarrera
													ORDER BY A.idAlumno DESC
													");
				$SQL->execute();
				return $SQL;
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function getCarreras() {
			try {
				$SQL = $this->CONNECTION->PREPARE("SELECT idCarrera, vCarrera, vClave FROM carreras WHERE bActivo = 1");

				$SQL->execute();
				return $SQL;
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function getAllCarreras() {
			try {
				$SQL = $this->CONNECTION->PREPARE("SELECT idCarrera, vCarrera, vClave, bActivo FROM carreras");
				$SQL->execute();
				return $SQL;
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function getAllPeriodos(){
			try {
				$SQL = $this->CONNECTION->PREPARE("SELECT idPeriodo, vPeriodo, bActivo FROM periodos");
				$SQL->execute();
				return $SQL;
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function getAllFechasEntrega(){
			try {
				$SQL = $this->CONNECTION->PREPARE("SELECT
													FEP.idFechaEntregaPeriodo,
													FEP.vDescripcion,
													FEP.dFechaInicioEntrega,
													FEP.dFechaFinalEntrega,
													P.vPeriodo,
													P.idPeriodo
													FROM fechasentregaperiodo FEP
													INNER JOIN periodos P
													ON FEP.idPeriodo = P.idPeriodo");
				$SQL->execute();
				return $SQL;
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function getAllEmpresas(){
			try {
				$SQL = $this->CONNECTION->PREPARE("SELECT idEmpresa, vNombreEmpresa,vGradoEstudios,vCorreoElectronico, vDireccion, vTitular, vContacto FROM empresas");
				$SQL->execute();
				return $SQL;
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}
		public function getAllGiros(){
			try {
				$SQL = $this->CONNECTION->PREPARE("SELECT idGiro, vGiro FROM giros WHERE bActivo = 1");
				$SQL->execute();
				return $SQL;
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}
		public function getAllOpciones(){
			try {
				$SQL = $this->CONNECTION->PREPARE("SELECT idOpcion, vOpcion FROM opciones WHERE bActivo = 1");
				$SQL->execute();
				return $SQL;
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
						</div>';
			}
		}
		public function getOpciones(){
			try {
				$SQL = $this->CONNECTION->PREPARE("SELECT idOpcion, vOpcion, vClave, bActivo FROM opciones");
				$SQL->execute();
				return $SQL;
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
						</div>';
			}
		}
		public function actualizarOpcion($idOpcion, $Opcion, $Clave){
			try {
				$SQL = $this->CONNECTION->PREPARE("
						UPDATE
							opciones
							SET
								vOpcion = :vOpcion,
								vClave = :vClave
						WHERE idOpcion = :idOpcion
					");
				$SQL->bindParam(":idOpcion",$idOpcion);
				$SQL->bindParam(":vOpcion",$Opcion);
				$SQL->bindParam(":vClave",$Clave);
				$SQL->execute();

				echo '<div class="alert alert-dismissable alert-success">Opcion con Clave: '.$Clave.' ha sido actualizada exitosamente!
							<button type="button" class="close" data-dismiss="alert">x</button>
						  </div>';
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
					<button type="button" class="close" data-dismiss="alert">x</button>
				  </div>';
			}
		}
		public function changeStatusOpcion($idOpcion, $status) {
			try {
				$STATUSNEW = "";
				switch ($status) {
					case '1':
						$STATUSNEW = 0;
						break;

					case '0':
						$STATUSNEW = 1;
						break;
				}
				$SQL = $this->CONNECTION->PREPARE("UPDATE opciones SET bActivo = :status WHERE idOpcion = :idOpcion");
				$SQL->bindParam(":status",$STATUSNEW);
				$SQL->bindParam(":idOpcion",$idOpcion);
				$SQL->execute();

				if($STATUSNEW == 0) {
					echo '<div class="alert alert-dismissable alert-success">Se ha desactivado correctamente
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
				} else {
					echo '<div class="alert alert-dismissable alert-success">Se ha activado corrrectamente.
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
				}
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}
		public function registrarOpcion($Clave, $Opcion){
			try {
				$SQL = $this->CONNECTION->PREPARE("INSERT INTO opciones (vOpcion,vClave) VALUES (:Opcion, :Clave);");
				$SQL->bindParam(":Opcion",$Clave);
				$SQL->bindParam(":Clave",$Opcion);
				$SQL->execute();

				echo '<div class="alert alert-dismissable alert-success">Opcion con Clave: '.$Clave.' ha sido registrada exitosamente!
							<button type="button" class="close" data-dismiss="alert">x</button>
						  </div>';
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
					<button type="button" class="close" data-dismiss="alert">x</button>
				  </div>';
			}
		}
		public function getAllSectores(){
			try {
				$SQL = $this->CONNECTION->PREPARE("SELECT idSector, vSector FROM sectores WHERE bActivo = 1");
				$SQL->execute();
				return $SQL;
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
						</div>';
			}
		}

		public function getAllProyectos(){
			try {
				$SQL = $this->CONNECTION->PREPARE("
						SELECT
							BP.idBancoProyecto,
							BP.idEmpresa,
							BP.idCarrera,
							BP.idEstado,
							BP.idPeriodo,
							BP.vNombreProyecto,
							BP.vDescripcion,
							BP.vArea,
							BP.vPropuestaDe,
							BP.iTotalResidentes,
							BP.bActive,
							E.vNombreEmpresa,
							C.vCarrera,
							ES.vEstado,
						    PE.vPeriodo
						FROM bancoproyectos BP
						INNER JOIN empresas E
						ON E.idEmpresa = BP.idEmpresa
						INNER JOIN carreras C
						ON BP.idCarrera = C.idCarrera
						INNER JOIN estados ES
						ON BP.idEstado = ES.idEstado
						INNER JOIN periodos PE
						ON PE.idPeriodo = BP.idPeriodo
					");
				$SQL->execute();
				return $SQL;
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function getAllEstados() {
			try {
				$SQL = $this->CONNECTION->PREPARE("SELECT idEstado, vEstado, bActivo FROM estados");
				$SQL->execute();
				return $SQL;
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function registrarAlumno(
				$idCarrera,
				$Sexo,
				$NumeroControl,
				$Nombre,
				$ApellidoPaterno,
				$ApellidoMaterno,
				$Semestre,
				$PlanEstudios,
				$FechaIngreso,
				$FechaTermino,
				$CreditosTotales,
				$CreditosAcumulados,
				$Porcentaje,
				$idPeriodo,
				$Promedio,
				$Situacion,
				$ServicioSocial,
				$ActividadesComplementarias,
				$MateriasEspecial,
				$CorreoInstitucional,
				$FechaNacimiento
			) {
			try {
				$SQLEXISTE = $this->CONNECTION->PREPARE("SELECT COUNT(idUsuario) AS Total FROM alumnos WHERE vNumeroControl = :NumeroControl");
				$SQLEXISTE->bindParam(":NumeroControl", $NumeroControl);
				$SQLEXISTE->execute();

				$TOTAL = $SQLEXISTE->FETCH(PDO::FETCH_ASSOC);

				if($TOTAL['Total'] == 0) {
					$SQLID = $this->CONNECTION->PREPARE("
						INSERT INTO usuarios (idTipoUsuario,vUsuario,vContrasena) VALUES (1,:Usuario,:Contrasena);
					");
					$this->CONNECTION->beginTransaction();
					$SQLID->bindParam(":Usuario",$NumeroControl);
					$SQLID->bindParam(":Contrasena",$NumeroControl);
					$SQLID->execute();

					$IDUSUARIO_ = $this->CONNECTION->lastInsertId();

					$SQL = $this->CONNECTION->PREPARE("
							INSERT INTO alumnos
							(
								idCarrera,
								idUsuario,
								bSexo,
								vNumeroControl,
								vNombre,
								vApellidoPaterno,
								vApellidoMaterno,
								vSemestre,
								vPlanEstudios,
								dFechaIngreso,
								dFechaTermino,
								iCreditosTotales,
								iCreditosAcumulados,
								fPorcentaje,
								idPeriodo,
								fPromedio,
								vSituacion,
								bServicioSocial,
								bActividadesComplementarias,
								bMateriasEspecial,
								vCorreoInstitucional,
								dFechaNacimiento
							)
							VALUES
							(
								:idCarrera,
								:idUsuario,
								:bSexo,
								:vNumeroControl,
								:vNombre,
								:vApellidoPaterno,
								:vApellidoMaterno,
								:vSemestre,
								:vPlanEstudios,
								:dFechaIngreso,
								:dFechaTermino,
								:iCreditosTotales,
								:iCreditosAcumulados,
								:fPorcentaje,
								:idPeriodo,
								:fPromedio,
								:vSituacion,
								:bServicioSocial,
								:bActividadesComplementarias,
								:bMateriasEspecial,
								:vCorreoInstitucional,
								:dFechaNacimiento
							);
						");

					$SQL->bindParam(":idCarrera",$idCarrera);
					$SQL->bindParam(":idUsuario",$IDUSUARIO_);
					$SQL->bindParam(":bSexo",$Sexo);
					$SQL->bindParam(":vNumeroControl",$NumeroControl);
					$SQL->bindParam(":vNombre",$Nombre);
					$SQL->bindParam(":vApellidoPaterno",$ApellidoPaterno);
					$SQL->bindParam(":vApellidoMaterno",$ApellidoMaterno);
					$SQL->bindParam(":vSemestre",$Semestre);
					$SQL->bindParam(":vPlanEstudios",$PlanEstudios);
					$SQL->bindParam(":dFechaIngreso",$FechaIngreso);
					$SQL->bindParam(":dFechaTermino",$FechaTermino);
					$SQL->bindParam(":iCreditosTotales",$CreditosTotales);
					$SQL->bindParam(":iCreditosAcumulados",$CreditosAcumulados);
					$SQL->bindParam(":fPorcentaje",$Porcentaje);
					$SQL->bindParam(":idPeriodo",$idPeriodo);
					$SQL->bindParam(":fPromedio",$Promedio);
					$SQL->bindParam(":vSituacion",$Situacion);
					$SQL->bindParam(":bServicioSocial",$ServicioSocial);
					$SQL->bindParam(":bActividadesComplementarias",$ActividadesComplementariasc);
					$SQL->bindParam(":bMateriasEspecial",$MateriasEspecial);
					$SQL->bindParam(":vCorreoInstitucional",$CorreoInstitucional);
					$SQL->bindParam(":dFechaNacimiento",$FechaNacimiento);

					$SQL->execute();
					$this->CONNECTION->commit();
					echo '<div class="alert alert-dismissable alert-success">¡Alumno con número de Control: '.$NumeroControl.'  registrado exitosamente!
							<button type="button" class="close" data-dismiss="alert">x</button>
						  </div>';
				} else {
					echo '<div class="alert alert-dismissable alert-warning">Ya existe un alumno registrado con el número de control: '.$NumeroControl.'
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

		public function actualizarAlumno(
				$idAlumno,
				$idCarrera,
				$Sexo,
				$NumeroControl,
				$Nombre,
				$ApellidoPaterno,
				$ApellidoMaterno,
				$Semestre,
				$PlanEstudios,
				$FechaIngreso,
				$FechaTermino,
				$CreditosTotales,
				$CreditosAcumulados,
				$Porcentaje,
				$idPeriodo,
				$Promedio,
				$Situacion,
				$ServicioSocial,
				$ActividadesComplementarias,
				$MateriasEspecial,
				$CorreoInstitucional,
				$FechaNacimiento
		){
			try {
				$SQL = $this->CONNECTION->PREPARE("
						UPDATE
							alumnos
							SET
								idCarrera = :idCarrera,
								bSexo	  = :bSexo,
								vNumeroControl = :vNumeroControl,
								vNombre = :vNombre,
								vApellidoPaterno = :vApellidoPaterno,
								vApellidoMaterno = :vApellidoMaterno,
								vSemestre = :vSemestre,
								vPlanEstudios = :vPlanEstudios,
								dFechaIngreso = :dFechaIngreso,
								dFechaTermino = :dFechaTermino,
								iCreditosTotales = :iCreditosTotales,
								iCreditosAcumulados = :iCreditosAcumulados,
								fPorcentaje = :fPorcentaje,
								idPeriodo = :idPeriodo,
								fPromedio = :fPromedio,
								vSituacion = :vSituacion,
								bServicioSocial = :bServicioSocial,
								bActividadesComplementarias = :bActividadesComplementarias,
								bMateriasEspecial = :bMateriasEspecial,
								vCorreoInstitucional = :vCorreoInstitucional,
								dFechaNacimiento = :dFechaNacimiento
						WHERE idAlumno = :idAlumno
					");
				$SQL->bindParam(":idAlumno", $idAlumno);
				$SQL->bindParam(":idCarrera",$idCarrera);
				$SQL->bindParam(":bSexo", $Sexo);
				$SQL->bindParam(":vNumeroControl", $NumeroControl);
				$SQL->bindParam(":vNombre", $Nombre);
				$SQL->bindParam(":vApellidoPaterno", $ApellidoPaterno);
				$SQL->bindParam(":vApellidoMaterno", $ApellidoMaterno);
				$SQL->bindParam(":vSemestre", $Semestre);
				$SQL->bindParam(":vPlanEstudios", $PlanEstudios);
				$SQL->bindParam(":dFechaIngreso", $FechaIngreso);
				$SQL->bindParam(":dFechaTermino", $FechaTermino);
				$SQL->bindParam(":iCreditosTotales", $CreditosTotales);
				$SQL->bindParam(":iCreditosAcumulados", $CreditosAcumulados);
				$SQL->bindParam(":fPorcentaje", $Porcentaje);
				$SQL->bindParam(":idPeriodo", $idPeriodo);
				$SQL->bindParam(":fPromedio", $Promedio);
				$SQL->bindParam(":vSituacion", $Situacion);
				$SQL->bindParam(":bServicioSocial", $ServicioSocial);
				$SQL->bindParam(":bActividadesComplementarias", $ActividadesComplementarias);
				$SQL->bindParam(":bMateriasEspecial", $MateriasEspecial);
				$SQL->bindParam(":vCorreoInstitucional", $CorreoInstitucional);
				$SQL->bindParam(":dFechaNacimiento", $FechaNacimiento);

				$SQL->execute();

				echo '<div class="alert alert-dismissable alert-success">¡Alumno con número de Control: '.$NumeroControl.'  actualizado exitosamente!
							<button type="button" class="close" data-dismiss="alert">x</button>
						  </div>';
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function registrarCarrera($Clave, $Carrera){
			try {
				$SQL = $this->CONNECTION->PREPARE("INSERT INTO carreras (vClave,vCarrera) VALUES (:Clave, :Carrera);");
				$SQL->bindParam(":Clave",$Clave);
				$SQL->bindParam(":Carrera",$Carrera);
				$SQL->execute();

				echo '<div class="alert alert-dismissable alert-success">¡Carrera con Clave: '.$Clave.' ha sido registrada exitosamente!
							<button type="button" class="close" data-dismiss="alert">x</button>
						  </div>';
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
					<button type="button" class="close" data-dismiss="alert">x</button>
				  </div>';
			}
		}

		public function actualizarCarrera($idCarrera, $Clave, $Carrera){
			try {
				$SQL = $this->CONNECTION->PREPARE("
						UPDATE
							carreras
							SET
								vClave = :vClave,
								vCarrera = :vCarrera
						WHERE idCarrera = :idCarrera
					");
				$SQL->bindParam(":idCarrera",$idCarrera);
				$SQL->bindParam(":vClave",$Clave);
				$SQL->bindParam(":vCarrera",$Carrera);
				$SQL->execute();

				echo '<div class="alert alert-dismissable alert-success">¡Carrera con Clave: '.$Clave.' ha sido actualizada exitosamente!
							<button type="button" class="close" data-dismiss="alert">x</button>
						  </div>';
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
					<button type="button" class="close" data-dismiss="alert">x</button>
				  </div>';
			}
		}


		public function changeStatusCarrera($idCarrera, $status) {
			try {
				$STATUSNEW = "";
				switch ($status) {
					case '1':
						$STATUSNEW = 0;
						break;

					case '0':
						$STATUSNEW = 1;
						break;
				}
				$SQL = $this->CONNECTION->PREPARE("UPDATE carreras SET bActivo = :status WHERE idCarrera = :idCarrera");
				$SQL->bindParam(":status",$STATUSNEW);
				$SQL->bindParam(":idCarrera",$idCarrera);
				$SQL->execute();

				if($STATUSNEW == 0) {
					echo '<div class="alert alert-dismissable alert-success">Se ha desactivado correctamente
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
				} else {
					echo '<div class="alert alert-dismissable alert-success">Se ha activado corrrectamente.
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
				}
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function changeStatusPeriodo($idPeriodo, $status) {
			try {
				$STATUSNEW = "";
				switch ($status) {
					case '1':
						$STATUSNEW = 0;
						break;

					case '0':
						$STATUSNEW = 1;
						break;
				}
				$SQL = $this->CONNECTION->PREPARE("UPDATE periodos SET bActivo = :status WHERE idPeriodo = :idPeriodo");
				$SQL->bindParam(":status",$STATUSNEW);
				$SQL->bindParam(":idPeriodo",$idPeriodo);
				$SQL->execute();

				if($STATUSNEW == 0) {
					echo '<div class="alert alert-dismissable alert-success">Se ha desactivado correctamente
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
				} else {
					echo '<div class="alert alert-dismissable alert-success">Se ha activado corrrectamente.
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
				}
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function registrarPeriodo($Periodo){
			try {
				$SQL = $this->CONNECTION->PREPARE("INSERT INTO periodos (vPeriodo) VALUES (:Periodo);");
				$SQL->bindParam(":Periodo",$Periodo);
				$SQL->execute();

				echo '<div class="alert alert-dismissable alert-success">¡El periodo ha sido registrado exitosamente!
							<button type="button" class="close" data-dismiss="alert">x</button>
						  </div>';
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function actualizarPeriodo($idPeriodo, $Periodo){
			try {
				$SQL = $this->CONNECTION->PREPARE("UPDATE periodos SET vPeriodo = :Periodo WHERE idPeriodo = :idPeriodo");
				$SQL->bindParam(":Periodo",$Periodo);
				$SQL->bindParam(":idPeriodo",$idPeriodo);
				$SQL->execute();

				echo '<div class="alert alert-dismissable alert-success">¡El periodo ha sido actualizado exitosamente!
							<button type="button" class="close" data-dismiss="alert">x</button>
						  </div>';
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function registrarFechaPeriodo($idPeriodo, $Descripcion, $FechaInicio, $FechaFinal){
			try {
				$SQL = $this->CONNECTION->PREPARE("
						INSERT INTO fechasentregaperiodo (
							idPeriodo,
							vDescripcion,
							dFechaInicioEntrega,
							dFechaFinalEntrega
						) VALUES (
							:idPeriodo,
							:vDescripcion,
							:dFechaInicioEntrega,
							:dFechaFinalEntrega
						);
					");
				$SQL->bindParam(":idPeriodo", $idPeriodo);
				$SQL->bindParam(":vDescripcion", $Descripcion);
				$SQL->bindParam(":dFechaInicioEntrega", $FechaInicio);
				$SQL->bindParam(":dFechaFinalEntrega", $FechaFinal);
				$SQL->execute();

				echo '<div class="alert alert-dismissable alert-success">¡La fecha ha sido registrada exitosamente!
							<button type="button" class="close" data-dismiss="alert">x</button>
						  </div>';
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function actualizarFechaPeriodo($idFechaEntregaPeriodo, $idPeriodo, $Descripcion, $FechaInicio, $FechaFinal) {
			try {
				$SQL = $this->CONNECTION->PREPARE("
						UPDATE fechasentregaperiodo
							SET
								idPeriodo = :idPeriodo,
								vDescripcion = :vDescripcion,
								dFechaInicioEntrega = :dFechaInicioEntrega,
								dFechaFinalEntrega = :dFechaFinalEntrega
						WHERE idFechaEntregaPeriodo = :idFechaEntregaPeriodo
					");
				$SQL->bindParam(":idFechaEntregaPeriodo", $idFechaEntregaPeriodo);
				$SQL->bindParam(":idPeriodo", $idPeriodo);
				$SQL->bindParam(":vDescripcion", $Descripcion);
				$SQL->bindParam(":dFechaInicioEntrega", $FechaInicio);
				$SQL->bindParam(":dFechaFinalEntrega", $FechaFinal);
				$SQL->execute();

				echo '<div class="alert alert-dismissable alert-success">¡La fecha ha sido actualizada exitosamente!
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function eliminarFechaPeriodo($idFechaEntregaPeriodo){
			try {
				$SQL = $this->CONNECTION->PREPARE("DELETE FROM fechasentregaperiodo WHERE idFechaEntregaPeriodo = :idFecha");
				$SQL->bindParam(":idFecha", $idFechaEntregaPeriodo);
				$SQL->execute();

				echo '<div class="alert alert-dismissable alert-success">¡La fecha ha sido eliminada exitosamente!
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function registrarEmpresa($Nombre, $Correo, $Direccion, $Titular, $Contacto,$vGradoEstudios){
			try {
				$SQL = $this->CONNECTION->PREPARE("
						INSERT INTO empresas (
							vNombreEmpresa,
							vCorreoElectronico,
							vDireccion,
							vTitular,
							vContacto,
							vGradoEstudios
						) VALUES (
							:Nombre,
							:Correo,
							:Direccion,
							:Titular,
							:Contacto,
							:vGradoEstudios
						)
					");
				$SQL->bindParam(":Nombre",$Nombre);
				$SQL->bindParam(":Correo", $Correo);
				$SQL->bindParam(":Direccion", $Direccion);
				$SQL->bindParam(":Titular", $Titular);
				$SQL->bindParam(":Contacto", $Contacto);
				$SQL->bindParam(":vGradoEstudios", $vGradoEstudios);
				$SQL->execute();

				echo '<div class="alert alert-dismissable alert-success">¡La empresa '.$Nombre.' ha sido registrada exitosamente!
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function actualizarEmpresa($idEmpresa, $Nombre, $Correo, $Direccion, $Titular, $Contacto,$vGradoEstudios){
			try {
				$SQL = $this->CONNECTION->PREPARE("
						UPDATE
							empresas
							SET
								vNombreEmpresa = :Nombre,
								vCorreoElectronico = :Correo,
								vDireccion = :Direccion,
								vTitular = :Titular,
								vContacto = :Contacto,
								vGradoEstudios = :vGradoEstudios
						WHERE idEmpresa = :idEmpresa
					");
				$SQL->bindParam(":idEmpresa", $idEmpresa);
				$SQL->bindParam(":Nombre",$Nombre);
				$SQL->bindParam(":Correo", $Correo);
				$SQL->bindParam(":Direccion", $Direccion);
				$SQL->bindParam(":Titular", $Titular);
				$SQL->bindParam(":Contacto", $Contacto);
				$SQL->bindParam(":vGradoEstudios", $vGradoEstudios);
				$SQL->execute();

				echo '<div class="alert alert-dismissable alert-success">¡La empresa ha sido actualizada exitosamente!
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function registrarProyecto($idEmpresa, $idCarrera, $idEstado, $idPeriodo, $Proyecto, $Descripcion, $Area, $PropuestaDe, $TotalResidentes) {
			try {
				$SQL = $this->CONNECTION->PREPARE("
						INSERT INTO bancoproyectos (
							idEmpresa,
							idCarrera,
							idEstado,
							idPeriodo,
							vNombreProyecto,
							vDescripcion,
							vArea,
							vPropuestaDe,
							iTotalResidentes,
							bActive
						) VALUES (
							:idEmpresa,
							:idCarrera,
							:idEstado,
							:idPeriodo,
							:vNombreProyecto,
							:vDescripcion,
							:vArea,
							:vPropuestaDe,
							:iTotalResidentes,
							1
						);
					");
				$SQL->bindParam(":idEmpresa", $idEmpresa);
				$SQL->bindParam(":idCarrera", $idCarrera);
				$SQL->bindParam(":idEstado", $idEstado);
				$SQL->bindParam(":idPeriodo", $idPeriodo);
				$SQL->bindParam(":vNombreProyecto", $Proyecto);
				$SQL->bindParam(":vDescripcion", $Descripcion);
				$SQL->bindParam(":vArea", $Area);
				$SQL->bindParam(":vPropuestaDe", $PropuestaDe);
				$SQL->bindParam(":iTotalResidentes", $TotalResidentes);

				$SQL->execute();

				echo '<div class="alert alert-dismissable alert-success">¡El proyecto ha sido registrado exitosamente!
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function actualizarProyecto($idBancoProyecto, $idEmpresa, $idCarrera, $idEstado, $idPeriodo, $Proyecto, $Descripcion, $Area, $PropuestaDe, $TotalResidentes){
			try {
				$SQL = $this->CONNECTION->PREPARE("
						UPDATE
							bancoproyectos
							SET
								idEmpresa = :idEmpresa,
								idCarrera = :idCarrera,
								idEstado = :idEstado,
								idPeriodo = :idPeriodo,
								vNombreProyecto = :vNombreProyecto,
								vDescripcion = :vDescripcion,
								vArea = :vArea,
								vPropuestaDe = :vPropuestaDe,
								iTotalResidentes = :iTotalResidentes
						WHERE idBancoProyecto = :idBancoProyecto
					");

				$SQL->bindParam(":idBancoProyecto", $idBancoProyecto);
				$SQL->bindParam(":idEmpresa", $idEmpresa);
				$SQL->bindParam(":idCarrera", $idCarrera);
				$SQL->bindParam(":idEstado", $idEstado);
				$SQL->bindParam(":idPeriodo", $idPeriodo);
				$SQL->bindParam(":vNombreProyecto", $Proyecto);
				$SQL->bindParam(":vDescripcion", $Descripcion);
				$SQL->bindParam(":vArea", $Area);
				$SQL->bindParam(":vPropuestaDe", $PropuestaDe);
				$SQL->bindParam(":iTotalResidentes", $TotalResidentes);

				$SQL->execute();

				echo '<div class="alert alert-dismissable alert-success">¡El proyecto ha sido actualizado exitosamente!
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function cambiarEstadoProyecto($idBancoProyecto, $status) {
			try {
				$STATUSNEW = "";
				switch ($status) {
					case '1':
						$STATUSNEW = 0;
						break;

					case '0':
						$STATUSNEW = 1;
						break;
				}
				$SQL = $this->CONNECTION->PREPARE("UPDATE bancoproyectos SET bActive = :status WHERE idBancoProyecto = :idBancoProyecto");
				$SQL->bindParam(":status",$STATUSNEW);
				$SQL->bindParam(":idBancoProyecto",$idBancoProyecto);
				$SQL->execute();

				if($STATUSNEW == 0) {
					echo '<div class="alert alert-dismissable alert-success">Se ha desactivado correctamente
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
				} else {
					echo '<div class="alert alert-dismissable alert-success">Se ha activado corrrectamente.
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
				}
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}


		# JEFES DE CARRERA
		public function getSolicitudesResidenciasByJefeCarrera($idJefeCarrera){
			try {
				$SQLJEFE = $this->CONNECTION->PREPARE("SELECT idCarrera FROM jefescarrera WHERE idJefeCarrera = :idJefeCarrera");
				$SQLJEFE->bindParam(":idJefeCarrera",$idJefeCarrera);
				$SQLJEFE->execute();

				$IDCARRERA = $SQLJEFE->FETCH(PDO::FETCH_ASSOC);

				$SQL = $this->CONNECTION->PREPARE("
									SELECT
										PS.idProyectoSeleccionado,
										PS.idBancoProyecto,
										PS.idAlumno,
										PS.idPeriodo,
										PS.idOpcion,
										PS.idGiro,
										PS.idEstado,
										PS.idSector,
										PS.vMotivoNoAceptacion,
										BP.vNombreProyecto,
										A.vNumeroControl,
										A.vNombre,
										A.vApellidoPaterno,
										A.vApellidoMaterno,
										P.vPeriodo,
										O.vOpcion,
										G.vGiro,
										E.vEstado,
										S.vSector
									FROM proyectoseleccionado AS PS
									INNER JOIN bancoproyectos AS BP
									ON BP.idBancoProyecto = PS.idBancoProyecto
									INNER JOIN alumnos AS A
									ON A.idAlumno = PS.idAlumno
									INNER JOIN periodos AS P
									ON P.idPeriodo = PS.idPeriodo
									INNER JOIN opciones AS O
									ON O.idOpcion = PS.idOpcion
									INNER JOIN giros AS G
									ON G.idGiro = PS.idGiro
									INNER JOIN estados AS E
									ON E.idEstado = PS.idEstado
									INNER JOIN sectores AS S
									ON S.idSector = PS.idSector
									WHERE A.idCarrera = :idCarrera
									ORDER BY PS.idProyectoSeleccionado DESC
				");
				$SQL->bindParam(":idCarrera", $IDCARRERA['idCarrera']);
				$SQL->execute();
				return $SQL;
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function getSolicitudesResidenciasByJefeCarreraAjax($idJefeCarrera, $NumeroControl) {
			try {
				$SQLJEFE = $this->CONNECTION->PREPARE("SELECT idCarrera FROM jefescarrera WHERE idJefeCarrera = :idJefeCarrera");
				$SQLJEFE->bindParam(":idJefeCarrera",$idJefeCarrera);
				$SQLJEFE->execute();

				$IDCARRERA = $SQLJEFE->FETCH(PDO::FETCH_ASSOC);

				$SQL = $this->CONNECTION->PREPARE("
									SELECT
										PS.idProyectoSeleccionado,
										PS.idBancoProyecto,
										PS.idAlumno,
										PS.idPeriodo,
										PS.idOpcion,
										PS.idGiro,
										PS.idEstado,
										PS.idSector,
										PS.vMotivoNoAceptacion,
										BP.vNombreProyecto,
										A.vNumeroControl,
										A.vNombre,
										A.vApellidoPaterno,
										A.vApellidoMaterno,
										P.vPeriodo,
										O.vOpcion,
										G.vGiro,
										E.vEstado,
										S.vSector
									FROM proyectoseleccionado AS PS
									INNER JOIN bancoproyectos AS BP
									ON BP.idBancoProyecto = PS.idBancoProyecto
									INNER JOIN alumnos AS A
									ON A.idAlumno = PS.idAlumno
									INNER JOIN periodos AS P
									ON P.idPeriodo = PS.idPeriodo
									INNER JOIN opciones AS O
									ON O.idOpcion = PS.idOpcion
									INNER JOIN giros AS G
									ON G.idGiro = PS.idGiro
									INNER JOIN estados AS E
									ON E.idEstado = PS.idEstado
									INNER JOIN sectores AS S
									ON S.idSector = PS.idSector
									WHERE A.idCarrera = :idCarrera
									AND A.NumeroControl LIKE %:NumeroControl%
									ORDER BY PS.idProyectoSeleccionado DESC
				");
				$SQL->bindParam(":idCarrera", $IDCARRERA['idCarrera']);
				$SQL->bindParam(":NumeroControl", $NumeroControl);
				$SQL->execute();
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function aceptarSolicitud($idProyecto){
			try {
				$SQL = $this->CONNECTION->PREPARE("UPDATE proyectoseleccionado SET idEstado = 5 WHERE idProyectoSeleccionado = :idProyecto");
				$SQL->bindParam(":idProyecto", $idProyecto);
				$SQL->execute();

				echo '<div class="alert alert-dismissable alert-success">Se ha aceptado correctamente la solicitud.
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function rechazarSolicitud($idProyecto, $MotivoRechazo) {
			try {
				$SQL = $this->CONNECTION->PREPARE("UPDATE proyectoseleccionado SET idEstado = 6, vMotivoNoAceptacion = :MotivoRechazo WHERE idProyectoSeleccionado = :idProyecto");
				$SQL->bindParam(":idProyecto", $idProyecto);
				$SQL->bindParam(":MotivoRechazo", $MotivoRechazo);
				$SQL->execute();

				echo '<div class="alert alert-dismissable alert-success">Se ha rechazado correctamente la solicitud.
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function getAllODT(){
			try {
				$SQL = $this->CONNECTION->PREPARE("SELECT idOdt, vNombreOdt, vRuta FROM odt");
				$SQL->execute();
				return $SQL;
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function actualizarODT($idOdt, $NombreOdt, $Ruta, $Archivo) {
			try {
				$RutaArchivo = "../pages/exportFilesTbsOdt/filesOdt/";
				$RutaSQL = $Ruta;
				$SQL = $this->CONNECTION->PREPARE("UPDATE odt SET vNombreOdt = :Nombre, vRuta = :Ruta WHERE idOdt = :idODT");
				$this->CONNECTION->beginTransaction();

				if($Archivo['name'] != "") {
					try {
						move_uploaded_file($Archivo['tmp_name'], $RutaArchivo.$Archivo['name']);
						@unlink($RutaArchivo.$Ruta);
						$RutaSQL = $Archivo['name'];
					} catch (Exception $ex) {
						@unlink($RutaArchivo.$Archivo['name']);
						$this->CONNECTION->rollback();
						exit('<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$ex->getMessage().'
								<button type="button" class="close" data-dismiss="alert">x</button>
							  </div>');
					}
				}

				$SQL->bindParam(":idODT",$idOdt);
				$SQL->bindParam(":Nombre", $NombreOdt);
				$SQL->bindParam(":Ruta", $RutaSQL);
				$SQL->execute();

				$this->CONNECTION->commit();
				echo '<div class="alert alert-dismissable alert-success">Se ha realizado la actualización correctamente.
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			} catch (PDOException $e) {
				$this->CONNECTION->rollback();
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function getDictamenAceptados(){
			try {
				$SQL = $this->CONNECTION->PREPARE("SELECT
														PS.idProyectoSeleccionado,
													    A.idAlumno,
													    A.vNumeroControl,
													    A.vNombre,
													    A.vApellidoPaterno,
													    A.vApellidoMaterno,
													    A.vCorreoInstitucional,
													    A.telefono,
													    A.bSexo,
													    PS.idbancoProyecto,
													    BP.vNombreProyecto,
													    E.vNombreEmpresa,
													   	PS.asesorInterno,
													    PS.asesorExterno
													FROM proyectoseleccionado PS
													INNER JOIN alumnos A
													ON PS.idAlumno = A.idAlumno
													INNER JOIN bancoproyectos BP
													ON BP.idbancoProyecto = PS.idbancoProyecto
													INNER JOIN empresas E
													ON E.idEmpresa = BP.idEmpresa
													WHERE PS.idEstado = 5
													ORDER BY PS.idProyectoSeleccionado DESC");
				$SQL->execute();
				return $SQL;
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function getDictamenRechazados(){
			try {
				$SQL = $this->CONNECTION->PREPARE("SELECT
														PS.idProyectoSeleccionado,
													    A.idAlumno,
													    A.vNumeroControl,
													    A.vNombre,
													    A.vApellidoPaterno,
													    A.vApellidoMaterno,
													    A.vCorreoInstitucional,
													    A.telefono,
													    A.bSexo,
													    PS.idbancoProyecto,
													    BP.vNombreProyecto,
													    E.vNombreEmpresa,
													   	PS.asesorInterno,
													    PS.asesorExterno
													FROM proyectoseleccionado PS
													INNER JOIN alumnos A
													ON PS.idAlumno = A.idAlumno
													INNER JOIN bancoproyectos BP
													ON BP.idbancoProyecto = PS.idbancoProyecto
													INNER JOIN empresas E
													ON E.idEmpresa = BP.idEmpresa
													WHERE PS.idEstado = 6
													ORDER BY PS.idProyectoSeleccionado DESC");
				$SQL->execute();
				return $SQL;
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		/*APARTADO PARA LAS ESTADISTICAS*/
		public function graficaOpcionElegida(){
			$StatementSQL = $this->CONNECTION->PREPARE(
				"SELECT carr.vClave as 'Carrera', 
				op.vOpcion as 'Opcion',
				op.vClave AS vClaveOpcion,
				COUNT(ps.idOpcion) as 'Total' FROM proyectoseleccionado as ps 
				INNER JOIN alumnos as al ON ps.idAlumno = al.idAlumno 
				INNER JOIN carreras as carr ON al.idCarrera = carr.idCarrera 
				INNER JOIN opciones as op ON ps.idOpcion = op.idOpcion 
				GROUP BY 
				ps.idOpcion,
				carr.vCarrera,
				op.vClave
				HAVING COUNT(ps.idOpcion)");
			$StatementSQL->execute();
			return $StatementSQL->fetchAll();
		}

		public function graficaImpactoAmbiental($idCarrera){
			if(isset($idCarrera['idCarrera']))
			{
				$Buscar = $idCarrera['idCarrera'];
			}
			else
			{
				$Buscar = $idCarrera;
			}
			$StatementSQL = $this->CONNECTION->PREPARE(
					"SELECT carr.vClave AS 'Carrera',
					'IA' AS Impacto, 
					carr.idCarrera AS 'idCarrera',
					COUNT(ps.idGiro) as 'Total' FROM proyectoseleccionado as ps 
					INNER JOIN alumnos as al ON ps.idAlumno = al.idAlumno 
					INNER JOIN carreras as carr ON al.idCarrera = carr.idCarrera 
					INNER JOIN giros as gir ON ps.idGiro = gir.idGiro
					WHERE carr.idCarrera = :idCarrera
	                AND ps.bImpactoAmbiental = 1
					GROUP BY 
					ps.idGiro,
					carr.vCarrera,
					gir.vGiro
					HAVING COUNT(ps.bImpactoAmbiental)");
			$StatementSQL->bindParam(":idCarrera",$Buscar);
			$StatementSQL->execute();
			return $StatementSQL->fetchAll();
		}

		public function graficaTotalGiro($idCarrera){
			if(isset($idCarrera['idCarrera']))
			{
				$Buscar = $idCarrera['idCarrera'];
			}
			else
			{
				$Buscar = $idCarrera;
			}
			$StatementSQL = $this->CONNECTION->PREPARE(
				"SELECT carr.vClave AS 'Carrera', 
				gir.vGiro AS 'Giro',
				carr.idCarrera AS 'idCarrera',
				gir.vClave AS 'vClaveGiro',
				COUNT(ps.idGiro) as 'Total' FROM proyectoseleccionado as ps 
				INNER JOIN alumnos as al ON ps.idAlumno = al.idAlumno 
				INNER JOIN carreras as carr ON al.idCarrera = carr.idCarrera 
				INNER JOIN giros as gir ON ps.idGiro = gir.idGiro
				WHERE carr.idCarrera = :idCarrera
				GROUP BY 
				ps.idGiro,
				carr.vCarrera,
				gir.vGiro
				HAVING COUNT(ps.idGiro)");
			$StatementSQL->bindParam(":idCarrera",$Buscar);
			$StatementSQL->execute();
			return $StatementSQL->fetchAll();
		}

		public function graficaGiroMujeryHombre($idCarrera){
			if(isset($idCarrera['idCarrera']))
			{
				$Buscar = $idCarrera['idCarrera'];
			}
			else
			{
				$Buscar = $idCarrera;
			}
			$StatementSQL = $this->CONNECTION->PREPARE(
				"SELECT gir.vGiro as 'Giro',
				  carr.vCarrera as 'Carrera',
				  gir.vClave as 'vClaveGiro',
				      IF(al.bSexo=1, 'Hombre', 'Mujer') as Sexo,
				      COUNT(al.bSexo) as Total FROM proyectoseleccionado as ps 
				      INNER JOIN alumnos as al ON ps.idAlumno = al.idAlumno 
				      INNER JOIN carreras as carr ON al.idCarrera = carr.idCarrera 
				      INNER JOIN giros as gir ON ps.idGiro = gir.idGiro
				      WHERE carr.idCarrera = :idCarrera
				      GROUP BY 
				ps.idGiro,
				carr.vCarrera,
				gir.vGiro,
				               al.bSexo
				HAVING COUNT(al.bSexo)");
			$StatementSQL->bindParam(":idCarrera",$Buscar);
			$StatementSQL->execute();
			return $StatementSQL->fetchAll();
		}

		public function graficaSector($idCarrera){
			if(isset($idCarrera['idCarrera']))
			{
				$Buscar = $idCarrera['idCarrera'];
			}
			else
			{
				$Buscar = $idCarrera;
			}
			$StatementSQL = $this->CONNECTION->PREPARE(
				"SELECT carr.vClave as 'Carrera2', 
				sec.vSector as 'Sector',
				sec.vClaveSector as 'vClaveSector',
				COUNT(ps.idSector) as 'Total' FROM proyectoseleccionado as ps 
				INNER JOIN alumnos as al ON ps.idAlumno = al.idAlumno 
				INNER JOIN carreras as carr ON al.idCarrera = carr.idCarrera 
				INNER JOIN sectores as sec ON ps.idSector = sec.idSector
				                 WHERE carr.idCarrera = :idCarrera
				GROUP BY 
				ps.idSector,
				carr.vCarrera,
				sec.idSector
				HAVING COUNT(ps.idSector)");
			$StatementSQL->bindParam(":idCarrera",$Buscar);
			$StatementSQL->execute();
			return $StatementSQL->fetchAll();
		}

		public function graficaSectorMujeryHombre($idCarrera){
			if(isset($idCarrera['idCarrera']))
			{
				$Buscar = $idCarrera['idCarrera'];
			}
			else
			{
				$Buscar = $idCarrera;
			}
			$StatementSQL = $this->CONNECTION->PREPARE(
				"SELECT sec.vSector as 'Sector',
				  carr.vCarrera as 'Carrera',
				  sec.vClaveSector as 'Clave',
				      IF(al.bSexo=1, 'Hombre', 'Mujer') as Sexo,
				      COUNT(al.bSexo) as Total FROM proyectoseleccionado as ps 
				      INNER JOIN alumnos as al ON ps.idAlumno = al.idAlumno 
				      INNER JOIN carreras as carr ON al.idCarrera = carr.idCarrera 
				      INNER JOIN sectores as sec ON ps.idSector = sec.idSector
				      WHERE carr.idCarrera = :idCarrera
				      GROUP BY 
				ps.idSector,
				carr.vCarrera,
				sec.idSector,
				               al.bSexo
				HAVING COUNT(al.bSexo)");
			$StatementSQL->bindParam(":idCarrera",$Buscar);
			$StatementSQL->execute();
			return $StatementSQL->fetchAll();
		}

		public function SubirExcelBancoProyectos($FileExcel){
			//Creamos la Ruta para la carpeta(si esta no ha sido creada) que almanecenara los archivos
			$ruta = "../files/";
	          try {
		            if (!file_exists($ruta)) {
		              mkdir($ruta,0777,true);
		            }
		          } catch (Exception $e) {
		            echo $e->getMessage();
		          }
		    //Creamos el directorio dentro de la carpeta principal
		    $carpetaAdmin = '../files/Admin Residencias';
		        try {
		            if (!file_exists($carpetaAdmin)) {
		              mkdir($carpetaAdmin,0777,true);
		            }
		          } catch (Exception $e) {
		            echo $e->getMessage();
		          }

		    //Creamos la ruta donde se guardara el archivo
		    //Lo guardamos con el nombre Banco de Proyectos y le concatenamos la fecha
		    //en la cual fue subido dicho archivo      
		    $ArchivoExcel = explode('.', $FileExcel['name']);
			$RutaExcel = '../files/Admin Residencias/Banco de Proyectos '.date("Y-m-d").'.'.$ArchivoExcel[1];
			$SuccessExcel = move_uploaded_file($FileExcel['tmp_name'], $RutaExcel);

			if($SuccessExcel) {
				include_once '../PHPExcel/Classes/PHPExcel.php';
				$DirectoryExcel = '../files/Admin Residencias/Banco de Proyectos '.date("Y-m-d").'.'.$ArchivoExcel[1];
				$inputFileType = PHPExcel_IOFactory::identify($DirectoryExcel);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
              	$objPHPExcel = $objReader->load($DirectoryExcel);
              	$sheet = $objPHPExcel->getSheet(0); 
              	$highestRow = $sheet->getHighestRow(); 
              	$highestColumn = $sheet->getHighestColumn();
              

              	for ($row = 2; $row <= $highestRow; $row++) {
              		$vNombreEmpresa = $sheet->getCell("A".$row)->getValue();
              		$vCarrera = $sheet->getCell("B".$row)->getValue();
	                $vPeriodo = $sheet->getCell("C".$row)->getValue();
	                $vNombreProyecto = $sheet->getCell("D".$row)->getValue();
	                $vDescripcion = $sheet->getCell("E".$row)->getValue();
	                $vArea = $sheet->getCell("F".$row)->getValue();
	                $vPropuestaDe = $sheet->getCell("G".$row)->getValue();
	                $iTotalResidentes = $sheet->getCell("H".$row)->getValue();

	                /**********************************************************
	                * Si la empresa no Existe Tomar los valores y registrarla *
	                ***********************************************************/

	                $vContacto = $sheet->getCell("I".$row)->getValue();
	                $vCorreoElectronico = $sheet->getCell("J".$row)->getValue();
	                $vDireccion = $sheet->getCell("K".$row)->getValue();


	                /*echo $vNombreEmpresa;
	                echo "<br>";
	                echo $vCarrera;
	                echo "<br>";
	                echo $vPeriodo;
	                echo "<br>";
	                echo $vNombreEmpresa;
	                echo "<br>";
	                echo $vContacto;
	                echo "<br>";
	                echo $vCorreoElectronico;
	                echo "<br>";*/

	                try {
	                	//Validar que la Carrera Exista
		                $SQLValidarCarrera = $this->CONNECTION->PREPARE("SELECT COUNT(idCarrera) AS Total FROM carreras WHERE vCarrera = :vCarrera");
		                $SQLValidarCarrera->bindParam(":vCarrera",$vCarrera);
		                $SQLValidarCarrera->execute();
		                $SuccessCarrera = $SQLValidarCarrera->FETCH(PDO::FETCH_ASSOC);

		                //Validar que la Empresa este registrada
		                $SQLValidarEmpresa = $this->CONNECTION->PREPARE("SELECT COUNT(idEmpresa) AS Total FROM empresas WHERE vNombreEmpresa = :vNombreEmpresa");
		                $SQLValidarEmpresa->bindParam(":vNombreEmpresa",$vNombreEmpresa);
		                $SQLValidarEmpresa->execute();
		                $SuccessEmpresa = $SQLValidarEmpresa->FETCH(PDO::FETCH_ASSOC);

		                //Validar que el periodo actual
		                $SQLValidarPeriodo = $this->CONNECTION->PREPARE("SELECT COUNT(idPeriodo) AS Total FROM periodos WHERE vPeriodo = :vPeriodo AND bActivo = 1");
		                $SQLValidarPeriodo->bindParam(":vPeriodo",$vPeriodo);
		                $SQLValidarPeriodo->execute();
		                $SuccessPeriodo = $SQLValidarPeriodo->FETCH(PDO::FETCH_ASSOC);

		                /*echo "Carrera = ".$SuccessCarrera['Total'];
		                echo "<br>";
		                echo "Empresa = ".$SuccessEmpresa['Total'];
		                echo "<br>";
		                echo "Periodo = ".$SuccessPeriodo['Total'];*/

		                if ($SuccessEmpresa['Total'] == 0) {
		                	//Registramos Primero si la Empresa no Existe para no perder el Dato
		                	$SQLInsertEmpresa = $this->CONNECTION->PREPARE(
		                		"INSERT INTO empresas (
		                			vNombreEmpresa,
		                			vCorreoElectronico,
		                			vDireccion,
		                			vTitular,
		                			vContacto
		                			)
		                		VALUES (
		                			:vNombreEmpresa,
		                			:vCorreoElectronico,
		                			:vDireccion,
		                			:vTitular,
		                			:vContacto);
		                	");
		                	$SQLInsertEmpresa->bindParam(":vNombreEmpresa",$vNombreEmpresa);
		                	$SQLInsertEmpresa->bindParam(":vCorreoElectronico",$vCorreoElectronico);
		                	$SQLInsertEmpresa->bindParam(":vDireccion",$vDireccion);
		                	$SQLInsertEmpresa->bindParam(":vTitular",$vPropuestaDe);
		                	$SQLInsertEmpresa->bindParam(":vContacto",$vContacto);
		                	$SQLInsertEmpresa->execute();

		                	echo '<div class="alert alert-dismissable alert-success">Nueva Empresa Registrada!!!
									<button type="button" class="close" data-dismiss="alert">x</button>
								  </div>';
		                }//Fin del if que registra la empresa en caso de que no exista
		                $SQLValidarEmpresa->execute();
		                $SuccessEmpresa = $SQLValidarEmpresa->FETCH(PDO::FETCH_ASSOC);

	                	if ($SuccessCarrera['Total'] == 1 && $SuccessEmpresa['Total'] == 1 && $SuccessPeriodo['Total'] == 1) {
	                		
	                		//Obtener el id de la Carrera
	                		$SQLidCarrera = $this->CONNECTION->PREPARE("SELECT idCarrera AS idCar FROM carreras WHERE vCarrera = :vCarrera");
	                		$SQLidCarrera->bindParam(":vCarrera",$vCarrera);
	                		$SQLidCarrera->execute();
	                		$IDCARRERA = $SQLidCarrera->FETCH(PDO::FETCH_ASSOC);

							//Obtener el id de la Empresa
	                		$SQLidEmpresa = $this->CONNECTION->PREPARE("SELECT idEmpresa AS idEmpre FROM empresas WHERE vNombreEmpresa = :vNombreEmpresa");
	                		$SQLidEmpresa->bindParam(":vNombreEmpresa",$vNombreEmpresa);
	                		$SQLidEmpresa->execute();
	                		$IDEMPRESA = $SQLidEmpresa->FETCH(PDO::FETCH_ASSOC);

	                		//Obtener el id del Periodo
	                		$SQLidPeriodo = $this->CONNECTION->PREPARE("SELECT idPeriodo AS idPer FROM periodos WHERE vPeriodo = :vPeriodo");
	                		$SQLidPeriodo->bindParam(":vPeriodo",$vPeriodo);
	                		$SQLidPeriodo->execute();
	                		$IDPERIODO = $SQLidPeriodo->FETCH(PDO::FETCH_ASSOC);

	                		$SQLInsertByExcel = $this->CONNECTION->PREPARE(	
								"INSERT INTO bancoproyectos (
									idEmpresa,
									idCarrera,
									idEstado,
									idPeriodo,
									vNombreProyecto,
									vDescripcion,
									vArea,
									vPropuestaDe,
									dFechaPropuesta,
									iTotalResidentes,
									bActive
								) 
								SELECT
									:idEmpresa,
									:idCarrera,
									1,
									:idPeriodo,
									:vNombreProyecto,
									:vDescripcion,
									:vArea,
									:vPropuestaDe,
									CURRENT_DATE,
									:iTotalResidentes,
									1 FROM bancoproyectos WHERE NOT EXISTS (SELECT * FROM bancoproyectos WHERE vNombreProyecto = :vNombreProyecto) LIMIT 1");

			                $SQLInsertByExcel->bindParam(":idEmpresa", $IDEMPRESA['idEmpre']);
							$SQLInsertByExcel->bindParam(":idCarrera", $IDCARRERA['idCar']);
							$SQLInsertByExcel->bindParam(":idPeriodo", $IDPERIODO['idPer']);
							$SQLInsertByExcel->bindParam(":vNombreProyecto", $vNombreProyecto);
							$SQLInsertByExcel->bindParam(":vDescripcion", $vDescripcion);
							$SQLInsertByExcel->bindParam(":vArea", $vArea);
							$SQLInsertByExcel->bindParam(":vPropuestaDe", $vPropuestaDe);
							$SQLInsertByExcel->bindParam(":iTotalResidentes", $iTotalResidentes);
							$SQLInsertByExcel->execute();

		                	echo '<div class="alert alert-dismissable alert-success">Todo Correcto!!!
									<button type="button" class="close" data-dismiss="alert">x</button>
								  </div>';
		                }//Fin del IF que compruba la existencia de los datos del Excel 
		                else{
		                	echo '<div class="alert alert-dismissable alert-warning">Los Datos estan mal!!:
									<button type="button" class="close" data-dismiss="alert">x</button>
								  </div>';
	                	}//Fin del ELSE
	                } catch (Exception $e) {
	                	echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
	                }
              	}
			}
	    }

	    /***************NOTIFICACIONES*****************/
	    public function obtenerNumeroNotificaciones($idAlumno) {
			try {
				$SQL = $this->CONNECTION->PREPARE("SELECT COUNT(idNotificacion) AS total FROM notificaciones WHERE idAlumno = :idAlumno AND bVista = 1 AND bActivo = 1");
				$SQL->bindParam(":idAlumno", $idAlumno);
				$SQL->execute();

				$TOTAL = $SQL->FETCH(PDO::FETCH_ASSOC);
				return $TOTAL['total'];
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function obtenerNotificacionesAlumno($idAlumno) {
			try {
				$SQL = $this->CONNECTION->PREPARE("SELECT tTexto, dFecha, bVista FROM notificaciones WHERE idAlumno = :idAlumno AND bActivo = 1 ORDER BY idNotificacion DESC");
				$SQL->bindParam(":idAlumno", $idAlumno);
				$SQL->execute();
				return $SQL;
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}

		public function actualizarNotificacionesVistas($idAlumno) {
			try {
				$SQL = $this->CONNECTION->PREPARE("UPDATE notificaciones SET bVista = 0 WHERE idAlumno = :idAlumno AND bActivo = 1");
				$SQL->bindParam(":idAlumno",$idAlumno);
				$SQL->execute();
			} catch (PDOException $e) {
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
		}
	}
?>
