<?php
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

<?php
	$content = ''; 
	if (isset($medium['facebook'])) {
			$content .= '<h2>' . $this->lang->line('Step_1/2') . ': ' . $this->lang->line('Login_to_your_facebook_account') . '</h2>';
			$content .= anchor($facebook['loginUrl'], 
								image('facebook_connect.png', '_theme_', array('style' => 'width:750px;',  'alt' => $this->lang->line('facebook_connect')))
							); 
	}
	
	echo $content;
?>

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
