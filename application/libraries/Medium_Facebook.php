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
log_message('debug', ' === error happened - you need to allow Scanalo APP permission to post to your wall');
			return false;
			// if not permissions forward to apply permissions we need:
			//$url = "http://www.facebook.com/connect/prompt_permissions.php?api_key=***REMOVED***&v=1.0&ext_perm=publish_stream&next=http://datacenter.enginx.com/scanalo/welcome/coupon/1/1";

			// just in case, make sure tables are unlocked
			//$this->db->query('UNLOCK TABLES');
			// unable to post to facebook, mark coupon as used
			//$this->coupon_model->set_coupon_status($coupon['id'], 'new');
			//redirect('auth/index');
		}
		
		return true;
		
	}
	
	
	
	public function checkin($params = array()) {
		
		if (!$params)
			return false;
			
	}
	
	
	
}