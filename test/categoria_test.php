<?php
	require_once("../libs/simpletest/autorun.php");
	require_once("../libs/autoload.php");
	
	use Controller\CategoriaController;
	use Entity\Categoria;
	use Entity\ReturnObj;
	use Config\Bootstrap;
	
	Class CategoriaTest extends UnitTestCase {
		
		/**
		 * Não deve ser permitido duas categorias com o mesmo nome, a menos que possuam categorias pai distintas.
		 */	
		function test_double_name_forbid() {
			$cat_controller = new CategoriaController();
			
			$return = $cat_controller->insert_categoria("testandoNomeDif", null);
			$this->assertTrue($return->get_success()); //Consegui inserir
			
			$cat_return = $return->get_transaction_return();
			$this->assertNotNull($cat_return); //A categoria foi retornada
			
			$cat_controller = new CategoriaController(); //Crio novamente um controller para iniciar o processo
			$return2 = $cat_controller->insert_categoria("testandoNomeDif",null);
			
			$this->assertFalse($return2->get_success()); //Não pode inserir com o mesmo nome
			
			$bs_instance = Bootstrap::get_instance();
			$ent_manager = $bs_instance->get_entity_manager();
			
			$categories = $ent_manager->getRepository("Entity\Categoria")->findBy(array("categoria"=>"testandoNomeDif"));
			
			$this->assertEqual(count($categories), 1); //Mesmo que tenha dado erro, verificar se não possui mais de um registro no banco
			
			foreach($categories as $category) {
				$ent_manager->remove($category);
			}
			$ent_manager->flush();
			
		}
		
		/**
		 * Uma categoria só poderá ter como categoria pai categorias que não possuam nenhuma categoria pai.
		 */
		function test_only_has_no_father_as_father() {
			$cat_controller = new CategoriaController();
			$return = $cat_controller->insert_categoria("grand father cat test", null);
			$this->assertTrue($return->get_success()); //Consegui inserir avô
			$granpa_return = $return->get_transaction_return();
			$this->assertNotNull($granpa_return); //A categoria foi retornada
			
			
			if($return->get_success()) { //Só preciso continuar testando se eu inseri o avô
				$cat_controller = new CategoriaController();
				$return2 = $cat_controller->insert_categoria("father cat test", $granpa_return->get_id());
				$this->assertTrue($return2->get_success()); //Consegui inserir pai
				$father_return = $return2->get_transaction_return();
				$this->assertNotNull($granpa_return); //A categoria foi retornada
				
				if($return2->get_success()) {//Só preciso continuar testando se eu inseri o pai
					$cat_controller = new CategoriaController();
					$return3 = $cat_controller->insert_categoria("error son cat test", $father_return->get_id());
					$this->assertFalse($return3->get_success()); //Não posso conseguir inserir
					$son_return = $return3->get_transaction_return();
					$this->assertNull($son_return); //A categoria não foi retornada pois não foi inserida
				}
			}
			$bs_instance = Bootstrap::get_instance();
			$ent_manager = $bs_instance->get_entity_manager();
			
			if(isset($son_return) && $son_return!=null)
				$ent_manager->remove($son_return);
			if(isset($father_return) && $father_return!=null)
				$ent_manager->remove($father_return);
			if(isset($granpa_return) && $granpa_return!=null)
				$ent_manager->remove($granpa_return);

			$ent_manager->flush();
		}
		
		/**
		 * Uma categoria não poderá ter mais que 50 caracteres.
		 */
		function test_name_has_less_then_50() {
			
			$cat_controller = new CategoriaController();
			$return = $cat_controller->insert_categoria("grand father cat test asdpoifas asdpo poasid ipoas poas mpompasoospasoifaso  fsdsipoasdj aspod sdiooapsodi idospaoi iospaosi dipas", null);
			$this->assertFalse($return->get_success()); 
			
			$bs_instance = Bootstrap::get_instance();
			$ent_manager = $bs_instance->get_entity_manager();
			
			$categoria = $ent_manager->getRepository("Entity\Categoria")->findOneBy(array("categoria"=>
																			 "grand father cat test asdpoifas asdpo poasid ipoas poas mpompasoospasoifaso  fsdsipoasdj aspod sdiooapsodi idospaoi iospaosi dipas"));																			 
			$this->assertNull($categoria);
			
		}
		
		/**
		 * Uma categoria não poderá possuir símbolos ou números em sua composição.
		 */
		function test_name_has_no_numbers_or_special_chars() {
			$cat_controller = new CategoriaController();
			$return = $cat_controller->insert_categoria("n40 Pod3 pegar", null);
			$this->assertFalse($return->get_success()); 
			
			$cat_controller = new CategoriaController();
			$return = $cat_controller->insert_categoria("n Pod&e pegar", null);
			$this->assertFalse($return->get_success()); 
			
			$cat_controller = new CategoriaController();
			$return = $cat_controller->insert_categoria("n Pod!e pegar", null);
			$this->assertFalse($return->get_success()); 
			
			$bs_instance = Bootstrap::get_instance();
			$ent_manager = $bs_instance->get_entity_manager();
			
			$flush = false;
			
			$categoria = $ent_manager->getRepository("Entity\Categoria")->findOneBy(array("categoria"=>"n40 Pod3 pegar"));
			$this->assertNull($categoria);
			if($categoria!=null) {
				$ent_manager->remove($categoria);
				$flush=true;
			}
			$categoria = $ent_manager->getRepository("Entity\Categoria")->findOneBy(array("categoria"=>"n Pod&e pegar"));
			$this->assertNull($categoria);
			if($categoria!=null) {
				$ent_manager->remove($categoria);
				$flush=true;
			}
			$categoria = $ent_manager->getRepository("Entity\Categoria")->findOneBy(array("categoria"=>"n Pod!e pegar"));
			$this->assertNull($categoria);
			if($categoria!=null) {
				$ent_manager->remove($categoria);
				$flush=true;
			}
			$categoria = $ent_manager->getRepository("Entity\Categoria")->findOneBy(array("categoria"=>"n Podã pegar"));
			$this->assertNull($categoria);
			if($categoria!=null) {
				$ent_manager->remove($categoria);
				$flush=true;
			}
			
			if($flush)
				$ent_manager->flush();
			
		}
	}
?>