<?php
	class fileManager{
		private $CONNECTION;

		public function __construct($BD){
			$this->CONNECTION = $BD;
		}

		public function getAllFilesForAdmin($filter,$idCarrera){

			if (!empty($filter)) {
				$filter = " WHERE al.vNumeroControl LIKE \"%".$filter."%\"";

				if($idCarrera!=0){
					$filter = $filter." AND al.idCarrera = ".$idCarrera;
				}

			}else if($idCarrera!=0){
				$filter = "WHERE al.idCarrera = ".$idCarrera;
			}


			$sql = "SELECT al.idAlumno,al.vNombre,al.vApellidoPaterno,al.vApellidoMaterno,al.vNumeroControl,d.vNombre as UUIDDoc,td.vNombre as nombreDocumento,d.bAceptadoAI,d.bAceptadoAE FROM alumnos as al
											   INNER JOIN proyectoseleccionado ps ON(ps.idAlumno = al.idAlumno)
											   INNER JOIN documentos d ON(d.idProyectoSeleccionado = ps.idProyectoSeleccionado AND d.idAlumno = al.idAlumno)
											   INNER JOIN tiposdocumento td ON(td.idTipoDocumento = d.idTipoDocumento) ".@$filter;

			$SQL = $this->CONNECTION->prepare($sql);
			$SQL->execute(); 
			$documentos = $SQL->fetchAll();

			return $documentos;
		}
		public function getCarreras(){
			$sql = "SELECT idCarrera,vCarrera FROM carreras WHERE bActivo = 1 ";

			$carreras = $this->CONNECTION->prepare($sql);
			$carreras->execute();
			return $carreras->fetchAll();
		}
	}
?>