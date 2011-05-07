<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?= $template['title']; ?></title>
	<?php echo $template['metadata']; ?>
	<?php //echo $template['partials']['metadata']; ?>
	
	<!-- Appllication base config -->    
	<script type="text/javascript">
	    var APPPATH_URI_ASSETS = "<?php echo $this->config->item('asset_dir');?>";
	    var BASE_URL = "<?php echo base_url();?>";
	    var BASE_URI = "<?php echo BASE_URI;?>";
	    var APPPATH_URI = "<?php echo APPPATH_URI; ?>";
	    var APPPATH_URL = "<?php echo APPPATH_URL; ?>";
	</script>


	<!-- CSS base -->
	<?=	css('reset.css', '_theme_', array('media' => 'screen', 'title' => 'default')); ?>
	<!-- jQuery Theme CSS -->
	<?=	css('layout.css', '_theme_'); ?>
	<!-- jQuery jqGrid CSS -->
	<?=	css('style.css', '_theme_'); ?>

	<!-- JavaScript base - jQuery
	<?php //echo js('jquery/jquery-1.4.4.min.js', '_theme_')?>
	<?php //echo js('jquery/jquery-ui-1.8.7.custom.min.js', '_theme_')?>
	<script type='text/javascript' src='http://www.google.com/jsapi'></script>
	 -->	 	
</head>
<body id="page5">

<div class="main">
<!-- header -->
	<header>
		<div class="wrapper">

		</div>
	</header>
<!-- / header -->
<!-- content -->
	<section id="content">

	<?php echo $template['partials']['header']; ?>
	<div class="clear">&nbsp;</div>
	 
	<?php echo $template['body']; ?>
	
	<div class="clear">&nbsp;</div>
	 
	</section>
<!-- / content -->
<!-- footer -->
	<footer>
		<?php echo $template['partials']['footer']; ?>
		<!-- 
		<a href="http://www.templatemonster.com/" target="_blank">Website template</a> designed by TemplateMonster.com<br>
		<a href="http://www.templates.com/product/3d-models/" target="_blank">3D Models</a> provided by Templates.com
		 -->
	</footer>
<!-- / footer -->
</div>
</body>
</html>