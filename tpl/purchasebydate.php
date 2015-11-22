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
include_once "api/purchase.php";
$Purchase = new Purchase();
$Purcahses = $Purchase->getPurchases()
?>

<div class="container">
<div class="page-header">
<h2>Purchase <small>Order by date</small></h2>
</div>

<table class="table table-hover table-condensed">
	<caption><h2>Purchase Table</h2></caption>
	<thead>
		<tr>
			<th width="20px">#</th>
			<th>Name</th>
			<th>Product</th>
			<th>Price</th>
			<th>Quantity</th>
			<th>Total</th>
			<th>Balance</th>
			<th>Date Ordered</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if(count($Purcahses)){
			foreach($Purcahses as $k => $v){ $k++;
				$total = $Purchase->format_decimal($v->quantity * $v->price);
				$color = array('danger','success','warning');
				$paynow = ($v->status != 1) ? "<a class='btn btn-primary' href='".BASE_URL."/custpayment/{$v->id}'>Pay Now</a>" : "<span class='btn disabled'>Paid</span>";
				echo "
					<tr class='{$color[$v->status]}'>
						<td>{$k}</td>
						<td>{$v->first_name} {$v->first_name}</td>
						<td>{$v->product}</td>
						<td>{$v->price}</td>
						<td>{$v->quantity}</td>
						<td>{$total}</td>
						<td>{$v->balance}</td>
						<td>{$v->date}</td>
						<td>{$paynow}</td>
					</tr>
				";
			}
		}else{
			echo "<tr><td colspan='9' class='center'>No record yet<td></tr>";
		}
	?>
	</tbody>
</table>
</div>