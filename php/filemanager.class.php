<?php
	class fileManager{
		private $CONNECTION;

		public function __construct($BD){
			$this->CONNECTION = $BD;
		}

		public function getAllFilesForAdmin($filter,$idCarrera,$idPeriodo){
			$currentDate = "'".date('Y-m-d')."'";
			if (!empty($filter)) {
				$filter = " WHERE al.vNumeroControl LIKE \"%".$filter."%\"";

				if($idCarrera!=0){
					$filter = $filter." AND al.idCarrera = ".$idCarrera;
				}

				if($idPeriodo!=0){
					$filter = $filter." AND ps.idPeriodo = ".$idPeriodo;
				}

			}else if($idCarrera!=0){
				$filter = "WHERE al.idCarrera = ".$idCarrera;

				if($idPeriodo!=0){
					$filter = $filter." AND ps.idPeriodo = ".$idPeriodo;
				}
			}else if($idPeriodo!=0){
				$filter = $filter." WHERE ps.idPeriodo = ".$idPeriodo;
			}


			$sql = "SELECT al.idAlumno,al.vNombre,al.vApellidoPaterno,al.vApellidoMaterno,al.vNumeroControl,d.vNombre as UUIDDoc,td.vNombre as   	nombreDocumento,d.bAceptadoAI,d.bAceptadoAE,d.dFechaRegistro,DATEDIFF(fe.dFechaLimite,d.dFechaRegistro) as aTiempo FROM alumnos as al
				 							   INNER JOIN proyectoseleccionado ps ON(ps.idAlumno = al.idAlumno)
											   INNER JOIN documentos d ON(d.idProyectoSeleccionado = ps.idProyectoSeleccionado AND d.idAlumno = al.idAlumno)
											   INNER JOIN tiposdocumento td ON(td.idTipoDocumento = d.idTipoDocumento)
											   INNER  JOIN fechaEntregaPorDocumento fe ON (fe.idTipoDocumento = td.idTipoDocumento)
											   ".@$filter;

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
		public function getPeriodos(){
			$sql = "SELECT idPeriodo,vPeriodo FROM periodos WHERE bActivo = 1 ";
			$periodos = $this->CONNECTION->prepare($sql);
			$periodos->execute();
			return $periodos->fetchAll();
		}
	}
?>
