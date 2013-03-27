<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->key?>" />
<meta name="description" content="<?php echo $this->content?>" />
<link href="<?php echo static_url_version('static/css/comm.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo static_url_version('static/js/jquery.min.js');?>"></script>
<?php
echo isset($js_header) ? $js_header : '';
echo isset($css_header) ? $css_header : '';
?>
</head>

<body>
<div id="banner">
<div id="subtop">
<div class="top_width">
<div class="logo"><a href="/" title="一木禾网盘"><img src="<?php echo static_url('static/images/logo_black.jpg')?>"></a></div>
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
</div>


<?php echo $content;?> 


<div id="bottom3">
  <table width="980" border="0" align="center" cellpadding="6" cellspacing="0">
    <tr>
      <td width="980" valign="top"><hr size="1"></td>
    </tr>
    <tr>
      <td align="center"><span class="friend">版权信息：Copyright @ 2007-2012 YiMuHe.com All rights reserved. 一木禾网盘(yimuhe.com) 版权所有</span>&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.miitbeian.gov.cn/" target="_blank">蜀ICP备12024491号</a></td>
    </tr>
  </table>
</div>

<?php
echo isset($js_footer) ? $js_footer: '';
echo isset($css_footer) ? $css_footer: '';
?>
</body>
</html>
