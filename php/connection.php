<?php

	/*try{
		$handler = new PDO('mysql:host=127.0.0.1;dbname=residenciasitsa','root',''); //Localhost
		$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo $e->getMessage();
	}

	include_once 'residenciasitsa.class.php';
	$ObjectITSA = new ITSA($handler);

	include_once 'filemanager.class.php';
	$ObjectITSAFiles = new fileManager($handler);

	include_once 'alumnosTemporal.class.php';
	$ObjectITSA1  = new alumnosTemporal($handler);*/

	try{
		$handler = new PDO('mysql:host=185.201.11.65;dbname=u276604013_dbres','u276604013_itsa','jesus_321'); //Localhost
		$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
	include_once 'residenciasitsa.class.php';
	$ObjectITSA = new ITSA($handler);
	include_once 'filemanager.class.php';
	$ObjectITSAFiles = new fileManager($handler);
	include_once 'alumnosTemporal.class.php';
	$ObjectITSA1  = new alumnosTemporal($handler);

?>
