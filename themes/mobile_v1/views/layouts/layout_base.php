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

        // fix for facebook's #_=_ bug, @see http://stackoverflow.com/questions/7131909/facebook-callback-appends-to-return-url
        if (String(window.location.hash).substring(0,1) == "#") {
        //if (String(window.location.hash) == '#_=_') {
			window.location.hash = '';
			window.location.href=window.location.href.slice(0, -1);
		}
        // Firefox version of the hack
        //if (String(location.hash) == "#_=_") {
        if (String(window.location.hash).substring(0,1) == "#") {
        	location.hash = "";
			location.href=location.href.substring(0,location.href.length-3);
		}

	</script>


    <?php if (isset($template['partials']['pre_css'])) echo $template['partials']['pre_css']; ?>

	<!--[if IE]> 
		<?php echo css('style-ie.css', '_theme_'); ?>
	<![endif]-->

	<!-- CSS base -->
	<?php echo css('jquery.mobile.min.css', '_theme_'); ?>
	<?php echo $template['partials']['css']; ?>

	

	<?php if (isset($template['partials']['pre_javascript'])) echo $template['partials']['pre_javascript']; ?>

</head>
<body>

<div id="loading">
    <br/><br/>
    <div class="spinner" id="spinner"> 
        <div class="bar1"></div> 
        <div class="bar2"></div> 
        <div class="bar3"></div> 
        <div class="bar4"></div> 
        <div class="bar5"></div> 
        <div class="bar6"></div> 
        <div class="bar7"></div> 
        <div class="bar8"></div> 
        <div class="bar9"></div> 
        <div class="bar10"></div> 
        <div class="bar11"></div> 
        <div class="bar12"></div> 
    </div> 
    <br/><br/>
    Loading please wait...
    <br/><br/>
    <br/><br/>
</div>

<div data-role="page" id="page" style="display: none">
	<div data-role='header'>
		<?php echo $template['partials']['header']; ?>
	</div>

 	<div data-role="content" >
		<?php echo $template['body']; ?>
	</div>

	<div data-role='footer' id="footer">
		<?php echo $template['partials']['footer']; ?>
	</div>

</div>

	<!-- JavaScript base  -->
	<?php 
    	echo js('jquery-1.6.2.min.js', '_theme_');
    ?>

    <!-- Customized theme layout by each brand -->
	<?php echo $template['partials']['theme']; ?>

    <?php if (isset($template['partials']['pre_jquerymobile'])) echo $template['partials']['pre_jquerymobile']; ?>
    
    <?php
        echo js('jquery.mobile.min.js', '_theme_');
	?>

	<?php if (isset($template['partials']['post_javascript'])) echo $template['partials']['post_javascript']; ?>
	
	<?php
	    echo js('microsite.js', '_theme_');
    ?>

	<?php if (isset($template['partials']['save_request_info'])) echo $template['partials']['save_request_info']; ?>

</body>
</html>

