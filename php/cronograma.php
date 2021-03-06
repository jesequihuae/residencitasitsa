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
				$this->handler = new PDO('mysql:host=185.201.11.65;dbname=u276604013_dbres','u276604013_itsa','jesus_321'); //Localhost
				$this->handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
				WHERE bActivo = 1 AND idTipoDocumento = 3";
			$prepare = $this->handler->prepare($sql);
			$prepare->execute();
			$resultado = $prepare->fetchAll();

			return $resultado;
		}
		public function guardarCronograma($cronograma,$size,$idAlumno,$idTipoDeDocumento){

			$array = json_decode($cronograma,true);

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
			if($db->execute()){
			
				$proceso = 0;
				if($idTipoDeDocumento == 5){
					$proceso = 5;
				}else if($idTipoDeDocumento == 6){
					$proceso = 6;
				}else if($idTipoDeDocumento == 7){
					$proceso = 7;
				}
				
				$sql = "
									UPDATE alumnos
									SET iProceso = $proceso
									WHERE idAlumno = $idAlumno;
							";
				
				if($proceso != 0){
					$db = $this->handler->prepare($sql);
 				 if($db->execute()){
 					 echo $proceso;
 				 }else{
 					 echo $db->errorCode();
 				 }
				}
			}else{
				echo $db->errorCode();
			}
		}
		public function obtenerSemanaInicioFin($idDocumento){
			$sql =
				"
					SELECT
						iSemanaInicioSeg,
						iSemanaFinSeg
					FROM tiposdocumento
					WHERE idTipoDocumento = $idDocumento
				";

				$db  = $this->handler->prepare($sql);
				$db->execute();
				$res = $db->fetch();
				//return $res;
				return array("inicio"=>$res["iSemanaInicioSeg"],"fin"=>$res["iSemanaFinSeg"]);

		}
		public function obtenerCronogramaCargado($idAlumno,$idDocumento){
			$idDocumentoReal = 0;
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
					WHERE idAlumno = $idAlumno"; //AND idDocumento = $idDocumento ".$filtroSemana."
			//return $semanaFin;
			$prepare = $this->handler->prepare($sql);

			$prepare->execute();

			$result = $prepare->fetchAll();

			return $result;
		}
		public function buscarCronogramaByUsuario($idAlumno){
			$sql =
			"
				SELECT
					1
				FROM cronograma
				WHERE idAlumno = :idAlumno
				LIMIT 1
			";
			$con = $this->handler->prepare($sql);
			$con->bindParam(":idAlumno",$idAlumno);
			$con->execute();

			return $con->rowCount();
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

		$semanaInicio = 0;
		$semanaFin 	  = 0;
		/*if(isset($idDocumento)){

			$array = $cronograma->obtenerSemanaInicioFin($idDocumento);
			$semanaInicio = $array["inicio"];
			$semanaFin    = $array["fin"];
		}*/



		echo json_encode($resultado);
		break;
		case 4:
		$cronograma->abrirConexion();
		$idAlumno 		= @$_SESSION["idUsuario"];

		$resultado = $cronograma->buscarCronogramaByUsuario($idAlumno);

		echo ($resultado > 0 )? 1 : 0;
		break;
	}
?>
