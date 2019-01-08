<?php
	use  Illuminate\Database\Capsule\Manager as Capsule;
	$capsule = new Capsule;

	$capsule->addConnection([
		'driver' => 'mysql',
		'host'   => '185.201.11.65',
		'database' => 'u276604013_dbres',
		'username' => 'u276604013_itsa',
		'password' => 'jesus_321',
		'charset' => 'utf8',
		'collation' => 'utf8_unicode_ci',
		'prefix' => ''
	]);

	$capsule->bootEloquent();
	$capsule->setAsGlobal();
?>
