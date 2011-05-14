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


	$name = (!empty($strategy['name'])) ? $strategy['name'] : $brand['name'];
	$website = (!empty($strategy['website'])) ? $strategy['website'] : $brand['website'];
	$picture = (!empty($strategy['picture'])) ? $strategy['picture'] : $brand['picture'];
	$description = (!empty($strategy['picture'])) ? $strategy['description'] : $brand['description'];
	
	if (isset($coupon['purchased_time']))
		list($date, $time) = explode(' ', $coupon['purchased_time']);
	else  
		$date = $date = '00-00';
	
?>





	<div id="header">
		
		<div id="logo">
			<!-- <img alt="logo" src="images/logo.png"/> -->
			<img alt="logo" src="<?= $picture ?>" width="125" height="100" />
		</div>

		<div id="breadcrumb_happy">
			<h3 id='white'> <?= $this->lang->line('Congratulations')?> </h3>
		</div>
		
	</div>


	<div id="content">

		<div class="min-width">

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
							<img src='<?= base_url()?>barcode/code128/<?= $coupon['serial'] ?>/png' height="80" width="200" />
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
