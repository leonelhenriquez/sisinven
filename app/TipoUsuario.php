<?php

	namespace app;

	/*
	 * @autor Leonel Henriquez
	 */
	class TipoUsuario{
		private $id;
		private $nombre;

		function __construct($id,$nombre){
			$this->setId($id);
			$this->setNombre($nombre);
		}

		public function getId()
		{
			return $this->id;
		}

		public function setId($id)
		{
			$this->id = $id;

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