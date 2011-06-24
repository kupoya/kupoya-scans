<?php 

class Auth extends Connect {
	
	
	public function __construct() {

		parent::__construct();
		
		$this->lang->load(array('auth/auth','app'), 'hebrew');
		$this->load->library('FBConnect', array('initSession' => false));
		
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