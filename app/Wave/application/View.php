<?php

	/**
	 * @autor Leonel Henriquez
	 * View class
	 */
	namespace Wave\application;

	use \Exception;

	class View
	{
		private $url;
		private $file;
		private $useFile = true;
		private $content;
		private $titulo = "";
		private $useHeaders = true;
		private $ajaxRequest = false;
		private $isViewError = false;

		
		function __construct()
		{
		}
		
		public function setContent($content){
			if(is_callable($content)){
				$this->setUseFile(false);
				$this->content = $content;
			}else{
				$this->file = $content;
				$this->setUseFile(true);
			}
			return $this;
		}

		public function getContent()
		{
			return $this->content;
		}

		public function getUrl()
		{
			return $this->url;
		}

		public function setUrl($url)
		{
			$this->url = $url;

			return $this;
		}

		public function getFile()
		{
			return $this->file;
		}

		public function setFile($file)
		{
			if(file_exists($file)){
				$this->file = $file;
			}else{
				throw new Exception("Error el archivo no existe", 1);
			}
			return $this;
		}

		public function isUseFile()
		{
			return $this->useFile;
		}

		public function setUseFile($useFile)
		{
			$this->useFile = $useFile;

			return $this;
		}

		/*public function getContent()
		{
			return $this->content;
		}

		public function setContent($content)
		{
			$this->content = $content;

			return $this;
		}*/

		public function getTitulo()
		{
			return $this->titulo;
		}

		public function setTitulo($titulo)
		{
			$this->titulo = $titulo;

			return $this;
		}

		public function isUseHeaders()
		{
			return $this->useHeaders;
		}

		public function setUseHeaders($useHeaders)
		{
			$this->useHeaders = $useHeaders;

			return $this;
		}

		public function isAjaxRequest()
		{
			return $this->ajaxRequest;
		}

		public function setAjaxRequest($ajaxRequest)
		{
			$this->ajaxRequest = $ajaxRequest;

			return $this;
		}


		public function isViewError()
		{
			return $this->isViewError;
		}

		public function setIsViewError($isViewError)
		{
			$this->isViewError = $isViewError;

			return $this;
		}
}

?>