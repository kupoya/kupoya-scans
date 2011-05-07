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
			<?= image('kupoya.png', '_theme_', array('height' => '30')); ?>
		</div>

		<div id="breadcrumb"> 
			<h3 id='white'> <?php echo $this->lang->line('Oops_something_bad_happened')?> </h3>
		</div>
		
	</div>


	<div id="content">

		<div class="min-width">
		<center>
			<?php echo $this->lang->line('Invalid_authentication')?>
			<br/>
			<?= image('kupi_sad_small.png', '_theme_', array( 'alt' => 'kupi is sad')); ?>
			<br/><br/><br/>
		</center>
		</div>

	</div>
	