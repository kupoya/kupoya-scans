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

	$name = (!empty($strategy['name'])) ? $strategy['name'] : $brand['name'];
	$picture = (!empty($strategy['picture'])) ? $strategy['picture'] : $brand['picture'];
	$description = (!empty($strategy['description'])) ? $strategy['description'] : $brand['description'];
	
?>




	<div id="header">
		
		<div id="logo">
			<!-- <img alt="logo" src="images/logo.png"/> -->
			<img alt="logo" src="<?= site_url($picture) ?>" width="" height="100" />
		</div>

		<div id="breadcrumb">
			<h3 id='white'> <?= $name ?> </h3>
		</div>
		
	</div>


	<div id="content">

		<div class="min-width">
			<div id="center">
			<?= $description ?>
			</div>
		</div>

	</div>

	
