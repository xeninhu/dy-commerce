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
	 
	}
?>