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
	

	
	// setup button images for this strategy
	$image_yes_name = 'wedding_yes_pressed-'.$language.'.png';
	$image_yes_path = image_path($image_yes_name, '_theme_');
	
	$image_yes_alt_name = 'wedding_yes-'.$language.'.png';
	$image_yes_alt_path = image_path($image_yes_alt_name, '_theme_');
	
	$image_no_name = 'wedding_no_pressed-'.$language.'.png';
	$image_no_path = image_path($image_no_name, '_theme_');
	
	$image_no_alt_name = 'wedding_no-'.$language.'.png';
	$image_no_alt_path = image_path($image_no_alt_name, '_theme_');
	
	
	// if the attending variable is set it means we're in a submitted form state
	// so the user already chose one of the options and we will need to highlight it 
	if (isset($attending)) {
		
		if ($attending)
			$image_yes_alt_name = $image_yes_name;
		else
			$image_no_alt_name = $image_no_name;
	}
		

	$header_texts = $this->lang->line('married_header');
	$random_key = array_rand($header_texts);
	$married_header = $header_texts[$random_key];
		
?>

<img src='<?= $image_yes_path?>' style="display: none;" />
<img src='<?= $image_no_path?>' style="display: none;" />
<img src='<?= $image_yes_alt_path?>' style="display: none;" />
<img src='<?= $image_no_alt_path?>' style="display: none;" />

<script type="text/javascript">

function toggle_yes() {

	if (document.images) {
		document["yes"].src = "<?php echo $image_yes_path?>";
		document["no"].src = "<?php echo $image_no_alt_path?>";
		
		weddingFormObj = document.forms['wedding_form'];
		attendingElem = weddingFormObj.elements['attending'];
		attendingElem.value = 1;

		window.location.hash="phase_2";
	}
	
}

function toggle_no() {
	
	if (document.images) {
		document["yes"].src = "<?php echo $image_yes_alt_path?>";
		document["no"].src = "<?php echo $image_no_path?>";

		weddingFormObj = document.forms['wedding_form'];
		attendingElem = weddingFormObj.elements['attending'];
		attendingElem.value = 0;

		window.location.hash="phase_2";
	}
	
}

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

<?php  ?>

	<div id="header">
		
		<div id="logo">
			<img alt="logo" src="<?= site_url(htmlentities($picture)) ?>" width="" height="100" />
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
				
				<form method="post" action="<?= site_url('wedding/confirm')?>" id="ContactForm" name="wedding_form">
					<div>
						<br/><br/>
						
						<?= $this->lang->line('Your_name'); ?> <br />
						<input type="text" <?php if (form_error('name')) echo 'class="error"'; ?>
								name="name" id="name" value="<?= set_value('name', '') ?>" /><br/><br/>
						
						
						<a name='phase_2'></a>
						<?= $this->lang->line('Are_you_planning_to_attend'); ?><br/>
						<input type="hidden" name="attending" id="attending" value="<?= set_value('attending', '0') ?>" />						
						<?php
							echo image($image_yes_alt_name, '_theme_', array('alt' => $this->lang->line('Yes'),
										'name' => 'yes', 'onclick' => 'javascript:toggle_yes()')
							);
						?>
						
						<?php
							echo image($image_no_alt_name, '_theme_', array('alt' => $this->lang->line('No'),
										'name' => 'no', 'onclick' => 'javascript:toggle_no()')
							);
						?>


						<br/><br/>
						<?= $this->lang->line('If_so_with_how_many_attendees'); ?><br/>
						<input type="text" <?php if (form_error('attendees')) echo 'class="error"'; ?>
								name="attendees" id="attendees" class='numbers_1k' value='<?= set_value('attendees', '') ?>' /><br/><br/>
						
						<?= $this->lang->line('You_may_leave_a_message_to_the_happy_couple'); ?><br/>
						<textarea <?php if (form_error('message')) echo 'class="error"'; ?>
								name="message" id="message" rows="5" cols="10"><?= set_value('message', '')?></textarea>
						<br/><br/>
						<input type="hidden" name="submit" id="submit" value="submit" />
						<input type='image'
							src='<?php
								$image = 'wedding_update-'.$language.'.png';
								echo image_path($image, '_theme_'); 
								?>'
							name='' value='' alt='submit' class='button' onClick="javascript:return validate_form();" />
					</div>
				</form>
			
			</div>
		</div>

	</div>

	
