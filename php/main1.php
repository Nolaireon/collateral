<?php
	$MySQLi = new mysqli("localhost", "test", "test", "test");
	$arr = array();
	
	/* проверка соединения */
	if ($MySQLi->connect_errno) {
		$arr = array(
			'status'	=>	0,
			'error'		=>	$MySQLi->connect_error
		);
		exit();
	}
	
	$MySQLi->set_charset("utf8");
	
	session_name("webtest");
	session_start();
	
	if ($_GET['action'] == 'login'){
		$username = $MySQLi->real_escape_string(htmlspecialchars($_POST['username']));
		$password = $MySQLi->real_escape_string(htmlspecialchars($_POST['password']));
		$query = "SELECT id, username FROM test_users WHERE username = '".$username."' AND password = '".$password."'";

		if ($result = $MySQLi->query($query)){
			if ($row = $result->fetch_assoc()){
				$arr = array(
					'status'	=>	1,
					'id'		=>	$row['id'],
					'name'		=>	$row['username']
				);
			}else{
				$arr = array(
					'status'	=>	0,
					'error'		=>	'Bad login/password'
				);
			}
			$result->free();
		}
		$_SESSION['user'] = array('id'=>$row['id'], 'name'=>$row['username'], 'logged'=>true);
	}
	
	if (($_GET['action'] == 'logout') && ($_SESSION['user']['logged'])){
		session_unset();
		session_destroy();
		$arr = array(
			'status'	=>	1,
			'message'	=>	'Session was destroyed'
		);
	}
	
	if ($_GET['action'] == 'checkLogged'){
		if ($_SESSION['user']['logged']){
			$arr = array(
				'status'	=>	1,
				'id'		=>	$_SESSION['user']['id'],
				'name'		=>	$_SESSION['user']['name']
			);
		}else{
			$arr = array('status'=>2, 'error'=>'You are not logged in');
		}
	}
	
	echo json_encode($arr);

	/* закрытие соединения */
	$MySQLi->close();
?>