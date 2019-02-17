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
		$handler = new PDO('mysql:host=localhost;dbname=residenciasitsa','root','root',array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\'')); //Localhost
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
