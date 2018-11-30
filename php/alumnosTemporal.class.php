<?php
  class alumnosTemporal{
    private $connection;
    function __construct($handler){
      $this->connection = $handler;
    }

    public function saveSolicitud($post,$constanciaFile,$idAlumno,$numeroControl){
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
            personasQueFirmaran
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
          :personasQueFirmaran
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
      echo $url;

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
      $SQLINTPROCESS->bindParam(":idProyectoSeleccionado",$post["idProyecto"]);
      $SQLINTPROCESS->bindParam(":idAlumno",$idAlumno);
      $SQLINTPROCESS->bindParam(":vNombre",$name);
      $SQLINTPROCESS->bindParam(":vRuta",$url);
      $SQLINTPROCESS->execute();


      $SQLINTPROCESS = $this->connection->PREPARE("UPDATE alumnos SET iProceso = 2 WHERE idAlumno = :idAlumno");
      $SQLINTPROCESS->bindParam(":idAlumno", $idAlumno);
      $SQLINTPROCESS->execute();
      //2 tipo documento
      //3 en espera

      echo '<div class="alert alert-dismissable alert-success">Solicitud guardada exitosamente!
          <button type="button" class="close" data-dismiss="alert">x</button>
            </div>';

  /*  }else{
        echo '<div class="alert alert-dismissable alert-danger">Algo salio mal, intentalo de nuevo...
            <button type="button" class="close" data-dismiss="alert">x</button>
            </div>';
      }*/
    }
  }


?>
