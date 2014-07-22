<?php

	namespace Entity;
	
	/**
	 *
	 * @Entity
	 * @Table(name="categoria")
	 */
	Class Categoria 
	{
	    /**
	     * @Id
	     * @GeneratedValue(strategy="AUTO")
	     * @Column(type="integer", name="id")
	     */
	    public $id;
	 
	    /**
	     * @Column(type="string", name="categoria", unique=true)
	     */
	    public $categoria;
		
		/**
		 * @ManyToOne(targetEntity="Categoria")
     	 * @JoinColumn(name="id", referencedColumnName="id")
		 * @Column(type="integer",name="categoria_id")
		 */
		public $pai;
		
		/**
		 * @Column(type="boolean",name="active")
		 */
		public $active;
	 
	    public function get_id()
	    {
	        return $this->id;
	    }
	 
	    public function get_categoria()
	    {
	        return $this->categoria;
	    }
	 
	    public function set_categoria($categoria)
	    {
	        $this->categoria = $categoria;
	    }
		
		public function get_pai() {
			return $this->pai;
		}
		
		public function set_pai($pai) {
			$this->pai = $pai;
		}
		
		public function is_active() {
			return $this->active;
		}
		
		public function set_active($active) {
			$this->active = $active;
		}
	 
	 	/*public function jsonSerialize() {
			foreach ($this as $key => $value) {
				if($key=="pai")
					$json->$key = $value->jsonSerialize();
				else 
					$json->$key = $value;
			}
			return $json;
	 	}*/
	 
	}
?>