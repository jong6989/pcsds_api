<?php 

Class api{
	public function __construct(){
	}

	public function out($data, $status=1,$error_responce=""){
		$response['status'] = $status;
		if(!$status){
			$response['error'] = $error_responce;
			$response['hint'] = $data;
		} else {
			$response['data'] = $data;
		}
		
		$response = convert_from_latin1_to_utf8_recursively($response);
		
		if ($response)
			echo json_encode($response);
		else
			echo json_last_error_msg();
		
		exit;
		die();
	}
	
	public function required_fields($keys){
		$required_fields = array();
		foreach ($keys as $key => $value) {
			if(!isset($this->params->{$value})){
				$required_fields[] = $value;
			}
		}

		if(count($required_fields) > 0){
			$this->out($required_fields,0,"some fields are required");
		}
	}
}
 ?>