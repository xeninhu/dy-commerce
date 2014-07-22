<?php
    //require 'libs/slim/slim/Slim/Slim.php';
	require_once "libs/autoload.php";
	
	use Slim\Slim;
	use Controller\CategoriaController;

	$app = new Slim();
	
	//Cliente
	
	
	$app->get('/', function () use ($app) {
		$app->response()->header('Content-Type', 'text/html;charset=utf-8');
		$app->render("../templates/principal.html");
	});
	
	/**
	 * Página de inserir categoria
	 */
	$app->get('/client/:template', function ($template) use ($app) {
		$app->response()->header('Content-Type', 'text/html;charset=utf-8');
		$app->render("../templates/".$template.".html");
	});
	
	//Serviços
	
	/**
	 *
	 * Insere categoria 
	 *
	 * @params categoria
	 * @params pai
	 */
	$app->post('/categoria/', function() use ($app){
		$app->response()->header('Content-Type', 'application/json;charset=utf-8');
		$params = json_decode($app->request()->getBody());
		$controller = new CategoriaController();
		$return = $controller->insert_categoria($params->categoria,$params->pai);
		print_r(json_encode($return));
		
	});
	
	$app->get('/categoria/', function() use ($app){
		$app->response()->header('Content-Type', 'application/json;charset=utf-8');
		//$params = json_decode($app->request()->getBody());
		$controller = new CategoriaController();
		$return = $controller->list_categorias();
		print_r(json_encode($return));
		
	});
	
	
	$app->run();
?>