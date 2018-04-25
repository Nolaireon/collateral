<?php

/* Database Configuration. */

$dbOptions = array(
	'db_host' => 'localhost',
	'db_user' => 'cb-test',
	'db_pass' => 'cb-test',
	'db_name' => 'cb-test'
);

/* Database Config End */

require "DB.class.php";
require "request.php";

session_name('collateral');
session_start();

try{
	
	DB::init($dbOptions);
	
	$response = array();
	
	switch($_GET['action']){
		
		case 'login':
			$response = action::login($_POST['email'], $_POST['password']);
		break;
		
		case 'checkLogged':
			$response = action::checkLogged();
		break;
		
		case 'logout':
			$response = action::logout();
		break;
		
		case 'register':
			$response = action::register($_POST['email'], $_POST['password']);
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