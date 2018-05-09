<?php

class CustomException extends Exception{

	private $errors = array();

	public function __construct($message, $code, array $errors){
		
		parent::__construct($message, $code);
		
		$this->errors = $errors;

	}

	public function getErrors(){
		
		return $this->errors;
		
	}
	
}

?>