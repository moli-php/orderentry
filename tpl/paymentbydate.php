<script>
$(function(){
	// search input
	$('#search_box').keyup(function(){
		var this_text = $(this).val();
			this_text = this_text.toLowerCase();
		var target = $('table tbody tr');
		var i = 0;
			$.each(target,function(k,v){
				var obj = $(v);
				var target_text = $(v).find('td:eq(1)').text();
					target_text = target_text.toLowerCase();
					if(target_text.indexOf(this_text) != -1){
						i++;
						obj.find('td:first').text(i);
						obj.removeClass('hide');
					}else{
						obj.addClass('hide');
					}
			});
	});
});
</script>
<?php
include_once "api/payment.php";
$Payment = new Payment();
$Payments = $Payment->getPayments();
?>

<div class="container">
	<div class="page-header">
<h2>Paments <small>Order by date</small></h2>
</div>
<table class="table table-hover table-condensed">
	<caption><h2>Payments Table</h2></caption>
	<colgroup>
		<col width="20px" />
		<col width="" />
		<col width="" />
		<col width="" />
		<col width="" />
		<col width="" />
		<col width="" />
		<col width="" />
	</colgroup>
	<thead>
		<tr>
		<th>#</th>
		<th>Name</th>
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
	if(count($Payments)){

	echo "<tbody>";
	
		$total_paid = 0;
		foreach($Payments as $key => $val){

			$key++;
			$total = $Payment->format_decimal($val->quantity * $val->price);
			$total_paid += $val->amount;
			$color = array('danger','success','warning');
			$paynow = ($val->status != 1) ? "<a class='btn btn-primary' href='".BASE_URL."/custpayment/{$val->purchase_id}'>Pay Now</a>" : "<span class='btn disabled'>Paid</span>";

			echo "<tr class='{$color[$val->status]}'>
					<td >{$key}</td>
					<td>{$val->first_name} {$val->last_name}</td>
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