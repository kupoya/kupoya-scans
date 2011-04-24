<?php
//echo "brand:"; 
//var_dump($brand);
//echo "strategy:";
//var_dump($strategy);

//var_dump($agent);
//var_dump($facebook);

//var_dump($facebook['loginUrl'])

$error = $this->session->flashdata('error');
if (!$error)
	$error = '';

?>

		<div class="wrapper">
			<div class="pad">
				<div class="wrapper"><h2></h2></div>
			</div>
			<div class="box pad_bot1 bot">
				<div class="pad marg_top">
					<article class="col1">
					<!-- 
						<div class="wrapper">
							<figure ><img src='#none' style='width:480px;' alt="logo"></figure>
						</div>
 					-->
						<div class="wrapper under">
							<h3><strong></strong> <span class="color1"><?php echo $this->lang->line('Oops_something_bad_happened')?></span>
							<br/><br/>
							
							</h3>
<br/><br/>
						</div>

						<div class="wrapper under">

							<div class="rbroundbox">
							<div class="rbtop"><div></div></div>
							<div class="rbcontent">
							<h3>
								<?php echo $error ?>
							</h3>
							<br/><br/>
														
							</div>
							<div class="rbbot"><div></div></div>
							</div>

						</div>
<br/><br/>

					<div>

			</div>
					</article>
				</div>
			</div>
		</div>

<br/><br/>
