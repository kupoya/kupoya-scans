<?php 

/* The MX_Controller class is autoloaded as required */

class MY_Controller extends CI_Controller {
	
	
	public function __construct() {
		
		parent::__construct();
		//$this->load->library('FBConnect');	
		
		// enable mobile-only support mode
		/*
		$this->load->library('user_agent');
		if (! $this->agent->is_mobile() )
			redirect('http://www.kupoya.com/');
		*/
		
		// set theme 
		$this->asset->set_theme('default');
		$this->template->set_theme('default');
		
		// template settings
		$this->template->enable_parser(FALSE); // default true
		$this->template->set_layout('layout_base');
		$this->template->set_partial('header', 'layouts/partials/header', FALSE);
		$this->template->set_partial('footer', 'layouts/partials/footer', FALSE);
		
		
	}
	
	
	
	protected function _getStatus() {
		
	}
	
	
	
	
	
	public function _requireLogin() {
		
		// if we got the brand id and product id let's validate the user is logged in
		$status = $this->session->userdata('logged_in');
		if ($status !== '1') {
			log_message('debug', ' === detected user NOT logged in');
			// user is not logged in, redirect to index/welcome page
			redirect('auth/invalid');
		}
		
		log_message('debug', ' === detected user logged in');
		return true;

	}
	
	
	/*
	public function Login() {
		
		if ($this->_requireLogin() === false)
			redirect('auth/index');

		$this->session->set_userdata(array('logged_in' => '1'));
			
		return true;
		
	}
	
	
	
	
	protected function _requireLogin() {
		
		$this->load->library('FBConnect');
		
		$ret = $this->load->model('User_model');
		
		if(!$this->fbconnect->getSession()) {
			//if no session is available the login is invalid
			error_log('no session found');
			return false;
			
   		} else {
   			error_log('user found');
			$fb_uid = $this->fbconnect->user_id;
			$fb_usr = $this->fbconnect->user;
   
			if ($fb_uid) {

				// if exists, we check if the user exists in the database 
				$user = $this->User_model->get_user_by_authprovider_uid($fb_uid, 'facebook');
   
				error_log('user returned: '.$user);
				// something bad happened
				if ($user === -1) {
					error_log('login: -1');
					return false;
				}
				
   				//if( is_array($user) && count($user) == 1) {
   				if ($user === true) {
 					// user exists
 					// let's set session data for use in our application
   					//$this->session->set_userdata(array('entity' => $user));
					error_log('login: true');
					return true;

   				} else {
   					error_log('login: false');
					// user doesn't exist so let's create it
					$userInfo = $this->fbconnect->user;
            		$userInfo['auth_provider'] = 'facebook';
            		
					// data ready, try to create the new user 
					if($query = $this->User_model->create_user($userInfo) ) {
						//$data['account_created'] = true;
						// log user in
						//$this->_facebook_validate($db_values["user_id"]);

						return true;

					} else {
						//Did not work, go back to login page
						//$this->index();
						
						return false;

					}
				}
			} else {
				//no user id? odd, redirect to index page
				return false;

			}
				
		}
		
	}
	
	*/
	
	
}