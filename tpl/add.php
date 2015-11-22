<?php 
$page_info = explode('/', @$_SERVER['PATH_INFO']);
array_shift($page_info);

if(isset($page_info[1]) && !empty($page_info[1])){
	$page = strtolower(trim($page_info[1]));
	
	if($page == 'customer'){
		include 'addcustomer.php';
	}elseif($page == 'product'){
		include 'addproduct.php';
	}elseif($page == 'order'){
		include 'orderentry.php';
	
	}else{
		echo "<h2>Error 404 : Page not found</h2>";		
	}

}else{
?>
<div class="container">
<div class="page-header">
<h2>Add <small></small></h2>
</div>
	<div class="panel panel-default">
	<div class="panel-heading"><a href="<?php echo BASE_URL .'/add/customer'; ?>">Add Customer</a></div>
	</div>
	<div class="panel panel-default">
	<div class="panel-heading"><a href="<?php echo BASE_URL .'/add/product'; ?>">Add Product</a></div>
	</div>
	<div class="panel panel-default">
	<div class="panel-heading"><a href="<?php echo BASE_URL .'/add/order'; ?>">Add Order</a></div>
	</div>
</div>

<?php
}
?>