<script>
$(function(){

	// search input
	$('#search_box').keyup(function(){
		var this_text = $(this).val();
			this_text = this_text.toLowerCase();
		var target = $('#accordion > div');
		
			$.each(target,function(k,v){
				var obj = $(v);
				var target_text = $(v).find('h4').text();
					target_text = target_text.toLowerCase();

					if(target_text.indexOf(this_text) != -1){
						obj.removeClass('hide');
					}else{
						obj.addClass('hide');
					}
			});
	});
	
	// anable disable input type for full payment
	$('#payment_check').click(function(){
		if($(this).attr('checked')){
			$('#payment_amount').attr('disabled',true);
		}else{
			$('#payment_amount').attr('disabled',false);
		}
	});

	$('#payment_btn').click(function(){
		var total_amount = helper.format_decimal($('#payment_check').val());
		var amount_to_pay = $('#payment_check').attr('checked') ? total_amount : $('#payment_amount').val();
			amount_to_pay = helper.format_decimal(amount_to_pay);
		var balance = helper.format_decimal($('#cust_balance').text());
		var paid_amount = helper.format_decimal($('#paid_amount').text());
		var cust_id = $('#cust_id').val();
		var purchase_id = $('#purchase_id').val();	
		var is_add = true;	
		var err = ['Please check you payment'];

		if(isNaN(amount_to_pay)){
			helper.check_error(err);
			return false;
		}
		if(amount_to_pay == 0 || amount_to_pay < 0){
			helper.check_error(err);
			return false;
		}


		if(paid_amount == 0){
			amount_to_pay = amount_to_pay > total_amount ? total_amount : amount_to_pay;
			var status = (amount_to_pay >= total_amount) ? 1 : 2;
		}else{		
			var status = (amount_to_pay >= balance) ? 1 : 2;
			amount_to_pay = amount_to_pay > balance ? total_amount : amount_to_pay + paid_amount;
			is_add = false;	
		}


		if(amount_to_pay){
			// add payment table
			if(is_add){	
				var data = {cust_id:cust_id, purchase_id:purchase_id, amount:amount_to_pay};
					if(api.addPayment(data)){	
						var data = {id:purchase_id, status:status};
						api.updatePurchase(data);
					}
			// update payment table
			}else{
					var payment_id = $('#payment_id').val();
					var data = {id:payment_id,amount:amount_to_pay};
					if(api.updatePayment(data)){
						var data = {id:purchase_id, status:status};
							api.updatePurchase(data);
					}
			}
			helper.success_msg('Payment successfully updated')
		}

			
			
	});

	// close call back upon successfully updated
	$('#modal-close-callsback').click(function(){
		var cust_id = $('#cust_id').val();
		window.location = api.base_url + '/profile/'+cust_id;
	});

});
</script>
<div class="container">
<div class="page-header">
<?php
if($id){
	echo "<h2>Payment <small></small></h2>";
}else{
	echo "<h2>Purchase <small>Group by customers</small></h2>";
}
?>

</div>
<?php
include_once "api/purchase.php";
$Purchase = new Purchase();

if($id){

	$getPurchase = $Purchase->getCustomerPurchase($id);
	if(count($getPurchase)) {

?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				<span class="panel-title"><?php echo $getPurchase->first_name ." ". $getPurchase->last_name; ?></span>
			</div>
			<div class="panel-body">
				<table class="table">
					<thead>
					<tr>
						<th>Product</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Total</th>	
						<th>Amount paid</th>
						<th>Balance</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$total = $Purchase->format_decimal($getPurchase->price * $getPurchase->quantity);
					$paid = $Purchase->format_decimal($getPurchase->amount);
					$balance = $Purchase->format_decimal($getPurchase->balance);

					echo "<tr>
							<td>{$getPurchase->product}</td>
							<td>{$getPurchase->price}</td>
							<td>{$getPurchase->quantity}</td>
							<td>{$total}</td>
							<td id='paid_amount'>{$paid}</td>
							<td id='cust_balance'>{$balance}</td>
						</tr>";
					?>
					
				</tbody>
				</table>
				<?php
				if($balance != "0.00"){
				?>
				<form class="form form-inline" role="form">
					<div class="form-group">
						<label class="sr-only" for="first_name">Amount</label>
						<input type="text" placeholder="Enter amount" id="payment_amount" disabled class="form-control">
					</div>
					<div class="form-group">
						<label class="checkbox-inline"><input id="payment_check" checked type="checkbox" value="<?php echo $total; ?>">Full payment</label>
					</div>
					<div class="form-group">
						<input type="button" id="payment_btn" value="Submit" class="form-control btn btn-primary" />
						<input type="hidden" id="cust_id" value="<?php echo $getPurchase->cust_id; ?>"/>
						<input type="hidden" id="purchase_id" value="<?php echo $getPurchase->id; ?>"/>
						<input type="hidden" id="payment_id" value="<?php echo $getPurchase->payment_id; ?>"/>
					</div>

				</div>
				</form>
				<?php
				}


	}else{
		echo "No data";
	}


				?>
				
			</div>
		</div>
	</div>
</div>







<?php
}else{ // id not set, show all customers and there purchases
include_once "api/customer.php";
$Customer = new Customer();
$getCustomers = $Customer->getCustomers();

// $getCustomers = $Customer->getCustomers();
if(count($getCustomers)){
	echo "<div id='accordion' class='panel-group'>";
	foreach($getCustomers as $val){
		$getPurchases = $Purchase->getCustomerPurchases($val->id);
		
				echo "<div class='panel panel-success'>
				<div class='panel-heading'>
					<h4>
						<a href='#section{$val->id}' data-parent='#accordion' data-toggle='collapse' class='collapsed'>
						{$val->first_name} {$val->last_name}
						</a>
					</h4>
				</div>
				<div class='panel-collapse collapse' id='section{$val->id}'>
			<div class='panel-body'>";
			?>
			<table class="table table-condensed ">
					<thead>
						<tr>
							<th>#</th>
							<th>Product</th>
							<th>Price</th>
							<th>Quantity</th>	
							<th>Total</th>
							<th>Balance</th>
							<th >Date</th>
							<th>Action</th>
							
						</tr>
					</thead>
					

			<?php 
						if(count($getPurchases)){
						echo "<tbody>";
							$total_balance = 0;
							foreach($getPurchases as $key => $val){
								$key++;
								$total = $Purchase->format_decimal($val->quantity * $val->price);
								$paid_amount = $Purchase->format_decimal($val->paid_amount);
								$balance = $Purchase->format_decimal($total - $paid_amount);
								$total_balance += $balance;
								$color = array('danger','success','warning');
								$paynow = ($val->status != 1) ? "<a class='btn btn-primary' href='".BASE_URL."/custpayment/{$val->id}'>Pay Now</a>" : "<span class='btn disabled'>Paid</span>";

								echo "<tr class='{$color[$val->status]}'>
										<td >{$key}</td>
										<td>{$val->product}</td>
										<td>{$val->price}</td>
										<td>{$val->quantity}</td>								
										<td>{$total}</td>
										<td>{$balance}</td>
										<td>{$val->date}</td>
										<td>{$paynow}</td>
									</tr>";
							}
						
								echo "</tbody>
								<tfoot style='padding:0px'>
										<tr>
											<td colspan='6' align='right'>Total Balance</td>
											<td colspan='2'>{$total_balance}</td>
										</tr>
								</tfoot>";
						}else{
							echo "<tbody><tr><td colspan='8' align='center'>No transaction's yet</td></tr></tbody>";
						}
						?>
				</table>
				<?php

			echo "</div></div></div>";

	}
	echo "</div>"; // end panel-group

	}else{
		echo "<h3>No records yet</h3>";
	}
}
?>
</div> <!-- end container -->