<script>
$(function(){
	$('#btn_edit_customer').click(function(){
		var getError = [];
		var first_name = $.trim($('#first_name').val());
		var last_name = $.trim($('#last_name').val());
		var address = $.trim($('#address').val());
		var credit_limit = $('#credit_limit').val();
		var gender = $.trim($('input[name="gender"]:checked').val());
		var contacts = $.trim($('#contacts').val());
		var id = $('#cust_id').val();
		var data = {id:id,first_name:first_name,last_name:last_name,contacts:contacts,gender:gender,address:address,credit_limit:credit_limit};

		if(first_name.length == 0){getError.push('First name is required')}
		if(last_name.length == 0){getError.push('Last name is required')}
		if(address.length == 0){getError.push('Address is required')}
		if(contacts.length == 0){getError.push('Contact number is required')}
		if(gender.length == 0){getError.push('Gender is required')}


		if(getError.length == 0){
			if(api.updateCustomer(data) == 1){
			helper.success_msg('Customer successfully updated.');
			}
		}else{
			helper.check_error(getError);
			return false;
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
<h2>Edit Customer</h2><br>
<div class="row">
<?php
if($id){

$getCustomer = $Customers->getCustomer($id);
	if(count($getCustomer)){
?>
	<div class="col-md-8">

	<form class="form-horizontal" role="form">
		<div class="form-group">
			<label for="first_name" class="col-sm-2 control-label">First name</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="first_name" placeholder="Enter first name" value="<?php echo $getCustomer->first_name; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="last_name" class="col-sm-2 control-label">Last name</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="last_name" placeholder="Enter last name" value="<?php echo $getCustomer->last_name; ?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="address" class="col-sm-2 control-label">Address</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="address" placeholder="Enter full address" value="<?php echo $getCustomer->address; ?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="contacts" class="col-sm-2 control-label">Contacts</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="contacts" placeholder="Enter contact number(s)" value="<?php echo $getCustomer->contacts; ?>"/>
			</div>
		</div>
		
		<div class="form-group">
			<label for="credit_limit" class="col-sm-2 control-label">Credit limit</label>
			<div class="col-sm-3">
				<select class="form-control" id="credit_limit">
					<?php
					$options = array(10000,20000,50000,100000,500000,'Unlimited');
					foreach($options as $v){
						if($getCustomer->credit_limit == $v){
							echo "<option selected>{$v}</option>";
						}elseif($getCustomer->credit_limit == 0 && $v == 'Unlimited'){
							echo "<option selected>{$v}</option>";
						}else{
							echo "<option>{$v}</option>";
						}
						
					}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="gender" class="col-sm-2 control-label">Gender</label>
			<div class="col-sm-10">
				<?php
				$gender = array('male','female');
				foreach($gender as $val){
					if($getCustomer->gender == $val){
						echo "<label class='radio-inline'><input type='radio' value='{$val}' checked name='gender' />'".ucfirst($val)."</label>";
					}else{
						echo "<label class='radio-inline'><input type='radio' value='{$val}' name='gender' />'".ucfirst($val)."</label>";
					}
				}
				?>
			</div>
		</div>
		<div class="form-group">
			<label for="btn_add_customer" class="col-sm-2 control-label sr-only">Credit limit</label>
			<div class="col-sm-10">
				<input type="button" value="Update" class="btn btn-primary" id="btn_edit_customer" />
				<a href="<?php echo BASE_URL; ?>" class="btn btn-default">Cancel</a>
				<input type="hidden" value="<?php echo $getCustomer->id; ?>" id="cust_id" />
			</div>
		</div>
		</div>
	</form>
	</div>
<?php
	}else{
		echo '<div class="col-md-8"><h4>No Record Found</h4></div>';
	}
}else{
$getCustomers = $Customers->getCustomers();
		if(count($getCustomers)){
			foreach($getCustomers as $val){
				echo "<div class='col-md-6'>
				 		<div class='panel panel-warning'>
						<div class='panel-heading'><a href='".BASE_URL."/editcustomer/{$val->id}'>{$val->first_name} {$val->last_name}</a></div>
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