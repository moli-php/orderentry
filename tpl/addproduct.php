<script>
$(function(){
	$('#btn_add_product').click(function(){
		var getError = [];
		var product = $.trim($('#product').val());
		var price = $.trim($('#price').val());
		var type = $.trim($('#type').val());

		if(product.length == 0){getError.push('Product field is required')}
		if(price.length == 0){getError.push('Price field is required')}
		if(type.length == 0){getError.push('Type field is required')}

		var data = {product:product,price:price,type:type};

		if(getError.length == 0){
			if(api.addProduct(data) == 1){
			helper.success_msg('Product successfully save.');
			}
		}else{
			helper.check_error(getError);
			return false;
		}

	});

	$('#modal-close-callsback').click(function(){
		$('input:text').val("");
	});

});
</script>
<div class="container">
<div class="page-header">
<h2>Add Product <small></small></h2>
</div><div class="col-md-8">
<form class="form-horizontal" role="form">
	<div class="form-group">
		<label for="product" class="col-sm-2 control-label">Product</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="product" placeholder="Enter product name" />
		</div>
	</div>
	<div class="form-group">
		<label for="price" class="col-sm-2 control-label">Price</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="price" placeholder="Enter price" />
		</div>
	</div>
	<div class="form-group">
		<label for="type" class="col-sm-2 control-label">Type</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="type" placeholder="Enter type" />
		</div>
	</div>
	<div class="form-group">
		<label for="btn_add_product" class="col-sm-2 control-label sr-only"></label>
		<div class="col-sm-10">
			<input type="button" value="Add" class="btn btn-primary" id="btn_add_product" />
		</div>
	</div>
	</div>
</form>
</div>
</div>
