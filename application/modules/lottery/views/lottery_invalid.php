<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$error = $this->session->flashdata('error');
if (!$error)
	$error = '';
	
$tips = $this->lang->line('message_generic_error_tip');
$random_key = array_rand($tips);
$tip = $tips[$random_key];


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
			<?php echo $error ?>
			<br/>
			<?php	echo $this->lang->line('tip') . ': ' . $tip; ?>
			<br/>
			<?= image('kupi_sad_small.png', '_theme_', array( 'alt' => 'kupi is sad','width'=>'123', 'height'=>'132')); ?>
		</div>
		</div>

	</div>
