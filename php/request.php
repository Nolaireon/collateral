<?php
class action{	
	public static function login($email, $password){
		if($_SESSION['user']['email']){
			throw new Exception('You are logged in already.');
		}
		
		if(!$email || !$password){
			throw new Exception('Fill in all the required fields.');
		}
		
		if(!filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL)){
			throw new Exception('Your email is invalid.');
		}
		
		$vault_pass = hash('sha256', DB::esc($password));
		$str = "SELECT * FROM clients WHERE email = '".DB::esc($email)."' AND password = '".$vault_pass."'";
		$result = DB::query($str);
	
		if ($result->num_rows != 1){
			throw new Exception('Invalid email or password.');
		}
		
		$user = $result->fetch_assoc();
		
		$_SESSION['user'] = $user;
		
		$result->free();
		return $_SESSION['user'];
	}

	public static function checkLogged(){
		if ($_SESSION['user']['email']){
			return $_SESSION['user'];
		} else {
			return array('checkLogged' => false);
		}
	}

	public static function logout(){
		if ($_SESSION['user']['email']){
			session_unset();
			session_destroy();
			return array('logout' => true);
		} else {
			throw new Exception('You are not logged in.');
		}
	}
	
	public static function register($email, $password){
		if (!$email || !$password){
			throw new Exception('Fill in all the required fields.');
		}
		
		if(!filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL)){
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
}
?>