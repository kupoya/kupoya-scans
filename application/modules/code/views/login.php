<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//echo "brand:"; 
//var_dump($brand);
//echo "strategy:";
//var_dump($strategy);
//var_dump($medium);
//var_dump($agent);
//var_dump($facebook);

//var_dump($facebook['loginUrl'])

	$picture = $brand['picture']; 
	$description = $brand['description'];
	$name = $brand['name']; 
	
/*	
	$myName = 'liran';
	$text_options = $this->lang->line('test1');
	$key = array_rand($text_options);
	$str = sprintf($text_options[$key], $myName);
	echo $str;
*/ 

?>

	<div id="header">
		
		<div id="logo">
			<img alt="logo" src="<?= $picture ?>" width="125" height="100" />
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
