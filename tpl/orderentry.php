<?php
include_once "api/customer.php";
include_once "api/product.php";
$Customers = new Customer();
$Products = new Product();
?>
<script>
$(function(){

	// if refresh custom quantity field should be retain
	if($('#quantity').val() == "Custom"){
		$('#quantity_defined_container').removeClass('hide');
		$('#quantity_defined').focus();
	}

	// if refresh enable customer select field if disabled
	if($('#cust_id option').length > 1){
		if($('#cust_id').attr('disabled')){
			$('#cust_id').attr('disabled',false);
		}
			
	}


	$('#quantity').on('change',function(){
		var val = $(this).val();

		if(val == "Custom"){
			$('#quantity_defined_container').removeClass('hide');
			$('#quantity_defined').focus();

		}else{
			$('#quantity_defined_container').addClass('hide');
			$('#quantity_defined').val("");
		}
	});


	$(document).on('click','.del_selected',function(){
		var obj = $(this);
		var this_total = parseFloat(obj.parent().prev().text());
		var this_grand_total = parseFloat($('#grand_total').text());
		var result = this_grand_total - this_total;
		var count_record = obj.closest('tbody').find('tr').length;
		var this_parent = obj.closest('tr');

			$('#grand_total').text(result);
			this_parent.remove();
			if(count_record == 1){
				$('#grand_total_container').addClass('hide');
				$('#order_table').addClass('hide');

				if($('#cust_id option').length > 1){
					$('#cust_id').attr('disabled',false);
				}
			}
	});


	$('#btn_add').click(function(){
		if(!$('#cust_id').attr('disabled'))
			$('#cust_id').attr('disabled',true);

		var cust_limit = $('#cust_id option:selected').data('limit') == 0 ? 'Unlimited' : $('#cust_id option:selected').data('limit');
		var cust_balance = $('#cust_id option:selected').attr('data-balance');

		//return false;
		var getErrors = [];
		var cust_id = $('#cust_id').val();
		var product_id = $('#product_id').val();
		var product_value = $('#product_id option:selected').text();
		var product_price = $('#product_id option:selected').attr('data-price');
		var quantity = $('#quantity_defined').val() == "" ? $('#quantity').val() : $.trim($('#quantity_defined').val());

		if(helper.check_number(quantity) === false){getErrors.push('Check your quantity entry');}
		if(product_value == 'Select product'){getErrors.push('You did not select a product item');}
		if(cust_id == 0){getErrors.push('You did not select a product item');}

		if(getErrors.length != 0){
			helper.check_error(getErrors);
			return false;
		}

		// show purchase list table if not yet visible
		if($('#order_table').hasClass('hide')){
			$('#credit_limit').text(cust_limit);
			$('#cust_balance').text(cust_balance);
			$('#order_table').removeClass('hide');
		}


		// check body table, if length is 0, show the footer table
		var table_length = $('#order_entry_table tbody tr').length;
		if(table_length == 0){
			$('#grand_total_container').removeClass('hide');
		}

		var str = '<tr data-cust_id="'+cust_id+'">\
			<td id="'+product_id+'">'+product_value+'</td>\
			<td >'+product_price+'</td>\
			<td >'+quantity+'</td>\
			<td >'+(product_price * quantity)+'</td>\
			<td><span class="btn del_selected"><i class="glyphicon glyphicon-remove"></i></span></td>\
		';
		// append to tbody
		$('#order_entry_table tbody').append(str);

		// get grand total
		var sum = 0;
		$('#order_entry_table tbody tr').each(function(k,v){
			sum += parseFloat($(v).find('td:eq(3)').text());
		});
		$('#grand_total').text(sum);

	});

	// purchase button
	$('#btn_purchase').click(function(){
		var getDataRaw = $('#order_entry_table tbody tr');
		var data_len = getDataRaw.length;
		var i = 0;

		var credit_limit = $('#credit_limit').text();
		var cust_balance = $('#cust_balance').text();
		var cust_purchased = $('#grand_total').text();

		// check customer credit limit
		if(credit_limit != 'Unlimited'){

			var total = parseFloat(cust_balance) + parseFloat(cust_purchased);
			credit_limit = parseFloat(credit_limit)
			if(total > credit_limit){
				helper.check_error(['Credit limit exceeded']);
				return false;
			}

		}

		getDataRaw.each(function(k,v){
			var obj = $(v);
			var cust_id = obj.attr('data-cust_id');
			var product_id = obj.find('td:first').attr('id');
			var quantity = obj.find('td:eq(2)').text();
			var amount = obj.find('td:eq(3)').text();
			var price = obj.find('td:eq(1)').text();
			var data = {cust_id:cust_id, product_id:product_id, quantity:quantity,amount:amount,price:price};
			// saving data
			i += parseInt(api.addPurchase(data));
		});
		if(data_len == i){
			helper.success_msg('Order have been successfully saved.');
			var new_balance = parseFloat($('#cust_balance').text()) + parseFloat($('#grand_total').text());
			$('#cust_id option:selected').attr('data-balance',new_balance);
		}else{
			helper.check_error(['<b>Internal error</b>','Some or all of orders might not be save']);
		}
	
	});

	
	

	// close button call back upon successfully purchased
	$('#modal-close-callsback').click(function(){
		var cust_id = $('#cust_id').val();
		var cust_id_len = $('#cust_id').find('option').length;
		

		if(cust_id_len > 1){
			
			$('#cust_id option:first').attr('selected',true);
			$('#cust_id').attr('disabled',false);
			$('#product_id option:first').attr('selected',true);
			$('#quantity option:first').attr('selected',true);
			$('#quantity_defined_container').addClass('hide');
			$('#order_entry_table tbody').html("");
			$('#grand_total').text("");
			$('#grand_total_container').addClass('hide');
			$('#order_table').addClass('hide');

		}else{
			window.location = api.base_url + '/profile/'+cust_id;
		}
		
	});



});
</script>
<div class="container">
<div class="page-header">
<h2>Order Entry <small></small></h2>
</div>
<div class="col-md-6">

<form class="form-horizontal" role="form">
	<div class="form-group">
		<label for="cust_id" class="col-sm-2 control-label">Customer</label>
		<div class="col-sm-10">
			
				<?php 
				if($id){
					echo '<select disabled class="form-control" id="cust_id">';
					$id = (int)$id;
					$getCustomer = $Customers->getInfos($id);
					if(count($getCustomer)){
						$balance = $Customers->format_decimal($getCustomer->balance);
						echo "<option  value='{$getCustomer->id}' data-limit='{$getCustomer->credit_limit}' data-balance='{$balance}'>{$getCustomer->first_name} {$getCustomer->last_name}</option>";
					}else{

					}
				}else{
					echo '<select class="form-control" id="cust_id">';
				?>
					<option value="0">Select customer</option>
					<?php
						if(count($Customers->getInfos())){
							
						foreach($Customers->getInfos() as $k => $v){
							$balance = $Customers->format_decimal($v->balance);
							echo "<option value='{$v->id}' data-limit='{$v->credit_limit}' data-balance='{$balance}'>{$v->first_name} {$v->last_name}</option>";
						}
					}
				}
				?>
				
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="product_id" class="col-sm-2 control-label">Product</label>
		<div class="col-sm-10">
			<select class="form-control" id="product_id">
				<option>Select product</option>
				<?php
				if(count($Products->getProducts())){
					foreach($Products->getProducts() as $k => $v){
						echo "<option data-price='{$v->price}' value='{$v->id}'>{$v->product}</option>";
					}
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="quantity" class="col-sm-2 control-label">Quantity</label>
		<div class="col-sm-3">
			<select class="form-control" id="quantity">
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				<option>6</option>
				<option>7</option>
				<option>8</option>
				<option>9</option>
				<option>10</option>
				<option>Custom</option>
			</select>
		</div>
		<div class="col-sm-4 hide" id="quantity_defined_container">
			<input type="text" class="form-control" id="quantity_defined" placeholder="Enter quantity" />
		</div>
	</div>


	<div class="form-group">
		<label for="btn_purchase" class="col-sm-2 control-label sr-only"></label>
		<div class="col-sm-10" >
			<input type="button" value="Add" class="btn btn-primary" id="btn_add" />
		</div>
	</div>

</form>
</div>
<div id="order_table" class="col-md-6 hide">
<h4>Order Table</h4>
<span class="col-md-6">Customer Credit Limit : <b id="credit_limit"></b></span>
<span class="col-md-6">Current Balance : <b id="cust_balance"></b></span>
<table class="table table-striped table-hover table-condensed" id="order_entry_table">

	<thead>
		<tr>
			<th>Products</th>
			<th>Price</th>
			<th>Quantity</th>
			<th>Total</th>
			<th width="5px">Action</th>
		</tr>
	</thead>
	<tbody>
		
	</tbody>
	<tfoot id="grand_total_container" class="hide">
		<tr>
			<td colspan="3" align="right">Total</td>
			<td id="grand_total"></td>
			<td><button class="btn btn-primary" id="btn_purchase">Purchase</button>
		</tr>
	</tfoot>
</table>
</div>


</div>
