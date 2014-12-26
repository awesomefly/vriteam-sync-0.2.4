var $alert = $.alert('').close();
;(function(){

  $('#form').submit(function(e){
      e.preventDefault();
      var $from = $(this);
      var option = {
        'success':function($data){
          $data = $.parseData($data);
          var type = $.type($data);
          if(type == 'object'){
            if($data.code == 0){
              window.location.href = $data.data.href; 
            }else{
		$alert.content($data.message).show().align();
            }
          }
        }
      }

      $from.ajaxSubmit(option);

  });

}());


;(function($){

	$.hotkeys.add('Ctrl+return', function(e) {
		if($alert.is(':hidden')){
			$('input[action-type="act-login"]').trigger('click');
		}
	});
	
	$.hotkeys.add('esc', function() {
		$('.i-dialog-close').trigger('click');
	});

}(jQuery));

