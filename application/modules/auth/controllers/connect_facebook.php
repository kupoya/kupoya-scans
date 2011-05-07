<?php

class Connect_Facebook extends Connect {
	
	
	public function __construct() {
		
		parent::__construct();

//		$this->load->model('brand_model');
//		$this->load->model('code_model');
//		$this->load->model('strategy_model');
//		$this->load->library('security');
//		$this->load->helper('security');

		$this->load->model('user_model');
		$this->load->library('FBConnect');
		
	}
	
	
	
	
	
	public function invalid() {
		
		$data = array();
		$this->template->build('auth/auth_invalid', $data);
		
	}	
	
	
	
	/**
	 * User registers for the first time at Kupoya's.
	 * Save user information in the database
	 */
	public function _register() {
				
		// get user's facebook information
		$facebook_info = $this->fbconnect->user;
		
		// get user's friends count
		$user_friends = $this->fbconnect->api('me/friends', 'GET');
        
        // set auth provider
        $user_info['auth_provider'] = 'facebook';

        // create user information array
        $user_info['auth_uid'] = $facebook_info['id'];
        $user_info['name'] = isset($facebook_info['name']) ? $facebook_info['name'] : '';
        $user_info['first_name'] = isset($facebook_info['first_name']) ? $facebook_info['first_name'] : '';
        $user_info['last_name'] = isset($facebook_info['last_name']) ? $facebook_info['last_name'] : '';
        $user_info['birthday'] = isset($facebook_info['birthday']) ? $facebook_info['birthday'] : '';
        $user_info['gender'] = isset($facebook_info['gender']) ? $facebook_info['gender'] : 'male';
        $user_info['email'] = isset($facebook_info['email']) ? $facebook_info['email'] : '';
        if ( isset($facebook_info['location']) && isset($facebook_info['location']['name']) )
        	$user_info['location'] = $facebook_info['location']['name'];
        else
        	$user_info['location'] = '';
        
        $user_info['timezone'] = isset($facebook_info['timezone']) ? $facebook_info['timezone'] : '';
        $user_info['locale'] = isset($facebook_info['locale']) ? $facebook_info['locale'] : '';
		$user_info['friends_count'] = isset($user_friends['data']) ? count($user_friends['data']) : 0;

		return parent::register($user_info);
//
	}
	
	

	public function login() {
		
		return parent::login();
		
	}
	
	
	
	
	public function _doLogin() {
				
log_message('debug', ' === IN connect_facebook _doLogin()');
		
		if(!$this->fbconnect->getSession()) {
			//if no session is available the login is invalid
log_message('debug', ' === no session found');
			return false;
			
   		} else {
   			log_message('debug', ' === user found');
			$fb_uid = $this->fbconnect->user_id;
			$fb_usr = $this->fbconnect->user;
   
			if ($fb_uid) {

				// if fb_uid is valid, we check if the user exists in the database 
				$user = $this->user_model->get_user_by_authprovider_uid($fb_uid, 'facebook');
   
log_message('debug', ' === user returned: '.$user);
				// something bad happened
				if ($user === -1) {
					log_message('debug', ' === login: -1');
					return false;
				}
				
   				if (is_array($user)) {
   				//if ($user === true) {
 					// user exists
 					// let's set session data for use in our application
					// push into session
					$this->session->set_userdata('user', $user);   					
log_message('debug', ' === login: true');
					// @TODO update user's logged in time
					return true;

   				} else {
log_message('debug', ' === login: false');
					// user doesn't exist so let's create it
					return $this->_register();
					
				}
			} else {
				//no user id? odd, redirect to index page
				return false;

			}
				
		}
		
	}
	
	
	
	
	
	public function logout() {

		// set nextUrl to index/welcome/invalid page..
		$nextUrl = site_url("auth/invalid");
		$params = array('next' => $nextUrl);
		
		// get facebook api logout link
		$fbLogoutUrl = $this->fbconnect->getLogoutUrl($params);
		
		parent::logout($fbLogoutUrl);
			
	}
	
	
	
}