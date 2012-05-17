<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	function seconds_to_time($s)
	{
		if (is_numeric($s))
		{
		    $value = array(
		      "years" => 0, "days" => 0, "hours" => 0,
		      "minutes" => 0, "seconds" => 0,
		    );

			$d = intval($s/86400);
			$s -= $d*86400;

			$h = intval($s/3600);
			$s -= $h*3600;

			$m = intval($s/60);
			$s -= $m*60;

			$value['days'] = $d;
			$value['hours'] = $h;
			$value['minutes'] = $m;
			$value['seconds'] = $s;

/*
		    if ($time >= 86400)
			{
		      $value["years"] = floor($time/31556926);
		      if ((int) $value["years"] < 10)
		      	$value["years"] = '0'.$value["years"];

		      $time = ($time%31556926);
		    }

		    if ($time >= 31556926)
		    {
		      $value["days"] = floor($time/31556926);
		      if ((int) $value["days"] < 10)
		      	$value["days"] = '0'.$value["days"];

		      $time = ($time%86400);
		    }

		    if ($time >= 3600)
		    {
		      $value["hours"] = floor($time/3600);
		      if ((int) $value["hours"] < 10)
		      	$value["hours"] = '0'.$value["hours"];

		      $time = ($time%3600);
		    }

		    if ($time >= 60)
		    {
		      $value["minutes"] = floor($time/60);
		      if ((int) $value["minutes"] < 10)
		      	$value["minutes"] = '0'.$value["minutes"];

		      $time = ($time%60);
		    }

		    $value["seconds"] = floor($time);
		      if ((int) $value["seconds"] < 10)
		      	$value["seconds"] = '0'.$value["seconds"];
*/
		    return $value;
	 	}
	 	else
	 	{
	    	return FALSE;
	    }
	}

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
			<img src='<?=site_url(htmlentities($picture))?>' alt='logo' />
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
				//echo sprintf($this->lang->line('users_entered_the_lottery'), $lottery['tickets_usage_info']['tickets_count']);
				/*
				if ($lottery['tickets_usage_info']['remaining_count'] > 0) {
					//echo '<br/>'.sprintf($this->lang->line('users_remaining_for_lottery'), $lottery['tickets_usage_info']['remaining_count']);
					echo '<div class="digits">'.$lottery['tickets_usage_info']['remaining_count'].'<span>'.$this->lang->line('users_remaining_for_lottery').'</span> </div>';
				}
				*/
				if ($strategy['plan_type'] === 'expiration'):
					// if this is an expiration time then we want to print out when this lottery will end
					$diff = ($strategy['expiration_date'] - time());
					// if diff is more than 0 then this expiration date is in the future and we should tell
					// the user when the strategy is over...
					if ($diff >= 0):
						//$days = (int) ($diff/86400) . ' days';
						$expires_time = seconds_to_time($diff);
						//echo '<br/>'.sprintf($this->lang->line('lottery_time_left'), $days);
						echo $this->lang->line('lottery_expires_in');

			?>
						<!-- Countdown dashboard start -->
						<div id="countdown_dashboard">
							<div class="dash days_dash">
								<span class="dash_title">days</span>
								<div class="digit"><?= $expires_time['days'] ?></div>
							</div>

							<div class="dash hours_dash">

								<span class="dash_title">hours</span>
								<div class="digit"><?= $expires_time['hours'] ?></div>
							</div>

							<div class="dash minutes_dash">
								<span class="dash_title">minutes</span>
								<div class="digit"><?= $expires_time['minutes'] ?></div>
							</div>

							<div class="dash seconds_dash">
								<span class="dash_title">seconds</span>
								<div class="digit"><?= $expires_time['seconds'] ?></div>
							</div>

						</div>
						<!-- Countdown dashboard end -->
		<?
				endif;
			endif;
		?>

			<br/><br/>
			<?php
				echo $this->lang->line('Step_2/2')?>: <?php echo $this->lang->line('Get_your_lottery_ticket')
				?>
			<br/>

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