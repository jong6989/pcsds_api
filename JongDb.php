<?php 

/*
	Created : december 20, 2018
	By : Tiburcio Baguio Bautista III
	From : Puerto Princesa Palawan, Philippines
	Title : JongDb Model Class
	Description : A model Class for shorthand mySQL database access. 
*/
require_once("settings.php");

if(!class_exists("JongDb")){
	
	function _z($d){
		$a = array();
		foreach ($d as $key => $value) {
			if(is_string($key)) return new _($d);
			if(is_array($value)){
				$a[$key] = new _($value);
			}else {
				$a[$key] = $value;
			}
		}
		return $a;
	}
	Class _{
		public function __construct($d){
			if(is_array($d)){
				foreach ($d as $key => $value) {
					if(is_array($value)){
						$this->{$key} = _z($value);
					}else {
						$this->{$key} = $value;
					}
				}
			}
		}
	}

	Class JongDb {
		private $dbHost = "";
		private $dbUser = "";
		private $dbPass = "";
		//
		public $dbConnection = null;
		private $dbName = "";
		private $tblName = "";
		private $jsonKey = "data";

		public function __construct($dbName,$tblName,$tableColumns=""){
			$this->dbHost = settings::$dbHost;
			$this->dbUser = settings::$dbUser;
			$this->dbPass = settings::$dbPass;
			$this->createDb($dbName);
			$this->dbName = $dbName;
			$this->tblName = $tblName;
			if(!$this->isTableExist($tblName)) 
				$this->createTable($tblName,$tableColumns);
		}
		
		public function connect(){
			$this->dbConnection = new mysqli($this->dbHost, $this->dbUser, $this->dbPass, $this->dbName);
			if ($this->dbConnection->connect_error) {
			    die("Connection failed: " . $this->dbConnection->connect_error);
			} 
		}

		public function close(){
			if($this->dbConnection !== null) $this->dbConnection->close();
		}

		public function createDb($db){
			$conn = new mysqli($this->dbHost, $this->dbUser, $this->dbPass);
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 
			$sql = "CREATE DATABASE $db";
			$conn->query($sql);
			$conn->close();
		}

		private function isTableExist($tbl){
			$this->connect();
			$sql = "SHOW TABLES LIKE '$tbl'";
			$result = $this->dbConnection->query($sql);
			$this->close();
			return ($result->num_rows > 0) ? true : false;
		}

		public function createTable($tableName,$tableColumns){
			$this->connect();
			$sql = "CREATE TABLE $tableName (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY, $tableColumns )";
			if($this->dbConnection->query($sql) === TRUE) {return 1;} else {return $this->dbConnection->error;}
			$this->close();
		}

		public function query($sql){
			$this->connect();
			$result = $this->dbConnection->query($sql);
			$result = ($result === false ) ? $this->dbConnection->error : $result;

			if(isset($result->num_rows)){
				if ($result->num_rows > 0) {
					$j = [];
				    while($row = $result->fetch_assoc()) {
				    	foreach ($row as $key => $value) {
							// if($key==$this->jsonKey) $row[$this->jsonKey] = json_decode($row[$this->jsonKey]);
							if($key===$this->jsonKey){
								$n = strlen($value);
								$e = str_split($value,1);
								$xv = ( $e[0] == '"' )? substr($value, 1, $n - 2) : $value;
								
								try {
									$dx = json_decode($xv);
									// echo var_dump($dx);
								}catch (Exception $e){
									echo $e->getMessage();
								}
								$row[$key] = $dx;
							} 
				    	}
				    	$j[] = new _($row);
				    }
				    $result = $j;
				}else {
					$result = array();
				}
			}

			$this->close();
			return $result;
		}

		public function create($data_array){
			$key_string = "";
			$value_string = "";

			foreach ($data_array as $key => $value) {
				if($key_string!=="")$key_string .= ",";
				if($value_string!=="")$value_string .= ",";
				$key_string .= $key;
				if($key===$this->jsonKey) $value = json_encode($value);
				$value_string .= "'" . $value . "'";
			}

			$sql = "INSERT INTO $this->tblName ($key_string) VALUES ($value_string)";
	        return $this->query($sql);
		}

		public function search($where_array=null,$select_string=null,$order="DESC",$order_by="id", $limit=500, $offset=0){
			$select = ($select_string === null) ? "*" : $select_string;
			if($where_array!==null){
				$where_string = "";

				foreach ($where_array as $key => $value) {
					if($where_string!=="")$where_string .= " AND ";
					if($key===$this->jsonKey){
						$value = json_encode($value);
					} 
					$where_string .= $key . " LIKE '" . $value . "'";
				}
				$sql = "SELECT $select FROM $this->tblName WHERE $where_string ORDER BY $order_by $order LIMIT $limit OFFSET $offset";
	    		return $this->query($sql);
			}
			return null;
		}

		public function get($where_array=null,$select_string=null,$order="DESC",$order_by="id", $limit=20000, $offset=0){
			$select = ($select_string === null) ? "*" : $select_string;
			if($where_array===null){
				$sql = "SELECT $select FROM $this->tblName ORDER BY $order_by $order LIMIT $limit OFFSET $offset";
	    		return $this->query($sql);
			}else if($where_array!==null){
				$where_string = "";
				foreach ($where_array as $key => $value) {
					if($where_string!=="")$where_string .= " AND ";
					$where_string .= $key . "= '" . $value . "'";
				}
				$sql = "SELECT $select FROM $this->tblName WHERE $where_string ORDER BY $order_by $order LIMIT $limit OFFSET $offset";
	    		return $this->query($sql);
			}
			return null;
		}

		public function update($data_array, $where_array){
			$set_string = "";
			$where_string = "";

			foreach ($data_array as $key => $value) {
				if($set_string!=="")$set_string .= ",";
				if($key===$this->jsonKey) $value = json_encode($value);
				$set_string .= $key . " = '" . $value . "'";
			}
			foreach ($where_array as $key => $value) {
				if($where_string!=="")$where_string .= " AND ";
				if($key===$this->jsonKey) $value = json_encode($value);
				$where_string .= "$this->tblName .`" . $key . "` = '" . $value . "'";
			}

			$sql = "UPDATE $this->tblName SET $set_string WHERE $where_string ";

	 		return $this->query($sql);
		}

		public function delete($where_array){
			$where_string = "";

			foreach ($where_array as $key => $value) {
				if($where_string!=="")$where_string .= " AND ";
				$where_string .= "$this->tblName .`" . $key . "` = '" . $value . "'";
			}

			$sql = "DELETE FROM $this->tblName WHERE $where_string ";

	 		return $this->query($sql);
		}

		public function exist($where_array,$selector="*"){
			$where_string = "";

			foreach ($where_array as $key => $value) {
				if($where_string!=="")$where_string .= " AND ";
				if($key===$this->jsonKey) $value = json_encode($value);
				$where_string .= $key . " = '" . $value . "'";
			}

			$sql = "SELECT $selector FROM $this->tblName WHERE $where_string ";
			$this->connect();
			$result = $this->dbConnection->query($sql);
			$r = false;
			if(isset($result->num_rows)) $r = ($result->num_rows > 0) ? true : false;

			$this->close();
			return $r;
		}

		public function count($where_array=null,$selector="id"){
			$sql = "";
			if($where_array===null){
				$sql = "SELECT count({$selector}) as res FROM $this->tblName";
			}else if($where_array!==null){
				$where_string = "";
				foreach ($where_array as $key => $value) {
					if($where_string!=="")$where_string .= " AND ";
					if($key===$this->jsonKey) $value = json_encode($value);
					$where_string .= $key . "= '" . $value . "'";
				}
				$sql = "SELECT count({$selector}) as res FROM $this->tblName WHERE $where_string";
			}
			$r = $this->query($sql);
			return (count($r) > 0) ? $r[0]->res : 0;
		}

		public function sum($item,$where_array=null){
			$sql = "";
			if($where_array===null){
				$sql = "SELECT sum({$item}) as res FROM $this->tblName";
			}else if($where_array!==null){
				$where_string = "";
				foreach ($where_array as $key => $value) {
					if($where_string!=="")$where_string .= " AND ";
					if($key===$this->jsonKey) $value = json_encode($value);
					$where_string .= $key . "= '" . $value . "'";
				}
				$sql = "SELECT sum({$item}) as res FROM $this->tblName WHERE $where_string";
			}
			$r = $this->query($sql);
			return (count($r) > 0) ? $r[0]->res : 0;
		}

		public function last($selector="id"){
			$sql = "SELECT $selector FROM $this->tblName ORDER BY `{$selector}` DESC LIMIT 1 ";
			$r = $this->query($sql);
			return (count($r) > 0) ? $r[0]->{$selector} : null;
		}

	}
}

 ?>

