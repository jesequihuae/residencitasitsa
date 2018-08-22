<?php
	class fileManager{
		private $CONNECTION;

		public function __construct($BD){
			$this->CONNECTION = $BD;
		}

		public function getAllFilesForAdmin(){
			$SQL = $this->CONNECTION->prepare("SELECT al.idAlumno,al.vNombre,al.vApellidoPaterno,al.vApellidoMaterno,al.vNumeroControl,d.vNombre as UUIDDoc,td.vNombre as nombreDocumento,d.bAceptadoAI,d.bAceptadoAE FROM alumnos as al
											   INNER JOIN proyectoseleccionado ps ON(ps.idAlumno = al.idAlumno)
											   INNER JOIN documentos d ON(d.idProyectoSeleccionado = ps.idProyectoSeleccionado AND d.idAlumno = al.idAlumno)
											   INNER JOIN tiposdocumento td ON(td.idTipoDocumento = d.idTipoDocumento)");
			$SQL->execute(); 
			$documentos = $SQL->fetchAll();

			return $documentos;
		}
	}
?>