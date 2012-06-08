
<div class="center-wrapper">

	<?php
		/*
		$content = ''; 
		if (isset($strategy['type']) && $strategy['type'] === 'coupon') {
			$content .= $this->lang->line('share_with_friends') . '<br/>';
		}
		*/

		$jqm_theme = 'c';

		$strategy = $this->session->userdata('strategy');
		// if we can't get the curently running strategy just quit it
		if (isset($strategy['id'])) {

			// get jqm theme variable from strategy
			$jqm_theme = variable_get($strategy['id'], 'jqm_theme');
			if ($jqm_theme != 'a' && $jqm_theme != 'b' && $jqm_theme != 'c' && $jqm_theme != 'd' && $jqm_theme != 'e')
				$jqm_theme = 'c';
		}

		if (isset($medium['facebook'])):
			//$content .= $this->lang->line('get_the_deal');
			//$content .= '<br/>';
			/*
			$content .= anchor($facebook['loginUrl'], 
								$this->lang->line('share_and_get'), 
								array('data-ajax' => 'false', 'data-role' => 'button')
							); 
			*/
			
	?>

	<a href="<?= $facebook['loginUrl']; ?>"
		data-ajax="false" data-icon="facebook" data-role="button" data-inline="true" data-theme="<?= $jqm_theme; ?>"
		style="margin-top: 5px; margin-bottom: 15px; width: 80%;">
		<span class="ui-btn-inner ui-btn-corner-all"><?= $this->lang->line('share_and_get') ?></span>
	</a>

	<?php endif; ?>

</div>