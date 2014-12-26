/**
	
	@lishouyan last:2013/04/18

	@released : 
	
	var $tips = $('.class-name').itips({
		'title':'your title',		//标题
		'content':'any things', 	//内容填充
		'class':'your-class-style', //自定义样式
		'width':500					//宽度
	});

	$tips.content(json.data.html);	//填充内容
	$tips.align($target);			//对齐位置
	$tips.close()					//关闭
		//实现一级事件
		.onok(fn);
		.oncancle(fn);
		.oncontent(fn);

*/

function getParamValue(_2b) {
	var q = document.location.search || document.location.hash;
	if (_2b == null) {
		return q;
	}
	if (q) {
		var _2d = q.substring(1).split("&");
		for (var i = 0; i < _2d.length; i++) {
			if (_2d[i].substring(0, _2d[i].indexOf("=")) == _2b) {
				return _2d[i].substring((_2d[i].indexOf("=") + 1));
			}
		}
	}
	return "";
};

;(function($) {
	if ($.parseDate) return false;
	$.parseData = function(data) {
		try {
			return data = $.parseJSON(data);
		} catch (e) {
			return data;
		}
	}
}(jQuery));

;(function($, win) {

	if ($.icard) return false;

	var $win = $(win),
		$body = $('body');

	$.icard = function(settings) {

		var defaults = {
			'align': null,
			'title': '标题',
			'content': '内容',
			'mask': false,
			'drag': true,
			'onok': false,
			'oncancle': false,
			'oncontent': false,
			'onalign': false,
			'context': $this,
			'focus':false
		}

		var opts = $.extend(defaults, settings);

		var html = [
				'<div class="i-dialog-wrap ', opts['class'], '" style="display:none">',
					'<div class="i-dialog-arrow">◆</div>',
					'<div class="i-dialog-title clearfix">',
						'<span>', opts['title'], '</span><i class="i-dialog-close icon-remove"></i>',
					'</div>',
					'<div class="i-dialog-content">', opts['content'], '</div>',
					'<div class="i-dialog-control clearfix">',
						'<a class="i-dialog-true btn btn-success" href="javascript:;" role="button">确定</a><a class="i-dialog-cancle btn" href="javascript:;">取消</a>',
					'</div>',
				'</div>'
		].join('');

		var $mask = '';
		if (opts.mask) {
			$mask = $('<div class="mask"></div>');
			$mask.css({
				'height': 1000,
				'width': 2000,
				'top':0,
				'left':0,
				'opacity': 0.8,
				'z-index': 99999,
				'background': '#000',
				'position': 'fixed'
			});
		}

		var $this = $(html);
		
		if(opts.width){
			$this.css({ 'width': opts.width });
		}

		//创建观察者模式的分发者
		var $trigger = $({});

		$trigger.on('ok cancle content align', function(e) {

			if ($.isFunction(opts.oncancle) && e.type == 'cancle') {
				opts.oncancle.apply($this, Array.prototype.slice.call(arguments, 1));
			}

			if ($.isFunction(opts.onok) && e.type == 'ok') {
				opts.onok.apply($this, Array.prototype.slice.call(arguments, 1));
			}

			if ($.isFunction(opts.oncontent) && e.type == 'content') {
				opts.oncontent.apply($this, Array.prototype.slice.call(arguments, 1));
			}
			
			if ($.isFunction(opts.onalign) && e.type == 'align') {
				opts.onalign.apply($this, Array.prototype.slice.call(arguments, 1));
			}

			if (e.type == 'ok' || e.type == 'cancle') {
				$this.close();
			}

		});
		//观察者结束

		var $arrow = $this.find('.i-dialog-arrow');

		//method : content
		$this.getRects = function(targets, e) {
			var Rects = null;

			targets = targets ? targets[0] : $this[0];
			if (e) {
				var targetsx = e.clientX;
				Rects = targets.getClientRects();
				for (var i = 0, len = Rects.length, index = 0; i < len; i++) {
					if ((Rects[i].left < targetsx) && (targetsx < Rects[i].right)) index = i;
				}
				return Rects[index];
			} else {
				Rects = targets.getBoundingClientRect();
				return Rects;
			}
		}

		// align : tips.
		$this.align = function($targets, e) {

			//$this.show();
			if (opts.mask) {
				$mask.show();
			}
			//$this is $tips
			if (!$this.is(':visible')) return;

			var $tipRect = $this.getRects();
			var width = $tipRect.right - $tipRect.left,
				height = $tipRect.bottom - $tipRect.top;

			var viewport = {
				'height': $win.height(),
				'width': $win.width()
			}

			var offset = {};
			var $targetRects = {};

			if ($targets) {

				$targetRects = $this.getRects($targets, e);

				//var $arrow_pos_left = parseInt( $arrow.position().left + $arrow.width()/2 );
				var $arrow_pos_left = parseInt((width - $arrow.width()) / 2);

				$arrow.css({
					'left': $arrow_pos_left
				});
				offset.left = $targetRects.left + parseInt(($targetRects.right - $targetRects.left - width) / 2);

				if (offset.left + width > viewport.width) {
					offset.left = viewport.width - width;
					$arrow.css({
						'left': $targetRects.left + parseInt(($targetRects.right - $targetRects.left) / 2) - offset.left - $arrow.width() / 2
					});
				}

				if (offset.left < 0) {
					offset.left = 0;
					$arrow.css({
						'left': $targetRects.left + parseInt(($targetRects.right - $targetRects.left - $arrow.width()) / 2)
					});
				}

				if ((viewport.height - $targetRects.bottom) >= $targetRects.top) {
					// if offset is bottom more .
					offset.top = $targetRects.top + $win.scrollTop() + $targetRects.height + ($arrow.height() / 2);
					$arrow.css({
						'top': -($arrow.height() / 2),
						'bottom': ''
					});

				} else {
					// if offset is top more.
					offset.top = $targetRects.top + $win.scrollTop() - height - ($arrow.height() / 2);
					$arrow.css({
						'top': '',
						'bottom': -($arrow.height() / 2)
					});

				}

			} else {

				offset.left = parseInt((viewport.width - width) / 2);
				offset.top = parseInt((viewport.height - height) / 2);
			}

			$this.css(offset);

			$trigger.trigger('align');
			return this;
		}

		//method : content
		$this.content = function(html) {
			$this.find('.i-dialog-content').html(html);
			$trigger.trigger('content');
			return this;
		}

		$this.close = function() {
			$this.hide();
			if (opts.mask) {
				$mask.hide();
			}
			return this;
		}

		$this.onok = function(fn) {
			if ($.isFunction(fn)) opts.onok = fn;
			return this;
		}

		$this.cancle = function(fn) {
			if ($.isFunction(fn)) opts.oncancle = fn;
			return this;
		}

		$this.oncontent = function(fn) {
			if ($.isFunction(fn)) opts.oncontent = fn;
			return this;
		}
		
		$this.onalign = function(fn) {
			if ($.isFunction(fn)) opts.onalign = fn;
			return this;
		}

		/* onok oncancle event bind */
		$this.find('.i-dialog-close, .i-dialog-cancle').bind('click', function() {
			$trigger.trigger('cancle');
		});

		$this.find('.i-dialog-true').bind('click', function(e) {
			$trigger.trigger('ok');
		});

		$.idrag($this.find('.i-dialog-title'), $this);
		$body.prepend($mask).prepend($this);

		return $this;

	}


}(jQuery, window));

;
(function($) {

	if ($.fn.icard) return false;

	$.fn.icard = function(settings) {

		var $this = this;
		var defaults = {};
		var opts = $.extend(defaults, settings);

		this.each(function() {

			var $this = $(this);
			var $card = $.icard(opts);

			$this.data({
				'icard': $card
			});

			$this.bind('click', function(e) {
				$card.show().align();
			});

		});

		return this;
	}
}(jQuery));

;
(function($) {

	if ($.fn.itips) return false;

	$.fn.itips = function(settings) {

		var mintime = 200;
		var $this = this;
		var defaults = {
			'delay': mintime
		};
		var opts = $.extend(defaults, settings);

		if (opts.delay < mintime) opts.delay = mintime;


		this.each(function() {

			var $this = $(this);
			var $card = $.icard(opts);
			var timer = null;

			$this.data({
				'itips': $card
			});

			$this.bind('mouseenter', function(e) {
				clearTimeout(timer);
				timer = setTimeout(function() {
					$card.show().align($this, e);
				}, opts.delay);
			});

			$this.bind('mouseleave', function(e) {
				clearTimeout(timer);
				timer = setTimeout(function() {
					$card.close();
				}, opts.delay / 2);
			});


			$card.bind('mouseenter', function(e) {
				clearTimeout(timer);
			});

			$card.bind('mouseleave', function(e) {
				clearTimeout(timer);
				timer = setTimeout(function(e) {
					$card.close();
				}, opts.delay / 2);
			});

		});

		return this;
	}
}(jQuery));

;
(function($) {
	$.getEventOffset = function(e) {
		return {
			'left': e.clientX,
			'top': e.clientY
		};
	}

	$.idrag = function($target, $wrap) {
		var isDrag = false;
		var start = {};

		function drag(e) {
			e.preventDefault();
			switch (e.type) {
				case 'mousedown':
					isDrag = true;
					start.x = e.clientX - $wrap.offset().left;
					start.y = e.clientY - $wrap.offset().top;
					if($.browser.mozilla) start.y += $('body').scrollTop();
					
				break;
				case 'mousemove':
					if (isDrag) {
						$wrap.css({'position':'absolute'});
						offset = $.getEventOffset(e);
						offset.left -= start.x;
						offset.top -= start.y;
						$wrap.css(offset);
					}
				break;
				case 'mouseup':
					isDrag = false;
				break;
				default:
			}
		}
		$target.on('mousedown mouseup', function(e) {
			drag(e);
		});
		$('body').on('mousemove', function(e){
			drag(e);
		});
	}

	$.fn.idrag = function() {
		$(this);
	}
}(jQuery));

;
(function($) {
	if ($.theme) return false;
	$.theme = function() {
		$('#change-theme')
			.after('<link rel="stylesheet" type="text/css" href="./static/core/css/common.theme.css">')
			.after('<link rel="stylesheet" type="text/css" href="./static/core/css/bootstrap.css">');
	}

}(jQuery));

(function($) {
	$.alert = function(msg) {
		return 	$.icard({
			'class': 'i-alert',
			'title': '确定',
			'content': '',
			'width': 400,
			'mask': true,
			'drag': true
		}).onalign(function(){
			this.find('.i-dialog-true').focus();
		}).content(msg).show().align();
	}
}(jQuery));

(function($) {
	$.comfirm = function(msg) {
		return 	$.icard({
			'class': 'i-comfirm',
			'title': '确定',
			'content': '',
			'width': 400,
			'mask': true,
			'drag': true
		}).onalign(function(){
			this.find('.i-dialog-true').focus();
		}).content(msg).show().align();
	}
}(jQuery));

(function($) {
	$.message = function(msg) {
		return 	$.icard({
			'class': 'i-message',
			'content': '',
			'width': 400
		}).content(msg).show().align().delay(2000).fadeOut()//.close();//.delay(3000).close();
	}
}(jQuery));

(function($) {
	$.ierror = function(msg) {
		return 	$.icard({
			'class': 'i-error',
			'content': msg,
			'width': 400
		}).show().align();
	}
}(jQuery));

(function(){

	$.fn.placeholder = function (param) {
		var defaults = {},
		opts = $.extend({}, defaults, param);
		return this.each(function() {
			var $this = $(this),
			text = $this.attr('action-data');
			$this.val(text);
			$this.bind('focus blur click', function(e) {
				switch (e.type) {
					case 'focus':
						if ($.trim($this.val()) == text)
						$this.val('');
						break;
					case 'blur':
						if ($.trim($this.val()) == '')
						$this.val(text);
						break;
					default:
				}
			});
		});
	}

}());
