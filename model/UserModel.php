<?php
	require_once("connection/api_links.php");
	
	class UserModel {
		public $name;
		public $login;
		public $company;
		public $count_followers;
		public $count_repos;
		public $avg_follow;
		
		public function __construct() {
		
		}
		
		function getUsers($query){
			$api = new githubLink();
			
			try {
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $api->user . "/$query");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, [
					'Accept: application/vnd.github.v3+json',
					'User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/50.0.125 Chrome/44.0.2403.125 Safari/537.36'
				]);
				
				// TEMPORARY!
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				/////////////
				
				$response  = curl_exec($ch);
				
				if($response == false){
					error_log(curl_error($ch), 0);
				}
				
				curl_close($ch);
				
				return json_decode($response);
			
			} catch (PDOException $e) {
				error_log($e->getMessage(), 0);
			}
		}
	}
	
?>