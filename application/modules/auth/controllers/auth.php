<?php 

class Auth extends Connect {
	
	
	public function __construct() {

		parent::__construct();
		
		$language = $this->getLanguage();
		$this->lang->load('auth', $language);
		$this->lang->load('app', $language);
		
		$this->load->library('FBConnect', array('initSession' => false));
		
	}
	
	
	/**
	 * End user login (theoretically could go into the user module/controller though preferably left in the auth module for now)
	 * 
	 */
	public function login() {
		
		// $this->load->model('brand_model');
		// $this->load->model('code/code_model');
		// $this->load->model('strategy_model');
		// $this->load->model('medium_model');	
		
		//$this->load->model('user/user_model');
		$this->load->helper('security');
		$this->load->helper('url');
		$this->load->helper('array');
		$this->load->helper('user_experience');
		
		$this->load->library('FBConnect', array('initSession' => false));
		$this->load->library('user_agent');
		$this->load->library('cache');

		if ($this->_isLoggedIn() === true) {
			redirect('user');
		}

		// create nextUrl string for facebook redirect after successful authentication.
		// this is done based on session data where these values were saved when the user
		// attempted accessing the app without authenticating first
		$nextUrl = site_url("auth/connect_facebook/login?destination=user");
		$this->fbconnect->urlNext = $nextUrl;
		
		// get the login url with all of facebook url info
		$fbLoginUrl = $this->fbconnect->getLoginUrl();
		
		// load language from strategy definition
		// $language = $this->getLanguageInitialize($strategy_info);
		// $this->lang->load('code/code', $language);
		// $this->lang->load('app', $language);
		// $this->lang->load('coupon/coupon', $language);

		$data['facebook'] = array(
			'app_id'		=> $this->fbconnect->getAppId(),
			// in pre SDK3 the parameters key was 'perms', now it's 'scope'
			'scope'			=> $this->fbconnect->config['req_perms'],
			'display'		=> 'touch',
			// in pre SDK3 the parameters key was 'next_url', now it's 'redirect_uri'
			'redirect_uri'		=> $nextUrl,
			//'session'		=> $this->fbconnect->getSession(),
			//'user'			=> $this->fbconnect->user,
			'loginUrl'		=> $fbLoginUrl,
		);

		$this->template->build('auth/auth_login', $data);
	}


	
	public function invalid() {
		
		$data = array();
		
		// enable caching for the templates
		$this->template->set_cache(3600);
		$this->template->build('auth/auth_invalid', $data);
		
	}
	
	
	public function logout() {
		
		parent::logout($this->fbconnect->getLogoutUrl(array('next' => site_url("auth/invalid"))));
		
	}
	
	
}