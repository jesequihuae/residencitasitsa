<?php
  class alumnosTemporal{
    private $connection;
    function __construct($handler){
      $this->connection = $handler;
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
  }


?>
