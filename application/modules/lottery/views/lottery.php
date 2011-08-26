<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
		$description = $this->lang->line('Your_ticket_is_only_a_click_away');
	}
	
	$description = mb_substr($description, 0, 63, 'UTF-8');
?>


<script type="text/javascript">
	function form_submit()
	{

		if (document.mobile_form.tos.checked == true) {
			document.mobile_form.submit();
		} else {
			alert('<?php echo $this->lang->line('Accept_TOS')?>');
			return false;
		}

	}

</script>


	<div id="header">
		
		<div id="logo">
			<img src='<?=site_url(htmlentities($picture))?>' alt='logo' width='' height='<?=$picture_height?>' />
		</div>

		<div id="breadcrumb">
			<h3 id='white'> <?= htmlentities($description) ?> </h3>
		</div>
		
	</div>


	<div id="content">
		<div class="min-width">
		<div id="center">
		
			<?php
				echo sprintf($this->lang->line('users_entered_the_lottery'), $lottery['tickets_usage_info']['tickets_count']);
				if ($lottery['tickets_usage_info']['remaining_count'] > 0) {
					echo '<br/>'.sprintf($this->lang->line('users_remaining_for_lottery'), $lottery['tickets_usage_info']['remaining_count']);
				}
				if ($strategy['plan_type'] === 'expiration') {
					// if this is an expiration time then we want to print out when this lottery will end
					$diff = ($strategy['expiration_date'] - time());
					// if diff is more than 0 then this expiration date is in the future and we should tell
					// the user when the strategy is over...
					if ($diff >= 0) {
						$days = (int) ($diff/86400) . ' days';
						echo '<br/>'.sprintf($this->lang->line('lottery_time_left'), $days);
					}	
				}
			?>
			<br/><br/>
			<?php
				echo $this->lang->line('Step_2/2')?>: <?php echo $this->lang->line('Get_your_lottery_ticket')
				?>
			<br/><br/>
			
			 
			 <form name='mobile_form' action='<?php echo site_url('lottery/view') ?>' method='post'>
			 <div>
			 

			 <button type="reset" onClick="javascript:form_submit();" data-theme="e">
			 	<?= $this->lang->line('Get_ticket'); ?>
			 </button>
			 
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
			 
			 </div>
			 </form>
		</div>
		</div>

	</div>

	
