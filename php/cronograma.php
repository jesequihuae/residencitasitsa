<?php
	class cronograma
	{	
		private $handler;
		function __construct()
		{
			
		}

		public function abrirConexion(){
			try{
				$this->handler = new PDO('mysql:host=127.0.0.1;dbname=residenciasitsa','root',''); //Localhost
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
				WHERE bActivo = 1 AND idTipoDocumento IN(5,6,7)";
			$prepare = $this->handler->prepare($sql);
			$prepare->execute();
			$resultado = $prepare->fetchAll();

			return $resultado;
		}
		public function guardarCronograma($cronograma,$size){
	
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
					 	INSERT INTO cronograma(
						 				vNombre,
						 				bValor,
						 				idDocumento,
						 				iSemana
					 				)
					 			VALUES
			";	
			$i = 0;
			foreach ($array as $k) {
					for($j = 0 ; $j < $size; $j++){
						$sql = $sql."
							(
								'".$k["actividad".$i]."',
								".$k["valor$i$j"].",
								".$k["idTipoDeDocumento"].",
								".$k["iSemana$i$j"]."
							),
						";
					}
					$i++;
			}

			$sql = trim($sql);
			$sql = substr($sql,0,-1);
			$db = $this->handler->prepare($sql);
			if($db->execute()){
				echo "Save";
			}else{
				echo $db->errorCode();
			}
		}
	}



	$operacion = $_POST["operacion"];
	$cronograma = new cronograma();
	switch ($operacion) {
		case 1:
			$info = $_POST["cronograma"];
			$size = $_POST["size"];
			
			$cronograma->abrirConexion();

			$cronograma->guardarCronograma($info,$size);
			
		break;
		case 2:
			$cronograma->abrirConexion();

			$resultado = $cronograma->obtenerTiposDeDocumentos();
			$select = "";
			foreach ($resultado as $r) {
				$select .= "<option value='".$r["idTipoDocumento"]."'>".$r["vNombre"]."</option>"; 
			}
			echo $select;
		break;
	}
?>