<?php
  class alumnosTemporal{
    private $connection;
    function __construct($handler){
      $this->connection = $handler;
    }

    public function getInfoSolicitud(){
      $idAlumno = $_SESSION["idUsuario"];
      $sql =
      "
       SELECT
          CONCAT(a.vNombre,' ',a.vApellidoPaterno,' ',a.vApellidoMaterno) AS nombreAlumno,
          a.vNumeroControl,
          a.domicilio,
          a.colonia,
          a.ciudadEstado,
          a.cp,
          a.telefono,
          a.vCorreoInstitucional,
          a.bSexo,
          a.idSeguro,
          a.numeroSeguro,
          jc.vNombre AS vNombreJefeCarrera,
          c.vCarrera AS vNombreCarrera,
          ps.idOpcion,
          p.vPeriodo,
          bp.iTotalResidentes,
          ap.vTitulo AS vTituloAnteProyecto,
          e.vNombreEmpresa,
          e.vCorreoElectronico AS vCorreoElectronicoEmpresa,
          e.vDireccion AS vDireccionEmpresa,
          e.vTitular AS vTitularEmpresa,
          e.vContacto AS vContactoEmpresa,
          e.vRfc AS vRfcEmpresa,
          e.idGiro AS idGiroEmpresa,
          e.idSector AS idSectorEmpresa,
          e.vCiudadEstado AS vCiudadEstadoEmpresa,
          e.cp AS cpEmpresa,
          e.vTelefono AS vTelefonoEmpresa,
          e.vColonia AS vColoniaEmpresa
        FROM alumnos a
        INNER JOIN proyectoseleccionado ps ON(ps.idAlumno = $idAlumno)
        INNER JOIN bancoproyectos bp ON(ps.idbancoProyecto = bp.idBancoProyecto)
        INNER JOIN empresas e ON(e.idEmpresa = bp.idEmpresa)
        INNER JOIN jefescarrera jc ON(jc.idCarrera = a.idCarrera)
        INNER JOIN carreras c ON(c.idCarrera = a.idCarrera)
        INNER JOIN periodos p ON(p.idPeriodo = ps.idPeriodo AND p.bActivo = 1)
        INNER JOIN anteproyecto ap ON(ap.idAnteproyecto = ps.idAnteProyecto)
        WHERE a.idAlumno = $idAlumno

      ";
      $con = $this->connection->prepare($sql);
      $con->execute();
      return $con->fetch();
    }
    function getInfoParaSeguimiento(){
      $idAlumno = $_SESSION["idUsuario"];
      $sql = "
      SELECT
        CONCAT(al.vNombre,' ',al.vApellidoPaterno,' ',al.vApellidoMaterno) AS nombreAlumno,
        al.vNumeroControl,
        ps.asesorInterno,
        ps.asesorExterno,
        bp.vNombreProyecto,
        p.vPeriodo,
        e.vNombreEmpresa
        FROM alumnos AS al
        INNER JOIN proyectoseleccionado ps        ON(al.idAlumno = ps.idAlumno)
        INNER JOIN bancoproyectos bp              ON(bp.idbancoProyecto = ps.idbancoProyecto)
        INNER JOIN periodos p                     ON(p.idPeriodo = ps.idPeriodo)
        INNER JOIN empresas e                     ON(e.idEmpresa = bp.idEmpresa)
        WHERE al.idAlumno = $idAlumno
      ";
      $con = $this->connection->prepare($sql);
      $con->execute();
      return $con->fetch();
    }
    function obtenerCronograma($idTipoDocumento){
      $idAlumno = $_SESSION["idUsuario"];
      $sql =
        "
          SELECT
            vNombre,
            iSemana
          FROM cronograma
          WHERE idAlumno = $idAlumno AND idDocumento = $idTipoDocumento
          GROUP BY
                  iSemana
        ";
        $con = $this->connection->prepare($sql);
        $con->execute();
        return $con->fetchAll();
    }
    function obtenerFechaEnLetra(){
      //$dia= conocerDiaSemanaFecha($fecha);
      //$num = date("j", strtotime($fecha));
      $YY = date("Y");
      $MM = date("m");
      $DD = date("d");

      $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
      $res = $DD." de ".$mes[$MM-1]." del ".$YY;
      return $res;
    }
    public function saveSolicitud($post,$constanciaFile,$idAlumno,$numeroControl){
      try {
        $sql =
        "
          SELECT
            1
          FROM cronograma
          WHERE idAlumno = :idAlumno
          LIMIT 1
        ";
        $con = $this->connection->prepare($sql);
        $con->bindParam(":idAlumno",$idAlumno);
        $con->execute();

        if($con->rowCount()){

            //  $this->connection->beginTransaction();
              $sql =
              "
                INSERT INTO anteproyecto
                (
                    vTitulo,
                    vObjectivoGeneral,
                    vObjectivoEspecifico,
                    vAlcancesDelimitaciones,
                    vDescripcionActividades,
                    vAreaOLugarImplementacion
                )
                VALUES
                (
                  :vTitulo,
                  :vObjectivoGeneral,
                  :vObjectivoEspecifico,
                  :vAlcancesDelimitaciones,
                  :vDescripcionActividades,
                  :vAreaOLugarImplementacion
                )
              ";
              $prepare = $this->connection->prepare($sql);
              $prepare->bindParam(":vTitulo",$post["tituloAnteproyecto"]);
              $prepare->bindParam(":vObjectivoGeneral",$post["objectivoGeneral"]);
              $prepare->bindParam(":vObjectivoEspecifico",$post["objectivoEspecifico"]);
              $prepare->bindParam(":vAlcancesDelimitaciones",$post["alcancesDelimitaciones"]);
              $prepare->bindParam(":vDescripcionActividades",$post["descripcionActividades"]);
              $prepare->bindParam(":vAreaOLugarImplementacion",$post["areaOLugarImplementacion"]);
              $prepare->execute();
              $idAnteproyecto = $this->connection->lastInsertId();

              $sql =
              "
                INSERT INTO proyectoseleccionado
                (
                    idBancoProyecto,
                    idAlumno,
                    idPeriodo,
                    idOpcion,
                    idGiro,
                    idEstado,
                    idSector,
                    asesorInterno,
                    asesorExterno,
                    personasQueFirmaran,
                    idAnteProyecto
                )
                VALUES
                (
                  :idBancoProyecto,
                  :idAlumno,
                  :idPeriodo,
                  :idOpcion,
                  :idGiro,
                  3,
                  :idSector,
                  :asesorInterno,
                  :asesorExterno,
                  :personasQueFirmaran,
                  :idAnteProyecto
                )
              ";
              $prepare = $this->connection->prepare($sql);
              $prepare->bindParam(":idBancoProyecto",$post["idProyecto"]);
              $prepare->bindParam(":idAlumno",$idAlumno);
              $prepare->bindParam(":idPeriodo",$post["idPeriodo"]);
              $prepare->bindParam(":idOpcion",$post["idOpcion"]);
              $prepare->bindParam(":idGiro",$post["idGiro"]);
              $prepare->bindParam(":idSector",$post["idSector"]);
              $prepare->bindParam(":asesorInterno",$post["asesorInterno"]);
              $prepare->bindParam(":asesorExterno",$post["asesorExterno"]);
              $prepare->bindParam(":personasQueFirmaran",$post["personasQueFirmaran"]);
              $prepare->bindParam(":idAnteProyecto",$idAnteproyecto);
              $prepare->execute();
              $IDProyectoSeleccionado = $this->connection->lastInsertId();

              $SQLINTPROCESS = $this->connection->PREPARE("
                                                            UPDATE alumnos
                                                            SET
                                                                iProceso           = 1,
                                                                domicilio          = '".$post["domicilioAlumno"]."',
                                                                colonia            = '".$post["coloniaAlumno"]."',
                                                                ciudadEstado       = '".$post["ciudadEstado"]."',
                                                                cp                 = '".$post["cp"]."',
                                                                telefono           = '".$post["telefono"]."',
                                                                idSeguro           = '".$post["idSeguroSocial"]."',
                                                                numeroSeguro       = '".$post["numeroSeguro"]."'
                                                            WHERE idAlumno = :idAlumno
                                                          ");
              $SQLINTPROCESS->bindParam(":idAlumno", $idAlumno);
              $SQLINTPROCESS->execute();

              $url = "../documentos/";

              $sql =
                    "
                    SELECT
                      vPeriodo
                    FROM periodos
                    WHERE idPeriodo = :idPeriodo
                    ";
              $SQLINTPROCESS = $this->connection->PREPARE($sql);
              $SQLINTPROCESS->bindParam(":idPeriodo",$post["idPeriodo"]);
              $SQLINTPROCESS->execute();
              $row = $SQLINTPROCESS->fetch();

              $periodo = $row["vPeriodo"];



              $sql =
                    "
                    SELECT
                      c.vClave
                    FROM alumnos a
                    INNER JOIN carreras c ON(c.idCarrera = a.idCarrera)
                    WHERE a.idAlumno = :idAlumno
                    ";
              $SQLINTPROCESS = $this->connection->PREPARE($sql);
              $SQLINTPROCESS->bindParam(":idAlumno",$idAlumno);
              $SQLINTPROCESS->execute();
              $row = $SQLINTPROCESS->fetch();
              $carrera = $row["vClave"];



              if(!file_exists($url)){
                if(!mkdir($url)){
                  die("fallo al crear la carpeta");
                }
              }
              $url .= $periodo."/";
              if(!file_exists($url)){
                if(!mkdir($url)){
                  die("fallo al crear la carpeta");
                }
              }
              $url .= $carrera."/";

              if(!file_exists($url)){
                if(!mkdir($url)){
                  die("fallo al crear la carpeta");
                }
              }
              $name = uniqid();
              $ext = pathinfo($constanciaFile['name'], PATHINFO_EXTENSION);


              if(!move_uploaded_file($constanciaFile['tmp_name'], $url.$name)){
                die("Fallo al guardar el archivo");
              }



              $sql =
              "
                INSERT INTO documentos
                (
                  idProyectoSeleccionado,
                  idAlumno,
                  idTipoDocumento,
                  idEstado,
                  vNombre,
                  vRuta,
                  bAceptadoAI,
                  bAceptadoAE
                )
                VALUES
                (
                  :idProyectoSeleccionado,
                  :idAlumno,
                  2,
                  3,
                  :vNombre,
                  :vRuta,
                  0,
                  0
                )
              ";

              $name .= ".".$ext;
              $SQLINTPROCESS = $this->connection->prepare($sql);
              $SQLINTPROCESS->bindParam(":idProyectoSeleccionado",$IDProyectoSeleccionado);
              $SQLINTPROCESS->bindParam(":idAlumno",$idAlumno);
              $SQLINTPROCESS->bindParam(":vNombre",$name);
              $SQLINTPROCESS->bindParam(":vRuta",$url);

              $SQLINTPROCESS->execute();


              $SQLINTPROCESS = $this->connection->PREPARE("UPDATE alumnos SET iProceso = 2 WHERE idAlumno = :idAlumno");
              $SQLINTPROCESS->bindParam(":idAlumno", $idAlumno);
              $SQLINTPROCESS->execute();
              //$this->connection->commit();
              echo '<div class="alert alert-dismissable alert-success">Solicitud guardada exitosamente!
                  <button type="button" class="close" data-dismiss="alert">x</button>
                    </div>';

          }else{
            echo '<div class="alert alert-dismissable alert-danger">Debes de guardar un cronograma primero! el Conograma se encuentra en la parte inferior de la solicitud!
                <button type="button" class="close" data-dismiss="alert">x</button>
                </div>';
          }
      } catch (PDOException $e) {
        	//$this->connection->rollback();
          echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
  						<button type="button" class="close" data-dismiss="alert">x</button>
  					  </div>';
      }

      //2 tipo documento
      //3 en espera


  /*  }else{
        echo '<div class="alert alert-dismissable alert-danger">Algo salio mal, intentalo de nuevo...
            <button type="button" class="close" data-dismiss="alert">x</button>
            </div>';
      }*/
    }
    public function saveLetters($idAlumno, $NumeroControl ,$cartaPresentacion, $cartaAceptacion) {
			try {

        $url = "../documentos/";

        $sql =
              "
              SELECT
                  p.vPeriodo
              FROM proyectoseleccionado ps
              INNER JOIN periodos p ON(ps.idPeriodo = p.idPeriodo)
              WHERE ps.idAlumno = :idAlumno
              ";
        $SQLINTPROCESS = $this->connection->PREPARE($sql);
        $SQLINTPROCESS->bindParam(":idAlumno",$idAlumno);
        $SQLINTPROCESS->execute();
        $row = $SQLINTPROCESS->fetch();

        $url .= $row["vPeriodo"]."/";



        $sql =
              "
              SELECT
                c.vClave
              FROM alumnos a
              INNER JOIN carreras c ON(c.idCarrera = a.idCarrera)
              WHERE a.idAlumno = :idAlumno
              ";
        $SQLINTPROCESS = $this->connection->PREPARE($sql);
        $SQLINTPROCESS->bindParam(":idAlumno",$idAlumno);
        $SQLINTPROCESS->execute();
        $row = $SQLINTPROCESS->fetch();
        $carrera = $row["vClave"];

        $url .= $carrera."/";


				//$NombrePresentacion = $cartaPresentacion['name'].;//explode('.', $cartaPresentacion['name']);
				//$NombreAceptacion = $cartaAceptacion['name'];

        $namePress = uniqid();
        $extPress = pathinfo($cartaPresentacion['name'], PATHINFO_EXTENSION);

        $nameAccep = uniqid();
        $extAccep = pathinfo($cartaAceptacion['name'], PATHINFO_EXTENSION);



				$RutaPresentacion = $url.$namePress.".".$extPress;
				$RutaAceptacion =   $url.$nameAccep.".".$extAccep;

				$SuccessPresentacion = move_uploaded_file($cartaPresentacion['tmp_name'], $RutaPresentacion);
				$SuccessAceptacion = move_uploaded_file($cartaAceptacion['tmp_name'], $RutaAceptacion);


				$SQLIdProyecto = $this->connection->PREPARE("SELECT idProyectoSeleccionado FROM proyectoseleccionado WHERE idAlumno = :idAlumno");
				$this->connection->beginTransaction();

				if($SuccessAceptacion && $RutaPresentacion) {
					$SQLIdProyecto->bindParam(":idAlumno",$idAlumno);
					$SQLIdProyecto->execute();
					$IDProyecto = $SQLIdProyecto->fetch(PDO::FETCH_ASSOC);

					$UNA = "asdadsda";

					$SQLPresentacion = $this->connection->PREPARE("INSERT INTO documentos (idProyectoSeleccionado,idAlumno,idTipoDocumento,idEstado,vNombre,vRuta) VALUES (:idProyectoSeleccionado,:idAlumno,4,4,:vNombre,:vRuta)");

					$SQLPresentacion->bindParam(":idProyectoSeleccionado",$IDProyecto['idProyectoSeleccionado']);
					$SQLPresentacion->bindParam(":vNombre",$UNA);
					$SQLPresentacion->bindParam(":vRuta",$RutaPresentacion);
					$SQLPresentacion->bindParam(":idAlumno",$idAlumno);
					$SQLPresentacion->execute();

					$SQLAceptacion = $this->connection->PREPARE("INSERT INTO documentos (idProyectoSeleccionado,idAlumno,idTipoDocumento,idEstado,vNombre,vRuta) VALUES (:idProyectoSeleccionado,:idAlumno,9,4,:vNombre,:vRuta)");

					$SQLAceptacion->bindParam(":idProyectoSeleccionado",$IDProyecto['idProyectoSeleccionado']);
					$SQLAceptacion->bindParam(":vNombre",$UNA);
					$SQLAceptacion->bindParam(":vRuta",$RutaAceptacion);
					$SQLAceptacion->bindParam(":idAlumno", $idAlumno);
					$SQLAceptacion->execute();

					$SQLINTPROCESS = $this->connection->PREPARE("UPDATE alumnos SET iProceso = 4 WHERE idAlumno = :idAlumno");
					$SQLINTPROCESS->bindParam(":idAlumno", $idAlumno);
					$SQLINTPROCESS->execute();

					$this->connection->commit();
					echo '<div class="alert alert-dismissable alert-success">Archivos registrados correctamente!
							<button type="button" class="close" data-dismiss="alert">x</button>
						  </div>';
				} else {
					$this->connection->rollback();
					unlink($RutaPresentacion);
					unlink($RutaAceptacion);
					echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: al subir los documentos. Intentalo nuevamente
							<button type="button" class="close" data-dismiss="alert">x</button>
					 	  </div>';
				}
			} catch (PDOException $e) {
				$this->CONNECTION->rollback();
				echo '<div class="alert alert-dismissable alert-danger">Ocurrió un error: '.$e->getMessage().'
						<button type="button" class="close" data-dismiss="alert">x</button>
				 	  </div>';
			}
		}

  }


?>
