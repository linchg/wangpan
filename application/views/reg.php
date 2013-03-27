<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>用户注册 - 一木禾网盘</title>
<link href="n_style/index.css" rel="stylesheet" type="text/css" />
<SCRIPT language="JavaScript" type="text/javascript" src="n_js/jquery.js"></SCRIPT>
<SCRIPT language="JavaScript" type="text/javascript" src="n_js/register.js"></SCRIPT>
</head>

<body>
<div id="banner">
<div id=subtop>
<div class="top_width">
<div class="logo"><a href="/" title="一木禾网盘"><img src="n_images/logo_black.jpg"></a></div>
<div class="subtop1">
<a href="/">首页</a>
<a href="/n_money.html">网盘赚钱</a>
<a href="/n_member/shop.php">积分兑换</a>
<a href="/n_faq.html">常见问题</a>
<a href="/n_about.html">关于网盘</a>
</div>
</div>
</div>
<div class="child" style="height:50px;"></div>
</div>

<div id="maincontent2" style="margin:40px auto">
<div class="sharp color1" style="width:100%;">
<b class="b1"></b>
<b class="b2"></b>
<b class="b3"></b>
<b class="b4"></b> 
<div class="content" style="padding:0px 0px 0px 0px; height:100%; position:relative;">
<div style="position:absolute; right:20px; top:10px;">一木禾网盘，网赚新选择。</div>
<br />

<div class="title_child" style="margin-left:20px;">用户注册</div>
<div id="reg"> 
<form id="regform">
      <table width="100%" align="center" cellpadding="4" cellspacing="0">
        <tr>
  <td width="302" align="right">登陆帐号：</td>
  <td width="243" align="left">
  <input name="username" id="username" type="text" value="" size="35" maxlength="20"> 
  *</td>
  <td width="427" align="left"><div class="info">
						<b id="uname_ico_ok" class="ico-ok" title="正确" style="display:none"></b>
						<b id="uname_ico_err" class="ico-error" title="错误" style="display:none"></b>
						<div id="div_uname_err" class="info-pop">
							<div class="arr"></div>
							<div class="info-pop-t"><b class="cr-l"></b><b class="cr-r"></b></div>
							<div class="info-pop-c"><div class="cont" id="div_uname_err_info">·5~15个字符，包括字母、数字、下划线<br />·字母和数字开头，字母和数字结尾，不区分大小写<br /></div></div>
							<div class="info-pop-b"><b class="cr-l"></b><b class="cr-r"></b></div>
						</div>
					</div></td>  
        </tr>
        <tr>
          <td align="right" >网盘名称：</td>
          <td align="left"><input name="petname" type="text" id="petname" value="" size="35" maxlength="20" />
* </td>
          <td align="left"><div class="info">
						<b id="pname_ico_ok" class="ico-ok" title="正确" style="display:none"></b>
						<b id="pname_ico_err" class="ico-error" title="错误" style="display:none"></b>
						<div id="div_pname_err" class="info-pop"  style="display:none">
							<div class="arr"></div>
							<div class="info-pop-t"><b class="cr-l"></b><b class="cr-r"></b></div>
							<div class="info-pop-c"><div class="cont" id="div_pname_err_info">·网盘的名称</div></div>
							<div class="info-pop-b"><b class="cr-l"></b><b class="cr-r"></b></div>
						</div>
					</div></td>
        </tr>
        <tr>
<td align="right" >登陆密码：</td>
<td align="left"><input name="password" type="password" id="password" value="" size="35" maxlength="20" />
            * </td>
<td align="left"><div class="info">
						<b id="password_ico_ok" class="ico-ok" title="正确" style="display:none"></b>
						<b id="password_ico_err" class="ico-error" title="错误" style="display:none"></b>
						<div id="div_password_rule" class="info-pop" style="display:none">
							<div class="arr"></div>
							<div class="info-pop-t"><b class="cr-l"></b><b class="cr-r"></b></div>
							<div class="info-pop-c">
								<div class="cont">6～16个字符（字母、数字、特殊符号）,区分大小写<br />
									<div class="fle">密码强度：<span class="Cred">弱</span></div>
									<div class="psw-sinfo"><div id="div_passowrd_Strong" class="bar state0"></div></div>
									<span class="fle Cblue">强</span>
									<div class="clear"></div>
								</div>
							</div>
							<div class="info-pop-b"><b class="cr-l"></b><b class="cr-r"></b></div>
						</div>
						<div id="div_password_err" class="info-pop I-error" style="display:none">
							<div class="arr"></div>
							<div class="info-pop-t"><b class="cr-l"></b><b class="cr-r"></b></div>
							<div class="info-pop-c"><div class="cont" id="div_password_err_info"></div></div>
							<div class="info-pop-b"><b class="cr-l"></b><b class="cr-r"></b></div>
						</div>
					</div></td>
        </tr>
        <tr>
          <td align="right" >确认密码：</td>
          <td align="left"><input name="passwordconfirm" type="password" id="passwordconfirm" value="" size="35" maxlength="20" />
            *</td>
          <td align="left"><div class="info">
							<b id="passwordconfirm_ico_ok" class="ico-ok" title="正确" style="display:none"></b>
							<b id="passwordconfirm_ico_err" class="ico-error" title="错误" style="display:none"></b>
							<div id="div_passwordconfirm_err" class="info-pop I-error" style="display:none">
								<div class="arr"></div>
								<div class="info-pop-t"><b class="cr-l"></b><b class="cr-r"></b></div>
								<div class="info-pop-c"><div class="cont" id="div_passwordconfirm_err_info">两次输入密码不一致</div></div>
								<div class="info-pop-b"><b class="cr-l"></b><b class="cr-r"></b></div>
							</div>
						</div></td>
        </tr>
          <tr>
            <td align="right" >邮箱地址：</td>
            <td align="left"><input name="email" type="text" id="email" value="" size="35" />
              *</td>
            <td align="left"><div class="info">
							<b id="email_ico_ok" class="ico-ok" title="正确" style="display:none"></b>
							<b id="email_ico_err" class="ico-error" title="错误" style="display:none"></b>
							<div id="div_email_err" class="info-pop I-error">
								<div class="arr"></div>
								<div class="info-pop-t"><b class="cr-l"></b><b class="cr-r"></b></div>
								<div class="info-pop-c"><div class="cont" id="div_email_err_info">邮箱地址，需邮件认证！请认真填写。</div></div>
								<div class="info-pop-b"><b class="cr-l"></b><b class="cr-r"></b></div>
							</div>
						</div></td>
          </tr>
          <tr>
            <td align="right" >&nbsp;</td>
            <td align="left"><img src="n_code.php" name="vcode_img" class="" id="vcode_img">&nbsp;&nbsp;<a href="#" onClick="$('#vcode_img').attr('src','n_code.php?t='+(new Date().getTime()));return false;">看不清楚，换一张</a></td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" >验证码：</td>
            <td align="left"><input name="authcode" type="text" id="authcode" value="" size="10" /> 
            *</td>
            <td align="left"><div class="info">
							<b id="authcode_ico_ok" class="ico-ok" title="正确" style="display:none"></b>
							<b id="authcode_ico_err" class="ico-error" title="错误" style="display:none"></b> 
							<div id="div_authcode_err" class="info-pop I-error" style="display:none">
								<div class="arr"></div>
								<div class="info-pop-t"><b class="cr-l"></b><b class="cr-r"></b></div>
								<div class="info-pop-c"><div id="div_authcode_err_info" class="cont"></div></div>
								<div class="info-pop-b"><b class="cr-l"></b><b class="cr-r"></b></div>
							</div>
						</div></td>
          </tr>
          <tr>
            <td align="right" ><input name="servItems" type="checkbox" id="servItems" style="border:0px;" checked /></td>
            <td>
              我已阅读并完全同意 <b><a href="/n_tiaokuan.html" target=_blank>注册协议</a></b>
              </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="center" >&nbsp;</td>
            <td class="Cred">注：支付信息在第一次提现时设置。</td>
            <td align="center" >&nbsp;</td>
          </tr>
          <tr>
          <td height="100" align="center" >&nbsp;</td>
          <td height="100" ><input type="button" onClick="this.blur();doRegFormSubmit();" name="button" id="button" value="确定注册" class="loginbutton" style="border:0px; width:184px; height:53px; font-size:22px; color:#FFF;background-image: url(n_images/menu_reg.jpg);"/></td>
          <td height="100" align="center" >&nbsp;</td>
          </tr>
      </table>
    </form></div>
</div>
<b class="b5"></b><b class="b6"></b><b class="b7"></b><b class="b8"></b>    
</div>
<div class="clear"></div>
</div>

<div id="bottom3">
  <table width="980" border="0" align="center" cellpadding="6" cellspacing="0">
    <tr>
      <td width="980" valign="top"><hr size="1"></td>
    </tr>
    <tr>
      <td align="center"><span class="friend1">版权信息：Copyright @ 2007-2012 YiMuHe.com All rights reserved. 一木禾网盘(yimuhe.com) 版权所有</span></td>
    </tr>
  </table>
</div>
<div style="display:none"><script src="http://s5.cnzz.com/stat.php?id=4551662&web_id=4551662" language="JavaScript"></script></div>
</body>
</html>

