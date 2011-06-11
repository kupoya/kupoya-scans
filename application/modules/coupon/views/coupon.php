<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//var_dump($brand);
//var_dump($strategy);
//var_dump($agent);
//var_dump($facebook);
//var_dump($agent);var_dump

//var_dump($facebook);

//echo 'count1:';
//echo count($friends['']);

//var_dump($fbUser);

//var_dump($facebook['loginUrl'])

//	$picture = (!empty($strategy['picture'])) ? $strategy['picture'] : $brand['picture'];
//	$description = (!empty($strategy['description'])) ? $strategy['description'] : $brand['description'];
	
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
		// fall back to template description for this business
		$description = $this->lang->line('Your_coupon_is_only_a_click_away');
	}
	
	$description = mb_substr($description, 0, 63, 'UTF-8');
?>




	<div id="header">
		
		<div id="logo">
			<?= image($picture, '_theme_', array('width' => '', 'height' => $picture_height, 'alt' => 'logo')) ?>
		</div>

		<div id="breadcrumb">
			<h3 id='white'> <?= $description ?> </h3>
		</div>
		
	</div>


	<div id="content">

		<div class="min-width">

			<?php
				echo $this->lang->line('Get_a_coupon_in_two_simple_steps');
				echo '<br/>'; 
				echo $this->lang->line('Step_2/2')?>: <?php echo $this->lang->line('Get_your_coupon')
				?>
			<br/><br/>
			<a href='<?php echo site_url('coupon/view') ?>'>
				<?php echo image('get_coupon.png', '_theme_', array('alt' => $this->lang->line('Get_your_coupon') )) ?>
			</a>
			<li> <?php echo $this->lang->line['User_agreement_to_share'] ?> </li>
		</div>

	</div>

	
