<?php
	namespace Controller;

	use Entity\Categoria;
	use Entity\ReturnObj;
	use Config\Bootstrap;
	use Doctrine\DBAL\DBALException;
	
	Class CategoriaController {
		private $categoria;
		private $entity_manager;
		
		public function __construct() {
			//require_once('classes/entities/Categoria.php');
			$this->categoria = new Categoria();
		//	require_once('config/bootstrap.php');
			$singleton = Bootstrap::get_instance();
			$this->entity_manager = $singleton->get_entity_manager();
		}
		
		public function insert_categoria($categoria,$pai) {
			$this->categoria->set_categoria($categoria);
			$this->categoria->set_active(true);
			$return = new ReturnObj();
			try {
				$this->entity_manager->persist($this->categoria);
				$this->entity_manager->flush();
				$return->set_success(true);
				$return->set_transaction_msg(null);
			}catch(DBALException $e) {
				$return->set_success(false);
				$return->set_transaction_msg($e->getMessage());
			}
			return $return;
		}
	}
?>