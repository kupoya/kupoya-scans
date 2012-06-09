<?php 

/* The MX_Controller class is autoloaded as required */

class MY_Controller extends CI_Controller {
	
	protected $MODEL_CACHE_SECS = 3600;
	
	public function __construct() {
		
		parent::__construct();

		// get theme from session
		$theme = $this->session->userdata('theme');
		if (!$theme)
			$theme = 'mobile_v1';

		// set theme 
		$this->asset->set_theme($theme);
		$this->template->set_theme($theme);

		// template settings
		$this->template->enable_parser(FALSE); // default true
		$this->template->set_layout('layout_base');
		$this->template->set_partial('css', 'layouts/partials/css', FALSE);
		$this->template->set_partial('header', 'layouts/partials/header', FALSE);


		if ($this->_isLoggedIn() === TRUE)
			$this->template->set_partial('footer', 'layouts/partials/footer_app', FALSE);
		else
			$this->template->set_partial('footer', 'layouts/partials/footer', FALSE);

		$this->template->set_partial('theme', 'layouts/partials/theme', FALSE);
		
		// do some pre-configuration of jquerymobile  
		$this->template->set_partial('pre_jquerymobile', 'layouts/partials/pre_jquerymobile', FALSE);
		
		$this->load->library('UserExp');
		
		// unrequired for now since we moved html_tags() to the template_model
		//$this->load->helper('microsite');
		
		$this->load->model('template_model');
		$this->load->helper('language');
		
		// enable profiler?
		//$this->output->enable_profiler(TRUE);
		
	}
	
	
	/*
	protected function _save_request_info() {
		
		$this->load->library('user_agent');
		$this->load->library('mongo_db');
		
		$req_info = array();
		
		$time = new DateTime();
		
		$req_info['ip_address'] = $this->session->userdata('ip_address');
		$req_info['time'] = $time->format('Y-m-d H:i:s');
		//$req_info['robot'] = $this->agent->robot();
		$req_info['mobile'] = $this->agent->mobile();
		$req_info['platform'] = $this->agent->platform();
		$req_info['browser'] = $this->agent->browser();
		$req_info['version'] = $this->agent->version();
		$req_info['agent_string'] = $this->agent->agent_string();
		
		$this->mongo_db->insert('strategy_requests', $req_info);
		
	}
	*/
	

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


	public function _isLoggedIn() {
		
		// checks if the user is logged in or not
		$status = $this->session->userdata('logged_in');
		if ($status !== '1') {
			return false;
		}

		return true;
	}
	
	
	/**
	 * 
	 * Set session variable to declare this is a first time user loads the page.
	 * first_login variable value is set to the strategy_id the user is actually browsing.
	 * Also used to perform some stuff on user's first login or hitting the app 
	 */
	protected function _firstLogin() {
		
		// get strategy information from session
		$strategy = $this->session->userdata('strategy');
		// if exists then this is definitely a session'ed user, otherwise this is some
		// other page...
		if (!isset($strategy['id']))
			return false;
		
		// first_login session var allows us to determine whether the user is first viewing
		// the page or not so we can implement some logic based on whether this is a first of a user.
		$login = $this->session->userdata('first_login');
		if (($login === false) || ($login != $strategy['id'])) {
			// since this item was not set before this is the first login
			// do first login stuff: set partial for saving request information
			$this->template->set_partial('save_request_info', 'layouts/partials/save_request_info', FALSE);
			
			// also, set the first_login session to the id of the strategy that is now in question.
			// this is required so that we can then compare whether the user viewed one strategy
			// (like /code/index/1/1) and then scanned another strategy - so he needs another "new"
			// session created with a new first_login variable.
			$this->session->set_userdata(array('first_login' => $strategy['id']));
		}			
		
	}
	
	
	
	
	/**
	 * 
	 * return language based on strategy definition, by default returns 'en-us' as default language
	 */
	public function getLanguage() {
		
		$language = $this->userexp->language_detect_quick();
		if ($language) {
			$this->performLanguageOperations($language);	
			return $language;
		}			
		
			
		return $this->getLanguageInitialize();
			
	}
		
	
	/**
	 * 
	 * get language for this strategy, initialize if it required
	 * @param array $strategy the strategy array
	 */
	protected function getLanguageInitialize($strategy = false) {		
		// if no strategy was provided, attempt to get from session
		if (!$strategy)
			$strategy = $this->session->userdata('strategy');
		
		// still no strategy defined? return default english language
		if (!$strategy)
			return 'en-us';
		
		// set default language if nothing else is set
		$language = 'en-us';
//		$strategy = $this->session->userdata('strategy');
		if ($strategy && isset($strategy['language']) && !empty($strategy['language'])) 
			$language = $strategy['language'];	

		// set the strategy language to the detected language
		//$strategy['language'] = $language;
		// prepare the session variable to be set and set it 
		//$session_var = array('strategy' => $strategy);
		// set the session info
		//$this->session->set_userdata($session_var, $language);
		if ($language == 'auto')
			$language = $this->userexp->language_detect();
		
		$this->performLanguageOperations($language);
		
		if ($language != 'auto')
			$this->userexp->language_set($language);
		
		return $language;
	} 
	
	
	protected function performLanguageOperations($language) {
		
		if (!$language)
			return false;
		
		switch($language) {				
			case 'he':
				$this->template->set_partial('css', 'layouts/partials/css-rtl', FALSE);
				break;
		}
		
	}
	
	
}