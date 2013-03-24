<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->key?>" />
<meta name="description" content="<?php echo $this->content?>" />
<link href="<?php echo static_url('static/css/comm.css');?>" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo static_url('static/js/jquery.min.js');?>"></script>
<script language="JavaScript">
$(document).ready(function(){
            $("#s_name").focus(function(){
               if($("#s_name").val()=="帐号"){
                   $("#s_name").attr("value","");
               }
            });
            $("#s_name").blur(function(){
                if($("#s_name").val()==""){
                    $("#s_name").attr("value","帐号")
                }
            })
            $("#s_code").focus(function(){
               if($("#s_code").val()=="验证码"){
                   $("#s_code").attr("value","");
               }
            });
            $("#s_code").blur(function(){
                if($("#s_code").val()==""){
                    $("#s_code").attr("value","验证码")
                }
            })
            $("#s_password").click(function(){
				   $(".PwdStr").html("");
            });
            $("#s_password").focus(function(){
			/*
               if($("#s_password").val()==""){
                    $(".PwdStr").html("");
               }else{
				   $(".PwdStr").html("");
				   }
			*/
			$(".PwdStr").html("");
            });
            $("#s_password").blur(function(){
                if($("#s_password").val()==""){
                    $(".PwdStr").html("密码");
                }else{
				   $(".PwdStr").html("");
			   }
            })

			$("#login").click(function(){
				if($("#s_name").val()=="帐号"||$("#s_name").val()==""){
						$("#s_name").focus();
						alert("请输入登录帐号。");
						return false;
				}
				if($("#s_password").val()==""){
						$("#s_password").focus();
						alert("请输入密码。");
						return false;
				}
				if($("#s_code").val()==""||$("#s_code").val()=="验证码"){
						$("#s_code").focus();
						alert("请输入验证码。");
						return false;
				}
			})
     }); 
</script>
</head>

<body>
<div id="banner">
<div id="subtop">
<div class="top_width">
<div class="logo"><a href="/" title="一木禾网盘"><img src="n_images/logo_black.jpg"></a></div>
<div class="subtop1">
<div id="hot"><img src="n_images/hot1.gif"></div>
<div id="new"><img src="n_images/new1.gif"></div>
<a href="/" class="on">首页</a>
<a href="/n_money.html">网盘赚钱</a>
<a href="/n_member/shop.php">积分兑换</a>
<a href="/n_faq.html">常见问题</a>
<a href="/n_about.html">关于网盘</a>
</div>
</div>
</div>
<div class="child"><img id="banner_img" onload="javascript:change_banner();"></div>
</div>

<div id="maincontent1"> 
<div class="sharp color1" style="width:690px;float:left;">
<b class="b1"></b>
<b class="b2"></b>
<b class="b3"></b>
<b class="b4"></b> 
<div class="content" >

<div class="webpackage">
<div class="news_default" style="height:243px;">
<div class="title" style="height:20px; padding-top:0px;"><span class="l">网盘公告</span></a><span class="r more"><a href="news.html" target="_blank" title="更多公告">更多公告</a></span></div>
<ul>
<li><span>2013-03-12 19:27:03</span> <a href="/news-20.html" target="_blank">一木禾网盘3月13日维护公告</a></li><li><span>2013-02-25 15:00:02</span> <a href="/news-19.html" target="_blank"><font color="#FF0000">一木禾网盘庆蛇年，收入翻倍计划重装启动！</font></a></li><li><span>2013-02-25 14:00:03</span> <a href="/news-18.html" target="_blank"><font color="#FF0000">一木禾网盘2013年提价公告！</font></a></li><li><span>2013-02-10 00:00:01</span> <a href="/news-17.html" target="_blank">一木禾网盘祝广大会员新年快乐，万事如意</a></li><li><span>2013-02-04 15:17:06</span> <a href="/news-16.html" target="_blank">一木禾网盘2013年春节放假及春节翻双倍活动通知</a></li></ul>
<a href="http://www.yimuhe.com/news-19.html" target="_blank"><img src="ymh-hd.gif" width="650" height="60"></a>
</div>
</div>
</div>

<b class="b5"></b><b class="b6"></b><b class="b7"></b><b class="b8"></b>    
</div>

<div class="webservice">

<div class="sharp color1" style="width:300px; margin-left:6px;">
<b class="b1"></b>
<b class="b2"></b>
<b class="b3"></b>
<b class="b4"></b> 
<div class="content" style="height:250px;padding:0px 0px 0px 30px;">  
<div class="title" style="margin-bottom:10px;height:15px;"><span class="l">网盘登录</span><span class="r more"><a href="index1.php">旧版登录</a>&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
<form id="form1" name="form1" method="post" action="n_post.php" target="_top">
<div class="userlogin2">
        <ul>
          <li>
            <input name="s_name" type="text" class="input_s" id="s_name" value="帐号" maxlength="20"/>
          </li>
          <li style="position:relative">
          <div class="PwdStr">密码</div>
          <input name="s_password" type="password" class="input_s" id="s_password" value="" maxlength="20"/>
          </li>
          <li>
          <input name="s_code" type="text" class="input_c" id="s_code" value="验证码" maxlength="5"/>
          <img src="n_code.php" name="vcode_img" align="absmiddle" class="" id="vcode_img">&nbsp;&nbsp;<a href="#" onClick="$('#vcode_img').attr('src','n_code.php?t='+(new Date().getTime()));return false;">换一个</a>
          </li>
          <li>
<input id="login" name="" type="image" src="n_images/but1.jpg">
<a href="n_reg_user.html" target="_top"><img src="n_images/but2.jpg" width="110" height="35" /></a>
<input name="type" type="hidden" id="type" value="login">
<br />
<a href="http://wpa.qq.com/msgrd?V=1&Uin=45995086&Site=www.yimuhe.com&Menu=no" title="忘记密码直接Q客服。" target="_blank" style="font-size:11px; color:#4476af; float:left;margin:3px 0px 0px 0px;">忘记密码？</a>
<div style="font-size:11px; float:right; margin:3px 15px 0px 0px;">注：登录后签到能获得积分哦。</div>
</li>
</ul>
</div>
</form>
</div>
<b class="b5"></b><b class="b6"></b><b class="b7"></b><b class="b8"></b>    
</div>

</div>
<div class="clear"></div></div>


<div id="maincontent2">
<div class="sharp color1" style="width:100%;">
<b class="b1"></b>
<b class="b2"></b>
<b class="b3"></b>
<b class="b4"></b> 
<div class="content" style="padding:15px 0px 0px 20px; height:150px;">
  <div class="ggbox">
<p><img src="n_images/ico_hy.gif" width="33" height="30" align="absmiddle">最新会员</p>
<span><a href="http://gjgwxy.yimuhe.com/" target="_blank">gjgwxy</a></span><span><a href="http://htrdffd.yimuhe.com/" target="_blank">htrdffd</a></span><span><a href="http://gly122.yimuhe.com/" target="_blank">gly122</a></span><span><a href="http://jieer1314520.yimuhe.com/" target="_blank">mc杰尔</a></span><span><a href="http://mytest.yimuhe.com/" target="_blank">mytest</a></span><span><a href="http://jacko111.yimuhe.com/" target="_blank">xxoo111</a></span><span><a href="http://xuexi258.yimuhe.com/" target="_blank">258789</a></span><span><a href="http://77799.yimuhe.com/" target="_blank">77799</a></span></div>
<div class="ggbox">
<p><img src="n_images/ico_wj.gif" width="33" height="30" align="absmiddle"> 最新文件</p>
<a href="/file-602386.html" target="_blank">郭德纲2012德云社美国哥伦比亚大学演讲.zip</a><br /><a href="/file-602384.html" target="_blank">種子.rar</a><br /><a href="/file-602383.html" target="_blank">辽宁全自动猜密码+湖北（内含湖北跳板代码） 全能刷钻辅助 v1.2.exe</a><br /><a href="/file-602382.html" target="_blank">TO27.zip</a><br /></div>
<div class="ggbox">
<p><img src="n_images/ico_wz.gif" width="33" height="30" align="absmiddle"> 网盘赚钱</p>
下载数越多您的活跃度越高，<br />活跃度越高千次下载单价越高！<br />金额满10元即可登录网盘申请结算！<br /><font color="#FF0000">最高可达50元每千次下载！</font>
</div>
<div class="ggbox">
<p><img src="n_images/ico_jf.gif" width="33" height="30" align="absmiddle">积分商城</p>
每次结算后，都会自动返回50%的积分。<br />
所有商品都通过积分兑换，<br />
只要您达到指定积分后，即可兑换，<br />
一木禾会在5个工作日内为您寄出。
</div>

</div>
<b class="b5"></b><b class="b6"></b><b class="b7"></b><b class="b8"></b>    
</div>
</div>

<div id="maincontent2">
<div class="sharp color1" style="width:100%;">
<b class="b1"></b>
<b class="b2"></b>
<b class="b3"></b>
<b class="b4"></b> 
<div class="content" style="padding:0px 20px 0px 20px; height:153px;">
<div class="title"><span class="l">积分兑换</span><span class="r more"><a href="/n_member/shop.php" target="_blank">更多商品</a></span></div>
<table width="100%" border="0" cellspacing="0" cellpadding="6" class="jifenshop">
  <tr>
<td align="center"><img alt="Apple/苹果 iPhone 4S 16G版（黑）" src="n_shopimg/16s.jpg" width="80" height="80"></td><td align="center"><img alt="Apple/苹果 the new iPad(16G)WIFI版（黑）" src="n_shopimg/15s.jpg" width="80" height="80"></td><td align="center"><img alt="Sony/索尼 HDR-CX210E 高清/闪存摄像机 家用/专业/DV摄像机" src="n_shopimg/14s.jpg" width="80" height="80"></td><td align="center"><img alt="华为（HUAWEI）Ascend G330C（C8825D）双模3G手机" src="n_shopimg/13s.jpg" width="80" height="80"></td><td align="center"><img alt="松下DMC-FH2GK数码相机（1410万像素 2.7英寸液晶屏 4倍光学变焦 28mm广角）" src="n_shopimg/12s.jpg" width="80" height="80"></td><td align="center"><img alt="飞利浦（PHILIPS）HMP5000 高清媒体播放器内置无线WiFi 高清大片" src="n_shopimg/11s.jpg" width="80" height="80"></td><td align="center"><img alt="三星（SAMSUNG）M3系列 高性能USB3.0移动硬盘 500G" src="n_shopimg/10s.jpg" width="80" height="80"></td><td align="center"><img alt="友讯（D-Link）DIR-505 150M迷你无线路由器 云旅机便携式Mini云路由" src="n_shopimg/9s.jpg" width="80" height="80"></td>  </tr>
</table>
</div>
<b class="b5"></b><b class="b6"></b><b class="b7"></b><b class="b8"></b>    
</div>
<div class="clear"></div>
</div>

<div id="maincontent2" style="height:20px;"></div>
<div id="bottom2">
  <table width="980" border="0" align="center" cellpadding="6" cellspacing="0">
    <tr class="bottom_title">
      <td width="17%">网盘赚钱</td>
      <td width="17%">常见问题</td>
      <td width="17%">关于网盘</td>
      <td width="17%" valign="top">网站客服</td>
      <td width="17%" valign="top">财务/投诉</td>
      <td valign="top">一木禾</td>
    </tr>
    <tr>
      <td valign="top"><a href="/n_money.html#part1">分成政策</a><br />
        <a href="/n_money.html#part2">关于分成结算</a><br />
        <a href="/n_money.html#part3">关于积分获得</a><br />
        <a href="/n_money.html#part4">关于积分商城</a></td>
      <td valign="top"><a href="/n_faq.html#part1">基础问题</a><br />
        <a href="/n_faq.html#part2">关于如何赚钱</a><br />
      <a href="/n_faq.html#part3">推广优化技巧</a><br /></td>
      <td valign="top"><a href="/n_about.html#part1">关于一木禾网盘</a><br />
        <a href="/n_about.html#part2">一木禾优势</a><br />
        <a href="/n_about.html#part3">一木禾宗旨</a></td>
      <td valign="top"><a href="http://wpa.qq.com/msgrd?V=1&Uin=45995086&Site=www.yimuhe.com&Menu=no" target="_blank">果园 QQ:45995086</a><br />
        <a href="http://wpa.qq.com/msgrd?V=1&Uin=2293321178&Site=www.yimuhe.com&Menu=no" target="_blank">蚂蚁 QQ:2293321178</a></td>
      <td valign="top"><a href="http://wpa.qq.com/msgrd?V=1&Uin=2244210&Site=www.yimuhe.com&Menu=no" target="_blank">雷东多 QQ:2244210</a></td>
      <td valign="top"><a href="/n_tiaokuan.html">使用条款</a> <br />
        <a href="/n_yinsi.html">隐私声明</a><br />
        <a href="/n_banquan.html">版权所属</a></td>
    </tr>
    <tr>
      <td colspan="6" valign="top"><hr size="1"></td>
    </tr>
    <tr>
      <td colspan="6" align="center"><span class="friend">版权信息：Copyright @ 2007-2012 YiMuHe.com All rights reserved. 一木禾网盘(yimuhe.com) 版权所有</span>&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.miitbeian.gov.cn/" target="_blank">蜀ICP备12024491号</a></td>
    </tr>
  </table>
</div>
</body>
</html>
