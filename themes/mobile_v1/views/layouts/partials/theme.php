<?php
	$strategy = $this->session->userdata('strategy');
	// if we can't get the curently running strategy just quit it
	if (!isset($strategy['id']))
		return false;



	// get theme_background
	$bg = variable_get($strategy['id'], 'theme_page_bg');
	$temp = explode('color:', $bg);
	if (isset($temp[1])) {
		$theme_page_bg_color = 'background: #'.$temp[1].';';
	}
	$temp = explode('file:', $bg);
	if (isset($temp[1])) {
		$theme_page_bg_file = 'background: transparent url('.site_url(htmlentities($temp[1])).') no-repeat center top;';
	}

	// get bluebar/title bg
	$theme_title_bg = variable_get($strategy['id'], 'theme_title_bg');
	$temp = explode('color:', $theme_title_bg);
	if (isset($temp[1])) {
		$theme_title_bg_color = $temp[1];
	}
	$temp = explode('file:', $theme_title_bg);
	if (isset($temp[1])) {
		$theme_title_bg_file = site_url(htmlentities($temp[1]));
	}

	// get bluebar/title text color
	$theme_title_text_color = variable_get($strategy['id'], 'theme_title_text_color');

	// get page text color
	$theme_page_text_color = variable_get($strategy['id'], 'theme_page_text_color');

	// get microdeal coupon contrainer bg
	$theme_microdeal_coupon_contrainer_bg = variable_get($strategy['id'], 'theme_microdeal_coupon_contrainer_bg');

	// get microdeal coupon contrainer text color
	$theme_microdeal_coupon_contrainer_text_color = variable_get($strategy['id'], 'theme_microdeal_coupon_contrainer_text_color');
			
?>

<style type="text/css">
	.highlightBar {
		<?php 
		if (isset($theme_microdeal_coupon_contrainer_bg) && !empty($theme_microdeal_coupon_contrainer_bg))
			echo 'border:dashed 3px #'.$theme_microdeal_coupon_contrainer_bg.';';

		if (isset($theme_microdeal_coupon_contrainer_text_color) && !empty($theme_microdeal_coupon_contrainer_text_color))
			echo 'color:#'.$theme_microdeal_coupon_contrainer_text_color.';';
/*		background: #fff000;
		overflow:hidden;border-radius:5px;-webkit-border-radius:5px;-moz-border-radius:5px;padding:1px;*/
		?>
	}	
	h3.theme_title_text_color {
		<?php
    	if (isset($theme_title_text_color) && !empty($theme_title_text_color))
    		echo 'color: #'.$theme_title_text_color.';';
    	else
    		echo 'color: #ffffff;';
    	?>
	}
	#breadcrumb_happy {
		padding:14px 0 11px 0;
		text-align: center;
		<?php 
		if (isset($theme_title_bg_color))
			echo 'background:#'.$theme_title_bg_color.';';
		elseif (isset($theme_title_bg_file))
			echo 'background:#76cddd url('.$theme_title_bg_file.') no-repeat top left;';
		else
			echo 'background:#76cddd url('.theme_image('happy_kupi_head_vsmall.png').';) no-repeat top left;';
		?>
		margin-bottom:6px;
	}
	#breadcrumb {
		padding:14px 0 11px 0;
		text-align: center;
		<?php 
		if (isset($theme_title_bg_color))
			echo 'background:#'.$theme_title_bg_color.';';
		elseif (isset($theme_title_bg_file))
			echo 'background:#76cddd url('.$theme_title_bg_file.') no-repeat top left;';
		else
			echo 'background:#76cddd;';
		?>
		margin-bottom:6px;
	}
	.ui-page {
		<?php 
		if (isset($theme_page_bg_color))
			echo $theme_page_bg_color;
		elseif (isset($theme_page_bg_file))
			echo $theme_page_bg_file;
		//else
		//	echo 'background: url('.theme_image('happy_kupi_head_vsmall.png').';) top right no-repeat;';
		?>
		-moz-background-size:cover;
    	background-size:cover;
    	position: relative;
    	<?php
    	if (isset($theme_page_text_color) && !empty($theme_page_text_color))
    		echo 'color: #'.$theme_page_text_color.';';
    	?>
	}
</style>


<?php

	// set jquery theme for what the strategy/campaign defined:
	$jqm_theme = variable_get($strategy['id'], 'jqm_theme');
	switch($jqm_theme) {
		case 'a':
		case 'b':
		case 'c':
		case 'd':
		case 'e':
		echo '
<script type="text/javascript">
	// disable jquery mobiles automatic ajax on submit and links loading 
	$(document).bind("mobileinit", function(){
	  $.mobile.page.prototype.options.theme  = "'.$jqm_theme.'";
	});
</script>
';
		break;
	}

?>