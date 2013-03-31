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

<?php echo $content;?> 

<?php
echo isset($js_footer) ? $js_footer: '';
echo isset($css_footer) ? $css_footer: '';
?>
</body>
</html>
