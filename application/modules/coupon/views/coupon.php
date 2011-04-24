<?php 
//var_dump($brand);
//var_dump($strategy);
//var_dump($agent);
//var_dump($facebook);
//var_dump($agent);var_dump

//echo 'count1:';
//echo count($friends['']);

//var_dump($fbUser);

//var_dump($facebook['loginUrl'])

	$picture = (!empty($strategy['picture'])) ? $strategy['picture'] : $brand['picture'];
	$description = (!empty($strategy['picture'])) ? $strategy['description'] : $brand['description'];
	
?>
		<div class="wrapper">
			<div class="pad">
				<div class="wrapper"><h2></h2></div>
			</div>
			<div class="box pad_bot1 bot">
				<div class="pad marg_top">
					<article class="col1">
						<div style="border: 8px red dashed;">
							<div class="wrapper">
								<figure ><img src='<?= $picture ?>' style='width:300px;' alt="logo"/></figure>
							</div>
	
							<div>
								<br/>
								<h3> <?= $description ?> </h3>
	
							</div>
						</div>
						<br/><br/>



						<div class="wrapper under">

							<div class="rbroundbox">
								<div class="rbtop"><div></div></div>
								<div class="rbcontent">

							   	<h2><?php echo $this->lang->line('Step_2/2')?>: <?php echo $this->lang->line('Get_your_coupon')?></h2>
<a href='<?php echo site_url('coupon/view') ?>'>
	<?php echo image('get-coupon.png', '_theme_', array('alt' => $this->lang->line('Get_your_coupon') )) ?>
</a>

								</div>
								<div class="rbbot"><div></div></div>
							</div>

						</div
<br/><br/>

					<div>
					</article>
				</div>
			</div>
		</div>

<br/><br/>