/* 表单验证 */ ;
(function($) {

	var message = {};
	message.success = function(msg) {
		var $card = $.icard({
			'class': 'i-message',
			'title': '',
			'content': msg,
			'width': 500
		}).show().align();
		setTimeout(function() {
			$card.fadeOut();
		}, 2000);
	}

	//检查input
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

    var min = 1;
    if(/\d$/ig.test(window.location.href.toString())) min = 0;
	$('input[name="password"]').inspect({
		'min': min,
        'pass': 'input[name="repassword"]',
		'success': function() {
			var $wrap = this;
			$wrap.next('.error').html('').addClass('corrects').removeClass('text-error').show();
		},
		'error': function(e) {
			var $wrap = this;
			$wrap.next('.error').html(e).addClass('text-error').removeClass('corrects').show();
		}
	});
	
    $('input[name="repassword"]').inspect({
		'min': min,
        'pass':'input[name="password"]',
		'success': function() {
			var $wrap = this;
			$wrap.next('.error').html('').addClass('corrects').removeClass('text-error').show();
		},
		'error': function(e) {
			var $wrap = this;
			$wrap.next('.error').html(e).addClass('text-error').removeClass('corrects').show();
		}
	});

	//检查表单
	$('#user_form').forminspect({
		'success': function() {},
		'error': function() {
		},
		'onsubmit': function(json) {

			json = $.parseJSON(json);
			if (json.code == '0') {
				$.comfirm(json.message).onok(function(){
					window.location.href = json.data.href;	
				});
			} else {
				if (json.data) {
					for (var key in json.data) {
						if (json.data[key]) $('[name="' + key + '"]').next('.error').addClass('text-error').removeClass('corrects').html(json.data[key]).show();
					}
				}
			}
			return false;

		}
	});

	/* 删除列表二次确认 */
	$('body').on('click', 'a[action-type="act-user-del"]', function(e) {
		e.preventDefault();

		var $this = $(this);
		var url = $this.attr('href');

		var $card = $.comfirm('删除后无法找回，确定要将该用户删除吗?').onok(function(e) {
			$.getJSON(url, function(json) {
				if(json.code == 0){
					$this.closest('tr').remove();
					message.success(json.message);
				}else{
					message.success(json.message);
				}
			});
		});

		return false;
	});

}(jQuery));
