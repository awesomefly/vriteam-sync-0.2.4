var $trigger = $({});
var $ialert = $.alert('').close();
var $config = {
  'id': parseInt(getParamValue('id'))
};

;(function($) {

	var $choose_file_template = '';
	var $sync_file_template = '';
	var $isynccard = '同步文件';
	var $wrap = $('#detail_list');

	$trigger.on('history', function(e) {
		var data = { 'id' : $config.id };
		
		;(function() {
			var $wrap = $('.seeList');
			var url = 'index.php?mod=web.ticket&act=history';
			$.post(url, data, function($data) {
				$data = $.parseData($data);
				var type = $.type($data);

				if (type == 'object') {
					$wrap.html($data.data);
				}

				if (type == 'string') {
					$wrap.html($data);
				}
			});
		}());
		
		;(function() {
			var $wrap = $('.present');
			var url = 'index.php?mod=web.ticket&act=sumary';
			$.post(url, data, function($data) {
				$data = $.parseData($data);
				var type = $.type($data);

				if (type == 'object') {
					$wrap.html($data.data);
				}

				if (type == 'string') {
					$wrap.html($data);
				}
			});
		}());
	});

	/*选择文件*/
	$('a[action-type="act-sync-file"]').on('click', function(e) {

		e.preventDefault();
		var $this = $(this);
		var url = $this.attr('href');

		if (!$this.data('icard')) {

			$isynccard = $.icard({
				'class': 'i-team-dialog-file',
				'title': $this.html(),
				'countent': '',
				'width': 920,
				'mask': true
			}).show().align();

			$this.data('icard', $isynccard);

		} else {
			$isynccard = $this.data('icard');
			$isynccard.content('').show().align();
		}

		if (true) {
			$.post(url, function($data) {
				$data = $.parseData($data);
				var type = $.type($data);
				if (type == 'object') {
					if ($data.code == 0) {
						$sync_file_template = $data.data;
						$isynccard.content($sync_file_template).align();
					} else {
						$isynccard.content($data.message);
					}
				}

				if (type == 'string') {
					$sync_file_template = $data;
					$isynccard.content($sync_file_template).align();
				}

			});
		} else {
			$isynccard.content($sync_file_template);
		}

	});

	/*保存文件*/
	$('body').on('click', 'a[action-type="act-sync"]', function(e) {
		var $request = null;
		if ($request) return false;

		var option = {
			'success': function($data) {

				$data = $.parseData($data);
				//处理拿到的结果，如果是json返回json,如果是html，返回html
				var type = $.type($data);
				//检测数据类型
				if (type == 'object') {
					if ($data.code == 0) {
						$isynccard.content($data.data).align();
						$trigger.trigger('history');
					} else {
						$.alert($data.message);
					}
				}

				if (type == 'string') {
					$trigger.trigger('history');
					$isynccard.content($data).align();
				}
			}
		}
		$('#act-sync').attr('action','/index.php?mod=web.ticket&act=sync_files&id=' + $config.id).ajaxSubmit(option);
	});
	
	/*回滚*/
	$('body').on('click', 'a[action-type="act-rollback"]', function(e) {
		var $request = null;
		if ($request) return false;

		var option = {
			'success': function($data) {

				$data = $.parseData($data);
				//处理拿到的结果，如果是json返回json,如果是html，返回html
				var type = $.type($data);
				//检测数据类型
				if (type == 'object') {
					if ($data.code == 0) {
						$isynccard.content($data.data).align();
						$trigger.trigger('history');
					} else {
						$.alert($data.message);
					}
				}

				if (type == 'string') {
					$trigger.trigger('history');
					$isynccard.content($data).align();
				}
			}
		}
        $.comfirm('确认要回滚到本次上线前的状态吗？').onok(function(){
		  $('#act-sync').attr('action','/index.php?mod=web.ticket&act=rollback&id=' + $config.id).ajaxSubmit(option);
        });
	});

	/*执行脚本*/
	$('a[action-type="act-run-file"]').on('click', function(e) {

		e.preventDefault();
		var $this = $(this);
		var url = $this.attr('href');

		if (!$this.data('icard')) {

			$isynccard = $.icard({
				'class': 'i-team-dialog-file',
				'title': $this.html(),
				'countent': '',
				'width': 920,
				'mask': true
			}).show().align();

			$this.data('icard', $isynccard);

		} else {
			$isynccard = $this.data('icard');
			$isynccard.content('').show().align();
		}

		if (true) {
			$.post(url, function($data) {
				$data = $.parseData($data);
				var type = $.type($data);
				if (type == 'object') {
					if ($data.code == 0) {
						$sync_file_template = $data.data;
						$isynccard.content($sync_file_template).align();
					} else {
						$isynccard.content($data.message);
					}
				}

				if (type == 'string') {
					$sync_file_template = $data;
					$isynccard.content($sync_file_template).align();
				}
				var $path = $('#s_path').text();
				alert($path);
				document.getElementById("sh_path").value=$path;

			});
		} else {
			$isynccard.content($sync_file_template);
		}

	});

	/*添加脚本浮层*/
    var $ishell = '';
	$('a[action-type="act-add-shellpath"]').on('click', function(e) {
        
		e.preventDefault();
		var $this = $(this);
		var url = $this.attr('href');

		$ishell = $.icard({
			'class': 'i-team-dialog-chron',
			'title': $this.html(),
		  	'countent': '',
		  	'width': 920,
		  	'mask': true
		}).show().align();


		if (true) {
			$.post(url, function($data) {
				$data = $.parseData($data);
				var type = $.type($data);
				if (type == 'object') {
					if ($data.code == 0) {
						$ishell.content($data.data).align();
						$('input[name="path"]').focus().click();
					} else {
						$.alert($data.message);
					}
				}

				if (type == 'string') {
					$icard.content($data.data).align();
				}
			
			});
		} else {
			$icard.content($data.data);
		}

	});

	/*保存添加脚本记录*/
	$('body').on('click', 'a[action-type="act-save-shell"]', function(e) {
		var $request = null;
		var $data = {
			'path': $('#add-shell').find('input[name="path"]').val()
		};
		if ($request) return false;
		var options = {
			'success': function($data) {
				$data = $.parseData($data);
				var type = $.type($data);
				if (type == 'object') {
					if ($data.code == 0) {
						$('.ajax-callback-list').html($data.data);
					} else {
						$('.ajax-callback-list').html($data.message);
					}
				}

				if (type == 'string') {
					$('.ajax-callback-list').html($data);
				}
				$ishell.align();
				$('#act-save').prepend('<input type="hidden" name="pname" value="' + $pname + '">');
			}
		}

		var $pname = $('#add-shell').find('select[name="pname"]').val();
		if ($pname == 'undefined') return false;
		$request = true;
		
		var $spath = $('#add-shell').find('input[name="path"]').val();
		$('#s_path').html($spath);
		$ishell.close();
		//$('#add-shell').ajaxSubmit(options);

	});
	
    
 

	/*执行*/
	$('body').on('click', 'a[action-type="act-run-shell"]', function(e) {
		var $request = null;
		if ($request) return false;

		var option = {
			'success': function($data) {

				$data = $.parseData($data);
				//处理拿到的结果，如果是json返回json,如果是html，返回html
				var type = $.type($data);
				//检测数据类型
				if (type == 'object') {
					if ($data.code == 0) {
						$isynccard.content($data.data).align();
						$trigger.trigger('history');
					} else {
						$.alert($data.message);
					}
				}

				if (type == 'string') {
					$trigger.trigger('history');
					$isynccard.content($data).align();
				}
			}
		}
		$('#act-run').attr('action','/index.php?mod=web.ticket&act=run_shell&id=' + $config.id).ajaxSubmit(option);
	});
	
    var $ifile = '';
	/*选择文件*/
	$('a[action-type="act-choose-file"]').on('click', function(e) {
        
		e.preventDefault();
		var $this = $(this);
		var url = $this.attr('href');

		$ifile = $.icard({
			'class': 'i-team-dialog-chron',
			'title': $this.html(),
		  	'countent': '',
		  	'width': 920,
		  	'mask': true
		}).show().align();


		if (true) {
			$.post(url, function($data) {
				$data = $.parseData($data);
				var type = $.type($data);
				if (type == 'object') {
					if ($data.code == 0) {
						$ifile.content($data.data).align();
						$('input[name="version"]').focus().click();
					} else {
						$.alert($data.message);
					}
				}

				if (type == 'string') {
					$icard.content($data.data).align();
				}

			});
		} else {
			$icard.content($data.data);
		}

	});

	/*选择文件*/
	$('body').on('click', 'a[action-type="act-browse-file"]', function(e) {
		var $request = null;
		var $data = {
			'version': $ifile.find('input[name="version"]').val()
		};
		if ($request) return false;

		var options = {
			'success': function($data) {
				$data = $.parseData($data);
				var type = $.type($data);
				if (type == 'object') {
					if ($data.code == 0) {
						$('.ajax-callback-list').html($data.data);
					} else {
						$('.ajax-callback-list').html($data.message);
					}
				}

				if (type == 'string') {
					$('.ajax-callback-list').html($data);
				}
				$ifile.align();
				$('#act-save').prepend('<input type="hidden" name="pname" value="' + $pname + '">');
				$('.act-choose input[action-type="all"]').icheck({
					'targets': '.i-team-dialog-chron .act-file-list',
					'type': 'all'
				});
				$('.act-choose input[action-type="reverse"]').icheck({
					'targets': '.i-team-dialog-chron .act-file-list',
					'type': 'reverse'
				});
				$request = null;
			}
		}

		var $pname = $('#select-file').find('select[name="pname"]').val();
		if ($pname == 'undefined') return false;
		$request = true;
		$('#select-file').ajaxSubmit(options);

	});
	
    
    
    /*删除文件*/
	$('a[action-type="act-delete-file"]').on('click', function(e) {
		
		var $this = $(this);

		var $delcard = $.icard({
			'class': 'i-dialog',
			'title': '确认',
			'content': '您确认要删除这些文件么？',
			'width': 400,
			'mask': true
		}).show().align();

		$delcard.onok(function() {
			$('#detail_list').ajaxSubmit({
				'success': function($data) {
					$data = $.parseData($data);
					var type = $.type($data);
					if (type == 'object') {
						if ($data.code == 0) {
							$wrap.html($data.data);
							$trigger.trigger('history');
							$('.handy input[action-type="all"]').icheck({
								'targets': '.fileList',
								'type': 'all'
							});
							$('.handy input[action-type="reverse"]').icheck({
								'targets': '.fileList',
								'type': 'reverse'
							});
						} else {
							$.alert($data.message);
						}
					}

					if (type == 'string') {
						$wrap.html($data);
						$trigger.trigger('history');
						$('.handy input[action-type="all"]').icheck({
							'targets': '.fileList',
							'type': 'all'
						});
						$('.handy input[action-type="reverse"]').icheck({
							'targets': '.fileList',
							'type': 'reverse'
						});
					}
				}
			});
		});

	});


	/*菜单联动*/
	$('body').on('change', 'select[action-type="act-pro-select"]', function(e) {
		var $this = $(this);
		var $data = {
			'id': $this.val()
		};
		var $request = null;
		if ($request) return false;

		$request = $.post('index.php?mod=web.ticket&act=select_project', $data, function($data) {
			$data = $.parseData($data);
			var type = $.type($data);
			if (type == 'object') {
				$this.next('select').remove();
				if ($data.code == 0) {
					$this.after($data.data);
				} else {
					$.alert($data.message);
				}
			}

			if (type == 'string') {
				$this.next('select').remove();
				$this.after($data);
			}

			$request = null;
		});
	});

	/*保存文件*/
	$('body').on('click', 'a[action-type="act-save-choose"]', function(e) {
		var $request = null;
		if ($request) return false;

		var option = {
			'success': function($data) {
				$data = $.parseData($data);
				var type = $.type($data);
				if (type == 'object') {
					if ($data.code == 0) {
						$('#detail_list').html($data.data);
						$trigger.trigger('history');
						$('.handy input[action-type="all"]').icheck({
							'targets': '.fileList',
							'type': 'all'
						});
						$('.handy input[action-type="reverse"]').icheck({
							'targets': '.fileList',
							'type': 'reverse'
						});
						$ifile.close();
					} else {
						$.alert($data.message);
					}
				}

				if (type == 'string') {
					$('#detail_list').html($data);
					$trigger.trigger('history');
					$('.handy input[action-type="all"]').icheck({
						'targets': '.fileList',
						'type': 'all'
					});
					$('.handy input[action-type="reverse"]').icheck({
						'targets': '.fileList',
						'type': 'reverse'
					});
					$ifile.close();
				}

			}
		}
		$('#act-save').ajaxSubmit(option);
	});

	$('body').on('click', 'a[action-type="act-history-detal"]', function(e) {
		var $this = $(this);
		var $url = $this.attr('href');
		if (!$this.data('detail')) {
			$.post($url, function($data) {
				$data = $.parseData($data);
				var type = $.type($data);
				if (type == 'object') {
					if ($data.code == 0) {
						$this.closest('span').after($data.data);
						$this.data('detail', $data.data);
					} else {
						$.alert($data.msg);
					}
				}

				if (type == 'string') {
					$this.closest('span').after($data);
					$this.data('detail', $data);
				}
			});
		}

		if ($this.closest('span').next('.details').is(':hidden')) {
			$this.closest('span').next('.details').show();
		} else {
			$this.closest('span').next('.details').hide();
		}

	});

}(jQuery));

(function($) {
	if ($.fn.icheck) return false;
	$.fn.icheck = function(settings) {
		var defaults = {};
		var opts = $.extend(defaults, settings);
		return $(this).each(function() {

			var $target = $(opts.targets).find('input[type="checkbox"]');
			if (opts.type == 'all') {
				$(this).on('click', function() {
					$(this).is(':checked') ? $target.attr('checked', 'checked') : $target.removeAttr('checked');
					$(this).next('input').removeAttr('checked');
				});
			}

			if (opts.type == 'reverse') {
				$(this).on('click', function() {
					$(this).prev('input').removeAttr('checked');
					$target.each(function() {
						$(this).is(':checked') ? $(this).removeAttr('checked') : $(this).attr('checked', 'checked');
					});
				});
			}

		});
	}

	$('.handy input[action-type="all"]').icheck({
		'targets': '.fileList',
		'type': 'all'
	});

	$('.handy input[action-type="reverse"]').icheck({
		'targets': '.fileList',
		'type': 'reverse'
	});

}(jQuery));

;
(function($) {

	$.hotkeys.add('Ctrl+a', function() {
		$('input[action-type="all"]').trigger('click');
	});

	$.hotkeys.add('Ctrl+i', function() {
		$('input[action-type="reverse"]').trigger('click');
	});

	$.hotkeys.add('esc', function() {
		$('.i-dialog-close').trigger('click');
	});

}(jQuery));

;(function($){
    
  $('a[action-type="act-get-help"]').on('click',function(){
    
      var $wrap = $('.helpExplain');
      var $url = 'index.php?mod=web.ticket&act=help';
      
      if($wrap.is(':visible')){
          $wrap.hide();
      }else{
        $wrap.show();
        $.post($url, function(json){
          json = $.parseJSON(json);
          if(json.code == '0'){
            $('.helpExplain').html($(json.data).find('span'));
          }
        }); 
      
      }

    }); 
    
}(jQuery));
