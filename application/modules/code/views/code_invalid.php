<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//echo "brand:"; 
//var_dump($brand);
//echo "strategy:";
//var_dump($strategy);

//var_dump($agent);
//var_dump($facebook);

//var_dump($facebook['loginUrl'])

?>


	<div id="header">
		
		<div id="logo">
			<?= image('kupoya.png', '_theme_', array('width'=>'120', 'height'=>'31')); ?>
		</div>

		<div id="breadcrumb">
			<h3 id='white'> <?php echo $this->lang->line('Oops_something_bad_happened')?> </h3>
		</div>
		
	</div>


	<div id="content">

		<div class="min-width">
		<div id="center">
			<?php echo $this->lang->line('Invalid_code')?>
			<br/>
			<?= image('kupi_sad_small.png', '_theme_', array('alt' => 'kupi is sad','width'=>'123', 'height'=>'132')); ?>
			<br/><br/><br/>
		</div>
		</div>

	</div>
