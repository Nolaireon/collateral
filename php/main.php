<?php

/* Database Configuration. */

$dbOptions = array(
	'db_host' => 'localhost',
	'db_user' => 'test',
	'db_pass' => 'test',
	'db_name' => 'test'
);

/* Database Config End */

require "DB.class.php";
require "request.php";

session_name('webtest');
session_start();

try{
	
	DB::init($dbOptions);
	
	$response = array();
	
	switch($_GET['action']){
		
		case 'login':
			$response = action::login($_POST['username'], $_POST['password']);
		break;
		
		case 'checkLogged':
			$response = action::checkLogged();
		break;
		
		case 'logout':
			$response = action::logout();
		break;
		
		case 'register':
			$response = action::register($_POST['username'], $_POST['password'], $_POST['rPassword'], $_POST['mail']);
		break;
		
		default:
			throw new Exception('Wrong action');
	}
	
	echo json_encode($response);
}

catch(Exception $e){
	die(json_encode(array('error' => $e->getMessage())));
}
?>