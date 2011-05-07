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
	<?=	css('main.css', '_theme_', array('media' => 'screen', 'title' => 'default')); ?>
	<!-- jQuery Theme CSS -->
	<?=	css('jquery-ui-1.8.9.custom.css', '_theme_'); ?>
	<!-- jQuery jqGrid CSS -->
	<?=	css('ui.jqgrid.css', '_theme_'); ?>

	<!-- JavaScript base - jQuery -->
	<?= js('jquery/jquery-1.4.4.min.js', '_theme_')?>
	<?= js('jquery/jquery-ui-1.8.7.custom.min.js', '_theme_')?>
	
	<script type='text/javascript' src='http://www.google.com/jsapi'></script>
	 	
</head>
<body>

<center>
	<?php 
	//var_dump($brand);
	//var_dump($agent);
	//var_dump($facebook);
	
	//var_dump($facebook['loginUrl'])
	?>
	
	<?php echo $template['partials']['header']; ?>
	<div class="clear">&nbsp;</div>
	 
	<?php echo $template['body']; ?>
	
	<div class="clear">&nbsp;</div>
	 
	<?php echo $template['partials']['footer']; ?>
 </center>
 
</body>
</html>