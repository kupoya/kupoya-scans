<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//echo "brand:"; 
//var_dump($brand);
//echo "code: ";
//var_dump($code);
//echo "strategy:";
//var_dump($strategy);
//var_dump($medium);
//var_dump($agent);
//var_dump($facebook);
//var_dump($facebook['loginUrl'])

	$language = user_language();

	$picture_height = '100';
	if ( (isset($brand['picture'])) && (!empty($brand['picture'])) )
		$picture = $brand['picture'];
	elseif ( (isset($strategy['picture'])) && (!empty($strategy['picture'])) )
		$picture = $strategy['picture'];
	else {
		// fall back to kupoya's logo if no picture was found for brand or strategy
		$picture_height = '';
		$picture = 'kupoya.png';
	}
		
		
	if ( (isset($strategy['name'])) && (!empty($strategy['name'])) )
		$description = $strategy['name'];
	elseif ( (isset($brand['name'])) && (!empty($brand['name'])) )
		$description = $brand['name'];
	else {
		// fall back to template description for this business
		$description = $this->lang->line('Welcome!');
	}

	$description = mb_substr($description, 0, 63, 'UTF-8');
	
?>

	<div id="header">
		
		<div id="logo">
			<img src='<?=site_url(htmlentities($picture))?>' alt='logo' width='' height='<?=htmlentities($picture_height)?>' />
		</div>

		<div id="breadcrumb">
			<h3 id='white'> <?= htmlentities($description, ENT_QUOTES, "UTF-8") ?> </h3>
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
			<?php
			
				$content = ''; 
				
				if (isset($strategy['type']) && $strategy['type'] === 'coupon') {
					$content .= $this->lang->line('Get_a_coupon_in_two_simple_steps') . '<br/>';
				}
				
				if (isset($medium['facebook'])) {
						$content .= $this->lang->line('Step_1/2') . ': ' . $this->lang->line('Login_to_your_facebook_account');
						$content .= '<br/>';
						$content .= anchor($facebook['loginUrl'], 
											$this->lang->line('facebook_connect'), 
											array('data-ajax' => 'false', 'data-role' => 'button', 'data-theme' => 'e')
										); 
				}
				
				echo $content;
			?>
			
		<!--  BLOCK_2 -->
		<div id="block">
			<?php
				if (isset($blocks['block_2']))
					echo Template_Model::html_view($blocks['block_2']);
			?>		
		</div>
		<!--  /BLOCK_2 -->
			
		</div>
		</div>

	</div>
