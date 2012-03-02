<?php
	$strategy = $this->session->userdata('strategy');
	// if we can't get the curently running strategy just quit it
	if (!isset($strategy['id']))
		return false;



	// get theme_background
	$bg = variable_get($strategy['id'], 'theme_page_bg');
	$temp = explode('color:', $bg);
	if (isset($temp[1])) {
		$css_bg = 'background: #'.$temp[1].';';
	}

	$temp = explode('file:', $bg);
	if (isset($temp[1])) {
		$css_file = 'background: url('.site_url(htmlentities($temp[1])).') top right no-repeat;';
	}
			

/*
<style type="text/css">
	#breadcrumb_happy {padding:14px 0 11px 0; text-align: center; background:#FF3333 url(../img/happy_kupi_head_vsmall.png) no-repeat top left; margin-bottom:6px;}
	.ui-page {
		<?php 
		if (isset($css_bg))
			echo $css_bg;
		elseif (isset($css_file))
			echo $css_file;
		else
			echo 'background: url(../img/body-bg.jpg) top right no-repeat;';
		?>
	}
</style>
*/
?>