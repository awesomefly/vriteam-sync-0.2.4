/* 表单验证插件 @lishouyan */
(function($) {

	if ($.fn.inspect) return;

	var type = {
		'name': /x/ig,
		'num': /x/ig,
		'svn' :  /svn\:\/{2}(\d{1,3}\.){3}\d{1,3}/ig
	}

	var getLen = function(str) {
		str = str.replace(/[^\x00-\xff]/g, 'xx');
		return str.length;
	}

	function isURL(str_url){ 
		var strRegex = "^((https|http|ftp|rtsp|mms|svn)?://)"
		+ "?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?"
		+ "(([0-9]{1,3}\.){3}[0-9]{1,3}"
		+ "|"
		+ "([0-9a-z_!~*'()-]+\.)*"
		+ "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\."
		+ "[a-z]{2,6})"
		+ "(:[0-9]{1,4})?"
		+ "((/?)|"
		+ "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$"

		var re = new RegExp(strRegex);

		if (re.test(str_url)){
			return (true);
		}else{
			return (false);
		}
	}


	function msg(value) {
		this.attr('act-data', value);
	}

		//创建观察者模式的分发者
	var $trigger = $({});

	$trigger.on('success error', function(e, context, fn) {
		var arg = Array.prototype.slice.call(arguments, 3);
		
        fn.apply(context, arg);
		msg.call(context, e.type);
	});
	//观察者结束


	$.fn.inspect = function(settings) {
		
		
		if ($(this).length == 0) return $(this);

		return $(this).each(function() {

			var $this = $(this);
			var defaults = {
				'success': function() {},
				'error': function() {}
			}

			var opts = $.extend({}, defaults, settings);
			
			$this.attr('act-type', 'act-input-inspect');
			if(opts.type && opts.type == 'checkbox'){
				var $checkbox = $this.find('input[type="checkbox"]');
				$this.on('click inspect',function(){
					var isRight = true;	
					if(!$this.find('input[type="checkbox"]:checked').length){
						isRight = false;
					}else{
						isRight = true;
					}
					isRight ? $trigger.trigger('success', [$this, opts.success]) : $trigger.trigger('error', [$this, opts.error]);
				});
			}else{

			$this.on('blur inspect change', function() {

				var content = $this.val();
				var isRight = true;
				
				if ( opts.closest && $(this).closest(opts.closet).is(':hidden') ){
				  return;
				}

				if ( opts.max && getLen(content) > opts.max ){
                  $trigger.trigger('error', [$this, opts.error, '字数不能超过' + opts.max ]); 
                  return;
                
                }
				
                if ( opts.min > 0 && getLen(content) < opts.min ){
                  console.log(opts.min)
                  $trigger.trigger('error', [$this, opts.error, '不允许为空']); 
                  return;
                }
				
                if ( opts.type == 'url' && !isURL(content) ){
                  $trigger.trigger('error', [$this, opts.error, 'URL地址不合法']); 
				  return;
                }
                
                if ( opts.type == 'number' && !(/^\d+$/ig.test(content)) ){
                  $trigger.trigger('error', [$this, opts.error, '只允许输入数字']); 
				  return;
                }

                if( opts.pass){
                  if( $(opts.pass).val() != '' && $(opts.pass).val() != content ){
                    $trigger.trigger('error', [$this, opts.error, '两次输入的密码不一致']); 
                    $trigger.trigger('error', [$(opts.pass), opts.error, '两次输入的密码不一致']); 
                    return;
                  }else if($(opts.pass).val() != ''){
                    $trigger.trigger('success', [$this, opts.success]); 
                    $trigger.trigger('success', [$(opts.pass), opts.success]); 
                  }
                }
				
				if ( $this.get(0).tagName.toLowerCase() == 'select' && $this.val() == 0 ) {
				  isRight = false;
				}

				if ( opts.ajax ) {
					$.post(opts.ajax.url, opts.ajax.data, function(json) {
						trigger.onsubmit.call($form, json);
					});
				}

				isRight ? $trigger.trigger('success', [$this, opts.success]) : $trigger.trigger('error', [$this, opts.error]);

			});
			}

		});
	}

}(jQuery));


/* 表单验证插件 @lishouyan */
;
(function($) {

	if ($.fn.forminspect) return;

	$.fn.forminspect = function(settings) {

		if ($(this).length == 0) return $(this);

		var $form = $(this);
		//创建观察者模式的分发者
		var $trigger = $({});

		var defaults = {
			'success': function(e) {
			},
			'error': function(e) {
			},
			'onbeforeSubmit': function(e){
			},
			'onsubmit': function(e) {
			}
		}

		return $form.each(function() {

			var $this = $(this);
			var $inputs = $('input[act-type="act-input-inspect"]', $this);

			var opts = $.extend({}, defaults, settings);

			// egistration new event for formispect.
			$trigger.on('success error beforeSubmit submit', function(e) {
				if (e.type == 'success') {
					opts.success.call($form, e);
				}

				if (e.type == 'error') {
					opts.error.call($form, e);
				}

				if (e.type == 'beforeSubmit'){
					opts.onbeforeSubmit.call($form, e);
				}

				if (e.type == 'submit'){
					opts.onsubmit.apply($form, Array.prototype.slice.call(arguments, 1));
				}

			});

			// do submit.
			$this.on('submit', function(e) {
				e.preventDefault();
				e.stopPropagation();
				
						$('[act-type="act-input-inspect"]').trigger('inspect');

				var $error = $('.info-list:visible input[act-data="error"]');
				var options = {
					'success': function(json) {
						$trigger.trigger('submit',[json]);
					},
					'error': function() {
						$trigger.trigger('error');
					}
				}

				if ($error.length) {
					$trigger.trigger('error');
					return false;
				}

				$trigger.trigger('beforeSubmit');
						$this.ajaxSubmit(options);
				return false;

			});

		});
	}

}(jQuery));


;(function($){
	if($.fn.icheckbox) return;

	$.fn.ichechbox = function(settings){
		var defaults = {};
		var $this = $(this);
		return $this.each(function(){
		});
	}

	$('input[type="checkbox"]').ichechbox({});

}(jQuery));

