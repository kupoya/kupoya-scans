<?php 

class Auth extends MY_Controller {
	
	
	public function __construct() {
		
		parent::__construct();

		$this->load->model('brand_model');
		$this->load->model('product_model');
		
		//$this->load->model('user_model');
		$this->load->library('security');
		$this->load->helper('security');
		
		$this->load->library('FBConnect');
	}
	
	
	
	
	
	public function invalid() {
		
		$data = array();
		//$this->load->view('coupon_invalid', $data);
		$this->template->build('coupon/coupon_invalid', $data);
		
	}
	
	
	
	public function index()
	{
		
		// initialize template data variable
		$data = array();
		
		// create nextUrl string for facebook redirect after successful authentication.
		// this is done based on session data where these values were saved when the user
		// attempted accessing the app without authenticating first
		$brandId = $this->session->userdata('brandId');
		$productId = $this->session->userdata('productId');
		
		log_message('debug', ' === brandId: '.$brandId);
		log_message('debug', ' === productId: '.$productId);		
		
		// check for given brandId and productId
		if (!$brandId || !$productId) {
			log_message('debug', ' === invalid 1');
			redirect('auth/invalid');
		}
			
		log_message('debug', ' === 1');
		
		// check that brandId and productId exist in the database
		if ($this->product_model->isExistProductByBrandId($brandId, $productId) !== true) {
			log_message('debug', ' === invalid 2');
			redirect('auth/invalid');
		}
		log_message('debug', ' === 2');
		
		// if we got the brand and product ok, let's pull up brand information
		$brandInfo = $this->brand_model->getBrandInfo($brandId);
		// push brand info into session for other pages 
		$this->session->set_userdata['brand'] = $brandInfo;
		// add the brand information to the view variables 
		$data['brand'] = $brandInfo;
			
		//$nextUrl = site_url("coupon/index/$brandId/$productId");
		$nextUrl = site_url("auth/login/$brandId/$productId");
		//log_message('debug', ' === 3');
		$this->fbconnect->urlNext = $nextUrl; 
		$fbLoginUrl = $this->fbconnect->getLoginUrl();
		
		//log_message('debug', ' === 4');
		$data['facebook'] = array(
			'app_id'		=> $this->fbconnect->getAppId(),
			'perms'			=> $this->fbconnect->config['req_perms'],
			'nextUrl'		=> $nextUrl,
			//'session'		=> $this->fbconnect->getSession(),
			//'user'			=> $this->fbconnect->user,
			'loginUrl'		=> $fbLoginUrl,
		);
				
		log_message('debug', ' === 6');
		$this->load->view('login', $data);
		
	}
	
	
	
	
	/**
	 * User registers for the first time at Kupoya's.
	 * Save user information in the database
	 */
	public function _register() {
		
		$this->load->model('User_model');
		
		$userInfo = $this->fbconnect->user;
        $userInfo['auth_provider'] = 'facebook';

		// data ready, try to create the new user 
		if($query = $this->User_model->create_user($userInfo) ) {
			// $data['account_created'] = true
			// log user in
			//$this->_facebook_validate($db_values["user_id"]);

			return true;

		} else {
			//Did not work, go back to login page
			//$this->index();

			return false;

		}
		
		

	}
	
	
	
	public function login() {
		
		$ret = $this->_doLogin();
		if ($ret === true) {
			$brandId = $this->session->userdata('brandId');
			$productId = $this->session->userdata('productId');
			
			// set user as logged in
			$this->session->set_userdata(array('logged_in' => '1'));
			
			// forward to the coupon page of this brand and product
			redirect('coupon/index/'.$brandId.'/'.$productId);
		} else {
			redirect('auth/index');
		} 		
	}
	
	
	
	public function _doLogin() {
				
		$this->load->model('User_model');
		
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
				$user = $this->User_model->get_user_by_authprovider_uid($fb_uid, 'facebook');
   
				log_message('debug', ' === user returned: '.$user);
				// something bad happened
				if ($user === -1) {
					log_message('debug', ' === login: -1');
					return false;
				}
				
   				//if( is_array($user) && count($user) == 1) {
   				if ($user === true) {
 					// user exists
 					// let's set session data for use in our application
   					//$this->session->set_userdata(array('entity' => $user));
					log_message('debug', ' === login: true');
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
		
		// destroy any session parameters
		// @TODO is this really required??!
		$this->session->sess_destroy();
		
		// redirect the user to the logout
		redirect($fbLogoutUrl);
		
		
	}
	
	
	
}