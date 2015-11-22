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
include_once "api/product.php";
$Products = new Product();
?>
<div class="container">

		<div class="page-header">
<h2>Product <small></small></h2>
</div>
<table class="table table-striped table-hover table-condensed">
	<caption><h2>Product Table</h2></caption>
		<colgroup>
			<col width="20px" />
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
			<th>Product</th>
			<th>Type</th>
			<th>Price</th>
			<th>Date Created</th>
			<th colspan='2' class='center'>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php

		$data = $Products->getProducts();
		if(count($data)){
			foreach($data as $k => $v){ $k++;
				echo "
				<tr>
				<td>{$k}</td>
				<td>{$v->product}</td>
				<td>{$v->type}</td>
				<td>{$v->price}</td>
				<td>{$v->date}</td>
				<td><a href='".BASE_URL."/deleteproduct/{$v->id}' data-id='{$v->id}' class='btn'><i class='glyphicon glyphicon-trash'></i></a></td>
				<td><a href='".BASE_URL."/editproduct/{$v->id}' data-id='{$v->id}' class='btn'><i class='glyphicon glyphicon-pencil'></i></a></td>
				</tr>
				";
			}
		}else{
			echo "<tr><td colspan='7' class='center'>No record yet<td></tr>";
		}
	?>
	</tbody>
</table>
</div>