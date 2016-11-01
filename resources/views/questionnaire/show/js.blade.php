<script type="text/javascript">
$(function() {
	$('#questionnaireForm').submit(function() {
		var form = $(this);
		var valid = true;
		form.find('.alert-danger:not(.hide)').addClass('hide');
		form.find('.choices').each(function() {
			var t = this;
			if ($('input:checked', t).length === 0) {
				$(t).next('.alert').removeClass('hide');
				valid = false;
			}
		});
		
		return valid;
	});
});
</script>
