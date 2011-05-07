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

	$picture = (!empty($strategy['picture'])) ? $strategy['picture'] : $brand['picture'];
	$description = (!empty($strategy['picture'])) ? $strategy['description'] : $brand['description'];
	
?>




	<div id="header">
		
		<div id="logo">
			<!-- <img alt="logo" src="images/logo.png"/> -->
			<img alt="logo" src="<?= $picture ?>" width="125" height="100" />
		</div>

		<div id="breadcrumb">
			<h3 id='white'> <?= $description ?> </h3>
		</div>
		
	</div>


	<div id="content">

		<div class="min-width">

			<?php echo $this->lang->line('Step_2/2')?>: <?php echo $this->lang->line('Get_your_coupon')?>
			<br/><br/>
			<a href='<?php echo site_url('coupon/view') ?>'>
				<?php echo image('get_coupon.png', '_theme_', array('alt' => $this->lang->line('Get_your_coupon') )) ?>
			</a>
		</div>

	</div>

	