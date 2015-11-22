<?php

class Routes {

	private $url_info;
	private $request;

	public function __construct() {
		$this->url_info = explode('/', @$_SERVER['PATH_INFO']);
		$this->request = $_SERVER['REQUEST_METHOD'];
		array_shift($this->url_info);

		// REST Apllication for ajax request
		$this->service_api();
	}



	public function viewPage() {

		if($this->url_info){
			$file = "tpl/{$this->url_info[0]}.php";
		}else{
			$file = "tpl/customer.php";
		}
		
		// create varables for the view
		foreach($this->createGlobalVariables() as $var => $value){
			${$var} = $value;
		}
		
		// create the page
		if(file_exists($file)){
			include_once "tpl/properties/header.php";
			include_once $file;
			include_once "tpl/properties/footer.php";
		}else{
			include "tpl/error.php";
		}
		
	}

	public function service_api() {

		if($this->url_info){
			if($this->url_info[0] == 'rest'){
				// create varables service.php api
				foreach($this->createGlobalVariables() as $var => $value){
				${$var} = $value;
				}
				include "api/service.php";
				exit();
			}
		}
	}

	private function createGlobalVariables() {

		$info = $this->url_info;

		$is_disabled = "";
		$page = "";
		$id = isset($info[1]) ? $info[1] : "";
		$action = isset($info[2]) ? $info[2] : "";
		$id2 = isset($info[3]) ? $info[3] : "";
		if(isset($info[0])){

			$search_disabled = array('addcustomer','orderentry','addproduct','add');

			if(in_array($info[0],$search_disabled)){
				$is_disabled = "disabled";
			}
			$page = $info[0];

			if($page == "custpayment" && $id != ""){
				$is_disabled = "disabled";
			}
		}

		$vars = array(
			'page' => $page,
			'is_disabled' => $is_disabled,
			'id' => (int)$id,
			'class' => $id,
			'action' => $action,
			'breadcrumb' => $info,
			'request' => $this->request,
			'id2' => (int)$id2
		);
		return $vars;

	}






	
}