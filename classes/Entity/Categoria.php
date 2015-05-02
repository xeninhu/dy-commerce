<?php

	namespace Entity;
	
	use API\JsonSerializable;
	/**
	 *
	 * @Entity
	 * @Table(name="categoria")
	 */
	Class Categoria implements JsonSerializable
	{
	    /**
	     * @Id
	     * @GeneratedValue(strategy="AUTO")
	     * @Column(type="integer", name="id")
	     */
	    protected $id;
	 
	    /**
	     * @Column(type="string", name="categoria", unique=true)
	     */
	    protected $categoria;
		
		/**
		 * @ManyToOne(targetEntity="Categoria")
     	 * @JoinColumn(name="id", referencedColumnName="id")
		 * @Column(type="integer",name="categoria_id")
		 */
		protected $pai;
		
		/**
		 * @Column(type="boolean",name="active")
		 */
		protected $active;
	 
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
	 
	 	public function serialize_to_json() {
	 		$json = array();
			foreach ($this as $key => $value) {
				if($value == null)
					$json[$key] = null;
				else if($key=="pai")
					$json[$key] = $value->serialize_to_json();
				else 
					$json[$key] = $value;
			}
			return $json;
	 	}
	 
	}
?>