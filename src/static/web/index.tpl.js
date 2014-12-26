;
(function($) {


	$('a[action-type="act-detail"], a[action-type="act-create"]').on('click', function(e) {
		var $this = $(this);
		var type = $this.attr('action-type').slice(4);
		$('input[name="act"]').val(type);
		$('#index_form').submit();
	});


}(jQuery));