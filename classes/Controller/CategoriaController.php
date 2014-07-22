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
			$this->categoria = new Categoria();
			$singleton = Bootstrap::get_instance();
			$this->entity_manager = $singleton->get_entity_manager();
		}
		
		public function list_categorias() {
			$return = new ReturnObj();
			$categorias = $this->entity_manager->getRepository("Entity\Categoria")->findBy(array("pai"=>null));
			$return->set_success(true);
			$return->set_transaction_return($categorias);
			return $return;
		}
		
		public function insert_categoria($categoria,$pai) {
			$return = new ReturnObj();
			if(strlen($categoria)>50) {
				$return->set_success(false);
				$return->set_transaction_msg("Uma categoria não pode ter mais que 50 caracteres");
				return $return;
			}
			
			if(!preg_match("#^[a-zA-Zà-úÀ-Ú ]+$#", $categoria)) {
				$return->set_success(false);
				$return->set_transaction_msg("Nome inválido para a categoria. Remova numeros e/ou caracteres especiais");
				return $return;
			}
			
			$this->categoria->set_categoria($categoria);
			$this->categoria->set_active(true);
			
			if(isset($pai) && $pai!=null) {
				$categoriaPai = $this->entity_manager->find('Entity\Categoria',$pai);
				if($categoriaPai->get_pai()!=null) {
					$return->set_success(false);
					$return->set_transaction_msg("Uma categoria só poderá ter como 
												  categoria pai categorias que não possuam nenhuma 
												  categoria pai");
					return $return;
				}
				else {
					$this->categoria->set_pai($pai);
				}
			}
			
			try {
				$this->entity_manager->persist($this->categoria);
				$this->entity_manager->flush();
				$return->set_success(true);
				$return->set_transaction_msg(null);
				$return->set_transaction_return($this->categoria->get_id());
			}catch(DBALException $e) {
				$return->set_success(false);
				$return->set_transaction_msg($e->getMessage());
			}
			return $return;
		}
	}
?>