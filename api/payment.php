<?php
include_once "init.php";

class Payment extends Init {
	public function __construct(){parent::__construct();}

	
	public function getPayments() {
		$sql = "SELECT a.*, 
				b.quantity, b.status, b.price,
				c.product,
				d.first_name, d.last_name
				FROM payments AS a
				LEFT JOIN
				purchase AS b ON a.purchase_id = b.id
				LEFT JOIN
				products AS c ON  c.id = b.product_id
				LEFT JOIN
				customers AS d ON d.id = a.cust_id
				ORDER BY a.date DESC";
		$data = $this->db->query($sql);
		$rows = array();
		while($row = $data->fetch_object()){
			$rows[] = $row;
		}
		return $rows;
	}


	public function addPayment() {
		$sql = "insert into payments (`cust_id`,`purchase_id`,`amount`,`date`) 
				values('{$this->data['cust_id']}','{$this->data['purchase_id']}','{$this->data['amount']}',NOW())";
		$this->db->query($sql);
		echo $this->db->affected_rows;
	}

	public function updatePayment($id) {
		$sql = "update payments set `amount` = '{$this->data['amount']}' where id = '{$id}'";
		$this->db->query($sql);
		echo $this->db->affected_rows;
	}

	public function getCustomerPayments($id) {
		$sql = "SELECT a.*, 
				b.quantity, b.status, b.price,
				c.product
				FROM payments AS a
				LEFT JOIN
				purchase AS b ON a.purchase_id = b.id
				LEFT JOIN
				products AS c ON  c.id = b.product_id
				WHERE a.cust_id = {$id}
				ORDER BY a.date DESC";
		$data = $this->db->query($sql);
		$rows = array();
		while($row = $data->fetch_object()){
			$rows[] = $row;
		}

		return $rows;
	}
}