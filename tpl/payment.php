<?php 
$page_info = explode('/', @$_SERVER['PATH_INFO']);
array_shift($page_info);

if(isset($page_info[1]) && !empty($page_info[1])){
	$page = strtolower(trim($page_info[1]));
	
	if($page == 'bydate'){
		include 'paymentbydate.php';
	}elseif($page == 'byname'){
		include 'paymentbycust.php';
	}else{
		echo "<h2>Error 404 : Page not found</h2>";		
	}

}else{
?>
<div class="container">
<div class="page-header">
<h2>Payment <small></small></h2>
</div>
	<div class="panel panel-default">
	<div class="panel-heading"><a href="<?php echo BASE_URL .'/payment/bydate'; ?>">By date</a></div>
	</div>
	<div class="panel panel-default">
	<div class="panel-heading"><a href="<?php echo BASE_URL .'/payment/byname'; ?>">Group by name</a></div>
	</div>
</div>

<?php
}
?>