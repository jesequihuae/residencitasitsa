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
				/*$handler = new PDO('mysql:host=127.0.0.1;dbname=residenciasitsa','root',''); //Localhost
				$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);*/
				$handler = new PDO('mysql:host=185.201.11.65;dbname=u276604013_dbres','u276604013_itsa','jesus_321'); //Localhost
				$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch(PDOException $e) {
				echo $e->getMessage();
			}
			$this->conection = $handler;
		}

		function obtenerAlumnos(){
				$sql = "
						SELECT
							idAlumno AS id,
							CONCAT(vNombre,' ',vApellidoPaterno,' ',vApellidoMaterno,' ',vNumeroControl) AS descripcion
						FROM alumnos
				";
				$alumnos = $this->conection->prepare($sql);
				$alumnos->execute();
				$respuesta = $alumnos->fetchAll();
				return $respuesta;
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
		function guardarMensaje($idAlumno,$msg,$titulo,$bActive,$idMensaje){
			if($idMensaje == 0){
				$sql = "
							 INSERT INTO mensajesporalumno
							 (
									idAlumno,
									vMensaje,
									vTitulo,
									bActive
							 )
							 VALUES(
								 $idAlumno,
								 '".$msg."',
								 '".$titulo."',
								 $bActive
							)
				";
			}else{
				$sql = "
							 UPDATE mensajesporalumno
							 SET
									vMensaje = '".$msg."',
									vTitulo = '".$titulo."'
							 WHERE idMensaje = $idMensaje
				";
			}
			$mensajes = $this->conection->prepare($sql);
			return $mensajes->execute();
		}

		function getMensajes($inicio,$rowMax,$activo,$idAlumno){

			$sql = "
					SELECT
						a.idMensaje,
						a.vMensaje,
						CONCAT(b.vNombre,' ',b.vApellidoPaterno,' ',b.vApellidoPaterno) AS vNombre,
						a.bActive
					FROM mensajesporalumno AS a
					INNER JOIN alumnos b ON(a.idAlumno = b.idAlumno)
					WHERE
								CASE WHEN $activo = -1 THEN a.bActive = a.bActive ELSE a.bActive = $activo END AND
								CASE WHEN $idAlumno = 0 THEN a.idAlumno = a.idAlumno  ELSE a.idAlumno  = $idAlumno END
					ORDER BY a.idMensaje DESC LIMIT $inicio,$rowMax
			";
			$mensajes = $this->conection->prepare($sql);
			$mensajes->execute();
			return $mensajes->fetchAll();
		}
		function obtenerNumeroDeMensajes($activo,$idAlumno){
			$sql = "
								SELECT
									COUNT(1)
								FROM mensajesporalumno
								WHERE
								 			CASE WHEN $activo = -1 THEN bActive = bActive ELSE bActive = $activo END AND
											CASE WHEN $idAlumno = 0 THEN idAlumno = idAlumno ELSE idAlumno = $idAlumno END
							";
			$numeroMensajes = $this->conection->prepare($sql);
			$numeroMensajes->execute();
			return $numeroMensajes->fetchColumn();
		}
		function DesactivarActivar($idMensaje,$bit){
			$sql = "
				UPDATE mensajesporalumno
							 SET bActive = $bit
				WHERE idMensaje = $idMensaje
			";
			$desactivar = $this->conection->prepare($sql);
			if($desactivar->execute()){
				return 1;
			}else{
				return 0;
			}
		}
		function obtenerInformacionMensaje($idMensaje){
			$sql = "
				SELECT
						a.idMensaje,
						a.vMensaje,
						a.idAlumno,
						a.vTitulo,
						b.idCarrera
				FROM mensajesporalumno AS a
				INNER JOIN alumnos b ON(a.idAlumno = b.idAlumno)
				WHERE idMensaje = $idMensaje
			";
			$info = $this->conection->prepare($sql);
			$info->execute();
			return $info->fetchAll();
		}
		function getSeguimientosPorAlumno($idAlumno){
			$sql = "		
			SELECT DISTINCT 
				a.idDocumento,
				b.vNombre,
				a.vRuta,
				a.UUID
			FROM documentos a
			INNER JOIN tiposdocumento b ON(a.idTipoDocumento = b.idTipoDocumento)
			WHERE a.idTipoDocumento IN(5,6,7) AND a.asesoria = 0 AND a.idAlumno = :idAlumno ORDER BY a.idTipoDocumento ";
			$sql = $this->conection->prepare($sql);
			$sql->bindParam("idAlumno",$idAlumno);
			$sql->execute();
			return $sql->fetchAll();
		}
		function aceptarSeguimiento($idDocumento){
			$sql = "UPDATE documentos SET bAceptadoAE = 1 WHERE idDocumento = :idDocumento;";
			$sql = $this->conection->prepare($sql);
			$sql->bindParam(":idDocumento",$idDocumento);
			$sql->execute();			
			return 1;
		}
		function rechazarSeguimiento($idDocumento){
			$sql = "UPDATE documentos SET bAceptadoAE = 0 WHERE idDocumento = :idDocumento;";
			$sql = $this->conection->prepare($sql);
			$sql->bindParam(":idDocumento",$idDocumento);
			$sql->execute();
			return 1;
		}
		function aceptarSeguimientoAsesorInterno($idDocumento){
			$sql = "UPDATE documentos SET bAceptadoAI = 1 WHERE idDocumento = :idDocumento;";
			$sql = $this->conection->prepare($sql);
			$sql->bindParam(":idDocumento",$idDocumento);
			$sql->execute();			
			return 1;
		}
		function rechazarSeguimientoAsesorInterno($idDocumento){
			$sql = "UPDATE documentos SET bAceptadoAI = 0 WHERE idDocumento = :idDocumento;";
			$sql = $this->conection->prepare($sql);
			$sql->bindParam(":idDocumento",$idDocumento);
			$sql->execute();
			return 1;
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
				$idMensaje = $_POST["idMensaje"];
				$idAlumno = $_POST["idAlumno"];
				$msg      = $_POST["mensaje"];
				$titulo   = $_POST["titulo"];
				$bActive  = $_POST["bActive"];

			  echo	$helper->guardarMensaje($idAlumno,$msg,$titulo,$bActive,$idMensaje);
			break;
			case 3:
				$helper = new helper();
				$mensajes = $helper->getMensajes($_POST["inicio"],$_POST["fin"],$_POST["activo"],$_POST["idAlumno"]);


				$tabla = "<thead>";
					$tabla .= "<tr>";
						$tabla .= "<th class='center'>Id mensaje</th>";
						$tabla .= "<th class='center'>Mensajes</th>";
						$tabla .= "<th class='center'>Nombre</th>";
						$tabla .= "<th class='center'>Activo</th>";
						$tabla .= "<th class='center'>Editar</th>";
						$tabla .= "<th class='center'>Desactivar</th>";
					$tabla .= "<tr>";
				$tabla .= "</thead>";
				foreach ($mensajes as $m) {
					$tabla .= "<tr>";

					$tabla .= "<td class='center'>".$m["idMensaje"]."</td>";
					$tabla .= "<td class='center'>".$m["vMensaje"]."</td>";
					$tabla .= "<td class='center'>".$m["vNombre"]."</td>";
					if($m["bActive"] == 1){
						$tabla .= "<td class='center'><input type='checkbox' checked disabled /></td>";
					}else{
						$tabla .= "<td class='center'><input type='checkbox' disabled /></td>";
					}
					$tabla .= "<td class='center'><button class='btn btn-warning' onclick='editar(".$m["idMensaje"].")'>Editar</button></td>";
					if($m["bActive"] == 1){
							$tabla .= "<td class='center'><button class='btn btn-danger' onclick='DesactivarActivar(".$m["idMensaje"].",0)'>Desactivar</button></td>";
					}else{
					 	$tabla .= "<td class='center'><button class='btn btn-success' onclick='DesactivarActivar(".$m["idMensaje"].",1)'>Activar</button></td>";
					}
					$tabla .= "</tr>";
				}
				$paginador = $helper->obtenerNumeroDeMensajes($_POST["activo"],$_POST["idAlumno"]);
				$respuesta = "<ul class='pagination'>";
				$j = 1;
				for($i = 0;$i < $paginador; $i+=7){
						$respuesta .= "<li><a onclick='cargarAlumnos(".$i.",7,-1,0)'>".$j."</a></li>";
						$j++;
				}

				$respuesta .= "</ul>";

				 $res = array("mensajes" => $tabla , "paginador" => $respuesta);

				echo json_encode($res);
			break;
			case 4:
				$helper = new helper();
				echo $helper->DesactivarActivar($_POST["idMensaje"],$_POST["activo"]);
			break;
			case 5:
				$helper = new helper();
				echo json_encode($helper->obtenerInformacionMensaje($_POST["idMensaje"]));
			break;
			case 6:
				$helper = new helper();
				$html = "";
				foreach($helper->getSeguimientosPorAlumno($_POST["idAlumno"]) AS $row){
					$html .= '<div class="panel panel-default">';
					$html .= '  <div class="panel-heading">'.$row["vNombre"].'</div>';
						$html .= '<div class="panel-body">';
							$html .= '<button class="btn btn-primary col-md-3 col-md-offset-1" data-idDocumento='.$row["idDocumento"].' data-idAlumno='.$_POST["idAlumno"].' onclick="aceptar(this)">Aceptar</button>';
							$html .= '<button class="btn btn-danger col-md-3 col-md-offset-1" data-idDocumento='.$row["idDocumento"].' data-idAlumno='.$_POST["idAlumno"].' onclick="rechazar(this)">Rechazar</button>';
							$html .= '<button class="btn btn-info col-md-3 col-md-offset-1">Descargar</button>';
						$html .= '</div>';
					$html .= '</div>';
				}
				echo $html;
			break;
			case 7:
				$helper = new helper();
				if($_POST["rechazar"] == 0){
					echo $helper->aceptarSeguimiento($_POST["idDocumento"]);
				}else if($_POST["rechazar"] == 1){
					echo $helper->rechazarSeguimiento($_POST["idDocumento"]);
				}
			break;
			case 8:
				$helper = new helper();
				if($_POST["rechazar"] == 0){
					echo $helper->aceptarSeguimientoAsesorInterno($_POST["idDocumento"]);
				}else if($_POST["rechazar"] == 1){
					echo $helper->rechazarSeguimientoAsesorInterno($_POST["idDocumento"]);
				}
			break;

			default:
					
				break;
		}
?>
