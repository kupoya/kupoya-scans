<?php 

class Auth extends Connect {
	
	
	public function __construct() {

		parent::__construct();
		
		$this->lang->load(array('auth/auth','app'), 'english');
		
	}
	
	
	
	
	
	public function invalid() {
		
		$data = array();
		$this->template->build('auth/auth_invalid', $data);
		
	}
	
	
	public function logout() {
		
		parent::logout();
		
	}
	
	
}