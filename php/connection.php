<?php 

	try{
		$handler = new PDO('mysql:host=127.0.0.1;dbname=residenciasitsa','root',''); //Localhost
		$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo $e->getMessage();
	}	

	include_once 'residenciasitsa.class.php';
	$ObjectITSA = new ITSA($handler);

	include_once 'filemanager.class.php';
	$ObjectITSAFiles = new fileManager($handler);

?>