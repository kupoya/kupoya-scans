<?php 
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

	$picture = (!empty($strategy['picture'])) ? $strategy['picture'] : $brand['picture'];
	$name = (!empty($strategy['name'])) ? $strategy['name'] : $brand['name'];
	$description = (!empty($strategy['picture'])) ? $strategy['description'] : $brand['description'];
	
?>
		<div class="wrapper">
			<div class="pad">
				<div class="wrapper"><h2></h2></div>
			</div>
			<div class="box pad_bot1 bot">
				<div class="pad marg_top">
					<article class="col1">
							<div class="wrapper">
								<figure ><img src='<?= $picture ?>' style='width:300px;' alt="logo"/></figure>
							</div>
	
							<div>
								<br/>
								<h3> <?= $name ?> </h3>
	
							</div>
						<br/><br/>



						<div class="wrapper under">

							<div class="rbroundbox">
								<div class="rbtop"><div></div></div>
								<div class="rbcontent">

								<h3> <?= $description ?> </h3>

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