;(function($){
	$('input[action-type="act-placeholder"]').placeholder({});
}(jQuery));
(function($) {

    var $ialert = $.alert('').close();

	
    $.hotkeys.add('Ctrl+return', function() {
		if($('.i-dialog-wrap ').is(':visible')) return;
		$('a[action-type="act-create"]').trigger('click');
	});


	$('body').on('keydown keyup keypress', 'input[name="version"]', function(e){
      if(e.keyCode == '13'){
        e.preventDefault();
       console.log('x');
		$('a[action-type="act-browse-file"]').click();
      }
    });

	$('body').on('keydown', 'input[name="id"]', function(e){
        if(e.keyCode == '13'){
          e.preventDefault();
          $('a[action-type="act-exist"]').click();
      }
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
						window.location.href = $data.data.href;
					} else {
						$ialert.content($data.message).show().align();
					}
				}
				if (type == 'string') {

				}
			}
		}
		var $val  = parseInt($('input[action-type="act-placeholder"]').val());
		if($ialert.is(':visible')) return;
		if(!$val){
			$ialert.content('请输入上线单号').show().align();	
			return;
		}
		$('#index_form').ajaxSubmit(options);
	});


}(jQuery));
