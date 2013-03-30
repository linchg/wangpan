<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $this->title;?></title>
<link href="<?php echo  static_url_version('static/css/global.css');?>" rel="stylesheet" type="text/css">
<link href="<?php echo  static_url_version('static/css/files.css')?>" rel="stylesheet" type="text/css">
<?php echo isset($css_header) ? $css_header : '';?>
<!--[if lt ie 9]>
<script type="text/javascript" src="<?php echo static_url_version('static/js/html5.js');?>"></script>
<![endif]-->
<script type="text/javascript" src="<?php echo static_url_version('static/js/jquery.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo static_url_version('static/js/common.js'); ?>"></script>
<script type="text/javascript" src="<?php echo static_url_version('static/js/jquery.blockUI.js'); ?>"></script>
<script type="text/javascript" src="<?php echo static_url_version('static/js/jquery.cookie.js'); ?>"></script>
<script type="text/javascript" src="<?php echo static_url_version('static/js/ZeroClipboard.js'); ?>"></script>
<?php echo isset($js_header) ? $js_header : '';?>
<script type="text/javascript">
	var clip = null;
	function copy(key,copyshorturl,type) {
		clip = new zeroclipboard.client();
		clip.addeventlistener( "load", function(client) {
			client.movie.title="复制链接";
		});

		clip.addeventlistener( "complete", function(){
			floatdiv("网址复制成功。","#");
			settimeout("closeform()",2000);
		});
		if(type==1)
			var con=$("#"+copyshorturl).val()
		else
			var con=$("#"+copyshorturl).html()
		clip.settext(con);
		clip.glue(key);
	}
</script>
</head>

<body>
<div class="clearfix">
<aside class="aside">
<a href="/" title="回到<?php echo $this->siteName;?>首页" class="db"><h1 class="logo ti"><?php echo $this->siteName;?></h1></a>
<div id="userinfobox" class="plr20  mb20">
    <p id="username"><a href="http://linchg.yimuhe.com/" target="_blank" title="http://linchg.yimuhe.com/"><span class="white">linchg</span></a></p>
    <div class="total-space mb5" id="total-space">
      <p id="userspace" class="userusednum">178.81kb 共2文件</p>
      <div class="used-space" style="width:1px;" id="used-space"></div>
    </div>
    <p class="user-fun"><a id="userinfo" class="hoverlink" title="管理账号信息" href="userinfo.php">账号信息</a><span class="plr5">|</span><a id="spaceinfo" class="hoverlink" title="未读信息" href="msg.php">未读信息(0)</a></p>
    <p class="user-fun">余额：<a href="tiqu.php"><b class="white">0.0000</b></a>元　积分：<a href="jifenlog.php"><b class="white" id="jifen">2</b></a></p>
</div>
<?php include_once("menu.php");?>
</aside>


<?php echo $content;?>

<?php
echo isset($js_footer) ? $js_footer: '';
echo isset($css_footer) ? $css_footer: '';
?>
</body>
</html>
