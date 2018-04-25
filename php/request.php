<?php
class action{	
	public static function login($email, $password){
		if($_SESSION['user']['id']){
			throw new Exception('You are logged in already.');
		}
		
		if(!$email || !$password){
			throw new Exception('Fill in all the required fields.');
		}
		
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			throw new Exception('Your email is invalid.');
		}
		
		$vault_pass = hash('sha256', DB::esc($password));
		$str = "SELECT * FROM clients WHERE email = '".DB::esc($email)."' AND password = '".$vault_pass."'";
		$result = DB::query($str);
	
		if($result->num_rows != 1){
			throw new Exception('Invalid email or password.');
		}
		
		$user = $result->fetch_assoc();
		
		$_SESSION['user'] = $user;
		
		$result->free();
		return $user;
	}

	public static function checkLogged(){
		if($_SESSION['user']['id']){
			return $_SESSION['user'];
		}else{
			return array('checkLogged' => false);
		}
	}

	public static function logout(){
		if($_SESSION['user']['id']){
			session_unset();
			session_destroy();
			return array('logout' => true);
		}else{
			throw new Exception('You are not logged in.');
		}
	}
	
	public static function register($email, $password){
		if(!$email || !$password){
			throw new Exception('Fill in all the required fields.');
		}
		
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			throw new Exception('Your email is invalid.');
		}
		
		$vault_pass = hash('sha256', DB::esc($password));
		$str = "INSERT INTO clients(email, password) VALUES ('".DB::esc($email)."', '".$vault_pass."')";
		DB::query($str);
		if(DB::getMySQLiObject()->affected_rows != 1){
			throw new Exception('This email is in use.');
		}
		
		return array('register' => true);
	}
	
	public static function clientDataUpdate($clientData){
		if(!$_SESSION['user']['id']){
			throw new Exception('Authorization required.');
		}
		
		$args = array(
			'name' => array(
				'filter' => FILTER_VALIDATE_REGEXP,
				'options' => array('regexp' => "/^[A-Za-z]{0,32}$/")
			),
			'surname' => array(
				'filter' => FILTER_VALIDATE_REGEXP,
				'options' => array('regexp' => "/^[A-Za-z]{0,32}$/")
			),
			'patronymic' => array(
				'filter' => FILTER_VALIDATE_REGEXP,
				'options' => array('regexp' => "/^[A-Za-z]{0,32}$/")
			),
			'birth_day' => array(
				'filter' => FILTER_VALIDATE_REGEXP,
				'options' => array('regexp' => "/^\d{4}-\d{2}-\d{2}$/")
			)
		);
		
		$data = filter_var_array($clientData, $args);
		
		$str = "UPDATE clients SET ";
		foreach($data as $k=>$v){
			if(!is_null($v) && $v != false){
				$str = $str.$k."='".$v."', ";
			}
		}
		$str = $str."last_activity=NOW() WHERE client_id=".$_SESSION['user']['id'];
		
		if(!DB::query($str)){
			throw new Exception('Database error: '.DB::getMySQLiObject()->error());
		}
		
		return array('updated' => true);
	}
}
?>