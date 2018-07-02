<?php 

class Dashboard {

	private $CONNECTION;

	public function __construct($BD){
		$this->CONNECTION = $BD;
	}
	

	public function login($Datos) {
		try {
			$SQL = $this->CONNECTION->prepare("SELECT idUsuario, idRol FROM usuarios WHERE vUsuario = :usuario AND vContrasena = :contrasena AND bActivo = 1");
			$SQL->bindParam(":usuario",$Datos['email']);
			$SQL->bindParam(":contrasena",$Datos['password']);
			$SQL->execute(); 

			if($SQL->rowCount() > 0) {
				$Usuario = $SQL->fetch(PDO::FETCH_ASSOC);

				if($Usuario['idRol'] == 1) {
					$SQLALUMNO = $this->CONNECTION->prepare("SELECT * FROM alumnos WHERE idUsuario = :idUsuario");
					$SQLALUMNO->bindParam(":idUsuario", $Usuario['idUsuario']);
					$SQLALUMNO->execute();		
					$Alumno = $SQLALUMNO->fetch(PDO::FETCH_ASSOC);			
					@session_start();					
			    	$_SESSION['username'] = $Alumno['vNombre'];
			    	$_SESSION['idUsuario'] = $Alumno['idAlumno'];	
				} else {
					$SQLOTRO = $this->CONNECTION->prepare("SELECT * FROM asesores WHERE idUsuario = :idUsuario");
					$SQLOTRO->bindParam(":idUsuario", $Usuario['idUsuario']);
					$SQLOTRO->execute();
					$OTRO = $SQLOTRO->fetch(PDO::FETCH_ASSOC);
					@session_start();	
					$_SESSION['username'] = $OTRO['vNombre'];
			    	$_SESSION['idUsuario'] = $OTRO['idAsesor'];
					// echo '<div class="alert alert-dismissable alert-info">Hola Asesor, por el momento no estás autorizado para ingresar a la plataforma, una disculpa. Regresa pronto cuando el Director de la indicación.
					// 		<button type="button" class="close" data-dismiss="alert">x</button>
					//   	 </div>';
				}

				$SQLPERMISOS = $this->CONNECTION->prepare("SELECT 
															LOWER(PP.vPagina) AS pagina 
															FROM permisos AS P 
															INNER JOIN paginas AS PP 
															ON P.idPagina = PP.idPagina
															WHERE PP.bActivo
															AND P.idRol = :idRol");

				$SQLPERMISOS->bindParam(":idRol", $Usuario['idRol']);
				$SQLPERMISOS->execute();

				$ArrayPermisos = array();

				while($Permiso = $SQLPERMISOS->fetch(PDO::FETCH_ASSOC)) {
					array_push($ArrayPermisos, $Permiso['pagina']);
				}
				@session_start();
				$_SESSION['paginasrol'] = $ArrayPermisos;

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

	public function logout() {
		@session_start();
		session_unset($_SESSION['username']);
		session_unset($_SESSION['idUsuario']);
		session_unset($_SESSION['paginasrol']);
		session_destroy();
		header('Location: ../index.php');
	}

	public function checkSession() {
		@session_start();
		if(!empty($_SESSION['idUsuario']) && !empty($_SESSION['username']))
			return true;

		return false;
	}


	public function isUserAvaliable($username){
		try {
			$SQL = $this->CONNECTION->prepare("SELECT idUsuario FROM usuarios WHERE vUsuario = :usuario");
			$SQL->bindParam(":usuario", $username);
			$SQL->execute();

			if($SQL->rowCount() > 0){
				echo "1";
			} else {
				echo "0";
			}
		} catch (PDOException $e) {
			echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
					<button type="button" class="close" data-dismiss="alert">x</button>
				  </div>';
		}
	}

	public function saveUser($Datos) {
		
			if($Datos['vClave'] == '12345') {
				try {
					$SQLCODIGOASESOR = $this->CONNECTION->prepare("SELECT idAsesor FROM asesores WHERE vCodigo = :codigoAsesor");
					$SQLCODIGOASESOR->bindParam(":codigoAsesor", $Datos['vCodigo']);
					$SQLCODIGOASESOR->execute();

					if($SQLCODIGOASESOR->rowCount() > 0) { 						
						$SQL = $this->CONNECTION->prepare("INSERT INTO usuarios (vUsuario, vContrasena, idRol, bActivo) VALUES (:usuario, :contrasena, 1, 1)");
						$this->CONNECTION->beginTransaction();
						$SQL->bindParam(":usuario", $Datos['vUsuario']);
						$SQL->bindParam(":contrasena", $Datos['vContrasena']);
						$SQL->execute();
						$IDUSUARIO_ = $this->CONNECTION->lastInsertId();

						$SQLALUMNO = $this->CONNECTION->prepare("INSERT INTO alumnos (idUsuario, vNombre, vApellidos, vDireccion, vCP, vCiudad, vEstado, vPais, vCorreoElectronico, vNumero, vCodigo, bActivo) VALUES (:idUsuario, :nombre, :apellidos, :direccion, :cp, :ciudad, :estado, :pais, :correo, :numero, :codigo, 1)");
						$SQLALUMNO->bindParam(":idUsuario", $IDUSUARIO_);
						$SQLALUMNO->bindParam(":nombre", $Datos['vNombre']);
						$SQLALUMNO->bindParam(":apellidos", $Datos['vApellidos']);
						$SQLALUMNO->bindParam(":direccion", $Datos['vDireccion']);
						$SQLALUMNO->bindParam(":cp", $Datos['vCP']);
						$SQLALUMNO->bindParam(":ciudad", $Datos['vCiudad']);
						$SQLALUMNO->bindParam(":estado", $Datos['vEstado']);
						$SQLALUMNO->bindParam(":pais", $Datos['vPais']);
						$SQLALUMNO->bindParam(":correo", $Datos['vCorreoElectronico']);
						$SQLALUMNO->bindParam(":numero", $Datos['vNumero']);
						$SQLALUMNO->bindParam(":codigo", $Datos['vCodigo']);
						$SQLALUMNO->execute();

						$this->CONNECTION->commit();	
						echo '<div class="alert alert-dismissable alert-success">Alumno registrado exitosamente! Ahora inicia sesión.
								<button type="button" class="close" data-dismiss="alert">x</button>
							  </div>';	
					} else {
						echo '<div class="alert alert-dismissable alert-warning">El código de asesor ingresado no es correcto.
								<button type="button" class="close" data-dismiss="alert">x</button>
							  </div>';
					}
				} catch (PDOException $e) {					
					$this->CONNECTION->rollback();
					echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
							<button type="button" class="close" data-dismiss="alert">x</button>
						  </div>';
				}
			} else {				
				echo '<div class="alert alert-dismissable alert-warning">La clave de seguridad no es correcta. Contacta al Director por medio de la página de Facebook.
						<button type="button" class="close" data-dismiss="alert">x</button>
					  </div>';
			}
	}

	public function saveCourses($idAlumno, $Datos) {
		try {
			$SQL = $this->CONNECTION->prepare("INSERT INTO alumnoasesorcurso (idAlumno, idAsesorCurso) VALUES (:idalumno, :idasesorcurso)");

			$Cursos = explode("?", $Datos);
			for ($i=0; $i < sizeof($Cursos)-1; $i++) { 
				$arrayCursos = array(
						':idalumno'=>$idAlumno,
						':idasesorcurso'=>$Cursos[$i]
					);	
				$SQL->execute($arrayCursos);
			}
			echo "1";
		} catch (PDOException $e) {
			echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
					<button type="button" class="close" data-dismiss="alert">x</button>
				  </div>';
		}
	}

	public function isThereCoursesRegistered($idAlumno) {
		try {
			$SQL = $this->CONNECTION->prepare("SELECT idAlumnoAsesorCurso FROM alumnoasesorcurso WHERE idAlumno = :idAlumno");
			$SQL->bindParam(":idAlumno", $idAlumno);
			$SQL->execute();
			if($SQL->rowCount() > 0) {
				return false;
			} else {
				return true;
			}
		} catch (PDOException $e) {
			return false;
		}
	}

	public function getCoursesOptions() {
		try {
			$SQL = $this->CONNECTION->prepare("SELECT
												AC.idAsesorCurso,
												(SELECT CONCAT(A.vNombre,' ',A.vApellidos)) AS vNombre,
												C.vCurso
											  FROM asesorcursos AS AC 
											  INNER JOIN ASESORES AS A 
											  ON AC.idAsesor = A.idAsesor
											  INNER JOIN cursos AS C 
											  ON C.idCurso = AC.idCurso
											  WHERE A.bActivo = 1
											  AND C.bActivo = 1 
											  AND idAsesorCurso != 2
											  ORDER BY C.vCurso ASC
											");
			$SQL->execute();

			while($Cursos = $SQL->fetch(PDO::FETCH_ASSOC)) {
				echo '<option data-id="'.$Cursos['idAsesorCurso'].'" data-curso="'.$Cursos['vCurso'].'" data-profesor="'.$Cursos['vNombre'].'" value="'.$Cursos['idAsesorCurso'].'">'.$Cursos['vCurso'].' - '.$Cursos['vNombre'].'</option>';
			}
		} catch (PDOException $e) {
			echo '<option>Ocurrio un error: '.$e->getMessage().'</option>';
		}
	}

	public function getDefaultCourse() {
		try {
			$SQL = $this->CONNECTION->prepare("SELECT
												AC.idAsesorCurso,
												(SELECT CONCAT(A.vNombre,' ',A.vApellidos)) AS vNombre,
												C.vCurso
											  FROM asesorcursos AS AC 
											  INNER JOIN ASESORES AS A 
											  ON AC.idAsesor = A.idAsesor
											  INNER JOIN cursos AS C 
											  ON C.idCurso = AC.idCurso
											  WHERE AC.idAsesorCurso = 2
											  ORDER BY C.vCurso ASC");
			$SQL->execute();
			$Curso = $SQL->fetch(PDO::FETCH_ASSOC);

			echo '<div class="panel panel-default">
                      <div class="panel-heading">
                      	<input type="hidden" class="idAsesorCurso" value="'.$Curso['idAsesorCurso'].'"/>
                        <strong><i class="fa fa-briefcase"></i> Curso: </strong>'.$Curso['vCurso'].'
                        <br>
                        <strong><i class="fa fa-user"></i> Profesor: </strong> '.$Curso['vNombre'].'
                      </div>
                  </div>';
		} catch (Exception $e) {
			echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
							<button type="button" class="close" data-dismiss="alert">x</button>
						  </div>';
		}
	}

	public function checkPermission($pagina) {
		@session_start();
		if(in_array($pagina, $_SESSION['paginasrol'])) {
			return true;
		}
		return false;
	}
}

?>