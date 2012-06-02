<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
// var_dump($coupon);
// var_dump($coupon_settings);
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

	//$description = mb_substr($description, 0, 63, 'UTF-8');
	
	if (isset($coupon['purchased_time']))
		list($date, $time) = explode(' ', $coupon['purchased_time']);
	else  
		$date = $time = '00-00';
	
	$website_text = '';
	if ($website && !empty($website))
	{
		if (!empty($brand['name']))
			$website_text = $brand['name'];
		else
			$website_text = $website;
			
		$website_text = sprintf($website_text, $this->lang->line('visit_brand_website'));
	}
	
?>

<script type="text/javascript">
	function form_submit()
	{
		var ret = confirm('<?= $this->lang->line('Are_you_sure_you_want_to_validate')?>');
		if (ret) {
			document.coupon_confirm.submit();
		}
		return false;
	}
</script>

 	<div id="header">
		 
		<div id="logo">
			<img src='<?=site_url(htmlentities($picture))?>' alt='logo' />
		</div>

		<div id="breadcrumb_happy">
			<h3 class='theme_title_text_color'> <?= $this->lang->line('Congratulations')?> </h3>
		</div>
		
	</div>


	<div id="content">
 
		<div class="min-width">
		
		<!--  BLOCK_1 -->
		<div id="block">
			<?php
				if (isset($blocks['block_1']))
					echo Template_Model::html_view($blocks['block_1']);
			?>		
		</div>
		<!--  /BLOCK_1 -->
		
		<div id="center">
			<?= htmlentities($description, ENT_QUOTES, "UTF-8") ?>
			<br/>
			<a href='<?= htmlentities($website, ENT_QUOTES, "UTF-8") ?>'><?= htmlentities($website_text, ENT_QUOTES, "UTF-8") ?></a>
			<br/>


			<br/>
			<div data-inline="true" class="highlightBar">
				<div class="coupon">
						<div class="indent">
							<div id="center">
							<h2> <?= $this->lang->line('this_is_your_coupon')?> </h2>
							<h3><b></b> <?= $coupon['serial'] ?> </b></h3>
								<div>
								<img src='<?= base_url()?>barcode/code128/<?= $coupon['serial'] ?>' width="250" height="71"  />
								<br/>

										<?= $date ?>
									- 
										<?= $time ?>

									<br/><br/>
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
		
		<!--  BLOCK_2 -->
		<div id="block">
			<?php
				if (isset($blocks['block_2']))
					echo Template_Model::html_view($blocks['block_2']);
			?>		
		</div>
		<!--  /BLOCK_2 -->
		

		<?php
			$validate = variable_get($strategy['id'], 'microdeal_validate');
			// if (isset($coupon_settings['validate']) && $coupon_settings['validate'] == 1):
			if (isset($validate) && $validate == '1'):

				// if validate is enabled, check if we need to do lite validation or not
				$validate_use_code = (bool) variable_get($strategy['id'], 'microdeal_validate_use_code');
		?>
		<br/><br/>
		<div id="center">
				<form method="post" action="<?= site_url('coupon/confirm')?>" name="coupon_confirm">
					<div class="ui-body ui-body-a">
					<?= $this->lang->line('validation'); ?> <?= $this->lang->line('validate_business_id:tooltip'); ?>
						<?php if ($validate_use_code): ?>
						<strong>
							<?= $this->lang->line('enter_business_id'); ?> (<?= $this->lang->line('validate_business_id'); ?>)
						</strong>
							<input type="text" name="brand_id" id="brand_id" value="" />
						<?php endif; ?>

						 <button type="submit" onClick="javascript:return form_submit('coupon_confirm');" data-theme="e">
			 				<?= $this->lang->line('validate'); ?>
						 </button>


					 </div>
				</form>
				<br/>
				<br/>
			<?php endif; ?>
		</div>

	</div>
