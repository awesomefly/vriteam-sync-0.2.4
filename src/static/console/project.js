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
	$('input[name="project_name"]').inspect({
		'min': 1,
		'success': function() {
			var $wrap = this;
			$wrap.next('.error').html('').addClass('corrects').removeClass('text-error').show();
		},
		'error': function() {
			var $wrap = this;
			$wrap.next('.error').html('项目名称不能为空！').addClass('text-error').removeClass('corrects').show();
		}
	});

	//检查表单
	$('#project_form').forminspect({
		'success': function() {},
		'error': function() {
			//message.success('表单有选项不合法，请检查之后再提交');
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

	$('select[name="group_id"], select[name="group_id"]').inspect({
		'success': function() {
			var $wrap = this;
			$wrap.next('.error').html('').addClass('corrects').removeClass('text-error').show();
		},
		'error': function() {
			var $wrap = this;
			$wrap.next('.error').html('项目组不能为空！').addClass('text-error').removeClass('corrects').show();
		}
	});

	$('select[name="server_svn"], select[name="server_svn"]').inspect({
		'success': function() {
			var $wrap = this;
			$wrap.next('.error').html('').addClass('corrects').removeClass('text-error').show();
		},
		'error': function() {
			var $wrap = this;
			$wrap.next('.error').html('svn服务器不能为空！').addClass('text-error').removeClass('corrects').show();
		}
	});

	$('.i-checkbox-inspect').inspect({
		'type': 'checkbox',
		'success': function() {
			var $wrap = this;
			$wrap.next('.error').html('').addClass('corrects').removeClass('text-error').show();
		},
		'error': function() {
			var $wrap = this;
			$wrap.next('.error').html('文件服务器不能为空！').addClass('text-error').removeClass('corrects').show();
		}
	});


	/* 提示信息*/
	$('tr[action-type="act-server-info"]').itips({
		'class': 'i-team-tips filter-drop-shadow',
		'title': '服务器内容',
		'content': '<ul><li>服务器信息：php服务器</li><li>服务器信息：php服务器</li><li>服务器信息：php服务器</li></ul>',
		'width': 400
	});

	/*  删除列表二次确认 */
	$('body').on('click', 'a[action-type="act-project-del"]', function(e) {
		e.preventDefault();
		var $this = $(this);
		var url = $this.attr('href');

		var $card = $.comfirm('确认删除?').onok(function(e) {
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
