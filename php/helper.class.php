<?php
	class helper
	{
		private $conection;

		function __construct()
		{
			$this->abrirConexion();
		}

		function abrirConexion(){
			try{
				$handler = new PDO('mysql:host=127.0.0.1;dbname=residenciasitsa','root',''); //Localhost
				$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch(PDOException $e) {
				echo $e->getMessage();
			}
			$this->conection = $handler;
		}

		function obtenerAlumnosPorCarrera($idCarrera){
			$sql = "
				SELECT
					idAlumno AS id,
					CONCAT(vNombre,' ',vApellidoPaterno,' ',vApellidoMaterno,' ',vNumeroControl) AS descripcion
				FROM alumnos
				WHERE idCarrera = '$idCarrera'
			";
			$alumnos = $this->conection->prepare($sql);
			$alumnos->execute();


			$respuesta = $alumnos->fetchAll();


			return $respuesta;
		}

		public function getCarreras(){
			$sql = "SELECT
						idCarrera AS id,
						vCarrera AS descripcion
					FROM carreras WHERE bActivo = 1 ";
			$carreras = $this->conection->prepare($sql);
			$carreras->execute();
			return $carreras->fetchAll();
		}
		function guardarMensaje($idAlumno,$msg,$bActive){
			$sql = "
					   INSERT INTO mensajesporalumno
						 (
							 	idAlumno,
								vMensaje,
								bActive
						 )
						 VALUES(
							 $idAlumno,
							 '".$msg."',
							 $bActive
						)
			";
			$mensajes = $this->conection->prepare($sql);
			return $mensajes->execute();
		}

		function getMensajes($inicio,$rowMax){
			$sql = "
					SELECT
						idMensaje,
						vMensaje
					FROM mensajesporalumno
					WHERE bActive = 1
					LIMIT $inicio,$rowMax
			";
			$mensajes = $this->conection->prepare($sql);
			return $mensajes->fetchAll();
		}
	}

	$operacion = @$_POST["operacion"];

	switch ($operacion) {
			case 1:
				$helper = new helper();
				$idCarrera = $_POST["idCarrera"];
				$alumnos = $helper->obtenerAlumnosPorCarrera($idCarrera);
				echo "<option value='0'>Selecciona uno</option>";
				foreach ($alumnos AS $k) {
					echo "<option value=".$k["id"].">".$k["descripcion"]."</option>";
				}

			break;
			case 2:
				$helper = new helper();
				$idAlumno = $_POST["idAlumno"];
				$msg      = $_POST["mensaje"];
				$bActive  = $_POST["bActive"];

			  echo	$helper->guardarMensaje($idAlumno,$msg,$bActive);
			break;
			case 3:
				$helper = new helper();
				$mensajes = $helper->getMensajes(0,10);

				$select = "";
				foreach ($mensajes as $m) {
					$select .= $select
				}

			break;

			default:

				break;
		}
?>
