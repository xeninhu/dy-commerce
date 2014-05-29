<?php
	namespace Config;
	
	use Doctrine\ORM\Tools\Setup;
	use Doctrine\ORM\EntityManager;
	
	/**
	 * Classe para recuperar o entity manager do doctrine 2.
	 * A instancia da classe vai para a sessão do usuário para que não seja necessário criar novamente.
	 * Não é um singleton para não ter problema de concorrência nas transações.
	 *
	 */
	Class Bootstrap {
		private $config;
		private $params;
		private $entity_manager;
		
		private function __construct() {
			$entidades = array("classes/entities");
			$isDevMode = true;

			$this->params = array(
			    'driver'   => 'pdo_mysql',
			    'user'     => 'root',
			    'password' => '',
			    'dbname'   => 'dycommerce',
			);
			
			$this->config = Setup::createAnnotationMetadataConfiguration($entidades, $isDevMode);
			$this->entity_manager = EntityManager::create($this->params, $this->config);
			$_SESSION['bootstrap'] = $this;
		}
		
		static public function get_instance() {
			
			if(!isset($_SESSION['bootstrap'])) {
				$_SESSION['bootstrap'] = new Bootstrap();	
			}
			
			return $_SESSION['bootstrap']; 
		}
		
		/**
		 * Verifica se o entityManager já foi utilizado e fechado, e caso isso tenha ocorrido, descarto
		 * e crio outro para enviar ao usuário
		 */
		public function get_entity_manager() {
			if(!$this->entity_manager->isOpen()) {
				$this->entity_manager = EntityManager::create($this->params, $this->config);
			}
			return $this->entity_manager;
		}
	}
	
?>