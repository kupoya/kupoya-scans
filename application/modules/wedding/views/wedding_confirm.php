<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	$picture_height = '100';
	if ( (isset($strategy['picture'])) && (!empty($strategy['picture'])) )
		$picture = $strategy['picture'];
	elseif ( (isset($brand['picture'])) && (!empty($brand['picture'])) )
		$picture = $brand['picture'];
	else {
		// fall back to kupoya's logo if no picture was found for brand or strategy
		$picture_height = '';
		$picture = 'kupoya.png';
	}
	
	if ( (isset($strategy['name'])) && (!empty($strategy['name'])) )
		$name = $strategy['name'];
	elseif ( (isset($strategy['name'])) && (!empty($strategy['name'])) )
		$name = $strategy['name'];
	else
		$name = '';
		
?>

	<div id="header">
		
		<div id="logo">
			<img alt="logo" src="<?= site_url(htmlentities($picture)) ?>" />
		</div>

		<div id="breadcrumb">
			<h3 id='white'> <?= htmlentities($name, ENT_QUOTES, "UTF-8") ?> </h3>
		</div>
		
	</div>


	<div id="content">

		<div class="min-width">
		
		<!--  BLOCK_1 -->
		<div id="block">
			<?php
				if (isset($blocks['block_1']))
					echo Template_Model::html_view($blocks['block_1']);
			?>		
		</div>
		<!--  /BLOCK_1 -->
		
			<div id="center">
			
				<?= $this->lang->line('thank_you') ?>
				<br/><br/>
				<?php 
				
					if (isset($strategy['expiration_date']))
						$exp = date('Y-m-d', $strategy['expiration_date']);
					else
						$exp = $this->lang->line('preferably_by');
					
					if ($attending)
						echo sprintf($this->lang->line('confirm_yes_msg'),  $exp);
					else
						echo sprintf($this->lang->line('confirm_no_msg'), $exp);
				?>
				
				<br/><br/>
			</div>
		</div>

	</div>

	
