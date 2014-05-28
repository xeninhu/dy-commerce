<?php
	namespace Config;
	
	use Doctrine\ORM\Tools\Setup;
	use Doctrine\ORM\EntityManager;
	
	/**
	 * Classe para recuperar o entity manager do doctrine 2.
	 * Cada entity vai para a sessão do usuário para que não seja necessário criar novamente.
	 * Não é um singleton para todas as requisições para não ter problema de concorrência nas transações.
	 *
	 */
	Class Bootstrap {
		private $entity_manager;
		
		private function __construct() {
			$entidades = array("classes/entities");
			$isDevMode = true;

			$dbParams = array(
			    'driver'   => 'pdo_mysql',
			    'user'     => 'root',
			    'password' => '',
			    'dbname'   => 'dycommerce',
			);
			
			$config = Setup::createAnnotationMetadataConfiguration($entidades, $isDevMode);
			$this->entity_manager = EntityManager::create($dbParams, $config);
			$_SESSION['bootstrap'] = $this;
		}
		
		static public function get_instance() {
			
			if(!isset($_SESSION['bootstrap'])) {
				$_SESSION['bootstrap'] = new Bootstrap();	
			}
			
			return $_SESSION['bootstrap']; 
		}
		
		public function get_entity_manager() {
			return $this->entity_manager;
		}
	}
	
?>