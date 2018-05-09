<?php

class Company extends Base{
	
	protected $errors = array();
	
	protected $data = array(
		'name' => '',
		/*'address' => '',
		'ITN' => '',
		'IEC' => '',
		'PSRN' => '',
		'settlement_account' => '',
		'bank_name' => '',
		'BIC' => '',
		'correspondent_account' => '',
		'OKVED' => '',
		'phone' => '',
		'email' => '',*/
		'owner' => ''
	);
	
	public function add(){
		
		$this->data = array_filter($this->data, 'strlen');
		
		$str = "INSERT into companies(";
		$keys = array_keys($this->data);
		$values = array_values($this->data);
		$keys = implode(', ', $keys).", modified) VALUES ('";
		$values = implode("', '", $values)."', NOW())";
		$str .= $keys.$values;
		
		DB::query($str);
		
		if(DB::getMySQLiObject()->affected_rows != 1){
			throw new Exception('This company already exist.', 1);
		}
		
		$company_id = DB::getMySQLiObject()->insert_id;
		
		$str = "UPDATE clients SET company_id='".$company_id."', modified=NOW() WHERE client_id=".$_SESSION['user']['client_id'];
		
		DB::query($str);
		
		if(DB::getMySQLiObject()->affected_rows != 1){
			throw new Exception(DB::getMySQLiObject()->error(), 1);
		}
		
		$_SESSION['user']['company_id'] = $company_id;
		
	}
	
	public function update(){
		
		$this->data = array_filter($this->data, 'strlen');
		
		$str = "UPDATE companies SET ";
		foreach($this->data as $k => $v){
			$str .= $k."='".$v."', ";
		}
		$str .= "modified=NOW() WHERE company_id=".$_SESSION['user']['company_id'];
		
		DB::query($str);
		
		if(DB::getMySQLiObject()->affected_rows != 1){
			throw new Exception(DB::getMySQLiObject()->error(), 1);
		}
		
	}

}

?>