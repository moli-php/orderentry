<?php
include_once "init.php";

class Customer extends Init {

	private $first_name;
	private $last_name;
	private $gender;
	private $address;
	private $id;
	private $contacts;
	private $credit_limit;

	public function __construct(){parent::__construct();}
	
	public function getCustomers() {
		$sql = "select * from customers order by `date` desc";
		$data = $this->db->query($sql);
		$rows = array();
		while($row = $data->fetch_object()){
			$rows[] = $row;
		}
		return $rows;
	}

	public function getCustomer($id) {
		$id = $this->db->real_escape_string($id);
		$sql = "select * from customers where id = {$id}";
		return $this->db->query($sql)->fetch_object();
	}

	public function getInfos($id = null){
		$where = ($id != null) ? "where a.id = {$id}" : "";
		$sql = "SELECT a.* , CASE WHEN !ISNULL(c.amount) THEN (SUM(b.amount) - SUM(c.amount)) ELSE SUM(b.amount) END AS balance
				FROM customers AS a
				LEFT JOIN purchase AS b ON b.cust_id = a.id
				LEFT JOIN payments AS c ON c.purchase_id = b.id
				{$where}
				GROUP BY a.id";

		if($id){
			return $this->db->query($sql)->fetch_object();
		}else{
			$rows = array();
			$data = $this->db->query($sql);
			while($row = $data->fetch_object()){
				$rows[] = $row;
			}
			return $rows;
		}
	}

	public function deleteCustomer($id) {
		$result = 0;
		$id = $this->db->real_escape_string($id);
		$sql = "delete from customers where id = {$id}";

		$this->db->query($sql);
		$result += $this->db->affected_rows;

		$sql = "delete from purchase where cust_id = {$id}";
		$this->db->query($sql);
		$result += $this->db->affected_rows;

		$sql = "delete from payments where cust_id = {$id}";
		$this->db->query($sql);
		$result += $this->db->affected_rows;

		echo $result;
	}

	public function addCustomer() {
		$this->sanitizeValues();
		$sql = "insert into customers (`first_name`,`last_name`,`gender`,`contacts`,`address`,`credit_limit`,`date`) 
				values('{$this->first_name}','{$this->last_name}','{$this->gender}',
						'{$this->contacts}','{$this->address}','{$this->credit_limit}',NOW())";
		$this->db->query($sql);
		echo $this->db->affected_rows;
	}

	private function sanitizeValues() {

		$this->first_name = $this->db->real_escape_string($this->data['first_name']);
		$this->last_name = $this->db->real_escape_string($this->data['last_name']);
		$this->gender = $this->db->real_escape_string($this->data['gender']);
		$this->contacts = $this->db->real_escape_string($this->data['contacts']);
		$this->address = $this->db->real_escape_string($this->data['address']);
		$this->credit_limit = $this->db->real_escape_string($this->data['credit_limit']);
		if(isset($this->data['id'])){
			$this->id = $this->db->real_escape_string($this->data['id']);
		}	

	}

	public function updateCustomer($id) {
		$this->sanitizeValues();
		$sql = "update customers set 
				first_name = '{$this->first_name}',
				last_name = '{$this->last_name}',
				gender = '{$this->gender}',
				address = '{$this->address}',
				contacts = '{$this->contacts}',
				credit_limit = '{$this->credit_limit}'
				where id = '{$id}'";
		$this->db->query($sql);
		echo $this->db->affected_rows;
	}
}