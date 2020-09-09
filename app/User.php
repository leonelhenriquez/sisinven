<?php
	namespace app;

	use Wave\Util;

	use app\TipoUsuario;

	/*
	 * @autor Leonel Henriquez
	 */
	class User
	{
		private $id;
		private $username;
		private $tipoUsuario;
		private $nombre;
		private $apellido;
		private $passwordChangedDate;
		private $empresa;
		private $foto;

		public function getId()
		{
			return $this->id;
		}

		public function setId($id)
		{
			$this->id = $id;

			return $this;
		}

		public function getUsername()
		{
			return $this->username;
		}

		public function setUsername($username)
		{
			$this->username = $username;

			return $this;
		}

		public function getTipoUsuario(): ?TipoUsuario
		{
			return $this->tipoUsuario;
		}

		public function setTipoUsuario($id,$nombre)
		{
			$this->tipoUsuario = new TipoUsuario($id,$nombre);

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

		public function getApellido()
		{
			return $this->apellido;
		}

		public function setApellido($apellido)
		{
			$this->apellido = $apellido;

			return $this;
		}

		public function getPasswordChangedDate($format = 'Y-m-d H:i:s'){
			return Util::parseDateTime($this->passwordChangedDate,$format); 
		}
		
		public function setPasswordChangedDate($passwordChangedDate){
			$this->passwordChangedDate = $passwordChangedDate;
			return $this;
		}
		
		public function getEmpresa()
		{
			return $this->empresa;
		}

		public function setEmpresa($empresa)
		{
			$this->empresa = $empresa;

			return $this;
		}
		public function getFoto($size = 500)
		{
			return str_replace("{size}",$size,$this->foto);
		}

		public function setFoto($foto)
		{
			$this->foto = $foto;

			return $this;
		}
	}

?>