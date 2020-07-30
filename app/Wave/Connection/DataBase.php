<?php
	/*
	 * Clase para conectarte a la base de datos
	 * Version: 1.0
	 *
	 * @author Leonel Henriquez
	 */
	/*
	 * Referencia informativa
	 * MySql: 		http://php.net/manual/es/mysqli.connect-error.php
	 * PostgreSql: 	http://php.net/manual/es/function.pg-last-error.php#99626
	 */
	namespace Wave\Connection;
	use \mysqli;
	use Wave\Connection\DBInfoConnection;
	use Wave\Connection\event\ConnectionDatabaseEvent;

	class DataBase{

		private $is_connected = false;
		private $db_info;
		private $connection;

		public function __construct(
			DBInfoConnection $db_info,
			ConnectionDatabaseEvent $event
		){
			$this->db_info = $db_info;

			if($this->db_info->getTypeDB()==TypeDB::MYSQL){
				$this->connection = @new mysqli(
					$this->db_info->getHost(),
					$this->db_info->getUsername(),
					$this->db_info->getPassword(),
					$this->db_info->getDBName(),
					$this->db_info->getPort()
				);

				if($this->connection->connect_error){
					$this->is_connected = false;
					$event->OnErrorConnection();
				}else{
					$this->is_connected = true;
				}
			}else if($this->db_info->getTypeDB()==TypeDB::POSTGRESQL){
				$this->connection = @pg_connect("host=".$this->db_info->getHost()." port=".$this->db_info->getPort()." dbname=".$this->db_info->getDBName()." user=".$this->db_info->getUsername()." password=".$this->db_info->getPassword());
				if($this->connection === FALSE)
					$this->is_connected = false;
					$event->OnErrorConnection();
				}else{
					$this->is_connected = true;
			}
		}

		public function getConnect(){
			return $this->connection;
		}

		public function close_db(){
			$this->Close();
		}

		public function Close(){
			if($this->is_connected){
				if ($this->db_info->getTypeDB()==TypeDB::MYSQL) {
					$this->connection->close();
				}elseif ($this->db_info->getTypeDB()==TypeDB::POSTGRESQL) {
					pg_close($this->connection);
				}
			}
		}

		public function Query(string $sql = ''){
			if($this->is_connected){
				if ($this->db_info->getTypeDB()==TypeDB::MYSQL) {
					return $this->connection->query($sql);
				}elseif ($this->db_info->getTypeDB()==TypeDB::POSTGRESQL) {
					return pg_query($this->connection,$sql);
				}
			}
			return null;
		}

		public function FetchArray($Query,int $result_type = -1){
			if ($this->db_info->getTypeDB()==TypeDB::MYSQL) {
				$result_type = ($result_type==-1) ? MYSQLI_ASSOC : $result_type;
				return $Query->fetch_array(MYSQLI_ASSOC);
			}elseif ($this->db_info->getTypeDB()==TypeDB::POSTGRESQL) {
				$result_type = ($result_type==-1) ? PGSQL_ASSOC : $result_type;
				return pg_fetch_array($Query,NULL,PGSQL_ASSOC);
			}
			return null;
		}

		public function free($result){
			if ($this->db_info->getTypeDB()==TypeDB::MYSQL) {
				return $result->free();
			}elseif ($this->db_info->getTypeDB()==TypeDB::POSTGRESQL) {
				return pg_free_result($result);
			}
		}

		private function ErrorMessage(){
			$this->cancel_proceso_cdb = true;
			$this->status_connection = false;
			exit('ERROR_CONNECT');
			return "ERROR_CONNECT";
		}

		private function CountTableSQL($sql){
			$count = 0;
			$query = $this->Query($sql);
			if($query && $query->num_rows>0){
				$datos = $this->FetchArray($query);
				$count = (int)$datos['n'];
			}
			return $count;
		}
		
		public function CountTable($from, $where){
			return $this->CountTableSQL("SELECT count(*) AS n FROM ".$from." WHERE ".$where);
		}
	}