$(function(){
	textSingleUtil.regTag = true;
	textSingleUtil._init({popDomId:'initEmails',popInnerDomId:'emailList',effectId:'email',overClass:'ys',outClass:'xs',domHeight:30});
	registerCheck();
});

//用户注册表单
window.userFeild = {
	'username' : {
			id : '#username_msg',
			input : '#username',
			rule : 1, 
			msg: '5~15个字符，包括字母、数字、下划线<br />·字母和数字开头，字母和数字结尾，不区分大小写<br />',
			ok:'.ico-ok',
			error:'.ico-error',
			contentDom:'.info-pop', // 内容的父dom
			content:'.info-pop .cont', //内容DOM
			tip:'',//提醒文字
			tipCall:'',//提醒函数
			ajaxUrl: 'auth/check',//是否ajax请求
			ajaxParams:{type : 1},
			checkCall:checkUserName,//
		    success:successCheckCall,
		    errorCall:errorCheckCall,
			blurClass:'inp ipt-focus',
			successClass:'inp ipt-normal',
			tips:[
				'·5~15个字符，包括字母、数字、下划线<br />·字母和数字开头，字母和数字结尾，不区分大小写',
				'合法长度为5-15个字符',
				'用户名只能包含_,英文字母,数字'
			]
		}, 	
	'nickname' : {
			id : '#nickname_msg',
			input : '#nickname',
			rule : 1, 
			msg: '2－20个字符，支持中文、英文、数字、下划线',
			ok:'.ico-ok',
			error:'.ico-error',
			contentDom:'.info-pop', // 内容的父dom
			content:'.info-pop .cont', //内容DOM
			tip:'',//提醒文字
			tipCall:'',//提醒函数
			ajaxUrl: '',//是否ajax请求
			ajaxParams:{type : 1},
			checkCall:checkNickname,//
		    success:successCheckCall,
		    errorCall:errorCheckCall,
			blurClass:'inp ipt-focus',
			successClass:'inp ipt-normal',
			tips:[
				'2－20个字符，支持中文、英文、数字、下划线',
				'合法长度为2-20个字符',
				'2－20个字符，支持中文、英文、数字、下划线'
			]
		}, 	

}

//用户注册验证
function registerCheck()
{

	//默认状态
	defaultStatus();

	//用户名
	$('#username').blur(function(){
		var vailInput = window.userFeild['username'];	
		if(typeof vailInput['checkCall'] == 'function')
		{
			var result  =  vailInput['checkCall'](vailInput);
			if (!$.isArray(result)) return false;
			if (result[0] === 1)
			{
				if (vailInput['ajaxUrl'])
				{
					checkAjax(vailInput);				
				} 
				else
				{
					vailInput['success'] && vailInput['success'].apply(this,result.slice(1));
				}
			}
			else if (result[0] === 0)
			{
				setStatus.apply(this , result.slice(1) , 2);
			}
			else
			{
				vailInput['errorCall'] && vailInput['errorCall'].apply(this,result.slice(1));
			}
			
		}
	});

	//昵称
	$('#nickname').focus(function(){
		var vailInput = window.userFeild['nickname'];	
		setStatus(vailInput , vailInput['msg'] , 2);	
	}).blur(function(){
		var vailInput = window.userFeild['nickname'];	
		if(typeof vailInput['checkCall'] == 'function')
		{
			var result  =  vailInput['checkCall'](vailInput);
			console.info(result);
			if (!$.isArray(result)) return false;
			if (result[0] === 1)
			{
				if (vailInput['ajaxUrl'])
				{
					checkAjax(vailInput);				
				} 
				else
				{
					vailInput['success'] && vailInput['success'].apply(this,result.slice(1));
				}
			}
			else if (result[0] === 0)
			{
				console.info('w');
				setStatus.apply(this , result.slice(1),1);
			}
			else
			{
				vailInput['errorCall'] && vailInput['errorCall'].apply(this,result.slice(1));
			}
			
		}
	});
}


function defaultStatus(vailObj , msg)
{
	var vailObj = vailObj || null;
	var feild = $.isEmptyObject(vailObj) ? window.userFeild:[vailObj];
	for(var i in feild)
	{
		if (!feild[i]['rule']) continue;
		var tmpVailObj = feild[i];	
	    $(tmpVailObj['id']).find(tmpVailObj['ok']).hide();
	    $(tmpVailObj['id']).find(tmpVailObj['error']).hide();
	    $(tmpVailObj['id']).show();
		//$(tmpVailObj['id']).find(tmpVailObj['contentDom']).show();
		/*if (msg)
		{
	    	$(tmpVailObj['id']).find(tmpVailObj['content']).html(msg);
		}
		*/
	}
}
//默认装态
function setStatus(vailObj , msg , hide)
{
			console.info(hide);
	var vailObj = vailObj || null;
	var feild = $.isEmptyObject(vailObj) ? window.userFeild:[vailObj];
	for(var i in feild)
	{
		if (!feild[i]['rule']) continue;
		var tmpVailObj = feild[i];	
	    $(tmpVailObj['id']).find(tmpVailObj['ok']).hide();
	    $(tmpVailObj['id']).find(tmpVailObj['error']).hide();
	    $(tmpVailObj['id']).show();
		if (hide == 1)
		{
			$(tmpVailObj['id']).find(tmpVailObj['contentDom']).hide();
		}	
		else
		{
			$(tmpVailObj['id']).find(tmpVailObj['contentDom']).show();
		}
		if (msg)
		{
	    	$(tmpVailObj['id']).find(tmpVailObj['content']).html(msg);
		}
	}

}

//公共错误处理函数
function errorCheckCall(vailObj , msg , call)
{
	if($.isEmptyObject(vailObj)) return false;	
	$(vailObj['id']).find(vailObj['ok']).hide();
	$(vailObj['id']).find(vailObj['error']).show();
	$(vailObj['id']).find(vailObj['contentDom']).show();
	$(vailObj['id']).find(vailObj['content']).html(msg);
	$.isFunction(call) && call();
}

//公共正确处理函数
function successCheckCall(vailObj, call)
{
	if($.isEmptyObject(vailObj)) return false;	
	$(vailObj['input']).attr('class', vailObj['successClass']);
	$(vailObj['id']).find(vailObj['ok']).show();
	$(vailObj['id']).find(vailObj['error']).hide();
	$(vailObj['id']).find(vailObj['contentDom']).hide();
	$(vailObj['id']).find(vailObj['content']).html('');
	$.isFunction(call) && call(vailObj);
}


//公共处理ajax函数
function checkAjax(vailObj , success , error)
{

	if ($.isEmptyObject(vailObj)) return false;
	var params = vailObj.ajaxParams;
	var inputVal = $.trim($(vailObj['input']).val());
	var key = vailObj['input'].replace('#' , '');
	params[key] = inputVal;
	console.info(vailObj);
	$.ajax({
			url: window.siteUrl+vailObj['ajaxUrl'],
			type: 'post',
			data:params,
			dataType: 'json',
			/*error: function() {
			  alert('查询用户名出错!');
			  },*/
			success: function(result) {
				if (result.r) {
					if ($.isFunction(success))
					{
						success(result);
					}
					else
					{
						vailObj['success'] && vailObj['success'](vailObj);
					}
					/*
					$("#username").attr("class", "inp ipt-normal");
					$("#uname_ico_err").hide();
					$("#uname_ico_ok").show();
					$("#div_uname_err").hide();
					$("#div_uname_err_info").html("");
					*/
				} else {
					if(parseInt(result.code,10) > 20000)
					{
						window.location.href = '/msg?code='+result.code;	
					}
					if($.isFunction(error))
					{
						error(result);
					}
					else
					{
						vailObj['errorCall'] && vailObj['errorCall'](vailObj , result.msg);
					}
					$(vailObj['input']).select();
					/*
					$("#uname_ico_err").show();
					$("#uname_ico_ok").hide();
					$("#div_uname_err").show();
					$("#div_uname_err_info").html("用户名已经存在");
					$("#username").select();
					*/
				}
			}
	});
}

//验证用户名
function checkUserName(vailObj)
{	
	if ($.isEmptyObject(vailObj)) return false;
	var username = $.trim($(vailObj['input']).val());
	var result = chkUserName(username);
	var msg = '';
	var tipCode = Math.abs(result);
	if (result === 0)
	{
		msg = vailObj['tips'][tipCode];	
	} 
	else if(result === -1)
	{
		msg = vailObj['tips'][tipCode];
	}
	else if(result === -2)
	{
		msg = vailObj['tips'][tipCode];
	}
	return [result , vailObj , msg];
} 

//昵称
function checkNickname(vailObj)
{
	if ($.isEmptyObject(vailObj)) return false;
	var nickname = $.trim($(vailObj['input']).val());
	var result = chkNickname(nickname);
	var msg = '';
	var tipCode = Math.abs(result);
	if (result === 0)
	{
		msg = '';	
	} 
	else if(result === -1)
	{
		msg = vailObj['tips'][tipCode];
	}
	else if(result === -2)
	{
		msg = vailObj['tips'][tipCode];
	}
	return [result , vailObj , msg];
}
