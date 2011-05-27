<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Connect extends MY_Controller {

	
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('user_model');
		
	}

	
	
	public function login()
	{
		
log_message('debug', ' === IN Connect parent login()');
		$brand = $this->session->userdata('brand');
		$code_id = $this->session->userdata('code_id');
		$strategy = $this->session->userdata('strategy');
		
log_message('debug', ' === brand_id: '.$brand['id']);
log_message('debug', ' === code_id: '.$code_id);
log_message('debug', ' === strategy id: '.$strategy['id']);

		if (!$brand['id'] || !$code_id)
			redirect('code/invalid');
		
		
		$ret = $this->_doLogin();
		
		$user_info = $this->session->userdata('user');
		
		if ($ret === true) {
			//$brandId = $this->session->userdata('brandId');
			//$productId = $this->session->userdata('productId');
			
			// set user as logged in
			$this->session->set_userdata(array('logged_in' => '1'));
			
			// update user's logged-in time
			$date = date('Y-m-d H:i:s');
			$this->user_model->update_user($user_info['id'], array('lastlogin_time' => $date));
			
			// forward to the coupon page of this brand and product
			$strategy_type = $strategy['type'];
			if (!$strategy_type) {
				log_message('debug', ' === no strategy type defined: '.$strategy['type']);
				redirect('code/invalid');
			}
			redirect($strategy_type.'/index');
			
		} else {
			redirect('code/invalid');
		}
		
		
	}
	
	
	public function logout($logoutUrl = '')
	{
		
		if (!$logoutUrl)
			$logoutUrl = base_url();
		
		// destroy any session parameters
		// @TODO is this really required??!
		$this->session->sess_destroy();
		
		// redirect the user to the logout
		redirect($logoutUrl);
		
	}
	
	
	
	
	public function register($user_info = '')
	{
		
		if (!$user_info)
			return false;
		
		// data ready, try to create the new user
		$user_id = $this->user_model->create_user($user_info);
		if (!$user_id)
			return false;
		
		// if user returns successful then $user is user's id in the database
		// so we push it also to the session:
		$user_info['id'] = $user_id;
			
		// push user info into session
		$this->session->set_userdata('user', $user_info);
		
		return true;
		
	}
	
	
}
