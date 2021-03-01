<?php

	require_once('config.php');
	class db{
		private $user; /*usuario de la bd*/
		private $pass; /*password de la bd*/
		private $conn; /*variable para almacenar la Coneccion*/
		private $nameDB; /*nombre de la bd*/
		private $host; /*Host de la bd*/

		public function __construct(){
			
			$this->user = DBUSER;
			$this->pass = DBPASS;
			$this->nameBD = DBNAME;
			$this->host = DBHOST;
			
			$this->ConnectBD();	
		}
		/*Conecta a la BD*/
		private function ConnectBD(){
			try{
				$this->conn = new PDO("sqlsrv:server=".$this->host.";Database=".$this->nameBD, $this->user,$this->pass);
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->conn->exec("SET NAMES 'utf8';");
				echo 'conexion exitosa';

			}catch(PDOException $e){
				"Error: ".$e->getMessage();
				
			}
		}
		/*Hace la consulta sql*/
		public function hacerConsulta($sql){
			try{
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				/*Convierto a JSON*/
				$result = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
				return $result;

			}catch(PDOException $e){
				echo "Error: ". $e->getMessage();
			}

	   }
       /*Hace insert sql*/
        public function hacerInsert($sql){
			try{
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				//sacar
				$result =  $this->conn->lastInsertId();
				
				return $result;

			}catch(PDOException $e){
				echo "Error: ". $e->getMessage();
			}

	   }
        /*Hace update/delete sql*/
        public function hacerCambio($sql){
			try{
				$stmt = $this->conn->prepare($sql);
				return $stmt->execute();

			}catch(PDOException $e){
				echo "Error: ". $e->getMessage();
			}

	   }

	   /*Hace la consulta sql*/
		public function hacerConsultaregistros($sql){
			try{
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();

				$result = $stmt->fetchAll(PDO::FETCH_CLASS);
				
				return $result;

			}catch(PDOException $e){
				echo "Error: ". $e->getMessage();
			}
		}
}
?>
