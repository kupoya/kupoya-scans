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
	
	
?>

<script type="text/javascript">

function validate_form() {

	var FormObj = document.forms['registration_form'];
	var nameElem = FormObj.elements['name'];
	var contactElem = FormObj.elements['contact'];

	if (nameElem.value == '') {
		alert('<?= $this->lang->line('Please_provide_your_name'); ?>');
		return false;
	}

	if (contactElem.value == '') {
		alert('<?= $this->lang->line('Please_provide_your_contact_info'); ?>');
		return false;
	}

	FormObj.submit();
	
}


</script>

<?php  ?>

	<div id="header">
		
		<div id="logo">
			<img alt="logo" src="<?= site_url(htmlentities($picture)) ?>" width="" height="<?= $picture_height ?>" />
		</div>

		<div id="breadcrumb">
			<h3 id='white'> <?= htmlentities($name, ENT_QUOTES, "UTF-8") ?> </h3>
		</div>
		
	</div>


	<div id="content">

		<div class="min-width">
			<div id="center">


<?php echo validation_errors(); ?>
<br/>
			
				<?= strip_tags($description, html_tags());  ?>
				
				<form method="post" action="<?= site_url('registration/confirm')?>" name="registration_form" >
					<div>
						
						<div data-role="fieldcontain">
						<?= $this->lang->line('Your_name'); ?> <br/>
						<input type="text" <?php if (form_error('name')) echo 'class="error"'; ?>
								name="name" id="name" value="<?= set_value('name', '') ?>" />
						</div>

						<div data-role="fieldcontain">
						<?= $this->lang->line('Your_contact_info'); ?> <br/>
						<input type="text" <?php if (form_error('contact')) echo 'class="error"'; ?>
								name="contact" id="contact" value="<?= set_value('contact', '') ?>" />
						<p class='size_small'><?= $this->lang->line('Your_contact_info:help'); ?></p>
						</div>
						
						<div data-role="fieldcontain">
						<?= $this->lang->line('Message'); ?><br/>
						<textarea <?php if (form_error('message')) echo 'class="error"'; ?>
								name="message" id="message" rows="5" cols="10"><?= set_value('message', '')?></textarea>
						</div>

 					<input type='submit' name='submit' class='ui-btn-hidden'
						 	<?php //onClick="javascript:return validate_form();" ?>
						 	value='<?= $this->lang->line('Send'); ?>' />


					</div>
				</form>
			
			</div>
		</div>

	</div>

	
