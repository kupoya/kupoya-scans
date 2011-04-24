<?php 

class Connect_Twitter extends Connect {
	
	
	public function __construct() {
		
		parent::__construct();

		$this->load->model('user_model');
		$this->load->library('tweet');
		
		//$this->tweet->enable_debug(TRUE);
		
	}
	
	
	
		
	public function invalid() {
		
		$data = array();
		$this->template->build('auth/auth_invalid', $data);
		
	}	
	
	
	
	/**
	 * User registers for the first time at Kupoya's.
	 * Save user information in the database
	 */
	public function _register($user) {
				
		//$user_info = $this->fbconnect->user;
		
		// get user's friends count
		//$user_friends = $this->fbconnect->api('me/friends', 'GET');
       
        // set auth provider
        $user_info['auth_provider'] = 'twitter';
		// set user's friends count
		$user_info['id'] = $user->id;
		$user_info['first_name'] = $user->name;
		$user_info['location'] = $user->location;
		$user_info['timezone'] = $user->time_zone;
		$user_info['locale'] = $user->lang;
		$user_info['friends_count'] = $user->friends_count;

		return parent::register($user_info);
//
	}
	
	
	
	// @TODO temporary method to redirect the user to twitter to connect
	public function index() {
		
log_message('debug', ' === IN connect_twitter index() 1');
		// This is where the url will go to after auth.
		// ( Callback url )
		
		$this->tweet->set_callback(site_url('auth/connect_twitter/login'));
		
		// Send the user off for login!
		$ret = $this->tweet->login();
		
	}
	
	

	public function login() {
		
log_message('debug', ' === IN connect_twitter login()');
		return parent::login();
		
	}
	
	
	
	
	public function _doLogin() {
				
log_message('debug', ' === IN connect_twitter _doLogin()');
		
		if(!$this->tweet->logged_in()) {
			//if no session is available the login is invalid
log_message('debug', ' === no session found');
			return false;
			
   		} else {
   			
   			// get tokens
   			$tokens = $this->tweet->get_tokens();
   			// get user information
			$twitter_user = $this->tweet->call('get', 'account/verify_credentials');
			
			// if the user object exist an
			if ($twitter_user && $twitter_user->id) {

log_message('debug', ' === user found');
				
				// if user is really valid, we check if the user exists in the database 
				$user = $this->user_model->get_user_by_authprovider_uid($twitter_user->id, 'twitter');
   
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
					return $this->_register($twitter_user);
					
				}
			} else {
				//no user id? odd, redirect to index page
				return false;

			}
				
		}

	}
	
	
	
	
	
	public function logout() {

		// set nextUrl to index/welcome/invalid page..
		//$nextUrl = site_url("auth/invalid");
		//$params = array('next' => $nextUrl);
		
		// get facebook api logout link
		//$fbLogoutUrl = $this->fbconnect->getLogoutUrl($params);
		
		$this->tweet->logout();

		parent::logout();
			
	}
	
	
	
}