;(function($){
	
	$('input[name="desc"]').inspect({
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
	
    $('input[name="s_uri"]').inspect({
		'min': 1,
		'type': 'url',
		'success': function() {
			var $wrap = this;
			$wrap.next('.error').html('').addClass('corrects').removeClass('text-error').show();
		},
		'error': function() {
			var $wrap = this;
			$wrap.next('.error').html('svn地址不合法！').addClass('text-error').removeClass('corrects').show();
		},
	});
    
	$('input[name="user_name"]').inspect({
		'min': 1,
		'success': function() {
			var $wrap = this;
			$wrap.next('.error').html('').addClass('corrects').removeClass('text-error').show();
		},
		'error': function() {
			var $wrap = this;
			$wrap.next('.error').html('用户名不能为空！').addClass('text-error').removeClass('corrects').show();
		}
	});

	$('input[name="password"]').inspect({
		'min': 1,
		'success': function() {
			var $wrap = this;
			$wrap.next('.error').html('').addClass('corrects').removeClass('text-error').show();
		},
		'error': function() {
			var $wrap = this;
			$wrap.next('.error').html('密码不能为空！').addClass('text-error').removeClass('corrects').show();
		}
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
					  if(json.data[key]) $('[name="'+key+'"]').next('.error').addClass('text-error').removeClass('corrects').html(json.data[key]).show();
                    			}
				}
			}
			return false;
			
		}
	});


}(jQuery));
