<div class="abs abs-r-10 " style="_margin-right:235px;">
<?php
$menus = isset($top_menus) ? $top_menus : array();
$i = 0;
foreach($menus as $key => $v)
{
	echo '<a id="'.$v['id'].'" href="'.$key.'" class="'.$v['style'].'" '.(empty($v['target'])?'':'target="'.$v['target'].'"').'>'.$v['title'].'</a>';
	$i ++ ;
	if ($i  <  count($menus))
	{
		echo '<span class="plr5 gray">|</span>';
	}
}
?>
<!--a href="http://linchg.yimuhe.com/" target="_blank" title="http://linchg.yimuhe.com/" class="hoverlink">我的主页</a>
<a href="userweb.php" target="_parent" title="空间公告设置" class="hoverlink">空间公告</a>
<span class="plr5 gray">|</span>
<a href="wdxx.php" target="_parent" title="我的下线" class="hoverlink blue">我的下线</a>
<span class="plr5 gray">|</span>
<a href="http://wpa.qq.com/msgrd?v=1&uin=45995086&site=www.yimuhe.com&menu=no" target="_blank" class="gray feedbacklink hoverlink">建议反馈</a>
<span class="plr5 gray">|</span>
<a href="/n_loginout.php" target="_parent" title="退出一木禾网盘" class="hoverlink">退出</a!-->
</div><!--up-->

