<?php 
  include 'connection.php';
  $opcion = $_POST['opcion'];
  $idCarrera = $_POST['idCarrera'];

		if ($opcion == 1) {
			$array = $ObjectITSA->graficaOpcionElegida();
			foreach ($array as $key) {
			   $ResultadoGrafica1[] = array("Carrera"=>$key['Carrera'],$key["vClaveOpcion"]=>(int)$key['Total']); 
			}
			echo json_encode($ResultadoGrafica1);
		}

		if ($opcion == 2) {
			$array = $ObjectITSA->graficaTotalGiro($idCarrera);
			foreach ($array as $key) {
			   $ResultadoGrafica2[] = array("Carrera"=>$key['Carrera'],$key["vClaveGiro"]=>(int)$key['Total']); 
			}
			echo json_encode($ResultadoGrafica2);
		}

		if ($opcion == 3) {
			$array = $ObjectITSA->graficaGiroMujeryHombre($idCarrera);
			foreach ($array as $key) {
			   $ResultadoGrafica3[] = array("Giro"=>$key['Giro'],$key["Sexo"]=>(int)$key['Total']); 
			}
			echo json_encode($ResultadoGrafica3);
		}

		if ($opcion == 4) {
			$array = $ObjectITSA->graficaSector($idCarrera);
			foreach ($array as $key) {
			   $ResultadoGrafica4[] = array("Carrera2"=>$key['Carrera2'],$key["vClaveSector"]=>(int)$key['Total']); 
			}
			echo json_encode($ResultadoGrafica4);
		}

		if ($opcion == 5) {
			$array = $ObjectITSA->graficaSectorMujeryHombre($idCarrera);
			foreach ($array as $key) {
			   $ResultadoGrafica4[] = array("Sector"=>$key['Sector'],$key["Sexo"]=>(int)$key['Total']); 
			}
			echo json_encode($ResultadoGrafica4);
		}
	
 ?>