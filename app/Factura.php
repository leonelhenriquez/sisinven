<?php

	namespace app;

	use app\User;

	use Wave\Util;

	/*
	 * @autor Leonel Henriquez
	 */
	class Factura{
		private $id;
		private $fecha;
		private $hora;
		private $nombreCliente;
		private $subtotal;
		private $usuario;
	
		public function getId()
		{
			return $this->id;
		}

		public function setId($id)
		{
			$this->id = $id;

			return $this;
		}

		public function getFecha($format = 'Y-m-d')
		{
			return Util::parseFecha($this->fecha,$format);
		}

		public function setFecha($fecha)
		{
			$this->fecha = $fecha;

			return $this;
		}

		public function getHora($format = 'H:i:s')
		{
			return Util::parseHora($this->hora,$format);
		}

		public function setHora($hora)
		{
			$this->hora = $hora;

			return $this;
		}

		public function getNombreCliente()
		{
			return $this->nombreCliente;
		}

		public function setNombreCliente($nombreCliente)
		{
			$this->nombreCliente = $nombreCliente;

			return $this;
		}

		public function getSubtotal()
		{
			return $this->subtotal;
		}

		public function setSubtotal($subtotal)
		{
			$this->subtotal = $subtotal;

			return $this;
		}

		public function getUsuario(): ?User
		{
			return $this->usuario;
		}

		public function setUsuario($usuario)
		{
			$this->usuario = $usuario;

			return $this;
		}
}

?>