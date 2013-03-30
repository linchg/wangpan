<nav class="menu f14 b" id="navbox">
<?php
$menu = isset($content_menus) ? $content_menus : array();
foreach ($menu as $url => $v)
{
echo '<a href="/'.$url.'"  id="'.$v['id'].'" hidefocus="true" title="'.$v['title'].'" class="'.(isset($v['active_style'])?$v['active_style']:'').'"><span class="'.$v['style'].'">'.$v['title'].'</span></a>';
}
?>
</nav>
