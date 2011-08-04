<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
	elseif ( (isset($brand['description'])) && (!empty($brand['description'])) )
		$description = $brand['description'];
	else 
		$description = '';
	
	if ( (isset($strategy['name'])) && (!empty($strategy['name'])) )
		$name = $strategy['name'];
	elseif ( (isset($strategy['name'])) && (!empty($strategy['name'])) )
		$name = $strategy['name'];
	else
		$name = '';
	

	if ( (isset($advertisement['text'])) && !empty($advertisement['text']) )
		$text = $advertisement['text'];
	else
		$text = '';
	
?>




	<div id="header">
		
		<div id="logo">
			<img alt="logo" src="<?= site_url(htmlentities($picture)) ?>" width="" height="<?= $picture_height ?>" />
		</div>

		<div id="breadcrumb">
			<h3 id='white'> <?= htmlentities($name) ?> <br/> <?= htmlentities($description) ?> </h3>
		</div>
		
	</div>


	<div id="content">

		<div class="min-width">
			<div id="center">
			<?= strip_tags($text, $this->advertisement_model->html_tags());?>
			</div>
		</div>

	</div>

	
