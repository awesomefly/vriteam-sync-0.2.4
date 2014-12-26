;
(function($) {

	$.hotkeys.add('return', function() {
		$('a[action-type="act-exist"]').trigger('click');
	});

	$.hotkeys.add('Ctrl+return', function() {
		$('a[action-type="act-create"]').trigger('click');
	});

	$('a[action-type="act-exist"], a[action-type="act-create"]').on('click', function(e) {
		var $this = $(this);
		var type = $this.attr('action-type').slice(4);
		$('input[name="act"]').val(type);
		var options = {
			'success': function($data) {
				$data = $.parseData($data);
				var type = $.type($data);
				if (type == 'object') {
					if ($data.code == 0) {
						location.href = $data.data.href;
					} else {
						$.alert($data.message);
					}
				}
				if (type == 'string') {

				}
			}
		}
		$('#index_form').ajaxSubmit(options);
	});


}(jQuery));