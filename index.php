<?php
    //require 'libs/slim/slim/Slim/Slim.php';
	require_once "libs/autoload.php";
	
	use Slim\Slim;
	use Controller\CategoriaController;
	
	
	
	//Slim::registerAutoloader();
	$app = new Slim();
	
	$app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	$app->get('/', function () {
		echo "Dynamic Commerce";
	});
	
	/**
	 *
	 * Insere categoria 
	 *
	 * @params categoria
	 * @params pai
	 */
	$app->post('/categoria/', function() use ($app){
		$params = json_decode($app->request()->getBody());
		$controller = new CategoriaController();
		$return = $controller->insert_categoria($params->categoria,$params->pai);
		print_r(json_encode($return));
		
	});
	
	
	$app->run();
?>