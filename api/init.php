<?php
class Init {

	protected $db;
	protected $data;
	
	public function __construct() {

		if(!isset($this->db)){
			$this->db = mysqli_connect('localhost','root','','orderentry') or die('Error: ' . mysqli_error($this->db));
		}

		$this->data_inputs();
	}

	public function format_decimal($num) {
		$num = (float)$num;
		return number_format($num,2,'.','');
	}

	private function data_inputs(){
		parse_str(file_get_contents('php://input'),$this->data);
	}

	
}