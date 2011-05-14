<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//echo "brand:"; 
//var_dump($brand);
//echo "strategy:";
//var_dump($strategy);

//var_dump($agent);
//var_dump($facebook);

//var_dump($facebook['loginUrl'])

$error = $this->session->flashdata('error');
if (!$error)
	$error = '';
	
$tips = $this->lang->line('message_generic_error_tip');
$random_key = array_rand($tips);
$tip = $tips[$random_key];


?>


	<div id="header">
		
		<div id="logo">
			<?= image('kupoya.png', '_theme_', array()); ?>
		</div>

		<div id="breadcrumb">
			<h3 id='white'> <?php echo $this->lang->line('Oops_something_bad_happened')?> </h3>
		</div>
		
	</div>


	<div id="content">

		<div class="min-width">
		<div id="center">
			<?php //echo $this->lang->line('Invalid_coupon')?>
			<?php echo $error ?>
			<br/>
			<?php	echo $this->lang->line('tip') . ': ' . $tip; ?>
			<br/>
			<?= image('kupi_sad_small.png', '_theme_', array( 'alt' => 'kupi is sad')); ?>
		</div>
		</div>

	</div>
