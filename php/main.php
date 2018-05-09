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
require "Base.php";
require "Client.php";
require "Company.php";
require "CustomException.php";

session_name('collateral');
session_start();

try{
	
	DB::init($dbOptions);
	
	$response = array();
	
	if(!isset($_GET['action'])){
		throw new Exception('action not specified');
	}
	
	switch($_GET['action']){
		
		case 'login':
			$response = action::login();
		break;
		
		case 'register':
			$response = action::register();
		break;
		
		case 'clientDataUpdate':
			$response = action::clientDataUpdate();
		break;
		
		case 'companyDataAdd':
			$response = action::companyDataAdd();
		break;
		
		case 'companyDataUpdate':
			$response = action::companyDataUpdate();
		break;
		
		case 'checkLogged':
			$response = action::checkLogged();
		break;
		
		case 'logout':
			$response = action::logout();
		break;
		
		default:
			throw new Exception('Wrong action');
	}
	
	echo json_encode(array('rc' => 0) + $response);
	
}catch(CustomException $e){
	die(json_encode(array('rc' => $e->getCode(), 'errors' => $e->getErrors(), 'msg' => $e->getMessage())));
}catch(Exception $e){
	die(json_encode(array('rc' => $e->getCode(), 'msg' => $e->getMessage())));
}

?>