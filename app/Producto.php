<?php
	namespace app;

	use app\{Categoria,Proveedor};

	class Producto{
		
		private $id;
		private $nombre;
		private $marca;
		private $modelo;
		private $cantidadExistencia;
		private $precio;
		private $descripcion;
		private $proveedor;
		private $categoria;

	
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

		public function getMarca()
		{
			return $this->marca;
		}

		public function setMarca($marca)
		{
			$this->marca = $marca;

			return $this;
		}

		public function getModelo()
		{
			return $this->modelo;
		}

		public function setModelo($modelo)
		{
			$this->modelo = $modelo;

			return $this;
		}

		public function getCantidadExistencia()
		{
			return $this->cantidadExistencia;
		}

		public function setCantidadExistencia($cantidadExistencia)
		{
			$this->cantidadExistencia = $cantidadExistencia;

			return $this;
		}

		public function getPrecio()
		{
			return $this->precio;
		}

		public function setPrecio($precio)
		{
			$this->precio = $precio;

			return $this;
		}

		public function getDescripcion()
		{
			return $this->descripcion;
		}

		public function setDescripcion($descripcion)
		{
			$this->descripcion = $descripcion;

			return $this;
		}

		public function getProveedor(): ?Proveedor
		{
			return $this->proveedor;
		}

		public function setProveedor($id,$nombre)
		{
			$this->proveedor = (new Proveedor())
								->setIdProveedor($id)
								->setNombreProveedor($nombre);

			return $this;
		}

		public function getCategoria(): ?Categoria
		{
			return $this->categoria;
		}

		public function setCategoria($id,$nombre)
		{
			$this->categoria = (new Categoria())
								->setId($id)
								->setNombre($nombre);

			return $this;
		}
	}
