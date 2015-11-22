
<!-- Modals -->
<div class="modal fade" id="errorModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header my-modal-danger" style="">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Error</h4>
			</div>
			<div class="modal-body" id="errorModalBody">
					error msg
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="successModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header my-modal-success" style="">
				<h4 class="modal-title" id="myModalLabel">Success</h4>
			</div>
			<div class="modal-body" id="successModalBody">
					success msg
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="modal-close-callsback">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- hidden path -->
<div class="hide" id="base_url"><?php echo BASE_URL; ?></div>
<!-- api script -->
<?php echo "<script src='".BASE_URL."/assets/js/api.js'></script>"; ?>

</body>
</html>