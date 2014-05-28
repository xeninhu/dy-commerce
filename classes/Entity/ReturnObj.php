<?php
	namespace Entity;
	
	/**
	 * Apesar de possuir getters e setters, os atributos dessa classe precisam ser 
	 * públicos pois esse objeto será transformado em JSON para enviar para quem 
	 * solicitar o serviço.
	 * 
	 */
	Class ReturnObj {
		/**
		 * Indica se houve ou não sucesso durante a transação.
		 */
		public $success;
		
		/**
		 * Valor correspondente ao retorno da transação, valorado apenas caso a
		 * operação tenha sido feita com sucesso.
		 */
		public $transaction_return;
		
		/**
		 * Mensagem de erro da transação.
		 */
		public $msg;
		
		/**
		 * Seta o retorno como sucesso para true. Qualquer valor diferente de true
		 * seta o retorno como sem sucesso
		 */
		public function set_success($success) {
			if($success===true)
				$this->success = true;
			else {
				$this->success = false;
			}
		}
		
		public function get_success() {
			return $this->success();
		}
		
		/**
		 * Seta um valor para o retorno da transação.
		 */
		public function set_transaction_return($return) {
			$this->transaction_return=$return;
		}
		
		public function get_transaction_return() {
			return $this->transaction_return;
		}
		
		/**
		 * 
		 * Seta a mensagem da transação(erro ou sucesso) com o valor de $msg caso a mesma seja uma string.
		 * Caso contrário, seta como "Transação efetuada com sucesso" em caso de sucesso e "Houve um problema
		 * na transação" caso $success não seja verdadeiro.
		 * 
		 */
		public function set_transaction_msg($msg) {
			if(gettype($msg)!=="string") {
				if($this->success)
					$this->msg = "Transação efetuada com sucesso";
				else 
					$this->msg = "Houve um problema na transação";
			}
			else 
				$this->msg=$msg;
		}
		
		/**
		 * Caso não tenha previamente setada uma mensagem para a transação, a mensagem 
		 * "Transação efetuada com sucesso" será retornada para o caso de $sucess ser true, caso
		 * contrário retornará a mensagem padrão "Houve um problema na transação"
		 */
		public function get_transaction_msg() {
			if(!isset($this->msg)) {
				if($this->success)
					$this->msg = "Transação efetuada com sucesso";
				else 
					$this->msg ="Houve um problema na transação";
			}
			return $this->msg;
		}
		
	}
	
?>