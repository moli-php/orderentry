<script>
$(function(){


$('#delete_product').click(function(){
	var data = {id:$('#prod_id').val()};

	if(api.deleteProduct(data)){
		helper.success_msg('Product successfully delete.');
	}
});

$('#modal-close-callsback').click(function(){
		window.location = api.base_url+ '/product';
});


});
</script>
<?php
include_once "api/product.php";
$Products = new Product();
?>

<div class="container">
<h2>Delete Product</h2><br>
	<div class="row">
	<?php 
	if($id){
		$getProduct = $Products->getProduct($id);
		if($getProduct){
			?>
<div class="col-md-5">
	<div class="thumbnail">
		<div class="caption">
			<h4><?php echo $getProduct->product; ?></h4>
			<p><b class='text-danger'>Warning:</b> Deleting this product will also delete all connected transactions.</p>
			<a class='btn btn-danger' id="delete_product" href='#'>Delete</a>
			<a class='btn btn-default' href='<?php echo BASE_URL."/product"; ?>'>Cancel</a>
			<input type="hidden" value="<?php echo $getProduct->id; ?>" id="prod_id" />
		</div>
	</div>

</div>
			<?php
		}else{
			echo "<h4>No Record Found</h4>";
		}
		
	}else{
		$getProducts = $Products->getProducts();
		if(count($getProducts)){
			foreach($getProducts as $val){
				echo "<div class='col-md-6'>
				 		<div class='panel panel-danger'>
						<div class='panel-heading'><a href='".BASE_URL."/deleteproduct/{$val->id}'>{$val->product}</a></div>
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