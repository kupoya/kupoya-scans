<?php

class Medium_Handler extends CI_Model {
	
	public function Medium_Handler() {
		parent::__construct();
		
		// load language file to get generic post messages
		$this->lang->load('app');
		
		// used for brand contact/address information
		$this->load->model('brand_model');
		
	}
	
	
	
	
	
	public function perform_action($medium = array()) {
		
		if (!$medium)
			return true;
		
		if (isset($medium['none']))
			return true;
		
		if (isset($medium['facebook'])) {
log_message('debug', ' === performing facebook action');
			return $this->perform_action_facebook($medium['facebook']);
		}
		
	}
	
	
	
	public function perform_action_facebook($actions = array()) {
		
		if (!$actions)
			return true;
			
		if (isset($actions['none']))
			return true;
			
log_message('debug', ' === in actions, going to handle one of them...');

		$this->load->library('Medium_Facebook', array('initSession' => false));

		// handle actions
		if (isset($actions['wallpost'])) {

log_message('debug', ' === handling wallpost ');
			
			$brand = $this->session->userdata('brand');
			$strategy = $this->session->userdata('strategy');
			
			
			// check strategy to see if user toggled on the option to set his own text for posting
			// the wallpost, if so let's get this information 
			if (isset($strategy['alt_enabled']) && $strategy['alt_enabled']) {
				
				$link = (!empty($strategy['alt_website'])) ? $strategy['alt_website'] : $strategy['website'];
				$name = (!empty($strategy['alt_name'])) ? $strategy['alt_name'] : $strategy['name'];
				$picture = (!empty($strategy['alt_picture'])) ? $strategy['alt_picture'] : $strategy['picture'];
				$picture = site_url($picture, true);
				
				// the message
				// example: $message = "Hi all, I've just visited ".$brand['name']." in ".$brand_contact['address']." and enjoyed ".$name;
				$message = (!empty($strategy['alt_message'])) ? $strategy['alt_message'] : $this->get_message_text('message_generic_post');
				
				if (empty($link))
					$link = "http://www.kupoya.com";
				
			} else {
			
				$link = (isset($strategy['website']) && !empty($strategy['website'])) ? $strategy['website'] : $brand['website'];
				$name = (isset($strategy['name']) && !empty($strategy['name'])) ? $strategy['name'] : $brand['name'];
				$picture = (isset($strategy['picture']) && !empty($strategy['picture'])) ? $strategy['picture'] : $brand['picture'];
				$picture = site_url($picture, true);
				
				// the message
				// example: $message = "Hi all, I've just visited ".$brand['name']." in ".$brand_contact['address']." and enjoyed ".$name;
				$message = $this->get_message_text('message_generic_post');
				
				if (empty($link))
					$link = "http://www.kupoya.com";
				
			}
			
			// the description
			// example: $description = 'made possible by Kupoya';
			$description = $this->get_message_text('message_generic_signature');
			
			$params = array( 'message' => $message, 
						'link' => $link,
						'name' =>  $name,
						'description' => $description,
						'picture'=> $picture,
			);
			
log_message('debug', ' === created params so far');
			return $this->medium_facebook->post($params);
			
			
			/*
			try {
				$ret = $this->fbconnect->api('me/feed', 'POST', $post);
			} catch (FacebookApiException $e) {
log_message('debug', ' === error happened - you need to allow Scanalo APP permission to post to your wall');
				//return false;
				// if not permissions forward to apply permissions we need:
				//$url = "http://www.facebook.com/connect/prompt_permissions.php?api_key=***REMOVED***&v=1.0&ext_perm=publish_stream&next=http://datacenter.enginx.com/scanalo/welcome/coupon/1/1";
	
				// if not permissions forward to apply permissions we need:
				$next_url = $this->urlNext;
	log_message('debug', ' === nextUrl set to '.$next_url);
				
				$perm = $this->config['req_perms'];
				$api_key = $this->config['app_id'];
				$perm_url = 'http://m.facebook.com/connect/prompt_permissions.php?api_key='.$api_key.
								'&v=1.0&ext_perm='.$perm.'&next='.$next_url;
				
				//redirect($next_url);
			
			}
			*/
			
		}
		
			
			
		
		
		
	}
	
	
	
	
	
	public function get_message_text($message = null) {
		
		if (!$message)
			return '';
				
		$brand = $this->session->userdata('brand');
		$strategy = $this->session->userdata('strategy');
		
		$brand_contact = $this->brand_model->get_brand_contact_info($brand['id']);
		
		$location = isset($brand_contact['city']) ? $brand_contact['city'] : $brand_contact['state'];
		if (!$location)
			$location = 'this great place';
			
		
		// get message text
		$message = $this->lang->line($message);
			
		// get random key for message array
		$random_key = array_rand($message);
		
		return sprintf($message[$random_key], $brand['name'], $location, $strategy['name']);

	}
	
	
	
}

