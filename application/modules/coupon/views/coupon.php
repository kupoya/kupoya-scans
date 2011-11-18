<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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

//	$picture = (!empty($strategy['picture'])) ? $strategy['picture'] : $brand['picture'];
//	$description = (!empty($strategy['description'])) ? $strategy['description'] : $brand['description'];

	$language = user_language();
	
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
		// fall back to template description for this business
		$description = $this->lang->line('Your_coupon_is_only_a_click_away');
	}
	
	$description = mb_substr($description, 0, 63, 'UTF-8');
?>


<script type="text/javascript">
	function form_submit()
	{

		if (document.get_coupon.tos.checked == true)
			document.get_coupon.submit();
		else
			alert('<?php echo $this->lang->line('Accept_TOS')?>');
	}
</script>


	<div id="header">
		
		<div id="logo">
			<img src='<?=site_url(htmlentities($picture))?>' alt='logo' width='' height='<?=$picture_height?>' />
		</div>

		<div id="breadcrumb">
			<h3 id='white'> <?= htmlentities($description, ENT_QUOTES, "UTF-8") ?> </h3>
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
			<?php
				echo $this->lang->line('Step_2/2')?>: <?php echo $this->lang->line('Get_your_coupon')
				?>
			<br/>
			<button type="reset" onClick="javascript:form_submit('tos');" data-theme="e">
			 	<?= $this->lang->line('Get_your_coupon'); ?>
			 </button>

			 <form name='get_coupon' action='<?php echo site_url('coupon/view') ?>' method='post'>
			 <div data-role="fieldcontain">
			 	<fieldset data-role="controlgroup">
			
					<input type="checkbox" name="tos" id="tos" class="custom" />
					<label for="tos"'>
					<?php
					 	//$terms_of_use_link = '<a href="/info/terms_of_use">'. $this->lang->line('Terms_Of_Use') .'</a>'; 
					 	//echo sprintf($this->lang->line('User_agreement_to_share'), $terms_of_use_link)
					 	echo sprintf($this->lang->line('User_agreement_to_share'), $this->lang->line('Terms_Of_Use'));
					?>
					</label>
			    </fieldset>
			 </div>
			 </form>
		</div>
		
		<!--  BLOCK_2 -->
		<div id="block">
			<?php
				if (isset($blocks['block_2']))
					echo Template_Model::html_view($blocks['block_2']);
			?>		
		</div>
		<!--  /BLOCK_2 -->
		
		</div>

	</div>

