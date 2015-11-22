<script>
$(function(){
	// search input
	$('#search_box').keyup(function(){
		var this_text = $(this).val();
			this_text = this_text.toLowerCase();
		var target = $('#profile_con > .row');
		
			$.each(target,function(k,v){
				var obj = $(v);
				var target_text = $(v).find('.profile_name').text();
					target_text = target_text.toLowerCase();

					if(target_text.indexOf(this_text) != -1){
						obj.removeClass('hide');
					}else{
						obj.addClass('hide');
					}
			});
	});
});
</script>
<div class="container">
<div class="page-header">
<h2>Profile <small>Group by customers</small></h2>
</div>
<?php
include_once "api/customer.php";
$Customer = new Customer();
if($id){
include_once "api/purchase.php";
include_once "api/payment.php";
$Purchase = new Purchase();
$Payment = new Payment();
$profile = $Customer->getCustomer($id);
if(count($profile)){
$getPurchases = $Purchase->getCustomerPurchases($id);
$getPayments = $Payment->getCustomerPayments($id);
$credit_limit = $profile->credit_limit == 0 ? 'Unlimited' : $profile->credit_limit;
?>

	<div class="row">
		<div class="col-md-12">
			<div class="well well-sm">
				<h2><?php echo $profile->first_name ." ". $profile->last_name; ?></h2>
				<div><?php echo $profile->address; ?></div>
				<div><?php echo $profile->contacts; ?></div>
				<div>Credit Limit: <?php echo $credit_limit; ?></div>
				<h4><a class="btn btn-primary" href="<?php echo BASE_URL . "/orderentry/{$id}"; ?>">Place an order</a></h4>
			</div>
			
		</div>
	</div>


<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				<span class="panel-title">Purchases</span>
			</div>
			<div class="panel-body">
				<table class="table table-condensed ">
					<thead>
						<tr>
							<th>#</th>
							<th>Product</th>
							<th >Date</th>
							<th>Price</th>
							<th>Quantity</th>	
							<th>Total</th>
							<th>Balance</th>
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
										<td>{$val->date}</td>
										<td>{$val->price}</td>
										<td>{$val->quantity}</td>								
										<td>{$total}</td>
										<td>{$balance}</td>
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
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Payments</h3>
			</div>
			<div class="panel-body">
				<table class="table table-condensed">
					<thead>
						<tr>
							<th>#</th>
							<th>Product</th>
							<th>Date</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Total</th>
							<th>Amount Paid</th>
							<th>Action</th>
						</tr>
					</thead>
					<?php
						if(count($getPayments)){

						echo "<tbody>";
						
							$total_paid = 0;
							foreach($getPayments as $key => $val){
								$key++;
								$total = $Purchase->format_decimal($val->quantity * $val->price);
								$total_paid += $val->amount;
								$color = array('danger','success','warning');
								$paynow = ($val->status != 1) ? "<a class='btn btn-primary' href='".BASE_URL."/custpayment/{$val->purchase_id}'>Pay Now</a>" : "<span class='btn disabled'>Paid</span>";

								echo "<tr class='{$color[$val->status]}'>
										<td >{$key}</td>
										<td>{$val->product}</td>
										<td>{$val->date}</td>
										<td>{$val->price}</td>
										<td>{$val->quantity}</td>								
										<td>{$total}</td>
										<td>{$val->amount}</td>
										<td>{$paynow}</td>
									</tr>";
							}
						
						
						echo "</tbody>
								<tfoot style='padding:0px'>
										<tr>
											<td colspan='6' align='right'>Total Paid</td>
											<td colspan='2'>{$total_paid}</td>
										</tr>
								</tfoot>";
						}else{
							echo "<tbody><tr><td colspan='8' align='center'>No transaction's yet</td></tr></tbody>";
						}
			?>
				</table>
			</div>
		</div>
	</div>
</div>

<?php
	}else{ // if no profile record found
		echo "<h3>No record found</h3>";
	}
}else{
	$getCustomers = $Customer->getCustomers();
	echo "<div id='profile_con'>";
	if(count($getCustomers)){

		foreach($getCustomers as $val){
			$credit_limit = $val->credit_limit == 0 ? 'Unlimited' : $val->credit_limit;
		echo "<div class='row'>
				<div class='col-md-12'>
					<div class='well well-sm'>
						<h2 class='profile_name'><a href='".BASE_URL."/profile/{$val->id}'>{$val->first_name} {$val->last_name}</a></h2>
						<div>{$val->address}</div>
						<div>{$val->contacts}</div>
						<div>Credit Limit: {$credit_limit}</div>
						<h4><a href='".BASE_URL."/orderentry/{$val->id}' class='btn btn-primary'>Place an order</a></h4>
					</div>	
				</div>
			</div>";
		}
	}else{
		echo "<h3>No Record yet</h3>";
	}
	echo "</div>";
}

?>
</div><!-- end container -->







