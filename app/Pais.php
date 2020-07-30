<?php

	namespace app;

	/*
	 * @autor Leonel Henriquez
	 */
	class Pais
	{
		
		private $id_pais;
		private $cod_area;
		private $nombre;


		function __construct($id_pais,$cod_area,$nombre)
		{
			$this->setIdPais($id_pais)
				->setCodigoArea($cod_area)
				->setNombre($nombre);
		}
		
		public function getIdPais()
		{
			return $this->id_pais;
		}

		public function setIdPais($id_pais)
		{
			$this->id_pais = $id_pais;

			return $this;
		}

		public function getCodigoArea()
		{
			return $this->cod_area;
		}

		public function setCodigoArea($cod_area)
		{
			$this->cod_area = $cod_area;

			return $this;
		}

		public function getNombre()
		{
			return $this->nombre;
		}

		public function setNombre($nombre)
		{
			$this->nombre = $nombre;

			return $this;
		}
	}

?>