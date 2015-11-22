<?php
include_once "init.php";

class Product extends Init {
	public function __construct(){parent::__construct();}

	private $product;
	private $price;
	private $type;
	private $di;
	
	public function getProducts() {
		$sql = "select * from products order by `date` desc";
		$data = $this->db->query($sql);
		$rows = array();
		while($row = $data->fetch_object()){
			$rows[] = $row;
		}
		return $rows;
	}

	public function getProduct($id) {
		$sql = "select * from products where id = {$id}";
		return $this->db->query($sql)->fetch_object();
	}

	public function deleteProduct($id) {
		$sql = "select * from purchase where product_id = {$id}";
		$result = 0;
		$data = $this->db->query($sql);
		$rows = array();
		$pur_ids = array();
		while($row = $data->fetch_object()){
			$pur_ids[] = $row->id;
		}
		if(count($pur_ids)){
			$pur_ids = implode($pur_ids,',');
			$sql = "delete from payments where purchase_id in ({$pur_ids})";
			$this->db->query($sql);
			$result += $this->db->affected_rows;
		}

		$sql = "delete from purchase where product_id = {$id}";
		$this->db->query($sql);
		$result += $this->db->affected_rows;

		$sql = "delete from products where id = {$id}";
		$this->db->query($sql);
		$result += $this->db->affected_rows;

		echo $result;

	}

	public function addProduct() {
		$this->sanitizeValues();

		$sql = "insert into products (`product`,`price`,`type`,`date`) 
				values('{$this->product}','{$this->price}','{$this->type}',NOW())";
		$this->db->query($sql);
		echo $this->db->affected_rows;
	}

	public function updateProduct($id) {
		$this->sanitizeValues();

		$sql = "update products set 
				product = '{$this->product}',
				price = '{$this->price}',
				type = '{$this->type}'
				where id = '{$id}'";
		$this->db->query($sql);
		echo $this->db->affected_rows;
	}

	private function sanitizeValues() {
		$this->product = $this->db->real_escape_string($this->data['product']);
		$this->price = $this->db->real_escape_string($this->data['price']);
		$this->type = $this->db->real_escape_string($this->data['type']);
		if(isset($this->data['id'])){
			$this->id = $this->db->real_escape_string($this->data['id']);
		}
		
	}
}