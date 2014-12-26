(function($){
	

	$('input[name="project_name"]').inspect({
		'min': 1,
		'success': function() {
			var $wrap = this;
			$wrap.next('.error').html('').addClass('corrects').removeClass('text-error').show();
		},
		'error': function() {
			var $wrap = this;
			$wrap.next('.error').html('服务器描述不能为空！').addClass('text-error').removeClass('corrects').show();
		}
	});

	$('input[name="pgroup_name"]').inspect({
		'min': 1,
		'success': function() {
			var $wrap = this;
			$wrap.next('.error').html('').addClass('corrects').removeClass('text-error').show();
		},
		'error': function() {
			var $wrap = this;
			$wrap.next('.error').html('项目组名称不合法！').addClass('text-error').removeClass('corrects').show();
		},
        'closest':'.info-list'
	});
	
    //检查表单
	$('#server_form').forminspect({
		'success' : function(){},
		'error':function(){
			//message.success('表单有选项不合法，请检查之后再提交');
		},
		'onsubmit':function(json){
			json = $.parseJSON(json);
			if(json.code == '0'){
				window.location = json.data.href;
			}else{
				if(json.data){
					for(var key in json.data){
					  if(json.data[key]) $('[name="'+key+'"]').next('.error').addClass('text-error').removeClass('text-success').html(json.data[key]).show();
                    			}
				}
			}
			return false;
			
		}
	});


}(jQuery));
