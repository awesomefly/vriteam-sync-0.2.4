;(function(){
	//对话框
	$.icard({'title':'标题','content':'详细使用请查看jquery\.icard\.js和login.js,样式支持定制，这里只写了一个简单的样式.\n$.icard({"title":"标题","content":"内容","class":"i-classname","width":500})','class':'i-dialog','width':400}).show().align();
	//关闭按钮提示
	$('.i-dialog-close').itips({'content':'点击关闭','width':120,'class':'i-simple-tips'});
	//提示层
	$('.head-min h1 a').itips({
		'content':'详细请查看\:jquery.\icard\.js',
		'class':'i-simple-tips',
		'width':150
	});
}());
