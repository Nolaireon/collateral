<?php

class Client extends Base{
	
	protected $errors = array();
	
	protected $data = array(
		'email' => '',
		'firstname' => '',
		'password' => '',
		'surname' => '',
		'patronymic' => '',
		'sex' => '',
		'birth_day' => ''
	);
	
	public function select(){
		
		$this->data = array_filter($this->data, 'strlen');
		$this->data['password'] = hash('sha256', $this->data['password']);
		
		$str = "SELECT client_id, email, firstname, company_id FROM clients WHERE email = '".$this->data['email']."' AND password = '".$this->data['password']."'";
		
		$result = DB::query($str);
		
		if($result->num_rows != 1){
			throw new Exception('Invalid email or password.', 1);
		}
		
		$_SESSION['user'] = $result->fetch_assoc();
		
		$result->free();
		
	}
	
	public function add(){
		
		$this->data = array_filter($this->data, 'strlen');
		$this->data['password'] = hash('sha256', $this->data['password']);
		
		$str = "INSERT into clients(";
		$keys = array_keys($this->data);
		$values = array_values($this->data);
		$keys = implode(', ', $keys).", modified) VALUES ('";
		$values = implode("', '", $values)."', NOW())";
		$str .= $keys.$values;
		
		DB::query($str);
		
		if(DB::getMySQLiObject()->affected_rows != 1){
			throw new Exception('This email is in use.', 1);
		}
		
	}
		
	public function update(){
		
		$exclude_keys = array(
			'email' => '',
			'password' => ''
		);
		
		$this->data = array_diff_key($this->data, $exclude_keys);
		$this->data = array_filter($this->data, 'strlen');
		
		$str = "UPDATE clients SET ";
		foreach($this->data as $k => $v){
			$str .= $k."='".$v."', ";
		}
		$str .= "modified=NOW() WHERE client_id=".$_SESSION['user']['client_id'];
		
		DB::query($str);
		
		if(DB::getMySQLiObject()->affected_rows != 1){
			throw new Exception(DB::getMySQLiObject()->error(), 1);
		}
		
		$_SESSION['user'] = array_replace($_SESSION['user'], array_intersect_key($this->data, $_SESSION['user']));
		
	}

}

?>