<?php
	namespace Wave\util;
	
	use Wave\Connection\TypeDB;
	use Wave\Connection\DBInfoConnection;
	use Wave\Connection\event\ConnectionDatabaseEvent;

	class AppSettings{
		private $SERVER				= 'localhost';
		private $TIMEZONE 			= 'America/El_Salvador';
		private $PATH_SOURCE		= '';
		private $PATH_SOURCE_DEV	= '';
		private $DEV_MODE			= true;
		private $USE_DB				= false;
		private $DB_INFO_CONNECTION;
		private $eventDBConnection;
		private $deafaultLang;
		private $language;
		private $appLangs;

		function __construct(){
			$this->setDBInfoConnection(new DBInfoConnection(TypeDB::MYSQL));
		}

		public function getDefaultLanguage(){
			return $this->deafaultLang;
		}

		public function getAppLangs(){
			return $this->appLangs;
		}

		public function setDefaultLanguage($lang){
			$this->deafaultLang = $lang;
			return $this;
		}

		public function setAppLangs($langs){
			$this->appLangs = $langs;
			return $this;
		}

		public function setLanguage($lang){
			$this->language = $lang;
			return $this;
		}

		public function getLanguage(){
			return $this->language;
		}

		public function isLanguage($lang){
			return isset($appLangs[$lang]);
		}

		public function setServer(string $value){
			if(isset($value)){
				$this->SERVER = $value;
			}
			return $this;
		}
		public function getServer(): ?string{
			return $this->SERVER;
		}

		public function setTimeZone(string $value){
			if(isset($value)){
				$this->TIMEZONE = $value;
			}
			return $this;
		}
		public function getTimeZone(): ?string{
			return $this->TIMEZONE;
		}


		public function setPathSource(string $value){
			if(isset($value)){
				$this->PATH_SOURCE = $value;
			}
			return $this;
		}
		public function getPathSource(): ?string{
			return $this->PATH_SOURCE;
		}


		public function setPathSourceDev(string $value){
			if(isset($value)){
				$this->PATH_SOURCE_DEV = $value;
			}
			return $this;
		}
		public function getPathSourceDev(): ?string{
			return $this->PATH_SOURCE_DEV;
		}

		public function setDevMode(bool $value){
			if(isset($value)){
				$this->DEV_MODE = $value;
			}
			return $this;
		}

		public function getDevMode(): bool{
			return $this->DEV_MODE;
		}

		public function setUseDB(bool $value){
			$this->USE_DB = $value;
			return $this;
		}	

		public function getUseDB(): bool{
			return $this->USE_DB;
		}

		public function setDBInfoConnection(DBInfoConnection $value){
			if(isset($value)){
				$this->DB_INFO_CONNECTION = $value;
			}
			return $this;
		}

		public function setEventDBConnection(ConnectionDatabaseEvent $value){
			$this->eventDBConnection = $value;
			return $this;
		}

		public function geetEventDBConnection(): ?ConnectionDatabaseEvent{
			return $this->eventDBConnection;
		}

		public function getDBInfoConnection(): ?DBInfoConnection{
			return $this->DB_INFO_CONNECTION;
		}
	}