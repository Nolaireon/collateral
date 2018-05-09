<?php

class Base{
	
	private $filters = array(
/* 		'company_id' => array(
			'filter' => FILTER_VALIDATE_INT,
			'options' => array('min_range' => 1, 'max_range' => 10)
		),
 */		// clients
		'email' => array(
			'filter' => FILTER_VALIDATE_EMAIL
		),
		'firstname' => array(
			'filter' => FILTER_VALIDATE_REGEXP,
			'options' => array('regexp' => "/^[A-Za-z]{2,32}$/")
		),
		'password' => array(
			'filter' => FILTER_VALIDATE_REGEXP,
			'options' => array('regexp' => "/^[\w]{4,80}$/")
		),
		'surname' => array(
			'filter' => FILTER_VALIDATE_REGEXP,
			'options' => array('regexp' => "/^[A-Za-z]{2,32}$/")
		),
		'patronymic' => array(
			'filter' => FILTER_VALIDATE_REGEXP,
			'options' => array('regexp' => "/^[A-Za-z]{2,32}$/")
		),
		'sex' => array(
			'filter' => FILTER_VALIDATE_REGEXP,
			'options' => array('regexp' => "/^(female|male)$/")
		),
		'birth_day' => array(
			'filter' => FILTER_VALIDATE_REGEXP,
			'options' => array('regexp' => "/^\d{4}-\d{2}-\d{2}$/")
		),
		// companies
		'name' => array(
			'filter' => FILTER_VALIDATE_REGEXP,
			'options' => array('regexp' => "/^[^\r\n\t]{5,64}$/")
		),
/* 		'name' => array(
			'filter' => FILTER_SANITIZE_MAGIC_QUOTES
		),
 */		'owner' => array(
			'filter' => FILTER_VALIDATE_REGEXP,
			'options' => array('regexp' => "/^[A-Za-z\s]{8,96}$/")
		)
	);

	public function __construct(){
		
		$filtered = filter_input_array(INPUT_POST, $this->filters);
		
		foreach($filtered as $k => $v){
			if(isset($this->data[$k])){
				if($v === false){
					$this->errors[$k] = $v;
				}else{
					$this->data[$k] = $v;
				}
			}
		}
		
		if(!empty($this->errors)){
			throw new CustomException('Wrong inputs', 2, $this->errors);
		}
		
	}
	
}

?>