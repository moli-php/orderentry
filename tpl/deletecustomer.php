<script>
$(function(){


$('#delete_customer').click(function(){
	var data = {id:$('#cust_id').val()};

	if(api.deleteCustomer(data)){
		helper.success_msg('Customer successfully delete.');
	}
});

$('#modal-close-callsback').click(function(){
		window.location = api.base_url;
});


});
</script>
<?php
include_once "api/customer.php";
$Customers = new Customer();
?>

<div class="container">
<h2>Delete Customer</h2><br>
	<div class="row">
	<?php 
	if($id){
		$getCustomer = $Customers->getCustomer($id);
		if($getCustomer){
			$gender = ($getCustomer->gender == "male") ? "his" : "her";
			?>
<div class="col-md-5">
	<div class="thumbnail">
		<div class="caption">
			<h4><?php echo $getCustomer->first_name ." ". $getCustomer->last_name; ?></h4>
			<p><b class='text-danger'>Warning:</b> Deleting this customer will also delete all <?php echo $gender; ?> transactions.</p>
			<a class='btn btn-danger' href='#' id="delete_customer">Delete</a>
			<a class='btn btn-default' href='<?php echo BASE_URL; ?>'>Cancel</a>
			<input type="hidden" id="cust_id" value="<?php echo $getCustomer->id; ?>" />
		</div>
	</div>

</div>
			<?php
		}else{
			echo "<h4>No Record Found</h4>";
		}
		
	}else{
		$getCustomers = $Customers->getCustomers();
		if(count($getCustomers)){
			foreach($getCustomers as $val){
				echo "<div class='col-md-6'>
				 		<div class='panel panel-danger'>
						<div class='panel-heading'><a href='".BASE_URL."/deletecustomer/{$val->id}'>{$val->first_name} {$val->last_name}</a></div>
						</div>
					</div>";
			}
		}else{
			echo "<h4>No Record Yet</h4>";
		}
	}
	?>





	</div>
</div>