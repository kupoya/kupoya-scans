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
			<!--
			<img src='<?=site_url(htmlentities($picture))?>' alt='logo' height='<?=htmlentities($picture_height)?>' />
			-->
			<img src='<?=image_url('kupoya.png', '_theme_')?>' alt='logo' />
		</div>

		<div id="breadcrumb">
		<!--
			<h3 class='theme_title_text_color'> <?= htmlentities($description, ENT_QUOTES, "UTF-8") ?> </h3>
		-->
			<?= $this->lang->line('welcome_to_your_user_account'); ?>
		</div>
		
	</div>


	<div id="content">

		<div class="min-width">
		
		<!--  BLOCK_1 -->
		<div id="block">
		</div>
		<!--  /BLOCK_1 -->
		
		<div id="center">
			<?php
			
				$content = ''; 
				
				// if (isset($strategy['type']) && $strategy['type'] === 'coupon') {
				// 	$content .= $this->lang->line('share_with_friends') . '<br/>';
				// }

				echo $this->lang->line('user_account_login_description') .'<br/><br/>';
				
				// if (isset($medium['facebook'])) {
						// $content .= $this->lang->line('get_the_deal');
						// $content .= '<br/>';
						$content .= anchor($facebook['loginUrl'], 
											$this->lang->line('login'),
											array('data-ajax' => 'false', 'data-role' => 'button')
										); 
				// }
				
				echo $content;
			?>
			
		<!--  BLOCK_2 -->
		<div id="block">
		</div>
		<!--  /BLOCK_2 -->
			
		</div>
		</div>

	</div>
