<?php
	class DB
	{
		private $connection;
		private $server;
		private $username;
		private $password;
		private $database;
		
		public function __construct()
		{
			/*
			 * Start DB
			 */
			@$this->server = "";
			@$this->username = "";
			@$this->password = "";
			@$this->database = "";
			
			//Get connection details from file
			@$this->getConnectionDetailsFromFile();
			
			@$this->connection = new mysqli(@$this->server, @$this->username, @$this->password, @$this->database);
			
			if (mysqli_connect_errno()) throw new Exception(__METHOD__.'::'.mysqli_connect_error());
			else
			{
				if (!$this->connection->set_charset("utf8")) printf("Error loading character set utf8: %s\n", $this->connection->error);
				else $this->connection->character_set_name();
			}
		}
		
		/**
		 *Fetches details for database connection from file in root directory (databaseConnectionProperties.txt).
		 *
		 *The following details in clear text are read: IP address, username, password and databasename
		 *
		 *
		 * @throws Exception
		 */
		private function getConnectionDetailsFromFile()
		{
			$configFile = fopen($_SERVER["DOCUMENT_ROOT"]."/fuwo/databaseConnectionProperties.conf","r");
			
			try{
			
			while(!feof($configFile))
			{
				$line = fgets($configFile,1024);
				
				if($line{0}== "#"){
				} else if (substr($line,0,11) == "IP_Address="){
					@$this->server = (substr($line, 11,strlen($line)-12));
 				} else if (substr($line,0,9) == "password="){
					@$this->password = (substr($line, 9,strlen($line)-10));
				} else if (substr($line,0,9) == "username="){
		       		@$this->username = (substr($line, 9,strlen($line)-10));					
				} else if (substr($line,0,3) == "db="){
					@$this->database = (substr($line, 3,strlen($line)-3));
				}					
			}
			fclose($configFile);
			
			} catch (Exception $ex){
				throw new Exception($ex);
			}
		}
		
		/**
		 * 
		 * @param string $host		Server
		 * @param string $database	Datenbank name
		 * @param string $username	Username
		 * @param string $password	Password
		 * @throws Exception
		 */
		public function connect($host, $database, $username, $password)
		{
			if (!$this->connection)
			{			
				@$this->connection = new mysqli($host, $username, $password, $database);
				if (mysqli_connect_errno()) throw new Exception(__METHOD__.'::'.mysqli_connect_error());
			}
			else return false;
		}
		
		public function close()
		{
			if (!$this->connection) return false;
			$this->connection->close();
		}
		
		public function query($sql, $return='affected', $result_mode=MYSQLI_USE_RESULT)
		{
			if (!$this->connection) throw new Exception('Connection missing');
			$data = array();
			if ($result = $this->connection->query($sql, $result_mode)) 
			{
				if ($return=='affected'){ $data = $this->connection->affected_rows; }
				elseif ($return=='num'){ $data = $result->num_rows; }
				elseif ($return=='id'){ $data = $this->connection->insert_id; }
				elseif ($return=='assoc'){ while ($row = $result->fetch_assoc()) $data[] = $row; }
				elseif ($return=='numeric'){ while ($row = $result->fetch_array(MYSQLI_NUM))$data[] = $row; }
				elseif ($return=='fields'){ while ($row = $result->fetch_fields()) $data[] = $row; }
				if (is_object($result)) $result->close();
			}
			else
			{
				throw new Exception(__METHOD__.'::'.$this->connection->error.'::'.$sql);
			};
			return $data;
		}
		
		public function startTransaction($isolation_level="SERIALIZABLE")
		{
			if (!$this->connection) return false;
			$isolation_level = strtoupper($isolation_level);
			$ok = $this->query("SET TRANSACTION ISOLATION LEVEL {$isolation_level};", "bool");
			$ok = ($ok && $this->query("SET AUTOCOMMIT=0;", "bool"));
			return ($ok && $this->query("START TRANSACTION;", "bool"));
		}
		
		public function commit()
		{	
			if (!$this->connection) return false;
			if (!$this->query("COMMIT;", "bool")) return false;
			$this->query("SET AUTOCOMMIT=1;", "bool");
			return true;
		}
	  
		public function rollback()
		{
			if (!$this->connection) return false;
			if (!$this->query("ROLLBACK;", "bool")) return false;
			$this->query("SET AUTOCOMMIT=1;");
			return true;
		}
	}
?>