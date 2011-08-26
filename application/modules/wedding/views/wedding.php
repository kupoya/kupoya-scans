<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
	elseif ( (isset($brand['description'])) && (!empty($brand['description'])) )
		$description = $brand['description'];
	else 
		$description = '';
	
	if ( (isset($strategy['name'])) && (!empty($strategy['name'])) )
		$name = $strategy['name'];
	elseif ( (isset($strategy['name'])) && (!empty($strategy['name'])) )
		$name = $strategy['name'];
	else
		$name = '';
	

	$header_texts = $this->lang->line('married_header');
	$random_key = array_rand($header_texts);
	$married_header = $header_texts[$random_key];
		
?>

 
<script type="text/javascript">


function validate_form() {

	weddingFormObj = document.forms['wedding_form'];
	nameElem = weddingFormObj.elements['name'];

	if (nameElem.value == '') {
		alert('<?= $this->lang->line('Please_provide_your_name'); ?>');
		return false;
	}

	weddingFormObj.submit();
	
}


</script>


	<div id="header">
		
		<div id="logo">
			<img alt="logo" src="<?= site_url(htmlentities($picture)) ?>" width="" height="<?= $picture_height ?>" />
		</div>

		<div id="breadcrumb">
			<h3 id='white'> <?= htmlentities($name, ENT_QUOTES, "UTF-8").' '.$married_header ?> </h3>
		</div>
		
	</div>


	<div id="content">

		<div class="min-width">
			<div id="center">


<?php echo validation_errors(); ?>
<br/>
			
				<?= strip_tags($description, $this->wedding_model->html_tags());  ?>
				
				<form method="post" action="<?= site_url('wedding/confirm')?>" name="wedding_form">
					<div>
						<br/><br/>
						
						<?= $this->lang->line('Your_name'); ?> <br />
						<input type="text" <?php if (form_error('name')) echo 'class="error"'; ?>
								name="name" id="name" value="<?= set_value('name', '') ?>" /><br/><br/>

									
						<div data-role="fieldcontain">
							<?= $this->lang->line('Are_you_planning_to_attend'); ?><br/>
							<select name="attending" id="attending" value="<?= set_value('attending', '0') ?>" data-role="slider">
								<option value="0"><?= $this->lang->line('No'); ?></option>
								<option value="1"><?= $this->lang->line('Yes');?></option>
							</select>
						</div>

						<br/>
						
						<div data-role="fieldcontain">
							<?= $this->lang->line('If_so_with_how_many_attendees'); ?><br/>
						 	<input type="range" name="attendees" id="attendees" value="<?= set_value('attendees', '0') ?>" min="0" max="10" 
						 			<?php if (form_error('attendees')) echo 'class="error"'; ?>  />
						</div>
						<br/>

						<?= $this->lang->line('You_may_leave_a_message_to_the_happy_couple'); ?><br/>
						<textarea <?php if (form_error('message')) echo 'class="error"'; ?>
								name="message" id="message" rows="5" cols="10"><?= set_value('message', '')?></textarea>
						<br/><br/>
						
						 
						 <input type='submit' name='submit' class='ui-btn-hidden'
						 	<?php //onClick="javascript:return validate_form();" ?>
						 	value='<?= $this->lang->line('Update_Status'); ?>' />
						 	
	

						 
					</div>
				</form>
			
			</div>
		</div>

	</div>

	
