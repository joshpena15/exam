<?php
	require_once("connection/connection.php");
	
	class Credentials {
		private $salt = "QK98z3BJdF";
		public $response;
		
		public function __construct() {
			
		}
		
		function register($user, $pass){
			$conn = new sqlConnect();
			$hashedpass = hash("sha512", $this->salt .  $pass);
			
			try {
				$sql = "CALL register(:user, :pass)";
				$stmt = $conn->pdo->prepare($sql);
				$stmt->bindParam(':user', $user, PDO::PARAM_STR);
				$stmt->bindParam(':pass', $hashedpass, PDO::PARAM_STR);
				$stmt->execute();
				
				if($stmt){
					$this->response = true;
				} else {
					$this->response = false;
					error_log("Statement Error", 0);
				}
				
				$errorInfo = $stmt->errorInfo();
				if (isset($errorInfo[2])) {
					$this->response = false;
					error_log($errorInfo[2], 0);
				}
				
				$stmt->closeCursor();
				
			} catch (PDOException $e) {
				$this->response = false;
				error_log($e->getMessage(), 0);
			}
			
			return $this->response;
		}
		
		function checkCredentials($user, $pass) {
			$conn = new sqlConnect();
			$hashedpass = hash("sha512", $this->salt .  $pass);
			
			try {
				$sql = "CALL login(:user, :pass)";
				$stmt = $conn->pdo->prepare($sql);
				$stmt->bindParam(':user', $user, PDO::PARAM_STR);
				$stmt->bindParam(':pass', $hashedpass, PDO::PARAM_STR);
				$stmt->execute();
				
				if($stmt){
					$this->response = true;
				} else {
					$this->response = false;
					error_log("Statement Error", 0);
				}
				
				$errorInfo = $stmt->errorInfo();
				if (isset($errorInfo[2])) {
					$this->response = false;
					error_log($errorInfo[2], 0);
				}
				
				$stmt->closeCursor();
				
			} catch (PDOException $e) {
				$this->response = false;
				error_log($e->getMessage(), 0);
			}
			
			return $this->response;
		}
	}
	
?>