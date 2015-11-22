<?php
include_once "init.php";

class Purchase extends Init {
	public function __construct(){parent::__construct();}
	
	public function getPurchases() {
		$sql = "SELECT a.*, 
				b.first_name, b.last_name,
				c.product,
				ROUND(IFNULL(d.amount,0),2) AS amount, d.id AS payment_id, ROUND((a.price * a.quantity) - IFNULL(d.amount,0),2) AS balance
				FROM purchase AS a
				LEFT JOIN
				customers AS b ON a.cust_id = b.id
				LEFT JOIN
				products AS c ON a.product_id = c.id
				LEFT JOIN
				payments AS d ON d.purchase_id = a.id
				ORDER BY a.date desc";
		$data = $this->db->query($sql);
		$rows = array();
		while($row = $data->fetch_object()){
			$rows[] = $row;
		}
		return $rows;
	}
	

	public function getCustomerPurchase($id) {
		$sql = "SELECT a.*, 
				b.first_name, b.last_name,
				c.product,
				ROUND(IFNULL(d.amount,0),2) AS amount, d.id AS payment_id, ROUND((a.price * a.quantity) - IFNULL(d.amount,0),2) AS balance
				FROM purchase AS a
				LEFT JOIN
				customers AS b ON a.cust_id = b.id
				LEFT JOIN
				products AS c ON a.product_id = c.id
				LEFT JOIN
				payments AS d ON d.purchase_id = a.id
				WHERE a.id = {$id}";
		return $this->db->query($sql)->fetch_object();
	}


	public function getCustomerPurchases($id) {
		$sql = "SELECT a.*, 
				b.product,
				c.amount AS paid_amount
				FROM purchase AS a
				LEFT JOIN
				products AS b ON a.product_id = b.id
				LEFT JOIN
				payments AS c ON  c.purchase_id = a.id
				where a.cust_id = {$id}
				ORDER BY a.date desc";
		$data = $this->db->query($sql);
		$rows = array();
		while($row = $data->fetch_object()){
			$rows[] = $row;
		}

		return $rows;

	}

	//not
	public function getCustomersPurchases() {
		$sql = "SELECT a.*, 
				b.product,
				c.amount AS paid_amount,
				d.first_name, d.last_name, d.credit_limit
				FROM purchase AS a
				LEFT JOIN
				products AS b ON a.product_id = b.id
				LEFT JOIN
				payments AS c ON  c.purchase_id = a.id
				LEFT JOIN
				customers AS d ON d.id = a.cust_id
				ORDER BY a.cust_id ASC, a.date DESC";
		$data = $this->db->query($sql);
		$rows = array();
		while($row = $data->fetch_object()){
			$rows[] = $row;
		}

		return $rows;

	}




	public function addPurchase() {
		/*@
		Note:
		status 0 = not paid, 1 = paid, 2 = partial
		*/
		$sql = "insert into purchase (`cust_id`,`product_id`,`quantity`,`price`,`amount`,`status`,`date`) 
				values('{$this->data['cust_id']}','{$this->data['product_id']}','{$this->data['quantity']}','{$this->data['price']}','{$this->data['amount']}','0',NOW())";

		$this->db->query($sql);
		echo $this->db->affected_rows;
	}


	public function updatePurchase($id) {
		$sql = "update purchase set 
				status = '{$this->data['status']}'
				where id = '{$id}'";
		$this->db->query($sql);
		echo $this->db->affected_rows;
	}
}