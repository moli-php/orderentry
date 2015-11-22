$(function(){

	// Monitor ajax requests, show or hide loader image
	$( document ).ajaxComplete(function() {
	$('#img_con').addClass('hide');
	});
	$( document ).ajaxStart(function() {
	$('#img_con').removeClass('hide');
	});



});


var helper = {

	format_decimal : function(num) {

		return parseFloat(Number(num).toFixed(2));

	},

	check_number : function(num) {

		return /^([1-9]|[1-9][0-9]*)$/.test(num);

	},

	check_error : function(data) {

		$('#errorModalBody').html("");
		$.each(data, function(k,v){
			$('#errorModalBody').append('<p class="text-danger">'+v+'</p>');
		});

		$('#errorModal').modal('show');
	},

	success_msg : function(msg) {
		$('#successModalBody').html('<p class="text-success">'+msg+'</p>');
		$('#successModal').modal('show');
	}
}