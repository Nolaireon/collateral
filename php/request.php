<?php
class action{	
	public static function login($name, $password){
		$sha256 = hash('sha256', DB::esc($password));
		$str = "SELECT id, username FROM test_users WHERE username = '".DB::esc($name)."' AND password = '".$sha256."'";
		$result = DB::query($str);
		$arr = array();
	
		if ($user = $result->fetch_assoc()){
			$avatar = "./images/png/".strtoupper(substr($user['username'], 0, 1)).".png";
			$arr = array(
				'status'	=>	1,
				'name'		=>	$user['username'],
				'avatar'	=>	$avatar
			);
			$_SESSION['user'] = array('name'=>$user['username'], 'avatar'=>$avatar);
		} else {
			$arr = array(
				'status'	=>	0,
				'error'		=>	'Bad login/password'
			);
		}
		
		$result->free();
		return $arr;
	}

	public static function checkLogged(){
		if ($_SESSION['user']['name']){
			return array(
				'status'	=>	1,
				'avatar'	=>	$_SESSION['user']['avatar'],
				'name'		=>	$_SESSION['user']['name']
			);
		} else {
			return array(
				'status'	=>	2,
				'message'	=>	'You are not logged in'
			);
		}
	}

	public static function logout(){
		if ($_SESSION['user']['name']){
			session_unset();
			session_destroy();
			return array('status'=>1);
		} else {
			return false;
		}
	}
	
	public static function register($name, $password, $rPassword, $mail){
		if (!$name || !$mail || !$password){
			//throw new Exception('Fill in all the required fields.');
			//return "Fill in all the required fields.";
			$str1 = "INSERT INTO logs(status, error) VALUES ('".DB::esc(0)."', '".DB::esc("Fill in all inputs.")."')";
			DB::query($str1);
			return array(
				'status'	=>	0,
				'error'	=>	'Fill in all the required fields.'
			);
		}
		
		if (!filter_var($mail, FILTER_VALIDATE_EMAIL) === false){
		}else{
			//throw new Exception('Your email is invalid.');
			//return "Your email is invalid";
			$str1 = "INSERT INTO logs(status, error) VALUES ('".DB::esc(0)."', '".DB::esc("Your email is invalid.")."')";
			DB::query($str1);
			return array(
				'status'	=>	0,
				'error'	=>	'Your email is invalid.'
			);
		}
		
		$str = "SELECT username FROM test_users WHERE username = '".DB::esc($name)."'";
		if (DB::query($str)->num_rows > 0){
			//throw new Exception('This username is in use.');
			//return "This username is already exist.";
			$str1 = "INSERT INTO logs(status, error) VALUES ('".DB::esc(0)."', '".DB::esc("This username is already exist.")."')";
			DB::query($str1);
			return array(
				'status'	=>	0,
				'error'	=>	'This username is already exist.'
			);
		}
		
		if ($password == $rPassword){
			$sha256 = hash('sha256', DB::esc($password));
			$str = "INSERT INTO test_users(username, password, mail) VALUES ('".DB::esc($name)."', '".$sha256."', '".DB::esc($mail)."')";
			$str1 = "INSERT INTO logs(status, name) VALUES ('".DB::esc(3)."', '".DB::esc($name)."')";
			DB::query($str);
			DB::query($str1);
			//return "Account has been created.";
			return array(
				'status'	=>	3,
				'message'	=>	'Account has been created.'
			);
		}else{
			//return "Password doesn't match.";
			$str1 = "INSERT INTO logs(status, error) VALUES ('".DB::esc(0)."', '".DB::esc("Password doesn't match.")."')";
			DB::query($str1);
			return array(
				'status'	=>	0,
				'error'	=>	"Password doesn't match."
			);
		}
	}
}
?>