<?php 

/* The MX_Controller class is autoloaded as required */

class MY_Controller extends CI_Controller {
	
	
	public function __construct() {
		
		parent::__construct();

		// set theme 
		$this->asset->set_theme('mobile_v1');
		$this->template->set_theme('mobile_v1');

		// template settings
		$this->template->enable_parser(FALSE); // default true
		$this->template->set_layout('layout_base');
		$this->template->set_partial('css', 'layouts/partials/css', FALSE);
		$this->template->set_partial('header', 'layouts/partials/header', FALSE);
		$this->template->set_partial('footer', 'layouts/partials/footer', FALSE);
		
		$this->load->library('UserExp');
		
		
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
	
	
	
	
	/**
	 * 
	 * return language based on strategy definition, by default returns 'en-us' as default language
	 */
	public function getLanguage() {
		
		$language = $this->userexp->language_detect_quick();
		if ($language)
			return $language;
			
		return $this->getLanguageInitialize();
			
	}
		
	
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
			
		switch($language) {				
			case 'he':
				$this->template->set_partial('css', 'layouts/partials/css-rtl', FALSE);
				break;
		}
		
		if ($language != 'auto')
			$this->userexp->language_set($language);
		
		return $language;
	} 
	
	
}