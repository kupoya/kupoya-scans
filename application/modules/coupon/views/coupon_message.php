<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
// var_dump($coupon);
// var_dump($coupon_settings);
//var_dump($brand);
//var_dump($strategy);
//var_dump($agent);
//var_dump($facebook);
//var_dump($agent);var_dump
//var_dump($fql);
//var_dump($fbUser);

//var_dump($ret);
//var_dump($facebook['loginUrl'])

	$website = (isset($strategy['website']) && !empty($strategy['website'])) ? $strategy['website'] : '';

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
	
	if ( (isset($strategy['description'])) && (!empty($strategy['description'])) )
		$description = $strategy['description'];
	elseif ( (isset($strategy['name'])) && (!empty($strategy['name'])) )
		$description = $strategy['name'];
	else {
		// fall back to empty text
		$description = '';
	}

	// $description = mb_substr($description, 0, 63, 'UTF-8');

	$website_text = '';
	if ($website && !empty($website))
	{
		if (!empty($brand['name']))
			$website_text = $brand['name'];
		else
			$website_text = $website;
			
		$website_text = sprintf($website_text, $this->lang->line('visit_brand_website'));
	}
	
?>
 	<div id="header">
		 
		<div id="logo">
			<img src='<?=site_url(htmlentities($picture))?>' alt='logo' height='100px' />
		</div>

		<div id="breadcrumb">
			<!-- <h3 class='theme_title_text_color'> <?= $this->lang->line('Congratulations')?> </h3>-->
			<h3 class='theme_title_text_color'>
			תודה עך תרומתך לקמפיין ראש השנה של פתחון לב
			</h3>
		</div>
		
	</div>


	<div id="content">
 		
		<!--  BLOCK_1 -->
		<div id="block">
			<?php
				if (isset($blocks['block_1']))
					echo Template_Model::html_view($blocks['block_1']);
			?>		
		</div>
		<!--  /BLOCK_1 -->
		
		<div id="center">
			<?= htmlentities($description, ENT_QUOTES, "UTF-8") ?>
			<br/>
		
	</div>
