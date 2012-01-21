<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

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

	//$description = mb_substr($description, 0, 63, 'UTF-8');
	
	if (isset($coupon['purchased_time']))
		list($date, $time) = explode(' ', $coupon['purchased_time']);
	else  
		$date = $time = '00-00';
	
	if (!empty($brand['name']))
		$website_text = $brand['name'];
	else
		$website_text = $website;
		
	$website_text = sprintf($website_text, $this->lang->line('visit_brand_website'));
	
?>





	<div id="header">
		
 		<div id="logo">
		</div>
<!-- 		<div id="logo">
			<img src='<?=site_url(htmlentities($picture))?>' alt='logo' width='' height='<?=$picture_height?>' />
		</div> -->

		<div id="breadcrumb">
			<h3 id='white'> <?= $this->lang->line('enjoy_your_coupon')?> </h3>
		</div>
		
	</div>


	<div id="content">

		<div class="min-width">
				
		<div id="center">
			<div class="box">
				<div class="tail-top">
				<div class="tail-bottom">
				<div class="corner-right-bottom">
				<div class="corner-left-bottom">
				<div class="corner-right-top">
				<div class="corner-left-top">
					<div class="indent">
						<div id="center">
						<h2 id='white'> <?= $this->lang->line('coupon_has_been_validated'). ', ' .
											$this->lang->line('courtesy_of')?>
						</h2>
						<div id="logo">
							<img src='<?=site_url(htmlentities($picture))?>' alt='logo' width='' height='<?=$picture_height?>' />
						</div>
						<h2 id='white'> <?php isset($brand['name']) ? $brand['name'] : '' ?></h2>
						</div>
					</div>
				</div>
				</div>
				</div>
				</div>
				</div>
				</div>
			</div>

		</div>

	</div>
