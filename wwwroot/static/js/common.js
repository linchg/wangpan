/***************************document ready***************************************/
//cookie
//about cookie function
var cookie = {
	set : function (name, value, seconds) {
		seconds = seconds || 0;
		var expires = "";
		if (seconds != 0 ) {
			var date = new Date();  
			date.setTime(date.getTime()+(seconds*1000));
			expires = "; expires="+date.toGMTString();
		}
		document.cookie = name+"="+escape(value)+expires+"; path=/";
	},
	get : function(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') {
				c = c.substring(1,c.length);
			}
			if (c.indexOf(nameEQ) == 0) {
				return unescape(c.substring(nameEQ.length,c.length));
			}
		}
		return false;
	},
	clear :function(name) {
		setCookie(name, "", -1);
	}
}

//popbox plugin
var popupBox = {
	lightBoxOpen : function(obj){
		var ops = $.extend({
			url : '',
			html : '',
			callback : null
		},obj);
		if(ops.url === "" && ops.html === ""){
			throw new Error("error");
		}
		var lightboxWidth,lightboxHeight,lightboxMarginTop,lightboxMarginLeft,top,left;
		var nowScroll=$(window).scrollTop();
		if(ops.url === "") {
			$("#lightBox").html(ops.html);
			$(window).scrollTop(nowScroll);
			$('#lightBox').css({"overflow":"visible"});
			lightboxWidth = $('#lightBox').innerWidth();
			lightboxHeight = $('#lightBox').innerHeight();
			lightboxMarginLeft = -Math.round(lightboxWidth/2);
			lightboxMarginTop= -Math.round(lightboxHeight/2);
			top = (($(window).height() / 2) - ($("#lightBox").outerHeight() / 2));
			left = (($(window).width() / 2) - ($("#lightBox").outerWidth() / 2));
			var rslt = navigator.appVersion.match(/MSIE (\d+\.\d+)/, '');
			var itsAllGood = (rslt != null && Number(rslt[1]) >= 5.5 && Number(rslt[1]) < 7.0);
			if (!itsAllGood){
				if(($(window).height()-$("#lightBox").outerHeight())<0){
					$("#lightBox").css({"position":"absolute"});
				} else {
					$("#lightBox").css({"position":"fixed"});
				}
			}
			if( $.browser.msie && parseInt($.browser.version) <= 6 ) {top = top + $(window).scrollTop();}
			if(top<0){
				top=$(window).scrollTop()+5;
			}

			$("#lightBox").removeClass('hide').css({top:top+'px',left:left+'px'});
			
			var bodyHeight = $(document).height();
			$("#lightBoxMask").removeClass('hide').height(bodyHeight);
			if( $.browser.msie && parseInt($.browser.version) <= 6 ) $("#maskIframe").height(bodyHeight);
			if (ops.callback != null){
				ops.callback.apply(this,arguments);
			}
			$('input.input_common1,input.input_common').each(function(){
				$(this).focus(function(){
					$(this).addClass('a_form_click');
				});
				$(this).blur(function(){
					$(this).removeClass('a_form_click');
				});
			});
		} else {
			$("#lightBox").html('').load(ops.url,function(){
				$(window).scrollTop(nowScroll);
				$('#lightBox').css({"overflow":"visible"});
				lightboxWidth = $('#lightBox').innerWidth();
				lightboxHeight = $('#lightBox').innerHeight();
				lightboxMarginLeft = -Math.round(lightboxWidth/2);
				lightboxMarginTop= -Math.round(lightboxHeight/2);
				top = (($(window).height() / 2) - ($("#lightBox").outerHeight() / 2));
				left = (($(window).width() / 2) - ($("#lightBox").outerWidth() / 2));
				var rslt = navigator.appVersion.match(/MSIE (\d+\.\d+)/, '');
				var itsAllGood = (rslt != null && Number(rslt[1]) >= 5.5 && Number(rslt[1]) < 7.0);
				if (!itsAllGood){
					if(($(window).height()-$("#lightBox").outerHeight())<0){
						$("#lightBox").css({"position":"absolute"});
					} else {
						$("#lightBox").css({"position":"fixed"});
					}
				}
				if( $.browser.msie && parseInt($.browser.version) <= 6 ) {top = top + $(window).scrollTop();}
				if(top<0){
					top=$(window).scrollTop()+5;
				}
	
				$(this).removeClass('hide').css({top:top+'px',left:left+'px'});
				
				var bodyHeight = $(document).height();
				$("#lightBoxMask").removeClass('hide').height(bodyHeight);
				
				if( $.browser.msie && parseInt($.browser.version) <= 6 ) $("#maskIframe").height(bodyHeight);
				if (ops.callback != null){
					ops.callback.apply(this,arguments);
				}
				$('input.input_common1,input.input_common').each(function(){
					$(this).focus(function(){
						$(this).addClass('a_form_click');
					});
					$(this).blur(function(){
						$(this).removeClass('a_form_click');
					});
				});
			});
		}
	},
    lightBoxClose : function(obj){
		var ops = $.extend({
            url : '',
            callback : null
        },obj);
        $("#lightBox").html('');
        $("#lightBoxMask").addClass('hide').css({height:0});
		if(ops.url != undefined && ops.url != '')
        {
            window.location = ops.url;
        }
        if (ops.callback!=undefined){
           ops.callback.apply(this,arguments);
        }
    }
}

//ajax plugin
var AjaxDI = {
    /**
    *ajax GET
    *@param obj{url:'',popSuccess:'',popError:'',successCallback:'',errorCallback:'',isLogin:''}
    **/
    ajaxCommitGet : function (obj){
		var ops = $.extend({
            url : '',
            popSuccess : 1,//0->不提示 1->提示
			popError : 1,//0->不提示 1->提示
			successCallback : null,
			errorCallback : null,
			isLogin:true
        },obj);
        if(ops.url === ""){
            throw new Error("error");
        }
       //block ui 
		//the9.waiting();
		if(ops.isLogin) {
			//TODO 校验登陆是否失效
		}
        $.getJSON(ops.url,function(json){
			//the9.waiting_close();
			if(ops.popSuccess != 1 || ops.popError != 1){
				$('.n_pop_overlayer').remove();
			}
            if(json.r === 'success')  {
                if (ops.popSuccess === 1){ the9.alert(json.m,1); };
                if (ops.successCallback != null) {ops.successCallback.apply( this,arguments)};
            } else {
                if (ops.popError === 1) { the9.alert(json.m,-1); };
                if (ops.errorCallback!= null) {ops.errorCallback.apply(this,arguments)};
            }
        });
    },
    /**
    *ajax POST
    *@param obj{formId:'',url:'',popSuccess:'',popError:'',successCallback:'',errorCallback:'',extraData:'',,isLogin:''}
    *
    **/
    ajaxCommitPost : function (obj){
		var ops = $.extend({
			formId : '',
			url : '',
			popSuccess : 1,//0->不提示 1->提示
			popError : 1,//0->不提示 1->提示
			successCallback : null,
			errorCallback : null,
			extraData : '',
			isGetFormData:true,//为false只接受extraData的参数
			isLogin:true,
			async:true
		},obj);
		if(ops.isGetFormData && ops.formId === "") {
			throw new Error("error");
		}
		if(!ops.isGetFormData && ops.url === ""){
			throw new Error("error");
		}
		/*
		if(!ops.isGetFormData && ops.extraData == "")
		{
			throw new Error("error");
		}
		*/
		if(ops.isGetFormData)
		{
			if(ops.extraData != ''){
				var dataPost = $('#'+ops.formId).serialize()+'&'+ops.extraData;
			}else{
				var dataPost = $('#'+ops.formId).serialize();
			}
		} else {
			var dataPost = ops.extraData;
		}
		if(ops.isLogin) {
			//TODO 校验登陆是否失效
		}
		//blockUi
		//the9.waiting();
		$.ajax({
			url : ops.url,
			type : "POST",
			dataType : 'json',
			data: dataPost,
			async: ops.async,
			success: function(json) {
				//the9.waiting_close();
				if(ops.popSuccess != 1 || ops.popError != 1){
					$('.n_pop_overlayer').remove();
				}
				if(json.r === 'success')  {
					if (ops.popSuccess === 1){ the9.alert(json.m,1); };
					if (ops.successCallback != null) {ops.successCallback.apply(this, arguments)};
				} else {
					if (ops.popError === 1) { the9.alert(json.m,-1); };
					if (ops.errorCallback!= null) {ops.errorCallback.apply(this, arguments)};
				}
			},
			error : function() {
				//the9.waiting_close();
				the9.alert('system busy',-1);
			}
		});
	},
    /**
    *ajax load
    *@param obj {domId:'',url:'',callback:''}
    *
    **/
    ajaxLoad : function(obj){
		var ops = $.extend({
			domId : '',
			url : '',
            callback : null
        },obj);
		if(ops.domId === "" || ops.url === ""){
            throw new Error("error");
        }
        $('#'+ops.domId).load(ops.url,function(){
            if (ops.callback != null){
                ops.callback.apply(this,arguments);
            }
        });
    },
    /**
    *ajax get json
    *@param obj {url:'',callback:''}
    **/
    ajaxGetJsondata : function(obj){
		var ops = $.extend({
			url : '',
            callback : null
        },obj);
		if(ops.url === ""){
            throw new Error("error");
        }
        $.getJSON(ops.url,function(json){
            if (ops.callback != null){
                ops.callback.apply(this,arguments);
            }
        });
    }
}

/******form check****/
var formCheck = {
    isEmail : function (str)
    {
        ereg = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9]+(-[a-zA-Z0-9]+)*(\.[a-zA-Z0-9]+[-a-zA-Z0-9]*)+[a-zA-Z0-9]+$/;
        if(!ereg.test(str)){
            return false;
        }
        return true;
    },
    isQq : function (str)
    {
		ereg = /^\d{5,11}$/;
		if(!ereg.test(str)) {
			return false;
		}
		return true;
    },
    isMobile : function (str)
    {
		ereg = /^(13|14|15|18)\d{9}$/;
		if(!ereg.test(str)) {
			return false;
		}
		return true;
    },
    isCardID : function (certid){
        var reg_15 = /\d{15}/;
		var reg_18 = /\d{17}([0-9]{1}|x|X)/;
		var monthPerDays = new Array("31","28","31","30","31","30","31","31","30","31","30","31");
		certid = certid.toLowerCase();
		if(certid == "" || certid=="111111111111111") {
			return 0;
		}
		var ret = certid.length == 15?reg_15.test(certid):reg_18.test(certid);
		if(!ret) {
			return 0;
		}
		birthDate = certid.length == 15?"19" + certid.substr(6,6):certid.substr(6,8);
		year = birthDate.substr(0,4);
		if(birthDate.substr(4,1) == '0')
			month = birthDate.substr(5,1);
		else
			month = birthDate.substr(4,2);
		if(birthDate.substr(6,1) == '0')
			day = birthDate.substr(7,1);
		else
			day = birthDate.substr(6,2);
		dd = parseInt(day);
		mm = parseInt(month);
		yy = parseInt(year);
		days = new Date();
		gdate = days.getDate();
		gmonth = days.getMonth();
		gyear18 = days.getFullYear()-18;
		if(mm>12 || mm<1 ||dd>31 || dd<1) {
			return 0;
		}
		if(year % 100 != 0) {
			if(year % 4 ==0)
			monthPerDays[1] = 29;
		}
		else {
			if(year % 400 == 0)
			monthPerDays[1] = 29;
		}
		if(monthPerDays[mm - 1] < dd) {
			return 0;
		}
		if(certid.length == 18) {
			var arTemp = new Array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
			var num = 0;
			var proof;
			for(var i=0; i < 17; i++) {
				num = num + certid.substr(i,1) * arTemp[i];
			}
			num = num % 11;
			switch(num) {
				case 0:proof='1';break;
				case 1:proof='0';break;
				case 2:proof='x';break;
				case 3:proof='9';break;
				case 4:proof='8';break;
				case 5:proof='7';break;
				case 6:proof='6';break;
				case 7:proof='5';break;
				case 8:proof='4';break;
				case 9:proof='3';break;
				case 10:proof='2';break;
			}
			if(certid.substr(17, 1) != proof) {
				return 0;
			}
		}
		mm = mm - 1;
		var prevTS18 = new Date(gyear18, gmonth, gdate,0,0,0);
		var ageTs = new Date(yy,mm,dd,0,0,0)
		if((prevTS18 < ageTs)) {
			return 1;
		}
		return 2;
    },
    strLen : function (str)
    {
		var cArr = str.match(/[^\x00-\xff]/ig);   
		return str.length + (cArr == null ? 0 : cArr.length);   
		
        return str.replace(/[^\x00-\xff]/ig, '__').length;
    },
    strSubString : function (str, len)
    {
        var stringLen = 0, textStr = '';
        var stringLen = this.strLen(str);
        if (stringLen > len)
        {
            return str.sub(len);
        } else {
            return str;
        }
    },
    isLetter : function (str)
    {
		var ereg = /[_a-zA-Z]/;
        if(!ereg.test(str)){
            return false;
        }
        return true;
    },
	isNumber : function (str)
    {
        var ereg = /^\d$/;;
        if(!ereg.test(str)){
            return false;
        }
        return true;
    },
	isLoginname : function (str)
    {
        var ereg = /^[A-Za-z0-9_\.\@\-]{3,50}$/;
        if(!ereg.test(str)){
            return false;
        }
        return true;
    },
	chkEmail: function(email,msg)
	{
		var _html = '';
		if(email == '') {
			_html = msg[0];
		}else if(email.length < 6 || email.length > 50){
			//校验email长度
			_html =  msg[1];
		}else if(!formCheck.isEmail(email)){
			//校验email格式
			_html =  msg[2];
		}
		return _html;
	},
	chkPwd : function(pwd,msg)
	{
		var validall = /^\w{6,16}$/;
		var _html = '';
		if(pwd == '') {
			_html = msg[0];
		}else if(!validall.test(pwd)) {
			_html = msg[1];
		}
		return _html;
	},
	chkConfirmPwd : function(oldPwd,pwd,msg)
	{
		var validall = /^\w{6,16}$/;
		var _html = '';
		if(oldPwd == '' && oldPwd == pwd) {
			_html =  msg[0];
		} else if(pwd != '' && pwd != oldPwd) {
			_html =  msg[1];
		} else if(!validall.test(pwd)) {
			_html =  msg[2];
		}
		return _html;
	},
	chkName : function(name)
	{
		var ereg = /^[\u4e00-\u9fff]*$/;
		if(name.length < 2 || name.length > 10 || ereg.test(name) == false) {
			return false;
		}
		return true;
	}
}

var checkPwdLevel = {
	//CharMode函数   
    //测试某个字符是属于哪一类.   
    charMode : function (str){   
        if (str>=48 && str <=57) //数字   
        return 1;   
        if (str>=65 && str <=90) //大写字母   
        return 2;   
        if (str>=97 && str <=122) //小写   
        return 4;   
        else   
        return 8; //特殊字符   
    },
    //bitTotal函数   
    //计算出当前密码当中一共有多少种模式   
    bitTotal : function (num){   
        var modes=0;   
        for (i=0;i<4;i++){   
			if (num & 1) modes++;   
			num>>>=1;   
        }   
        return modes;   
    },
    //checkStrong函数   
    //返回密码的强度级别   
    getLevel: function (pwd){   
        if (pwd.length<6)   
        return 0; //密码太短   
        var temp = 0;   
        for (i=0;i<pwd.length;i++){   
			//测试每一个字符的类别并统计一共有多少种模式.   
			temp|= checkPwdLevel.charMode(pwd.charCodeAt(i));   
        }   
        return checkPwdLevel.bitTotal(temp);   
    },
	getPwdLevel : function(pwd) {
		if(pwd==null) return;
		var lev = checkPwdLevel.getLevel(pwd);
		if(lev == 0) {
			//都为默认值
			$('#pwdLevel').attr('class','a_span1');
		}else if(lev == 1) {
			//低级别
			$('#pwdLevel').attr('class','a_span2');
		}else if(lev == 2 || lev == 3) {
			//中级别
			$('#pwdLevel').attr('class','a_span3');
		}else {
			//高级别
			$('#pwdLevel').attr('class','a_span4');
		}
	}
}

var selectGame = {
	//获取区服信息
    getServer : function (type){   
		switch (type)
		{
			case 'part':
                selectGame.hideServerTip();
				selectGame.hideServer();
				selectGame.hidePart();

				var game = $("#site_cd").val();
				if(game == '0'){
					return;
				}
				
				AjaxDI.ajaxCommitGet({
					url : '/api/pay_part_list?site_cd='+game,
					popSuccess : 0,
					successCallback : function(json) {
					   if(json.d.list != '')selectGame.showPart(json.d.list);
					}
				});            
				break;
			case 'server':
                selectGame.hideServerTip();
                selectGame.hideServer();
                
				var part = $("#part").val();
                var game = $("#site_cd").val();
				if(part == '0'){
					selectGame.hideServer();
					return;
				}
				
				AjaxDI.ajaxCommitGet({
					url : '/api/pay_group_list?site_cd=' + game + '&part_id=' + part,
					popSuccess : 0,
					successCallback : function(json) {
					   if(json.d.dest == 'part') selectGame.hideServer();
					   else if(json.d.dest  == 'group')selectGame.showServer(json.d.list);
                       else if(json.d.dest == 'show_group')selectGame.showServerTip(json.d.list);
					}
				});            
				break; 				
		}  
    },
    //显示大区   
    showPart : function (part){   
		if(part.length == 0)return;

		$('#part').append('<option value="0">请选择充入游戏区</option>');
		$.each(part, function(key, val) {  
		   $('#part').append('<option value="'+key+'">'+val+'</option>');
		}); 
		$('#part_select').show();   
    },
    //隐藏大区   
    hidePart : function (){   
		$('#part').find('option').remove();
		$('#part_select').hide(); 
    },
    //显示服  
    showServer : function (server){   
		if(server.length == 0)return;

		$('#server').append('<option value="0">请选择充入游戏服</option>');
		$.each(server, function(key, val) {   
		   $('#server').append('<option value="'+key+'">'+val+'</option>');
		}); 
		$('#server_select').show(); 
    },
    //隐藏服  
    hideServer : function (){   
		$('#server').find('option').remove();
		$('#server_select').hide();
    },
    //显示服提示  
    showServerTip : function (server){   
		if(server.length == 0)return;

		$('#server_tip_html').html('');
		$.each(server, function(key, val) {   
		   $('#server_tip_html').append(val+'&nbsp;');
		}); 
		$('#server_tip_title').show(); 
        $('#server_tip_content').show(); 
    },
    //隐藏服提示  
    hideServerTip : function (server){   
		$('#server_tip_html').html('');
        $('#server_tip_title').hide();
        $('#server_tip_content').hide();
    },
    reset : function (){   
        selectGame.hideServerTip();
		selectGame.hideServer();
		selectGame.hidePart();
        $('#site_cd')[0].selectedIndex = 0;
    },    
    //登录名  
    showLoginName : function (showloginname, id){   
		if(showloginname.length > 16){
			arr = showloginname.split('@');
			if(arr[0].length > 9) arr[0] = arr[0].substring(0,3) + "..." + arr[0].substring(arr[0].length-3);
			showloginname = arr[0]+'@'+arr[1];
		}	
		document.getElementById(id).innerHTML = showloginname;
		document.getElementById(id).title = showloginname;
    }
}

function isIE6(){
	return $.browser.msie && $.browser.version == "6.0";
}
function resetFrom(){
	$('input:text,input:password,input:checkbox,input:file').each(function(){
		$(this).val('');
	});
	$('input:radio,input:checkbox').each(function(){
		$(this).removeAttr('checked');
	});
}
function logout_menu(id) {
	var str = '<div class="login_div button1">' + 
		'<div class="button1_left"></div>' + 
		'<a href="/logout"><div class="button1_middle">登出</div></a>' + 
		'<div class="button1_right"></div>' + 
	'</div>';
	$("#" + id).html(str);
}

var commonCodeTimmer;
var mobileGetCode = {
	get : function(mobile,type)
	{
		if(type == undefined) type = 1;
		var para = 'mobile='+mobile.toLowerCase()+'&chk_unique=1&log=1';
		var url = '/api/get_mobile_code?'+para;
		if(type == 2)
		{
			//快速注册
			AjaxDI.ajaxCommitGet({
				url:url,
				popSuccess:0,
				popError:0,
				successCallback: function(){
					$('#mobileGetCode').hide();
					$('#mobileReGetCode').show();
					mobileGetCode.countDown(60);
					$('#regQuickError').html('').removeClass('errorTips');
				},
				errorCallback: function(json) {
					if(typeof json.d!='undefined'){
						$('#mobileGetCode').hide();
						$('#mobileReGetCode').show();
						mobileGetCode.countDown(json.d.count_down);
					} else {
						$('#regQuickError').html(json.m).addClass('errorTips');
					}
				},
				isLogin:false
			});
		} else {
			AjaxDI.ajaxCommitGet({
				url:url,
				popSuccess:0,
				popError:1,
				successCallback: function(){
					$('#mobileGetCode').hide();
					$('#mobileReGetCode').show();
					mobileGetCode.countDown(60);
				},
				errorCallback: function(json) {
					if(typeof json.d != 'undefined'){
						$('#mobileGetCode').hide();
						$('#mobileReGetCode').show();
						mobileGetCode.countDown(json.d.count_down);
					}
				},
				isLogin:false
			});
		}
		
		return;
	},
	countDown: function (secs){
		clearTimeout(commonCodeTimmer);
		var codeTimmer = document.getElementById('codeTimmer');
			codeTimmer.innerHTML=secs;
		if(--secs > 0) {
			commonCodeTimmer = setTimeout("mobileGetCode.countDown("+secs+")",1000);
		} else {
			$('#mobileGetCode').show();
			$('#mobileReGetCode').hide();
		}
	}
}

function commonReturnHtml(){
	var str = '<div class="cp1_div2">'+
					'<a class="cp1_a1" href="javascript:history.go(-1)"></a>'+
					'<span class="cp1_line"></span>'+
					'<p class="cp1_p1"><a class="returnIndexLink" href="/">返回首页</a></p>'+
				'</div>';
	$("#returnIndexDom").html(str);
}

function getParameterByName(name) {
  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
  var regexS = "[\\?&]" + name + "=([^&#]*)";
  var regex = new RegExp(regexS);
  var results = regex.exec(window.location.search);
  if(results == null)
    return "";
  else
    return decodeURIComponent(results[1].replace(/\+/g, " "));
}
