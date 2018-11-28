<?php
	class cronograma
	{
		private $handler;
		function __construct()
		{
			@session_start();
		}

		public function abrirConexion(){
			try{
			/*	$this->handler = new PDO('mysql:host=127.0.0.1;dbname=residenciasitsa','root',''); //Localhost
				$this->handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);*/
				$handler = new PDO('mysql:host=185.201.11.65;dbname=u276604013_dbres','u276604013_itsa','jesus_321'); //Localhost
				$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch(PDOException $e) {
				echo $e->getMessage();
			}
		}

		public function obtenerTiposDeDocumentos(){
			$sql = "
				SELECT
					idTipoDocumento,
					vNombre
				FROM tiposdocumento
				WHERE bActivo = 1 AND idTipoDocumento IN(5,6,7)";
			$prepare = $this->handler->prepare($sql);
			$prepare->execute();
			$resultado = $prepare->fetchAll();

			return $resultado;
		}
		public function guardarCronograma($cronograma,$size,$idAlumno,$idTipoDeDocumento){

			$array = json_decode($cronograma,true);
			echo "<pre>";
			print_r($array);
			echo "</pre>";

			/*if(is_array($array)){
				echo "si";
			}else{
				echo "no";
			}*/
			$sql = "
						DELETE FROM cronograma
						WHERE idAlumno = $idAlumno AND idDocumento = $idTipoDeDocumento
			";
			$db = $this->handler->prepare($sql);
			$db->execute();


			$sql = "
					 	INSERT INTO cronograma(
						 				vNombre,
						 				bValor,
						 				idDocumento,
										idAlumno,
						 				iSemana,
										i,
										j
					 				)
					 			VALUES
			";
			$i = 0;
			foreach ($array as $k) {
					for($j = 0 ; $j < $size; $j++){
						if($k["valor$i$j"] == "true"){
								$sql = $sql."
									(
										'".$k["actividad".$i]."',
										".$k["valor$i$j"].",
										".$k["idTipoDeDocumento"].",
										".$idAlumno.",
										".$k["iSemana$i$j"].",
										".$k["i$i"].",
										".$k["j$i$j"]."
									),
								";
							}
					}
					$i++;
			}

			$sql = trim($sql);
			$sql = substr($sql,0,-1);
			$db = $this->handler->prepare($sql);
			echo $sql;
			if($db->execute()){
				echo "Save";
			}else{
				echo $db->errorCode();
			}
		}

		public function obtenerCronogramaCargado($idAlumno,$idDocumento){
			$sql =
			"
					SELECT
						idCronograma,
						vNombre,
						iMes,
						iSemana,
						bValor,
						idDocumento,
						idAlumno,
						i,
						j
					FROM cronograma
					WHERE idAlumno = $idAlumno AND idDocumento = $idDocumento
			";
			$prepare = $this->handler->prepare($sql);

			$prepare->execute();

			$result = $prepare->fetchAll();

			return $result;
		}

	}



	$operacion = @$_POST["operacion"];
	$cronograma = new cronograma();
	switch ($operacion) {
		case 1:
			$info 				= $_POST["cronograma"];
			$size 				= $_POST["size"];
			$idAlumno 		= $_SESSION['idUsuario'];
			$idDocumento 	= $_POST["idTipoDeDocumento"];

			$cronograma->abrirConexion();

			$cronograma->guardarCronograma($info,$size,$idAlumno,$idDocumento);

		break;
		case 2:
			$cronograma->abrirConexion();

			$resultado = $cronograma->obtenerTiposDeDocumentos();
			$select = "";
			$select .= "<option value='0'>Selecciona un documento</option>";
			foreach ($resultado as $r) {
				$select .= "<option value='".$r["idTipoDocumento"]."'>".$r["vNombre"]."</option>";
			}
			echo $select;
		break;
		case 3:
		$cronograma->abrirConexion();
		$idAlumno 		= @$_SESSION["idUsuario"];
		$idDocumento	= $_POST["idDocumento"];

		$resultado = $cronograma->obtenerCronogramaCargado($idAlumno,$idDocumento);

		echo json_encode($resultado);
		break;
	}
?>
