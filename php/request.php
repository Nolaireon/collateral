<?php

class action{
	
	public static function login(){
		if(isset($_SESSION['user']['client_id'])){
			throw new Exception('You have already logged in.', 1);
		}
		
		if(!isset($_POST['email'], $_POST['password'])){
			throw new Exception('Fill in all the required fields.', 1);
		}
		
		$client = new Client();
		
		$client->select();
		
		return array('result' => $_SESSION['user']);
	}

	public static function checkLogged(){	
		if(!isset($_SESSION['user']['client_id'])){
			throw new Exception('You have not logged in.', 1);
		}
		
		return array('result' => $_SESSION['user']);
	}

	public static function logout(){
		if(!isset($_SESSION['user']['client_id'])){
			throw new Exception('Authorization required.', 1);
		}
		
		session_unset();
		session_destroy();
		
		return array('msg' => 'You have logged out.');
	}
	
	public static function register(){
		if(!isset($_POST['firstname'], $_POST['email'], $_POST['password'])){
			throw new Exception('Fill in all the required fields.', 1);
		}
		
		$client = new Client();
		
		$client->add();
		
		return array('msg' => 'Account has been created.');
	}
	
	public static function clientDataUpdate(){
		if(!isset($_SESSION['user']['client_id'])){
			throw new Exception('Authorization required.', 1);
		}
		
		$client = new Client();
		
		$client->update();
		
		return array('msg' => 'Data was updated.');
	}
	
	public static function companyDataAdd(){
		if(!isset($_SESSION['user']['client_id'])){
			throw new Exception('Authorization required.', 1);
		}
		
		if($_SESSION['user']['company_id'] != 0){
			throw new Exception('You can create only one company per account', 1);
		}
		
		if(!isset($_POST['name'], $_POST['owner'])){
			throw new Exception('Fill in all the required fields.', 1);
		}
		
		$company = new Company();
		
		$company->add();
		
		return array('msg' => 'Company has been created.');
	}
	
	public static function companyDataUpdate(){
		if(!isset($_SESSION['user']['client_id'])){
			throw new Exception('Authorization required.', 1);
		}
		
		if($_SESSION['user']['company_id'] == 0){
			throw new Exception('You have no company to update it.', 1);
		}
		
		if(!isset($_POST['name']) && !isset($_POST['owner'])){
			throw new Exception('Fill in all the required fields.', 1);
		}
		
		$company = new Company();
		
		$company->update();
		
		return array('msg' => 'Company has been updated.');
	}

}

?>