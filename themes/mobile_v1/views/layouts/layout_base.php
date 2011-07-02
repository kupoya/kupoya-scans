<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<meta http-equiv="cache-control" content="max-age=200" />
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
	<?php echo $template['partials']['css']; ?>
	<?php //css('style.css', '_theme_', array('media' => 'handheld, screen')); ?>

	<!-- JavaScript base 
	<?php //echo js('ajax.js', '_theme_')?>
	-->
</head>
<body>
<div class="mainwrapper">
<div class="top-bg">


		<?php echo $template['partials']['header']; ?>

		<?php echo $template['body']; ?>

	<div id="footer">
		<?php echo $template['partials']['footer']; ?>
	</div>
</div>
</div>
</body>
</html>
