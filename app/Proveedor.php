<?php
	namespace app;
	/**
	 * @autor Leonel
	 */
	class Proveedor
	{
		private $id_proveedor;
		private $nombre_proveedor;

	
		public function getIdProveedor()
		{
			return $this->id_proveedor;
		}

		public function setIdProveedor(int $id_proveedor)
		{
			$this->id_proveedor = $id_proveedor;

			return $this;
		}

		public function getNombreProveedor()
		{
			return $this->nombre_proveedor;
		}

		public function setNombreProveedor(string $nombre_proveedor)
		{
			$this->nombre_proveedor = $nombre_proveedor;

			return $this;
		}
}