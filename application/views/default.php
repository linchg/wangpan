<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->key?>" />
<meta name="description" content="<?php echo $this->content?>" />
<link href="<?php echo static_url_version('static/css/comm.css');?>" rel="stylesheet" type="text/css" />
<?php echo isset($css_header) ? $css_header : '';?>
<script type="text/javascript" src="<?php echo static_url_version('static/js/jquery.min.js');?>"></script>
<?php
echo isset($js_header) ? $js_header : '';
?>
</head>

<body>
<div id="banner">
    <div id="subtop">
        <div class="top_width">
            <div class="logo"><a href="/" title="一木禾网盘"><img src="<?php echo static_url('static/images/logo_black.jpg')?>"></a></div>
            <div class="subtop1">
                <div id="hot"><img src="<?php echo static_url('static/images/hot1.gif');?>"></div>
                <div id="new"><img src="<?php echo static_url('static/images/new1.gif');?>"></div>
                <?php
                $menu = isset($content_menus) ? $content_menus : array();
                foreach ($menu as $url => $v)
                {
                    echo '<a href="/'.$url.'" class="'.$v['style'].'">'.$v['title'].'</a>';
                }
                ?>
            </div>
        </div>
    </div>
    <?php
    switch($this->menu)
    {
    case 'auth':
        echo '<div class="child" style="height:50px;"></div>';
        break;
    default:
        break;
    }
    ?>
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
