<?php

	namespace app;

	/*
	 * @autor Leonel Henriquez
	 */

	use app\Pais;

	class Direccion
	{
		private $id_direccion;
		private $id_persona;
		private $tipo;
		private $direccion;
		private $departamento;
		private $pais;
		function __construct($id_direccion,$id_persona,$tipo,$direccion,$departamento,$id_pais,$cod_area,$nombre)
		{
			$this->setIdDireccion($id_direccion)
				->setIdPersona($id_persona)
				->setTipo($tipo)
				->setDireccion($direccion)
				->setDepartamento($departamento)
				->setPais($id_pais,$cod_area,$nombre);
		}
		
	    public function getIdDireccion()
	    {
	        return $this->id_direccion;
	    }

	    public function setIdDireccion($id_direccion)
	    {
	        $this->id_direccion = $id_direccion;

	        return $this;
	    }

	    public function getIdPersona()
	    {
	        return $this->id_persona;
	    }

	    public function setIdPersona($id_persona)
	    {
	        $this->id_persona = $id_persona;

	        return $this;
	    }

	    public function getTipo()
	    {
	        return $this->d_tipo;
	    }

	    public function setTipo($d_tipo)
	    {
	        $this->d_tipo = $d_tipo;

	        return $this;
	    }

	    public function getDireccion()
	    {
	        return $this->direccion;
	    }

	    public function setDireccion($direccion)
	    {
	        $this->direccion = $direccion;

	        return $this;
	    }

	    public function getDepartamento()
	    {
	        return $this->departamento;
	    }

	    public function setDepartamento($departamento)
	    {
	        $this->departamento = $departamento;

	        return $this;
	    }

	    public function getPais() :?Pais
	    {
	        return $this->pais;
	    }

	    public function setPais($id_pais,$cod_area,$nombre)
	    {
	        $this->pais = new Pais($id_pais,$cod_area,$nombre);

	        return $this;
	    }
	}

?>