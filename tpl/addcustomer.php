<script>
$(function(){
	$('#btn_add_customer').click(function(){
		var getError = [];
		var first_name = $.trim($('#first_name').val());
		var last_name = $.trim($('#last_name').val());
		var address = $.trim($('#address').val());
		var credit_limit = $('#credit_limit').val();
		var gender = $.trim($('input[name="gender"]:checked').val());
		var contacts = $.trim($('#contacts').val());
		var data = {first_name:first_name,last_name:last_name,contacts:contacts,gender:gender,address:address,credit_limit:credit_limit};

		if(first_name.length == 0){getError.push('First name is required')}
		if(last_name.length == 0){getError.push('Last name is required')}
		if(address.length == 0){getError.push('Address is required')}
		if(contacts.length == 0){getError.push('Contact number is required')}
		if(gender.length == 0){getError.push('Gender is required')}


		if(getError.length == 0){
			if(api.addCustomer(data) == 1){
			helper.success_msg('Customer successfully save.');
			}
		}else{
			helper.check_error(getError);
			return false;
		}

	});


	$('#modal-close-callsback').click(function(){
		$('input:text').val("");
		$('input:radio').attr('checked',false);
		$('select')[0].selectedIndex = 0;
	});

});
</script>
<div class="container">
<div class="page-header">
<h2>Add Customer <small></small></h2>
</div>
<div class="col-md-8">
<form class="form-horizontal" role="form">
	<div class="form-group">
		<label for="first_name" class="col-sm-2 control-label">First name</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="first_name" placeholder="Enter first name" />
		</div>
	</div>
	<div class="form-group">
		<label for="last_name" class="col-sm-2 control-label">Last name</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="last_name" placeholder="Enter last name" />
		</div>
	</div>
	<div class="form-group">
		<label for="address" class="col-sm-2 control-label">Address</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="address" placeholder="Enter full address" />
		</div>
	</div>
	<div class="form-group">
		<label for="contacts" class="col-sm-2 control-label">Contacts</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="contacts" placeholder="Enter contact number(s)" />
		</div>
	</div>
	<div class="form-group">
		<label for="credit_limit" class="col-sm-2 control-label">Credit limit</label>
		<div class="col-sm-3">
			<select class="form-control" id="credit_limit">
				<option>10000</option>
				<option>20000</option>
				<option>50000</option>
				<option>100000</option>
				<option>500000</option>
				<option>Unlimited</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="gender" class="col-sm-2 control-label">Gender</label>
		<div class="col-sm-10">
			<label class="radio-inline"><input type="radio" value="male" name="gender" />Male</label>
			<label class="radio-inline"><input type="radio" value="female" name="gender" />Female</label>
		</div>
	</div>
	<div class="form-group">
		<label for="btn_add_customer" class="col-sm-2 control-label sr-only">Credit limit</label>
		<div class="col-sm-10">
			<input type="button" value="Add" class="btn btn-primary" id="btn_add_customer" placeholder="Enter customer's credit limit" />
		</div>
	</div>
	</div>
</form>
</div>
</div>