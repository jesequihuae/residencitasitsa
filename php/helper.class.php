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

			if($alumnos->rowCount() > 0){
				$respuesta = $alumnos->fetchAll();
			}else{
				$respuesta = null;
			}

			return $respuesta;
		}
	}
	
	
?>

