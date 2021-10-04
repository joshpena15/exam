<?php
	require_once("model/Credentials.php");
	require_once("model/UserModel.php");
	
	if(json_decode(file_get_contents('php://input')) !== null){
		$redis = new Redis();
		$redis->connect('127.0.0.1', 6379);
		$redis->auth('P@ssw0rd123');

		if(isset($_SERVER['PHP_AUTH_USER'])){
			$github = new UserModel();
			$login = new Credentials();
			$response = array();

			$pass = $_SERVER['PHP_AUTH_PW'];
			$user = $_SERVER['PHP_AUTH_USER'];
			
			if($login->checkCredentials($user, $pass)) {
				
				$input_json = json_decode(file_get_contents('php://input'), true);
				
				if(count($input_json) <= 10){
					foreach($input_json as $key => $value) {
						$query = $value["username"];
						
						if(!$redis->hExists($query, 'name')){
							$github_response = json_decode($github->getUsers($query), true);
							if(!isset($github_response["message"])){
								$avg_followers = round($github_response["followers"] / max($github_response["public_repos"], 1));
								
								$redis->hset($query, 'name', $github_response["name"]);
								$redis->hset($query, 'login', $github_response["login"]);
								$redis->hset($query, 'company',  $github_response["company"]);
								$redis->hset($query, 'followers', $github_response["followers"]);
								$redis->hset($query, 'public_repos', $github_response["public_repos"]);
								$redis->hset($query, 'avg_followers', $avg_followers);
								$redis->expire($query, 120);

								$build = array(
												"name" => $github_response["name"],
												"login" => $github_response["login"],
												"company" => $github_response["company"],
												"followers" =>  $github_response["followers"],
												"public_repos" =>  $github_response["public_repos"],
												"avg_followers" => $avg_followers

								);

								array_push($response, $build);
							} else {
								error_log($query . " is Not Found", 0);
							}
						} else {
							// $redis->hget($query, 'name');
							// $redis->hget($query, 'login');
							// $redis->hget($query, 'company');
							// $redis->hget($query, 'followers');
							// $redis->hget($query, 'public_repos');
							// $redis->hget($query, 'avg_followers');

							$build = array(
								"name" => $redis->hget($query, 'name'),
								"login" => $redis->hget($query, 'login'),
								"company" => $redis->hget($query, 'company'),
								"followers" =>  $redis->hget($query, 'followers'),
								"public_repos" =>  $redis->hget($query, 'public_repos'),
								"avg_followers" => $redis->hget($query, 'avg_followers')
							);

							array_push($response, $build);
						}
					}

					header('Content-type:application/json;charset=utf-8');
					echo json_encode($response);

				} else {
					header('HTTP/1.0 422 Maximum Queries Reached');
					error_log("Maximum Queries Reached", 0);
					exit;
				}
				
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