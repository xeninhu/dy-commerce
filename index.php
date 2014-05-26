<?php
    require 'libs/Slim/Slim/Slim.php';
	require 'classes/bd_singleton.php';
	\Slim\Slim::registerAutoloader();
	$app = new \Slim\Slim();
	$app->response()->header('Content-Type', 'application/json;charset=utf-8');
	$app->get('/', function () {
		echo "Dynamic Commerce";
	});
	$app->post('/categoria/', function() {
		/*require 'classes/canais.php';
		require 'classes/evento.php';
		$evento_controller = new Evento();
		print_r(json_encode($evento_controller->post()));*/
	});
	
	
	$app->run();
?>