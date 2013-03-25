<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $this->title;?></title>
<link href="<?php echo static_url('static/css/global.css');?>" rel="stylesheet" type="text/css">
<link href="<?php echo static_url('static/css/files.css')?>" rel="stylesheet" type="text/css">
<!--[if lt ie 9]>
<script language="javascript" type="text/javascript" src="<?php echo static_url('static/js/html5.js');?>"></script>
<![endif]-->
<script type="text/javascript" src="<?php echo static_url('static/js/jquery.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo static_url('static/js/jquery.blockUI.js'); ?>"></script>
<script type="text/javascript" src="<?php echo static_url('static/js/jquery.cookie.js'); ?>"></script>
<script type="text/javascript" src="<?php echo static_url('static/js/common.js'); ?>"></script>
<script type="text/javascript" src="<?php echo static_url('static/js/ZeroClipboard.js'); ?>"></script>
<script language="javascript">
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
<a href="/" title="回一木禾首页" class="db"><h1 class="logo ti">一木禾网盘</h1></a>
<div id="userinfobox" class="plr20  mb20">
    <p id="username"><a href="http://linchg.yimuhe.com/" target="_blank" title="http://linchg.yimuhe.com/"><span class="white">linchg</span></a></p>
    <div class="total-space mb5" id="total-space">
      <p id="userspace" class="userusednum">178.81kb 共2文件</p>
      <div class="used-space" style="width:1px;" id="used-space"></div>
    </div>
    <p class="user-fun"><a id="userinfo" class="hoverlink" title="管理账号信息" href="userinfo.php">账号信息</a><span class="plr5">|</span><a id="spaceinfo" class="hoverlink" title="未读信息" href="msg.php">未读信息(0)</a></p>
    <p class="user-fun">余额：<a href="tiqu.php"><b class="white">0.0000</b></a>元　积分：<a href="jifenlog.php"><b class="white" id="jifen">2</b></a></p>
</div>
<?php include_once("left_menu.php");?>
</aside>

<section class="mainer">
<!--右边区域  a-->
<div class="plr20 pt5">
<header class="menubox rel h60 mb20">
<div class="abs abs-r-10 " style="_margin-right:235px;">
<a id="mrqd" href="javascript:;" class="checkin imitate-ico imitate-checkin dib hoverlink">每日签到</a>
<span class="plr5 gray">|</span>
<a href="http://linchg.yimuhe.com/" target="_blank" title="http://linchg.yimuhe.com/" class="hoverlink">我的主页</a>
<span class="plr5 gray">|</span>
<a href="userweb.php" target="_parent" title="空间公告设置" class="hoverlink">空间公告</a>
<span class="plr5 gray">|</span>
<a href="wdxx.php" target="_parent" title="我的下线" class="hoverlink blue">我的下线</a>
<span class="plr5 gray">|</span>
<a href="http://wpa.qq.com/msgrd?v=1&uin=45995086&site=www.yimuhe.com&menu=no" target="_blank" class="gray feedbacklink hoverlink">建议反馈</a>
<span class="plr5 gray">|</span>
<a href="/n_loginout.php" target="_parent" title="退出一木禾网盘" class="hoverlink">退出</a>
</div><!--up-->
<div class="clearfix pt30">
<div class="l">
<!-- 新建文件夹菜单 -->
<a href="javascript:;" id="newdir" class="imitate-btn btn-blue r2 dib mr15">新建文件夹</a>
<!-- 上传文件 -->
<a href="javascript:;" id="upload" class="imitate-btn imitate-green r2 dib">上传文件</a>
<div id="folder_id" class="dn">0</div><div id="f" class="dn">0</div>
<!--显示已删除-->
</div>
<div class="r w450">
<!--搜索-->
<form action="" class="r" id="searchform" method="get">
<input name="s" type="text" class="r2 f12 bde txt-t1 w260 bsi" onfocus="(this.value == '请输入您要搜索的文件名') ? this.value='':''" onblur="(this.value == '') ? this.value='请输入您要搜索的文件名' :''" value="请输入您要搜索的文件名" />
<input type="submit" id="searchbtn" value="搜索" class="imitate-btn normal-btn" />
</form>
</div>
</div>
</header>

<form action="" method="post">
<table class="toolabsolute dn">
<!--[if lt ie 8]>
<colgroup>
<col class="w40"/>
<col />
<col class="w80" />
<col class="w60" />
<col class="w80" />
<col class="w135" />
</colgroup>
<![endif]-->
<thead>
<tr class="tableheader" bgcolor="#ffffff">
<th class="bt0 w40 chkall">&nbsp;&nbsp;<input name="chk_all" id="chk_all2" type="checkbox"></th>
<th class="filename  bt0 tl">
<div id="wjm1">文件名</div>
<div id="movedel1" class="dn"><a href="javascript:;" onclick="get_folder(0);" class="menu bgs ico-move-file">移动</a><a href="javascript:;" onclick="del_filearr('0');" class="menu bgs ico-delete-file">删除</a><a href="javascript:;" onclick="link_urlarr('0');" class="menu bgs ico-link-file">取链</a></div>
</th>
<th class="status w80 tr bt0">&nbsp;

</th>
<th class="status w60 tr bt0">
下载
</th>
<th class="size  tr w80 bt0">
大小
</th>
<th class="date tr w135 bt0">
日期
<a class="sort" href="javascript:;" sortkey="modtime" sorttype="asc">▲</a>
</th>
</tr>
</thead>
</table>

<table class="ie6">
<!--[if lt ie 8]>
<colgroup>
<col class="w40"/>
<col />
<col class="w80" />
<col class="w60" />
<col class="w80" />
<col class="w135" />
</colgroup>
<![endif]-->
<thead>
<tr>
<th colspan="6" >
<nav id="navlinkbox" class="n f14">
<a title="返回上一级" class="bgs ico-go-back dib lgray ico-go-back-disable" href="###">上一级</a><a class="dib pl15" title="我的网盘" href="index.php?folderid=0">我的网盘</a><span class="lgray plr5">&gt;</span>
</nav>
</th>
</tr>
<tr class="tableheader" id="kptopdefault" bgcolor="#ffffff">
<th class="bt0 w40 chkall">&nbsp;&nbsp;<input name="chk_all" id="chk_all1" type="checkbox"></th>
<th class="filename bt0 tl">
<div id="wjm">文件名</div>
<div id="movedel" class="dn"><a href="javascript:;" onclick="get_folder(0);" class="menu bgs ico-move-file">移动</a><a href="javascript:;" onclick="del_filearr('0');" class="menu bgs ico-delete-file">删除</a><a href="javascript:;" onclick="link_urlarr('0');" class="menu bgs ico-link-file">取链</a></div>
</th>
<th class="status w80 tr bt0">&nbsp;</th>
<th class="status w60 tr bt0">
下载
</th>
<th class="size  tr w80 bt0">
大小
</th>
<th class="date tr w135 bt0">
日期
<a class="sort" href="javascript:;" sortkey="modtime" sorttype="asc">▲</a>
</th>
</tr>
</thead>
</table>

<table id="listviewfilelist" class="list ie6">
<colgroup>
<col class="w40"/>
<col />
<col class="w80" />
<col class="w60" />
<col class="w80" />
<col class="w135" />
</colgroup>
  <tbody id="filemangelist">
    <tr>
      <td class="select-file">&nbsp;&nbsp;<input name="f" type="checkbox" disabled></td>
      <td class="file-title f14"><a class="floder ico-type filename filelink" title="视频" href="?folderid=1">视频</a><span class="lgray">(0)</span></td>
      <td class="tr sharestatus"><div id="rename" class="dn"><a href="javascript:;" onclick="delfolder(1,'视频',0);" class="menudm bgs1 ico-delete-file1 r" style="width:25px;display: block;" title="删除">&nbsp;</a><a class="menudm bgs1 ico-rename-file1 r" style="width:25px;display: block;" href="javascript:;" onclick="modfolder(1,'视频');" title="重命名">&nbsp;</a><a href="javascript:;" class="menudm bgs1 ico-copy-file r" style="width:25px;display: block;" title="复制链接地址" id="copy101" onclick="copyfolder('1','linchg');">&nbsp;</a></div></td>
      <td></td>
      <td></td>
      <td class="tr">2013-03-23 20:41:12</td>
    </tr>
    <tr>
      <td class="select-file">&nbsp;&nbsp;<input name="f" type="checkbox" disabled></td>
      <td class="file-title f14"><a class="floder ico-type filename filelink" title="音频" href="?folderid=2">音频</a><span class="lgray">(0)</span></td>
      <td class="tr sharestatus"><div id="rename" class="dn"><a href="javascript:;" onclick="delfolder(2,'音频',0);" class="menudm bgs1 ico-delete-file1 r" style="width:25px;display: block;" title="删除">&nbsp;</a><a class="menudm bgs1 ico-rename-file1 r" style="width:25px;display: block;" href="javascript:;" onclick="modfolder(2,'音频');" title="重命名">&nbsp;</a><a href="javascript:;" class="menudm bgs1 ico-copy-file r" style="width:25px;display: block;" title="复制链接地址" id="copy102" onclick="copyfolder('2','linchg');">&nbsp;</a></div></td>
      <td></td>
      <td></td>
      <td class="tr">2013-03-23 20:49:39</td>
    </tr>
    <tr>
      <td class="select-file">&nbsp;&nbsp;<input name="f" type="checkbox" disabled></td>
      <td class="file-title f14"><a class="floder ico-type filename filelink" title="bbbccc" href="?folderid=5">bbbccc</a><span class="lgray">(0)</span></td>
      <td class="tr sharestatus"><div id="rename" class="dn"><a href="javascript:;" onclick="delfolder(5,'bbbccc',0);" class="menudm bgs1 ico-delete-file1 r" style="width:25px;display: block;" title="删除">&nbsp;</a><a class="menudm bgs1 ico-rename-file1 r" style="width:25px;display: block;" href="javascript:;" onclick="modfolder(5,'bbbccc');" title="重命名">&nbsp;</a><a href="javascript:;" class="menudm bgs1 ico-copy-file r" style="width:25px;display: block;" title="复制链接地址" id="copy103" onclick="copyfolder('5','linchg');">&nbsp;</a></div></td>
      <td></td>
      <td></td>
      <td class="tr">2013-03-25 10:20:13</td>
    </tr>
    <tr>
      <td class="select-file">&nbsp;&nbsp;<input id="fid" name="fid" type="checkbox" value="603436"></td>
      <td class="file-title f14"><a class="img ico-type filename filelink" title="1443_13043820036zym.jpg" href="/file-603436.html" target="_blank">1443_13043820036zym.jpg</a></td>
      <td class="tr sharestatus"><div id="rename" class="dn"><a href="javascript:;" class="menudm bgs1 ico-delete-file1 r" style="width:25px;display: block;" title="删除" onclick="del_file('603436','0');">&nbsp;</a><a class="menudm bgs1 ico-rename-file1 r" style="width:25px;display: block;" href="javascript:;" title="重命名" onclick="edit_file('603436','1443_13043820036zym','');">&nbsp;</a><a href="javascript:;" class="menudm bgs1 ico-copy-file r" style="width:25px;display: block;" title="复制链接地址" onclick="copy_file('603436','www.yimuhe.com');">&nbsp;</a></div></td>
      <td class="tr">0</td>
      <td class="tr">178.8kb</td>
      <td class="tr">2013-03-25 09:32:11</td>
    </tr>
    <tr>
      <td class="select-file">&nbsp;&nbsp;<input id="fid" name="fid" type="checkbox" value="590684"></td>
      <td class="file-title f14"><a class="txt ico-type filename filelink" title="1.txt" href="/file-590684.html" target="_blank">1.txt</a></td>
      <td class="tr sharestatus"><div id="rename" class="dn"><a href="javascript:;" class="menudm bgs1 ico-delete-file1 r" style="width:25px;display: block;" title="删除" onclick="del_file('590684','0');">&nbsp;</a><a class="menudm bgs1 ico-rename-file1 r" style="width:25px;display: block;" href="javascript:;" title="重命名" onclick="edit_file('590684','1','');">&nbsp;</a><a href="javascript:;" class="menudm bgs1 ico-copy-file r" style="width:25px;display: block;" title="复制链接地址" onclick="copy_file('590684','www.yimuhe.com');">&nbsp;</a></div></td>
      <td class="tr">0</td>
      <td class="tr">3</td>
      <td class="tr">2013-03-23 10:50:46</td>
    </tr>
  </tbody>
</table>
</form>

<!--ul id="previewfilelist" onselectstart="return false;" class="dn clearfix thumblist fl-li">
</ul>
<div class="menubar" id="filemagemenubar">
</div-->
<div class="page mt10 mb10"><span class="l f14">当前所在 <b>根目录</b> 共有 2 个文件  页码 1/1 </span> <span class="r db"><b class='sel'>1</b></span></div>

</div>
</section>

<script language="javascript">
var folder='<select id="folderid" size="1"><option value="0">根目录</option><option value="1">视频</option><option value="3">&nbsp;&nbsp;└&nbsp;www</option><option value="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└&nbsp;aaa</option><option value="2">音频</option><option value="5">bbbccc</option></select>';
function get_folder(mvdir){
	yid_file(mvdir,folder);
}
</script>
<br /><br />
<div style="display:none"><script src="http://s5.cnzz.com/stat.php?id=4551662&web_id=4551662" language="javascript"></script></div>
</body>
</html>
