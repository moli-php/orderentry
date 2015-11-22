var api = {
	
	base_url : document.getElementById('base_url').innerHTML,

	addCustomer : function(data) {
		var result = false;
		$.ajax({
			url : api.base_url +'/rest/customer/add',
			type : 'post',
			data : data,
			async : false,
			success : function(data){
				result = data;
			}
		});
		
		return result;
	
	},

	deleteCustomer : function(data) {
		var result = false;

		$.ajax({
			url : api.base_url +'/rest/customer/delete/'+data.id,
			type : 'delete',
			data : data,
			async : false,
			success : function(data){
				result = data;
			}
		});
		
		return result;
	},

	updateCustomer : function(data) {
		var result = false;
		$.ajax({
			url : api.base_url +'/rest/customer/update/'+data.id,
			type : 'put',
			data : data,
			async : false,
			success : function(data){
				result = data;
			}
		});
		
		return result;
	},

	addProduct : function(data) {
		var result = false;
		$.ajax({
			url : api.base_url +'/rest/product/add',
			type : 'post',
			data : data,
			async : false,
			success : function(data){
				result = data;
			}
		});
		
		return result;
	
	},

	deleteProduct : function(data) {
		var result = false;
		$.ajax({
			url : api.base_url +'/rest/product/delete/'+data.id,
			type : 'delete',
			data : data,
			async : false,
			success : function(data){
				result = data;
			}
		});
		
		return result;
	},

	updateProduct : function(data) {
		var result = false;
		$.ajax({
			url : api.base_url +'/rest/product/update/'+data.id,
			type : 'put',
			data : data,
			async : false,
			success : function(data){
				result = data;
			}
		});
		
		return result;
	},

	addPurchase : function(data) {

		var result = false;
		$.ajax({
			url : api.base_url +'/rest/purchase/add',
			type : 'post',
			data : data,
			async : false,
			success : function(data){
				result = data;
			}
		});
		
		return result;
	},

	updatePurchase : function(data) {
		var result = false;
		$.ajax({
			url : api.base_url +'/rest/purchase/update/'+data.id,
			type : 'put',
			data : data,
			async : false,
			success : function(data){
				result = data;
			}
		});
		
		return result;
	},

	addPayment : function(data) {
		var result = false;
		$.ajax({
			url : api.base_url +'/rest/payment/add',
			type : 'post',
			data : data,
			async : false,
			success : function(data){
				result = data;
			}
		});
		
		return result;
	},

	updatePayment : function(data) {
		var result = false;
		$.ajax({
			url : api.base_url +'/rest/payment/update/'+data.id,
			type : 'put',
			data : data,
			async : false,
			success : function(data){
				result = data;
			}
		});
		
		return result;
	},



}