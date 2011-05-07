<?php
//echo "brand:"; 
//var_dump($brand);
//echo "strategy:";
//var_dump($strategy);

//var_dump($agent);
//var_dump($facebook);

//var_dump($facebook['loginUrl'])

	$picture = $brand['picture']; 
	$description = $brand['description'];
	$name = $brand['name']; 

?>

		<div class="wrapper">
			<div class="pad">
				<div class="wrapper"><h2></h2></div>
			</div>
			<div class="box pad_bot1 bot">
				<div class="pad marg_top">
					<article class="col1">
						<div class="wrapper">
							<figure ><img src='<?= $picture ?>' style='width:480px;' alt="logo"></figure>
						</div>

						<div class="wrapper under">
							<h3><strong><?php //echo $name ?></strong> <span class="color1"><?= $name ?></span>
							<br/>
							<?= $description ?>
							</h3>
<br/><br/>
						</div>

						<div class="wrapper under">

							<div class="rbroundbox">
							<div class="rbtop"><div></div></div>
							<div class="rbcontent">

							   <h2>Step 1/2: Login to your facebook account</h2>
<?php
	if ($strategy['action'] === 'facebook'):
?>
<a href='<?php echo $facebook['loginUrl'] ?>' />
	<?php echo image('facebook_connect.png', '_theme_', array('style' => 'width:750px;',  'alt' =>'facebook connect')) ?>
</a>
<?php 
	endif;
?>

							</div>
							<div class="rbbot"><div></div></div>
							</div>

						</div>
<br/><br/>

<h3> powered by  <?php echo image('kupoya.png', '_theme_') ?> </h3>

					<div>

			</div>
					</article>
				</div>
			</div>
		</div>

<br/><br/>
