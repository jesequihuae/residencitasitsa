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
