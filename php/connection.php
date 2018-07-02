<?php 
	// try{
	// 	$handler = new PDO('mysql:host=127.0.0.1;dbname=impronta_cesar','impronta_cesar','CNKiZQut%?zG'); //Localhost
	// 	$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// } catch(PDOException $e) {
	// 	echo $e->getMessage();
	// }	

	// include_once 'cesarchavez.class.php';
	// $ObjectCesar = new cesarchavez($handler);
	try{
		$handler = new PDO('mysql:host=127.0.0.1;dbname=diplomadosep','root',''); //Localhost
		$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo $e->getMessage();
	}	

	include_once 'dashboard.class.php';
	$ObjectDashboard = new Dashboard($handler);
?>