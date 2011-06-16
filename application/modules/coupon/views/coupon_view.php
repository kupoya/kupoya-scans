<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
//var_dump($brand);
//var_dump($strategy);
//var_dump($agent);
//var_dump($facebook);
//var_dump($agent);var_dump
//var_dump($fql);
//var_dump($fbUser);

//var_dump($ret);
//var_dump($facebook['loginUrl'])


	$website = (isset($strategy['website']) && !empty($strategy['website'])) ? $strategy['website'] : '';

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
		// fall back to empty text
		$description = '';
	}

	$description = mb_substr($description, 0, 63, 'UTF-8');
	
	if (isset($coupon['purchased_time']))
		list($date, $time) = explode(' ', $coupon['purchased_time']);
	else  
		$date = $time = '00-00';
	
?>





	<div id="header">
		
		<div id="logo">
			<img src='<?=$picture?>' alt='logo' width='' height='<?=$picture_height?>' />
		</div>

		<div id="breadcrumb_happy">
			<h3 id='white'> <?= $this->lang->line('Congratulations')?> </h3>
		</div>
		
	</div>


	<div id="content">

		<div class="min-width">
		<div id="center">
			<?= $description ?>
			<br/>
			<a href='<?= $website ?>'><?= $website ?></a>
			<br/>

			<div class="box">
				<div class="tail-top">
				<div class="tail-bottom">
				<div class="corner-right-bottom">
				<div class="corner-left-bottom">
				<div class="corner-right-top">
				<div class="corner-left-top">
					<div class="indent">
						<div id="center">
						<h2 id='white'> <?= $this->lang->line('present_this_coupon')?> </h2>
						<h3><b></b> <?= $coupon['serial'] ?> </b></h3>
							<div>
							<img src='<?= base_url()?>barcode/code128/<?= $coupon['serial'] ?>' width="250" height="71"  />
								<p style='text-align: left; float: left;'> 
									<?= $date ?>
								</p>
								<p style='text-align: right; float: right;'>
									<?= $time ?>
								</p>
								<br/><br/>
							</div>
						</div>
					</div>
				</div>
				</div>
				</div>
				</div>
				</div>
				</div>
			</div>

		</div>
		</div>

	</div>
