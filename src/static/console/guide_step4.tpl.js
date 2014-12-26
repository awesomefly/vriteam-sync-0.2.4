(function($){
	//检查表单
	$('#guide_step4').forminspect({
		'onsubmit':function(json){
			json = $.parseJSON(json);
			if(json.code == '0')
				window.location = json.data.href;
			return false;
			
		}
	});
}(jQuery));
