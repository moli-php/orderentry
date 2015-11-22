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
				var target_text = $(v).find('td:eq(1) a').text();
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
include_once "api/customer.php";
$Customers = new Customer();
?>

<div class="container">
<div class="page-header">
<h2>Customer <small></small></h2>
</div>
<table class="table table-striped table-hover table-condensed">
	<caption><h2>Customer Table</h2></caption>
		<colgroup>
			<col width="20px" />
			<col width="" />
			<col width="" />
			<col width="" />
			<col width="" />
			<col width="" />
			<col width="" />
			<col width="5px" />
			<col width="5px" />
		</colgroup>
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Address</th>
			<th>Gender</th>
			<th>Contacts</th>
			<th>Credit Limit</th>
			<th>Date Created</th>
			<th colspan='2' class='center'>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$data = $Customers->getCustomers();
		if(count($data)){
			foreach($data as $k => $v){ $k++;
				$credit = $v->credit_limit == "0.00" ? 'Unlimited' : $v->credit_limit;
				echo "<tr>
						<td>{$k}</td>
						<td><a href='".BASE_URL."/profile/{$v->id}'>{$v->first_name} {$v->last_name}</a></td>
						<td>{$v->address}</td>
						<td>{$v->gender}</td>
						<td>{$v->contacts}</td>
						<td>{$credit}</td>
						<td>{$v->date}</td>
						<td><a href='".BASE_URL."/deletecustomer/{$v->id}' data-id='{$v->id}' class='btn cust_delete'><i class='glyphicon glyphicon-trash'></i></a></td>
						<td><a href='".BASE_URL."/editcustomer/{$v->id}' data-id='{$v->id}' data-id='{$v->id}' class='btn'><i class='glyphicon glyphicon-pencil'></i></a></td>
					</tr>";
			}
		}else{
			echo "<tr><td colspan='9' class='center'>No record yet<td></tr>";
		}
	?>
	</tbody>
</table>
</div>