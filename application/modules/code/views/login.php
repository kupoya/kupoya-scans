<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//echo "brand:"; 
//var_dump($brand);
//echo "code: ";
//var_dump($code);
//echo "strategy:";
//var_dump($strategy);
//var_dump($medium);
//var_dump($agent);
//var_dump($facebook);
//var_dump($facebook['loginUrl'])


	if ( (isset($brand['picture'])) && (!empty($brand['picture'])) )
		$picture = $brand['picture'];
	elseif ( (isset($strategy['picture'])) && (!empty($strategy['picture'])) )
		$picture = $strategy['picture'];

	/*
	 * no use-case yet for using the brand name
	if ( (isset($brand['name'])) && (!empty($brand['name'])) )
		$name = $brand['name'];
	elseif ( (isset($strategy['name'])) && (!empty($strategy['name'])) )
		$name = $strategy['name'];
	*/
		
	if ( (isset($brand['description'])) && (!empty($brand['description'])) )
		$description = $brand['description'];
	elseif ( (isset($strategy['description'])) && (!empty($strategy['description'])) )
		$description = $strategy['description'];

	
?>

	<div id="header">
		
		<div id="logo">
			<img alt="logo" src="<?= $picture ?>" width="" height="100" />
		</div>

		<div id="breadcrumb">
			<h3 id='white'> <?= $description ?> </h3>
		</div>
		
	</div>


	<div id="content">

		<div class="min-width">

			<?php
				$content = ''; 
				if (isset($medium['facebook'])) {
						$content .= $this->lang->line('Step_1/2') . ': ' . $this->lang->line('Login_to_your_facebook_account');
						$content .= '<br/><br/>';
						$content .= anchor($facebook['loginUrl'], 
											image('fb_connect.png	', '_theme_', array('style' => '',  'alt' => $this->lang->line('facebook_connect')))
										); 
				}
				
				echo $content;
			?>

		</div>

	</div>
