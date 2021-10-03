<?php
	require_once("model/Credentials.php");
	require_once("model/UserModel.php");
	
	if(json_decode(file_get_contents('php://input')) !== null){
		if(isset($_SERVER['PHP_AUTH_USER'])){
			$github = new UserModel();
			$login = new Credentials();

			$pass = $_SERVER['PHP_AUTH_PW'];
			$user = $_SERVER['PHP_AUTH_USER'];
			
			if($login->checkCredentials($user, $pass)) {
				
				$input_json = json_decode(file_get_contents('php://input'));
				
				header('Content-type:application/json;charset=utf-8');
				$query = $input_json->username;
				echo json_encode($github->getUsers($query));
				
			} else {
				header('HTTP/1.0 401 Unauthorized');
				error_log("Unauthorized Request", 0);
				exit;
			}
		}
		else {
			header('HTTP/1.0 401 Unauthorized');
			error_log("Unauthorized Request", 0);
			exit;
		}
	} else {
		header('HTTP/1.0 422 Unprocessable Entity');
		error_log("Unprocessable Entity", 0);
		exit;
	}
?>