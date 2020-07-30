<?php
	namespace Wave\Connection;

	use Wave\Connection\TypeDB;
		
	class DBInfoConnection{
		private $type_db	= TypeDB::MYSQL;
		private $host		= "";
		private $username	= "";
		private $passwd		= "";
		private $dbname		= "";
		private $port		= 3306;
		function __construct(
			string $type_db,
			string $host = "",
			string $username = "",
			string $passwd = "",
			string $dbname = "",
			int $port = 0
		)
		{
			$this->type_db 	= $type_db;
			$this->host 	= $host;
			$this->username = $username;
			$this->passwd 	= $passwd;
			$this->dbname 	= $dbname;
			$this->port 	= $this->validPort($port,$type_db);
		}
		public function getTypeDB(): ?string{
			return $this->type_db;
		}
		public function getHost(): string{
			return $this->host;
		}
		public function getUsername(): string{
			return $this->username;
		}
		public function getPassword(): string{
			return $this->passwd;
		}
		public function getDBName(): string{
			return $this->dbname;
		}
		public function getPort(): int{
			return $this->port;
		}



		public function setTypeDB(string $value): void{
			if(isset($value)){
				$this->type_db = $value;
			}
		}
		public function setHost(string $value): void{
			if(isset($value)){
				$this->host = $value;
			}
		}
		public function setUsername(string $value): void{
			if(isset($value)){
				$this->username = $value;
			}
		}
		public function setPassword(string $value): void{
			if(isset($value)){
				$this->passwd = $value;
			}
		}
		public function setDBName(string $value): void{
			if(isset($value)){
				$this->dbname = $value;
			}
		}
		public function setPort(int $value): void{
			if(isset($value)){
				$this->port = $value;
			}
		}


		private function validPort($port,$type_db){
			if($port==0 && TypeDB::MYSQL==$type_db){
				return 3306;
			}else if($port==0 && TypeDB::POSTGRESQL==$type_db){
				return 5432;
			}
			return $port;
		}
	}