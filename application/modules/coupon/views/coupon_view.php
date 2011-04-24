<?php 
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
	
	list($date, $time) = explode(' ', $coupon['purchased_time']);
	
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
								<figure ><img src='<?= $picture ?>' style='width:200px;' alt="logo"></figure>
								<h3><strong> <span class="color1"><?php echo $this->lang->line('Congratulations')?></span></strong></h3>
							</div>
							<br/>
	
							<div>
								<br/>
								<h3><!-- 
									<span class="color1"><?php //echo $this->lang->line('Your_value')?>:</span>
									<br/>
									 -->
									<?= $description ?>
								</h3>
	
							</div>
							
							<div>
								<br/>
								<h3>
									<!-- 
									<?php //echo $this->lang->line('website_for')?>: <span class="color1"><?= $name ?></span>
									<br/>
									 -->
									<a href='<?= $website ?>'><?= $website ?></a>
								</h3>
	
							</div>
							<br/><br/>
						<div class="rbroundbox">
						<div class="rbtop"><div></div></div>
						<div class="rbcontent">
							
							<div>
								<br/><br/>
								<h3>
									<?php echo $this->lang->line('present_this_coupon')?>
									<br/><br/>
									<div style='font-weight:bold'>
									
										<?= $coupon['serial'] ?>
										<br/>
										<div>
										<img src='http://scans.kupoya.com/index.php/barcode/code128/<?= $coupon['serial'] ?>/png' />
										<br/>

											<p style='text-align: left; float: left; margin-left:75px;'> 
												<?= $date ?>
											</p>
											<p style='text-align: right; float: right; margin-right:80px;'>
												<?= $time ?>
											</p>
											<br/>
										</div>
									</div>
								</h3>
							</div>
							
						</div>
						<div class="rbbot"><div></div></div>
						</div>
							
						</div>
<br/><br/>

					<div>
					</article>
				</div>
			</div>
		</div>

<br/><br/>