<script>
$(function(){
	$('#btn_edit_product').click(function(){
		var getError = [];
		var product = $.trim($('#product').val());
		var price = $.trim($('#price').val());
		var type = $.trim($('#type').val());
		var id = $('#prod_id').val();

		if(product.length == 0){getError.push('Product field is required')}
		if(price.length == 0){getError.push('Price field is required')}
		if(type.length == 0){getError.push('Type field is required')}

		var data = {id:id,product:product,price:price,type:type};

		if(getError.length == 0){
			if(api.updateProduct(data) == 1){
			helper.success_msg('Product successfully updated.');
			}
		}else{
			helper.check_error(getError);
			return false;
		}

	});

	$('#modal-close-callsback').click(function(){
		window.location = api.base_url + '/product';
	});

});
</script>
<?php
include_once "api/product.php";
$Products = new Product();
?>
<div class="container">
<h2>Edit Product</h2><br>
<div class="row">
<?php
if($id){

$getProduct = $Products->getProduct($id);
	if(count($getProduct)){
?>
	<div class="col-md-8">

	<form class="form-horizontal" role="form">
		<div class="form-group">
			<label for="product" class="col-sm-2 control-label">Product</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="product" placeholder="Enter product name" value="<?php echo $getProduct->product; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="price" class="col-sm-2 control-label">Price</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="price" placeholder="Enter price" value="<?php echo $getProduct->price; ?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="type" class="col-sm-2 control-label">Type</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="type" placeholder="Enter type" value="<?php echo $getProduct->type; ?>"/>
			</div>
		</div>

		<div class="form-group">
			<label for="" class="col-sm-2 control-label sr-only"></label>
			<div class="col-sm-10">
				<input type="button" value="Update" class="btn btn-primary" id="btn_edit_product" />
				<a href="<?php echo BASE_URL.'/product'; ?>" class="btn btn-default">Cancel</a>
				<input type="hidden" value="<?php echo $getProduct->id; ?>" id="prod_id" />
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
$getProducts = $Products->getProducts();
		if(count($getProducts)){
			foreach($getProducts as $val){
				echo "<div class='col-md-6'>
				 		<div class='panel panel-warning'>
						<div class='panel-heading'><a href='".BASE_URL."/editproduct/{$val->id}'>{$val->product}</a></div>
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