<?php
/*
	$jqm_theme = 'c';

	$strategy = $this->session->userdata('strategy');
	// if we can't get the curently running strategy just quit it
	if (isset($strategy['id'])) {

		// get jqm theme variable from strategy
		$jqm_theme = variable_get($strategy['id'], 'jqm_theme');
		if ($jqm_theme != 'a' && $jqm_theme != 'b' && $jqm_theme != 'c' && $jqm_theme != 'd' && $jqm_theme != 'e')
			$jqm_theme = 'c';
	}



<?php
	if (isset($header_content) && !empty($header_content)) {
		echo $header_content;
	}
?>


<div class="center-wrapper">
<a href="#" data-ajax="false" data-icon="myapp-email" data-role="button" data-inline="true" data-theme="<?= $jqm_theme; ?>"
	style="margin-top: 5px; margin-bottom: 15px; width: 80%;">
	<span class="ui-btn-inner ui-btn-corner-all">GET COUPON</span>
</a>
</div>
*/

	if (isset($footer_content) && !empty($footer_content)) {
		echo $footer_content;
	}
?>


<div class="footer">
	powered by kupoya &nbsp;&copy;&nbsp; 2012
	<br/>
	<a href="/info/privacy_policy"><?= $this->lang->line('Privacy_Policy'); ?></a>
	|
	<a href="/info/terms_of_use"><?= $this->lang->line('Terms_Of_Use'); ?></a>
</div>