<?php

class Medium_Facebook extends FBConnect {
	
	public function __construct() {
		parent::__construct();
	}
	
	
	
	
	public function post($params = array()) {
		
		if (!$params)
			return false;
				
log_message('debug', ' === i got params, lets try this');
		try {
log_message('debug', ' === trying to post...');
			$ret = $this->api('me/feed', 'POST', $params);
		} catch (FacebookApiException $e) {
log_message('debug', ' === error happened - you need to allow kupoya app permission to post to your wall');

			return false;
			
		}
		
		return true;
		
	}
	
	
	
	public function checkin($params = array()) {
		
		if (!$params)
			return false;
			
	}
	
	
	
}