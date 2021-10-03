<?php
	class sqlConnect {
		public $dbServername = "localhost";
		public $dbUsername = "root";
		public $dbPassword = "uKGemV5UddIYkBKs";
		public $dbName = "kumu_test";

		public function __construct() {
			$conn = new mysqli($this->dbServername, $this->dbUsername, $this->dbPassword);
			if ($conn->connect_error) {
			  die("Connection failed: " . $conn->connect_error);
			} else {
				$this->pdo = new PDO("mysql:host=" . $this->dbServername . ";dbname=". $this->dbName, $this->dbUsername, $this->dbPassword);
			}
		}
	}
?>